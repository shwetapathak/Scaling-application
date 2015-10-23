<?php
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;

$fileName = 'gs://shweta/'.$_FILES['uploaded_file']['name'];
echo $fileName."<br>";

$options = array('gs'=>array('acl'=>'public-read','Content-Type' => $_FILES['uploaded_file']['type']));
$ctx = stream_context_create($options);

if (false == rename($_FILES['uploaded_file']['tmp_name'], $fileName, $ctx)) {
  die('Could not rename.');
}

$object_public_url = CloudStorageTools::getPublicUrl($fileName, true);
echo $object_public_url."<br>";

$filename = $_FILES['uploaded_file']['name'];
echo $filename."<br>";
$filesize = $_FILES['uploaded_file']['size'];
echo $filesize."<br>";

$db = new pdo('mysql:unix_socket=/cloudsql/assignment7-1001:assgn7;dbname=scale',
  'root',  
  'shweta'   
  );

$username = $_SESSION['user'];
echo $username;
$insertStatememt = $db->prepare("insert into images values('$username','$filename','$filesize','$object_public_url')");
$insertStatememt->execute();
$stm = $db->prepare("select * from images");
$stm->execute();

// Displaying all the uploaded files in a web page.

echo "<table border='2'>";
echo '<tr>';

echo '<th>FileName:</th>';
echo '<th>Image:</th>';
echo '<th>FileSize:</th>';
echo '<th>FileURL:</th>';
echo '</tr>';


while($row = $stm->fetch()) {
	
    $filename = $row['filename'];

    $filesize = $row['filesize'];

    $fileurl = $row['fileurl'];
    echo '<tr>';
	
    echo '<td>'.$filename.'</td>';
    echo '<td>'.$filesize.'</td>';
	echo '<td>';
    echo "<img src='" . $fileurl . "'></img>";
    echo '</td>';
	echo '<td>'.$fileurl.'</td>';
    echo '</tr>';

    }

echo '</table>';

?>
<html>
<body>
<form action= "upload.php" enctype="multipart/form-data" method="post">
    <input type="submit" value="go back">
       
    </form>

