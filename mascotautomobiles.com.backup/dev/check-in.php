<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

$ticketnum = $_POST['ticket_num'];
$no_of_tkt_checkin = $_POST['checkin_tkts'];

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
        echo 'window.location.href = "check-in.html";';
        echo "</script>";
}

// function for welcome screen
function Welcome_txt($delar_name) {
	$xml = new SimpleXMLElement('<xml/>');
	$page = $xml->addChild('page');
    	$page->addChild('d_name', $delar_name);
	Header('Content-type: text/xml');
	//print($xml->asXML());

	$my_file = "XML/check-in.xml";
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	$data = $xml->asXML();
	fwrite($handle, $data);
}

if(!isset($ticketnum) || trim($ticketnum) == '')
 {
  AlertMsg("Please Input A Valid Ticket No.");
 }
 else 
    {
    $query_select = "SELECT *  FROM `Ticket_info` WHERE ticket_id = '$_POST[ticket_num]'";
    $result = mysqli_query($conn, $query_select);

    if (mysqli_num_rows($result) > 0) 
     {
     if(!isset($no_of_tkt_checkin) || trim($no_of_tkt_checkin) == '')
      {
       AlertMsg("Please Input Checkin Ticket Details"); 
      }
      else 
         {
         $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
         if ($no_of_tkt_checkin <= $row['pass_no']) 
          {
          $no_of_tkt_issued = $row['pass_no'];
          $event_date = $row['event_date'];
          $delar_id = $row['delar_id'];
          $query_select = "SELECT *  FROM `CheckIn` WHERE ticket_id = '$_POST[ticket_num]'";
          $result = mysqli_query($conn, $query_select);

	  if (mysqli_num_rows($result) > 0) 
           {
            AlertMsg("Check-In Chance Already Over For This Ticket");
           }  
           else 
              {
              $checkin_date = date("Y-m-d");
	      $checkin_time = date("H:i:s");

              if ($checkin_date == $event_date) 
               {	      
                $query_checkin = "INSERT INTO CheckIn (`checkin_date`, `checkin_time`, `checkin_tkt`, `ticket_id`, `delar_id`) VALUES ('$checkin_date', '$checkin_time','$_POST[checkin_tkts]', '$_POST[ticket_num]', '$delar_id')";

                if ($conn->query($query_checkin) === TRUE) 
                 {
		  $last_checkin_id = $conn->insert_id;
                  $query_select = "SELECT `ticket_id`, `checkin_date`,`checkin_time`, `checkin_tkt` FROM CheckIn WHERE `checkin_id` = '$last_checkin_id'";
		  $result = mysqli_query($conn, $query_select);

		  if (mysqli_num_rows($result) > 0) 
                   {
	            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                        {
                         echo "<html>";
		         echo "<link rel='stylesheet' type='text/css' href='CSS/style_merge.css'>";
		         echo "<form action='http://mascotautomobiles.com/dev/check-in.html' >";
                         echo "<div style='padding-top:1px; color: #5a5756; font: 1em sans-serif;'>";
                         echo "<h1>Check-in Completed!</h1>";
                         echo "</div>";
		         echo "<ul>";
		         echo "<li>Ticket No  : {$row['ticket_id']} </li>";
		         echo "<li>Check-in Date    : {$row['checkin_date']}</li>";
		         echo "<li>Check-in Time    : {$row['checkin_time']}</li>";
		         echo "<li>No. Pass Issued: $no_of_tkt_issued</li>";
		         echo "<li>No. People Check-in: {$row['checkin_tkt']}</li>";
		         echo "<button type='submit'>Done</button>";
                         echo "</ul>";
		         echo "</form>";
	                 echo "</html>";
		         $tkt_id = $row['ticket_id'];
		        }
                   } 
                   else 
                      {
		       echo "Query didn't return any result";
	              }     
                      $query_select = "SELECT `delar_id` from `Ticket_info` WHERE `ticket_id` = '$tkt_id'";
                     	  $result = mysqli_query($conn, $query_select);

                          if (mysqli_num_rows($result) > 0) 
                           {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                                {
                                $delar_id = $row['delar_id'];
                                } 
                           } 
                      $query_select = "SELECT `delar_name` from `Register` WHERE `delar_id` = '$delar_id'";
                          $result = mysqli_query($conn, $query_select);

                          if (mysqli_num_rows($result) > 0) 
                           {
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                                {
                                 $delar_n = $row['delar_name'];
				 Welcome_txt("$delar_n");
                                }
                           }  
                 }	
               
      	       }  
               else 
                  {
                   AlertMsg("Opps!, Ticket Is Not Valid For Today's Event.");
                  }
             }
         }
         else 
	    {
             AlertMsg("No. Of Tickets Entered More Than Actually Issued");
	    }	
         }   
     }
     else 
        {  
         AlertMsg("Ticket No. Is Not Valid, Please Check Again."); 
        }

   }

?>
