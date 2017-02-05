<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

$delarid = $_POST['delar_id'];
$no_of_tkt_checkin = $_POST['checkin_tkts'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

function AlertMsg($message) {
	echo "<script type='text/javascript'>";
        echo "alert('$message');";
        echo 'window.location.href = "check-in.html";';
        echo "</script>";
}
if(!isset($delarid) || trim($delarid) == ''){
   AlertMsg("Please input a valid delar id");
}
else {
   $query_select = "SELECT *  FROM `Register` WHERE delar_id = '$_POST[delar_id]'";
   $result = mysqli_query($conn, $query_select);
   if (mysqli_num_rows($result) > 0) {
      if(!isset($no_of_tkt_checkin) || trim($no_of_tkt_checkin) == ''){
         AlertMsg("Please input checkin ticket details"); 
      }
      else {
         $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
         if ($no_of_tkt_checkin <= $row['pass']) {
             $no_of_tkt_issued = $row['pass'];
             $query_select = "SELECT *  FROM `CheckIn` WHERE delar_id = '$_POST[delar_id]'";
             $result = mysqli_query($conn, $query_select);
	     if (mysqli_num_rows($result) > 0) {
                 AlertMsg("Check-in chance already over for this Delar");
             }
             else {
	         $checkin_date = date("Y-m-d");
		 $checkin_time = date("H:i:s");
  		 $query_checkin = "INSERT INTO CheckIn (`checkin_date`, `checkin_time`, `checkin_tkt`, `delar_id`) VALUES ('$checkin_date', '$checkin_time','$_POST[checkin_tkts]', '$_POST[delar_id]')";
                 if ($conn->query($query_checkin) === TRUE) {
		     $last_checkin_id = $conn->insert_id;
                     $query_select = "SELECT `delar_id`, `checkin_date`,`checkin_time`, `checkin_tkt` FROM CheckIn WHERE `checkin_id` = '$last_checkin_id'";
		     $result = mysqli_query($conn, $query_select);
		     if (mysqli_num_rows($result) > 0) {
	                 while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                       	 echo "<html>";
			 echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
			 echo "<form action='http://mascotautomobiles.com/dev/check-in.html' >";
                         echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>";
                         echo "<h1>Check-in completed!</h1>";
                         echo "</div>";
			 echo "<ul>";
			 echo "<li>Delar ID  : {$row['delar_id']} </li>";
			 echo "<li>Check-in Date    : {$row['checkin_date']}</li>";
			 echo "<li>Check-in Time    : {$row['checkin_time']}</li>";
			 echo "<li>No. Tickets issued: $no_of_tkt_issued</li>";
			 echo "<li>No. Tickets Check-in: {$row['checkin_tkt']}</li>";
			 echo "<button type='submit'>Done</button>";
			 echo "</form>";
	                 echo "</html>";
			 }
                     }
                     else {
		         echo "Query didn't return any result";
	             }     
                }	
             }	
  	 }    
         else {
                    AlertMsg("No. of tickets entered more than actually issued");
	   	}		
       
      }   
   }
   else {  
           AlertMsg("Delar ID not valid, please check again."); 
       }
   }	



?>
