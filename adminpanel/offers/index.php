<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();
?>
<script type="text/javascript" src="offer.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Upload Offers</h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Upload New</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-round btn-success" onclick="location.href='list.php';">View List</button>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="" method="post" id="offerform">
          
            <div class="col-sm-12"> 
            
              <div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="offertitle">Offer Title <span class="required">*</span> </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" id="offertitle" name="offertitle" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Offer Title">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="published_date">Publish Date <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="published_date" name="published_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD-MM-YYYY">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="expiry_date" name="expiry_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD-MM-YYYY">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileupload">Updoad News Image <span class="required">*</span></label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="file" id="fileupload" name="fileupload" class="form-control col-md-7 col-xs-12" accept="pdf">
                    <span id="errmsg"></span> (Note : Upload Image not more than 1MB.) </div>
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
          <p>Offer Successfully Added</p>
        </div>
        <div id="dialog2" title="Message" style="display:none; text-align:left;">
          <p>Something is Wrong</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
