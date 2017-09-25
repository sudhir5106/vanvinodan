<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

$getCategory=$db->ExecuteQuery("SELECT Category_Id, Category_Name FROM tbl_category WHERE Category_Id='".$_REQUEST['id']."'");

?>
<script type="text/javascript" src="category.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3> Edit Category </h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Form </h2>
          <ul class="nav navbar-right panel_toolbox">
           <li><button class="btn btn-round btn-success" onclick="window.history.back();">Back</button></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="" method="post" id="editcategoryform">
          	<input type="hidden" id="id" value="<?php echo $_REQUEST['id']?>">
            <div class="col-sm-12">
           <!---Write here English Content Here-->
            <div>
            
              <div class="item form-group">
                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">Category <span class="required">*</span> </label>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <input type="text" id="name" class="form-control col-md-7 col-xs-12" name="name" placeholder="Architecture" required value="<?php echo $getCategory[1]['Category_Name']?>">
                </div>
              </div>
              
            </div>
            <!---Close Here English -->
            
             <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-5"> 
                <button id="update" type="button" class="btn btn-success">Update</button>
              </div>
            </div>
          </form>
            </div>
             <div id="dialog" title="Message" style="display:none; text-align:left;">
                <p>Category Successfully Update</p>
            </div>
        </div>
      </div>
    </div>
  </div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
