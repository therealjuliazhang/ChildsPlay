<?php 
/*
Title:Update Educator; 
Author:Phuong Linh Bui (5624095), Andre Knell (5741622);
*/
include "educatorAccess.php";
include 'db_connection.php';
$conn = OpenCon();
//session_start();

if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];

//get username
if(isset($_POST["username"]))
	$username = $_POST["username"];
//get email
if(isset($_POST["email"]))
	$email = $_POST["email"];

if(isset($_POST["locations"]))
	$locations = $_POST["locations"];

//get password
if(isset($_POST["password1"])){
	$password = $_POST["password1"];
	if($password != ""){
		$password = md5($password);
		//update educator details
		$sql = "UPDATE USERS SET username = '".$username."', password = '".$password."', email = '".$email."' WHERE userID=$userID";
	}
	else
		$sql = "UPDATE USERS SET username = '".$username."', email = '".$email."' WHERE userID=$userID";	
}
if ($conn->query($sql) === TRUE){
	echo "Successfully updated educator profile!";
}
else
	echo "Failed to update user record!";

//delete old location in the database
$deleteSql = "DELETE FROM LOCATIONASSIGNMENT WHERE userID=$userID";
if ($conn->query($deleteSql) === TRUE){
	foreach($locations as $location){
		$locIDSql = "SELECT locationID FROM LOCATION WHERE name='".$location."'";
		$result = $conn->query($locIDSql);
		while($row = mysqli_fetch_assoc($result)){
			$locationID = $row["locationID"];
			$locationQuery = "INSERT INTO LOCATIONASSIGNMENT VALUES ('".$locationID."', '".$userID."')";
			if ($conn->query($locationQuery) === TRUE){
				echo "Successfully updated educator profile!";
			}
			else
				echo "Failed to update location record!";
		}
	}
}
else
	echo "Failed to remove old location record!";
