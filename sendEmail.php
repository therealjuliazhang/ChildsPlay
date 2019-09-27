<?php

date_default_timezone_set('Etc/UTC');
//include 'db_connection.php'
//$conn->Open();
// Edit this path if PHPMailer is in a different location.
require 'PHPMailer/PHPMailerAutoload.php';

if(isset($_SESSION["uID"])){
	$uID = $_SESSION["uID"];
	echo "iD: ".$uID;
	$sql = "SELECT email FROM USERS WHERE userID=$uID";
	$result = $conn->query($sql);
	$email = "";
	while($row = mysqli_fetch_assoc($result))
		$email = $row["email"];
	
	//$email = "'".$email."'";
	$mail = new PHPMailer;
	$mail->isSMTP();

	/*
	 * Server Configuration
	 */

	$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
	$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
	$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
	$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
	$mail->Username = "childsplaycsit321@gmail.com"; // Your Gmail address.
	$mail->Password = "feioqvyptetcmoov"; // Your Gmail login password or App Specific Password.

	/*
	 * Message Configuration
	 */

	$mail->setFrom('childsplay@gmail.com', 'ChildsPlay Website'); // Set the sender of the message.
	$mail->addAddress($email); // Set the recipient of the message.
	$mail->Subject = 'PHPMailer GMail testing'; // The subject of the message.

	$mail->isHTML(true); //allows to use HTML content
	/*
	 * Message Content - Choose simple text or HTML email
	 */
	 
	// Choose to send either a simple text email...
	$message = "<span style='font-size:16px;font-weight:bold'>Congratulations!</span><br/><br/>";
	$message .=	"Your account in ChildsPlay website has been approved by admin! Now you can use this account to login!";
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
