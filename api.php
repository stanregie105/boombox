<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'project';

if (getenv('CLEARDB_DATABASE_URL')) {
    $dbUrl = parse_url(getenv('CLEARDB_DATABASE_URL'));
    $host = $dbUrl['host']; // Heroku database host
    $user = $dbUrl['user']; // Heroku database user
    $pass = $dbUrl['pass']; // Heroku database password
    $dbName = substr($dbUrl["path"], 1); // Heroku database name
}


// Connect to mysql server and database
$conn = mysqli_connect($host, $user, $pass, $dbName);

// If not connected stop executing
if (!$conn) {
    die('Not connected');
}
$plateNumber = $_POST['plate_number'];//get plate number from image processor

// query holds all your normal sql query
$sql = "select * from driver_info where plate_number = '" . $plateNumber . "' limit 1";

// Run query
$result = mysqli_query($conn, $sql);
$driver = mysqli_fetch_assoc($result);
$output = json_encode($driver);

$email_content = file_get_contents('Email.html');
$email_content = str_replace('%name%', $driver['first_name'] . ' ' . $driver['last_name'], $email_content);
$email_content = str_replace('%plate_number%', $driver['plate_number'], $email_content);

$mail = new PHPMailer(true);
$mail->SMTPDebug = 2;
$mail->isSMTP();
$mail->Host = 'smtp.elasticemail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'stanleyregal004@yahoo.com';                 // SMTP username
$mail->Password = 'f84f55e7-6fc2-4256-8f74-9c7ef6a52306';   // SMTP password
//$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 2525;                                    // TCP port to connect to

$mail->setFrom('stanleyregal004@yahoo.com', 'Traffic');
$mail->addAddress( $driver['Email_address'], $driver['first_name'] . ' ' . $driver['last_name']);     // Add a recipient

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'FRSC TICKET';
$mail->Body    = $email_content;


$mail->send();
echo 'Message has been sent';
mysqli_free_result($result);
mysqli_close($conn);

echo $output;
?>
