<?php 
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();
session_start();
//results for Identify body parts task
if($_REQUEST["x"] && $_REQUEST["y"] && $_REQUEST["taskID"] && $_REQUEST["preID"] && $_SESSION["testID"]){
	$x = $_REQUEST["x"];
	$y = $_REQUEST["y"];
	$taskID = $_REQUEST["taskID"];
	$testID = $_SESSION["testID"];
	$preID = $_REQUEST["preID"];
	$dateCollected = date('Y-m-d');
	$sql = "INSERT INTO RESULTS(x, y, testID, taskID, preID) VALUES (".$x.", ".$y.", ".$testID.", ".$taskID.", ".$preID.")";
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