// JavaScript Document
$(document).ready(function(){

	//////////////////////////////////
	//  form validation
	////////////////////////////////////
    $("#changePassword ").validate({
	  rules: 
		{   
		  	old_pwd: 
			{ 
				required: true,
				equalTo: "#password"
			},
			new_pwd:
			{
				required: true,
				minlength: 6,
				maxlength: 15,
			},
		   con_pwd:
			{
				required: true,
				equalTo: "#new_pwd"
			},
		   
		},
		messages:
		{
			old_pwd: 
			{ 				
				equalTo: "Incorrect Old Password"
			},
			con_pwd:
			{				
				equalTo: "Password does not Match"
			},
		}
	});// eof validation
	
	
	//////////////////////////////////
	// on click of submit button
	//////////////////////////////////
	$('#submit').click(function(){
	  if ($("#changePassword").valid())
		{			
						
			var x;
			$.ajax({
			   type: "POST",
			   url: "change_password_curd.php",
			   data: {type: "changePassword", new_pwd:$('#new_pwd').val(),adminId:$('#adminId').val()},
			   async: false,
			   success: function(data){ //alert(data);
			   $('#success').show();
			   $('#success').html(data);
				   x=data;
			   },
			  
			});//eof ajax
		
			if(x!=0)
			{
				//location.reload();
			}
			else{
			
				$('#warning').show();
			   	$('#warning').html("Password does not Match");	
				
			}
		}
		
	});	
	

		
});// JavaScript Document