<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

$category=$db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name FROM tbl_rooms_category");
?>

<script type="text/javascript" src="imageuplaod.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Uplaod Rooms Gallery</h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add New </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-round btn-success" onclick="window.history.back();">Back</button>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="" method="post" id="categoryform">
            
            <input type="hidden" id="id" value="">
            
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="category">Room Type <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="category" class="form-control col-md-7 col-xs-12" name="category">
                  <option value="">Select Type</option>
                  <?php foreach($category as $val){ ?>
                  <option value="<?php echo $val['R_Category_Id']?>"><?php echo $val['R_Category_Name']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageupload">Image Upload <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" id="imageupload" name="imageupload" required="required" class="form-control col-md-7 col-xs-12 " accept="image/jpg,image/png,image/jpeg,image/gif" multiple>
                <span id="errmsg"></span> (Note : Image size must be geater than 500*300  and you can also upload multiple images also.) </div>
            </div>
            
            <div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-5"> 
                <button id="submit" type="button" class="btn btn-success">Submit</button>
              </div>
            </div>
            
          </form>          
        </div>
        
      </div>
      <!-- GEt HEre All The Image -->
      <div id="imageShow"> </div>
      <div id="dialog1" title="Message" style="display:none; text-align:left;">
        <p>Image Successfully Uploaded</p>
      </div>
      <div id="dialog2" title="Message" style="display:none; text-align:left;">
        <p>Something is Wrong </p>
      </div>
    </div>
  </div>
</div>
<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
