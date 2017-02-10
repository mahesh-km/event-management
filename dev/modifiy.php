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
                echo "alert('Please input some valid data in to the filed');";
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
                echo "<ul class='topnav'>";
                echo "<li><a class='active' href='option_page.html'>Home</a></li>";
                echo "<li><a href='registration.html'>Delar Registration</a></li>";
                echo " <li><a href='issue_ticket.html'>Issue ticket</a></li>";
                echo "<li><a href='user_search.html'>Search</a></li>";
                echo "<li><a href='check-in.html'>Check-in</a></li>";
                echo" <li><a href='report.php'>Report</a></li>";
                echo "<li class='right'><a href='index.html'>Logout</a></li>";
                echo"</ul>";

                echo "<form action='update_register.php' method='POST'>";
		echo "<table id='box-table-a' >";
                        echo "<thead>";
		        	echo "<tr>";
        				echo "<th>Delar ID</th>";
			                echo "<th>Delar Name</th>";
					echo "<th>Contact Name</th>";
					echo "<th>Sales Name</th>";
			                echo "<th>Email</th>";
					echo "<th>Address</th>";
	                		echo "<th>Mobile</th>";
					echo "<th>Phone Off.</th>";
			                echo "<th>District</th>";
					echo "<th>Tin No.</th>";
			                echo "<th>No. pass issued</th>";
					echo "<th></th>";
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
					 $col10 = $row["pass"];
                        echo "<tbody>";
                               echo "<tr>
            			         <td>{$id}</td>
            		         	 <td><input type='text' name='col1' value='{$col1}' style='width:150'/></td>
				         <td><input type='text' name='col2' value='{$col2}' style='width:150'/></td>
			             	 <td><input type='text' name='col3' value='{$col3}' style='width:150'/></td>
                                         <td><input type='text' name='col4' value='{$col4}' /></td>
                                         <td><input type='text' name='col5' value='{$col5}' /></td>
                                         <td><input type='text' name='col6' value='{$col6}' style='width:100px'></td>
                                         <td><input type='text' name='col7' value='{$col7}' style='width:100px'></td>
                                         <td><select type='text' id='col8' name='col8' style='width:150'>
             			                <option>{$col8}</option>
				                <option value='Alappuzha'>Alappuzha</option>
				                <option value='Ernakulam'>Ernakulam</option>
				                <option value='Idukki'>Idukki</option>
				                <option value='Kannur'>Kannur</option>
				                <option value='Kasaragod'>Kasaragod</option>
				                <option value='Kollam'>Kollam</option>
				                <option value='Kottayam'>Kottayam</option>
				                <option value='Kozhikode'>Kozhikode</option>
				                <option value='Malappuram'>Malappuram</option>
				                <option value='Palakkad'>Palakkad</option>
				                <option value='Pathanamthitta'>Pathanamthitta</option>
				                <option value='Thiruvananthapuram'>Thiruvananthapuram</option>
				                <option value='Thrissur'>Thrissur</option>
				                <option value='Wayanad'>Wayanad</option>
				         </select></td>
                                         <td><input type='text' name='col9' value='{$col9}' style='width:100'/></td>
                                         <td><input type='text' name='col10' value='{$col10}' style='width:100%'/></td>
				 	 <td><input type='submit' name='submit_t' value='Modify'/><input type='hidden' name='id' value='{$id}'/></td>
                                 </tr>";
                      	echo "</tbody>";
                }
                echo "</table>";
                echo "</form>";
                echo "</html>";

                echo "<html>";
		echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
		echo "<form method='post' action='issue_tickets.php'>
 			   <div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>
		           	   <h1>Issue Ticket</h1>
			   </div>
    			   <div>
		        	   <h3>please enter number of pass required</h3>
 		           </div>
			   <div>
			       <label for='pass_rq'>No. of pass </label>
		               <input type='number' id='pass_rq' name='pass_rq' style='height:30px;'/>
			    </div>
			    <div class='button'>
		    	        <input id='button' type='submit' name='submit' value='Submit'>
			    </div>
			</form>";

                echo "</html>";
 
	}else {
         echo "<script type='text/javascript'>";
         echo "alert('No records found!');";
         echo 'window.location.href = "issue_ticket.html";';
         echo "</script>";
        } 

?>
