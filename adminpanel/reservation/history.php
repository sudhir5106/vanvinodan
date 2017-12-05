<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

//**********************************************************************************
// Get all the reservations except pending reservations ////////////////////////////
//**********************************************************************************
$allReservations = $db->ExecuteQuery("SELECT Reservation_Id, Reservation_Ref_No, Client_Name, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Grand_Total_Amt, CASE WHEN Reservation_Status=1 THEN 'Confirmed' WHEN Reservation_Status=2 THEN 'Arrived' WHEN Reservation_Status=3 THEN 'Checked Out' WHEN Reservation_Status=4 THEN 'Cancelled' END Reservation_Status
FROM tbl_reservation
WHERE Reservation_Status<>5 ORDER BY Reservation_Id DESC, Check_In_Date ASC");
//**********************************************************************************

require_once(PATH_ADMIN_INCLUDE.'/header.php');

?>
<script type="text/javascript" src="reservation.js"></script>
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
                <th>Paid Amt.</th>
                <th>Reservation Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
    <?php 
          $i=1;
          foreach($allReservations as $allReservationsVal){ 
            
            //**********************************************************************************
            // Get the total paid amount from tbl_transactions for each customer ///////////////
            //**********************************************************************************
            $totalPaidAmt = $db->ExecuteQuery("SELECT SUM(Paid_Amt) AS Paid_Amt 
            FROM tbl_transactions 
            WHERE Reservation_Id=".$allReservationsVal['Reservation_Id']);
            //**********************************************************************************
            // Get the total paid amount percentage ////////////////////////////////////////////
            //**********************************************************************************
            $paidAmtPercent = sprintf('%0.2f', $totalPaidAmt[1]['Paid_Amt']) * 100/sprintf('%0.2f', $allReservationsVal['Grand_Total_Amt']);
            //**********************************************************************************
            $rid = base64_encode($allReservationsVal['Reservation_Id']);
            //**********************************************************************************
            ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $allReservationsVal['Reservation_Ref_No']; ?></td>
                <td><?php echo $allReservationsVal['Client_Name']; ?></td>
                <td><?php echo $allReservationsVal['Check_In_Date']; ?></td>
                <td><?php echo $allReservationsVal['Check_Out_Date']; ?></td>
                <td><?php echo sprintf('%0.2f', $allReservationsVal['Grand_Total_Amt']); ?></td>
                <td><?php echo sprintf('%0.2f', $totalPaidAmt[1]['Paid_Amt']); ?></td>

                <td>
                  <?php echo "<span class='label ".($allReservationsVal['Reservation_Status']=='Confirmed'?'label-success':($allReservationsVal['Reservation_Status']=='Arrived'?'label-info':($allReservationsVal['Reservation_Status']=='Checked Out'?'label-warning':'label-danger')))."'>".$allReservationsVal['Reservation_Status']."</span>"; ?>
                  
                  <?php echo "<span class='label ".(round($paidAmtPercent)==0?'label-danger':(round($paidAmtPercent)=='100'?'label-primary':'label-default'))."'>Paid ".round($paidAmtPercent)."%</span>"; ?>                  
                </td>

                <td>
                  <a href="edit-reservation.php?rid=<?php echo $rid; ?>" class="btn btn-success btn-xs edit">Edit</a>
                  <?php if(sprintf('%0.2f', $allReservationsVal['Grand_Total_Amt']) != sprintf('%0.2f', $totalPaidAmt[1]['Paid_Amt'])){ ?>
                  <button data="<?php echo $allReservationsVal['Reservation_Ref_No'].'-'.sprintf('%0.2f', $allReservationsVal['Grand_Total_Amt']).'-'.sprintf('%0.2f', $totalPaidAmt[1]['Paid_Amt']); ?>" id="pay-<?php echo $allReservationsVal['Reservation_Id']; ?>" class="btn btn-info btn-xs pay">Pay</button>
                  <?php } ?>
                </td>

              </tr>
              <?php $i++; } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Modal POPUP for payment info-->
    <div id="paymentInfo" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" style="display: none;" aria-hidden="false">
        <div class="modal-dialog modal-md" role="document">
          
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="gridModalLabel">Payment Info</h4>
              </div>
              <div class="modal-body">
                          
                <form class="form-horizontal" role="form" id="paymentFrm" method="post">
                  
                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="resNo">Reservation Ref. No.</label>
                    <div id="resNo" class="control-label col-md-5 col-sm-5 col-xs-12 text-left" style="text-align:left!important">
                      
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="resAmt">Total Reservation Amt.</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <input type="text" id="resAmt" name="resAmt" class="form-control col-md-7 col-xs-12" readonly="readonly">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="paidAmt">Total Paid Amt.</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <input type="text" id="paidAmt" name="paidAmt" class="form-control col-md-7 col-xs-12" readonly="readonly">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="BalAmt">Balance Amt.</label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <input type="text" id="BalAmt" name="BalAmt" class="form-control col-md-7 col-xs-12" readonly="readonly">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="payment">Going to Pay <span class="required">*</span></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <input type="text" id="payment" name="payment" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12"></label>
                    <div class="col-md-5 col-sm-5 col-xs-12">
                      <button id="submitpayment" type="button" class="btn btn-success">Submit Payment</button>
                    </div>
                  </div>

                </form>
              
              </div>
              <div class="clearfix"></div>
          </div>
        </div>
    </div>
    <!-- EOF Modal POPUP -->


    <!-- Modal POPUP for booking info-->
    <div id="bookingInfo" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" style="display: none;" aria-hidden="false">
        <div class="modal-dialog modal-md" role="document">
          
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="gridModalLabel">Edit Reservation Info</h4>
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
