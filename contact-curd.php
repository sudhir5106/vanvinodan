<?php

error_reporting(0);

///*******************************************************
/// Contact Form Submition /////////////////////////////////
///*******************************************************
if($_POST['type']=="feedbackInfo")
{
	///******************************************************************************************
	///////////////////////After Feedback Form is Submition Email Send /////////////////////////
	//******************************************************************************************
					
	//$to  ='mail@fsnl.nic.in/';
	$to  ='sudhir5106@gmail.com/';  
	
	// subject ///////////////////////////////////////
	$subject = 'Feedback - FSNL Website';
	// message ////////////////////////////////////////////////
	$message = "
					Dear FSNL Team,
					<br>
					<br>
					You Getting A Mail 
					<br>
						Name = ".$_POST['name']."
					<br>
					<br>
						Email = ".$_POST['email']."
					<br>
					<br>
						Phone = ".$_POST['phone']."
					<br>
					<br>
						Message  = ".$_POST['mgs'];
	
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
	$headers .= 'From: FSNL <'.trim($_POST['email']).'>' . "\r\n";
	
	mail($to, $subject, $message, $headers);
	
	echo 1;
}

?>