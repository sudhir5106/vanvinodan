// JavaScript Document
$(document).ready(function(){
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
				// calls a function
				reCalulate();
				
				if($("#subTotal-"+uniqueId[1]).val()=="0"){
					$("#bookRoomBtn").prop("disabled",true);
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
	
	////////////////////////////////////////////
	// on change of .acAmt checkbox
	////////////////////////////////////////////
	$(document).on("click", ".acAmt", function(){
		
		////////////////////////
		// calls a function
		reCalulate();		
		
	});
	
	////////////////////////////////////////////
	// on change of .extraBedAmt checkbox
	////////////////////////////////////////////
	$(document).on("click", ".extraBedAmt", function(){
		
		////////////////////////
		// calls a function
		reCalulate();		
		
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
		
		$(".acAmt").each(function(){
			if($(this).prop('checked') == true)
			{
				acAmt = acAmt + parseInt($(this).val())
			}
		});
		
		$(".extraBedAmt").each(function(){
			if($(this).prop('checked') == true)
			{
				extraBedAmt = extraBedAmt + parseInt($(this).val())
			}
		});
		
		$("#noOfRooms").html(noOfRooms);
		
		var FinalAmt = parseInt(acAmt) + parseInt(extraBedAmt) + (parseInt($("#totalNights").val()) * invoicetotal);
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
		
		alert($("#chckin").val());		
		
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
	
	
})//eof ready function