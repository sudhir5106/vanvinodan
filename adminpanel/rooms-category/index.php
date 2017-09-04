<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();
?>
<script type="text/javascript" src="roomcategory.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Add Room Category</h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add New</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-round btn-success" onclick="location.href='list.php';">View List</button>
            </li>
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
                    <input type="text" id="rcatname" name="rcatname" required class="form-control col-md-7 col-xs-12 " placeholder="Standard, Deluxe,..etc.">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="capacity">Room Capacity <span class="required">*</span> </label>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <input type="text" id="capacity" name="capacity" required class="form-control col-md-7 col-xs-12 " placeholder="Ex: 2">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="basefare">Base Fare <span class="required">*</span> </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="basefare" name="basefare" required class="form-control col-md-7 col-xs-12 " placeholder="Rs.">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="extraguestfare">Extra Guest Fare <span class="required">*</span> </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <input type="text" id="extraguestfare" name="extraguestfare" required class="form-control col-md-7 col-xs-12 " placeholder="Rs.">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">Room Description <span class="required">*</span></label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <textarea id="desc" name="desc" required class="form-control col-md-7 col-xs-12 " placeholder="Write Here Something About Room... "  rows="10"></textarea>
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="amenities">Amenities <span class="required">*</span></label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <textarea id="amenities" name="amenities" required class="form-control col-md-7 col-xs-12 " placeholder="Ex: 3 LCD TV | H/C Water Supply | Tea/Coffee Maker | WIFI | Electronic Safe | EPABX | Toiletries...etc "  rows="10"></textarea>
                  </div>
                </div>
                
              </div>
              
              
              
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            
            <div class="form-group">
              <div class="col-md-6 col-md-offset-5"> 
                <button id="submit" type="button" class="btn btn-success">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <div id="dialog1" title="Message" style="display:none; text-align:left;">
          <p>Successfully Added New Room Category</p>
        </div>
        <div id="dialog2" title="Message" style="display:none; text-align:left;">
          <p>Something is Wrong</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>