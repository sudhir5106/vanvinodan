<?php 
include('../../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();


///*******************************************************
/// To Insert New category /////////////////////////////////
///*******************************************************
if($_POST['type']=="addVideo")
{
		$caption = mysql_real_escape_string($_POST['caption']);
		$videoLink = mysql_real_escape_string($_POST['videoLink']);
		
	    $tblfield=array('Video_Caption','Video_Link');
		$tblvalues=array($caption,$videoLink);
		$res=$db->valInsert("tbl_video_gallery",$tblfield,$tblvalues);
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
/// Edit Plant
///*******************************************************
if($_POST['type']=="editCategory")
{
	
	 $caption = mysql_real_escape_string($_POST['caption']);
	 $videoLink = mysql_real_escape_string($_POST['videoLink']);
	
	 $tblfield=array('Video_Caption','Video_Link');
	 $tblvalues=array($caption,$videoLink);
	 $condition="Video_Id=".$_POST['id'];
	 $res=$db->updateValue('tbl_video_gallery',$tblfield,$tblvalues,$condition);
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
/// Delete row from Plant table
///*******************************************************
if($_POST['type']=="delete")
{
	
	$tblname="tbl_video_gallery";
	$condition="Video_Id=".$_POST['id'];
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