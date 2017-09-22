<?php 
include('../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
$currentDate = date("Y-m-d");
$getTdayCnfmedBkng = $db->ExecuteQuery("SELECT Reservation_Id, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Arrival_Time FROM tbl_reservation WHERE (Reservation_Status = 1 OR Reservation_Status = 2) AND Check_In_Date = '".$currentDate."' ORDER BY Arrival_Time ASC LIMIT 5");


$getPendingBkng = $db->ExecuteQuery("SELECT Reservation_Id, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Arrival_Time FROM tbl_reservation WHERE Reservation_Status = 5 AND Check_In_Date >= '".$currentDate."' ORDER BY Check_In_Date ASC LIMIT 5");

////////////////////////////////////////////////////////////////////////////////////
// Get all the room id's from tbl_room_master table to compare with the booked rooms
////////////////////////////////////////////////////////////////////////////////////
$getRoomsMaster = $db->ExecuteQuery("SELECT Room_Id, Room_Name FROM tbl_room_master");
//**********************************************************************************
// Get all booked rooms in the current date ////////////////////////////////////////
//**********************************************************************************
$cuurentBookedRooms = $db->ExecuteQuery("SELECT r.Reservation_Id, Client_Name, DATE_FORMAT(r.Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(r.Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Room_Id, CASE WHEN r.Reservation_Status=1 THEN 'Confirmed' WHEN r.Reservation_Status=2 THEN 'Arrived' END Reservation_Status
FROM tbl_reservation r
LEFT JOIN tbl_reserved_rooms rr ON r.Reservation_Id = rr.Reservation_Id
WHERE r.Check_In_Date<='".$currentDate."' AND r.Check_Out_Date >='".$currentDate."' AND r.Reservation_Status = 1 OR r.Reservation_Status = 2");
//**********************************************************************************

require_once(PATH_ADMIN_INCLUDE.'/header.php');

?>
<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Dashboard</h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Today's Confirmed Reservations <span class="badge"><?php echo count($getTdayCnfmedBkng); ?></span></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-sm btn-success" onclick="location.href='list.php';">View All</button>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table class="table table-bordered table-striped">
          	<thead>
                <tr class="bg-info">
                    <th>Name</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Arrival</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
				if(!empty($getTdayCnfmedBkng)){
				  foreach($getTdayCnfmedBkng as $getTdayCnfmedBkngVal){ ?>
                <tr>
                    <td><?php echo $getTdayCnfmedBkngVal['Client_Name'] ?></td>
                    <td><?php echo $getTdayCnfmedBkngVal['Check_In_Date'] ?></td>
                    <td><?php echo $getTdayCnfmedBkngVal['Check_Out_Date'] ?></td>
                    <td><?php echo $getTdayCnfmedBkngVal['Arrival_Time'] ?></td>
                    <td><a class="btn btn-xs btn-info confirmViewBtn" id="resid-<?php echo $getTdayCnfmedBkngVal['Reservation_Id'] ?>">view</a></td>
                </tr>
                <?php }
				}else{?>
                <tr>
                	<td align="center" colspan="5"><span class="label label-danger">No Confirmed Reservations for Today</span></td>
                </tr>
                <?php } ?>
            </tbody>
          </table>
          
        </div>
      </div>
    </div>
    
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Pending Reservations <span class="badge"><?php echo count($getPendingBkng); ?></span></h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-sm btn-success" onclick="location.href='list.php';">View All</button>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-bordered table-striped">
          	<thead>
                <tr class="bg-info">
                    <th>Name</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Arrival</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            	<?php 
				if(!empty($getPendingBkng)){
				foreach($getPendingBkng as $getPendingBkngVal){ ?>
                <tr>
                    <td><?php echo $getPendingBkngVal['Client_Name'] ?></td>
                    <td><?php echo $getPendingBkngVal['Check_In_Date'] ?></td>
                    <td><?php echo $getPendingBkngVal['Check_Out_Date'] ?></td>
                    <td><?php echo $getPendingBkngVal['Arrival_Time'] ?></td>
                    <td>
                    <button class="btn btn-xs btn-info pendingViewBtn" id="rid-<?php echo $getPendingBkngVal['Reservation_Id'] ?>">view</button>
                    </td>
                </tr>
                <?php }
				}else{?>
                <tr>
                	<td align="center" colspan="5"><span class="label label-danger">No Pending Reservations</span></td>
                </tr>
                <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Today's Reserved Rooms</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="bg-info">
                <th>Room No</th>
                <th>Customer Name</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($getRoomsMaster as $getRoomsMasterVal){ ?>
              <tr>
                <td><?php echo $getRoomsMasterVal['Room_Name']; ?></td>
                <td><?php 
                foreach($cuurentBookedRooms as $cuurentBookedRoomsVal){
                  if($cuurentBookedRoomsVal['Room_Id']==$getRoomsMasterVal['Room_Id']){
                    echo $cuurentBookedRoomsVal['Client_Name'];
                  }                  
                }
                ?></td>

                <td><?php 
                foreach($cuurentBookedRooms as $cuurentBookedRoomsVal){
                  if($cuurentBookedRoomsVal['Room_Id']==$getRoomsMasterVal['Room_Id']){
                    echo $cuurentBookedRoomsVal['Check_In_Date'];
                  }                  
                }
                ?></td>

                <td><?php 
                foreach($cuurentBookedRooms as $cuurentBookedRoomsVal){
                  if($cuurentBookedRoomsVal['Room_Id']==$getRoomsMasterVal['Room_Id']){
                    echo $cuurentBookedRoomsVal['Check_Out_Date'];
                  }                  
                }
                ?></td>

                <td><?php 
                foreach($cuurentBookedRooms as $cuurentBookedRoomsVal){
                  if($cuurentBookedRoomsVal['Room_Id']==$getRoomsMasterVal['Room_Id']){
                    echo "<span class='label ".($cuurentBookedRoomsVal['Reservation_Status']=='Confirmed'?'label-warning':'label-success')."'>".$cuurentBookedRoomsVal['Reservation_Status']."</span>";
                  }                  
                }
                ?></td>

              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    
    
    <!-- Modal POPUP -->
    <div id="bookingInfo" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" style="display: none;" aria-hidden="false">
        <div class="modal-dialog modal-md" role="document">
          
          <div class="modal-content" id="usersignin">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="gridModalLabel">Reservation Info</h4>
              </div>
              <div class="modal-body">
                          
                
              
              </div>
              <div class="clearfix"></div>
          </div>
        </div>
    </div>
    <!-- EOF Modal POPUP -->
</div>
<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>
