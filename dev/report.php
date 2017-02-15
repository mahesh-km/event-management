<?php
// generate report from tables.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

// $delarname = $_POST['delar_name'];
// $delaremail = $_POST['delar_email'];

$select_date = $_POST['event_date'];
$date = new DateTime($select_date);
$select_date = $date->format('Y-m-d');

$date_now = date("Y-m-d");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

if ($select_date <= $date_now) 
 {
  $query_select = "SELECT `Register`.`delar_id`, `Register`.`delar_name`, `Register`.`contact_name`, `CheckIn`.`checkin_date`, `CheckIn`.`checkin_time`, `Ticket_info`.`ticket_id`, `Ticket_info`.`guest_name`, `Ticket_info`.`guest_gender`, `Ticket_info`.`ticket_date`, `Ticket_info`.`event_date` from `Register` INNER JOIN `Ticket_info` ON `Register`.`delar_id` = `Ticket_info`.`delar_id` INNER JOIN `CheckIn` ON `Ticket_info`.`delar_id` = `CheckIn`.`delar_id` WHERE `Ticket_info`.`event_date` = '$select_date' ORDER BY `CheckIn`.`checkin_time`";

  $result = mysqli_query($conn, $query_select);

        if (mysqli_num_rows($result) > 0) {
                echo "<html>";
		echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<link rel='stylesheet' type='text/css' href='CSS/style_table_report.css'>";
		echo "<ul class='topnav'>";
	 	echo "<li><a class='active' href='option_page.html'>Home</a></li>";
		echo "<li><a href='registration.html'>Delar Registration</a></li>";
                echo "<li><a href='modify.html'>Edit</a></li>";
		echo " <li><a href='issue_ticket.html'>Issue ticket</a></li>";
		echo "<li><a href='user_search.html'>Search</a></li>";
 		echo "<li><a href='check-in.html'>Check-in</a></li>";
		echo" <li><a href='report.html'>Report</a></li>";
		echo "<li class='right'><a href='index.html'>Logout</a></li>";
		echo"</ul>";
                echo "<form action='http://mascotautomobiles.com/dev/option_page.html' >";
                echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>";
                echo "<h2>Report For The Date $select_date</h2>";
                echo "</div>";
                echo "<table id='box-table-a' >";
                        echo "<thead>";
                                echo "<tr>";
                                        echo "<th>Sl.no</th>";
                                        echo "<th>Dealer Name</th>";
                                        echo "<th>Contact Name</th>";
                                        echo "<th>Guest Name</th>";
                                        echo "<th>Gender</th>";
                                        //echo "<th>Phone</th>";
                                        //echo "<th>Email</th>";
                                        //echo "<th>District</th>";
					echo "<th>Ticket No</th>";
					echo "<th>Ticket Issue Date</th>";
                                        echo "<th>Check In Date</th>";
                                        echo "<th>Check In Time</th>";
                                echo "</tr>";
                        echo "</thead>";
                        $slno = 0;
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo "<tbody>";
                                echo "<tr>";
                                        $sl_value = ++$slno;
                                        echo "<td>$sl_value</td>";
                                        echo "<td>" . $row["delar_name"]. "</td>";
                                        echo "<td>". $row["contact_name"]. "</td>";
					echo "<td>". $row["guest_name"]. "</td>";
					echo "<td>". $row["guest_gender"]. "</td>";
                                        //echo "<td>" . $row["phone_mob"]. "</td>";
                                        //echo "<td>" . $row["email"]. "</td>";
                                        //echo "<td>" . $row["delar_dist"]. "</td>";
					echo "<td>" . $row["ticket_id"]. "</td>";
					echo "<td>" . $row["ticket_date"]. "</td>";
                                        echo "<td>". $row["checkin_date"]. "</td>";
        		                echo "<td>". $row["checkin_time"]. "</td>";
                                        //echo "<td>" . $row["pass_no"]. "</td>";
                                        //echo "<td>". $row["checkin_tkt"]. "</td>";
                                echo "</tr>";
                        echo "</tbody>";
                }
                echo "</table>";
                echo "<script type='text/javascript'>";
                echo "function myFunction()";
                echo "{  window.print(); }";
                echo "</script>";
		echo "<p>&nbsp;</p>";
                echo "<button onclick='myFunction()'>Print</button>";
                echo "<button type='submit'>Done</button>";
                echo "</form>";
                echo "</html>";	
	}else {
         echo "<script type='text/javascript'>";
         echo "alert('No Records Found!');";
         echo 'window.location.href = "report.html";';
         echo "</script>";
        } 
}
else 
   {
         echo "<script type='text/javascript'>";
         echo "alert('Please Select A Valid Date.');";
         echo 'window.location.href = "report.html";';
         echo "</script>";

   }   
?>
