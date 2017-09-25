<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();
?>
<script type="text/javascript" src="video.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Add Video</h3>
    </div>
  </div>
  <div class="clearfix"></div>
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
        <form class="form-horizontal form-label-left" action="" method="post" id="addVideoFrm">
          
          <div class="col-sm-12">
           <!---Write here English Content Here-->
            <div>
            	
                <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="caption">Caption <span class="required">*</span> </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" id="caption" name="caption" class="form-control col-md-7 col-xs-12" placeholder="Caption" required >
                    </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="videoLink">Video Link <span class="required">*</span> </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <textarea  id="videoLink" name="videoLink" required="required" class="form-control col-md-7 col-xs-12" placeholder=""></textarea><br /> <strong>Note:</strong> Please insert youtube video links only.
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
              <button id="submit" type="button" class="btn btn-success">Submit</button>
            </div>
          </div>
        </form>
      </div>
      <div id="dialog" title="Message" style="display:none; text-align:left;">
        <p>Video Successfully Added!</p>
      </div>
    </div>
  </div>
</div>
</div>

<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>
