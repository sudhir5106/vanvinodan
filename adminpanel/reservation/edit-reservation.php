<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
//************************************************************
$rid = base64_decode($_GET['rid']);
//************************************************************
// Get reservation details from DB ///////////////////////////
//************************************************************
$bookingInfo = 	$db->ExecuteQuery("SELECT Reservation_Id, Reservation_Ref_No, Check_In_Date, Check_Out_Date, Arrival_Time, Client_Name, Email, Phone, Total_Rooms_Amt, Total_Guests_Amt, Subtotal_Amt, SGST_Amt, CGST_Amt, Grand_Total_Amt, CASE WHEN Reservation_Status=5 THEN 'Pending' WHEN Reservation_Status=1 THEN 'Confirmed' END Reservation_Status
	FROM tbl_reservation 
	WHERE Reservation_Id='".$rid."'");

require_once(PATH_ADMIN_INCLUDE.'/header.php');


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
// Get the number of rooms of each category which is booked by customer /////
/////////////////////////////////////////////////////////////////////////////
$bookedRooms = $db->ExecuteQuery("SELECT COUNT( rc.R_Category_Id ) AS Room_Count, R_Category_Name, Adult, Children, rr.Base_Fare 
FROM tbl_reserved_rooms rr
LEFT JOIN tbl_room_master rm ON rm.Room_Id = rr.Room_Id
LEFT JOIN tbl_rooms_category rc ON rm.R_Category_Id = rc.R_Category_Id

WHERE Reservation_Id=".$bookingInfo[1]['Reservation_Id']." GROUP BY rc.R_Category_Id
");

?>
<script type="text/javascript" src="reservation.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>

  <div class="page-title">
    <div class="title_left">
      <h3>Edit Reservation</h3>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title"> 
        	<form class="form-horizontal" role="form" id="extendDateFrm" method="post">
             <div class="col-sm-2 col-xs-6 padding-left-zero">
                  <label>Check-In</label>
                  <div class="input-group date" data-provide="datepicker">
                      <input type="text" id="chckin" name="chckin" class="form-control input-sm datetimepicker2 hasDatepicker" placeholder="check-in" value="<?php echo $checkindate; ?>" readonly="readonly" >
                      <div class="input-group-addon">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                      </div>
                  </div>
              </div>
              
              <div class="col-sm-2 col-xs-6">
              	  <label>Check-Out</label>
                  <div class="input-group date" data-provide="datepicker">
                      <input type="text" id="chckout" name="chckout" class="form-control input-sm datetimepicker3" placeholder="check-out" value="<?php echo $checkoutdate; ?>">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                      </div>
                  </div>
              </div>
            
              <div class="col-sm-2 col-xs-12 text-left text-center-xs"><h2><strong>Total Nights:</strong> <label class="badge"><?php echo $numberOfNights; ?></label></h2></div>
        
          	  <div class="text-right"><button onClick="window.history.back();" type="button" class="btn btn-success btn-sm">Back</button></div>

          	</form>
              
            <div class="clearfix"></div>
    	  
        </div>

        <div class="x_content">

	        <div>
		        <h4 class="col-sm-6 row"><strong>Reservation Ref. No.:</strong> <?php echo $bookingInfo[1]['Reservation_Ref_No']; ?></h4>
		        <div class="col-sm-6 row text-right">
		        	<strong>Reservation Status:</strong> 
		        	<select>
		        		<option><?php echo $bookingInfo[1]['Reservation_Status']; ?></option>
		        	</select>
		        </div>
		        <div class="clearfix"></div>
	        </div>

		<?php
			$message = '

			<div style="background:#F2F2F2; padding:30px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
				<div><strong>Name:</strong> '.$bookingInfo[1]['Client_Name'].'</div>
				<div><strong>Email:</strong> '.$bookingInfo[1]['Email'].'</div>
				<div><strong>Phone:</strong> '.$bookingInfo[1]['Phone'].'</div>
				<div><strong>Estimated Arrival Time:</strong> '.$bookingInfo[1]['Arrival_Time'].'</div>

				<hr>
				<div class="table-responsive">
					<table class="table table-bordered table-striped" width="100%" cellspacing="0" cellpadding="5">
						<thead>
						<tr class="bg-primary">
							<th>Room Type</th>
							<th>Adults & Childrens</th>
							<th>Base Fare x Total Rooms x Total Nights</th>
							<th>Total Room Fare</th>
						</tr>
						</thead>
						<tbody>
						';
						foreach($bookedRooms as $val){
						
						$message .='<tr>
							<td>'.$val['R_Category_Name'].' - '.$val['Room_Count'].' Room(s)</td>
							<td>Adult(s):'.$val['Adult'].'&nbsp;&nbsp;&nbsp;&nbsp; Children(s):'.$val['Children'].'</td>
							<td>'.$val['Base_Fare'].' x '.$val['Room_Count'].' x '.$numberOfNights.'</td>
							<td>'.$val['Base_Fare']*$val['Room_Count']*$numberOfNights.'</td>
						</tr>';
						}
					$message .='
						</tbody>
						<tfoot>
							<tr>
								<td colspan="3" class="text-right">Total Room Amt.: </td>
								<td width="15%">'.$bookingInfo[1]['Total_Rooms_Amt'].'</td>
							</tr>
							<tr>
								<td colspan="3" class="text-right">Extra Guest Amt: </td>
								<td>'.$bookingInfo[1]['Total_Guests_Amt'].'</td>
							</tr>
							<tr>
								<td colspan="3" class="text-right">SGST: </td>
								<td>'.$bookingInfo[1]['SGST_Amt'].'</td>
							</tr>
							<tr>
								<td colspan="3" class="text-right">CGST: </td>
								<td>'.$bookingInfo[1]['CGST_Amt'].'</td>
							</tr>
							<tr>
								<td colspan="3" class="text-right"><strong>GRAND TOTAL: </strong></td>
								<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>'.$bookingInfo[1]['Grand_Total_Amt'].'</strong></td>
							</tr>						
						<tfoot>
					
					</table>
					<div class="text-center">
						<button type="button" class="btn btn-success btn-lg">Update</button>
					</div>
				</div>
			</div>'; 
			
			echo $message ;
		?>

        </div>
      </div>
    </div>
  </div>

</div>
<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>