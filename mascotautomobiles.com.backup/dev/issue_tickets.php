<?php  

// Gernerate QR code
// Using google chart api,  chart.apis.google.com 

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

$event_date = $_POST['event_date'];
$date = new DateTime($event_date);
$event_date = $date->format('Y-m-d');


$pass = $_POST['pass_rq'];
$delar_id = $_POST['id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// function for alert messages
function AlertMsg($message) {
        echo "<script type='text/javascript'>";
        echo "alert('$message');";
        echo 'window.location.href = "issue_ticket.html";';
        echo "</script>";
}

// Gen QR code for ticket number.
function print_qr ($auto_ticket_id, $conn)
{
	$query_select =  "SELECT `Register`.`delar_name`, `Register`.`contact_name`, `Register`.`phone_mob`,  `Register`.`email`, `Register`.`delar_dist`, `Register`.`address`, `Ticket_info`.`ticket_id`, `Ticket_info`.`ticket_date`, `Ticket_info`.`event_date`, `Ticket_info`.`pass_no` from `Register` INNER JOIN `Ticket_info` ON `Register`.`delar_id` = `Ticket_info`.`delar_id` and `Ticket_info`.`ticket_id` = '$auto_ticket_id'";
 
        $result = mysqli_query($conn, $query_select);

        if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        $last_id = $row['ticket_id'];
                        echo "<html>";
                        echo "<link rel='stylesheet' type='text/css' href='CSS/style_ticket.css'>";
                        echo "<form action='http://mascotautomobiles.com/dev/option_page.html' >";
                        echo "<div style='padding-right:10px; color: #5a5756; font: 1em sans-serif;'>";
                        echo "<img src='image/veedol-logo.png' alt='veedol-logo' align='middle' style='width:260px;height:75px;'>";
                        echo "<p>&nbsp;</p>";
                        echo "<h1 style='color: #5a5756; font:2em sans-serif;'>DEALERS MEET</h1>";
                        echo "<p>&nbsp;</p>";
                        echo "<p>{$row['contact_name']} </p>";
                        echo "<p>{$row['delar_name']} </p>";
                        echo "<p>{$row['address']} </p>";
                        echo "<p>{$row['delar_dist']}</p>";
                        echo "<p>&nbsp;</p>"; 
                        echo "<h3 style='color: #5a5756; font:sans-serif;'>Admit {$row['pass_no']}</h3>";
                        echo "<h4 style='color: #5a5756; font:sans-serif;'>(Not Transferable)</h4>";
                        echo "<p>&nbsp;</p>";
			echo "<p>EVENT DATE : {$row['event_date']}</p>";
                        echo "<a href='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=$last_id' download='QR.png'>";
                        echo "<p><img src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=$last_id' alt='QR code' border='0'/></p></a>";
                        echo "<p>Ticket No : {$row['ticket_id']} </p>";
                        echo "<p>&nbsp;</p>";
                        echo "<p>(Please Register before 11:30AM.</p>";
                        echo "<p>Show This Card At The Time Of Registration)</p>";
                        echo "<p>&nbsp;</p>";       
			echo "</div>";
                        echo "<script type='text/javascript'>";
                        echo "function myFunction()";
                        echo "{  window.print(); }";
                        echo "</script>";
                        echo "<button onclick='myFunction()'>Print</button>";
                        echo "<button type='submit' onclick=''>Email</button>";
                        echo "<button type='submit'>Done</button>";
                        echo "</form>";
                        echo "</html>";
                }
        }
        else
        {
                echo "Query didn't return any result";
        }
}

// create ticket
if(!isset($pass) || trim($pass) == '')
 {
  AlertMsg('Please Input Number Of Pass Required');
 }
 elseif(!isset($event_date) || trim($event_date) == '')
      {
       AlertMsg('Please Select An Event Date');
      }
      else
         {
          $date_now = date("Y-m-d");
          if ($event_date < $date_now )
           {
            AlertMsg('Please Select A Vaild Date');
           }
           else
              {
	       $query_select = "SELECT * FROM `Ticket_info` WHERE `delar_id` = '$delar_id'";
               $result = mysqli_query($conn, $query_select);
	       if (mysqli_num_rows($result) > 0) 
	        {
	        $auto_ticket_id = uniqid();	
       		$ticket_date = date("Y-m-d");
                $query_update = "UPDATE Ticket_info
    	   	 	SET ticket_id = '$auto_ticket_id', 
		            pass_no = '$_POST[pass_rq]', 
	        	    ticket_date = '$ticket_date',
        	            event_date = '$event_date'
		       WHERE `delar_id` = '$delar_id'";
	        $result = mysqli_query($conn, $query_update);
                if ($conn->query($query_update) === TRUE)
		 { 
                  print_qr($auto_ticket_id, $conn);
                 } 
	         else
                    {	
                     echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                else 
                   {
                    $auto_ticket_id = uniqid();
                    $ticket_date = date("Y-m-d");

                    $sql = "INSERT INTO Ticket_info (ticket_id, pass_no, ticket_date, event_date, delar_id) VALUES ('$auto_ticket_id', '$_POST[pass_rq]', '$ticket_date', '$event_date', '$delar_id')";
   
                    if ($conn->query($sql) === TRUE) 
                    {
                     print_qr($auto_ticket_id, $conn);
                    } 
                    else 
                       {
               	        echo "Error: " . $sql . "<br>" . $conn->error;
                       } 
                   }
             }
          }

$conn->close();
?> 

