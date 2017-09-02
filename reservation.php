<?php 
include('header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

$checkindate = date('Y-m-d',strtotime($_POST['checkindate']));
$checkoutdate = date('Y-m-d',strtotime($_POST['checkoutdate']));

/////////////////////////////////////////
//Get Total No of Nights
$date1 = new DateTime($checkindate);
$date2 = new DateTime($checkoutdate);

// this calculates the diff between two dates, which is the number of nights
$numberOfNights= $date2->diff($date1)->format("%a"); 
/////////////////////////////////////////

$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Aircondition_Fare, Extra_Bed_Fare, Room_Info, Amenities FROM tbl_rooms_category

WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' ))");

?>


<main> 
        
    <div class="middle-container">
    	
        <div class="container page-content">
        	<form class="form-horizontal" role="form" id="reservationFrm" method="post">
            	<input type="hidden" id="checkindate" value="<?php echo $checkindate; ?>" />
                <input type="hidden" id="checkoutdate" value="<?php echo $checkoutdate; ?>" />
                <input type="hidden" id="totalNights" value="<?php echo $numberOfNights; ?>" />
                
        	<div class="col-sm-9 table-responsive">
            	<table class="table table-hover roomTypeList">
                	<thead>
                        <tr class="bg-default">
                            <th>Room Photo</th>
                            <th>Room Type</th>
                            <th>Price/Night</th>
                            <th>Max</th>
                            <th>Adults</th>
                            <th>Children</th>
                            <th>Rooms</th>
                            <th>Extra Facility</th>
                        </tr>
                    </thead>
                    <tbody>
                    
					<?php foreach($res as $val){ ?>
                        <tr>
                            <td><img src="images/room-img.jpg" alt="" /></td>
                            <td class="text-info">
								<?php echo $val['R_Category_Name']; ?>
                                <input type="hidden" id="roomType-<?php echo $val['R_Category_Id']; ?>" value="<?php echo $val['R_Category_Id']; ?>" />
                            </td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f',$val['Base_Fare']); ?></td>
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
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' )"); 

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
                            	<input type="checkbox" class="acAmt" id="acAmt-<?php echo $val['R_Category_Id']; ?>" name="" value="<?php echo $val['Aircondition_Fare'] ?>" /> AC ( <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $val['Aircondition_Fare']; ?> )<br />
                                <input type="checkbox" class="extraBedAmt" id="extraBedAmt-<?php echo $val['R_Category_Id']; ?>" name="" value="<?php echo $val['Extra_Bed_Fare'] ?>" /> Extra Bed ( <i class="fa fa-inr" aria-hidden="true"></i> <?php echo $val['Extra_Bed_Fare']; ?> )<br />
                                
                                <input type="hidden" class="subtotal" id="subTotal-<?php echo $val['R_Category_Id']; ?>" value="" />
                                
                            </td>
                        </tr>
                        <tr class="roomInfo" style="display:none; background:#f7f7f9;">
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
                    <div><button type="button" class="btn btn-lg btn-danger">BOOK NOW</button></div>
                </div>
            </div>
            </form>
            <div class="clearfix"></div>
        	
        </div>
        
        <!--<div class="text-info" style="padding-top:20px;">
        <?php foreach($res2 as $val2){ 
			echo $val2['Room_Name'].'<br>'; 
		} ?>
        </div>-->
        
    </div>  	
</main>

<?php include('footer.php'); ?>