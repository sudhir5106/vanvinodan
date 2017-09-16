<?php 
require_once "DBConn.php";

class mail extends DBConn
{
	
	///***************************************************************************
	/// Function to send the pending reservation mail to user from billing ///////
	///***************************************************************************
	function reservationPendingMail($reservationId){
		
		//*********************************
		// Get reservation details from DB
		//*********************************
		$bookingInfo = 	$this->ExecuteQuery("SELECT Reservation_Ref_No, Check_In_Date, Check_Out_Date, Arrival_Time, Client_Name, Email, Phone, Total_Rooms_Amt, Total_Guests_Amt, Subtotal_Amt, SGST_Amt, CGST_Amt, Grand_Total_Amt, CASE WHEN Reservation_Status=5 THEN 'Pending' END Reservation_Status
		FROM tbl_reservation 
		WHERE Reservation_Id=".$reservationId."
		");
		
		//************************************************************
		$checkindate=date('d-m-Y',strtotime($bookingInfo[1]['Check_In_Date']));
		$checkoutdate=date('d-m-Y',strtotime($bookingInfo[1]['Check_Out_Date']));
		//************************************************************
		//Get Total No of Nights /////////////////////////////////////
		//************************************************************
		$date1 = new DateTime($bookingInfo[1]['Check_In_Date']);
		$date2 = new DateTime($bookingInfo[1]['Check_Out_Date']);
		
		//***********************************************************
		// Its calculates the the number of nights between two dates
		//***********************************************************
		$numberOfNights= $date2->diff($date1)->format("%a"); 
		
		/////////////////////////////////////////////////////////////////////////////
		// this calculates the diff between two dates, which is the number of nights
		/////////////////////////////////////////////////////////////////////////////
		$bookedRooms = $this->ExecuteQuery("SELECT COUNT( rc.R_Category_Id ) AS Room_Count, R_Category_Name, Adult, Children 
		FROM tbl_reserved_rooms rr
		LEFT JOIN tbl_room_master rm ON rm.Room_Id = rr.Room_Id
		LEFT JOIN tbl_rooms_category rc ON rm.R_Category_Id = rc.R_Category_Id
		
		WHERE Reservation_Id=".$reservationId." GROUP BY rc.R_Category_Id
		");
		
		//*********************************
		// User Email Id //////////////////
		//*********************************		
		//$to  = "billing@vanvinodan.com";
		$to  = $bookingInfo[1]['Email'];
		
		//*********************************************************
		// Email Subject //////////////////////////////////////////
		//*********************************************************
		$subject = 'Pending Reservation at Van Vinodan Resort';
		//*********************************************************
		// Message ////////////////////////////////////////////////
		//*********************************************************
		$message = '
		<table width="600" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td style="padding:20px; background:#F2F2F2;">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
                        <td><img src="images/logo.png" alt="" /></td>
                    </tr>
                    <tr>
                    	<td style="background:#fff; padding:15px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td>
                                    	<h2>Thanks for showing an ineterest in reservation with Van Vinodan</h2>
                                        <p>your pending reservation and payment details</p>
                                    </td>
                                </tr>
                                <tr>
                                	<td style="background:#F2F2F2; padding:10px;">
                                    	YOUR RESERVATION DETAILS
                                    </td>
                                </tr>
                                <tr>
                                	<td style="padding:20px 10px; border:solid 1px #F2F2F2;">
                                    	<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        	<tr>
                                            	<td><strong>Reservation Ref. No.:</strong> '.$bookingInfo[1]['Reservation_Ref_No'].'</td>
                                                <td style="text-align:right;"><strong>Date:</strong> '.date("M d, Y").'</td>
                                            </tr>
											<tr>
												<td><strong>Reservation Status:</strong> '.$bookingInfo[1]['Reservation_Status'].'</td>
											</tr>
                                            <tr>
                                            	<td colspan="2" style="padding-bottom:15px;">
                                                	<table width="50%">
                                                    	<tr>
                                                        	<td colspan="2" style="padding-top:15px; padding-bottom:5px; border-bottom:solid 1px #CCCCCC;"><strong>BILL To</strong></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Name:</strong> '.$bookingInfo[1]['Client_Name'].'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Email:</strong> '.$bookingInfo[1]['Email'].'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Phone:</strong> '.$bookingInfo[1]['Phone'].'</td>
                                            </tr>
											<tr>
                                            	<td colspan="2">
                                                	<table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                    	';
														foreach($bookedRooms as $val){
														
														$message .='<tr>
                                                        	<td>'.$val['R_Category_Name'].' - '.$val['Room_Count'].' Room(s)</td>
                                                            <td>Adult(s):'.$val['Adult'].'&nbsp;&nbsp;&nbsp;&nbsp; Children(s):'.$val['Children'].'</td>
                                                        </tr>';
														}
                                                    $message .='</table>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td colspan="2"><strong>Check-In Date:</strong> '.$checkindate.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Check-Out Date:</strong> '.$checkoutdate.'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Estimated Arriaval Time:</strong> '.$bookingInfo[1]['Arrival_Time'].' &nbsp;&nbsp;&nbsp;&nbsp; <strong>Total Nights:</strong> '.$numberOfNights.'</td>
                                            </tr>
                                            <tr>
                                            	<td style="padding-top:30px;">Total Room Amt.:</td>
                                                <td style="padding-top:30px;">'.$bookingInfo[1]['Total_Rooms_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td>Extra Guest Amt:</td>
                                                <td>0.00</td>
                                            </tr>
                                            <tr>
                                            	<td>SGST:</td>
                                                <td>'.$bookingInfo[1]['SGST_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td>CGST:</td>
                                                <td>'.$bookingInfo[1]['CGST_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>GRAND TOTAL:</strong></td>
                                                <td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>'.$bookingInfo[1]['Grand_Total_Amt'].'</strong></td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2" style="text-align:center; padding:15px;">
                                                	<a href=""><img src="images/payBtn.png" alt="" /></a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
		
		//*********************************************************
		// To send HTML mail, the Content-type header must be set
		//*********************************************************
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		//*********************************************************
		// Additional headers /////////////////////////////////////
		//*********************************************************
		$headers .= 'From: Van Vinodan Reosrt <billing@suncrosonline.com>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		
		//*********************************************************
		// Send Mail //////////////////////////////////////////////
		//*********************************************************
		mail($to, $subject, $message, $headers);
		//*********************************************************
	}//eof billing function
	
	
	
	
	//////////////////////////////////////////////////////////////////////////////
	/// Function to send the pending reservation mail to user from billing ///////
	//////////////////////////////////////////////////////////////////////////////
	function reservationConfirmedMail($reservationId){
		
		//*********************************
		// Get reservation details from DB
		//*********************************
		$bookingInfo = 	$this->ExecuteQuery("SELECT Reservation_Ref_No, Check_In_Date, Check_Out_Date, Arrival_Time, Client_Name, Email, Phone, Total_Rooms_Amt, Total_Guests_Amt, Subtotal_Amt, SGST_Amt, CGST_Amt, Grand_Total_Amt, CASE WHEN Reservation_Status=1 THEN 'Confirmed' END Reservation_Status, Transaction_No, Payment_Id
		FROM tbl_reservation r
		LEFT JOIN tbl_transactions t ON r.Reservation_Id = t.Reservation_Id
		WHERE Reservation_Id=".$reservationId."
		");
		
		//************************************************************
		$checkindate=date('d-m-Y',strtotime($bookingInfo[1]['Check_In_Date']));
		$checkoutdate=date('d-m-Y',strtotime($bookingInfo[1]['Check_Out_Date']));
		//************************************************************
		//Get Total No of Nights /////////////////////////////////////
		//************************************************************
		$date1 = new DateTime($bookingInfo[1]['Check_In_Date']);
		$date2 = new DateTime($bookingInfo[1]['Check_Out_Date']);
		
		//***********************************************************
		// Its calculates the the number of nights between two dates
		//***********************************************************
		$numberOfNights= $date2->diff($date1)->format("%a"); 
		
		/////////////////////////////////////////////////////////////////////////////
		// this calculates the diff between two dates, which is the number of nights
		/////////////////////////////////////////////////////////////////////////////
		$bookedRooms = $this->ExecuteQuery("SELECT COUNT( rc.R_Category_Id ) AS Room_Count, R_Category_Name, Adult, Children 
		FROM tbl_reserved_rooms rr
		LEFT JOIN tbl_room_master rm ON rm.Room_Id = rr.Room_Id
		LEFT JOIN tbl_rooms_category rc ON rm.R_Category_Id = rc.R_Category_Id
		
		WHERE Reservation_Id=".$reservationId." GROUP BY rc.R_Category_Id
		");
		
		//*********************************
		// User Email Id //////////////////
		//*********************************		
		//$to  = "billing@vanvinodan.com";
		$to  = $bookingInfo[1]['Email'];
		
		//*********************************************************
		// Email Subject //////////////////////////////////////////
		//*********************************************************
		$subject = 'Confirmation of Reservation at Van Vinodan Resort';
		//*********************************************************
		// Message ////////////////////////////////////////////////
		//*********************************************************
		$message = '
		<table width="600" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td style="padding:20px; background:#F2F2F2;">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
                        <td><img src="images/logo.png" alt="" /></td>
                    </tr>
                    <tr>
                    	<td style="background:#fff; padding:15px; font-family:Arial, Helvetica, sans-serif; font-size:14px;">
                        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                            	<tr>
                                	<td>
                                    	<h2>Thanks for showing an ineterest in reservation with Van Vinodan</h2>
                                        <p>your confirmation of reservation and payment details</p>
                                    </td>
                                </tr>
                                <tr>
                                	<td style="background:#F2F2F2; padding:10px;">
                                    	YOUR RESERVATION DETAILS
                                    </td>
                                </tr>
                                <tr>
                                	<td style="padding:20px 10px; border:solid 1px #F2F2F2;">
                                    	<table width="100%" border="0" cellspacing="0" cellpadding="5">
                                        	<tr>
                                            	<td><strong>Reservation Ref. No.:</strong> '.$bookingInfo[1]['Reservation_Ref_No'].'</td>
                                                <td style="text-align:right;"><strong>Date:</strong> '.date("M d, Y").'</td>
                                            </tr>
											<tr>
												<td><strong>Reservation Status:</strong> '.$bookingInfo[1]['Reservation_Status'].'</td>
											</tr>
                                            <tr>
                                            	<td colspan="2" style="padding-bottom:15px;">
                                                	<table width="50%">
                                                    	<tr>
                                                        	<td colspan="2" style="padding-top:15px; padding-bottom:5px; border-bottom:solid 1px #CCCCCC;"><strong>RECEIPT To</strong></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
											<tr>
                                            	<td colspan="2"><strong>Payment Id:</strong> '.$bookingInfo[1]['Payment_Id'].'</td>
                                            </tr>
											<tr>
                                            	<td colspan="2"><strong>Transaction Code:</strong> '.$bookingInfo[1]['Transaction_No'].'</td>
                                            </tr>
											<tr>
                                            	<td colspan="2"><strong>Name:</strong> '.$bookingInfo[1]['Client_Name'].'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Email:</strong> '.$bookingInfo[1]['Email'].'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Phone:</strong> '.$bookingInfo[1]['Phone'].'</td>
                                            </tr>
											<tr>
                                            	<td colspan="2">
                                                	<table width="100%" border="1" cellspacing="0" cellpadding="5">
                                                    	';
														foreach($bookedRooms as $val){
														
														$message .='<tr>
                                                        	<td>'.$val['R_Category_Name'].' - '.$val['Room_Count'].' Room(s)</td>
                                                            <td>Adult(s):'.$val['Adult'].'&nbsp;&nbsp;&nbsp;&nbsp; Children(s):'.$val['Children'].'</td>
                                                        </tr>';
														}
                                                    $message .='</table>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                            	<td colspan="2"><strong>Check-In Date:</strong> '.$checkindate.'&nbsp;&nbsp;&nbsp;&nbsp;<strong>Check-Out Date:</strong> '.$checkoutdate.'</td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2"><strong>Estimated Arriaval Time:</strong> '.$bookingInfo[1]['Arrival_Time'].' &nbsp;&nbsp;&nbsp;&nbsp; <strong>Total Nights:</strong> '.$numberOfNights.'</td>
                                            </tr>
                                            <tr>
                                            	<td style="padding-top:30px;">Total Room Amt.:</td>
                                                <td style="padding-top:30px;">'.$bookingInfo[1]['Total_Rooms_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td>Extra Guest Amt:</td>
                                                <td>0.00</td>
                                            </tr>
                                            <tr>
                                            	<td>SGST:</td>
                                                <td>'.$bookingInfo[1]['SGST_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td>CGST:</td>
                                                <td>'.$bookingInfo[1]['CGST_Amt'].'</td>
                                            </tr>
                                            <tr>
                                            	<td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>GRAND TOTAL:</strong></td>
                                                <td style="border-top:solid 1px #CCC; border-bottom:solid 1px #CCC;"><strong>'.$bookingInfo[1]['Grand_Total_Amt'].'</strong></td>
                                            </tr>
                                            <tr>
                                            	<td colspan="2" style="text-align:center; padding:15px; color:green; font-size:35px;">PAID</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>';
		
		//*********************************************************
		// To send HTML mail, the Content-type header must be set
		//*********************************************************
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		//*********************************************************
		// Additional headers /////////////////////////////////////
		//*********************************************************
		$headers .= 'From: Van Vinodan Reosrt <billing@suncrosonline.com>' . "\r\n";
		//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
		//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";
		
		//*********************************************************
		// Send Mail //////////////////////////////////////////////
		//*********************************************************
		mail($to, $subject, $message, $headers);
		//*********************************************************
	}//eof billing function
		
}

?>