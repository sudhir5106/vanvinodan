<?php
session_start();
date_default_timezone_set('Asia/Calcutta');
define("SERVER",'localhost');
define("DBUSER",'root');
define("DBPASSWORD",'');
define("DBNAME",'vanvinodan');
define("ROOT",$_SERVER['DOCUMENT_ROOT'].'/vanvinodan'); //FOR PHP ROOT LINK

define("PATH_LIBRARIES", ROOT.'/libraries');
define("PATH_USER", ROOT.'/user');
define("PATH_JS_LIBRARIES",'/vanvinodan/js');
define("PATH_CSS_LIBRARIES",'/vanvinodan/css');
define("PATH_IMAGE",'/vanvinodan/images'); // Images Link
define("PATH_FONTS",'/vanvinodan/fonts'); // fonts Link

define("PATH_INCLUDE",ROOT.'/include');

//Admin Section
define("LINK_CONTROL", '/vanvinodan/adminpanel');
define("PATH_ADMIN", ROOT.'/adminpanel');
define("PATH_ADMIN_INCLUDE",PATH_ADMIN.'/include');
define("PATH_UPLOAD_IMAGE",'/vanvinodan/images/img-gallery');
define("PATH_ROOMS_IMAGE",'/vanvinodan/images/rooms');

define("LINK_ROOT",'/vanvinodan'); //For HTML LINK
define("ROWS_PER_PAGE",10);
define("PAGELINK_PER_PAGE",10);

?>