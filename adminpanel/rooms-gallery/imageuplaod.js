// JavaScript Document
$(document).ready(function(){
		$('#loading').hide();
 
	//////////////////////////////////
	// Add Sector form validation
	////////////////////////////////////
    $("#categoryform").validate({
	  rules: 
		{ 
			
			category:
			{
				required:true,
			},
			imageupload: 
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
	$(document).on('click','#submit',function(){
     
		flag=$("#categoryform").valid();
		
		if (flag==true)
		{	
			$('#submit').hide();
		 	$('#loading').attr('style','display:block');
			
			var totalFiles = document.getElementById("imageupload").files.length;
			if(totalFiles<1)
			{
				$('#errmsg').show();
				$('#errmsg').append("image is required");;
				return false;
			}
			var formdata = new FormData();
			formdata.append('type', "addImageupload");
			formdata.append('category', $("#category").val());
			
			for (var i = 0; i < totalFiles; i++) {
				var file = document.getElementById("imageupload").files[i];
				formdata.append("imageupload[]", file);  //Use [] to add multiple.
			}
			
			var x;
			$.ajax({
			   type: "POST",
			   url: "imageuplaod_curd.php",
			   data:formdata,
			   cache: false,
			   contentType: false,
			   processData: false,
			   beforeSend: function() {
        			$('#loading').show();
   			   },
			   success: function(data){ //alert(data);
				   x=data;
			   },
			   complete: function(data){ //alert(data);
				  $('#loading').hide();
				  $('#submit').show();
				  if(x==1)
					{	
						$('#loading').hide();		
						$("#dialog1").dialog({
								dialogClass: "alert",
								buttons: {
								 	'Ok': function() {
										window.location.replace("index.php");
									}
								}
						});
					}
				   else
					{
					 	$('#loading').hide();		
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
			   
			});//eof ajax
		
			
		}// eof if condition
		
	});
	
   
	/////////////////////////////////////////
	//OnChange category Get Gallery Images
	/////////////////////////////////////////
	$(document).on('change','#category',function()
	{
			var formdata = new FormData();
			formdata.append('type', "imageShow");
			formdata.append('category', $(this).val());
			
			$("#loding").show();
			
			$.ajax({
			   type: "POST",
			   url: "imageuplaod_curd.php",
			   data:formdata,
			   success: function(data){ //alert(data);
				   $('#imageShow').html(data);
				   $("#loding").hide();
			   },
			   cache: false,
			   contentType: false,
			   processData: false
			});//eof ajax
	})

});


	//////////////////////////////////
	// on click of delete button
	//////////////////////////////////
	$(document).on('click',"#deletegalleryimage",function(){
		
		var i=0;
			 var delete_id = [];	
		     $('.deletegallery').each(function(){
	       
		      if($(this).prop('checked') == true)		 
		      {
				  delete_id.push($(this).attr("id"));
				  i++;
		      }
	     });
		 if(i==0){
			
			alert("Please Select Any One Option"); 
			 
			 }
			// alert(delete_id);
			if(i!=0){
				 //alert("Are you sure? ")
				 var didConfirm = confirm("Are you sure?");
				 if(didConfirm==true)
				 {
				// alert(delete_id);
				$("#loding").show();
		
				
			$.ajax({
				url:"imageuplaod_curd.php",
				type: "POST",
				data: {type:"deletegallerymultiimg",id:delete_id},
				//async:false,
				success: function(data){ //alert(data);
				location.reload();
				}
			});
			
	    }
			}
	});		
	
//On click Checked The All THE LIST	
$(document).on('change',".deletegallery",function (event) { 
          if($('#selecctallgallery').prop('checked') == true)	{	
	          $('#selecctallgallery').attr('checked',false); 	
		  }
        }); 
		
	$(document).on('click','#selecctallgallery',function(event) {  //on click 
        if(this.checked) { // check select status
            $('.deletegallery').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"               
            });
        }
		else { // check select status
            $('.deletegallery').each(function() { //loop through each checkbox
                this.checked = false;  //select all checkboxes with class "checkbox1"               
            });
        }
		
    });
	
	//////////////////////////////////
	// on click of radio btn
	//////////////////////////////////
	$(document).on('click',".mainimage",function(){
		
		var didConfirm = confirm("Are you sure ?");
	    if (didConfirm == true) {
			var id=$(this).val();
			var book_id=$('#category').val();
			
			$("#loding").show();
			$.ajax({
				url:"imageuplaod_curd.php",
				type: "POST",
				data: {type:"makemainimage",id:id,book_id:book_id},
				async:false,
				success: function(data){///alert(data);
				$("#loding").hide();
				}
			});
			//location.reload();
	    }
	});		
	
//Search Filter Write HEre
$(document).on('click','#search',function()
{
	
		var x;
		$.ajax({
			url:"filter_report.php",
			type: "POST",
			data: {type:"searchList",langauge:$('#langauge').val(),category:$('#category').val(),subcategory:$('#subcategory').val(),imagename:$('#imagename').val()},
			async:false,
			success: function(data){ 
			$('#add').html(data);
			//alert(data);
			}
		});
			

});
