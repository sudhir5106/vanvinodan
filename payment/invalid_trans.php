<?php 
include('../config.php');
require_once(PATH_LIBRARIES . '/classes/DBConn.php');
$db = new DBConn();
include(PATH_INCLUDE.'/header.php');

?>

<div class="content-wrapper">
  <section class="content-header">
    <h1> Payment Status </h1>
  </section>
  <div class="content">
    <div class="row">
      <div class="col-sm-8 col-sm-offset-2">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Payment Status </h3>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <div style="background:#fff; padding:10px; box-shadow:0px 0px 2px #B7B7B7; margin-bottom:20px;">
                  <h4> Invalid Transaction. Please <a href="PayUMoney_form.php?id=<?php echo $_REQUEST['id'];?>">try again</a></h4>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(PATH_INCLUDE.'/footer.php');?>
