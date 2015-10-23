<html>
<body>
<h1> Sign up to post pictures</h1>
<form action= "main.php" enctype="multipart/form-data" method="post">
    Username:  <input type="text" name = "username" value="username">
    Password:   <input type="password" name = "password" value="password">
    
    <input type="submit" value="Send">
</form>


<?php


//echo "User Authentication";

$db = new pdo('mysql:unix_socket=/cloudsql/assignment7-1001:assgn7;dbname=scale',
  'root',  // username
  'shweta'       // password
  );
if ($_SERVER["REQUEST_METHOD"] == "POST"){

$user=$_POST['username'];
$pass=$_POST['password'];

$tableName = "User_Info";
$columnName = "user_name varchar(150) PRIMARY KEY, password varchar(120) " ;
$createTableUser = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$tableName ($columnName)");
$createTableUser->execute();

$tableImage= "images";
$columnImage = "username varchar(200), filename varchar(200),filesize varchar(200),fileurl varchar(200)" ;
$createTableImage = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$tableImage($columnImage)");
$createTableImage->execute();

$tab= "comments";
$col = "fileurl varchar(200),comment varchar(200),comment_id int(20) AUTO INCREMENT" ;
$createTab = $db->prepare("CREATE TABLE IF NOT EXISTS scale.$tab($col)");
$createTab->execute(); 
$insertStatement = $db->prepare("insert into User_Info values('$user','$pass')");
$insertStatement->execute(); 

$selectStatement=$db->prepare("select user_name, password from User_Info where user_name='$user' and password='$pass'");

$selectStatement->execute();
$row = $selectStatement->fetch();

if($row>0)
{
	session_start();
	$_SESSION['user'] = $user;
    header("Location: login.php");
    echo '<meta http-equiv="refresh" content="0; URL=http://assignment7-1001.appspot.com/login.php">';
}

}
?>

</body>
</html>