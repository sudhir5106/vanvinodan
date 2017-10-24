<?php 
include('../../config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();

//****************************************************************
//using for SQL Query ////////////////////////////////////////////
//****************************************************************
$checkindate = date("Y-m-d");
$checkoutdate = date("Y-m-d",strtotime($checkindate.'+1 day'));//It will adding 1 day
//****************************************************************
//using for Calendar /////////////////////////////////////////////
//****************************************************************
$checkin = date("d-m-Y");
$checkout = date("d-m-Y",strtotime($checkin.'+1 day'));//It will add 1 day

/////////////////////////////
//Get Total No of Nights
/////////////////////////////
$date1 = new DateTime($checkindate);
$date2 = new DateTime($checkoutdate);

///////////////////////////////////////////////////////////////////////////////////////
// this calculates the diff between two dates, which is the number of nights
///////////////////////////////////////////////////////////////////////////////////////
$numberOfNights= $date2->diff($date1)->format("%a"); 
///////////////////////////////////////////////////////////////////////////////////////

//**********************************************************************************
// Get all the Room Types which are having rooms availble for reservation //////////
//**********************************************************************************
$res = $db->ExecuteQuery("SELECT R_Category_Id, R_Category_Name, R_Capacity, Base_Fare FROM tbl_rooms_category

WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5 ))");
////////////////////////////////////////////////////////////////////////////////////

require_once(PATH_ADMIN_INCLUDE.'/header.php');

?>

<script type="text/javascript" src="reservation.js"></script>

<div id="loading">
    <div class="loader-block"><i class="fa-li fa fa-spinner fa-spin spinloader"></i></div>
</div>


<div>

  <div class="page-title">
    <div class="title_left">
      <h3>New Reservation</h3>
    </div>
  </div>

  <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
        <div class="x_title">
          <form class="form-horizontal" role="form" id="searchRoomsFrm" method="post">
        
             <div class="col-sm-2 col-xs-6 padding-left-zero">
                  <div class="input-group date" data-provide="datepicker">
                      <input type="text" id="chckin" name="chckin" class="form-control input-sm datetimepicker2" placeholder="check-in" value="<?php echo $checkin; ?>">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                      </div>
                  </div>
              </div>
              
              <div class="col-sm-2 col-xs-6">
                  <div class="input-group date" data-provide="datepicker">
                      <input type="text" id="chckout" name="chckout" class="form-control input-sm datetimepicker3" placeholder="check-out" value="<?php echo $checkout; ?>">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar" aria-hidden="true"></i>
                      </div>
                  </div>
              </div>
              <div class="col-sm-2 col-xs-12 text-left text-center-xs"><button type="button" id="searchRoomsBtn" class="btn btn-sm btn-info"><i class="fa fa-search" aria-hidden="true"></i> SEARCH</button></div>
              
              <div class="clearfix"></div>
          
          </form>
          
        </div>
        <div class="x_content">
          
          <div>
          <?php foreach($res as $val){ ?>
            <div class="col-md-4 col-sm-4 col-xs-12 animated fadeInDown">
              <div class="well profile_view">
                <div class="col-sm-12">
                  <div class="text-center">
                    <h2><?php echo $val['R_Category_Name']; ?></h2>
                    <p><strong>Capacity: </strong> <?php echo $val['R_Capacity']; ?></p>

                    <?php $roomCount = $db->ExecuteQuery("SELECT COUNT(Room_Id) AS RID FROM tbl_room_master 
WHERE R_Category_Id=".$val['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5)"); ?>

                    <p><strong>Rooms Left:</strong> <span class="badge"><?php echo $roomCount[1]['RID']; ?></span></p>
                    <p class="room-price"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $val['Base_Fare']; ?> <span>/ Night</span></p>
                  </div>
                  
                </div>
                <div class="col-xs-12 bottom-btn text-center">
                  <div>
                    <button type="button" id="<?php echo $val['R_Category_Id']; ?>" class="btn btn-success btn-sm selectRoomBtn"> <i class="fa fa-plus-circle" aria-hidden="true"></i> Select Rooms </button>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>

            <div class="clearfix"></div>

          </div>
          <hr>

          <form class="form-horizontal" role="form" id="bookingFrm" method="post">

            <div id="roomData">
              <table class="table table-hover table-stripped">
                <thead>
                  <tr class="bg-info">
                    <th width="30"></th>
                    <th width="120">Room No.</th>
                    <th width="50">Adult</th>
                    <th width="50">Child</th>
                    <th width="70">Extra Guest</th>
                    <th width="100">Base Fare</th>
                    <th width="100"><span id="Nightscount" class="badge"><?php echo $numberOfNights; ?></span> Night(s) Fare</th>
                    <th width="100"><span id="guestCount" class="badge"></span> Guest(s) Fare</th>
                    <th width="120">Total</th>                  
                  </tr>
                </thead>

                <tfoot class="tbFootLabel">
                  <tr>
                    <td align="right" colspan="8"><label><strong>Subtotal</strong></label></td>
                    <td><input id="subtotal" type="text" value="" class="form-control input-sm" disabled ></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="8"><label>SGST(9%)</label></td>
                    <td><input id="sgst" type="text" value="" class="form-control input-sm" disabled ></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="8"><label>CGST(9%)</label></td>
                    <td><input id="cgst" type="text" value="" class="form-control input-sm" disabled ></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="8"><label><strong>GRAND TOTAL</strong></label></td>
                    <td><input id="grand-total" type="text" value="" class="form-control input-sm" disabled ></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="8"><label><strong>Paid Amount <span class="required">*</span></strong></label></td>
                    <td><input id="paidAmt" type="text" value="" class="form-control input-sm" ></td>
                  </tr>
                  <input id="nightsCount" type="hidden" value="<?php echo $numberOfNights; ?>" class="form-control input-sm" >
                  
                </tfoot>

                <tbody>
                  
                </tbody>
                
              </table>
            </div>
            <hr>

            <div>
              <h2>CUSTOMER DETAILS</h2>
              <div>
                <div class="item form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label" for="fullname">Full Name <span class="required">*</span> </label>
                    <div>
                      <input type="text" id="fullname" name="fullname" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Name">
                    </div>
                  </div>
                  <div class="item col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label" for="email">Email <span class="required">*</span> </label>
                    <div>
                      <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Email Id">
                    </div>
                  </div>
                  <div class="clearfix"></div>
              </div>
              
              <div>
                 <div class="item form-group col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label" for="phone">Phone <span class="required">*</span> </label>
                    <div>
                      <input type="text" id="phone" name="phone" required="required" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Phone No.">
                    </div>
                  </div>
                  <div class="item col-md-6 col-sm-6 col-xs-12">
                    <label class="control-label" for="idprof">Id Proof</label>
                    <div>
                      <input type="file" id="idprof" name="idprof" class="form-control col-md-7 col-xs-12 " placeholder="Enter Your Name"> (Ex: Aadhaar Card, Voter Id, Passport etc.)
                    </div>
                  </div>
                  <div class="clearfix"></div>
              </div>

              <div class="text-center reservationBtn">
                <button id="completeReservBtn" type="button" class="btn btn-danger btn-lg">COMPLETE RESERVATION</button>
              </div>

            </div>

          </form>

          
        </div>
      </div>
    </div>
    
    
    <?php foreach($res as $value){ ?>
    <!-- Modal POPUP -->
    <div id="roomInfo-<?php echo $value['R_Category_Id']; ?>" class="modal-popup modal fade in" tabindex="-1" role="dialog" aria-labelledby="gridModalLabel" style="display: none;" aria-hidden="false">
        <div class="modal-dialog modal-sm" role="document">
          
          <div class="modal-content" id="usersignin">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="gridModalLabel">Select Rooms</h4>
              </div>
              <div class="modal-body">
                <ul>          
                <?php $rooms = $db->ExecuteQuery("SELECT Room_Id, Room_Name FROM tbl_room_master 
WHERE R_Category_Id=".$value['R_Category_Id']." AND Room_id NOT IN (SELECT Room_Id FROM tbl_reserved_rooms WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' AND Reservation_Status<>3 AND Reservation_Status<>4 AND Reservation_Status<>5)"); 
                
                foreach($rooms as $roomsVal){ ?>
                  <li class="ckeckbox checkbox-danger"><input id="rmid-<?php echo $roomsVal['Room_Id']; ?>" class="roomid" type="checkbox" value="<?php echo $roomsVal['Room_Id']; ?>">
                  <label><?php echo $roomsVal['Room_Name']; ?></label></li>
                <?php }
?>
                </ul>
                <div class="clearfix"></div>
                <div class="text-center"><button type="button" class="btn btn-info btn-sm" data-dismiss="modal" aria-label="Close">Ok</button></div>
              </div>
              <div class="clearfix"></div>
          </div>
        </div>
    </div>
    <!-- EOF Modal POPUP -->
    <?php } ?>

</div>
<?php require_once(PATH_ADMIN_INCLUDE.'/footer.php'); ?>
