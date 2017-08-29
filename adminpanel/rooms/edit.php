<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

//Get Here Rooms List
$getRoom=$db->ExecuteQuery("SELECT Room_Name, R_Category_Id FROM tbl_room_master WHERE Room_Id=".$_REQUEST['id']);
$getRCate = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name FROM tbl_rooms_category");

?>
<script type="text/javascript" src="room.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Edit Room</h3>
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
          <form class="form-horizontal form-label-left" action="" method="post" id="roomform">
          
            <div class="col-sm-12"> 
            
              <div>
                
                <div class="form-group">
                  <label class="control-label col-sm-3 mandatory" for="rcatname">State <span>*</span>:</label>
                  <div class="col-sm-3">
                    <select name="rcatname" id="rcatname" class="form-control input-sm" >
                      <option value="">-- Select --</option>
                      <?php foreach($getRCate as $getRCateVal){ ?>
                      <option <?php echo $getRCateVal['R_Category_Id']==$getRoom[1]['R_Category_Id']?'selected':'' ?> value="<?php echo $getRCateVal['R_Category_Id'] ?>"><?php echo $getRCateVal['R_Category_Name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
        
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="roomName">Room Name &amp; No <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="roomName" name="roomName" required class="form-control col-md-7 col-xs-12 " placeholder="Room 101,..etc." value="<?php echo $getRoom[1]['Room_Name'] ?>">
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
          	<p>Room Category Updated Successfully!</p>
    	</div>
        </div>
      </div>
    </div>
  </div>

<?php 
require_once(PATH_ADMIN_INCLUDE.'/footer.php');

?>
