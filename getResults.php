<?php 
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();

//rsults for Identify body parts task
if($_REQUEST["x"] && $_REQUEST["y"] && $_REQUEST["taskID"] && $_REQUEST["testID"] && $_REQUEST["preID"]){
	$x = $_REQUEST["x"];
	$y = $_REQUEST["y"];
	$taskID = $_REQUEST["taskID"];
	$testID = $_REQUEST["testID"];
	$preID = $_REQUEST["preID"];
	$dateCollected = date('Y-m-d');
	$sql = "INSERT INTO RESULTS VALUES (NULL, ".$x.", ".$y.", CURRENT_TIMESTAMP, ".$testID.", ".$taskID.", ".$preID.")";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	CloseCon($conn);
}
else
	echo "Failed!";

//results from character ranking task
if($_REQUEST["name"] && $_REQUEST["character"] && $_REQUEST["points"]){
	$name = $_REQUEST["name"];
	$character = $_REQUEST["character"];
	$points = $_REQUEST["points"];
	
	$sql = "INSERT INTO BODYPARTS VALUES (".$x.", ".$y.")";
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