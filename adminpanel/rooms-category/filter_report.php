<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/ps_pagination.php');
$db = new DBConn();
error_reporting(0);

$con  = mysql_connect(SERVER, DBUSER, DBPASSWORD);
$rows_per_page=ROWS_PER_PAGE;
$totpagelink=PAGELINK_PER_PAGE;

//Get Rooms Category list
$sql="SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Extra_Guest_Fare FROM tbl_rooms_category ORDER BY R_Category_Id DESC";
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
		//this code is for pagination
		event.preventDefault();
		var page=$(this).attr('id');	
		$("#planresult input[id=page]").val(page);
		var str = $("#planresult").serializeArray();
		
		//ajax call
		$.ajax({  
				type: "GET",  
				url: "filter_report.php",  
				data: str,
				success: function(value) {  
					$("#add").html(value);
				}
		});//eof ajax
	});//eof click method
	
});//eof ready function
</script>

<form name="planresult" id="planresult">
 
        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No.</th>
              <th>Room Category</th>
              <th>Capacity</th>
              <th>Base Fare</th>
              <th>Extra Guest Fare</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php 
	if(empty($rs)==false)
		{
		while($val=mysql_fetch_array($rs)){ ?>
            <tr>
              <td><?php echo $i;?></td>
              <td><?php echo $val['R_Category_Name'];?></td>
              <td><?php echo $val['R_Capacity'];?></td>
              <td><?php echo $val['Base_Fare'];?></td>
              <td><?php echo $val['Extra_Guest_Fare'];?></td>
              
              <td>
              	<a class="btn btn-success btn-xs" href="edit.php?id=<?php echo $val['R_Category_Id'];?>">Edit</a>
                <a class="btn btn-danger btn-xs delete" href="#" id="<?php echo $val['R_Category_Id'];?>">Delete</a>
              </td>
            </tr>
            <?php $i++;}
			}else{ ?>
            <td colspan="7" align="center">Opps No Data Found</td>
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

