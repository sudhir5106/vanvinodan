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
	$sql = "SELECT Reservation_Ref_No, Check_In_Date, Check_Out_Date, Grand_Total_Amt, Client_Name, Email, Phone FROM tbl_reservation	
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

/*if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}*/
//$txnid=$getid;
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
		//$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
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
        <div class="innerPageTxt">
        	<div class="container">
            	<h1>Payment</h1>
                
                <section id="form">
                <!--form-->
                <div class="container">
                    <div class="row">
                    
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="content-wrapper">
                              <section class="content-header">
                                <h3> Pay </h3>
                              </section>
                              <div class="content">
                                <?php if($formError) { ?>
                                <span style="color:red; margin-bottom:20px; margin-top:20px;">Please fill all mandatory fields.</span>
                                <?php } ?>
                                <div class="row">
                                  <div>
                                    <div class="box box-primary">
                                      <div class="box-header with-border">
                                        <h3 class="box-title"> </h3>
                                      </div>
                                      <div class="box-body">
                                        <form action="<?php echo $action; ?>" method="post" name="payuForm">
                                        
                                          <input type="text" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                                          <input type="text" name="hash" value="<?php echo $hash ?>"/>
                                          <input type="text" name="txnid" value="<?php echo $txnid?>" />
                                          <?php  
                                               $surl='http://'.$_SERVER['SERVER_NAME'].LINK_ROOT.'/payment/payment-success.php';
                                               $furl='http://'.$_SERVER['SERVER_NAME'].LINK_ROOT.'/payment/payment-failure.php';
                                           ?>
                                           
                                          <div class="col-md-9 col-md-offset-1">
                                            <div class="table-responsive">
                                              <table class="table table-bordered">
                                                <tbody  style="display:block">
                                                  <tr>
                                                    <td><b>Mandatory Parameters</b></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Amount: </td>
                                                    <td><input type="text" name="amount" value="<?php echo (empty($getDetails[1]['Grand_Total_Amt'])) ? '' :$getDetails[1]['Grand_Total_Amt']?>" /></td>
                                                    <td>Name: </td>
                                                    <td><input type="text" name="firstname" id="firstname" value="<?php echo (empty($getDetails[1]['Client_Name']))? '' : $getDetails[1]['Client_Name']; ; ?>" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Email: </td>
                                                    <td><input type="text" name="email" id="email" value="<?php echo (empty($getDetails[1]['Email'])) ? '' : $getDetails[1]['Email']; ?>" /></td>
                                                    <td>Phone: </td>
                                                    <td><input type="text" name="phone" value="<?php echo (empty($getDetails[1]['Phone'])) ? '' : $getDetails[1]['Phone']; ?>" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Product Info: </td>
                                                    <td colspan="3"><textarea name="productinfo"><?php echo 'Room(s) Booking on van vinodan resort'?></textarea></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Success URI: </td>
                                                    <td colspan="3"><input  type="text" name="surl" value="<?php echo (empty($surl)) ? '' : $surl ?>" size="64" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td>Failure URI: </td>
                                                    <td colspan="3"><input type="text" name="furl" value="<?php echo (empty($furl)) ? '' : $furl ?>" size="64" /></td>
                                                  </tr>
                                                  <tr>
                                                    <td colspan="3"><input  type="hidden"  name="service_provider" value="payu_paisa" size="64" /></td>
                                                  </tr>
                                                </tbody>
                                                
                                                <!---------------------------------------------------------------------------------------------
                                               for display order ----------------------------------------------------------------------------------------------->
                                                
                                                <tr>
                                                  <td class="active"><strong>Payment Method :</strong></td>
                                                  <td>Online</td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Payment Gateway :</strong></td>
                                                  <td>PayUMoney</td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Total Payble Amount:</strong></td>
                                                  <td><i class="fa fa-inr"></i> <?php echo (empty($getDetails[1]['Grand_Total_Amt'])) ? '' : $getDetails[1]['Grand_Total_Amt']; ?></td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Check-In Date:</strong></td>
                                                  <td><?php echo (empty($getDetails[1]['Check_In_Date'])) ? '' : $getDetails[1]['Check_In_Date']; ?></td>
                                                </tr>
                                                <tr>
                                                  <td class="active"><strong>Check-Out Date:</strong></td>
                                                  <td><?php echo (empty($getDetails[1]['Check_Out_Date'])) ? '' : $getDetails[1]['Check_Out_Date']; ?></td>
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
                                  </div>
                                </div>
                              </div>
                            </div>
                        <!--middle containar start here-->
                        </div>
                    </div>
                </div>
                </section>
                
            </div>
        </div>
    </div>  	
</main>

<?php include('../footer.php');?>

