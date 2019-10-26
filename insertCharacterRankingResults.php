<!--
=======================================
Title:Insert Character Ranking Results; 
Author:Phuong Linh Bui (5624095); 
=======================================
-->
<?php 
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();
include "educatorAccess.php";

//results from character ranking task
if($_REQUEST["imageID"] && $_REQUEST["score"] && $_REQUEST["taskID"] && $_REQUEST["preID"]){
	$imageID = $_REQUEST["imageID"];
	$score = $_REQUEST["score"];
	$taskID = $_REQUEST["taskID"];
	$testID = $_REQUEST["testID"];
	$preID = $_REQUEST["preID"];
	$sql = "INSERT INTO RANKING VALUES ($imageID, $score, $testID, $taskID, $preID)";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	CloseCon($conn);
}
else
	echo "Failed!";
?>