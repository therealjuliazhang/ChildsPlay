<!--
Title:Update Educator; 
Author:Andre Knell (5741622); 
-->
<?php 
include 'db_connection.php';
$conn = OpenCon();
session_start();

if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];

//get username
if(isset($_POST["uName"]))
	$user = $_POST["uName"];
//get password
if(isset($_POST["password"]))
	$password = $_POST["password"];
//get email
if(isset($_POST["mailInput"]))
	$email = $_POST["mailInput"];


//updaet details (NEED TO CHANGE AND GET USERID)
$sql = "UPDATE USERS SET username = '".$user."', password = '".$password."', email = '".$email."' WHERE userID=".$userID;
    if (mysqli_query($conn, $sql))
    	header("Refresh:0; url=adminProfile.php");
    else
    	echo"error idk";