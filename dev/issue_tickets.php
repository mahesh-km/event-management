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

$event_date = $_POST['event_date'];
$date = new DateTime($event_date);
$event_date = $date->format('Y-m-d');


$pass = $_POST['pass_rq'];
$delar_id = $_POST['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// create ticket
if(!isset($pass) || trim($pass) == ''){
	echo "<script type='text/javascript'>";
        echo "alert('Please input number of pass required');";
        echo 'window.location.href = "user_search.html";';
        echo "</script>";
}
else
{
	$query_select = "SELECT * FROM `Ticket_info` WHERE `delar_id` = '$delar_id'";
	$result = mysqli_query($conn, $query_select);
	if (mysqli_num_rows($result) > 0) {
	    $auto_ticket_id = uniqid();	
	    $ticket_date = date("Y-m-d");
	    $query_update = "UPDATE Ticket_info
    		SET ticket_id = '$auto_ticket_id', 
	            pass_no = '$_POST[pass_rq]', 
        	    ticket_date = '$ticket_date',
                    event_date = '$event_date'
	       WHERE `delar_id` = '$delar_id'";

	    $result = mysqli_query($conn, $query_update);

	if ($conn->query($query_update) === TRUE)
	{
        $query_select =  "SELECT `Register`.`delar_name`, `Register`.`contact_name`, `Register`.`phone_mob`,  `Register`.`email`, `Register`.`delar_dist`, `Ticket_info`.`ticket_id`, `Ticket_info`.`ticket_date`, `Ticket_info`.`event_date`, `Ticket_info`.`pass_no` from `Register` INNER JOIN `Ticket_info` ON `Register`.`delar_id` = `Ticket_info`.`delar_id` and `Ticket_info`.`ticket_id` = '$auto_ticket_id'";

        $result = mysqli_query($conn, $query_select);

        if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $last_id = $row['ticket_id'];
                        echo "<html>";
                        echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
                        echo "<form action='http://mascotautomobiles.com/dev/option_page.html' >";
                        echo "<ul>";
                        echo "<li>Ticket No : {$row['ticket_id']} </li>";
                        echo "<li>Delar Name: {$row['delar_name']} </li>";
                        echo "<li>Email     : {$row['email']}</li>";
                        echo "<li>Mobile    : {$row['phone_mob']}</li>";
                        echo "<li>District  : {$row['delar_dist']}</li>";
                        echo "<li>No. Pass issued: {$row['pass_no']}</li>";
                        echo "<li>Ticket Date: {$row['ticket_date']}</li>";
			echo "<li>Event Date: {$row['event_date']}</li>";
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

}

else {

$auto_ticket_id = uniqid();

$ticket_date = date("Y-m-d");

$sql = "INSERT INTO Ticket_info (ticket_id, pass_no, ticket_date, event_date, delar_id) VALUES ('$auto_ticket_id', '$_POST[pass_rq]', '$ticket_date', '$event_date', '$delar_id')";

if ($conn->query($sql) === TRUE) 
{
	//$last_id = $conn->insert_id;
	$query_select =  "SELECT `Register`.`delar_name`, `Register`.`contact_name`, `Register`.`phone_mob`,  `Register`.`email`, `Register`.`delar_dist`, `Ticket_info`.`ticket_id`, `Ticket_info`.`ticket_date`, `Ticket_info`.`event_date`, `Ticket_info`.`pass_no` from `Register` INNER JOIN `Ticket_info` ON `Register`.`delar_id` = `Ticket_info`.`delar_id` and `Ticket_info`.`ticket_id` = '$auto_ticket_id'";

	$result = mysqli_query($conn, $query_select);

	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $last_id = $row['ticket_id'];
			echo "<html>";
			echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
			echo "<form action='http://mascotautomobiles.com/dev/option_page.html' >";
			echo "<ul>";
			echo "<li>Ticket No : {$row['ticket_id']} </li>";
			echo "<li>Delar Name: {$row['delar_name']} </li>";
			echo "<li>Email     : {$row['email']}</li>";
			echo "<li>Mobile    : {$row['phone_mob']}</li>";
			echo "<li>District  : {$row['delar_dist']}</li>";
			echo "<li>No. Pass issued: {$row['pass_no']}</li>";
			echo "<li>Ticket Date: {$row['ticket_date']}</li>";
                        echo "<li>Event Date: {$row['event_date']}</li>";
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

}
}
$conn->close();

?> 

