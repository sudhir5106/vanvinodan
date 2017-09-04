<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Here Category List
$getCategory=$db->ExecuteQuery("SELECT R_Category_Name, R_Capacity, Base_Fare, Extra_Guest_Fare, Room_Info, Amenities FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['id']);

?>
<script type="text/javascript" src="roomcategory.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Edit Room Category</h3>
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
          <form class="form-horizontal form-label-left" action="" method="post" id="roomCatform">
          
            <div class="col-sm-12"> 
            
              <div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="rcatname">Room Category Name <span class="required">*</span> </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" id="rcatname" name="rcatname" required class="form-control col-md-7 col-xs-12 " placeholder="Standard, Deluxe,..etc." value="<?php echo $getCategory[1]['R_Category_Name']; ?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="capacity">Room Capacity <span class="required">*</span> </label>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <input type="text" id="capacity" name="capacity" required class="form-control col-md-7 col-xs-12 " placeholder="Ex: 2" value="<?php echo $getCategory[1]['R_Capacity']; ?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="basefare">Base Fare <span class="required">*</span> </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="basefare" name="basefare" required class="form-control col-md-7 col-xs-12 " placeholder="Rs." value="<?php echo $getCategory[1]['Base_Fare']; ?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="extraguestfare">Extra Guest Fare <span class="required">*</span> </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="extraguestfare" name="extraguestfare" required class="form-control col-md-7 col-xs-12 " placeholder="Rs." value="<?php echo $getCategory[1]['Extra_Guest_Fare']; ?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">Room Description <span class="required">*</span></label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <textarea id="desc" name="desc" required class="form-control col-md-7 col-xs-12 " placeholder="Write Here Something About Room... "  rows="10"><?php echo $getCategory[1]['Room_Info']; ?></textarea>
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities">Amenities <span class="required">*</span></label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <textarea id="amenities" name="amenities" required class="form-control col-md-7 col-xs-12 " placeholder="Ex: 3 LCD TV | H/C Water Supply | Tea/Coffee Maker | WIFI | Electronic Safe | EPABX | Toiletries...etc "  rows="10"><?php echo $getCategory[1]['Amenities']; ?></textarea>
                  </div>
                </div>
                
              </div>
              
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            
            <div class="form-group">
              <div class="col-md-6 col-md-offset-5"> 
                <input type="hidden" id="id" value="<?php echo $_REQUEST['id']?>">
                <button id="update" type="button" class="btn btn-success">Update</button>
              </div>
            </div>
          </form>
            </div>
         <div id="dialog" title="Message" style="display:none; text-align:left;">
          	<p>Room Category Updated Successfully!</p>
    	</div>
        </div>
      </div>
    </div>
  </div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
