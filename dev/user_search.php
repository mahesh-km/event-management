<?php
// searching user information from database.

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


$query_select = "SELECT `delar_id`, `delar_name`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `pass` FROM `Register` WHERE `delar_id` = '$_POST[delar_id]'";
        
$result = mysqli_query($conn, $query_select);
        
        if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<html>";
                        echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
                        echo "<form action='http://mascotautomobiles.com/dev/user_search.html' >";
                        echo "<ul>";
                        echo "<li>Delar ID  : {$row['delar_id']} </li>";
                        echo "<li>Delar Name: {$row['delar_name']} </li>";
                        echo "<li>Email     : {$row['email']}</li>";
                        echo "<li>Mobile    : {$row['phone_mob']}</li>";
                        echo "<li>District  : {$row['delar_dist']}</li>";
                        echo "<li>No. Tickets issued: {$row['pass']}</li>";
                        echo "";
                        echo "<button type='submit'>Done!</button>";
                        echo "</form>";
                        echo "</html>";
                }
        }   

