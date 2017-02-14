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

$query_select = "SELECT `delar_id`, `delar_name`, `contact_name`, `salesman_name`, `address`, `email`, `phone_mob`, `land_phone`, `delar_dist`, `tin_no` FROM `Register` WHERE `delar_id`= '$delar_id'";

	$result = mysqli_query($conn, $query_select);
   	if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                  echo "<html>
		        <title>mascotautomobiles</title>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
			<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>
			<ul class='topnav'>
			  <li><a class='active' href='option_page.html'>Home</a></li>
			  <li><a href='registration.html'>Dealer Registration</a></li>
			  <li><a href='modify.html'>Edit</a></li>
			  <li><a href='issue_ticket.html'>Issue Ticket</a></li>
			  <li><a href='user_search.html'>Search</a></li>
			  <li><a href='check-in.html'>Check-In</a></li>
			  <li><a href='report.html'>Report</a></li>
			  <li class='right'><a href='index.html'>Logout</a></li>
			</ul>

			<form method='post' action='update_register.php'>
			<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>
     			        <h1>Modify</h1>
                                <label for='delar_id' name=id>Dealer ID: $row[delar_id]</label>
		        </div>
		        <div>
			        <label for='name'>Dealer Name</label>
			        <input type='text' id='name' name='delar_name' value='$row[delar_name]' required/>
			</div>
		        <div>
			        <label for='name'>Contact Name</label>
			        <input type='text' id='name' name='contact_name' value='$row[contact_name]' required/>
			</div>
		        <div>
			        <label for='name'>Salesman</label>
			        <input type='text' id='name' name='salesman_name' value='$row[salesman_name]' required/>
		        </div>
		        <div>
			        <label for='Email'>E-mail</label>
			        <input type='email' id='mail' name='delar_email' value='$row[email]' />
	                </div>
			<div>
			        <label for='address'>Address</label>
			        <textarea id='address' name='delar_address' required>$row[address]</textarea>
		        </div>
		        <div>
			        <label for='phone_mob'>Mobile</label>
			        <input type='tel' id='phone_mob' name='delar_mobile' value='$row[phone_mob]' required pattern='^[0-9\-\+\s\(\)]*$'>
		        </div>
		        <div>
			        <label for='phone_land'>Phone Office</label>
			        <input type='tel' id='phone_land' name='delar_land' value='$row[land_phone]' required pattern='^[0-9\-\+\s\(\)]*$'>
	      	        </div>
		        <div>
			        <label for='district'>District</label>
			        <select type='text' id='district' name='delar_district' required>
		        	        <option>$row[delar_dist]</option>
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
			        </select>
		        </div>
		        <div>
			        <label for='tin_no'>Tin No.</label>
			        <input type='text' id='tin_no' name='tin_no' value='$row[tin_no]' style='height:30px'/>
		        </div>
		        <div class='button'>
			        <input id='button' type='submit' name='submit_m' value='Save'>
				<input type='hidden' name='id' value='{$delar_id}'/>
		        </div>	
		        </form>
		        </html>";

            }
        }


mysql_close($conn);
?>
