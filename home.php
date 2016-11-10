<?php
 ob_start();
 session_start();
 require_once 'dbconnect.php';
 
 // if session is not set this will redirect to login page
 if( !isset($_SESSION['user']) ) {
  header("Location: index.php");
  exit;
 }


if ( isset($_POST['btn-gender']) ) {

 $gndr = trim($_POST['gndr']);

if (empty($gndr)) {
   $error = true;
   $gndrError = "Please enter m or f.";
  }

if( !$error ) {
	$query = "SELECT userName,userId,image,aboutMe FROM `users` WHERE gender='$gndr'";
	//$frnd=mysql_fetch_array($query);


if ($result = mysql_query($query)) {
	
	$store_name_array= array();
	$store_id_array= array();
	$store_image_array= array();
	$store_aboutme_array= array();
    /* fetch associative array */

    while ($row = mysql_fetch_assoc($result)) {
      //  printf ("%s (%s)\n", $row["userName"], $row["userId"]);
	array_push($store_name_array,$row["userName"]);
	array_push($store_id_array,$row["userId"]);
	array_push($store_image_array,$row["image"]);
	array_push($store_aboutme_array,$row["aboutMe"]);
    }
	
	

    /* free result set */
    mysqli_free_result($result);
}

}


}


 // select loggedin users detail
 $res=mysql_query("SELECT * FROM users WHERE userId=".$_SESSION['user']);
 $userRow=mysql_fetch_array($res);

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['userEmail']; ?></title>
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>


  <div id="navbar" class="navbar-collapse collapse">
       
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class="glyphicon glyphicon-user"></span>&nbsp; Welcome to this site <?php echo $userRow['userName']; ?>&nbsp;<span class="caret"></span></a>


              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div>

<img src="documents/<?php echo $userRow['image'];?>"  width="175" height="200" />

<!--upload image-->
<div></div>

<form action="upload.php" method="post" enctype="multipart/form-data">
     <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>


<div id="navbar" class="navbar-collapse collapse">
       
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
     <span class="glyphicon glyphicon-user"></span>&nbsp; About me: <?php echo $userRow['aboutMe']; ?>&nbsp;<span class="caret"></span></a>



<form action="aboutme.php" method="post" enctype="multipart/form-data">
     <input type="text" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Edit" name="submit">
</form>



<div>
<h2>People</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
    

<div class="form-group">
             <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
             <input type="text" name="gndr" class="form-control" placeholder="Enter Gender" maxlength="1" value="<?php echo $gndr ?>" />
               </div>
		</div>
<div class="form-group">
             <button type="submit" class="btn btn-block btn-primary" name="btn-gender">Find</button>
            </div></form>

<?php echo "<br>"."<br>"; ?>
<?php
echo "<table>";
for( $i=0 ; $i< count($store_name_array);$i++){
echo "<tr>";
?>
<img src="documents/<?php echo $store_image_array[$i];?>"  width="40" height="40" />
<?php
echo $store_name_array[$i];
echo "<br>";
echo "Bio:".$store_aboutme_array[$i];
echo "<br>";
echo '
<form  method="post" action="test.php">
 <input type="hidden" name="userid" value="'.$userRow['userId'].'"/>
 <input type="hidden" name="friend" value="'.$store_id_array[$i].'"/> 
<input type="submit" value="Like"/>
</form>';
echo "<br>";
?>


<?php
echo "<br>";
echo "</tr>";
}
echo "</table>";
?>
</div>
<div>

<h2>Match</h2>
<?php
$json_data = file_get_contents('myTutorials.txt');
$data = json_decode($json_data);
$friends=explode(",",$data[$userRow['userId']]->friends);
$n = count($friends);
echo "Match"." ".$n;
echo "<br>";
echo "<table>";
for($i=0;$i< $n;$i++)
{
	
$res1=mysql_query("SELECT * FROM users WHERE userId=".$friends[$i]);
 $userRow1=mysql_fetch_array($res1);
echo $userRow1['userName']." ";
echo $userRow1['phone'];
echo "<br>";
}
echo "</table>";

?>
</div>

  
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>
