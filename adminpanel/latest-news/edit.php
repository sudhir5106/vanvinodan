<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Here News List
$getNews=$db->ExecuteQuery("SELECT News_Title , News_Image, Description, CASE WHEN Date=0 THEN '----' ELSE DATE_FORMAT(Date,'%d/%m/%Y') END  PDate FROM tbl_latest_news WHERE Id='".$_REQUEST['id']."'");

?>
<script type="text/javascript" src="news.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Edit Latest News</h3>
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
          <form class="form-horizontal form-label-left" action="" method="post" id="newsform">
          	
            <div class="col-sm-12"> 
              <div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="published_date">Date <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="published_date" name="published_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD/MM/YYYY" value="<?php echo $getNews[1]['PDate']?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="newstitle">News Title <span class="required">*</span> </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" id="newstitle" name="newstitle" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Heading" value="<?php echo $getNews[1]['News_Title']?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileupload">Updoad News Image</label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="hidden" id="news-img" name="news-img" value="<?php echo $getNews[1]['News_Image']?>"/>
                
				<?php if(!empty($getNews[1]['News_Image']) && file_exists(ROOT."/images/latest-news/".$getNews[1]['News_Image']))
                    { 
                        echo '<div class="col-md-4"><img width="100%" src="'.PATH_IMAGE."/latest-news/thumb/".$getNews[1]['News_Image'].'"/></div>';
                    } 
                  else{
                      echo '<label class="col-md-4 control-label" for="fileupload"><span class="glyphicon glyphicon-user" style="font-size:50pt;"></span></label>';
                  } ?>
                    
                    <input class="col-md-8" type="file" id="fileupload" name="fileupload" accept="image/jpg,image/png,image/jpeg,image/gif"/>
              	  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">Description <span class="required">*</span></label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <textarea id="desc" name="desc" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Write Here Something... "  rows="10"><?php echo $getNews[1]['Description']?></textarea>
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
          	<p>News Updated Successfully!</p>
    	</div>
        </div>
      </div>
    </div>
  </div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
