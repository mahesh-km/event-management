<?php
// searching user information from database.

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles2";

$ticketnum = $_POST['ticket_num'];
// $no_of_tkt_checkin = $_POST['checkin_tkts'];

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
function Welcome_txt($delar_name, $guest_name) {
	$writer = new XMLWriter();
	$writer->openURI('XML/check-in.xml');
	$writer->startDocument('1.0','UTF-8');
	$writer->setIndent(4);
	$writer->startElement('xml');
	   $writer->startElement('page');
	      $writer->writeElement('d_name', $delar_name);
	      $writer->writeElement('guest_n', $guest_name);
	   $writer->endElement();
	$writer->endElement();
	$writer->endDocument();
	$writer->flush();
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
       $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
       $event_date = $row['event_date'];
       $delar_id = $row['delar_id'];

       // check ticket no already registered
       $query_select = "SELECT * FROM `CheckIn` WHERE `ticket_id` = '$_POST[ticket_num]'";
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
              $query_checkin = "INSERT INTO CheckIn (`checkin_date`, `checkin_time`, `ticket_id`, `delar_id`) VALUES ('$checkin_date', '$checkin_time', '$_POST[ticket_num]', '$delar_id')";

              if ($conn->query($query_checkin) === TRUE) 
               {
	        $last_checkin_id = $conn->insert_id;
                $query_select = "SELECT `ticket_id`, `checkin_date`, `checkin_time` FROM CheckIn WHERE `checkin_id` = '$last_checkin_id'";
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
		       //echo "<li>No. Pass Issued: $no_of_tkt_issued</li>";
		       //echo "<li>No. People Check-in: {$row['checkin_tkt']}</li>";
                       echo "<p>&#160;</p>";
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
                    $query_select = "SELECT `delar_id`, `guest_name`  from `Ticket_info` WHERE `ticket_id` = '$tkt_id'";
                    $result = mysqli_query($conn, $query_select);
                    if (mysqli_num_rows($result) > 0) 
                     {
                      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                          {
                           $delar_id = $row['delar_id'];
                           $guest_name = $row['guest_name'];
			  }   
		     } 
                     //
                     $query_select = "SELECT `delar_name` from `Register` WHERE `delar_id` = '$delar_id'";
                     $result = mysqli_query($conn, $query_select);
                     if (mysqli_num_rows($result) > 0) 
                      {
                       while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) 
                           {
                            $delar_n = $row['delar_name'];
			    Welcome_txt("$delar_n", "$guest_name");
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
          AlertMsg("Ticket No. Is Not Valid, Please Check Again."); 
        }

   }

?>
