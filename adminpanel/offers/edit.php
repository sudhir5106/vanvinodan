<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Offers List
$getoffer=$db->ExecuteQuery("SELECT Offer_Name , Offer_Image, CASE WHEN Published_Date=0 THEN '----' ELSE DATE_FORMAT(Published_Date,'%d/%m/%Y') END  PDate, DATE_FORMAT(Expired_Date,'%d/%m/%Y') AS  EDate FROM tbl_offers WHERE Offer_Id='".$_REQUEST['id']."'");

?>
<script type="text/javascript" src="offer.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Edit Offers</h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Form</h2>
          <ul class="nav navbar-right panel_toolbox">
             <li><button class="btn btn-round btn-success" onclick="window.history.back();">Back</button></li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="" method="post" id="offerEditform">
          	
            <div class="col-sm-12"> 
              <div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="offertitle">Offer Title <span class="required">*</span> </label>
                  <div class="col-md-5 col-sm-5 col-xs-12">
                    <input type="text" id="offertitle" name="offertitle" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Offer Title" value="<?php echo $getoffer[1]['Offer_Name'] ?>">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="published_date">Publish Date <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="published_date" name="published_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD-MM-YYYY" value="<?php echo $getoffer[1]['PDate'] ?>">
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="expiry_date">Expiry Date <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="expiry_date" name="expiry_date" required="required" class="form-control col-md-7 col-xs-12 datetimepicker" placeholder="DD-MM-YYYY" value="<?php echo $getoffer[1]['EDate'] ?>">
                  </div>
                </div>
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="fileupload">Updoad News Image</label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                    <input type="hidden" id="offer-img" name="offer-img" value="<?php echo $getoffer[1]['Offer_Image']?>"/>
                
				<?php if(!empty($getoffer[1]['Offer_Image']) && file_exists(ROOT."/images/offers/".$getoffer[1]['Offer_Image']))
                    { 
                        echo '<div class="col-md-4"><img width="100%" src="'.PATH_IMAGE."/offers/thumb/".$getoffer[1]['Offer_Image'].'"/></div>';
                    } 
                  else{
                      echo '<label class="col-md-4 control-label" for="fileupload"><span class="glyphicon glyphicon-user" style="font-size:50pt;"></span></label>';
                  } ?>
                    
                    <input class="col-md-8" type="file" id="fileupload" name="fileupload" accept="image/jpg,image/png,image/jpeg,image/gif"/>
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
          	<p>Offer Updated Successfully!</p>
    	</div>
        </div>
      </div>
    </div>
  </div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
