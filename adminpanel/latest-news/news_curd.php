<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/resize.php');
$db = new DBConn();

///*******************************************************
/// To Insert Latest News ////////////////////////////////
///*******************************************************
if($_POST['type']=="addNews")
{
	$selecteddate = strtr($_REQUEST['published_date'], '/', '-');
	$date=date('Y-m-d',strtotime($selecteddate));
	
	$newstitle = mysql_real_escape_string($_POST['newstitle']);
	$desc = mysql_real_escape_string($_POST['desc']);
	
	////////////////////////////////////////////
	// Path for latest news photo //////////////
	////////////////////////////////////////////
	$path = ROOT."/images/latest-news/";
	$path1 = ROOT."/images/latest-news/thumb/";	
	
	$name = $_FILES['file']['name'];
	$image=explode('.',$name);
	$actual_image_name = time().'.'.$image[1]; // rename the file name
	$tmp = $_FILES['file']['tmp_name'];
	
	if(move_uploaded_file($tmp, $path.$actual_image_name)){
		
		///////////////////////////////////////////////////////////
		// move the image in the data_images/student/thumb folder
		///////////////////////////////////////////////////////////
		$resizeObj1 = new resize($path.$actual_image_name);
		$resizeObj1 -> resizeImage(200, 200, 'auto');
		$resizeObj1 -> saveImage($path1.$actual_image_name, 100);
		
		//**************************************
		// Code for insertion //////////////////
		//**************************************
		$tblname = "tbl_latest_news";
		$tblfield=array('Date', 'News_Title', 'News_Image', 'Description', 'Status');
		$tblvalues=array($date, $newstitle, $actual_image_name, $desc, 1);
		$res=$db->valInsert($tblname, $tblfield, $tblvalues);
		
		if(empty($res))
		{
			echo 0;
		}
		else
		{
			echo 1;
		}
	}//eof if condition
		
}//eof if condition

///*******************************************************
/// Edit News ////////////////////////////////////////////
///*******************************************************
if($_POST['type']=="editNews")
{
	////////////////////////////////////////////
	// Path for latest news photo //////////////
	////////////////////////////////////////////
	$path = ROOT."/images/latest-news/";
	$path1 = ROOT."/images/latest-news/thumb/";
	
	$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0',$con);
	mysql_query('START TRANSACTION',$con);
	
	try
	{
		//Upload Here News Image	
		if($_REQUEST['imageval']==1)
		{
			$gallary = $_FILES['image']['name'];		
			$tmp2 = $_FILES['image']['tmp_name'];
			$image=explode('.',$gallary);
			$gallary_image = time().'.'.$image[1]; // rename the file name
			
			if(move_uploaded_file($tmp2, $path.$gallary_image))
			  {
				// move the image in the thumb folder
				$resizeObj1 = new resize($path.$gallary_image);
				$resizeObj1 ->resizeImage(50,50,'auto');
				$resizeObj1 -> saveImage($path1.$gallary_image, 100);
				
			  }
			  
			  //Delete Old Image from folder
			  $remove=$db->ExecuteQuery("SELECT News_Image FROM tbl_latest_news WHERE Id=".$_REQUEST['id']);
			  if(count($remove)>0 )
			  {
				  if(file_exists($path.$remove[1]['News_Image']) && $remove[1]['News_Image']!='')
				  {
						unlink($path.$remove[1]['News_Image']);
						unlink($path1.$remove[1]['News_Image']);
				  }
			  }
		}
		else
		{
			//if Image Is Empty Than
			$gallary_image = $_REQUEST['news-img'];
		}
		
		$selecteddate = strtr($_REQUEST['published_date'], '/', '-');
		$date=date('Y-m-d',strtotime($selecteddate));
		$title = mysql_real_escape_string($_POST['newstitle']);
		$desc = mysql_real_escape_string($_POST['desc']);
		
		//**********************************
		// Update tbl_latest_News Table ////
		//**********************************
		$tblname="tbl_latest_news";		
		$tblfield=array('Date','News_Title','News_Image','Description');		
		$tblvalues=array($date, $title, $gallary_image, $desc);		
		$condition="Id=".$_POST['id'];
		$res=$db->updateValue($tblname,$tblfield,$tblvalues,$condition);
		
		if (empty($res)) 
		{
			throw new Exception('0');
		}
		
		mysql_query("COMMIT",$con);
		echo 1;
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
	}
}//eof if condition


///*******************************************************
/// Delete row from tbl_latest_news table
///*******************************************************
if($_POST['type']=="delete")
{
			
	////////////////////////////////////////////
	// Path for latest news photo //////////////
	////////////////////////////////////////////
	$path = ROOT."/images/latest-news/";
	$path1 = ROOT."/images/latest-news/thumb/";
	
	$newsimg=$db->ExecuteQuery("SELECT News_Image FROM tbl_latest_news WHERE Id=".$_POST['id']);
		
	$tblname="tbl_latest_news";
	$condition="Id=".$_POST['id'];
	$res=$db->deleteRecords($tblname,$condition);
	
	if($res)
	{
		if(!empty($newspdf[1]['News_Image'])){
			unlink($path.$newsimg[1]['Page_Link']);
			unlink($path1.$newsimg[1]['Page_Link']);
		}
		
		echo 1;
	}
	else
	{
		echo 0;
	}
}

///*******************************************************
/// Change Status (Hide or Show) ////////////////////
///*******************************************************
if($_POST['type']=="changeStatus")
{	
	$id = explode("-", $_POST['id']);
	$tblName = "tbl_latest_news";
	$tablField = "Status";
	$conditionField = "Id";
	
	$db->Status($id[1], $tblName, $tablField, $conditionField);	
	
}