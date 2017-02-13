<?php
$con = mysqli_connect("localhost","root","root","mascotautomobiles");
if (!$con) {
die("Failed to connect to MySQL: " . mysqli_error());
}

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
                header("location:option_page.html");
                
	}
	else
	{
		echo "<script type='text/javascript'>";
                echo "alert('Sorry!...Wrong ID and Password, Please try again!');";
                echo 'window.location.href = "http://mascotautomobiles.com/dev/";';
                echo "</script>";
	}
}
}


if(isset($_POST['submit']))
{
	SignIn();
}

?>

