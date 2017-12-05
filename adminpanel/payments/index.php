<?php 
include('../../config.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');

//***************************************************
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
//***************************************************
$report = $db->ExecuteQuery("SELECT Transaction_Id, DATE_FORMAT(Transaction_Date,'%d-%m-%Y <mark>%h:%i:%s</mark>') AS Transaction_Date, Transaction_No, Paid_Amt, Payment_Mode, Pay_Status, Payment_Id, Reservation_Ref_No, Client_Name
FROM tbl_transactions t
LEFT JOIN tbl_reservation r ON t.Reservation_Id = r.Reservation_Id
ORDER BY t.Transaction_Date DESC
");
//***************************************************


?>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>List of Payments Received</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>View List </h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <table class="table table-bordered table-stripped paymentTbl">
            <thead>
              <tr class="bg-info">
                <th>Sno.</th>
                <th>Date &amp; Time</th>
                <th>Customer</th>
                <th>Reservation Ref. No</th>
                <th>Amount(<i class="fa fa-inr" aria-hidden="true"></i>)</th>
                <th>Transaction Code</th>
                <th>Payment Id</th>
                <th>Payment Mode</th>
                <th>Payment Status</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach($report as $reportVal){ ?>
              <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $reportVal['Transaction_Date']; ?></td>
                <td><?php echo $reportVal['Client_Name']; ?></td>
                <td><?php echo $reportVal['Reservation_Ref_No']; ?></td>
                <td><?php echo $reportVal['Paid_Amt']; ?></td>
                <td><?php echo $reportVal['Transaction_No']; ?></td>
                <td><?php echo $reportVal['Payment_Id']; ?></td>
                <td><?php echo $reportVal['Payment_Mode']; ?></td>
                <td><label class="label <?php echo $reportVal['Pay_Status']=='success'?'label-success':'label-danger' ?> label-xs"><?php echo $reportVal['Pay_Status']; ?></label></td>
              </tr>
              <?php $i++;} ?>
            </tbody>
          </table>
        </div>
        <div id="deletemsg" title="Message" style="display:none; text-align:left;">
            <p>Room Deleted Successfully!</p>
        </div>
      </div>
    </div>
  </div>
  
</div>
<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
