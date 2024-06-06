
<HTML>
<HEAD>
<TITLE>Upload Image to MySQL BLOB</TITLE>
<link href="css/form.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
<style>
.image-gallery {
    text-align:center;
}
.image-gallery img {
    padding: 3px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
    border: 1px solid #FFFFFF;
    border-radius: 4px;
    margin: 20px;
}
</style>
</HEAD>
<BODY>
    <form action="#"
        method="post" enctype="multipart/form-data">
        <div class="phppot-container tile-container">
            <label>Upload Image File:</label>
            <div class="row">
                <input name="image" id="image" type="file" class="full-width" />
            </div>
            <div class="row">
                <input type="submit" value="Submit" id="submit" name="submit" />
            </div>
        </div>
    </form>
    <?php


$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    
    include "connessione.php";
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
         
        // Allow certain file formats 
        $allowTypes = array('jpg','png','jpeg','gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            $imgContent = addslashes(file_get_contents($image)); 

            // Insert image content into database 
            echo $query = "INSERT INTO `tbl_image`(`imageId`, `imageData`) VALUES (null,'".$imgContent."')";
            $insert = $db_connection->query($query); 
            if($insert){    
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 

    echo $statusMsg;
} 





    /*
        if(isset($_POST['submit'])){ 
            //$imgData = file_get_contents($_FILES['userImage']['tmp_name']);
            $imgData = addslashes(file_get_contents($_FILES['userImage']['tmp_name'])); 
            $sql = "INSERT INTO `tbl_image` (`imageId`, `imageData`) VALUES (NULL,$imgData)";
            $result = $db_connection->query($sql);

        }
        
     */   
?>
</BODY>
</HTML>