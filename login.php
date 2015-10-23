<html>
<body>
<h1>LOGIN</H1><br>
<form action= "" enctype="multipart/form-data" method="post">
    Enter Username:  <input type="text" name = "username">
    Enter Password:   <input type="password" name = "password">
    
    <input type="submit" value="Send">
</form>


<?php


$db = new pdo('mysql:unix_socket=/cloudsql/assignment7-1001:assgn7;dbname=scale',
  'root',  // username
  'shweta'       // password
  );
if ($_SERVER["REQUEST_METHOD"] == "POST"){

$user=$_POST['username'];
$pass=$_POST['password'];



$statement=$db->prepare("select user_name, password from User_Info where user_name='$user' and password='$pass'");

$statement->execute();
$row = $statement->fetch();
echo $row['username'];

if($row>0)
{
	session_start();
	$_SESSION['user'] = $user;
	

    header("Location: upload.php");
    echo '<meta http-equiv="refresh" content="0; URL=http://assignment7-1001.appspot.com/upload.php">';
}

}
?>

</body>
</html>