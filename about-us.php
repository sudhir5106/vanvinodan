<?php 
require_once('config.php');
include('header.php'); ?>
<main>    
    <div class="middle-container">
        <div>
            <figure>
              <img src="images/resort.jpg" alt="The Van Vinodan Resort" width="100%">
            </figure>
        </div>
        <div class="innerPageTxt">
        	<div class="container">
            	<h1>About Us</h1>
                <article>
                    <p>If you an ardent nature lover, want to experience its beauty, witness its secrets unravel and feel the magic of the Jungle take your breath away, The Tiger Safari personifies your expectations. We encourage you to come share your experience with us, as we witness the Royalty of the Royal Bengal Tiger, the enchanting bliss of the jungle, the joy of bird watching, the ecstasy of discovering new bird species, the unique culture and rich heritage of the tiger country and the like.</p>

                    <p>Our aim is to provide the best experience ever. We design our program to render tranquil surroundings and cosseted service. Our team is friendly, professional, knowledgeable and experienced in accompanying both the seasoned travelers and assisting those who are exploring the mysteries of nature for the first time by seeking personalized travel consulting and planning. We pride ourselves in customer satisfaction. We offer our services to a wide range of people – Individuals, Families, Corporates, and Students. We specialize in customizing trips for you as per your wish, depending on the theme, size and maturity of the group. The Tiger Safari offers you an experience of the lifetime through our well planned tours, assisting and enlightening you at each step to capture the incredible memories photographically and preserve the thrilling moments to cherish them for life. Join us to witness the spirit of the wild.</p>
                </article>
            </div>
        </div>

        <div class="partners-bg3">
            <div class="container">
                <div class="partner-head3">
                    <div class="double-border3 hidden-xs pull-left"></div>
                    <div class="title pull-left text-center">OUR <strong>FOUNDERS</strong> &amp; <strong>DIRECTORS</strong><br><span>WHAT THEY SAID</span></div>
                    <div class="double-border3 hidden-xs pull-left"></div>
                    <div class="clearfix"></div>
                </div>

                <div>
                    <div class="col-sm-3 msgBlk">
                        <div><img width="100%" src="images/director1.jpg" alt=""></div>
                        <div>
                            <h3>Manoj Khanna<br><span>Founder and Director</span></h3>
                            <p>A wildlife photographer by profession, he has an unfailing eye for unique perspectives.</p>
                        </div>
                    </div>
                    <div class="col-sm-3 msgBlk">
                        <div><img width="100%" src="images/director2.jpg" alt=""></div>
                        <div>
                            <h3>D.M.Rao<br><span>Founder and Director</span></h3>
                            <p>A wildlife photographer by profession, he has an unfailing eye for unique perspectives.</p>
                        </div>
                    </div>
                    <div class="col-sm-3 msgBlk">
                        <div><img width="100%" src="images/director1.jpg" alt=""></div>
                        <div>
                            <h3>Manoj Khanna<br><span>Founder and Director</span></h3>
                            <p>A wildlife photographer by profession, he has an unfailing eye for unique perspectives.</p>
                        </div>
                    </div>
                    <div class="col-sm-3 msgBlk">
                        <div><img width="100%" src="images/director2.jpg" alt=""></div>
                        <div>
                            <h3>D.M.Rao<br><span>Founder and Director</span></h3>
                            <p>A wildlife photographer by profession, he has an unfailing eye for unique perspectives.</p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                
            </div>
        </div>
        
    </div>  	
</main>
<script type="text/javascript">
            
            $(window).scroll(function(){
                if ($(document).scrollTop() > 200){ 
                    var imageUrl = "images/Dining.jpg";
                    $("body").css({'background-image':'url(' + imageUrl + ')', 'background-position':'bottom', 'background-attachment':'fixed'});
                } 
                else{
                    
                    $("body").removeAttr( "style" );
                }
                
            });

</script>
<?php include('footer.php'); ?>