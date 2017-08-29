<?php 
include('../../config.php');
require_once(PATH_ADMIN_INCLUDE.'/head.php');


?>

<script>
document.onkeydown = function(event) {
   	if (event.keyCode == 13) {
       $("#loginsubmit").trigger("click");
  		}
	}
</script>



<script>
$(document).ready(function(){
	$("#msg").hide();
	$("#loginsubmit").click(function()
	{
		$("#msg").hide();
		$("#msg").text('');
		var user_name =$("#user").val();
		var password =$("#password").val();
		
		if (user_name=="")
		{
			$("#msg").append("<strong>Warning!</strong> Enter User Name");
			$("#msg").show();
			return false;
		}
		if (password=="")
		{
			$("#msg").append("<strong>Warning!</strong> Enter Password");
			$("#msg").show();
			return false;
		}
		var x;
		$.ajax(
		{
			url:'check_login.php',
			type:'POST',
			data:{user:user_name, password:password},
			success:function(data){ //alert(data);
				x=data;
				
				if(x=="true")
				{
					document.location.href="<?php echo LINK_CONTROL?>/index.php";
				}
				else
				{
					$("#msg").append("<strong>Warning!</strong> Incorrect Username/Password!");
					$("#msg").show();
				}
				
			}
		});
		
	});
});
</script>

<body style="background:#F7F7F7;">

  <div class="">
    <!--<a class="hiddenanchor" id="toregister"></a>
    <a class="hiddenanchor" id="tologin"></a>
-->
    <div id="wrapper">
      <div id="login" class="animate form">
        <section class="login_content">
          <form action="" method="post" name="loginform" id="loginform">
            <h1>Admin Login Panel</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" id="user"/>
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" id="password"/>
            </div>
            <div>
              <a class="btn btn-default submit" href="#" id="loginsubmit" >Log in</a>
              <!--<a class="reset_pass" href="#">Lost your password?</a>-->
            </div>
            <div class="clearfix"></div>
            <div id="msg"></div>
            <div class="separator"></div>
            <!--<div class="separator">

              <p class="change_link">New to site?
                <a href="#toregister" class="to_register"> Create Account </a>
              </p>
              <div class="clearfix"></div>
              <br />
              <div>
                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
              </div>
            </div>-->
          </form>
          <!-- form -->
        </section>
        <!-- content -->
      </div>
    <!--  <div id="register" class="animate form">
        <section class="login_content">
          <form>
            <h1>Create Account</h1>
            <div>
              <input type="text" class="form-control" placeholder="Username" required="" />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" required="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Password" required="" />
            </div>
            <div>
              <a class="btn btn-default submit" href="index.html">Submit</a>
            </div>
            <div class="clearfix"></div>
            <div class="separator">

              <p class="change_link">Already a member ?
                <a href="#tologin" class="to_register"> Log in </a>
              </p>
              <div class="clearfix"></div>
              <br />
              <div>
                <h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

                <p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
              </div>
            </div>
          </form>
         
        </section>
        
      </div>-->
    </div>
  </div>

</body>

</html>
