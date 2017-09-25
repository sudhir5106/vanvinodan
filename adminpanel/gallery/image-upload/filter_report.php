<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/ps_pagination.php');
$db = new DBConn();
error_reporting(0);

$con  = mysql_connect(SERVER, DBUSER, DBPASSWORD);
$rows_per_page=ROWS_PER_PAGE;
$totpagelink=PAGELINK_PER_PAGE;
$condition='';
//Check Here IF Langauge is Empty For Filter
if($_REQUEST['langauge']!='')
{
	$condition.=' AND IMS.Langauge="'.$_REQUEST['langauge'].'"';
}

//Check Here IF Category is Empty For Filter
if($_REQUEST['category']!='')
{
	$condition.=' AND IMS.Category_Id="'.$_REQUEST['category'].'"';
}
//Check Here IF Langauge is Empty For Filter
if($_REQUEST['subcategory']!='')
{
	$condition.=' AND IMS.Sub_Id="'.$_REQUEST['subcategory'].'"';
}
//Check Here IF Langauge is Empty For Filter
if($_REQUEST['imagename']!='')
{
	$condition.=' AND IMS.Section_Name="'.$_REQUEST['imagename'].'"';
}

//Get Here Category List
 $sql="SELECT IMS.Section_Name, IMS.Section_Id, IU.Image_Path ,SC.Sub_Id, CG.Category_Name , SC.Position, Lang_Name, SC.Sub_Name FROM image_section IMS LEFT JOIN image_upload IU ON IU.Section_Id=IMS.Section_Id AND MainImage=1 LEFT JOIN  sub_category SC ON SC.Sub_Id=IMS.Sub_Id INNER JOIN category CG ON CG.Category_Id=IMS.Category_Id INNER JOIN langauge LG ON LG.Id=IMS.Langauge WHERE 1=1 ".$condition." ORDER BY Sub_Id DESC";
$getCategory=$db->ExecuteQuery($sql);

if(isset($_REQUEST['page']) && $_REQUEST['page']>1)
		{
			$i=($_REQUEST['page']-1)*$rows_per_page+1;
		}
		else
		{
			$i=1;
		}
		$pager = new PS_Pagination($con,$sql,$rows_per_page,$totpagelink);
		$rs=$pager->paginate();
		
?>
<script>
$(document).ready(function() {
$(".pagination a").click( function(event)
	{		
	event.preventDefault();
	var page=$(this).attr('id');
	
		$("#planresult input[id=page]").val(page);
		var str = $("#planresult").serializeArray();
		
				$.ajax({  
    					type: "GET",  
   						url: "filter_report.php",  
    					data: str,  
						async: false,
    					success: function(value) {  $("#add").html(value);}
						});//eof ajax
	});
	});
</script>

<form name="planresult" id="planresult">
 
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Section Name</th>
              <th>Subcategory Name</th>
              <th>Category Name</th>
              <th>Image</th>
              <th>Langauge</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
				 if(empty($rs)==false)
		{
		while($val=mysql_fetch_array($rs)){
			
			
			 ?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $val['Section_Name'];?></td>
              <td><?php echo $val['Sub_Name'];?></td>
              <td><?php echo $val['Category_Name'];?></td>
              <td><?php if(count($val['Image_Path'])>0){ echo '<img src="'.LINK_ROOT.'/image_upload/thumb/'.$val['Image_Path'].'" style="width:50px">'; }else{ echo '<img src="'.LINK_ROOT.'/image_upload/thumb/defult.jpg"  style="width:50px">'; }?></td>
              <td><?php echo $val['Lang_Name'];?></td>
              <td><!--<a href="view.php?id=<?php// echo $val['Sub_Id'];?>">View</a> |--> <a href="edit.php?id=<?php echo $val['Section_Id'];?>">Edit</a> | <a class="delete" href="#" id="<?php echo $val['Section_Id'];?>"> Delete</a></td>
            </tr>
            <?php $i++;}}else{ ?>
            <td colspan="6" align="center">Opps No Data Found</td>
            <?php } ?>
          </tbody>
        </table>
         
 		<div class="text-center">
     		 <?php echo $pager->renderFullNav() ?>
     	</div> 
        <input type="hidden" name="page" id="page" value="1"/>
        <input type="hidden" name="langauge" id="langauge" value="<?php echo @$_REQUEST['langauge']; ?>" />
        <input type="hidden" name="category" id="category" value="<?php echo @$_REQUEST['category']; ?>" />

</form>

