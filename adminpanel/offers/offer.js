// JavaScript Document
$(document).ready(function(){
	
	$('#loading').hide();
 
	//////////////////////////////////
	// Add Offer form validation
	////////////////////////////////////
    $("#offerform").validate({
	  rules: 
		{ 
			
			offertitle:
			{
				required:true,
			},
			published_date: 
			{ 
				required: true,
			},
			expiry_date: 
			{ 
				required: true,				
			},
			fileupload:
			{
				required:true,
			}
			
		},
		messages:
		{
		}
	});// eof validation

	//////////////////////////////////
	// Edit Offer form validation
	////////////////////////////////////
    $("#offerEditform").validate({
	  rules: 
		{ 
			
			offertitle:
			{
				required:true,
			},
			published_date: 
			{ 
				required: true,
			},
			expiry_date: 
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
     
		flag=$("#offerform").valid();
		
		if (flag==true)
		{	
		
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "addOffer");
			formdata.append('offertitle', $("#offertitle").val());
			formdata.append('published_date', $("#published_date").val());
			formdata.append('expiry_date', $("#expiry_date").val());
			formdata.append('file', $('input[id=fileupload]')[0].files[0]);

			$.ajax({
			   type: "POST",
			   url: "offer_curd.php",
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
		
		flag=$("#offerEditform").valid();
		
		if (flag==true)
		{			
			$('#loading').show();
			
			///////////////////////////////////
			//Check News Image Uploaded or not
			///////////////////////////////////
			var image='';
			var imageval='';
						
			if($("#fileupload").val().length>0)
			{
				image=$("#fileupload").prop('files')[0];
				imageval=1;
			}
			
			var formdata = new FormData();
			formdata.append('type', "editOffer");
			formdata.append('id', $("#id").val());
			
			formdata.append('image', image);
			formdata.append('imageval', imageval);
			formdata.append('offer-img', $('#offer-img').val());
			formdata.append('file', $('input[id=fileupload]')[0].files[0]);
			
			formdata.append('offertitle', $("#offertitle").val());
			formdata.append('published_date', $("#published_date").val());
			formdata.append('expiry_date', $("#expiry_date").val());			
			
			var x;
			$.ajax({
			   type: "POST",
			   url: "offer_curd.php",
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
				url:"offer_curd.php",
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
	
	//////////////////////////////////////////
	//Search Filter Write HEre ///////////////
	//////////////////////////////////////////
	$(document).on('click','#search',function()
	{
		
			var x;
			$.ajax({
				url:"filter_report.php",
				type: "POST",
				data: {type:"searchList",heading:$('#heading').val(),date:$('#date').val()},
				async:false,
				success: function(data){ 
				$('#add').html(data);
				//alert(data);
				}
			});
				
	
	});

	//////////////////////////////////////////
	// on click of Block or Unblock button
	//////////////////////////////////////////
	$(document).on('click', '.status', function() { 
		
		var id = $(this).attr("id");
		
		var formdata = new FormData();
			formdata.append('type', "changeStatus");
			formdata.append('id', id);
			
			$.ajax({
			   type: "POST",
			   url: "offer_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
				   window.location.replace("list.php");
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
	});
	
});

	

