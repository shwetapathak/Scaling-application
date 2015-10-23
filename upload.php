<?
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
$options = [ 'gs_bucket_name' => 'shweta' ];
$upload_url = CloudStorageTools::createUploadUrl('/upload_handler.php', $options);

?>
<form action="<?php echo $upload_url?>" enctype="multipart/form-data" method="post">
    Files to upload: <br>
   <input type="file" name="uploaded_file" size="40">
   <input type="submit" value="Upload">
</form>    
<form action="delete.php" enctype="multipart/form-data" method="post">
	<input type="submit" value="Delete Image">
</form>
<form action="comment.php" enctype="multipart/form-data" method="post">
	<input type="submit" value="Post Comment">
</form>
