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
			
			$.ajax({
			   type: "POST",
			   url: "reservation_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
			   		
					$("#roomData tbody").append(data);
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
		}
		else{
			$("#row-"+roomId).remove();
		}
		
		
	});
 	
	
});//eof ready function