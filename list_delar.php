<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

$delarname = $_POST['delar_name'];
$delaremail = $_POST['delar_email'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}


function issue_tkt() {
	header("location:issue_tickets.php");
}
if(!isset($delarname) || trim($delarname) == ''){
	if (!isset($delaremail) || trim($delaremail) == ''){
        	echo "<script type='text/javascript'>";
                echo "alert('Please Input Some Valid Data In To The Field');";
                echo 'window.location.href = "issue_ticket.html";';
                echo "</script>";
	}
        else {
                   $query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `salesman_name`, `address`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `tin_no` FROM `Register` WHERE `email` REGEXP '$_POST[delar_email]'";
                }   
}
else {
        $query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `salesman_name`, `address`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `tin_no` FROM `Register` WHERE `delar_name` REGEXP '$_POST[delar_name]'";
}
        
$result = mysqli_query($conn, $query_select);
        
        if (mysqli_num_rows($result) > 0) {
                echo "<html>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<link rel='stylesheet' type='text/css' href='CSS/style_table_issuetkt.css'>";
                echo "<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'>";
                echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js'></script>";
                echo "<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js'></script>";
                echo "<script text/javascript>
                      $(document).ready(function() {
                      $('#datepicker').datepicker();
                       });
		      </script>";
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

                echo "<form action='issue_tickets.php' method='POST'>";
                echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>
                        <h1>Issue Ticket</h1>
                     </div>
		     <div style='color: #5a5756; font: 1em sans-serif;'>
		        <h3>Please Select A Dealer From The Below List</h3>
		     </div>";
		echo "<table id='box-table-a' >";
                        echo "<thead>";
		        	echo "<tr>";
                                        echo "<th>Select</th>";
        				echo "<th>Dealer ID</th>";
			                echo "<th>Dealer Name</th>";
					echo "<th>Contact Name</th>";
					echo "<th>Sales Name</th>";
			                echo "<th>Email</th>";
					echo "<th>Address</th>";
	                		echo "<th>Mobile</th>";
					echo "<th>Phone Off.</th>";
			                echo "<th>District</th>";
					echo "<th>Tin No.</th>";
                                        echo "<th>Ticket No</th>";
                                        echo "<th>Ticket Issue Date</th>";
                                        echo "<th>Event Date</th>";
			                echo "<th>No. Pass Issued</th>";
	                	echo "</tr>"; 
                 	echo "</thead>";
                	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                         $id = $row['delar_id'];
				   	 $col1 = $row["delar_name"];
    					 $col2 = $row["contact_name"];
    					 $col3 = $row["salesman_name"];
                                         $col4 = $row["email"];
				         $col5 = $row["address"];
					 $col6 = $row["phone_mob"];
                                         $col7 = $row["land_phone"];
				         $col8 = $row["delar_dist"];
					 $col9 = $row["tin_no"];

                                         $query_select_ticket = "SELECT `ticket_id`, `ticket_date`,`event_date`, `pass_no` FROM `Ticket_info` WHERE `delar_id` = '$row[delar_id]'";
                                         $result_pass = mysqli_query($conn, $query_select_ticket);
                                         if (mysqli_num_rows($result_pass)==0) {
                                            $col10 = "-";
                                            $col11 = "-";
                                            $col12 = "-";
                                            $col13 = "-";
                                         }
                                         else {
                                              while ($row = mysqli_fetch_array($result_pass, MYSQLI_ASSOC)) {
                                              $col10 = $row["ticket_id"];
                                              $col11 = $row["ticket_date"];
                                              $col12 = $row["event_date"];
                                              $col13 = $row["pass_no"];
                                              }
                                         } 
                        echo "<tbody>";
                               echo "<tr>
					 <td><input type='radio' name='id' value='${id}' required></td>
            			         <td>{$id}</td>
            		         	 <td>{$col1}</td>
				         <td>{$col2}</td>
			             	 <td>{$col3}</td>
                                         <td>{$col4}</td>
                                         <td>{$col5}</td>
                                         <td>{$col6}</td>
                                         <td>{$col7}</td>
                                         <td>{$col8}</td>
                                         <td>{$col9}</td>
                                         <td>{$col10}</td>
					 <td>{$col11}</td>
					 <td>{$col12}</td>
					 <td>{$col13}</td>
                                 </tr>";
                      	echo "</tbody>";
                }
                echo "</table>
                <p>&nbsp;</p> 
                <div>  
			<label for='pass_rq'>Select An Event Date</label>
                        <input style='width: 200px;' type='date' id='datepicker' name='event_date' required/>
		</div>
		<div>
			<label for='pass_rq'>Enter No.Of Pass Required</label>
		        <input type='number' id='pass_rq' name='pass_rq' style='height:30px;' required'/>
		</div>
			<div class='button'>
		    	<input id='button' type='submit' name='submit_2' value='Submit'/> 
		</div>
	 	</form>";
                echo "</html>";
 
	}else {
         echo "<script type='text/javascript'>";
         echo "alert('No Records Found!');";
         echo 'window.location.href = "issue_ticket.html";';
         echo "</script>";
        } 

?>
