<?php
class Send
{
  public function Sms($contactno,$content)
  {
     
	//$authKey = "74958A2tgaMyx547717dd"; //thelift club sms api key 
	$authKey = "84713A9JSRj3qtNl5551c9d6"; //thefly club sms api key 

	//Multiple mobiles numbers seperated by comma
	$mobileNumber = $contactno;



//Your message to send, Add URL endcoding here.
$message = urlencode($content);
//Define sender id
$senderId = "TheFly";
//Define route 
$route = "template";
//Prepare your post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
	'sender'=> $senderId,
    'route' => $route
);

//API URL
$url="https://control.msg91.com/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

//get response
$output = curl_exec($ch);

curl_close($ch);

return $output;
  }
  
  
   
}
?>
