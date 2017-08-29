// JavaScript Document
$(document).ready(function(){
	
	$('#loading').hide();
 
	//////////////////////////////////
	// Add News form validation
	////////////////////////////////////
    $("#roomform").validate({
	  rules: 
		{ 
			
			rcatname: 
			{ 
				required: true,
			},
			roomName:
			{
				required:true,
			}
			
		},
		messages:
		{
		}
	});// eof validation
	
	
	//////////////////////////////////
	// on click of submit button
	//////////////////////////////////
	$('#submit').click(function(){
     
		flag=$("#roomform").valid();
		
		if (flag==true)
		{	
		
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "addRoom");

			formdata.append('rcatname', $("#rcatname").val());
			formdata.append('roomName', $("#roomName").val());

			$.ajax({
			   type: "POST",
			   url: "room_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
				   
				   $('#loading').hide();
				   
				   if(data==1)
					{	
						$( "#dialog1" ).dialog({
								dialogClass: "alert",
								buttons: {
								 'Ok': function() {
									window.location.replace("list.php");
									}
								}
						});
					}
					else
					{
					 			
						$( "#dialog2" ).dialog({
								dialogClass: "alert",
								buttons: {
								 'Ok': function() {
									window.location.replace("index.php");
									}
								}
						});
						
					}
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax		
			
		}// eof if condition
		
	});
	
    /////////////////////////////////
	// on click of edit button
	/////////////////////////////////		
	$('#update').click(function(){
		
		flag=$("#roomform").valid();
		
		if (flag==true)
		{			
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "editRoom");
			formdata.append('id', $("#id").val());
			
			formdata.append('rcatname', $("#rcatname").val());
			formdata.append('roomName', $("#roomName").val());
			
			var x;
			$.ajax({
			   type: "POST",
			   url: "room_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
				   
				   $('#loading').hide();
				   
				   if(data==1)
					{						 	
						$( "#dialog" ).dialog({
							dialogClass: "alert",
							buttons: {
							 'Ok': function() {
								window.location.replace("list.php");
								}
							}
						});
					}
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
			
		}// eof if condition
		
	});
	
	
	//////////////////////////////////
	// on click of delete button
	//////////////////////////////////	
	$(document).on('click', '.delete', function() {
		
		var didConfirm = confirm("Are you sure?");
	   	
		if (didConfirm == true) {
			var id=$(this).attr("id");
			
			$.ajax({
				url:"room_curd.php",
				type: "POST",
				data: {type:"delete",id:id},
				success: function(data){ //alert(data);
				
					$('#loading').hide();
					
					if(data==1)
					{						
						$( "#deletemsg" ).dialog({
							dialogClass: "alert",
							buttons: {
							 'Ok': function() {
								window.location.replace("list.php");
								}
							}
						});
					}
				
				}
			});
			
	    }
	});
	
	
	
	
});//eof ready function