// JavaScript Document
$(document).ready(function(){
	
	$("#Tab2").hide();
	
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
		
		
	});
	
	//By default Book Now button will be disabled
	$("#bookRoomBtn").prop("disabled",true);
	
	// set 0 .subtotal value
	$(".subtotal").val("0");	
	
	////////////////////////////////////////////
	// on change of .totalRooms drop down
	////////////////////////////////////////////
	$(document).on("change", ".totalRooms", function(){
		
		var Id = $(this).attr("id");		
		var uniqueId = Id.split("-");
		
		var formdata = new FormData();
		formdata.append('type', "getTotalAmt");
		formdata.append('roomType', $("#roomType-"+uniqueId[1]).val());
		
		
		$.ajax({
		   type: "POST",
		   url: "global_curd.php",
		   data:formdata,
		   success: function(data){ //alert(data);
		   		
				var totalAmt = $("#room-"+uniqueId[1]).val() * data;
				$("#subTotal-"+uniqueId[1]).val(totalAmt);
				
				////////////////////////
				// call a function
				reCalulate();
				
				if($("#subTotal-"+uniqueId[1]).val()=="0"){
					
					var stotal = new Array();
					
					$(".subtotal").each(function(){
						stotal.push($(this).val());
					});
					
					//call a function
					//this function checks that
					//all subtotal is equals to 0(zero)
					checkIsZero();
					
					function checkSubtotal(subtotal) {
						return subtotal == 0;
					}
					
					function checkIsZero() {
						var result = stotal.every(checkSubtotal);
						
						//if all subtotal is equals to 0(zero)
						//then disable the #bookRoomBtn button
						if(result==true){
							$("#bookRoomBtn").prop("disabled",true);
						}
						else{
							$("#bookRoomBtn").prop("disabled",false);
						}
					}
					
				}
				else{
					$("#bookRoomBtn").prop("disabled",false);
				}
		   },
		   cache: false,
		   contentType: false,
		   processData: false
		});//eof ajax
		
		
	});
	
	///////////////////////////////////////
	//Function for calculating the amount
	///////////////////////////////////////
	function reCalulate(){
		var invoicetotal = 0;
		var noOfRooms = 0;
		var acAmt = 0;
		var extraBedAmt = 0;
		
		$(".subtotal").each(function(){
			invoicetotal = invoicetotal + parseFloat($(this).val());
		});
		
		$(".totalRooms").each(function(){
			noOfRooms = noOfRooms + parseInt($(this).val())
		});
		
		$("#noOfRooms").html(noOfRooms);
		
		var FinalAmt = parseInt($("#totalNights").val()) * invoicetotal;
		$("#displayTotalAmt").html(Math.round(parseFloat(FinalAmt)).toFixed(2));
		$("#TotalAmt").val(Math.round(parseFloat(FinalAmt)).toFixed(2))
	}//eof function
	
	
	//////////////////////////////////////////////
	// Get total nights on change of checkout date 
	//////////////////////////////////////////////
	$(document).on("change", "#chckout", function(){
		
		var formdata = new FormData();
		formdata.append('type', "getTotalNights");
		formdata.append('chckin', $("#chckin").val());
		formdata.append('chckout', $("#chckout").val());
		
		$.ajax({
		   type: "POST",
		   url: "global_curd.php",
		   data:formdata,
		   success: function(data){ //alert(data);
		   		
				$("#totalNights").val(data);
		   },
		   cache: false,
		   contentType: false,
		   processData: false
		});//eof ajax
	});
	
	/////////////////////////
	//Get the search results
	/////////////////////////
	$(document).on("click", "#searchRoomsBtn", function(){
		
		var formdata = new FormData();
		formdata.append('type', "getRooms");
		formdata.append('chckin', $("#chckin").val());
		formdata.append('totalNights', $("#totalNights").val());
		
		$.ajax({
		   type: "POST",
		   url: "global_curd.php",
		   data:formdata,
		   success: function(data){ //alert(data);
		   		
				$(".page-content").html(data);
		   },
		   cache: false,
		   contentType: false,
		   processData: false
		});//eof ajax
		
	});
	
	//////////////////////////////
	//Get the reservation details
	//////////////////////////////
	$(document).on("click", "#bookRoomBtn", function(){
		
		$("#Tab2").show();
		$("#Tab1").hide();
		$("#backBtn").show();
		
		var roomsTypeArray = new Array();
		var adultArray = new Array();
		var childArray = new Array();
		var TotalroomsArray = new Array();
		
		
		$(".totalRooms").each(function(){
			if($(this).val()!='0'){
				var Id = $(this).attr("id");		
				var uniqueId = Id.split("-");
				
				roomsTypeArray.push( $("#room-name-"+uniqueId[1]).val() );
				adultArray.push( $("#adult-"+uniqueId[1]).val() );
				childArray.push( $("#child-"+uniqueId[1]).val() );
				TotalroomsArray.push( $("#room-"+uniqueId[1]).val() );
			}
		});
		
		var formdata = new FormData();
		formdata.append('type', "getCheckoutDisplay");
		formdata.append('checkindate', $("#chckin").val());
		formdata.append('checkoutdate', $("#chckout").val());		
		formdata.append('totalNights', $("#totalNights").val());
		formdata.append('roomsTypeArray', roomsTypeArray);
		formdata.append('adultArray', adultArray);
		formdata.append('childArray', childArray);
		formdata.append('TotalroomsArray', TotalroomsArray);
		formdata.append('TotalAmt', $("#TotalAmt").val());
		
		$.ajax({
		   type: "POST",
		   url: "global_curd.php",
		   data:formdata,
		   success: function(data){ //alert(data);
		   		
				$("#checkout-info").html(data);
		   },
		   cache: false,
		   contentType: false,
		   processData: false
		});//eof ajax
		
	});
	
	///////////////////////////////////
	//Get Back to the #Tab1
	///////////////////////////////////
	$(document).on("click", "#backBtn", function(){
		$("#Tab2").hide();
		$("#Tab1").show();
		$("#backBtn").hide();
	});
	
	
	/////////////////////////////////////////
	//validation for booking contact details
	/////////////////////////////////////////
	$("#contactFrm ").validate({
	  rules: 
		{   
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
			idprof:
			{
				required: true,
			},
			iagree:
			{
				required: true,
			}
		   
		},
		messages:
		{
			iagree:"Please agree our terms & conditions to proceed."
		}
	});// eof validation
	
	///////////////////////////////////////
	//click on complete reservation button
	///////////////////////////////////////
	$(document).on("click", "#completeReservBtn", function(){
		
		if ($("#contactFrm").valid())
		{
			
		}
		
	});
	
})//eof ready function