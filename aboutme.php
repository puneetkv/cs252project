
<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }

$w=$_SESSION['user'];

$www = $_POST['fileToUpload'];
$insert_img = mysql_query("UPDATE `users` SET aboutMe = '$www' WHERE userId = '$w'");


if ($insert_img)  {
# code...
echo "Img inserted successfully";
}
else{
 echo "There is something wrong with this code. Eff!";
}

header("Location: home.php");

?>

