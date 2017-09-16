<?php

ini_set('display_errors',1);
$PayuMoney_BASE_URL = "https://test.payumoney.com/payment/merchant/refundPayment?";         /* This is for test mode
                                                                   For live mode use https://www.payumoney.com/payment/merchant/refundPayment?     */

$action = '';
$posted = array();
if(!empty($_POST)) {

  foreach($_POST as $key => $value) {
     
   $posted[$key] = htmlentities($value, ENT_QUOTES);
  }
  //var_dump($posted);
  
  $postData = array();
  $postData['merchantKey']=$posted['merchantKey'];
  unset($posted['merchantKey']);
  $postData['paymentId']=$posted['paymentId'];
  unset($posted['paymentId']);
  $postData['refundAmount']=$posted['refundAmount'];
  unset($posted['refundAmount']);
  $postNow = http_build_query($postData);

  //$postNow = $postNow .'&jsonSplits=['.$postNow.']';
  var_dump($postNow);
  $response = curlCall($PayuMoney_BASE_URL.$postNow,TRUE);
  var_dump($response);
  
}
/*foreach ($posted as $key => $value) {
    echo "posted[".$key."]=".$value."<br>";
}*/
//echo $posted;
$formError = 0;



function curlCall($postUrl, $toSend) {
   
  $ch = curl_init();
   curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $toSend);
  curl_setopt($ch, CURLOPT_URL, $postUrl);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

  $header = array(
     'Authorization: MLvb78E77ueK9oAyr3UgMdpcHkzOQedKSayVuqb+t44='    //Enter you Authorization header value here
  );
  curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
   
  $out = curl_exec($ch);
  //if got error
  if (curl_errno($ch)) {
    $c_error = curl_error($ch);
    if (empty($c_error)) {
      $c_error = 'Some server error';
    }
    return array('curl_status' => 'FAILURE', 'error' => $c_error);
  }
  $out = trim($out);
  return array('curl_status' => 'SUCCESS', 'result' => $out);
}


?>

<html>
  <body >
    <h2>PayuMoney Refund API</h2>
    <br/>
	
	<form action="<?php echo $action; ?>" method="post" name="PayuMoneyForm">
	
      <table>
        <tr>
          <td><b>Mandatory Parameters(For Refund API)</b></td>
        </tr>
		<tr>
          <td>Payment Id: </td>
          <td><input name="paymentId" id="paymentId=" value="<?php echo (empty($posted['paymentId='])) ? '' : $posted['paymentId=']; ?>" /></td>
        </tr>
		<tr>
          <td>Refund Amount</td>
          <td><input name="refundAmount" id="refundAmount" value="<?php echo (empty($posted['refundAmount'])) ? '' : $posted['refundAmount']; ?>" /></td>
        </tr>
		<tr>
          <td>Merchant Key</td>
          <td><input name="merchantKey" id="merchantKey" value="<?php echo (empty($posted['merchantKey'])) ? '' : $posted['merchantKey']; ?>" /></td>
        </tr>
		</table>
		<input type="submit" value="submit"/>
    </form>

  </body>
</html>
