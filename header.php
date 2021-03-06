<?php 
$page = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
$pagename = basename($page, ".php"); // $file is set to "index"
//For base url PayUMoney_form.php
$baseurl = basename($_SERVER['PHP_SELF']);

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="" />
        <meta name="keywords" content="" />
        
        <title>Van Vinodan :: The Resort</title>

        <!-- Latest compiled and minified CSS -->
        <link href="<?php echo PATH_CSS_LIBRARIES ?>/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/style.css">
        <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/owl.carousel.css" type="text/css">
    	  <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/owl.theme.default.min.css"  type="text/css" />
        <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/animate.min.css"  type="text/css" />
        <link rel="stylesheet" href="<?php echo PATH_CSS_LIBRARIES ?>/jquery-ui.css">

        <script src="<?php echo PATH_JS_LIBRARIES ?>/jquery.min.js"></script>
        <script src="<?php echo PATH_JS_LIBRARIES ?>/jquery-ui.js"></script>
        <script src="<?php echo PATH_JS_LIBRARIES ?>/bootstrap.min.js"></script>
        <script src="<?php echo PATH_JS_LIBRARIES ?>/owl.carousel.min.js"></script>
        <script src="<?php echo PATH_JS_LIBRARIES ?>/jquery.validate.js"></script>
        
		<script>
			$(document).ready(function() {
				$(".bottom-slider").owlCarousel();
				interval: 1200;
	
				$('.innerPageTxt').addClass("fadeIn").addClass("animated");
	
			});
     </script>
		
    </head>
    <body <?php if($baseurl=='PayUMoney_form.php'){ ?> onLoad="submitPayuForm()" <?php } ?>>
    <?php
        if($pagename=='vanvinodan' || $pagename=='index'){ ?>
        	<div class="homeslider">
                <!-- slides -->
                <div class="slides">
                    <ul> <!-- slides -->
                        <li><img src="images/slides/slide1.jpg"></li>
                        <li><img src="images/slides/slide2.jpg"></li>
                        <li><img src="images/slides/slide1.jpg"></li>
                        <li><img src="images/slides/slide2.jpg"></li>
                    </ul>
                </div>
                <!-- eof slides -->
            </div>
     <?php }else{ ?>
     		
            <div class="homeslider pageinheader">
            	<div class="div-table"></div>
            </div>
                 
     <?php } ?>
        
        
        <header>
            
            <div class="searchRooms">
            	<div class="closeBtn">X</div>
            	<div class="searchTitle">CHECK AVAILABILITY FOR ROOMS AT VANVINODAN RESORT</div>
                <div class="searchFields">
                	<form class="form-horizontal" role="form" id="searchFrm" name="searchFrm" action="<?php echo LINK_ROOT ?>/reservation.php" method="post">
                        <div class="col-sm-4 col-xs-6">
                        	<div class="input-group date" data-provide="datepicker">
                                <input type="text" id="checkindate" name="checkindate" class="form-control input-lg datetimepicker" placeholder="check-in">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-4 col-xs-6">
                        	<div class="input-group date" data-provide="datepicker">
                                <input type="text" id="checkoutdate" name="checkoutdate" class="form-control input-lg datetimepicker2" placeholder="check-out">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 text-left text-center-xs"><button type="submit" id="search" class="btn btn-lg btn-danger">BOOK NOW</button></div>
                    </form>
                </div>
            </div>
            
            <div class="headTop">
            	<div class="container-fluid">
                    <div class="col-xs-12 col-sm-4 col-md-4 padding-left-zero">
                        <div class="logo"><a href="<?php echo LINK_ROOT ?>/index.php"><img class="img-responsive" src="<?php echo PATH_IMAGE ?>/logo.png" alt="SA Global India Financial Services"></a></div>
                    </div>
                    <div class="navbar-header hidden-md">
                      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                    </div>
                                
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="col-xs-12 col-sm-8 col-md-8 topmenu collapse navbar-collapse padding-right-zero padding-right-zero-xs" id="bs-example-navbar-collapse-1">
                       
                       <div class="text-white topimpinfo">
                            <div class="pull-right social-icons">
                                <ul>
                                    <li><a class="fb-icon" href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                    <li><a class="twitter-icon" href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a class="gplus-icon" href=""><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                                    <li><a class="linkedin-icon" href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                            <div class="pull-right emergencyNo">CALL US: <span>+91-77999 99565</span><span class="hidden-xs"> &nbsp;&nbsp;|</span></div>
                            <?php if($pagename!='reservation'){ ?>
                            <div class="pull-right booknowBtn"><a class="bookBtn">BOOK NOW</a></div>
                            <?php } ?>
                            <div class="clearfix"></div>
                       </div>
                       
                       <div class="menu-right">
                       		
                            <nav class="navbar navbar-default navbar-static-top navBg" role="navigation">
                            	<div class="collapse navbar-collapse in" id="navbar-collapse-1">
                                <ul class="nav navbar-nav navigation">
                                  <li class="active"><a class="homelink" href="<?php echo LINK_ROOT ?>/index.php">Home</a></li>
                                  <li><a href="<?php echo LINK_ROOT ?>/about-us.php">About us</a></li>
                                  <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown">Accommodation <b class="caret"></b></a>
                                     <ul class="dropdown-menu">
                                        <li><a href="<?php echo LINK_ROOT ?>/super-deluxe.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Super Deluxe Room</a></li>
                                        <li><a href="<?php echo LINK_ROOT ?>/deluxe.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Deluxe Room</a></li>
                                        <li><a href="<?php echo LINK_ROOT ?>/tent.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Tent Room</a></li>
                                     </ul>
                                  </li>
                                  <li><a href="">Places to visit</a></li>
                                  <li><a href="<?php echo LINK_ROOT ?>/gallery-category.php">Photo Gallery</a></li>
                                  <li><a href="#" class="dropdown-toggle" data-toggle="dropdown">Reservation <b class="caret"></b></a>
                                  
                                  	<ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Package Tour</a></li>
                                        <li><a href="#"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Tariff</a></li>
                                        <li><a href="<?php echo LINK_ROOT ?>/reservation.php"><i class="fa fa-angle-double-right" aria-hidden="true"></i> Online Reservation</a></li>
                                     </ul>
                                  </li>
                                  <li><a href="<?php echo LINK_ROOT ?>/contact-us.php">Contact us</a></li>
                                </ul>
                            </div>
                            </nav>
                       		
                       </div>
                       
                    </div>
                    <!-- /.navbar-collapse -->
                    <div class="clearfix"></div> 
                </div>
            </div>
            
        </header>