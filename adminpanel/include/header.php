<?php 

	require_once(PATH_ADMIN_INCLUDE.'/head.php');
	//Check Here If Admin is authorised or not
	if(empty($_SESSION['admin']))
	{?>
		<script>
			window.location.href = '<?php echo LINK_CONTROL.'/login/index.php'; ?>';
		</script>
	<?php } ?>
 
<script>
	$(document).ready(function() {
		$("#logoff").click(function(){
			$.ajax(
			{
				url:'<?php echo LINK_CONTROL.'/login/logout.php'; ?>',
				type:'POST',
				data:{},
				async:false,
				success:function(data){
				if (data=="true")
					{
						document.location.href='<?php echo LINK_CONTROL.'/login/index.php'; ?>';
					}
				}
			});//eof ajax
		});// eof click function
	});// eof ready function
</script>
<style>
#loading img
{
	width:60px;
}
#loading
{
	text-align:center;
}
</style>
<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;"> <a href="index.php" class="site_title"><i class="fa fa-laptop"></i> <span>Adminpanel</span></a> </div>
    <div class="clearfix"></div>
    
    <!-- menu prile quick info -->
    <div class="profile">
      <div class="profile_pic"> <img src="<?php echo PATH_IMAGE?>/img.jpg" alt="..." class="img-circle profile_img"> </div>
      <div class="profile_info"> <span>Welcome,</span>
        <h2><?php echo $_SESSION['admin_name']?></h2>
      </div>
    </div>
    <!-- /menu prile quick info --> 
    
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <div class="clearfix"></div>
        <ul class="nav side-menu">
          <li><a href="<?php echo LINK_CONTROL?>"><i class="fa fa-home"></i>Dashboard</a></li>
          
          <li><a><i class="fa fa-bed" aria-hidden="true"></i>Rooms<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo LINK_CONTROL?>/rooms-category/index.php">Add Category</a> </li>
              <li><a href="<?php echo LINK_CONTROL?>/rooms/index.php">Add Room</a> </li>
            </ul>
          </li>
          
          <li><a><i class="fa fa-newspaper-o" aria-hidden="true"></i>Latest News<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo LINK_CONTROL?>/latest-news/index.php">Add New</a> </li>
              <li><a href="<?php echo LINK_CONTROL?>/latest-news/list.php">View List</a> </li>
            </ul>
          </li>

          <li><a><i class="fa fa-newspaper-o" aria-hidden="true"></i>Offers<span class="fa fa-chevron-down"></span></a>
            <ul class="nav child_menu" style="display: none">
              <li><a href="<?php echo LINK_CONTROL?>/offers/index.php">Add New</a> </li>
              <li><a href="<?php echo LINK_CONTROL?>/offers/list.php">View List</a> </li>
            </ul>
          </li>
          
        </ul>
      </div>
    <div class="clearfix"></div>
    </div>
    <!-- /sidebar menu --> 
    
    
  </div>
</div>

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav class="" role="navigation">
      <div class="nav toggle"> <a id="menu_toggle"><i class="fa fa-bars"></i></a> </div>
      <ul class="nav navbar-nav navbar-right">
        <li class=""> <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <img src="<?php echo PATH_IMAGE?>/img.jpg" alt=""><?php echo $_SESSION['admin_name']?> <span class=" fa fa-angle-down"></span> </a>
          <ul class="dropdown-menu dropdown-usermenu animated fadeInDown pull-right">
           <!-- <li><a href="javascript:;"> Profile</a> </li>
            <li> <a href="javascript:;"> <span class="badge bg-red pull-right">50%</span> <span>Settings</span> </a> </li>-->
            <li> <a href="<?php echo LINK_CONTROL?>/change_password/index.php">Change Password</a></li>
            <li><a href="#" id="logoff"><i class="fa fa-sign-out pull-right"></i> Log Out</a> </li>
          </ul>
        </li>
        
          </ul>
        </li>
      </ul>
    </nav>
  </div>
</div>
<!-- /top navigation --> 
<!-- page content -->
<div class="right_col" role="main">