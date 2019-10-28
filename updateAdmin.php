<?php
/*
=============================================================
Title:Update Admin; 
Author:Alex Satoru Hanrahan (4836789), Andre Knell (5741622);
=============================================================
*/ 
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
/*
session_start();
if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];
else
	header("Location: login.php");
*/
//get username
if(isset($_POST["username"]))
	$username = $_POST["username"];
//get password
if(isset($_POST["password1"]))
	$password = $_POST["password1"];
//get email
if(isset($_POST["email"]))
	$email = $_POST["email"];

//get password
if(isset($_POST["password1"])){
	$password = $_POST["password1"];
	if($password != ""){
		$password = md5($password);
		//update educator details
		$sql = $conn->prepare("UPDATE USERS SET username = ?, password=?, email=? WHERE userID=?");
		$sql->bind_param("sssi", $username, $password, $email, $userID);
	}
	else{
		$sql = $conn->prepare("UPDATE USERS SET username = ?, email=? WHERE userID=?");
		$sql->bind_param("ssi", $username, $email, $userID);
	}
}
if ($sql->execute()){
	echo "Successfully updated educator profile!";
}
else
	echo "Failed to update user record!";
$sql->close();
CloseCon($conn);
?>