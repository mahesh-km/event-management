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


$conn->close();

?>