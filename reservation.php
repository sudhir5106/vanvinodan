<?php 
include('header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

if(!empty($_POST['checkindate']) && !empty($_POST['checkoutdate'])){
	
	$checkindate = date('Y-m-d',strtotime($_POST['checkindate']));
	$checkoutdate = date('Y-m-d',strtotime($_POST['checkoutdate']));
	
	$checkin = date('d-m-Y',strtotime($_POST['checkindate']));
	$checkout = date('d-m-Y',strtotime($_POST['checkoutdate']));
}

else{
	$checkindate = date("Y-m-d");
	$checkoutdate = date("Y-m-d",strtotime($checkindate.'+1 day'));//It will adding 1 day
	
	$checkin = date("d-m-Y");
	$checkout = date("d-m-Y",strtotime($checkin.'+1 day'));//It will add 1 day
}

/////////////////////////////
//Get Total No of Nights
/////////////////////////////
$date1 = new DateTime($checkindate);
$date2 = new DateTime($checkoutdate);

///////////////////////////////////////////////////////////////////////////////////////
// this calculates the diff between two dates, which is the number of nights
///////////////////////////////////////////////////////////////////////////////////////
$numberOfNights= $date2->diff($date1)->format("%a"); 
/////////////////////////////////////////

$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Room_Info, Amenities FROM tbl_rooms_category

WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5 ))");
?>


<main> 
    
    <div class="middle-container">
    	
        <div class="container searchFrm padding-left-zero padding-right-zero">
        <form class="form-horizontal" role="form" id="searchRoomsFrm" method="post">
        
        	<div class="col-sm-2 col-xs-6 padding-left-zero">
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" id="chckin" name="chckin" class="form-control input-sm datetimepicker" placeholder="check-in" value="<?php echo $checkin; ?>">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-2 col-xs-6">
                <div class="input-group date" data-provide="datepicker">
                    <input type="text" id="chckout" name="chckout" class="form-control input-sm datetimepicker2" placeholder="check-out" value="<?php echo $checkout; ?>">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-2 col-xs-12 text-left text-center-xs"><button type="button" id="searchRoomsBtn" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> SEARCH</button></div>
            
            <div class="col-sm-6 col-xs-12 text-right backbtnblk padding-right-zero">
            	<a id="cancelBtn" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i> CANCEL RESERVATION</a>
                <a id="cancelBtn" class="btn btn-sm btn-info"><i class="fa fa-spinner" aria-hidden="true"></i> PENDING RESERVATION</a>
                <button type="button" id="backBtn" class="btn btn-sm btn-success"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> BACK</button>
            </div>
            <div class="clearfix"></div>
        
    	</form>
        </div>
        
        <div id="Tab1">
        <form class="form-horizontal" role="form" id="reservationFrm" method="post">
            	<input type="hidden" id="checkindate" value="<?php echo $checkindate; ?>" />
                <input type="hidden" id="checkoutdate" value="<?php echo $checkoutdate; ?>" />
                <input type="hidden" id="totalNights" value="<?php echo $numberOfNights; ?>" />
        <div class="container page-content">
                
        	<div class="col-sm-9 table-responsive">
            	<table class="table table-hover roomTypeList">
                	<thead>
                        <tr class="bg-default">
                            <th>Room Photo</th>
                            <th>Room Type</th>
                            <th>Price/Night</th>
                            <th>Price for <?php echo $numberOfNights;?> Night(s)</th>
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
                            <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f', $val['Base_Fare']);?></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f', ($numberOfNights * $val['Base_Fare'])); ?></td>
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
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5)"); 

?>
                            	<select id="room-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control totalRooms">          
                                  <option value="0" selected="selected">0</option>          
                                  <?php 
								  $i=1;
								  while($i<=$roomCount[1]['RID']){ ?>
                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                  <?php $i++;} ?>
                                  
                                </select>
                                
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
        	
        </div>
        </form>
        </div>
        
        <div id="Tab2" class="container checkout-tab" style="display:none;">
        	<form class="form-horizontal" role="form" id="contactFrm" method="post">
            <div class="col-sm-8">
            	<h2><strong>CONTACT INFORMATION</strong></h2>
                
                <div class="contact-info">
                	
                    	<div>
                        	<div class="item form-group col-md-6 col-sm-6 col-xs-12">
                              <label class="control-label" for="fullname">Full Name <span class="required">*</span> </label>
                              <div>
                                <input type="text" id="fullname" name="fullname" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Name">
                              </div>
                            </div>
                            <div class="item col-md-6 col-sm-6 col-xs-12">
                              <label class="control-label" for="email">Email <span class="required">*</span> </label>
                              <div>
                                <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Email Id">
                              </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                        	<div class="item form-group col-md-6 col-sm-6 col-xs-12">
                              <label class="control-label" for="phone">Phone <span class="required">*</span> </label>
                              <div>
                                <input type="text" id="phone" name="phone" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Phone No.">
                              </div>
                            </div>
                            <div class="item col-md-6 col-sm-6 col-xs-12">
                              <label class="control-label" for="idprof">Id Proof <span class="required">*</span></label>
                              <div>
                                <input type="file" id="idprof" name="idprof" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Name"> (Ex: Aadhaar Card, Voter Id, Passport etc.)
                              </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                        	<div class="item form-group col-md-4 col-sm-4 col-xs-12">
                              <label class="control-label" for="arrTime">Your estimated arrival time</label>
                              <div>
                                <select name="arrTime" id="arrTime" class="form-control input-sm" >
                                  <option value="">-- Select --</option>
                                  <option value="01:00">01:00</option>
                                  <option value="02:00">02:00</option>
                                  <option value="03:00">03:00</option>
                                  <option value="04:00">04:00</option>
                                  <option value="05:00">05:00</option>
                                  <option value="06:00">06:00</option>
                                  <option value="07:00">07:00</option>
                                  <option value="08:00">08:00</option>
                                  <option value="09:00">09:00</option>
                                  <option value="10:00">10:00</option>
                                  <option value="11:00">11:00</option>
                                  <option value="12:00">12:00</option>
                                  
                                  <option value="13:00">13:00</option>
                                  <option value="14:00">14:00</option>
                                  <option value="15:00">15:00</option>
                                  <option value="16:00">16:00</option>
                                  <option value="17:00">17:00</option>
                                  <option value="18:00">18:00</option>
                                  <option value="19:00">19:00</option>
                                  <option value="20:00">20:00</option>
                                  <option value="21:00">21:00</option>
                                  <option value="22:00">22:00</option>
                                  <option value="23:00">23:00</option>
                                  <option value="00:00">00:00</option>
                                </select>
                              </div>
                            </div>
                            
                            <div class="clearfix"></div>
                        </div>
                        
                        <div>
                        	<input type="checkbox" id="iagree" name="iagree" required="required" /> <label style="font-weight:normal" class="control-label" for="idprof"><span class="required">*</span> I agree with the terms and conditions of Van Vinodan Resort  </label>
                        </div>
                    
                </div>
                
                <div class="termsBlk">
                	<h5>Check-In / Check-Out Policies</h5>
                    <p>This property has the following check-in and check-out times and policies. </p>
                    
                    <p><strong>Check-In</strong>: 10:00 AM<br>
                    <strong>Check-Out</strong>: 08:00 AM</p>
                    
                    <h5>Property and Cancellation Policies:</h5>
                    <p>CANCELLATION POLICY</p>
                    <ul>
                        <li>No refund against confirmed booking, when cancelled within 14 days prior to arrival date.</li>
                        <li>One day’s room rent will be the cancellation charge for confirmed booking when cancelled minimum 15 days prior to arrival date.</li>
                    </ul>
                    <p>NO-SHOW POLICY</p>
                    <ul>
                        <li>Guest should check-in before 6 P.M. of the arrival date, else will be treated as no-show to the Hotel.</li>
                        <li>For late check-in, guest must intimate to the Hotel.</li>
                        <li>In case of no-show, there will be no-refund of the advance paid.</li>
                    </ul>
                    
                    <h5>Terms and Conditions</h5>
                    <p>As a guest at Van Vinodan Resort, our policies are designed to enhance your stay and ensure maximum comfort and convenience throughout. Please be advised that all guests including children staying at Holiday Resort are required to present valid identification upon check-in which may be either a passport or National ID. *Passport is mandatory for all foreign nationals. Please be aware of the following policies:</p>
                </div>
                
            </div>
            <div class="col-sm-4 reservation-info">
            	<h2><strong>Your Reservation</strong></h2>
                <div id="checkout-info">
                
                </div>
            </div>
            </form>
        </div>
    </div>  	
</main>

<?php include('footer.php'); ?>