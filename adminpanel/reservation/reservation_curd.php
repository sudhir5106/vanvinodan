<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

require_once(PATH_LIBRARIES.'/classes/resize.php');

///*******************************************************
/// Check the Paid amount is not greater than grand total 
///*******************************************************
if($_POST['type']=='paidAmtIsNotGreater'){
	
	$GT = $_REQUEST['GT'];
	$PA = $_REQUEST['PA'];

	if($GT < $PA){
		echo 0;
	}
	else {
		echo 1;
	}
}

///*******************************************************
/// Get Rooms ///////////////////////////////////////
///*******************************************************
if($_POST['type']=="getRoomsFrm")
{
	$room = $db->ExecuteQuery("SELECT Room_Name FROM tbl_room_master WHERE Room_Id=".$_REQUEST['roomId']);
	
	$specification = $db->ExecuteQuery("SELECT R_Capacity, Base_Fare, Extra_Guest_Fare FROM tbl_rooms_category WHERE R_Category_Id=(SELECT R_Category_Id FROM tbl_room_master WHERE Room_Id=".$_REQUEST['roomId'].")");

?>

	<tr id="row-<?php echo $_REQUEST['roomId']; ?>">
		<td class="bookingCol crossBtnCol"><a id="deleteRow-<?php echo $_REQUEST['roomId']; ?>" class="drow text-danger"><i class="fa fa-times-circle" aria-hidden="true"></i></a></td>
		<td class="bookingCol">
			<?php echo $room[1]['Room_Name']; ?>
			<input id="roomId-<?php echo $_REQUEST['roomId']; ?>" type="hidden" class="form-control Roomid" value="<?php echo $_REQUEST['roomId']; ?>">
		</td>
		<td>
			<select id="adult-<?php echo $_REQUEST['roomId']; ?>" class="form-control adultdd" style="width:55px;">
              <?php 
			  $i=1;
			  while($i<=$specification[1]['R_Capacity']){ ?>
              	<option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php $i++; } ?>
              
            </select>
		</td>
		<td width="50">
			<select id="child-<?php echo $_REQUEST['roomId']; ?>" class="form-control childdd" style="width:55px;">          
              <?php 
			  $i=0;
			  while($i<$specification[1]['R_Capacity']){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php $i++; } ?>
              
            </select>
		</td>
		<td><input id="extra-<?php echo $_REQUEST['roomId']; ?>" type="text" class="form-control extraGuest" value=""></td>
		<td><input id="baseFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo $specification[1]['Base_Fare']; ?>" class="form-control" disabled ></td>
		<td><input id="total-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo ($_REQUEST['nightsCount'] * $specification[1]['Base_Fare']); ?>" class="form-control" disabled ></td>
		<td><input id="extraFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="0" class="form-control" readonly="readonly" ></td>
        <td><input id="totalFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo ($_REQUEST['nightsCount'] * $specification[1]['Base_Fare']); ?>" class="form-control total" disabled ></td>
		
		<input id="extraGuestFare-<?php echo $_REQUEST['roomId']; ?>" type="hidden" class="form-control" value="<?php echo $specification[1]['Extra_Guest_Fare']; ?>">
		<input id="capacity-<?php echo $_REQUEST['roomId']; ?>" type="hidden" class="form-control" value="<?php echo $specification[1]['R_Capacity']; ?>">
	</tr>

<?php
}//eof if condition

///*******************************************************
/// Insert The New Reservation Info in the database //////
///*******************************************************
if($_POST['type']=="insertReservationInfo"){ 

	$path = ROOT."/images/upload-proof/";
	$paththumb = ROOT."/images/upload-proof/thumb/";
	
	$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0',$con);
	mysql_query('START TRANSACTION',$con);
	
	try{
	
		$roomsIdArray = explode(',',$_POST['roomsIdArray']);
		$adultArray = explode(',',$_POST['adultArray']);
		$childArray = explode(',',$_POST['childArray']);
		$basefareArray = explode(',',$_POST['basefareArray']);
		$extraGuestArray = explode(',',$_POST['extraGuestArray']);
		$extraFareArray = explode(',',$_POST['extraFareArray']);
		$totalRoomFareArray = explode(',',$_POST['totalRoomFareArray']);
		
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
			$DBTotalRoomsAmt = $_POST['subtotal'] - $_POST['TotalGuestAmt'];
			//************************************************************
			$DBsubtotalAmt = $DBTotalRoomsAmt + $_POST['TotalGuestAmt'];
			

			
			///////////////////////////////////////////////////////////
			// SQL Query to insert the data into tbl_reservation table
			///////////////////////////////////////////////////////////
			$tblfield=array('Reservation_Ref_No','Check_In_Date','Check_Out_Date','Client_Name','Email','Phone','ID_Proof_Image','Total_Rooms_Amt','Total_Guests_Amt','Subtotal_Amt','SGST_Amt','CGST_Amt','Grand_Total_Amt','Reservation_Status');
			
			$tblvalues=array($refNo,$checkindate,$checkoutdate,$_POST['clientname'],$_POST['email'],$_POST['phone'],$actual_image_name,$DBTotalRoomsAmt,$_POST['TotalGuestAmt'],$DBsubtotalAmt,$_POST['sgst'],$_POST['cgst'],$_POST['grandTotal'],1);
			
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
			$transaction_no = base64_encode($last_Id);
			////////////////////////////////////////////////
			// SQL Query to get the remain unreserved rooms 
			////////////////////////////////////////////////
			$i=0;
			$roomCount = count($roomsIdArray);
			
			while(($roomCount-1) >= $i){
				
				/////////////////////////////////////////////////////////////
				// SQL Query to insert the data into tbl_reserved_rooms table
				/////////////////////////////////////////////////////////////
				$tblfield=array('Reservation_Id','Room_Id','Check_In_Date','Check_Out_Date','Adult','Children','Total_Extra_Guests','Base_Fare','Extra_Guest_Amt','Reservation_Status');
				
				$tblvalues=array($last_Id,$roomsIdArray[$i],$checkindate,$checkoutdate,$adultArray[$i],$childArray[$i],$extraGuestArray[$i],$basefareArray[$i],$extraFareArray[$i],1);
				
				$res=$db->valInsert("tbl_reserved_rooms",$tblfield,$tblvalues);
				
				if(!$res)
				{
					throw new Exception('0');
				}

				$i++;								
			}//eof while loop


			////////////////////////////////////////////////////
			///// insert transaction detail in tbl_transactions
			////////////////////////////////////////////////////			
			$date = date('Y-m-d H:i:s');
			//************************************************
			$tblname = "tbl_transactions";
			$tblfield=array('Transaction_Date', 'Transaction_No', 'Reservation_Id', 'Paid_Amt', 'Payment_Mode', 'Pay_Status', 'Payment_Id');
			$tblvalues=array($date, $transaction_no, $last_Id, $_POST['PaidAmt'], 'Desk Payment', 'success', '');
			$res=$db->valInsert($tblname, $tblfield, $tblvalues);
			
			//**************************************************
			// Call a class to send a mail to the user regarding 
			// confirmation of reservation.
			//**************************************************
			//$mailClass->reservationConfirmedMail($Id);
			//**************************************************
			
		}
		else{
			throw new Exception('0');
		}
		
		mysql_query("COMMIT",$con);
		
		echo $transaction_no;
		
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
	}

}//eof if condition


///*******************************************************
/// insert transaction detail in tbl_transactions ////////
///*******************************************************
if($_POST['type']=="doPayment"){ 

	//************************************************
	$date = date('Y-m-d H:i:s');
	//************************************************
	$transaction_no = base64_encode($_POST['rid']);
	//************************************************
	// Query for Insert in tbl_transactions table
	//************************************************
	$tblname = "tbl_transactions";
	$tblfield=array('Transaction_Date', 'Transaction_No', 'Reservation_Id', 'Paid_Amt', 'Payment_Mode', 'Pay_Status', 'Payment_Id');
	$tblvalues=array($date, $transaction_no, $_POST['rid'], $_POST['payment'], 'Desk Payment', 'success', '');
	$res=$db->valInsert($tblname, $tblfield, $tblvalues);

}


?>