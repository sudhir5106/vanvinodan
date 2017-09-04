<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

///*******************************************************
/// To Insert Category ////////////////////////////////
///*******************************************************
if($_POST['type']=="addRoomCategory")
{
		$rcatname = mysql_real_escape_string($_POST['rcatname']);
		$desc = mysql_real_escape_string($_POST['desc']);
		$amenities = mysql_real_escape_string($_POST['amenities']);
		
		$tblname = "tbl_rooms_category";
		$tblfield=array('R_Category_Name', 'R_Capacity', 'Base_Fare', 'Extra_Guest_Fare', 'Room_Info', 'Amenities');
		$tblvalues=array($rcatname, $_POST['capacity'], $_POST['basefare'], $_POST['extraguestfare'], $desc, 
		$amenities);
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
/// Edit Category
///*******************************************************
if($_POST['type']=="editRoomCategory")
{
		
	$rcatname = mysql_real_escape_string($_POST['rcatname']);
	$desc = mysql_real_escape_string($_POST['desc']);
	$amenities = mysql_real_escape_string($_POST['amenities']);
		
	$tblname = "tbl_rooms_category";
	$tblfield=array('R_Category_Name', 'R_Capacity', 'Base_Fare', 'Extra_Guest_Fare', 'Room_Info', 'Amenities');
	$tblvalues=array($rcatname, $_POST['capacity'], $_POST['basefare'], $_POST['extraguestfare'], $desc, $amenities);
	$condition="R_Category_Id=".$_POST['id'];
	
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
/// Delete row from tbl_rooms_category table
///*******************************************************
if($_POST['type']=="delete")
{
			
	$tblname="tbl_rooms_category";
	$condition="R_Category_Id=".$_POST['id'];
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
