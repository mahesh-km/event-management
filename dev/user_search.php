<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

$delarname = $_POST['delar_name'];
// $delaremail = $_POST['delar_email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}

if(!isset($delarname) || trim($delarname) == ''){
	//if (!isset($delaremail) || trim($delaremail) == ''){
        	echo "<script type='text/javascript'>";
                echo "alert('Please Input Some Valid Data In To The Field');";
                echo 'window.location.href = "user_search.html";';
                echo "</script>";
	//}
        //else {
        //        $query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `salesman_name`, `address`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `tin_no` FROM `Register` WHERE `email` REGEXP '$_POST[delar_email]'";
        //}
}
else {
		$query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `address`, `phone_mob`, `land_phone`  FROM `Register` WHERE `delar_name` REGEXP '$_POST[delar_name]'";

}
        
$result = mysqli_query($conn, $query_select);
        
        if (mysqli_num_rows($result) > 0) {
                echo "<html>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<link rel='stylesheet' type='text/css' href='CSS/style_table_search.css'>";
                echo "<ul class='topnav'>";
                echo "<li><a class='active' href='option_page.html'>Home</a></li>";
                echo "<li><a href='registration.html'>Dealer Registration</a></li>";
                echo "<li><a href='modify.html'>Edit</a></li>";
                echo "<li><a href='issue_ticket.html'>Issue Ticket</a></li>";
                echo "<li><a href='user_search.html'>Search</a></li>";
                echo "<li><a href='check-in.html'>Check-In</a></li>";
                echo" <li><a href='report.php'>Report</a></li>";
                echo "<li class='right'><a href='index.html'>Logout</a></li>";
                echo"</ul>";
                echo "<form action='http://mascotautomobiles.com/dev/user_search.html' >";
		echo "<table id='box-table-a' >";
                        echo "<thead>";
		        	echo "<tr>";
        				echo "<th>Dealer ID</th>";
			                echo "<th>Dealer Name</th>";
					echo "<th>Contact Name</th>";
					//echo "<th>Salesman Name</th>";
			                //echo "<th>Email</th>";
					echo "<th>Address</th>";
	                		//echo "<th>Mobile</th>";
					//echo "<th>Phone Off.</th>";
			                //echo "<th>District</th>";
					//echo "<th>Tin No.</th>";
					//echo "<th>Ticket No</th>";
					//echo "<th>Ticket Issue Date</th>";
					//echo "<th>Event Date</th>";
			                echo "<th>No. Pass Issued</th>";
	                	echo "</tr>"; 
                 	echo "</thead>";
                	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	  		//while($row = $result->fetch_assoc()) {
                        echo "<tbody>";
	                        echo "<tr>";
                	        	echo "<td>". $row['delar_id']. "</td>";
        		                echo "<td>" . $row["delar_name"]. "</td>";
					echo "<td>" . $row["contact_name"]. "</td>";
					//echo "<td>" . $row["salesman_name"]. "</td>";
		                        //echo "<td>" . $row["email"]. "</td>";
					echo "<td>" . $row["address"]. "</td>";
                		        //echo "<td>" . $row["phone_mob"]. "</td>";
					//echo "<td>" . $row["land_phone"]. "</td>";
                        		//echo "<td>" . $row["delar_dist"]. "</td>";
					//echo "<td>" . $row["tin_no"]. "</td>";

                                        $query_select_ticket = "SELECT COUNT(`ticket_id`)  as total FROM `Ticket_info` WHERE `delar_id` = '$row[delar_id]'";
                                        $result_pass = mysqli_query($conn, $query_select_ticket);
                                        if (mysqli_num_rows($result_pass)==0) {                        
					     $pass = "-";
                                           //$tkt_id = "-";
                                           //$tkt_date = "-";
                                           //$event_d = "-";
                                        }
                                        else {
                                             while ($row = mysqli_fetch_array($result_pass, MYSQLI_ASSOC)) {
                                             $pass  = $row['total'];
                                             //$tkt_id = $row["ticket_id"];
					     //$tkt_date = $row["ticket_date"];
                                             //$event_d = $row["event_date"];
                                             }
                                        }
                                        //echo "<td>$tkt_id</td>";
					//echo "<td>$tkt_date</td>";
                                        //echo "<td>$event_d</td>";
                                        echo "<td>$pass</td>";
                        	echo "</tr>";
                      	echo "</tbody>";
                }
                echo "</table>";
                echo "<button type='submit'>Done</button>";
                echo "</form>";
                echo "</html>";
 
	}else {
         echo "<script type='text/javascript'>";
         echo "alert('No Records Found!');";
         echo 'window.location.href = "user_search.html";';
         echo "</script>";
        } 

