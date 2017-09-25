<?php 
require_once('config.php');
include('header.php'); 
//****************************************************************
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
//****************************************************************
$getGallery = $db->ExecuteQuery("SELECT Category_Name, Image_Path
		FROM tbl_image_upload imgup
		LEFT JOIN  tbl_category c ON imgup.Category_Id = c.Category_Id
		WHERE c.Category_Id=".$_GET['id']);
//****************************************************************
?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
<style>
.gallery
{
    display: inline-block;
    margin-top: 20px;
}
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
<script>
	$(document).ready(function(){
    //FANCYBOX
    //https://github.com/fancyapps/fancyBox
    $(".fancybox").fancybox({
        openEffect: "none",
        closeEffect: "none"
    });
});
</script>
<main>    
    <div class="middle-container">
        <div>
            <figure>
              <img src="images/resort.jpg" alt="The Van Vinodan Resort" width="100%">
            </figure>
        </div>
        <div class="innerPageTxt">
        	<div class="container">
            	<h1><a href='gallery-category.php'>Gallery</a> <i class="fa fa-angle-right" aria-hidden="true"></i> <?php echo $getGallery[1]['Category_Name']; ?></h1>
            	<p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam.</p>
            	<div class="category-grid">
                	<?php foreach($getGallery as $getGalleryVal){ ?>
                	<div class="col-sm-3">
                        
                        <div class="img-holder2">
                            <img width='100%' height='100%' src="<?php echo PATH_UPLOAD_IMAGE.'/thumb/'.$getGalleryVal['Image_Path']; ?>" alt="" >
                            <div class="photo-caption">
                                <div class="media-center"><a class="fancybox" rel="ligthbox" href="<?php echo PATH_UPLOAD_IMAGE.'/'.$getGalleryVal['Image_Path']; ?>"><i class="fa fa-camera" aria-hidden="true"></i></a></div>
                            </div>
                        </div>
                        
                    </div>
                	<?php } ?>
                </div>
            </div>
        </div>
        
    </div>  	
</main>
<?php include('footer.php'); ?>