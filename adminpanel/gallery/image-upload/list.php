<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();


/*//Get Here Category List
$getCategory=$db->ExecuteQuery("SELECT SC.Sub_Id, CG.Category_Name , SC.Position, Lang_Name, SC.Sub_Name FROM sub_category SC INNER JOIN category CG ON CG.Category_Id=SC.Category_Id INNER JOIN langauge LG ON LG.Id=CG.Langauge ORDER BY Sub_Id DESC");
*/
////Get Here Langauge List
$getLang=$db->ExecuteQuery("SELECT * FROM langauge");
?>
<script type="text/javascript" src="imageuplaod.js"></script>

<script>
	$( document ).ready(function() {
		
	  var x;
			$.ajax({
			   type: "GET",
			   url: "filter_report.php",
			   async: false,
			   success: function(data){ //alert(data);
				   x=data;
				   $('#add').html(data);
			   }
			   });
	});
</script>
<div class="">
  <div class="page-title">
    <div class="title_left">
      <h3>Image Upload</h3>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>View List </h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a href="#"><i class="fa fa-chevron-up"></i></a> </li>
          <li><a href="#"><i class="fa fa-close"></i></a> </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_title">
      	<form class="form-horizontal form-label-left" action="" method="post" id="categoryform">
        <div class="item form-group">
              
              <div class="col-md-2 col-sm-3 ">
                <select id="langauge" class="form-control col-md-7 col-xs-12" name="langauge">
                 	<option value="">Select Langauge</option>
                  <?php foreach($getLang as $val){?>
                  <option value="<?php echo $val['Id']?>"><?php echo $val['Lang_Name']?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-md-3 col-sm-3 ">
                <select id="category" class="form-control col-md-7 col-xs-12" name="category">
                 	<option value="">Select Category</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-2 ">
                <select id="subcategory" class="form-control col-md-7 col-xs-12" name="subcategory">
                 	<option value="">Select Subcategory</option>
                </select>
              </div>
              <div class="col-md-2 col-sm-2 ">
                <input type="text" id="imagename" class="form-control col-md-7 col-xs-12" name="imagename" placeholder="Section Name"/>
              </div>
               <div class="col-md-2 col-sm-2 ">
                <input type="button" id="search" class="btn btn-primary" name="search" value="Search" />
                 	
              </div>
              
            </div>
        </form>
      </div>
      <div class="x_content" id="add">
        
        <!-- Get ?here Al The List data-->
      </div>
      <div id="deletemsg" title="Message" style="display:none; text-align:left;">
          <p>You can not delete this category , <br/>
            becouse this category is used in sub-category</p>
        </div>
    </div>
  </div>
</div>
<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
