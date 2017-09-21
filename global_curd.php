<?php 

include('config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

require_once(PATH_LIBRARIES.'/classes/mail.php');
$mailClass = new mail();

require_once(PATH_LIBRARIES.'/classes/resize.php');

///*******************************************************
/// Get Base_Fare ////////////////////////////////////////
///*******************************************************
if($_POST['type']=="getTotalAmt")
{
	$res = $db->ExecuteQuery("SELECT Base_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Base_Fare'];	
	
}

///*******************************************************
/// Get AC Amount ////////////////////////////////////////
///*******************************************************
if($_POST['type']=="getACAmt")
{
	$res = $db->ExecuteQuery("SELECT Aircondition_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Aircondition_Fare'];	
	
}

///*******************************************************
/// Get Total Nights /////////////////////////////////////
///*******************************************************
if($_POST['type']=="getTotalNights")
{
	///////////////////////////////////////////
	//Get Total No of Nights //////////////////
	///////////////////////////////////////////
	$date1 = new DateTime($_REQUEST['chckin']);
	$date2 = new DateTime($_REQUEST['chckout']);
	
	//***********************************************************
	// Its calculates the the number of nights between two dates
	//***********************************************************
	$numberOfNights= $date2->diff($date1)->format("%a"); 
	//***********************************************************
	echo $numberOfNights;	
}

///*******************************************************
/// Get list of available room type //////////////////////
///*******************************************************
if($_POST['type']=="getRooms"){
	
	$checkinDate = date('Y-m-d',strtotime($_REQUEST['chckin']));
	
	$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Room_Info, Amenities FROM tbl_rooms_category
	
	WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
	WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkinDate."' AND Check_Out_Date > '".$checkinDate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5 ))");?>
	
    <div class="col-sm-9 table-responsive">
        <table class="table table-hover roomTypeList">
            <thead>
                <tr class="bg-default">
                    <th>Room Photo</th>
                    <th>Room Type</th>
                    <th>Price/Night</th>
                    <th>Price for <?php echo $_REQUEST['totalNights']; ?> Night(s)</th>
                    <th>Max</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Rooms</th>
                </tr>
            </thead>
            <tbody>
            
            <?php foreach($res as $val){ ?>
                <tr>
                    <td><img src="images/room-img.jpg" alt="" /></td>
                    <td class="text-info">
                        <?php echo $val['R_Category_Name']; ?>
                        <input type="hidden" id="room-name-<?php echo $val['R_Category_Id']; ?>" value="<?php echo $val['R_Category_Name']; ?>" />
                        <input type="hidden" id="roomType-<?php echo $val['R_Category_Id']; ?>" value="<?php echo $val['R_Category_Id']; ?>" />
                    </td>
                    <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f',$val['Base_Fare']); ?></td>
                    <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f', ($_REQUEST['totalNights'] * $val['Base_Fare'])); ?></td>
                    <td>
                        <span class="glyphicon glyphicon-user"></span> <?php echo $val['R_Capacity']; ?>
                        <input type="hidden" id="capacity-<?php echo $val['R_Category_Id']; ?>" value="<?php echo $val['R_Capacity']; ?>" />
                    </td>
                    <td class="ddbtn">
                        <select id="adult-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control adultdd">          
                          <?php 
                          $i=1;
                          while($i<=$val['R_Capacity']){ ?>
                          <option value="<?php echo $i ?>"><?php echo $i ?></option>
                          <?php $i++; } ?>
                          
                        </select>
                    </td>
                    <td class="ddbtn">
                        <select id="child-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control childdd">          
                          <?php 
                          $i=0;
                          while($i<$val['R_Capacity']){ ?>
                          <option value="<?php echo $i ?>"><?php echo $i ?></option>
                          <?php $i++; } ?>
                          
                        </select>
                    </td>
                    <td class="rooms">
                    <?php $roomCount = $db->ExecuteQuery("SELECT COUNT(Room_Id) AS RID FROM tbl_room_master 
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkinDate."' AND Check_Out_Date > '".$checkinDate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5)"); 

?>
                        <select id="room-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control totalRooms">          
                          <option value="0" selected="selected">0</option>          
                          <?php 
                          $i=1;
                          while($i<=$roomCount[1]['RID']){ ?>
                          <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                          <?php $i++;} ?>
                          
                        </select>
                        
                    </td>
                    <td class="extraItems">
                        <input type="hidden" class="subtotal" id="subTotal-<?php echo $val['R_Category_Id']; ?>" value="0.00" />
                        
                    </td>
                </tr>
                <tr class="roomInfo">
                    <td colspan="8">
                        <?php echo $val['Room_Info'] ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
            
        </table>
    </div>
    <div class="col-sm-3 text-center">
        <div class="bg-info calculationBox">
            <h5><span id="noOfRooms">0</span> Accommodation(s) for</h5>
            <div class="Totalprice"><i class="fa fa-inr" aria-hidden="true"></i> <span id="displayTotalAmt">0.00</span></div>
            <div>
                <input type="hidden" id="TotalAmt" value="0.00" />
                <button type="button" id="bookRoomBtn" class="btn btn-lg btn-danger" disabled="disabled">BOOK NOW</button>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
	
<?php }

///*******************************************************
/// Get the selected rooms detail to display items ///////
///*******************************************************
if($_POST['type']=="getCheckoutDisplay"){ 
	
	$roomsTypeArray = explode(',',$_POST['roomsTypeArray']);
	$adultArray = explode(',',$_POST['adultArray']);
	$childArray = explode(',',$_POST['childArray']);
	$TotalroomsArray = explode(',',$_POST['TotalroomsArray']);
	
	$gst = ($_POST['TotalAmt']*9)/100;
	$grandtotal = $_POST['TotalAmt'] + ($gst*2);
	
	$i=0;
	$roomCount = count($roomsTypeArray);
	
	while(($roomCount-1) >= $i){
		echo '<div class="roomBg"><p><strong>'.$roomsTypeArray[$i].'</strong> <span class="label label-info">'.$TotalroomsArray[$i].' Room (s)</span></p><p>Adult(s): '.$adultArray[$i].' &nbsp;&nbsp;&nbsp;Children(s): '.$childArray[$i].'</p></div>';
		$i++;
	}
	
	echo '<div class="dates">
		<div class="col-sm-6"><strong>Check-In Date:</strong><br>'.$_POST['checkindate'].'</div>
		<div class="col-sm-6"><strong>Check-Out Date:</strong><br>'.$_POST['checkoutdate'].'</div>
		<div class="clearfix"></div>
		<div class="nightsBlk"><strong>Total Nights:</strong> '.$_POST['totalNights'].'</div>
	</div>
	<div>
		<div class="amtRow">
			<div class="col-sm-6">Total Room Amt.:</div>
			<div class="col-sm-6 text-right"><i class="fa fa-inr" aria-hidden="true"></i> '.sprintf('%0.2f',$_POST['TotalAmt']).'</div>
			<div class="clearfix"></div>
		</div>
		<div class="amtRow">
			<div class="col-sm-6">Extra Guest:</div>
			<div class="col-sm-6 text-right"><i class="fa fa-inr" aria-hidden="true"></i> 0.00</div>
			<div class="clearfix"></div>
		</div>
		<div class="amtRow">
			<div class="col-sm-6">SGST(9%):</div>
			<div class="col-sm-6 text-right"><i class="fa fa-inr" aria-hidden="true"></i> '.sprintf('%0.2f',$gst).'</div>
			<div class="clearfix"></div>
		</div>
		<div class="amtRow">
			<div class="col-sm-6">CGST(9%):</div>
			<div class="col-sm-6 text-right"><i class="fa fa-inr" aria-hidden="true"></i> '.sprintf('%0.2f',$gst).'</div>
			<div class="clearfix"></div>
		</div>
		<div class="grandTotalBlk">
			<div class="col-sm-6"><strong>GRAND TOTAL:</strong></div>
			<div class="col-sm-6 text-right grandTotal"><i class="fa fa-inr" aria-hidden="true"></i> '.sprintf('%0.2f',$grandtotal).'</div>
			<div class="clearfix"></div>
		</div>
		<div class="text-center compltBtn">
			<button id="completeReservBtn" type="button" class="btn btn-danger btn-lg">COMPLETE RESERVATION</button>
		</div>
	</div>
	';

}

///*******************************************************
/// Get the selected rooms detail to display items ///////
///*******************************************************
if($_POST['type']=="insertReservationInfo"){ 

	$path = ROOT."/images/upload-proof/";
	$paththumb = ROOT."/images/upload-proof/thumb/";
	
	$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0',$con);
	mysql_query('START TRANSACTION',$con);
	
	try{
	
		$roomsTypeArray = explode(',',$_POST['roomsTypeArray']);
		$adultArray = explode(',',$_POST['adultArray']);
		$childArray = explode(',',$_POST['childArray']);
		$TotalroomsArray = explode(',',$_POST['TotalroomsArray']);
		$SubtotalArray = explode(',',$_POST['SubtotalArray']);
		
		
		$name = $_FILES['file']['name'];
		$image=explode('.',$name);
		$actual_image_name = time().'.'.$image[1]; // rename the file name
		$tmp = $_FILES['file']['tmp_name'];
		
		
		if(move_uploaded_file($tmp, $path.$actual_image_name))
		{
			
			/////////////////////////////////////////////////////////////
			// move the image in the /images/upload-proof/ thumb folder
			/////////////////////////////////////////////////////////////
			$resizeObj1 = new resize($path.$actual_image_name);
			$resizeObj1 -> resizeImage(200, 200, 'auto');
			$resizeObj1 -> saveImage($paththumb.$actual_image_name, 100);
			
			//************************************************************
			$checkindate=date('y-m-d',strtotime($_POST['checkindate']));
			$checkoutdate=date('y-m-d',strtotime($_POST['checkoutdate']));
			//************************************************************			
			$refNo = 'REF'.time(); //Generate Unique Reservation ref no.
			//************************************************************
			
			///////////////////////////////////////////////////////////
			// SQL Query to insert the data into tbl_reservation table
			///////////////////////////////////////////////////////////
			$tblfield=array('Reservation_Ref_No','Check_In_Date','Check_Out_Date','Arrival_Time','Client_Name','Email','Phone','ID_Proof_Image','Total_Rooms_Amt','Total_Guests_Amt','Subtotal_Amt','SGST_Amt','CGST_Amt','Grand_Total_Amt','Reservation_Status');
			
			$tblvalues=array($refNo,$checkindate,$checkoutdate,$_POST['arrTime'],$_POST['clientname'],$_POST['email'],$_POST['phone'],$actual_image_name,$_POST['TotalAmt'],0,$_POST['TotalAmt'],$_POST['gst'],$_POST['gst'],$_POST['grandTotal'],5);
			
			$res=$db->valInsert("tbl_reservation",$tblfield,$tblvalues);
			
			if(!$res)
			{
				throw new Exception('0');
			}
			//*************************
			//Get the Inserted Last Id
			//*************************
	 		$last_Id=mysql_insert_id();
			//*************************
			////////////////////////////////////////////////
			// SQL Query to get the remain unreserved rooms 
			////////////////////////////////////////////////
			$i=0;
			$roomCount = count($roomsTypeArray);
			
			while(($roomCount-1) >= $i){
				
				//////////////////////////////////////////
				// SELECT Query to get the remaining rooms
				// which are not reserved
				//////////////////////////////////////////				
				$getrooms = $db->ExecuteQuery("SELECT Room_Id FROM tbl_room_master 
WHERE R_Category_Id=".$roomsTypeArray[$i]." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5) LIMIT ".$TotalroomsArray[$i]);
				
				//Get the singal room fare their room category wise
				//**************************************************
				$basefare = $SubtotalArray[$i]/$TotalroomsArray[$i];
				//**************************************************

				foreach($getrooms as $getroomsVal){					
					/////////////////////////////////////////////////////////////
					// SQL Query to insert the data into tbl_reserved_rooms table
					/////////////////////////////////////////////////////////////
					$tblfield=array('Reservation_Id','Room_Id','Check_In_Date','Check_Out_Date','Adult','Children','Base_Fare','Extra_Guest_Amt','Reservation_Status');
					
					$tblvalues=array($last_Id,$getroomsVal['Room_Id'],$checkindate,$checkoutdate,$adultArray[$i],$childArray[$i],$basefare,0,5);
					
					$res=$db->valInsert("tbl_reserved_rooms",$tblfield,$tblvalues);
					
					if(!$res)
					{
						throw new Exception('0');
					}
					
				}//eof foreach loop
				$i++;								
			}//eof while loop
			
			//**************************************************
			// Call a class to send a mail to the user regarding 
			// pending reservation.
			//**************************************************
			$mailClass->reservationPendingMail($last_Id);
			//**************************************************
			
		}
		else{
			throw new Exception('0');
		}
		
		mysql_query("COMMIT",$con);
		
		echo base64_encode($last_Id);
		
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
	}

}//eof if condition

///*******************************************************
/// Check the Reservation Ref No is valid or Not /////////
///*******************************************************
if($_POST['type']=="RnoExist"){
	
	//////////////////////////////////////////////
	// SELECT Query to Get the Reservation Ref No
	//////////////////////////////////////////////
	$res = $db->ExecuteQuery("SELECT Reservation_Ref_No FROM tbl_reservation WHERE Reservation_Ref_No='".$_POST['rno']."'");
	
	if(!$res){
		echo 1;
	}
	else{
		echo 0;
	}
}

///*******************************************************
/// check the Reservation Ref no is confirmed or pending 
///*******************************************************
if($_POST['type']=="ConfirmedRno"){
	
	//////////////////////////////////////////////
	// SELECT Query to Get the Reservation status
	//////////////////////////////////////////////
	$res = $db->ExecuteQuery("SELECT Reservation_Status FROM tbl_reservation WHERE Reservation_Ref_No='".$_POST['rno']."' AND (Reservation_Status=1 OR Reservation_Status=2 OR Reservation_Status=3 OR Reservation_Status=4)");
	
	if(!$res){
		echo 0;
	}
	else{
		echo 1;
	}
}

///*******************************************************
/// Find the Reservation Details /////////////////////////
///*******************************************************
if($_POST['type']=="getReservationInfo"){
	
	//*********************************
	// Get reservation details from DB
	//*********************************
	$bookingInfo = 	$db->ExecuteQuery("SELECT Reservation_Id, Reservation_Ref_No, Check_In_Date, Check_Out_Date, Arrival_Time, Client_Name, Email, Phone, Total_Rooms_Amt, Total_Guests_Amt, Subtotal_Amt, SGST_Amt, CGST_Amt, Grand_Total_Amt, CASE WHEN Reservation_Status=5 THEN 'Pending' END Reservation_Status
		FROM tbl_reservation 
		WHERE Reservation_Ref_No='".$_POST['rno']."'");
	
	//*****************************************************************
	$reservationId = base64_encode($bookingInfo[1]['Reservation_Id']);
	//*****************************************************************
	$checkindate=date('d-m-Y',strtotime($bookingInfo[1]['Check_In_Date']));
	$checkoutdate=date('d-m-Y',strtotime($bookingInfo[1]['Check_Out_Date']));
	//************************************************************
	//Get Total No of Nights /////////////////////////////////////
	//************************************************************
	$date1 = new DateTime($bookingInfo[1]['Check_In_Date']);
	$date2 = new DateTime($bookingInfo[1]['Check_Out_Date']);
	
	//***********************************************************
	// Its calculates the the number of nights between two dates
	//***********************************************************
	$numberOfNights= $date2->diff($date1)->format("%a"); 
	
	/////////////////////////////////////////////////////////////////////////////
	// this calculates the diff between two dates, which is the number of nights
	/////////////////////////////////////////////////////////////////////////////
	$bookedRooms = $db->ExecuteQuery("SELECT COUNT( rc.R_Category_Id ) AS Room_Count, R_Category_Name, Adult, Children 
	FROM tbl_reserved_rooms rr
	LEFT JOIN tbl_room_master rm ON rm.Room_Id = rr.Room_Id
	LEFT JOIN tbl_rooms_category rc ON rm.R_Category_Id = rc.R_Category_Id
	
	WHERE Reservation_Id=".$bookingInfo[1]['Reservation_Id']." GROUP BY rc.R_Category_Id
	");
	
	//*********************************************************
	// Message ////////////////////////////////////////////////
	//*********************************************************
	$message = '
	<table width="60%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td style="padding:20px; background:#F2F2F2;">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				
				<tr>
					<td style="padding:15px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td style="background:#F2F2F2; padding:10px;">
									YOUR RESERVATION DETAILS
								</td>
							</tr>
							<tr>
								<td style="padding:20px 10px; border:solid 1px #F2F2F2;">
									<table width="100%" border="0" cellspacing="0" cellpadding="5">
										<tr>
											<td><strong>Reservation Ref. No.:</strong> '.$bookingInfo[1]['Reservation_Ref_No'].'</td>
										</tr>
										<tr>
											<td><strong>Reservation Status:</strong> '.$bookingInfo[1]['Reservation_Status'].'</td>
										</tr>
										
										
										<tr>
											<td colspan="2"><strong>Name:</strong> '.$bookingInfo[1]['Client_Name'].'</td>
										</tr>
										<tr>
											<td colspan="2"><strong>Email:</strong> '.$bookingInfo[1]['Email'].'</td>
										</tr>
										<tr>
											<td colspan="2"><strong>Phone:</strong> '.$bookingInfo[1]['Phone'].'</td>
										</tr>
										<tr>
											<td colspan="2">
												<table width="100%" border="1" cellspacing="0" cellpadding="5">
													';
													foreach($bookedRooms as $val){
													
													$message .='<tr>
														<td>'.$val['R_Category_Name'].' - '.$val['Room_Count'].' Room(s)</td>
														<td>Adult(s):'.$val['Adult'].'&nbsp;&nbsp;&nbsp;&nbsp; Children(s):'.$val['Children'].'</td>
													</tr>';
													}
												$message .='</table>
											</td>
										</tr>
										
										<tr>
											<td colspan="2"><strong>Check-In Date:</strong> '.$checkindate.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Check-Out Date:</strong> '.$checkoutdate.'</td>
										</tr>
										<tr>
											<td colspan="2"><strong>Estimated Arriaval Time:</strong> '.$bookingInfo[1]['Arrival_Time'].' &nbsp;&nbsp;&nbsp;&nbsp; <strong>Total Nights:</strong> '.$numberOfNights.'</td>
										</tr>
										<tr>
											<td style="padding-top:30px;">Total Room Amt.:</td>
											<td style="padding-top:30px;">'.$bookingInfo[1]['Total_Rooms_Amt'].'</td>
										</tr>
										<tr>
											<td>Extra Guest Amt:</td>
											<td>0.00</td>
										</tr>
										<tr>
											<td>SGST:</td>
											<td>'.$bookingInfo[1]['SGST_Amt'].'</td>
										</tr>
										<tr>
											<td>CGST:</td>
											<td>'.$bookingInfo[1]['CGST_Amt'].'</td>
										</tr>
										<tr>
											<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>GRAND TOTAL:</strong></td>
											<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>'.$bookingInfo[1]['Grand_Total_Amt'].'</strong></td>
										</tr>
										<tr>
											<td colspan="2" style="text-align:center; padding:15px;">
												<a href="payment/PayUMoney_form.php?id='.$reservationId.'"><img src="images/payBtn.png" alt="" /></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>';

echo $message;
	
}


///*******************************************************
/// Get the Reservation Details //////////////////////////
///*******************************************************
if($_POST['type']=="getReservationDetails"){
	
	//*********************************
	// Get reservation details from DB
	//*********************************
	$bookingInfo = 	$db->ExecuteQuery("SELECT Reservation_Id, Reservation_Ref_No, Check_In_Date, Check_Out_Date, Arrival_Time, Client_Name, Email, Phone, Total_Rooms_Amt, Total_Guests_Amt, Subtotal_Amt, SGST_Amt, CGST_Amt, Grand_Total_Amt, CASE WHEN Reservation_Status=5 THEN 'Pending' END Reservation_Status
		FROM tbl_reservation 
		WHERE Reservation_Id='".$_POST['rid']."'");
	
	//*****************************************************************
	$reservationId = base64_encode($bookingInfo[1]['Reservation_Id']);
	//*****************************************************************
	$checkindate=date('d-m-Y',strtotime($bookingInfo[1]['Check_In_Date']));
	$checkoutdate=date('d-m-Y',strtotime($bookingInfo[1]['Check_Out_Date']));
	//************************************************************
	//Get Total No of Nights /////////////////////////////////////
	//************************************************************
	$date1 = new DateTime($bookingInfo[1]['Check_In_Date']);
	$date2 = new DateTime($bookingInfo[1]['Check_Out_Date']);
	
	//***********************************************************
	// Its calculates the the number of nights between two dates
	//***********************************************************
	$numberOfNights= $date2->diff($date1)->format("%a"); 
	
	/////////////////////////////////////////////////////////////////////////////
	// this calculates the diff between two dates, which is the number of nights
	/////////////////////////////////////////////////////////////////////////////
	$bookedRooms = $db->ExecuteQuery("SELECT COUNT( rc.R_Category_Id ) AS Room_Count, R_Category_Name, Adult, Children 
	FROM tbl_reserved_rooms rr
	LEFT JOIN tbl_room_master rm ON rm.Room_Id = rr.Room_Id
	LEFT JOIN tbl_rooms_category rc ON rm.R_Category_Id = rc.R_Category_Id
	
	WHERE Reservation_Id=".$bookingInfo[1]['Reservation_Id']." GROUP BY rc.R_Category_Id
	");
	
	//*********************************************************
	// Message ////////////////////////////////////////////////
	//*********************************************************
	$message = '
	<div>
		<div class="modal-top-info">
			<div class="col-sm-5">
				<strong>Customer Name:</strong> '.$bookingInfo[1]['Client_Name'].'<br>
				<strong>Email:</strong> '.$bookingInfo[1]['Email'].'<br>
				<strong>Phone:</strong> '.$bookingInfo[1]['Phone'].'
			</div>
			<div class="col-sm-7">
				<strong>Reservation Ref. No.:</strong> '.$bookingInfo[1]['Reservation_Ref_No'].'<br>
				<strong>Reservation Status:</strong> <span class="label label-danger">'.$bookingInfo[1]['Reservation_Status'].'</span>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<div class="col-sm-12 modal-room-info">
			<div>
				<strong>Check-In:</strong> '.$checkindate.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Check-Out:</strong> '.$checkoutdate.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total Nights:</strong> '.$numberOfNights.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Arriaval Time:</strong>'.$bookingInfo[1]['Arrival_Time'].'
			</div>
			';
			foreach($bookedRooms as $val){
			
			$message .='<div class="roomBg">
				<div class="col-sm-6">'.$val['R_Category_Name'].' - '.$val['Room_Count'].' Room(s)</div>
				<div class="col-sm-6">Adult(s):'.$val['Adult'].'&nbsp;&nbsp;&nbsp;&nbsp; Children(s):'.$val['Children'].'</div>
				<div class="clearfix"></div>
				</div>';
			}
		$message .='
		</div>
		<div class="clearfix"></div>
		<div class="calculationBlock">
			<table width="100%" border="0" cellspacing="0" cellpadding="5">
				<tr>
					<td>Total Room Amt.:</td>
					<td>'.$bookingInfo[1]['Total_Rooms_Amt'].'</td>
				</tr>
				<tr>
					<td>Extra Guest Amt:</td>
					<td>0.00</td>
				</tr>
				<tr>
					<td>SGST(9%):</td>
					<td>'.$bookingInfo[1]['SGST_Amt'].'</td>
				</tr>
				<tr>
					<td>CGST(9%):</td>
					<td>'.$bookingInfo[1]['CGST_Amt'].'</td>
				</tr>
				<tr>
					<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>GRAND TOTAL:</strong></td>
					<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>'.$bookingInfo[1]['Grand_Total_Amt'].'</strong></td>
				</tr>
				
			</table>
		</div>

	</div>';

echo $message;
	
}

?>