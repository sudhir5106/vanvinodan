<?php 
include('../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
$currentDate = date("Y-m-d");
$getTdayCnfmedBkng = $db->ExecuteQuery("SELECT Reservation_Id, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Arrival_Time FROM tbl_reservation WHERE Reservation_Status = 1 AND Check_In_Date = ".$currentDate." ORDER BY Arrival_Time ASC");

$getPendingBkng = $db->ExecuteQuery("SELECT Reservation_Id, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Arrival_Time FROM tbl_reservation WHERE Reservation_Status = 5 AND Check_In_Date >= '".$currentDate."' ORDER BY Check_In_Date ASC");



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
                    <td><a class="btn btn-xs btn-info" href="">view details</a></td>
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
                    <td><!--<a class="btn btn-xs btn-info" href="reservations/reservation-info.php?rid=<?php echo $getPendingBkngVal['Reservation_Id'] ?>">view details</a>-->
                    <button class="btn btn-xs btn-info pendingViewBtn" id="rid-<?php echo $getPendingBkngVal['Reservation_Id'] ?>">view details</button>
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
    
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>All Reservations</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-sm btn-success" onclick="location.href='list.php';">View List</button>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
        </div>
      </div>
    </div>
    
    
    <!-- Modal POPUP -->
    <div id="bookingInfo" rel="modal" style="background:#fff; display:none">sdfsd</div>
    
    
  </div>
</div>
<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
