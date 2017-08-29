<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

///*******************************************************
/// To Insert Room ////////////////////////////////
///*******************************************************
if($_POST['type']=="addRoom")
{
		$roomName = mysql_real_escape_string($_POST['roomName']);
		
		$tblname = "tbl_room_master";
		$tblfield=array('Room_Name', 'R_Category_Id');
		$tblvalues=array($roomName, $_POST['rcatname']);
		$res=$db->valInsert($tblname, $tblfield, $tblvalues);
		if(empty($res))
    	{
 	  		echo 0;
    	}
     	else
		{
	  		echo 1;
		}
}

///*******************************************************
/// Edit Room
///*******************************************************
if($_POST['type']=="editRoom")
{
		
	$roomName = mysql_real_escape_string($_POST['roomName']);
		
	$tblname = "tbl_room_master";
	$tblfield=array('Room_Name', 'R_Category_Id');
	$tblvalues=array($roomName, $_POST['rcatname']);
	$condition="Room_Id=".$_POST['id'];
	
	$res=$db->updateValue($tblname,$tblfield,$tblvalues,$condition);
	
	if (empty($res))
	{
		echo 0;
	}
	else
	{
		echo 1;
	}
}


///*******************************************************
/// Delete row from tbl_room_master table
///*******************************************************
if($_POST['type']=="delete")
{
			
	$tblname="tbl_room_master";
	$condition="Room_Id=".$_POST['id'];
	$res=$db->deleteRecords($tblname,$condition);
	
	if($res)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}
