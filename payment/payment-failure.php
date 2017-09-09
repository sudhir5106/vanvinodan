<?php
include('../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
include(PATH_INCLUDE.'/header.php');
error_reporting(0);	 
///******************************** pay U Money Code *****************************************///

 $con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	   mysql_query('SET AUTOCOMMIT=0',$con);
	   mysql_query('START TRANSACTION',$con);
		try
			{
				$status=$_POST["status"];
				$firstname=$_POST["firstname"];
				$amount=$_POST["amount"];
				$txnid=$_POST["txnid"];
				$posted_hash=$_POST["hash"];
				$key=$_POST["key"];
				$productinfo=$_POST["productinfo"];
				$email=$_POST["email"];
				$salt="8nLWOyBc";
				$mode=$_POST['mode'];
				$payuMoneyId=$_POST['payuMoneyId'];

				if(isset($_POST["additionalCharges"]))
				 {
      				 $additionalCharges=$_POST["additionalCharges"];
        			 $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
        
                  }
				  else 
				  {	  

       				 $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;

        			}
		
					$hash = hash("sha512", $retHashSeq);
        
		 			 $Id = explode("-",base64_decode($txnid));	
		   			 $_SESSION['user']=$Id[1];
					  //#########################################################################
					 //#################### Check Here Member Associated or not ################
					 
					  $perDetails=$db->ExecuteQuery("SELECT User_Id,Pin_Type,First_Name FROM customer_login WHERE Login_Id='".$Id[1]."' AND Active=1");
					 if(count($perDetails)>0)
					 {
						 if($perDetails[1]['Pin_Type']>0)
						 {
							$_SESSION['creUserId']	=	$perDetails[1]['User_Id'];
						 }
					 }
					 $_SESSION['username']=$perDetails[1]['First_Name'];
					 
      				 if ($hash != $posted_hash)
					 {
		   
	      				 //echo "Invalid Transaction. Please try again";
						 throw new Exception('0');
		  	   			
		  			 }
	  				 else 
					 {
         
						///********** for database (starts) *****************************///   
		  
						///////////////////////////////////
						///// Query for payment status( not reload page)
						////////////////////////////////////	
				
						
						$paymentCheck=$db->ExecuteQuery("SELECT EXISTS (SELECT 1 FROM order_main WHERE Pay_Status=0 AND Order_Id=".$Id[0]." AND Login_Id=".$Id[1].") as 'find' ");
						
				
						if($paymentCheck[1]['find']==1)
						{
							
							///////////////////////////////////
							///// update transection detail after transection
							////////////////////////////////////	
							
							$res=mysql_query("UPDATE order_main SET Transaction_Id='".$txnid."',	Transaction_Date=TIMESTAMPADD(MINUTE, 330,NOW()),Payment_Id='".$payuMoneyId."',Payment_Status='".$status."',Payment_Mode='".$mode."', Pay_Status=0  WHERE Order_Id=".$Id[0]." AND Login_Id=".$Id[1]."");
							
							if(!$res)
							{
								/*echo mysql_error();
								exit;
*/								throw new Exception('0');
							}
							
							
							  
						} //if closing (payment status for transection and no reload page )
					 }
			
			mysql_query("COMMIT",$con);
			echo '<script type="text/javascript">window.location.href="failure-report.php?id='.$txnid.'";</script>';
		}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
		if( $e->getMessage()==0)
		{
			echo '<script type="text/javascript">window.location.href="invalid_trans.php";</script>';
		}

		
	mysql_close($con);
}
?>
<script type="text/javascript">
$(window).load(function() {
	$(".loader").fadeOut("slow");
	$('.try').show();
})
</script>
<!--<style type="text/css">
.loader {
	position: fixed;
	left: 0px;
	top: 0px;
	width: 100%;
	height: 100%;
	z-index: 9999;
	background: url('<?php echo PATH_IMAGE?>/loading.gif') 50% 50% no-repeat rgb(249,249,249);
}
</style>-->
<body style="background:#fff;">
<?php //$_SESSION['CustomerId']=$Id[1];?>
<div style="margin:50px auto; width:150px; padding-bottom:30px;"> <a class="navbar-brand"  style="padding-top:4px" href='<?php echo LINK_ROOT."/index.php"?>'>Crestera<!--<img src="<?php //echo PATH_IMAGE ?>/logo.png"  />--></a></div>
<br />
<div class="container">
  <div class="row">
  <div class="loader">
    <div class="col-sm-12 " align="center">
    <img src="<?php echo PATH_IMAGE?>/loading.gif" style="width:200px">
      <h4 class="text-center"> Please wait while your transaction is processing, and do not refresh or close the page until your transaction completed</h4>
    </div>
    </div> 
    <div class="col-sm-12 try" align="center" style="display:none"><a href="PayUMoney_form.php?id=<?php echo $txnid;?>" >Try Again</a></div>
  </div>
</div>
</body>


<?php include(PATH_INCLUDE.'/footer.php'); ?>