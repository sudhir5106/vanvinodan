// JavaScript Document
$(document).ready(function(){
	
	$('#loading').hide();
 
	//////////////////////////////////
	// Add News form validation
	////////////////////////////////////
    $("#roomCatform").validate({
	  rules: 
		{ 
			
			rcatname: 
			{ 
				required: true,
			},
			capacity:
			{
				required:true,
				number:true
			},
			basefare:
			{
				required:true,
				number:true
			},
			airconditionfare:
			{
				required:true,
				number:true
			},
			extrabedfare:
			{
				required:true,
				number:true
			},
			desc: 
			{ 
				required: true,				
			},
			amenities: 
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
	$('#submit').click(function(){
     
		flag=$("#roomCatform").valid();
		
		if (flag==true)
		{	
		
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "addRoomCategory");

			formdata.append('rcatname', $("#rcatname").val());
			formdata.append('capacity', $("#capacity").val());
			formdata.append('basefare', $("#basefare").val());
			formdata.append('airconditionfare', $("#airconditionfare").val());
			formdata.append('extrabedfare', $("#extrabedfare").val());
			formdata.append('desc', $("#desc").val());
			formdata.append('amenities', $("#amenities").val());

			$.ajax({
			   type: "POST",
			   url: "roomcategory_curd.php",
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
		
		flag=$("#roomCatform").valid();
		
		if (flag==true)
		{			
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "editRoomCategory");
			formdata.append('id', $("#id").val());
			
			formdata.append('rcatname', $("#rcatname").val());
			formdata.append('capacity', $("#capacity").val());
			formdata.append('basefare', $("#basefare").val());
			formdata.append('airconditionfare', $("#airconditionfare").val());
			formdata.append('extrabedfare', $("#extrabedfare").val());
			formdata.append('desc', $("#desc").val());
			formdata.append('amenities', $("#amenities").val());
			
			var x;
			$.ajax({
			   type: "POST",
			   url: "roomcategory_curd.php",
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
				url:"roomcategory_curd.php",
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