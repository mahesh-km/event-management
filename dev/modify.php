<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

$delarname = $_POST['delar_name'];
//$delaremail = $_POST['delar_email'];

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
        echo "<script type='text/javascript'>";
        echo "alert('Please Input Some Valid Data In To The Field');";
        echo 'window.location.href = "modify.html";';
        echo "</script>";
	}
else {
        $query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `address`, `phone_mob`, `land_phone`  FROM `Register` WHERE `delar_name` REGEXP '$_POST[delar_name]'";
}
        
$result = mysqli_query($conn, $query_select);
        
        if (mysqli_num_rows($result) > 0) {
                echo "<html>";
                echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
                echo "<link rel='stylesheet' type='text/css' href='CSS/style_table_issuetkt.css'>";
                echo "<link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css'>";
                echo "<ul class='topnav'>";
                echo "<li><a class='active' href='option_page.html'>Home</a></li>";
                echo "<li><a href='registration.html'>Delar Registration</a></li>";
                echo "<li><a href='modify.html'>Edit</a></li>";
                echo "<li><a href='issue_ticket.html'>Issue ticket</a></li>";
                echo "<li><a href='user_search.html'>Search</a></li>";
                echo "<li><a href='check-in.html'>Check-in</a></li>";
                echo" <li><a href='report.php'>Report</a></li>";
                echo "<li class='right'><a href='index.html'>Logout</a></li>";
                echo"</ul>";

                echo "<form action='update_form.php' method='POST'>";
                echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>
                        <h1>Edit Dealers Informations</h1>
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
					//echo "<th>Salesman Name</th>";
			                //echo "<th>Email</th>";
					echo "<th>Address</th>";
	                		echo "<th>Mobile</th>";
					echo "<th>Phone Off.</th>";
			                //echo "<th>District</th>";
					//echo "<th>Tin No.</th>";
	                	echo "</tr>"; 
                 	echo "</thead>";
                	while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                         $id = $row['delar_id'];
				   	 $col1 = $row["delar_name"];
    					 $col2 = $row["contact_name"];
    					 //$col3 = $row["salesman_name"];
                                         //$col4 = $row["email"];
				         $col5 = $row["address"];
					 $col6 = $row["phone_mob"];
                                         $col7 = $row["land_phone"];
				         //$col8 = $row["delar_dist"];
					 //$col9 = $row["tin_no"];
                        echo "<tbody>";
                               echo "<tr>
					 <td><input type='radio' name='id' value='${id}' required></td>
            			         <td>{$id}</td>
            		         	 <td>{$col1}</td>
				         <td>{$col2}</td>
			            <!-- <td>{$col3}</td> --!>
                                    <!-- <td>{$col4}</td> --!>
                                         <td>{$col5}</td>
                                         <td>{$col6}</td>
                                         <td>{$col7}</td>
                                    <!-- <td>{$col8}</td> --!>
                                    <!-- <td>{$col9}</td> --!>
                                 </tr>";
                      	echo "</tbody>";
                }
                echo "</table>";
                echo "<div class='button'>
                        <p>&nbsp;</p>
                        <input id='button' type='submit' name='submit_m' value='Modify'/> 
                      </div>";
                echo "</html>";
 
	}else {
         echo "<script type='text/javascript'>";
         echo "alert('No Records Found!');";
         echo 'window.location.href = "modify.html";';
         echo "</script>";
        } 

?>
