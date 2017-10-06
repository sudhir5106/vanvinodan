<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

//**********************************************************************************
// Get all the reservations except pending reservations ////////////////////////////
//**********************************************************************************
$allReservations = $db->ExecuteQuery("SELECT Reservation_Id, Reservation_Ref_No, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Grand_Total_Amt, CASE WHEN Reservation_Status=1 THEN 'Confirmed' WHEN Reservation_Status=2 THEN 'Arrived' WHEN Reservation_Status=3 THEN 'Checked Out' WHEN Reservation_Status=4 THEN 'Cancelled' END Reservation_Status
FROM tbl_reservation
WHERE Reservation_Status<>5");
//**********************************************************************************

require_once(PATH_ADMIN_INCLUDE.'/header.php');

?>
<div>

  <div class="page-title">
    <div class="title_left">
      <h3>Reservation History</h3>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>History</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-bordered table-striped">
            <thead>
              <tr class="bg-info">
                <th>SNo</th>
                <th>Res. Ref. No</th>
                <th>Customer Name</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Amount</th>
                <th>Reservation Status</th>
              </tr>
            </thead>
            <tbody>
    <?php 
          $i=1;
          foreach($allReservations as $allReservationsVal){ ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $allReservationsVal['Reservation_Ref_No']; ?></td>
                <td><?php echo $allReservationsVal['Client_Name']; ?></td>
                <td><?php echo $allReservationsVal['Check_In_Date']; ?></td>
                <td><?php echo $allReservationsVal['Check_Out_Date']; ?></td>
                <td><?php echo $allReservationsVal['Grand_Total_Amt']; ?></td>
                <td><?php echo "<span class='label ".($allReservationsVal['Reservation_Status']=='Confirmed'?'label-success':'label-warning')."'>".$allReservationsVal['Reservation_Status']."</span>"; ?></td>

              </tr>
              <?php $i++; } ?>
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
