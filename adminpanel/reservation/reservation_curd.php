<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

///*******************************************************
/// To Insert Room ////////////////////////////////
///*******************************************************
if($_POST['type']=="getRoomsFrm")
{
	$room = $db->ExecuteQuery("SELECT Room_Name FROM tbl_room_master WHERE Room_Id=".$_REQUEST['roomId']);
	
	$specification = $db->ExecuteQuery("SELECT R_Capacity, Base_Fare, Extra_Guest_Fare FROM tbl_rooms_category WHERE R_Category_Id=(SELECT R_Category_Id FROM tbl_room_master WHERE Room_Id=".$_REQUEST['roomId'].")");

	?>

	<tr id="row-<?php echo $_REQUEST['roomId']; ?>">
		<td><?php echo $room[1]['Room_Name']; ?></td>
		<td>
			<select id="adult-<?php echo $_REQUEST['roomId']; ?>" class="form-control adultdd">          
              <?php 
			  $i=1;
			  while($i<=$specification[1]['R_Capacity']){ ?>
              	<option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php $i++; } ?>
              
            </select>
		</td>
		<td>
			<select id="child-<?php echo $_REQUEST['roomId']; ?>" class="form-control childdd">          
              <?php 
			  $i=0;
			  while($i<$specification[1]['R_Capacity']){ ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
              <?php $i++; } ?>
              
            </select>
		</td>
		<td><input id="extra-<?php echo $_REQUEST['roomId']; ?>" type="text" class="form-control extraGuest" value=""></td>
		<td><input id="baseFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo $specification[1]['Base_Fare']; ?>" class="form-control" disabled ></td>
		<td><input id="extraFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="0" class="form-control" disabled ></td>
		<td><input id="total-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo $specification[1]['Base_Fare']; ?>" class="form-control total" disabled ></td>
        <td><input id="totalFare-<?php echo $_REQUEST['roomId']; ?>" type="text" value="<?php echo ($_REQUEST['nightsCount'] * $specification[1]['Base_Fare']); ?>" class="form-control total" disabled ></td>
		
		<input id="extraGuestFare-<?php echo $_REQUEST['roomId']; ?>" type="hidden" class="form-control" value="<?php echo $specification[1]['Extra_Guest_Fare']; ?>">
		<input id="capacity-<?php echo $_REQUEST['roomId']; ?>" type="hidden" class="form-control" value="<?php echo $specification[1]['R_Capacity']; ?>">

	</tr>

<?php
}//eof if condition

?>