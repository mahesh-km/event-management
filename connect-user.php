<?php
//define('DB_SERVER', 'localhost');
//define('DB_NAME', 'macxzistudios');
//define('DB_USER','root');
//define('DB_PASSWORD','Vy0m@123');

$con = mysqli_connect("localhost","root","root","mascotautomobiles");
if (!$con) {
die("Failed to connect to MySQL: " . mysqli_error());
}
//$db = mysqli_select_db($con,DB_NAME);
//if (!$db) {
//die("Failed to connect to MySQL: " . mysqli_error());
//}

/*
$ID = $_POST['user'];
$Password = $_POST['pass'];
*/

function SignIn()
{
session_start();   //starting the session for user 
if(!empty($_POST['user']))   //checking the 'user' name which is from Sign in html.
{ 
        $con = mysqli_connect("localhost","root","root","mascotautomobiles"); 
	$query = mysqli_query($con,"SELECT *  FROM UserName where UserName = '$_POST[user]' AND pass = '$_POST[pass]'");
	$row = mysqli_fetch_array($query);
	if(!empty($row['UserName']) AND !empty($row['pass']))
	{
		$_SESSION['UserName'] = $row['pass'];
                header("location:reg.html");
                
	}
	else
	{
		echo "Sorry!...Wrong ID and Password, Please try again!.";
	}
}
}


if(isset($_POST['submit']))
{
	SignIn();
}

?>

