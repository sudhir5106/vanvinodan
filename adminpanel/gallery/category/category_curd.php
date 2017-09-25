<?php 
include('../../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

///*******************************************************
/// Validate that the data already exist or not
///*******************************************************
if($_POST['type']=="validate")
{

	$sql="SELECT Category_Name FROM tbl_category WHERE Category_Name='".$_POST['cate_name']."'";
	$res=$db->ExecuteQuery($sql);
		
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
/// Validate that the data already exist or not
///*******************************************************
if($_POST['type']=="validate2")
{

	$sql="SELECT Category_Name FROM tbl_category WHERE Category_Name='".$_POST['cate_name']."' and Category_Id<>'".$_REQUEST['id']."'";
	$res=$db->ExecuteQuery($sql);
		
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
/// To Insert New category /////////////////////////////////
///*******************************************************
if($_POST['type']=="addCategory")
{
	
	    $tblfield=array('Category_Name');
		$tblvalues=array($_POST['cate_name']);
		$res=$db->valInsert("tbl_category",$tblfield,$tblvalues);
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
	 $tblfield=array('Category_Name');
	 $tblvalues=array($_POST['cate_name']);
	 $condition="Category_Id=".$_POST['id'];
	 $res=$db->updateValue('tbl_category',$tblfield,$tblvalues,$condition);
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
	$res=$db->ExecuteQuery("Select Sub_Id from tbl_category CG INNER JOIN sub_category SC ON SC.Category_Id=CG.Category_Id where CG.Category_Id=".$_POST['id']."");
	
	//Check HEre If Category  is used than you can not delete the row
	 if(count($res)==0)
	 {
		$tblname="tbl_category";
		$condition="Category_Id=".$_POST['id'];
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
	 else
	 {
	
		echo 0;
	}
}