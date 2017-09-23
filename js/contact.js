// JavaScript Document
$(document).ready(function(){
 
	//////////////////////////////////
	// Add feedback form validation
	////////////////////////////////////
    $("#feedbackform").validate({
	  rules: 
		{ 			
			name:
			{
				required:true,
			},
			emailId: 
			{ 
				required: true,
				email:true,				
			},
			subject: 
			{ 
				required: true,			
			},
			msg:
			{
				required: true,
			}
			
		},
		messages:
		{
		}
	});// eof validation
	
	
	//////////////////////////////////
	// on click of submit button
	//////////////////////////////////
	$(document).on("click","#submit", function(){
		
		flag=$("#feedbackform").valid();
		
	});// eof click function
	
});//eof ready function


