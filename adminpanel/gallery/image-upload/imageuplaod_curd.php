<?php 
include('../../../config.php'); 
require_once(PATH_LIBRARIES.'/classes/DBConn.php');
require_once(PATH_LIBRARIES.'/functions/fun1.php');
$db = new DBConn();

$pathmulti = ROOT."/images/img-gallery/";
$pathmulti1 = ROOT."/images/img-gallery/thumb/";

///*******************************************************
/// Validate that the data already exist or not //////////
///*******************************************************
if($_POST['type']=="validate")
{

	$sql="SELECT Section_Name FROM image_section WHERE Section_Name='".$_POST['image_name']."' AND Section_Id<>".$_REQUEST['id'];
	$res=$db->ExecuteQuery($sql);
		
	if(empty($res))
    {
 		echo 0;
    }
	else
	{
		echo 1;
	}

}

///*******************************************************
/// To Insert New Images /////////////////////////////////
///*******************************************************
if($_POST['type']=="addImageupload")
{	

	$con= mysql_connect(SERVER,DBUSER,DBPASSWORD);
	mysql_query('SET AUTOCOMMIT=0',$con);
	mysql_query('START TRANSACTION',$con);
	
	try
	{		
		$gallary = $_FILES['imageupload']['name'];
		
		$i=0;
		foreach($gallary as $gallaryval)
		{
		
			$tmp2 = $_FILES['imageupload']['tmp_name'];			
			$image=explode('.',$gallaryval);
			$gallary_image = time().$i.'.'.$image[1]; //rename the file name
		
			if(move_uploaded_file($tmp2[$i], $pathmulti.$gallary_image))
			{
				// move the image in the thumb folder
				$resizeObj1 = new resize($pathmulti.$gallary_image);
				$resizeObj1 ->resizeImage(200,200,'auto');
				$resizeObj1 -> saveImage($pathmulti1.$gallary_image, 100);
				
				$CheckQuery=$db->ExecuteQuery("SELECT Image_Id FROM tbl_image_upload WHERE MainImage=1 AND Category_Id='".$_POST['category']."'");
				
				if(count($CheckQuery)==0)
				{			
					$sql1="insert into tbl_image_upload(Image_Path, MainImage, Category_Id) values('".$gallary_image."','1','".$_POST['category']."')";
				}
				else{
					$sql1="insert into tbl_image_upload(Image_Path, Category_Id) values('".$gallary_image."','".$_POST['category']."')";				
				}
				
			 	$res1=mysql_query($sql1);
				
				if(!$res1)
				{
					throw new Exception('0');
				}
			
				$i++;
			}
		}//end of foreach
	
	    echo 1;
		mysql_query("COMMIT",$con);
			
	}
	catch(Exception $e)
	{
		echo  $e->getMessage();
		mysql_query('ROLLBACK',$con);
		mysql_query('SET AUTOCOMMIT=1',$con);
	}
}

///*******************************************************
/// Edit Sub category
///*******************************************************
if($_POST['type']=="editCategory")
{
		
	$tblfield=array('Category_Id','Sub_Name','Position','Sub_Desc','Langauge');
	$tblvalues=array($_POST['category'],$_POST['subcategory'],$_POST['position'],$_POST['desc'],$_POST['langauge']);
	$condition="Sub_Id=".$_POST['id'];
	$res=$db->updateValue('sub_category',$tblfield,$tblvalues,$condition);
	
	if (empty($res))
	{
		//echo mysql_error();
		echo 0;
	}
	else
	{
		echo 1;
	}
}


 ///*******************************************************
/// Delete row from Plant table
///*******************************************************
if($_POST['type']=="delete")
{
	$res=$db->ExecuteQuery("Select Sub_Id FROM sub_category  where Sub_Id=".$_POST['id']."");
	
	//Check HEre If Category  is used than you can not delete the row
	 if(count($res)>0)
	 {
		$tblname="sub_category";
		$condition="Sub_Id=".$_POST['id'];
		$res=$db->deleteRecords($tblname,$condition);
		if($res)
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	 }
	 else
	 {
	
		echo 0;
	}
}
///*******************************************************
/// Onchange Langauge
///*******************************************************
if($_POST['type']=="getCategory")
{

	$sql="SELECT Category_Name, Category_Id FROM category WHERE  Langauge='".$_REQUEST['id']."'";
	$res=$db->ExecuteQuery($sql);
	
	echo '<option value="">Select Category</option>';
	foreach($res as $val)
	{
		echo '<option value="'.$val['Category_Id'].'">'.$val['Category_Name'].'</option>';	
	}

}


///*******************************************************
/// Delete gallery Images
///*******************************************************
if($_POST['type']=="deletegallerymultiimg")
{
	
 foreach($_POST['id'] as $deleteVal)
 {
	  
		$sql="SELECT Image_Path FROM tbl_image_upload WHERE Image_Id =".$deleteVal;
		$imagename=$db->ExecuteQuery($sql);
		
		$tblname="tbl_image_upload";
		$condition="Image_Id =".$deleteVal;
		$res=$db->deleteRecords($tblname,$condition);
		foreach($imagename as $image)
		{
			if($image['Image_Path']!="")
				{
					unlink($pathmulti.$image['Image_Path']);
					unlink($pathmulti1.$image['Image_Path']);
			    }
		}
		
 }
}

///*******************************************************
/// make main image
///*******************************************************
if($_POST['type']=="makemainimage")
{
	
     $res1=mysql_query("update tbl_image_upload set MainImage=0 WHERE Category_Id='".$_POST['book_id']."'");	
	 $res=mysql_query("update tbl_image_upload set MainImage=1 where Category_Id='".$_POST['book_id']."' AND Image_Id=".$_POST['id']."");
	 		
	if(empty($res))
		{
		  echo 0;
		}
		else
		{
		  echo 1;
		}
} 

//*****************************************************
// Image Showing
//*****************************************************
if($_POST['type']=='imageShow')
{
	
	////////Get Gallery Image
$gallery_list=$db->ExecuteQuery("SELECT * FROM tbl_image_upload WHERE Category_Id='".$_POST['category']."'");

if($gallery_list)
{	
?>
    <div class="form-group">
        <div class="col-sm-12">
          <input title="Select All" type="checkbox" id="selecctallgallery"/>
          <button title="Delete" type="button" class="btn btn-danger btn-sm " id="deletegalleryimage" name="deletegalleryimage"> <span class="glyphicon glyphicon-trash"></span> Delete All</button>
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <?php 
             $i=1;
              foreach($gallery_list as $value){ 
               ?>
          <div class="col-sm-3 imgBlck">
            <div class="bg-success">
              <input title="Set As Base Image" type="radio" class="select mainimage" name="mainimage"  value="<?php echo $value['Image_Id'];?>" <?php if($value['MainImage']==1){ echo "checked ";}?> />
              Base Image </div>
            	<div class="galleryImg"><img width="100%" src="<?php echo PATH_UPLOAD_IMAGE."/thumb/".$value['Image_Path'];?>" alt="" /></div>
            <div>
             
            </div>
            <div>
              <?php if($value['MainImage']!=1){?>
              <input type="checkbox" class="deletegallery" id="<?php echo $value['Image_Id'];?>"/>
              <?php } ?>
              
            </div>
          </div>
          <?php $i++; }?>
    </div>
 <?php } 
 
 }?>