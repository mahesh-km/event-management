<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query_select = "SELECT `delar_name`, `email`, `delar_dist`, `pass` FROM `Register` WHERE `delar_id` = '10'";

$result = mysqli_query($conn, $query_select);

if (mysqli_num_rows($result) > 0) {
echo "<ul>";
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
echo "<li>Delar ID  : {$row['delar_id']}</li>";
echo "<li>Delar Name: {$row['delar_name']} </li>";
echo "<li>Email     : {$row['email']}</li>";
echo "<li>District  : {$row['delar_dist']}</li>";
echo "<li>No. Tickets issued: {$row['pass']}</li>";
}
echo "</ul>";
} else {
echo "Query didn't return any result";
}

                    $query_select = "SELECT `Register`.`delar_name`, `Register`.`contact_name`, `Register`.`email`, `Register`.`pass`, `CheckIn`.`checkin_date`, `CheckIn`.`checkin_time`, `CheckIn`.`checkin_tkt`  from `Register` INNER JOIN `CheckIn` ON `Register`.`delar_id` = '$_POST[delar_id]'";
                     $result = mysqli_query($conn, $query_select);
                     if (mysqli_num_rows($result) > 0) {
                         while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                         echo "<html>";
                         echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
                         echo "<form action='http://mascotautomobiles.com/dev/checki-in.html' >";
                         echo "<ul>";
                         echo "<li>Delar ID  : $delarid </li>";
                         echo "<li>Delar Name: {$row['delar_name']} </li>";
                         echo "<li>Contact Name: {$row['contact_name']} </li>";
                         echo "<li>Email     : {$row['email']}</li>";
                         echo "<li>Check-in Date    : {$row['checkin_date']}</li>";
                         echo "<li>Check-in Time    : {$row['checkin_time']}</li>";
                         echo "<li>No. Tickets issued: {$row['pass']}</li>";
                         echo "<li>No. Tickets Check-in: {$row['checkin_tkt']}</li>";
                         echo "<button type='submit'>Done</button>";
                         echo "</form>";
                         echo "</html>";
                         }

$conn->close();

?>
