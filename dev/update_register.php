<?php

// update register table

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

// $delar_id = $_POST['id'];

if(isset($_POST['submit_m'])) {
    $delar_id = $_POST['id'];
    $query_update = "UPDATE Register
               SET delar_name = '$_POST[delar_name]', 
                  contact_name = '$_POST[contact_name]', 
                  address = '$_POST[delar_address]'
             WHERE delar_id = '$delar_id'";
    $result = mysqli_query($conn, $query_update);
    if(! $result )
    {  
     die('Could not update data: ' . mysqli_error());
    }
    echo "<script type='text/javascript'>";
    echo "alert('Updated Successfully');";
    echo 'window.location.href = "modify.html";';
    echo "</script>";
}

mysql_close($conn);
?>

