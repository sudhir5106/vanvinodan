<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

$table = "tbl_admin_login";
$usrfield = "Login_Name";
$usrpassfield = "Login_Password";

$result = $db->checkLogin($table,$usrfield,$_POST['user'],$usrpassfield,$_POST['password']);

if(!empty($result)){
	
	$_SESSION['admin_name']=$result[1]['Login_Name'];
	$_SESSION['admin']=$result[1]['Login_Id'];
	
	echo "true";
}
else{
	echo "false";
}

?>