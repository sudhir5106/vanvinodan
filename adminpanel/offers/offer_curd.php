<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/classes/resize.php');
$db = new DBConn();

///*******************************************************
/// To Insert Latest News ////////////////////////////////
///*******************************************************
if($_POST['type']=="addOffer")
{
	$date1 = strtr($_REQUEST['published_date'], '/', '-');
	$publishedDate=date('Y-m-d',strtotime($date1));

	$date2 = strtr($_REQUEST['expiry_date'], '/', '-');
	$expiryDate=date('Y-m-d',strtotime($date2));
	
	$offertitle = mysql_real_escape_string($_POST['offertitle']);
	
	
	////////////////////////////////////////////
	// Path for latest news photo //////////////
	////////////////////////////////////////////
	$path = ROOT."/images/offers/";
	$path1 = ROOT."/images/offers/thumb/";	
	
	$name = $_FILES['file']['name'];
	$image=explode('.',$name);
	$actual_image_name = time().'.'.$image[1]; // rename the file name
	$tmp = $_FILES['file']['tmp_name'];
	
	if(move_uploaded_file($tmp, $path.$actual_image_name)){
		
		///////////////////////////////////////////////////////////
		// move the image into the offers/thumb folder ////////////
		///////////////////////////////////////////////////////////
		$resizeObj1 = new resize($path.$actual_image_name);
		$resizeObj1 -> resizeImage(200, 200, 'auto');
		$resizeObj1 -> saveImage($path1.$actual_image_name, 100);
		
		//**************************************
		// Code for insertion //////////////////
		//**************************************
		$tblname = "tbl_offers";
		$tblfield=array('Offer_Name', 'Published_Date', 'Expired_Date', 'Offer_Image', 'Status');
		$tblvalues=array($offertitle , $publishedDate, $expiryDate, $actual_image_name, 1);
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
if($_POST['type']=="editOffer")
{
	////////////////////////////////////////////
	// Path for Offer Image ////////////////////
	////////////////////////////////////////////
	$path = ROOT."/images/offers/";
	$path1 = ROOT."/images/offers/thumb/";
	
	$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0',$con);
	mysql_query('START TRANSACTION',$con);
	
	try
	{
		//*****************************************
		//Upload Offer Image //////////////////////
		//*****************************************
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
			  $remove=$db->ExecuteQuery("SELECT Offer_Image FROM tbl_offers WHERE Offer_Id=".$_REQUEST['id']);
			  if(count($remove)>0 )
			  {
				  if(file_exists($path.$remove[1]['Offer_Image']) && $remove[1]['Offer_Image']!='')
				  {
						unlink($path.$remove[1]['Offer_Image']);
						unlink($path1.$remove[1]['Offer_Image']);
				  }
			  }
		}
		else
		{
			//if Image Is Empty Than
			$gallary_image = $_REQUEST['offer-img'];
		}
		
		$date1 = strtr($_REQUEST['published_date'], '/', '-');
		$publishedDate=date('Y-m-d',strtotime($date1));

		$date2 = strtr($_REQUEST['expiry_date'], '/', '-');
		$expiryDate=date('Y-m-d',strtotime($date2));
		
		$title = mysql_real_escape_string($_POST['offertitle']);
		
		
		//**********************************
		// Update tbl_offers Table /////////
		//**********************************
		$tblname="tbl_offers";		
		$tblfield=array('Offer_Name','Published_Date','Expired_Date','Offer_Image');		
		$tblvalues=array($title, $publishedDate, $expiryDate, $gallary_image);		
		$condition="Offer_Id=".$_POST['id'];
		$res=$db->updateValue($tblname,$tblfield,$tblvalues,$condition);
		
		if (empty($res)) 
		{
			throw new Exception('a');
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
/// Delete row from tbl_offers table /////////////////////
///*******************************************************
if($_POST['type']=="delete")
{
			
	////////////////////////////////////////////
	// Path for latest news photo //////////////
	////////////////////////////////////////////
	$path = ROOT."/images/offers/";
	$path1 = ROOT."/images/offers/thumb/";
	
	$newsimg=$db->ExecuteQuery("SELECT Offer_Image FROM tbl_offers WHERE Offer_Id=".$_POST['id']);
		
	$tblname="tbl_offers";
	$condition="Offer_Id=".$_POST['id'];
	$res=$db->deleteRecords($tblname,$condition);
	
	if($res)
	{
		if(!empty($newspdf[1]['Offer_Image'])){
			unlink($path.$newsimg[1]['Offer_Image']);
			unlink($path1.$newsimg[1]['Offer_Image']);
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
	$tblName = "tbl_offers";
	$tablField = "Status";
	$conditionField = "Offer_Id";
	
	$db->Status($id[1], $tblName, $tablField, $conditionField);		
}