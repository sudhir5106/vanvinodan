<?php 
require_once('config.php');
include('header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

$checkin = date("d-m-Y");
$checkout = date("d-m-Y",strtotime($checkin.'+1 day'));//It will add 1 day
?>

<main>
	
    <div id="loading">
        <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i> <span>On Process...</span></div>
    </div> 
    
    <div class="middle-container">
    	
        <div class="container">
            <div class="searchFrm padding-left-zero padding-right-zero">
                <form class="form-horizontal" role="form" id="searchRoomsFrm" method="post">
            
                <div class="col-sm-2 col-xs-6 padding-left-zero">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" id="chckin" name="chckin" class="form-control input-sm datetimepicker" placeholder="check-in" value="<?php echo $checkin; ?>">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-2 col-xs-6">
                    <div class="input-group date" data-provide="datepicker">
                        <input type="text" id="chckout" name="chckout" class="form-control input-sm datetimepicker2" placeholder="check-out" value="<?php echo $checkout; ?>">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-12 text-left text-center-xs"><button type="button" id="searchRoomsBtn" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> SEARCH</button></div>
                
                <div class="col-sm-6 col-xs-12 text-right backbtnblk padding-right-zero">
                    <a id="cancelBtn" class="btn btn-sm btn-danger"><i class="fa fa-times" aria-hidden="true"></i> CANCEL RESERVATION</a>
                    <a id="cancelBtn" class="btn btn-sm btn-info"><i class="fa fa-spinner" aria-hidden="true"></i> PENDING RESERVATION</a>
                    <button type="button" id="backBtn" class="btn btn-sm btn-success"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> BACK</button>
                </div>
                <div class="clearfix"></div>
            
            </form>
            </div>
            
            <div class="innerPageTxt pr-block">
                <h1>Pending Reservation</h1>
                <hr>
                <div>
                	<form class="form-horizontal" role="form" id="searchReservFrm" method="post">
                    	<div class="form-group">
                          <div class="col-sm-3">
                            <input type="text" id="rno" name="rno" class="form-control input-sm" placeholder="Enter Reservation Ref. No.">
                          </div>
                          <div class="col-sm-3 row">
                            <button type="button" id="findReservationBtn" class="btn btn-sm btn-success"><i class="fa fa-search" aria-hidden="true"></i> SEARCH</button>
                          </div>
                        </div>
                    </form>
                </div>
                
                <div id="reservation-details">
                	
                </div>
            </div>
        </div>
        
        
    </div>  	
</main>

<?php include('footer.php'); ?>