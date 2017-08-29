<?php 
include('../../config.php');
include(PATH_ADMIN_INCLUDE.'/header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

$ChangePwd = $db->ExecuteQuery("SELECT Login_Password FROM tbl_admin_login WHERE Login_Id=".$_SESSION['admin']);

?>
<script type="text/javascript" src="change_password.js"></script>
<script>
	$(document).ready(function(){
		$('#success').hide();
		$('#warning').hide();	
	});
</script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>

<div>
  <div class="page-title">
    <div class="title_left">
      <h3>Change Password</h3>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_content" style="padding-top:30px;">
        	<form  class="form-horizontal"   id="changePassword" method="post" >
  				
                <input type="hidden" id="adminId" name="adminId" value="<?php echo $_SESSION['admin'];?>"/>
                <input type="hidden" id="password" name="password" value="<?php echo $ChangePwd[1]['Login_Password'];?>"/>
                
              <fieldset>
               <div class="alert alert-success" id="success" role="alert" style="display:none;">...</div>
                <div class="alert alert-danger" id="warning" role="alert" style="display:none;">...</div>
                
                <div class="form-group">
                  <label class="control-label col-sm-3" for="old_pwd">Old Password<span class="required">*</span>: </label>
                  <div class="col-sm-4">
                    <input type="password" placeholder="Old Password" id="old_pwd" name="old_pwd" class="form-control input-sm" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="new_pwd">New Password<span class="required">*</span>: </label>
                  <div class="col-sm-4">
                    <input type="password" placeholder="Old Password" id="new_pwd" name="new_pwd" class="form-control input-sm" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="con_pwd">Confirm New Password<span class="required">*</span>: </label>
                  <div class="col-sm-4">
                    <input type="password" placeholder="Confirm New Password" id="con_pwd" name="con_pwd" class="form-control input-sm" >
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="col-sm-9 col-sm-offset-3">
                      <button type="button" id="submit" class="btn btn-success">Submit</button>
                      <?php if(isset($_SESSION['login'])){?>
                      <a href="<?php echo PATH_ADMIN_LINK .'/update_employee/employee_list.php'?>" class="btn-success btn-sm">Back</a>
                      <?php } ?>
                  </div>
                </div>
              </fieldset>
            </form>
        </div>
      </div>
    </div>
  </div>
  
</div>

<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php');?>