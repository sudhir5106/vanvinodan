<?php 
include('header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

$checkindate = date('Y-m-d',strtotime($_POST['checkindate']));
$checkoutdate = date('Y-m-d',strtotime($_POST['checkoutdate']));

$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Aircondition_Fare, Extra_Bed_Fare, Room_Info, Amenities FROM tbl_rooms_category

WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' ))");

?>


<main> 
        
    <div class="middle-container">
    	
        <div class="container page-content">
        	<div class="col-sm-8">
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
                            <td class="text-info"><?php echo $val['R_Category_Name']; ?></td>
                            <td><i class="fa fa-inr" aria-hidden="true"></i> <?php echo sprintf('%0.2f',$val['Base_Fare']); ?></td>
                            <td><span class="glyphicon glyphicon-user"></span> <?php echo $val['R_Capacity']; ?></td>
                            <td class="ddbtn">
                                <select id="adult-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control multiselect multiselect-icon " role="multiselect">          
                                  <option value="1" selected="selected">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                </select>
                            </td>
                            <td class="ddbtn">
                                <select id="child-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control multiselect multiselect-icon" role="multiselect">          
                                  <option value="0" selected="selected">0</option>          
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                </select>
                            </td>
                            <td class="rooms">
                            <?php $roomCount = $db->ExecuteQuery("SELECT COUNT(Room_Id) AS RID FROM tbl_room_master 
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' )"); 

?>
                            	<select id="room-<?php echo $val['R_Category_Id']; ?>" type="text" class="form-control multiselect multiselect-icon" role="multiselect">          
                                  <option value="0" selected="selected">0</option>          
                                  <?php 
								  $i=1;
								  while($i<=$roomCount[1]['RID']){ ?>
                                  <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                  <?php $i++;} ?>
                                  
                                </select>
                                
                            </td>
                            <td class="extraItems">
                            	<select type="text" class="form-control multiselect multiselect-icon" multiple="multiple" role="multiselect">          
                                  <option value="<?php echo $val['Aircondition_Fare'] ?>" data-icon="glyphicon-asterisk">AC</option>
                                  <option value="<?php echo $val['Extra_Bed_Fare'] ?>" data-icon="glyphicon-asterisk">Extra Bed</option>
                                </select>
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
            <div class="col-sm-4 text-center">
            	<div class="bg-info"><strong>3 Accommodation(s) for</strong></div>
            </div>
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