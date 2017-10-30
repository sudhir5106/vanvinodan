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
 			$("#totalFare-"+uniqueId[1]).val(total);

 			calculate();

 		}
 		else{
 			$("#guestCount").html("");
 			$("#extraFare-"+uniqueId[1]).val("0");
 			$("#totalFare-"+uniqueId[1]).val($("#baseFare-"+uniqueId[1]).val());

 			calculate();
 		}

 	});//eof keyup event

 	//////////////////////////////////
	// on click of delete icon ///////
	//////////////////////////////////
 	$(document).on("click", ".drow", function(){
 		var Id = $(this).attr('id');
 		var rowid = Id.split("-");

 		$("#row-"+rowid[1]).remove();
 		$("#rmid-"+rowid[1]).attr('checked', false);

 		calculate();

 	});

 	/////////////////////////////////////////
	//validation for Room Booking details
	/////////////////////////////////////////
	$("#bookingFrm").validate({
	  rules: 
		{   
		  	subtotal:{
		  		required: true,	
		  		subtotalIsZero: true,
		  	},
		  	paidAmt:{
		  		required: true,	
		  		paidAmtIsZero: true,
		  		paidAmtIsNotGreater: true,
		  	},
		  	fullname: 
			{ 
				required: true,
			},
			email:
			{
				required: true,
				email:true
			},
		   	phone:
			{
				required: true,
				number:true,
				minlength: 10,
				maxlength: 11
			},
			idprof:{
				required: true
			}
		   
		},
		messages:
		{
			subtotal:{required:"Please Select Any Room"}
		}
	});// eof validation

	///////////////////////////////////////////////////
	// Method to check the data is equals to 0 or not
	///////////////////////////////////////////////////
	$.validator.addMethod('subtotalIsZero', function(val, element)
	{		
		
		if($("#subtotal").val()!=0){
			data = 1;
			var isSuccess=(data==1)?true:false;
		}
		return isSuccess ;				
	}, 'Please Select Any Room');

	///////////////////////////////////////////////////
	// Method to check the data is equals to 0 or not
	///////////////////////////////////////////////////
	$.validator.addMethod('paidAmtIsZero', function(val, element)
	{		
		
		if($("#paidAmt").val()!=0){
			data = 1;
			var isSuccess=(data==1)?true:false;
		}
		return isSuccess ;				
	}, 'Please Pay Some Amount');

	//////////////////////////////////////////////////////////////
	// Method to check the data is greater than GRAND TOTAL or not
	//////////////////////////////////////////////////////////////
	$.validator.addMethod('paidAmtIsNotGreater', function(val, element)
	{		
		var isSuccess;
		var GT = $("#grand-total").val();
		var PA = $("#paidAmt").val(); 

		$.ajax({
			 url:"reservation_curd.php",
			 type: "POST",
			 data: {type:"paidAmtIsNotGreater", GT:GT, PA:PA},
			 async:false,
			 success:function(data){ //alert(data);
				 isSuccess=(data==1)?true:false;
			 }
			 
		});//eof ajax
		return isSuccess ;

	}, 'Please Do Not Enter The Amount More Than Grand Total');

	///////////////////////////////////////
	//click on complete reservation button
	///////////////////////////////////////
	$(document).on("click", "#completeBtn", function(){

		if($("#bookingFrm").valid())
		{
			$('#loading').show();

			var roomsIdArray = new Array();
			var adultArray = new Array();
			var childArray = new Array();
			var basefareArray = new Array();
			var extraGuestArray = new Array();
			var totalRoomFareArray = new Array();
			
			var TotalGuestAmt = 0;
			
			$(".Roomid").each(function(){
				if($(this).val()!='0'){
					var Id = $(this).attr("id");		
					var uniqueId = Id.split("-");
					
					roomsIdArray.push( $("#roomId-"+uniqueId[1]).val() );
					adultArray.push( $("#adult-"+uniqueId[1]).val() );
					childArray.push( $("#child-"+uniqueId[1]).val() );
					basefareArray.push( $("#baseFare-"+uniqueId[1]).val() );
					extraGuestArray.push( $("#extraFare-"+uniqueId[1]).val() );
					totalRoomFareArray.push( $("#totalFare-"+uniqueId[1]).val() );

					TotalGuestAmt=parseFloat(TotalGuestAmt)+parseFloat($("#extraFare-"+uniqueId[1]).val());
				}
			});
			

			var formdata = new FormData();
			formdata.append('type', "insertReservationInfo");
			formdata.append('checkindate', $("#chckin").val());
			formdata.append('checkoutdate', $("#chckout").val());

			formdata.append('roomsIdArray', roomsIdArray);
			formdata.append('adultArray', adultArray);
			formdata.append('childArray', childArray);
			formdata.append('basefareArray', basefareArray);
			formdata.append('extraGuestArray', extraGuestArray);
			formdata.append('totalRoomFareArray', totalRoomFareArray);

			formdata.append('TotalGuestAmt', TotalGuestAmt);
			formdata.append('subtotal', $("#subtotal").val());
			formdata.append('sgst', $("#sgst").val());
			formdata.append('cgst', $("#cgst").val());
			formdata.append('grandTotal', $("#grand-total").val());
			formdata.append('PaidAmt', $("#paidAmt").val());

			formdata.append('clientname', $("#fullname").val());
			formdata.append('email', $("#email").val());
			formdata.append('phone', $("#phone").val());
			formdata.append('file', $('input[id=idprof]')[0].files[0]);
			
			//Ajax start from here
			$.ajax({
			   type: "POST",
			   url: "reservation_curd.php",
			   data:formdata,
			   success: function(data){ alert(data);
					
					if(data!=0){
						$('#loading').hide();
						window.location.replace("../index.php");						
					}
					else{ 
						window.location.replace("index.php");
					}
					
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof Ajax
			

		}

	});// eof completeReservBtn



	
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