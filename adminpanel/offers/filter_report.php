<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/ps_pagination.php');
$db = new DBConn();
error_reporting(0);

$con  = mysql_connect(SERVER, DBUSER, DBPASSWORD);
$rows_per_page=ROWS_PER_PAGE;
$totpagelink=PAGELINK_PER_PAGE;

$condition='';
//******************************************
//Check Here IF Date is not Empty For Filter
//******************************************
if(!empty($_REQUEST['date']))
{
	$date = strtr($_REQUEST['date'], '/', '-');
	$condition.=' AND Published_Date="'.date('Y-m-d',strtotime($date)).'"';
}
//******************************************
//Check Here IF Langauge is Empty For Filter
//******************************************
if(!empty($_REQUEST['heading']))
{
	$condition.=' AND Offer_Name="'.$_REQUEST['heading'].'"';
}
//***********************************
//Get Offers List ///////////////////
//***********************************
$sql="SELECT Offer_Id, Offer_Name, Offer_Image, CASE WHEN Published_Date=0 THEN '----' ELSE DATE_FORMAT(Published_Date,'%d-%m-%Y') END PDate, DATE_FORMAT(Expired_Date,'%d-%m-%Y') AS EDate, CASE WHEN Status=0 THEN 'Show' ELSE 'Hide' END Status FROM tbl_offers WHERE 1=1 ".$condition." ORDER BY Published_Date DESC";
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
              <th>News Image</th>
              <th>News Title</th>
              <th>Publish Date</th>
              <th>Expiry Date</th>
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
              <td><img width="50" src="<?php echo PATH_IMAGE."/offers/thumb/".$val['Offer_Image'];?>" /></td>
              <td><?php echo $val['Offer_Name'];?></td>
              <td><?php echo $val['PDate'];?></td>
              <td><?php echo $val['EDate'];?></td>
              <td>
              	<a class="btn btn-success btn-xs" href="edit.php?id=<?php echo $val['Offer_Id'];?>">Edit</a>
                <a class="btn btn-danger btn-xs delete" href="#" id="<?php echo $val['Offer_Id'];?>">Delete</a>
                
                <button id="status-<?php echo $val['Offer_Id'];?>" type="button" class="status btn btn-xs <?php echo $val['Status']=='Hide'?"btn-warning":"btn-primary";?>"><?php echo $val['Status']; ?></button>
                
                </td>
            </tr>
            <?php $i++;}
			}else{ ?>
            <td colspan="6" align="center">Opps No Data Found</td>
            <?php } ?>
          </tbody>
        </table>
         
 		<div class="text-center">
     		 <?php echo $pager->renderFullNav() ?>
     	</div> 
        <input type="hidden" name="page" id="page" value="1"/>
        <input type="hidden" name="category" id="category" value="<?php echo @$_REQUEST['category']; ?>" />

</form>

