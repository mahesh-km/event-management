<?php

// update register table

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

$delar_id = $_POST['id'];

if(isset($_POST['submit_m'])) {
    $delar_id = $_POST['id'];
    $query_update = "UPDATE Register
               SET delar_name = '$_POST[delar_name]', 
                  contact_name = '$_POST[contact_name]', 
                  salesman_name = '$_POST[salesman_name]',
                  email = '$_POST[delar_email]',
                  address = '$_POST[delar_address]',
                  phone_mob = '$_POST[delar_mobile]',
                  land_phone = '$_POST[delar_land]',
                  delar_dist = '$_POST[delar_district]',
                  tin_no = '$_POST[tin_no]'
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

