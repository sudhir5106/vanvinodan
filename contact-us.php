<?php 
require_once('config.php');
include('header.php'); 

if (isset($_REQUEST['submit']) ) {
	require_once('recaptchalib.php');
  	$privatekey = "6LennPISAAAAAJBERy3ksjlQllAOCn2K7uy9ckC5";
  	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
?>
    <script type="text/javascript">

    	$(document).ready(function(){
    		alert("working");
			$("#captchaError").show();
			$("#captchaError").html("<p class='alert alert-danger' style='margin-top:15px;'><i class='fa fa-times-circle' aria-hidden='true'></i> The reCAPTCHA wasn't entered correctly. Please try it again.</p>")

		});// eof ready function

    </script>
<?php
  }//eof if condition

  else{
	  
	  	echo 1;
		///////////////////////////////////
		//data send to the admin via Email
		///////////////////////////////////
		//$to  = "mail@fsnl.nic.in/";
		$to  = "sudhir5106@gmail.com";

		// subject ///////////////////////////////////////
		$subject = 'A New Enquiry Has Been Initiated';
		$user_name=$_POST['name'];
		$emailId=$_POST['emailId'];
		$subject=$_POST['subject'];
		$msg=$_POST['msg'];

		// message ////////////////////////////////////////////////
		$message = "
		<table width='100%' border='0' cellspacing='0' cellpadding='0'>
		  <tr>
			<td>Name:</td>
			<td align='left'><strong>".$user_name."</strong></td>
		  </tr>

		  <tr>
			<td>Email:</td>
			<td align='left'><strong>".$emailId."</strong></td>
		  </tr>
		  
          <tr>
			<td>Subject:</td>
			<td align='left'><strong>".$subject."</strong></td>
		  </tr>

		  <tr>
			<td>Message/Enquiry:</td>
			<td align='left'><strong>".$msg."</strong></td>
		  </tr>
		</table>";

		// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		// Additional headers
		$headers .= 'From: Van Vinodan <feedback@vanvinodan.com>' . "\r\n";

		// Mail it
		mail($to, $subject, $message, $headers);
	}//eof else
}// eof submit

?>
<main>    
    <div class="middle-container">
        <div>
            <figure>
              <img src="images/resort.jpg" alt="The Van Vinodan Resort" width="100%">
            </figure>
        </div>
        <div class="innerPageTxt">
        	<div class="container">
            	<h1>Contact Us</h1>
            	<div class="contact-blocks">
            		<section class="col-sm-4">
            			<i class="fa fa-envelope" aria-hidden="true"></i><br>
	                	<p>If you are on the go and still want to ask a question, simply drop us an e-mail.</p>
	                	<p class="support"><strong>support@vanvinodan.com</strong></p>
	                </section>
	                <section class="col-sm-4">
	                	<i class="fa fa-phone" aria-hidden="true"></i><br>
	                	<p>If you are on the go and still want to ask a question, simply call us on.</p>
	                	<p class="support"><strong>+91-77999 99565</strong></p>
	                </section>
	                <section class="col-sm-4">
	                	<i class="fa fa-map-marker" aria-hidden="true"></i><br>
	                	<p>Van Vinodan Resort, Mangatta Rajnandgaon, Chhattisgarh.</p>
	                	<p class="support"><strong>INDIA</strong></p>
	                </section>
                </div>
                <div class="clearfix"></div>
                <div class="contact-form">
                	<h2 class="text-center">Feedback</h2>
                	<p class="text-center">Need help with our services more information in website we're ready and waiting for your questions.</p>
                	<div style="display:none;" id="captchaError"></div>
                	<form id="feedbackform" method="post">
	                	<section class="col-sm-6">
	                		<div class="form-group">
                                 <input type="text"  id="name" name="name" class="form-control" placeholder="Name" required="">
                            </div>

                            <div class="form-group">
                                 <input type="text" id="emailId" name="emailId" class="form-control" placeholder="Email" required="">
                            </div>
                            
                            <div class="form-group">
                                 <input type="text" id="subject" name="subject" class="form-control" placeholder="Subject" required="">
                            </div>
	                	</section>
	                	<section class="col-sm-6">
	                		<div class="form-group">
                                <textarea class="form-control" id="msg" name="msg" placeholder="Your Message"></textarea>
                            </div>
	                	</section>

	                	<div class="col-sm-12 text-center">
                            <?php 
                              require_once('recaptchalib.php');
                              $publickey = "6LennPISAAAAAAwbLk1VSEy4h50Zwk1bOJZgwnYN"; // you got this from the signup page
                              echo recaptcha_get_html($publickey);
                              ?>
                        </div>

	                	<div class="col-sm-12 butn text-center">
                            <button type="submit" id="submit" name="submit" href="#" class="btn btn-padding btn-g-border">Submit</button>
                        </div>
                	</form>
                	<div class="clearfix"></div>
                	<div id="dialog1" title="Message" style="display:none; text-align:left;">
                      <p>Your Feedback Successfully Submitted, We Will Touch With You Soon..</p>
                    </div>
                    <div id="dialog2" title="Message" style="display:none; text-align:left;">
                      <p>Something is Wrong</p>
                    </div>
                </div>

            </div>
        </div>
        <section class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29756.406747534314!2d81.15639758350716!3d21.20999458306046!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a293f9a65c7ebcf%3A0x373ae10924fb13a0!2sMangata%2C+Chhattisgarh+491441!5e0!3m2!1sen!2sin!4v1506175934803" width="100%" height="410px" frameborder="0" style="border:0" allowfullscreen></iframe>
        </section>

        
        
    </div>  	
</main>

<?php include('footer.php'); ?>
<script src="js/contact.js" type="text/javascript"></script>