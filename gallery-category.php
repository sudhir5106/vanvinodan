<?php 
require_once('config.php');
include('header.php'); 
//****************************************************************
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
$db = new DBConn();
//****************************************************************
$getCategory = $db->ExecuteQuery("SELECT c.Category_Id, Category_Name, Image_Path
		FROM tbl_category c
		LEFT JOIN tbl_image_upload imgup ON c.Category_Id = imgup.Category_Id
		WHERE imgup.MainImage = 1");
//****************************************************************
?>
<main>    
    <div class="middle-container">
        <div>
            <figure>
              <img src="images/resort.jpg" alt="The Van Vinodan Resort" width="100%">
            </figure>
        </div>
        <div class="innerPageTxt">
        	<div class="container">
            	<h1>Categories of Gallery</h1>
                <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam.</p>
            	<div class="category-grid">
                	<?php foreach($getCategory as $getCategoryVal){ ?>
                	<div class="col-sm-4">
                        
                        <div class="img-holder">
                            <img width='100%' height='100%' src="<?php echo PATH_UPLOAD_IMAGE.'/'.$getCategoryVal['Image_Path']; ?>" alt="" >
                            <div class="photo-caption">
                                <div class="media-center"><a href="photo-gallery.php?id=<?php echo $getCategoryVal['Category_Id']; ?>"><i class="fa fa-camera" aria-hidden="true"></i></a></div>
                                <div class="media-bottom"><a href="photo-gallery.php?id=<?php echo $getCategoryVal['Category_Id']; ?>"><?php echo $getCategoryVal['Category_Name']; ?></a></div>
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