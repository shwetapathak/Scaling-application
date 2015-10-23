<?
session_start();
require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;
 $username = $_SESSION['user'];
 echo $username;
 $db = new pdo('mysql:unix_socket=/cloudsql/assignment7-1001:assgn7;dbname=scale',
  'root',    
  'shweta'      
  );
  $fetchData = $db->prepare("select * from images where username = '$username' ");
  $fetchData->execute();
  echo "<table border='2'>";
echo '<tr>';

echo '<th>FileName:</th>';
echo '<th>Image:</th>';
echo '<th>FileSize:</th>';
echo '<th>FileURL:</th>';
echo '</tr>';


while($row = $fetchData->fetch()) {
	
    $filename = $row['filename'];

    $filesize = $row['filesize'];

    $fileurl = $row['fileurl'];
    echo '<tr>';
	
    echo '<td>'.$filename.'</td>';
    echo '<td>'.$filesize.'</td>';
	echo '<td>';
    echo "<img src='" . $fileurl . "'></img><form action = 'delete.php' method='POST' ><input type='submit' name= 'submit' value='delete'>";
	if(isset($_POST['delete']))
{
	$delete = $db->prepare("delete from images where fileurl = '$fileurl'");
	$delete->exceute();
}
	echo '</form>';
	echo '</td>';
	echo '<td>'.$fileurl.'</td>';
    echo '</tr>';

    }

echo '</table>';


  
?>
