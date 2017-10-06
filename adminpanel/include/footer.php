
        <!-- footer content -->
        <footer>
          <div class="pull-right">
          	Van Vinodan - The Resort.
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
      <!-- /page content -->
    </div>

</div>

  <script src="<?php echo PATH_JS_LIBRARIES ?>/bootstrap.min.js"></script>

  <!-- bootstrap progress js -->
  <script src="<?php echo PATH_JS_LIBRARIES ?>/progressbar/bootstrap-progressbar.min.js"></script>
  <!-- daterangepicker -->
  <script type="text/javascript" src="<?php echo PATH_JS_LIBRARIES ?>/moment/moment.min.js"></script>
  
  <script src="<?php echo PATH_JS_LIBRARIES ?>/custom.js"></script>
  <script src="<?php echo PATH_JS_LIBRARIES ?>/jquery.validate.js"></script>
  <script src="<?php echo PATH_JS_LIBRARIES ?>/tiny_mce/tiny_mce.js"></script>
  <script src="<?php echo PATH_JS_LIBRARIES ?>/van-vinodan.js"></script>
  <script type="text/javascript">
   <!--Time Picker Show here -->
	$(function () {
		$('.datetimepicker').datepicker({
			orientation: "top auto",
			forceParse: false,
			autoclose: true,
			dateFormat: 'dd-mm-yy',      
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
        $('.datetimepicker3').datepicker({
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
 </script>

</body>

</html>
