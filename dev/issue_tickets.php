<?php  

// Gernerate QR code
// Using google chart api,  chart.apis.google.com 

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

$event_date = $_POST['event_date'];
$date = new DateTime($event_date);
$event_date = $date->format('Y-m-d');

$gender = $_POST['gender'];
$guest = $_POST['guest_name'];
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
	$query_select =  "SELECT `Register`.`delar_name`, `Register`.`contact_name`, `Register`.`phone_mob`, `Register`.`address`, `Ticket_info`.`ticket_id`, `Ticket_info`.`guest_name`, `Ticket_info`.`guest_gender`, `Ticket_info`.`ticket_date`, `Ticket_info`.`event_date` from `Register` INNER JOIN `Ticket_info` ON `Register`.`delar_id` = `Ticket_info`.`delar_id` and `Ticket_info`.`ticket_id` = '$auto_ticket_id'";
 
        $result = mysqli_query($conn, $query_select);

        if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                       $last_id = $row['ticket_id'];
                       echo "<html>
			     <head>
			       <script type='text/javascript'>
                                 function myFunction()
                                 {  window.print(); }
                               </script>
			     </head>
                             <link rel='stylesheet' type='text/css' href='CSS/style_ticket.css'>
                             <form action='http://mascotautomobiles.com/dev/option_page.html' >

                                 <div style='padding-right:10px; text-align: center; width:600px;height:90px;color:#5a5756;font:1em sans-serif;'>
                                   <img src='image/veedol-logo.png' alt='veedol-logo' align='middle' style='width:200px;height:55px;'>
                                   <h1 style='color: #5a5756; font:sans-serif;'>DEALERS PASS</h1>
                                   <h3 style='color: #5a5756; font:sans-serif;'>Admit One</h3>
                                   <h4 style='color: #5a5756; font:sans-serif;'>(Not Transferable)</h4>
                                 </div>
 
                                 <div id='container' style='text-align: center;color: #5a5756; font: 1em sans-serif;'>
                                 <table>
                                    <tr>
                                       <td>
                                          <div style='text-align: left; width:300px; height:170px;color: #5a5756; font: 1em sans-serif;'>
                                              <p>Name&nbsp;&nbsp;&nbsp;&nbsp;: {$row['guest_name']} </p>
                                       	      <p>Address : {$row['delar_name']} </p>
                                              <p>{$row['address']} </p>
                                              <p>{$row['delar_dist']}</p>
                                          </div>
                                       </td>
                                       <td>
                                          <div style='text-align:center; width:300px; height:170px;'>
                                             <img src='http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl=$last_id' alt='QR code' border='0'/>
                                             <p style='font-size: 12px;'>{$row['ticket_id']} </p>
                                          </div>
				       </td>
				   </tr>
                                   </table>                                  
                                   <div style='text-align:center; width:600px; height:20px;'>
                                       <p>Please bring this card for registration and Lucky drow</p>
                                   </div>
                                   </form>
				   <div class='w-screen'>
                                   <button onclick='myFunction()'>Print</button>
                                   <button type='submit' onclick=''>Email</button>
                                   <button type='submit'>Done</button> 
			           </div>
                            </html>";
                }
        unset($_POST);
        }
        else
        {
                echo "Query didn't return any result";
        }
}

// create ticket
if(!isset($guest) || trim($guest) == '')
 {
  AlertMsg('Please Enter The Guest Name');
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
               $auto_ticket_id = uniqid();
               $ticket_date = date("Y-m-d");

               $sql = "INSERT INTO Ticket_info (ticket_id, guest_name, guest_gender, ticket_date, event_date, delar_id) VALUES ('$auto_ticket_id', '$guest', '$gender', '$ticket_date', '$event_date', '$delar_id')";
   
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

$conn->close();

?> 

