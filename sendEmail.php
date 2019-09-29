<?php
/*
Author: Phuong Linh Bui (5624095)
*/

date_default_timezone_set('Etc/UTC');

// Edit this path if PHPMailer is in a different location
require 'PHPMailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();

$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "childsplaycsit321@gmail.com"; // Your Gmail address.
$mail->Password = "feioqvyptetcmoov"; // Your Gmail login password or App Specific Password.

$mail->setFrom('childsplay@gmail.com', 'ChildsPlay Website'); // Set the sender of the message.
$mail->Subject = 'ChildsPlay Account Registration Notification'; // The subject of the message.
$mail->isHTML(true); //allows to use HTML content

//send email when admin accepts or rejects the account
if(isset($_SESSION["uID"])){
	$uID = $_SESSION["uID"];
	echo "iD: ".$uID;
	$sql = "SELECT email FROM USERS WHERE userID=$uID";
	$result = $conn->query($sql);
	$email = "";
	$message = "";
	while($row = mysqli_fetch_assoc($result))
		$email = $row["email"];
	
	$mail->addAddress($email); // Set the recipient of the message

	if(isset($_SESSION["accepted"])){
		$accepted = $_SESSION["accepted"];
		if($accepted == 1){
			$message = "<span style='font-size:16px;font-weight:bold'>Congratulations!</span><br/><br/>";
			$message .=	"Your account in ChildsPlay website has been approved by admin! Now you can use this account to login!";
		}
		else if ($accepted == -1){
			$message = "<span style='font-size:16px;font-weight:bold'>Unfortunately,</span><br/><br/>";
			$message .=	"Your account in ChildsPlay website is rejected by admin!";
		}
	}
	$mail->Body = $message; // Set a plain text body.

	// ... or send an email with HTML.
	//$mail->msgHTML(file_get_contents('contents.html'));
	// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.
	//$mail->AltBody = 'This is a plain-text message body'; 

	// Optional: attach a file
	//$mail->addAttachment('images/phpmailer_mini.png');

	if ($mail->send()) {
		echo "Your message was sent successfully!";
		header('location: userPage.php');
	} else {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
//send email to admin when there's a new registered account
if(isset($_SESSION["uEmail"])){
	$email = $_SESSION["uEmail"];
	$mail->addAddress("childsplaycsit321@gmail.com"); // Set the recipient of the message.
	$url = "http://localhost/CSIT321/ChildsPlay/userPage.php"; //NEED TO CHANGE TO MATCH WITH THE ONLINE WEB SERVER
	$message = "<span style='font-size:16px;font-weight:bold'>Notification!</span><br/><br/>";
	$message .=	"A new account has been registered with the email address $email in ChildsPlay website! See it <a href=$url >here</a>";
	$mail->Body = $message;
	
	if ($mail->send()) {
		echo "Your message was sent successfully!";
	} else {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
unset($_SESSION["uID"]);
unset($_SESSION["accepted"]);
unset($_SESSION["uEmail"]);
