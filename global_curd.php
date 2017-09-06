<?php 

include('config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/resize.php');
$db = new DBConn();

///*******************************************************
/// Get Base_Fare
///*******************************************************
if($_POST['type']=="getTotalAmt")
{
	$res = $db->ExecuteQuery("SELECT Base_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Base_Fare'];	
	
}

///*******************************************************
/// Get AC Amount
///*******************************************************
if($_POST['type']=="getACAmt")
{
	$res = $db->ExecuteQuery("SELECT Aircondition_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Aircondition_Fare'];	
	
}

///*******************************************************
/// Get Total Nights
///*******************************************************
if($_POST['type']=="getTotalNights")
{
	/////////////////////////////
	//Get Total No of Nights
	/////////////////////////////
	$date1 = new DateTime($_REQUEST['chckin']);
	$date2 = new DateTime($_REQUEST['chckout']);
	
	///////////////////////////////////////////////////////////////////////////////////////
	// this calculates the diff between two dates, which is the number of nights
	///////////////////////////////////////////////////////////////////////////////////////
	$numberOfNights= $date2->diff($date1)->format("%a"); 
	/////////////////////////////////////////
	echo $numberOfNights;
	
}

///*******************************************************
/// Get list of available room type
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
/// Get the selected rooms detail to display items
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
?>
	
    
    
<?php }

///*******************************************************
/// Get the selected rooms detail to display items
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
				throw new Exception('a');
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
						throw new Exception('b');
					}
					
				}//eof foreach loop
				$i++;								
			}//eof while loop
			
			
		}
		else{
			throw new Exception('c');	
		}
		
	
		mysql_query("COMMIT",$con);
		echo 1;
		
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
	}

}//eof if condition




?>