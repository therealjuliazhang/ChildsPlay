<?php
/*
Title:Reset password;
Author:Phuong Linh Bui (5624095);
*/
session_start();
include "db_connection.php";
$conn = OpenCon();

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

//send reset password link to user email
if(isset($_POST["resetEmail"])){
	$email = $_POST["resetEmail"];

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
		} else {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
	}
	else
		echo "Failed.";
}
?>