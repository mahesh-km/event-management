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

if(isset($_POST['submit_t'])) {
    $update_id = $_POST['id'];
    $query_update = "UPDATE Register
               SET delar_name = '$_POST[col1]', 
                  contact_name = '$_POST[col2]', 
                  salesman_name = '$_POST[col3]',
                  email = '$_POST[col4]',
                  address = '$_POST[col5]',
                  phone_mob = '$_POST[col6]',
                  land_phone = '$_POST[col7]',
                  delar_dist = '$_POST[col8]',
                  tin_no = '$_POST[col9]'
             WHERE delar_id = '$update_id'";
    $result = mysqli_query($conn, $query_update);
    if(! $result )
    {  
     die('Could not update data: ' . mysqli_error());
    }
    echo "<script type='text/javascript'>";
    echo "alert('Updated successfully');";
    echo 'window.location.href = "issue_ticket.html";';
    echo "</script>";
}

mysql_close($conn);
?>
