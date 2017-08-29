<footer>
        	<div class="footer-bg">
            	<div class="container">
                	<div class="text-center suncrosTxt">Copyright 2017 - <span>Van Vinodan The Resort</span> - All Rights Reserved.<br>
                    Developed by <a target="_blank" href="http://www.suncrosonline.com"><img src="images/suncrosonline.png" alt=""></a></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </footer>

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
			

		   <!--Time Picker Show here -->
			$(function () {
				$('.datetimepicker').datepicker({
					orientation: "top auto",
					forceParse: false,
					autoclose: true,
					dateFormat: 'dd-mm-yy'
				});
			});
			<!--Datepicker Show here-->
			
			
			$(document).ready(function(){
				
				$(document).on('click','.bookBtn', function(){
					
					var hasClass = $( ".searchRooms" ).hasClass( "animated" );
					// hasClass is boolean
					if(hasClass === true)
					{
						 $('.searchRooms').removeClass("fadeOutDown").removeClass("animated");
					}

					$('.searchRooms').addClass("fadeInDown").addClass("animated");
					//$(".searchRooms").css({'z-index':'100'});
					
				});
				
				$(document).on('click','.closeBtn', function(){
					
					var hasClass = $( ".searchRooms" ).hasClass( "animated" );
					// hasClass is boolean
					if(hasClass === true)
					{
						 $('.searchRooms').removeClass("fadeInDown").removeClass("animated");
					}
					
					$('.searchRooms').addClass("fadeOutDown").addClass("animated");
					//$(".searchRooms").css({'z-index':'98'});
					
				});
				
			});
			
			
			
			$(".testimonial-slider").owlCarousel({
				loop:true,
				margin:10,
				autoplay:true,
				autoplayTimeout:8000,
				autoplayHoverPause:false,
				responsiveClass:true,
				responsive:{
					0:{
						items:1,
						nav:true
					},
					600:{
						items:1,
						nav:false
					},
					1024:{
						items:1,
						nav:true,
						loop:false
					},
					1200:{
						items:1,
						nav:true,
						loop:false
					},
					
					1600:{
						items:1,
						nav:true,
						loop:false
					}
				}
			});
		
			$('.bottom-slider').owlCarousel({
					loop:true,
					dots: false,
					margin:10,
					autoplay:true,
					autoplayTimeout:4000,
					autoplayHoverPause:false,
					responsiveClass:true,
					responsive:{
						0:{
							items:1,
							nav:true
						},
						600:{
							items:1,
							nav:false
						},
						1024:{
							items:1,
							nav:true,
							loop:false
						},
						1200:{
							items:1,
							nav:true,
							loop:false
						},
						
						1600:{
							items:1,
							nav:true,
							loop:false
						}
					}
				});
		
		</script>
        
	</body>
</html>