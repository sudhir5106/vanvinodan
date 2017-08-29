<?php 
require_once "DBConn.php";

class latestnews extends DBConn
{
	
	///*******************************************************
	/// Get List of Eng News  ////////////////////////////////
	///*******************************************************
	function GetEngNews(){
		
		$res=$this->ExecuteQuery("SELECT Heading, Page_Link, Description FROM tbl_latest_news ORDER BY Id DESC");
		
		return $res;
		
	}//eof function
	
	///*******************************************************
	/// Get List of Hindi News  //////////////////////////////
	///*******************************************************
	function GetHiNews(){
		
		$res=$this->ExecuteQuery("SELECT H_Heading as Heading, H_Page_Link as Page_Link, H_Description as Description FROM tbl_latest_news ORDER BY Id DESC");
		
		return $res;
		
	}//eof function
	
	
}//eof class

?>