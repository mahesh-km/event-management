<?php  
/*************************************************************  
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com  
 * Fee free to distribute and modify code, but keep reference to its creator  
 *  
 * This class generate QR [Quick Response] codes with proper metadata for mobile  phones  
 * using google chart api http://chart.apis.google.com  
 * Here are sources with free QR code reading software for mobile phones:  
 * http://reader.kaywa.com/  
 * http://www.quickmark.com.tw/En/basic/download.asp  
 * http://code.google.com/p/zxing/  
 *  
 * For more information, examples and online documentation visit:   
 * http://webcodingeasy.com/PHP-classes/QR-code-generator-class  
 **************************************************************/  
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

$reg_delar_id = uniqid();

$sql = "INSERT INTO Register (delar_id, delar_name, contact_name, salesman_name, email, address, phone_mob, land_phone, delar_dist, pass) VALUES ('$reg_delar_id', '$_POST[delar_name]', '$_POST[contact_name]', '$_POST[salesman_name]', '$_POST[delar_email]', '$_POST[delar_address]', '$_POST[delar_mobile]', '$_POST[delar_land]','$_POST[delar_district]', '$_POST[num_of_tickets]')";

if ($conn->query($sql) === TRUE) 
{
	//$last_id = $conn->insert_id;
        $last_id = $reg_delar_id;
        //echo $last_id; 
	//echo "<script type='text/javascript'>";
	//echo "alert('New record created successfully. Last inserted ID is: $last_id');";
	//echo "</script>";

	$query_select = "SELECT `delar_name`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `pass` FROM `Register` WHERE `delar_id` = '$last_id'";

	$result = mysqli_query($conn, $query_select);

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			echo "<html>";
			echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
			echo "<form action='http://mascotautomobiles.com/dev/registration.html' >";
			echo "<ul>";
			echo "<li>Delar ID  : $last_id </li>";
			echo "<li>Delar Name: {$row['delar_name']} </li>";
			echo "<li>Email     : {$row['email']}</li>";
			echo "<li>Mobile    : {$row['phone_mob']}</li>";
			echo "<li>District  : {$row['delar_dist']}</li>";
			echo "<li>No. Tickets issued: {$row['pass']}</li>";
			echo "<a href='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=$last_id' download='QR.png'>";
			echo "<p><img src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=$last_id' alt='QR code' border='0'/></p></a>";
                        echo "<script type='text/javascript'>";
    			echo "function myFunction()";
                        echo "{  window.print(); }";
                        echo "</script>";
                        echo "<button onclick='myFunction()'>Print</button>";
                        echo "<button type='submit' onclick=''>Email</button>";
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

?> 

