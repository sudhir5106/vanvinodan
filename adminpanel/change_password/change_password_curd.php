<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/resize.php');

$db = new DBConn();


///*******************************************************
/// To change Password for admin/////////////////////////////////
///*******************************************************

if($_POST['type']=="changePassword")
{	
	$con  = mysql_connect(SERVER, DBUSER, DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0', $con);
	mysql_query('START TRANSACTION', $con);
		
	try{		
			
			$tblname="tbl_admin_login";
			$tblfield=array('Login_Password');
			$tblvalues=array($_POST['new_pwd']);
			$condition="Login_Id=".$_POST['adminId'];
			$res=$db->updateValue($tblname,$tblfield,$tblvalues,$condition);
		
			if(!$res)
			{
				throw new Exception('0');
			}		
			
		 	mysql_query("COMMIT", $con);
			mysql_close($con);
			echo "Your Password Have been Changed Successfully";
			
	}
  catch (Exception $e)
	{
		echo $e->getMessage();
		mysql_query('ROLLBACK', $con);
		mysql_query('SET AUTOCOMMIT=1', $con);
		mysql_close($con);
	}
}


?>
