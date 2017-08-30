<?php 
include('header.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();


$checkindate = date('Y-m-d',strtotime($_POST['checkindate']));
$checkoutdate = date('Y-m-d',strtotime($_POST['checkoutdate']));

$res = $db->ExecuteQuery("SELECT R_Category_Name, R_Capacity, Base_Fare, Aircondition_Fare, Extra_Bed_Fare, Room_Info, Amenities FROM tbl_rooms_category WHERE R_Category_Id IN (SELECT R_Category_Id FROM tbl_room_master 
WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."' AND Check_Out_Date > '".$checkindate."' ))");

/*$res2 = $db->ExecuteQuery("SELECT Room_Name FROM tbl_room_master WHERE Room_id NOT IN (SELECT Room_Id FROM tbl_reservation WHERE Check_In_Date <= '".$checkindate."'  AND Check_Out_Date > '".$checkindate."' )");*/



?>

<main style="margin-top:194px;"> 
        
    <div class="middle-container">
    
    	
        <div></div>
        
    
        <div class="text-danger">
        <?php foreach($res as $val){ 
			echo $val['R_Category_Name'].'<br>'; 
		} ?>
        </div>
        
        <!--<div class="text-info" style="padding-top:20px;">
        <?php foreach($res2 as $val2){ 
			echo $val2['Room_Name'].'<br>'; 
		} ?>
        </div>-->
        
    </div>  	
</main>

<?php include('footer.php'); ?>