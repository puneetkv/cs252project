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
	$query = "SELECT userName,userId FROM `users` WHERE gender='$gndr'";
	//$frnd=mysql_fetch_array($query);


if ($result = mysql_query($query)) {
	
	$store_name_array= array();
	$store_id_array= array();
    /* fetch associative array */

    while ($row = mysql_fetch_assoc($result)) {
      //  printf ("%s (%s)\n", $row["userName"], $row["userId"]);
	array_push($store_name_array,$row["userName"]);
	array_push($store_id_array,$row["userId"]);
	
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
             <button type="submit" class="btn btn-block btn-primary" name="btn-gender">Click here</button>
            </div></form>
<?php
for( $i=0 ; $i< count($store_name_array);$i++){

echo "<button>$store_id_array[$i]</button>";
echo '
<form  method="post" action="test.php">
 <input type="hidden" name="userid" value="'.$userRow['userId'].'"/>
 <input type="hidden" name="friend" value="'.$store_id_array[$i].'"/> 
<input type="submit" value="submit"/>
</form>';

echo $store_name_array[$i];
echo "<br>";
}
?>
</div>
<div>
<h2>Friends</h2>
<?php
$json_data = file_get_contents('myTutorials.txt');
$data = json_decode($json_data);
$friends=explode(",",$data[$userRow['userId']]->requests);
$n = count($friends);

for($i=0;$i< $n;$i++)
{
	
$res1=mysql_query("SELECT * FROM users WHERE userId=".$friends[$i]);
 $userRow1=mysql_fetch_array($res1);
echo $userRow1['userName']."<br>";
}

?>
</div>

  
    <script src="assets/jquery-1.11.3-jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    
</body>
</html>
<?php ob_end_flush(); ?>
