<?php  
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

$delar_email = $_POST['delar_email'];


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


if(!isset($delar_email) || trim($delar_email) == ''){
   AlertMsg("Please input a valid email address");
}
else {
     $query_select = "SELECT *  FROM `Register` WHERE `email` = '$_POST[delar_email]'";
     $result = mysqli_query($conn, $query_select);
     if (mysqli_num_rows($result) > 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Email address provided already registered with the system!');";
        echo 'window.location.href = "registration.html";';
        echo "</script>";
     }
     else {
	$sql = "INSERT INTO Register (delar_name, contact_name, salesman_name, email, address, phone_mob, land_phone, delar_dist, tin_no) VALUES ('$_POST[delar_name]', '$_POST[contact_name]', '$_POST[salesman_name]', '$_POST[delar_email]', '$_POST[delar_address]', '$_POST[delar_mobile]', '$_POST[delar_land]','$_POST[delar_district]', '$_POST[tin_no]')";

	if ($conn->query($sql) === TRUE) 
	{
	$last_id = $conn->insert_id;
        $query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `salesman_name`, `address`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `tin_no` FROM `Register` WHERE `delar_id` = '$last_id'";

        $result = mysqli_query($conn, $query_select);

        if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<html>";
                        echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
                        echo "<form action='http://mascotautomobiles.com/dev/registration.html' >";
			echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>";
                        echo "<h1>Delar Registered</h1>";
                        echo "</div>";
                        echo "<ul>";
                        echo "<li>Delar ID  : $last_id </li>";
                        echo "<li>Delar Name: {$row['delar_name']} </li>";
                        echo "<li>Contact Name: {$row['delar_name']} </li>";
                        echo "<li>Sales Man: {$row['delar_name']} </li>";
                        echo "<li>Address     : {$row['address']}</li>";
                        echo "<li>Email     : {$row['email']}</li>";
                        echo "<li>Mobile    : {$row['phone_mob']}</li>";
                        echo "<li>Phone Off.   : {$row['land_phone']}</li>";
                        echo "<li>District  : {$row['delar_dist']}</li>";
                        echo "<li>Tin No.: {$row['tin_no']}</li>";
                        echo "<button type='submit'>Done</button>";
                        echo "</form>";
                        echo "</html>";
                }
        }
        else
        {
                echo "Query didn't return any result";
        }

        } 
        else 
        {
	echo "Error: " . $sql . "<br>" . $conn->error;
        }

$conn->close();
  }
}
?> 

