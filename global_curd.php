<?php 

include('config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/resize.php');
$db = new DBConn();

///*******************************************************
/// Get Base_Fare
///*******************************************************
if($_POST['type']=="getTotalAmt")
{
	$res = $db->ExecuteQuery("SELECT Base_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Base_Fare'];	
	
}

///*******************************************************
/// Get AC Amount
///*******************************************************
if($_POST['type']=="getACAmt")
{
	$res = $db->ExecuteQuery("SELECT Aircondition_Fare FROM tbl_rooms_category WHERE R_Category_Id=".$_REQUEST['roomType']);
	
	echo $res[1]['Aircondition_Fare'];	
	
}

///*******************************************************
/// Get list of available room type
///*******************************************************
if($_POST['type']=="getRooms"){
	
	$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare, Aircondition_Fare, Extra_Bed_Fare, Room_Info, Amenities FROM tbl_rooms_category
	
	WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
	WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' ))");
	
}
?>