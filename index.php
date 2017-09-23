<?php

//****************************************************************
/// Set Cookie for display offers ////////////////////////////////
//****************************************************************
//setcookie("offer", "", time()-3600);
$cookie_name = "offer6";
$cookie_value = "ad";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
//****************************************************************
require_once('config.php');
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
include('header.php'); 
//****************************************************************
$getNews = $db->ExecuteQuery("SELECT DATE_FORMAT(Date,'%d %M, %Y') AS Date, News_Title, News_Image FROM tbl_latest_news");
//****************************************************************
$currentDate = date("Y-m-d");
$getOffer = $db->ExecuteQuery("SELECT Offer_Image FROM tbl_offers WHERE Status=1 AND Expired_Date>=".$currentDate." LIMIT 1");
//****************************************************************
?>

<link rel="stylesheet" href="support/popup.css" />

<main> 
        
    <div class="middle-container">
        
        <div class="quotation">
            Say Yes<br>
            <span>To New Adventures</span>
        </div>
        
        <div class="partners-bg">
            <div class="midPortion">
                <div class="col-sm-12 feturesBlock">
                    <div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="partner-logo"><img width="100%" class="img-responsive" src="images/swimming-pool.jpg" alt=""></div>
                            <div class="featureBox text-center">Swimming Pool</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="partner-logo"><img width="100%" class="img-responsive" src="images/adventures-sports.jpg" alt=""></div>
                            <div class="featureBox text-center">Adventures Sports</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="partner-logo"><img width="100%" class="img-responsive" src="images/open-theater.jpg" alt=""></div>
                            <div class="featureBox text-center">Open Theater</div>
                        </div>
                        <div class="col-sm-3 col-xs-6">
                            <div class="partner-logo"><img width="100%" class="img-responsive" src="images/children-park.jpg" alt=""></div>
                            <div class="featureBox text-center">Children's Park</div>
                        </div>
                        <div class="clearfix"></div>
                        
                    </div>
                </div>   
                <div class="clearfix"></div>
                
                <div class="text-center welcomTxt">
                    <h1>Welcome to<br>Van Vinodan Resort</h1>
                    <p>Near extinction. Stringent conservation programs for the overall protection of the Park's fauna and flora, makes Mangatta one of the most well maintained National Parks in Asia.<br>
    A heightened attraction within the Park is Bamni Dadar,  popularly known as Sunset Point that offers the most awe-inspiring backdrop of the sunset against grazing Sambhars and Gaurs, magnifying the natural splendor of the area. Aside from its diverse wildlife and bird population, the frequent sightings of Tigers roaming in the wild at Kanha Wildlife Sanctuary remain the most popular draw. </p>
                </div>
                
                <div class="highlightRooms text-center">
                    <div class="container">
                        <h2>HIGHLIGHT ROOMS 
                            <div class="recRotate">
                                <p class="recRotateIn"></p>
                            </div>
                        </h2>
                        <div class="roomsSliderBox">
                            <div class="col-sm-4">
                            
                                <div class="bottom-slider">
                                    <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="roomsTitle">
                                    <div class="pull-left"><a href="">SUPER DELUX ROOM</a> <i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                    <div class="pull-right"><i class="fa fa-bed" aria-hidden="true"></i> 4 Beded</div>
                                    <div class="clearfix"></div>
                                 </div>
                            
                            </div>
                            <div class="col-sm-4">
                                <div class="bottom-slider">
                                    <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="roomsTitle">
                                    <div class="pull-left"><a href="">DELUX ROOM</a> <i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                    <div class="pull-right"><i class="fa fa-bed" aria-hidden="true"></i> 2 Beded</div>
                                    <div class="clearfix"></div>
                                 </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="bottom-slider">
                                    <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room1.jpg" alt=""></div>
                                         </div>
                                     </div>
                                     <div class="owl-item-box">
                                        <div class="box-donations-item text-center">
                                            <div class="box-donation-logo"><img src="images/rooms/super-deluxe/room2.jpg" alt=""></div>
                                         </div>
                                     </div>
                                 </div>
                                 <div class="roomsTitle">
                                    <div class="pull-left"><a href="">TENT ROOM</a> <i class="fa fa-angle-right" aria-hidden="true"></i></div>
                                    <div class="pull-right"><i class="fa fa-bed" aria-hidden="true"></i> 6 Peoples</div>
                                    <div class="clearfix"></div>
                                 </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        
        <div class="extraInfo">
            <div class="col-sm-8">
                <h2>ABOUT MANGATTA</h2>
                <div class="aboutmangatta">
                    <div class="col-sm-4 padding-right-zero padding-right-zero-xs"><img width="100%" src="images/about-mangatta-img.jpg" alt=""></div>
                    <div class="col-sm-8 col-xs-12">
                        <p>Mangata is a Village in Rajnandgaon Tehsil in Rajnandgaon District of Chattisgarh State, India. It is located 22 KM towards East from District head quarters Rajnandgaon. 13 KM from Rajnandgaon. 55 KM from State capital Raipur, Joratarai(m) ( 3 KM ) , Murhipar ( 4 KM ) , Magarlota ( 5 KM ) , Fuljhar(f) ( 6 KM ) , Uparwah ( 6 KM ) are the nearby Villages to Mangata. <br><br>
    
    Mangata is surrounded by Durg Tehsil towards East , Bhilai Tehsil towards East , Dhamdha Tehsil towards North , Khairagarh Tehsil towards North.
                        </p>
                        <a class="btn btn-lg btn-warning exploreBtn" href="">EXPLORE MORE</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-sm-4">
                <h2>LATEST NEWS</h2>
                
                <?php foreach($getNews as $getNewsVal){ ?>
                <div class="latestnews">
                    <div class="col-sm-4 col-xs-4 padding-right-zero news-img"><img width="100%" src="<?php echo PATH_IMAGE."/latest-news/thumb/".$getNewsVal['News_Image'] ?>" alt=""></div>
                    <div class="col-sm-8 col-xs-8 news-title">
                        <div><?php echo $getNewsVal['News_Title'] ?></div>
                        <p>Posted on : <?php echo $getNewsVal['Date'] ?></p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php } ?>
                
            </div>
            <div class="clearfix"></div>
        </div>
        
        <div class="partners-bg2" style="position:relative;">
            <div class="container">
                <div class="partner-head2">
                    <div class="double-border2 hidden-xs pull-left"></div>
                    <div class="title pull-left text-center"><strong>VISITOR</strong> TESTIMONIALS<br><span>WHAT THEY SAID</span></div>
                    <div class="double-border2 hidden-xs pull-left"></div>
                    <div class="clearfix"></div>
                </div>
                
                <!-- testimonial -->   
                                     
                <div>
                    <div class="row">
                        <div class="container">
                            <div class="testimonial-slider owl-carousel">
                                
                                <div class="testimonial">
                                    <div class="pic">
                                        <img src="images/testimonial/p1.jpg" alt="">
                                    </div>
                                    <div class="visitorName">Ms. Rajini's</div>
                                    <div class="testimonial-review">
                                        <p class="testimonial-description">
                                            "This is my 2nd visit to Van Vinodan Resort and I think it was as good if not better than my 1st visit. I received a very warm welcome on my arrival and was shown to Room 112. which is a twin bedded airy room and very comfortable. They have ceiling fans and A/C which I hardly used. Although it was very hot when the sun was shining at night I was very comfortable with just the ceiling fan. The food was just as good as i remembered and the care and friendliness of Ranjit and Nandita along with their staff have made my stays here so memorable."
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="testimonial">
                                    <div class="pic">
                                        <img src="images/testimonial/p1.jpg" alt="">
                                    </div>
                                    <div class="visitorName">Ms. Rajini's</div>
                                    <div class="testimonial-review">
                                        <p class="testimonial-description">
                                            "This is my 2nd visit to Van Vinodan Resort and I think it was as good if not better than my 1st visit. I received a very warm welcome on my arrival and was shown to Room 112. which is a twin bedded airy room and very comfortable. They have ceiling fans and A/C which I hardly used. Although it was very hot when the sun was shining at night I was very comfortable with just the ceiling fan. The food was just as good as i remembered and the care and friendliness of Ranjit and Nandita along with their staff have made my stays here so memorable."
                                        </p>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Eof testimonial -->
                
            </div>
        </div>
        
        <div class="getintouch">
            <div class="partner-head2">
                <div class="double-border2 pull-left"></div>
                <div class="title pull-left text-center"><strong>GET IN</strong> TOUCH</div>
                <div class="double-border2 pull-left"></div>
                <div class="clearfix"></div>
            </div>
            <div>
                <div class="col-sm-3">
                    <h4>Location</h4>
                    <p>Van Vinodan Resort, Mangatta Rajnandgaon, Chhattisgarh.</p>
                </div>
                <div class="col-sm-3">
                    <h4>Desk Hours</h4>
                    <p><span class="text-warning">6AM to 11PM</span><br> Monday through Sunday</p>
                </div>
                <div class="col-sm-3">
                    <h4>Contact Info</h4>
                    <p><i class="fa fa-envelope" aria-hidden="true"></i> contact@example.com<br> <i class="fa fa-phone" aria-hidden="true"></i> 1800 123 456</p>
                </div>
                <div class="col-sm-3">
                    <h4>Connect with us now</h4>
                    <div class="social-icons">
                        <div class="ico-facebook">
                            <a href="">
                                <p class="anch1"><i class="fa fa-facebook" aria-hidden="true"></i></p>
                                <p class="anch2"><i class="fa fa-facebook" aria-hidden="true"></i></p>
                            </a>
                        </div>
                        <div class="ico-twitter">
                            <a href="">
                                <p class="anch1"><i class="fa fa-twitter" aria-hidden="true"></i></p>
                                <p class="anch3"><i class="fa fa-twitter" aria-hidden="true"></i></p>
                            </a>
                        </div>
                        <div class="ico-youtube">
                            <a href="">
                                <p class="anch1"><i class="fa fa-youtube" aria-hidden="true"></i></p>
                                <p class="anch4"><i class="fa fa-youtube" aria-hidden="true"></i></p>
                            </a>                                    
                        </div>
                        <div class="ico-pinterest">
                            <a href="">
                                <p class="anch1"><i class="fa fa-pinterest" aria-hidden="true"></i></p>
                                <p class="anch5"><i class="fa fa-pinterest" aria-hidden="true"></i></p>
                            </a>
                        </div>
                        <div class="ico-googleplus">                                
                            <a href="">
                                <p class="anch1"><i class="fa fa-google-plus" aria-hidden="true"></i></p>
                                <p class="anch6"><i class="fa fa-google-plus" aria-hidden="true"></i></p>
                            </a>
                        </div>
                        <div class="ico-linkedin">
                            <a href="">
                                <p class="anch1"><i class="fa fa-linkedin" aria-hidden="true"></i></p>
                                <p class="anch7"><i class="fa fa-linkedin" aria-hidden="true"></i></p>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>  	
</main>
<script type="text/javascript">
            
            $(window).scroll(function(){
                if ($(document).scrollTop() > 700){ 
                    $('.homeslider').hide();
                    
                    var imageUrl = "images/Dining.jpg";
                    $("body").css({'background-image':'url(' + imageUrl + ')', 'background-position':'bottom', 'background-attachment':'fixed'});
                } 
                else{
                    $('.homeslider').show();
                    $("body").removeAttr( "style" );
                }
                
            });

</script>

<?php include('footer.php'); ?>

<?php
if(!isset($_COOKIE[$cookie_name])) {
?>
<script type="text/javascript">  
    $(document).ready(function(){
        setTimeout(function() {
            $.fn.colorbox({href:"images/offers/<?php echo $getOffer[1]['Offer_Image'] ?>", open:true});  
        }, 15);
    });  
</script>
<?php } ?>