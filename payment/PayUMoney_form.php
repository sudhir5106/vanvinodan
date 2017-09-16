<?php
include('../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
require_once('../header.php');
$getid=$_REQUEST['id'];		

//*******************************************************************
//Get Payment Gateway Details ///////////////////////////////////////
//*******************************************************************
$paymentGateway=$db->ExecuteQuery("SELECT Company_Name, Merchant_Key, Salt_Key FROM `tbl_payment_gateway_detail` 
WHERE `Status`=1");
//*******************************************************************
		
$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
mysql_query('SET AUTOCOMMIT=0',$con);
mysql_query('START TRANSACTION',$con);
 		
try
{
	//*******************************
	//Decode Reservation Id  ////////
	//*******************************
	$Id = base64_decode($getid);		
	//*******************************
	
	//////////////////////////////////////////////////////////
	//Get The Resrvation Details /////////////////////////////
	//////////////////////////////////////////////////////////
	$sql = "SELECT Reservation_Ref_No, DATE_FORMAT(Check_In_Date,'%d-%m-%Y') AS Check_In_Date, DATE_FORMAT(Check_Out_Date,'%d-%m-%Y') AS Check_Out_Date, Grand_Total_Amt, Client_Name, Email, Phone FROM tbl_reservation	
	WHERE Reservation_Id =".$Id;
	
	$getDetails=$db->ExecuteQuery($sql);
	
	if(!$getDetails)
	{
		throw new Exception('a');
	}
		
	mysql_query("COMMIT",$con);
	
}
catch(Exception $e)
{
	echo  $e->getMessage();
	mysql_query('ROLLBACK',$con);
	mysql_query('SET AUTOCOMMIT=1',$con);
	
}

mysql_close($con);
		
/////////////////////////////////////////////////////
// PayUMoney Code	/////////////////////////////////
/////////////////////////////////////////////////////
// Merchant Salt as provided by Payu
$MERCHANT_KEY = $paymentGateway[1]['Merchant_Key'];
// Merchant Salt as provided by Payu
$SALT =  $paymentGateway[1]['Salt_Key'];

// End point - change to https://secure.payu.in for LIVE mode
//$PAYU_BASE_URL = "https://test.payu.in"; //for test 
$PAYU_BASE_URL = "https://secure.payu.in"; // for vanvinodan

$action = '';

$posted = array();
if(!empty($_POST)) {
  //print_r($_POST);
  foreach($_POST as $key => $value) {    
    $posted[$key] = $value; 	
  }
}

$formError = 0;
$txnid=$getid;

$hash = '';

//****************************************************************
// Hash Sequence /////////////////////////////////////////////////
//****************************************************************
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
//****************************************************************

if(empty($posted['hash']) && sizeof($posted) > 0) {
	
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone']) 
		  || empty($posted['productinfo'])         
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
    )
  {
	  $formError = 1;
  }//eof if condition 
  else
  {  
		$hashVarsSeq = explode('|', $hashSequence);
		$hash_string = '';
		
		foreach($hashVarsSeq as $hash_var) {
		  $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
		  $hash_string .= '|';
		}//eof foreach loop
	
		$hash_string .= $SALT;	
	
		$hash = strtolower(hash('sha512', $hash_string));
		$action = $PAYU_BASE_URL . '/_payment';	
	
  }//eof else
  
}//eof if condition
elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}//eof ifelse 
?>

<script>
	var hash = '<?php echo $hash ?>';
	function submitPayuForm() {
		
	  if(hash == '') {
		return;
	  }
	  var payuForm = document.forms.payuForm;
	  payuForm.submit();	  
	}
</script>

<main>    
    <div class="middle-container">
        <div class="container">
        	<h1 class="innerTitle">Reservation &amp; Payment Details</h1>
        	<div class="innerPageTxt">
                <section id="form">
                    <div class="contents">
                        <?php if($formError) { ?>
                        <div class="alert alert-danger">Please fill all <strong>mandatory fields.</strong></div>
                        <?php } ?>
                        
                        <div class="row">
                        	<form action="<?php echo $action; ?>" method="post" name="payuForm">                                
                                  <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                                  <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                                  <input type="hidden" name="txnid" value="<?php echo $txnid?>" />
                                  
                                  <?php  
                                       $surl='http://'.$_SERVER['SERVER_NAME'].LINK_ROOT.'/payment/payment-success.php';
                                       $furl='http://'.$_SERVER['SERVER_NAME'].LINK_ROOT.'/payment/payment-failure.php';
                                  ?>
                                   
                                  <div class="payment-info">
                                  		
                                        <div style="display:none;">
                                        	Amount: <input type="text" name="amount" value="<?php echo (empty($getDetails[1]['Grand_Total_Amt'])) ? '' :$getDetails[1]['Grand_Total_Amt']?>" /><br />
                                            Name: <input type="text" name="firstname" id="firstname" value="<?php echo (empty($getDetails[1]['Client_Name']))? '' : $getDetails[1]['Client_Name']; ; ?>" /><br />
                                            Email: <input type="text" name="email" id="email" value="<?php echo (empty($getDetails[1]['Email'])) ? '' : $getDetails[1]['Email']; ?>" /><br />
                                            Phone: <input type="text" name="phone" value="<?php echo (empty($getDetails[1]['Phone'])) ? '' : $getDetails[1]['Phone']; ?>" /><br />
                                            Product Info:<textarea name="productinfo"><?php echo 'Room(s) Booking on van vinodan resort'?></textarea><br />
                                   			Success URL: <input  type="text" name="surl" value="<?php echo (empty($surl)) ? '' : $surl ?>" size="64" /><br />
                                            Failure URL: <input type="text" name="furl" value="<?php echo (empty($furl)) ? '' : $furl ?>" size="64" /><br />
                                            <input  type="hidden"  name="service_provider" value="payu_paisa" size="64" />
                                        </div>
                                  
                                  
										<div>
                                        	<strong>Name:</strong> <?php echo $getDetails[1]['Client_Name']; ?><br />
                                            <strong>Check-In Date:</strong> <?php echo $getDetails[1]['Check_In_Date']; ?> - 
                                            <strong>Check-Out Date:</strong> <?php echo $getDetails[1]['Check_Out_Date']; ?>
                                            
                                            
                                        </div>
                                        
                                        
                                        <div class="table-responsive">
                                      		<table class="table">
                                                <tr>
                                                  <td class="active"><strong>Payment Method :</strong></td>
                                                  <td>Online</td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Payment Gateway :</strong></td>
                                                  <td>PayUMoney</td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Total Reservation Amount:</strong></td>
                                                  <td><i class="fa fa-inr"></i> <?php echo $getDetails[1]['Grand_Total_Amt']; ?></td>
                                                </tr>
                                                
                                                <tr>
                                                  <?php if(!$hash) { ?>
                                                  <td colspan="4" align="center"><input type="submit"  class="btn btn-lg btn-success" value="Pay by Net Banking/ Credit Card/ Debit Card " /></td>
                                                  <?php } ?>
                                                </tr>
                                            </table>
                                  		</div>
                                  </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>  	
</main>

<?php include('../footer.php');?>

