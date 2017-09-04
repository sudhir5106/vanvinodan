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
	
	$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Aircondition_Fare, Extra_Bed_Fare, Room_Info, Amenities FROM tbl_rooms_category
	
	WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
	WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$_REQUEST['chckin']."' AND Check_Out_Date > '".$_REQUEST['chckin']."' ))");?>
	
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
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$_REQUEST['chckin']."' AND Check_Out_Date > '".$_REQUEST['chckin']."' )"); 

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
                        
                        <input type="hidden" class="subtotal" id="subTotal-<?php echo $val['R_Category_Id']; ?>" value="0.00" />
                        
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
            <div>
                <input type="hidden" id="TotalAmt" value="0.00" />
                <button type="button" id="bookRoomBtn" class="btn btn-lg btn-danger">BOOK NOW</button>
            </div>
        </div>
    </div>
    
    <div class="clearfix"></div>
    
	
<?php }










?>