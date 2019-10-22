<?php
/*
Title: Send Email; 
Author: Phuong Linh Bui (5624095); 
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

//send email to user when admin accepts or rejects the account
if(isset($_SESSION["uID"])){
	$uID = $_SESSION["uID"];
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
			$message .=	"Your account in ChildsPlay website is declined by admin!";
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
		header('Location: userPage.php');
	} else {
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
}
//send email to admin when there's a new registered account
if(isset($_POST["registerEmail"])){
//if(isset($_SESSION["uEmail"])){
	$email = $_POST["registerEmail"];
	//$email = $_SESSION["uEmail"];
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

//send reset password link to user email
if(isset($_POST["resetEmail"])){
if(isset($_SESSION["resetPwEmail"])){
	$email = $_SESSION["resetPwEmail"];

	$password = rand(999, 99999);
	$password_hash = md5($password);

	$sql = "UPDATE USERS SET token='$password_hash' WHERE email='$email'";
	$result = $conn->query($sql);
	$count = mysqli_affected_rows($conn);
	if($count == 1){
		$mail->Subject = 'ChildsPlay Reset Password Notification';
		$mail->addAddress($email); // Set the recipient of the message.
		$url = "http://localhost/CSIT321/ChildsPlay/resetPassword.php?token=$password_hash"; //NEED TO CHANGE TO MATCH WITH THE ONLINE WEB SERVER
		$message = "<span style='font-size:16px;font-weight:bold'>Reset Password Link</span><br/><br/>";
		$message .=	"A reset password has been made in ChildsPlay website with the email address $email! Please click this <a href=$url >link</a> to reset your password!";
		$mail->Body = $message;
		
		if ($mail->send()) {
			echo "Your message was sent successfully!";
			//exit;
		} else {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
	}
	else
	echo "Failed.";
}
}
if(isset($_SESSION["uID"])) unset($_SESSION["uID"]);
if(isset($_SESSION["accepted"])) unset($_SESSION["accepted"]);
if(isset($_SESSION["uEmail"])) unset($_SESSION["uEmail"]);
if(isset($_SESSION["resetPwEmail"])) unset($_SESSION["resetPwEmail"]);
