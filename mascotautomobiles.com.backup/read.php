<?php  
/*************************************************************  
 * This script is developed by Arturs Sosins aka ar2rsawseen, http://webcodingeasy.com  
 * Fee free to distribute and modify code, but keep reference to its creator  
 *  
 * This class generate QR [Quick Response] codes with proper metadata for mobile  phones  
 * using google chart api http://chart.apis.google.com  
 * Here are sources with free QR code reading software for mobile phones:  
 * http://reader.kaywa.com/  
 * http://www.quickmark.com.tw/En/basic/download.asp  
 * http://code.google.com/p/zxing/  
 *  
 * For more information, examples and online documentation visit:   
 * http://webcodingeasy.com/PHP-classes/QR-code-generator-class  
 **************************************************************/  
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "mascotautomobiles";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO Register (user_name, email, location, address, pass) VALUES ('$_POST[delar_name]', '$_POST[delar_location]', '$_POST[delar_email]', '$_POST[Delar_address]', '$_POST[pass_number]')";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    echo "New record created successfully. Last inserted ID is: " . $last_id;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
      
echo "<p><img src='http://chart.apis.google.com/chart?cht=qr&chs=300x300&chl=$last_id' border='0'/></p>";


?> 

