<?php
/*
=======================================
Title:Insert Body Parts Results; 
Author:Phuong Linh Bui (5624095); 
=======================================
*/ 
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();
session_start();
include "educatorAccess.php";
//results for Identify body parts task
if($_REQUEST["x"] && $_REQUEST["y"] && $_REQUEST["taskID"] && $_REQUEST["preID"] && $_REQUEST["testID"]){
	$x = $_REQUEST["x"];
	$y = $_REQUEST["y"];
	$taskID = $_REQUEST["taskID"];
	$testID = $_REQUEST["testID"];
	$preID = $_REQUEST["preID"];
	$dateCollected = date('Y-m-d');
	$sql = $conn->prepare("INSERT INTO RESULTS(x, y, testID, taskID, preID) VALUES (?, ?, ?, ?, ?)");
	$sql->bind_param("ddiii", $x, $y, $testID, $taskID, $preID);
	
	//$sql = "INSERT INTO RESULTS(x, y, testID, taskID, preID) VALUES ($x, $y, $testID, $taskID, $preID)";
	if ($sql->execute()) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	$sql->close();
	CloseCon($conn);
}
else
	echo "Failed!";
?>