<?php 
include('../../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//get all categories
$getVideo=$db->ExecuteQuery("SELECT Video_Id, Video_Caption, Video_Link FROM tbl_video_gallery ORDER BY Video_Id DESC")
?>
<script type="text/javascript" src="video.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3> Videos </h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>View List </h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><button class="btn btn-round btn-success" onclick="location.href='index.php';">Add New Video</button>
            </li>
            
          </ul>
          <div class="clearfix"></div>
        </div>
        <div class="x_content">
          
          <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Caption Name</th>
                <th>Video</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
            <?php $i=1; foreach($getVideo as $val){ ?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $val['Video_Caption'];?></td>
                <td width="150" height="150"><?php echo $val['Video_Link'];?></td>
                <td>
                    <a class="btn btn-success btn-xs" href="edit.php?id=<?php echo $val['Video_Id'];?>">Edit</a>
                    <a class="btn btn-danger btn-xs delete" href="#" id="<?php echo $val['Video_Id'];?>"> Delete</a>
                </td>
              </tr>
              <?php $i++;} ?>
              
            </tbody>
          </table>
          
          <div id="deletemsg" title="Message" style="display:none; text-align:left;">
              <p>Video Successfully Deleted!</p>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  
  
</div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
