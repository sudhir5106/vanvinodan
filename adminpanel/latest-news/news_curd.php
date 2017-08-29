<?php 
include('../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

///*******************************************************
/// To Insert Latest News ////////////////////////////////
///*******************************************************
if($_POST['type']=="addNews")
{
		$selecteddate = strtr($_REQUEST['date'], '/', '-');
		$date=date('Y-m-d',strtotime($selecteddate));
		$title = mysql_real_escape_string($_POST['heading']);
		$desc = mysql_real_escape_string($_POST['desc']);
		
		//PDF File Path
		$path = ROOT."/pdf/latest-news/english/";
		$path_h = ROOT."/pdf/latest-news/hindi/";
		
		//Upload Here News Document	
		if($_REQUEST['pdfval']==1)
		{
			$newsfile = $_FILES['pdf']['name'];		
			$tmp = $_FILES['pdf']['tmp_name'];
			$pdf = explode('.',$newsfile);
			$news_doc = time().'.'.$pdf[1]; // rename the file name
			move_uploaded_file($tmp, $path.$news_doc);	
		}
		else{
			$news_doc = '';	
		}
		
		if($_REQUEST['pdfval_h']==1)
		{
			$newsfile_h = $_FILES['pdf_h']['name'];		
			$tmp_h = $_FILES['pdf_h']['tmp_name'];
			$pdf_h = explode('.',$newsfile_h);
			$news_doc_h = time().'.'.$pdf_h[1]; // rename the file name
			move_uploaded_file($tmp_h, $path_h.$news_doc_h);
		}
		else{
			$news_doc_h = '';	
		}	
	
	    $tblname = "tbl_latest_news";
		$tblfield=array('Date', 'Heading', 'Page_Link', 'Description', 'H_Heading', 'H_Page_Link', 'H_Description', 'Status');
		$tblvalues=array($date, $title, $news_doc, $desc, $_POST['h_heading'], $news_doc_h, $_POST['h_desc'], 1);
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
/// Edit News
///*******************************************************
if($_POST['type']=="editNews")
{
		
		//PDF File Path
		$path = ROOT."/pdf/latest-news/english/";
		$path_h = ROOT."/pdf/latest-news/hindi/";
		
		//Upload Here Tender Document	
		if($_REQUEST['pdfval']==1)
		{
			$newsfile = $_FILES['pdf']['name'];		
			$tmp = $_FILES['pdf']['tmp_name'];
			$pdf = explode('.',$newsfile);
			$news_doc = time().'.'.$pdf[1]; // rename the file name
			
			move_uploaded_file($tmp, $path.$news_doc);
			
			 //Delete Old PDF from folder
			 $remove = $db->ExecuteQuery("SELECT Page_Link FROM tbl_latest_news WHERE Id=".$_REQUEST['id']);
			  
			 if(count($remove)>0 )
			 {
				if(file_exists($path.$remove[1]['Page_Link']) && !empty($remove[1]['Page_Link']))
				{
					unlink($path.$remove[1]['Page_Link']);
				}
			 }
		}
		else
		{
			//if PDF Is Empty Then
			$news_doc = $_REQUEST['news-doc'];
		}
		
		
		if($_REQUEST['pdfval_h']==1)
		{
			$newsfile_h = $_FILES['pdf_h']['name'];		
			$tmp_h = $_FILES['pdf_h']['tmp_name'];
			$pdf_h = explode('.',$newsfile_h);
			$news_doc_h = time().'.'.$pdf_h[1]; // rename the file name
			 
			move_uploaded_file($tmp_h, $path_h.$news_doc_h);
			
			//Delete Old PDF from folder
			 $remove = $db->ExecuteQuery("SELECT H_Page_Link FROM tbl_latest_news WHERE Id=".$_REQUEST['id']);
			  
			 if(count($remove)>0 )
			 {
				if(file_exists($path_h.$remove[1]['H_Page_Link']) && !empty($remove[1]['H_Page_Link']))
				{
					unlink($path_h.$remove[1]['H_Page_Link']);
				}
			 }
		}
		else
		{
			//if PDF Is Empty Then
			$news_doc_h = $_REQUEST['news-doc_h'];
		}
		
		
		$selecteddate = strtr($_REQUEST['date'], '/', '-');
		$date=date('Y-m-d',strtotime($selecteddate));
		$title = mysql_real_escape_string($_POST['heading']);
		$desc = mysql_real_escape_string($_POST['desc']);
	
	    $tblname = "tbl_latest_news";
		$tblfield=array('Date', 'Heading', 'Page_Link', 'Description', 'H_Heading', 'H_Page_Link', 'H_Description');
		$tblvalues=array($date, $title, $news_doc, $desc, $_POST['h_heading'], $news_doc_h, $_POST['h_desc'], 1);
		$condition="Id=".$_POST['id'];
		
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
/// Delete row from tbl_latest_news table
///*******************************************************
if($_POST['type']=="delete")
{
			
	$newspdf=$db->ExecuteQuery("SELECT Page_Link, H_Page_Link FROM tbl_latest_news WHERE Id=".$_POST['id']);
		
	$tblname="tbl_latest_news";
	$condition="Id=".$_POST['id'];
	$res=$db->deleteRecords($tblname,$condition);
	
	if($res)
	{
		if(!empty($newspdf[1]['Page_Link'])){
			unlink(PATH_LATEST_NEWS_PDF."/english/".$newspdf[1]['Page_Link']);
		}
		if(!empty($newspdf[1]['H_Page_Link'])){
			unlink(PATH_LATEST_NEWS_PDF."/hindi/".$newspdf[1]['H_Page_Link']);
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