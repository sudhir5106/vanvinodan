<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Here Category List
$getCategory=$db->ExecuteQuery("SELECT H_Description , H_Heading,Id, CASE WHEN Date=0 THEN '----' ELSE DATE_FORMAT(Date,'%d/%m/%Y') END  PDate, Description, Heading, Page_Link, H_Page_Link FROM tbl_latest_news WHERE Id='".$_REQUEST['id']."'");

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
              <!---Write here English Content Here-->
              <div class="col-sm-6">
                <div class="item form-group">
                  <center>
                    <h4><strong>English Section</strong></h4>
                  </center>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="published_date">Date <span class="required">*</span> </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" id="published_date" name="published_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD/MM/YYYY" value="<?php echo $getCategory[1]['PDate']?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="subcategory">News Title <span class="required">*</span> </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" id="heading" name="heading" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Heading" value="<?php echo $getCategory[1]['Heading']?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="fileupload">Updoad News PDF</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    
                    <input type="hidden" id="news-doc" name="news-doc" value="<?php echo $getCategory[1]['Page_Link']?>" />                  
                    <?php if(!empty($getCategory[1]['Page_Link'])){ ?>
                    <div><a target="_blank" class="btn btn-default btn-xs" style="color:#ff0000; font-size:18px;" href="<?php echo PATH_LATEST_NEWS_PDF."/english/".$getCategory[1]['Page_Link'];?>"><i class="fa fa-file-pdf-o"></i> News Document</a></div>
                    <?php } ?>
                    
                    <input type="file" id="fileupload" name="fileupload" class="form-control col-md-7 col-xs-12" accept="pdf">
                    <span id="errmsg"></span> (Note : Only PDF Document Can Upload.) </div>
                    
              	</div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="description">Description <span class="required">*</span> </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea id="desc" name="desc" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Write Here Something... "  rows="10"><?php echo $getCategory[1]['Description']?></textarea>
                  </div>
                </div>
              </div>
              <!---Close Here English --> 
              <!---Write here Hindi Content Here-->
              <div class="col-sm-6">
                <div class="item form-group">
                  <center>
                    <h4><strong >Hindi Section</strong></h4>
                  </center>
                </div>
              	<div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="h_heading">News Title <span class="required">*</span> </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <input type="text" id="h_heading" name="h_heading"  class="form-control col-md-7 col-xs-12 " placeholder="शीर्षक" value="<?php echo $getCategory[1]['H_Heading']?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="fileupload">Updoad News PDF</label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    
                    <input type="hidden" id="news-doc_h" name="news-doc_h" value="<?php echo $getCategory[1]['H_Page_Link']?>" />                  
                    <?php if(!empty($getCategory[1]['H_Page_Link'])){ ?>
                    <div><a target="_blank" class="btn btn-default btn-xs" style="color:#ff0000; font-size:18px;" href="<?php echo PATH_LATEST_NEWS_PDF."/hindi/".$getCategory[1]['H_Page_Link'];?>"><i class="fa fa-file-pdf-o"></i> News Document</a></div>
                    <?php } ?>
                    
                    <input type="file" id="fileupload_h" name="fileupload_h" class="form-control col-md-7 col-xs-12" accept="pdf">
                    <span id="errmsg"></span> (Note : Only PDF Document Can Upload.) </div>
                    
              	</div>
                
                <div class="item form-group">
                  <label class="control-label col-md-5 col-sm-5 col-xs-12" for="hdescription">Description <span class="required">*</span> </label>
                  <div class="col-md-7 col-sm-7 col-xs-12">
                    <textarea id="h_desc" name="h_desc" class="form-control col-md-7 col-xs-12 " placeholder="कुछ लिखिए..... "  rows="10"><?php echo $getCategory[1]['H_Description']?></textarea>
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
