// JavaScript Document
$(document).ready(function(){
	
	$('#loading').hide();
 
	//////////////////////////////////
	// Add News form validation
	////////////////////////////////////
    $("#newsform").validate({
	  rules: 
		{ 
			
			published_date: 
			{ 
				required: true,
			},
			newstitle:
			{
				required:true,
			},
			desc: 
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
     
		flag=$("#newsform").valid();
		
		if (flag==true)
		{	
		
			$('#loading').show();
			
			var formdata = new FormData();
			formdata.append('type', "addNews");
			formdata.append('published_date', $("#published_date").val());
			formdata.append('newstitle', $("#newstitle").val());			
			formdata.append('file', $('input[id=fileupload]')[0].files[0]);			
			formdata.append('desc', $("#desc").val());

			$.ajax({
			   type: "POST",
			   url: "news_curd.php",
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
		
		flag=$("#newsform").valid();
		
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
			formdata.append('type', "editNews");
			formdata.append('id', $("#id").val());
			
			formdata.append('image', image);
			formdata.append('imageval', imageval);
			formdata.append('news-img', $('#news-img').val());
			
			formdata.append('published_date', $("#published_date").val());
			formdata.append('newstitle', $("#newstitle").val());			
			formdata.append('file', $('input[id=fileupload]')[0].files[0]);			
			formdata.append('desc', $("#desc").val());
			
			var x;
			$.ajax({
			   type: "POST",
			   url: "news_curd.php",
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
				url:"news_curd.php",
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
	
	//OnChange Lange GEt Sub Category
	$(document).on('change','#langauge',function()
	{
			var id=$(this).val();
			var x;
			$.ajax({
				url:"subcategory_curd.php",
				type: "POST",
				data: {type:"getCategory",id:id},
				async:false,
				success: function(data){ 
				$('#category').html(data);
				//alert(data);
				}
			});
			
	
	})
	
	
	//Search Filter Write HEre
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
			   url: "news_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
				   window.location.replace("list.php");
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
	});


	//Onclick Active And Unactive
	/*$(document).on('click','.checkStatus',function()
	{
		
			var id=$(this).attr('value');
			var x;
			$.ajax({
				url:"news_curd.php",
				type: "POST",
				data: {type:"CheckStatus",id:id},
				async:false,
				success: function(data){// alert(data);
					location.reload();
				}
			});
			
	
	})*/
	
	
});

	

