<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Here Langauge List
$getLang=$db->ExecuteQuery("SELECT * FROM langauge");

//Get Here Category List
$getCategory=$db->ExecuteQuery("SELECT IMS.Section_Name, IMS.Section_Id, IU.Image_Path ,SC.Sub_Id, CG.Category_Name, SC.Position, Lang_Name, SC.Sub_Name FROM image_section IMS LEFT JOIN image_upload IU ON IU.Section_Id=IMS.Section_Id AND MainImage=1 LEFT JOIN  sub_category SC ON SC.Sub_Id=IMS.Sub_Id INNER JOIN category CG ON CG.Category_Id=IMS.Category_Id INNER JOIN langauge LG ON LG.Id=IMS.Langauge WHERE IMS.Section_Id='".$_REQUEST['id']."'");

//GEt Here Category list
$getList=$db->ExecuteQuery("SELECT Category_Id, Category_Name FROM category WHERE Langauge='".$getCategory[1]['Langauge']."'");


?>
<script type="text/javascript" src="subcategory.js"></script>
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Image - Upload </h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Edit Form </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
            <li><a class="close-link"><i class="fa fa-close"></i></a> </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          <form class="form-horizontal form-label-left" action="" method="post" id="categoryform">
          	<input type="hidden" id="id" value="<?php echo $_REQUEST['id']?>">
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="langauge">Language <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="langauge" class="form-control col-md-7 col-xs-12" name="langauge">
                 <option value="">Select Langauge</option>
                  <?php foreach($getLang as $val){?>
                  <option value="<?php echo $val['Id']?>" <?php if($getCategory[1]['Langauge']==$val['Id']){ echo "selected";}?>><?php echo $val['Lang_Name']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Category <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
              <select id="category" class="form-control col-md-7 col-xs-12" name="category">
                  <option value="">Select Category</option>
                  <?php foreach($getList as $val){?>
                  <option value="<?php echo $val['Category_Id']?>" <?php if($val['Category_Id']==$getCategory[1]['Category_Id']){ echo "Selected";} ?>><?php echo $val['Category_Name']?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="subcategory">Sub Category <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="subcategory" class="form-control col-md-7 col-xs-12" name="subcategory">
                  <option value="">Select Subcategory</option>
                </select>
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageupload">Section Name <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="imagename" name="imagename" required="required" class="form-control col-md-7 col-xs-12 "  placeholder="Ex. Villa"/>
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="imageupload">Image Upload <span class="required">*</span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="file" id="imageupload" name="imageupload" required="required" class="form-control col-md-7 col-xs-12 " accept="image/jpg,image/png,image/jpeg,image/gif" multiple>
                <span id="errmsg"></span>
                (Note : You can upload multiple images also.)
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="position">Description <span class="required"></span> </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <textarea id="desc" name="desc"  class="form-control col-md-7 col-xs-12 " placeholder="Write Here Something... " rows="5"></textarea>
              </div>
            </div><div class="ln_solid"></div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-3"> 
                <!-- <button type="submit" class="btn btn-primary">Cancel</button>-->
                <button id="update" type="button" class="btn btn-success">Update</button>
              </div>
            </div>
          </form>
            </div>
         <div id="dialog" title="Message" style="display:none; text-align:left;">
          	<p>Successfully Update Subcategory</p>
    	</div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
