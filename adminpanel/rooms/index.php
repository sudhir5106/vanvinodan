<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_ADMIN_INCLUDE.'/header.php');
$db = new DBConn();

$getRCate = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name FROM tbl_rooms_category");

?>
<script type="text/javascript" src="room.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Add Room</h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <h2>Add New</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li>
              <button class="btn btn-round btn-success" onclick="location.href='list.php';">View List</button>
            </li>
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
                      <option value="<?php echo $getRCateVal['R_Category_Id']; ?>"><?php echo $getRCateVal['R_Category_Name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
        
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="roomName">Room Name &amp; No <span class="required">*</span> </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <input type="text" id="roomName" name="roomName" required class="form-control col-md-7 col-xs-12 " placeholder="Room 101,..etc.">
                  </div>
                </div>
                
              </div>
              
            </div>
            <div class="clearfix"></div>
            <div class="ln_solid"></div>
            
            <div class="form-group">
              <div class="col-md-6 col-md-offset-5"> 
                <button id="submit" type="button" class="btn btn-success">Submit</button>
              </div>
            </div>
          </form>
        </div>
        <div id="dialog1" title="Message" style="display:none; text-align:left;">
          <p>New Room Successfully Added!</p>
        </div>
        <div id="dialog2" title="Message" style="display:none; text-align:left;">
          <p>Something is Wrong</p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>