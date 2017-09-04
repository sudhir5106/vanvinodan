<footer>
        	<div class="footer-bg">
            	<div class="container">
                	<div class="text-center suncrosTxt">Copyright 2017 - <span>Van Vinodan The Resort</span> - All Rights Reserved.<br>
                    Developed by <a target="_blank" href="http://www.suncrosonline.com"><img src="images/suncrosonline.png" alt=""></a></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </footer>
        <script src="js/multi-select-1.js"></script>
        <script src="js/van-vinodan.js"></script>

        <script type="text/javascript">
			
			// An array of dates
			//var array = ["2017-08-31","2017-09-01","2017-09-02"];
			
			
		   <!--Time Picker Show here -->
			$(function () {
				$('.datetimepicker').datepicker({
					orientation: "top auto",
					//changeYear: true,
					forceParse: false,
					autoclose: true,
					dateFormat: 'dd-mm-yy',
					minDate: 0,
					
					/*beforeShowDay: function(date){
						var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
						return [ array.indexOf(string) == -1 ]
					},*/ // This is to show Booked Rooms Details
					
					//numberOfMonths: 2 // to display 2 months at a time
				});
			});
			<!--Datepicker Show here-->
			
			 
			<!--Time Picker Show here -->
			$(function () {
				$('.datetimepicker2').datepicker({
					orientation: "top auto",
					//changeYear: true,
					forceParse: false,
					autoclose: true,
					dateFormat: 'dd-mm-yy',
					minDate: 1, // Disable Past Dates
					//maxDate: new Date // Disable future dates
				});
			});
			<!--Datepicker Show here-->
			
			
			$(document).ready(function(){
				
				$('.searchRooms').hide();
				
				$(document).on('click','.bookBtn', function(){
					
					var hasClass = $( ".searchRooms" ).hasClass( "animated" );
					// hasClass is boolean
					if(hasClass === true)
					{
						 $('.searchRooms').removeClass("fadeOutDown").removeClass("animated");
					}

					$('.searchRooms').addClass("fadeInDown").addClass("animated");
					$('.searchRooms').show();
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
					$('.searchRooms').hide();
					//$(".searchRooms").css({'z-index':'98'});
					
				});
				
			});//eof ready function
			
			
			
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