<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

$getVideo=$db->ExecuteQuery("SELECT Video_Id, Video_Caption, Video_Caption_H, Video_Link FROM tbl_video_gallery WHERE Video_Id='".$_REQUEST['id']."'");

?>
<script type="text/javascript" src="video.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3> Edit Video </h3>
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
          <form class="form-horizontal form-label-left" action="" method="post" id="addVideoFrm">
            <div class="col-sm-12">
           <!---Write here English Content Here-->
            <div class="col-sm-6">
                
                <div class="item form-group">
                    <label class="control-label col-md-4 col-sm-4 col-xs-12" for="caption">Caption <span class="required">*</span> </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input type="text" id="caption" name="caption" class="form-control col-md-7 col-xs-12" placeholder="Caption" required value="<?php echo $getVideo[1]['Video_Caption']; ?>">
                    </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-4 col-sm-4 col-xs-12" for="videoLink">Video Link <span class="required">*</span> </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <textarea  id="videoLink" name="videoLink" required="required" class="form-control col-md-7 col-xs-12" placeholder=""><?php echo $getVideo[1]['Video_Link']; ?></textarea><br /> <strong>Note:</strong> Please insert youtube video links only.
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
              	<input type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
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
