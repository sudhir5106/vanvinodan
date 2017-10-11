// JavaScript Document
$(document).ready(function(){
	
	$('#loading').hide();
 	
 	//////////////////////////////////
	// on click of select room button
	//////////////////////////////////
	$(document).on('click','.selectRoomBtn',function(){
		var roomTypeId = $(this).attr('id');
		$("#roomInfo-"+roomTypeId).modal('show');
	});
 		
 	//////////////////////////////////
	// on click of room checkbox /////
	// get the room info /////////////
	//////////////////////////////////
	$(document).on('click','.roomid',function(){

		var roomId = $(this).val();

		if(this.checked) {
			var formdata = new FormData();
			formdata.append('type', "getRoomsFrm");
			formdata.append('roomId', roomId);
			formdata.append('nightsCount',$("#nightsCount").val())
			
			$.ajax({
			   type: "POST",
			   url: "reservation_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
			   		
					$("#roomData tbody").append(data);
					calculate();
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
			
		}
		else{
			$("#row-"+roomId).remove();
			calculate();
		}		
		
	});//eof click event

	//////////////////////////////////
	// on change of adult drop down //
	//////////////////////////////////
	$(document).on("change", ".adultdd", function(){
		
		var Id = $(this).attr("id");		
		var uniqueId = Id.split("-");
		
		var capacity = $("#capacity-"+uniqueId[1]).val();		
		var childCount = 0;
		
		if(capacity==1){
			switch($(this).val()) {
				case '1':
					childCount = 0;
					break;
			}
		}
		else if(capacity==2){
			switch($(this).val()) {
				case '1':
					childCount = 1;
					break;
				case '2':
					childCount = 0;
						
			}
		}
		else if(capacity==3){
			switch($(this).val()) {
				case '1':
					childCount = 2;
					break;
				case '2':
					childCount = 1;
					break;
				case '3':
					childCount = 0;
						
			}
		}
		else if(capacity==4){
			switch($(this).val()) {
				case '1':
					childCount = 3;
					break;
				case '2':
					childCount = 2;
					break;
				case '3':
					childCount = 1;
					break;
				case '4':
					childCount = 0;
						
			}
		}
		else if(capacity==5){
			switch($(this).val()) {
				case '1':
					childCount = 4;
					break;
				case '2':
					childCount = 3;
					break;
				case '3':
					childCount = 2;
					break;
				case '4':
					childCount = 1;
					break;
				case '5':
					childCount = 0;
						
			}
		}
		else if(capacity==6){
			switch($(this).val()) {
				case '1':
					childCount = 5;
					break;
				case '2':
					childCount = 4;
					break;
				case '3':
					childCount = 3;
					break;
				case '4':
					childCount = 2;
					break;
				case '5':
					childCount = 1;
					break;
				case '6':
					childCount = 0;
						
			}
		}
		
		var i = 0;
		var itrateItem = new Array();
		
		while(i <= childCount){
			itrateItem.push( '<option value="'+i+'" >'+i+'</option>' );
			i++;
		}
		
		$("#child-"+uniqueId[1]).html(itrateItem);
		
		
	});//eof change event

	//////////////////////////////////
	// on keyup of extra guest textbox
	//////////////////////////////////
 	$(document).on("keyup", ".extraGuest", function(){

 		var Id = $(this).attr("id");		
		var uniqueId = Id.split("-");

		if($(this).val()!=0){
 			$("#guestCount").html($(this).val());
 			var totalGuestFare = parseFloat($("#extraGuestFare-"+uniqueId[1]).val()) * parseFloat($(this).val());
 			$("#extraFare-"+uniqueId[1]).val(totalGuestFare);

 			var total = parseFloat($("#baseFare-"+uniqueId[1]).val()) + parseFloat(totalGuestFare);
 			$("#total-"+uniqueId[1]).val(total);

 			calculate();

 		}
 		else{
 			$("#guestCount").html("");
 			$("#extraFare-"+uniqueId[1]).val("0");
 			$("#total-"+uniqueId[1]).val($("#baseFare-"+uniqueId[1]).val());

 			calculate();
 		}
 		


 	});//eof keyup event
	
	//************************************
	//Function for calculate subtotal,
	//SGST, CGST and Grand Total
	//************************************
	function calculate(){
		var totalAmt = 0;
		
		$(".total").each(function() {			
			totalAmt = totalAmt + parseFloat($(this).val());
		});//eof each function

		$("#subtotal").val(totalAmt);
		
		var gst = (totalAmt * 9) / 100;
		$("#sgst").val(gst);
		$("#cgst").val(gst);
		
		var grandTotal = totalAmt + (gst*2);
		$("#grand-total").val(grandTotal);

	}//eof function


});//eof ready function