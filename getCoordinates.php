<?php 
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();

if($_REQUEST["x"] && $_REQUEST["y"]){
	$x = $_REQUEST["x"];
	$y = $_REQUEST["y"];
	echo "Welcome ".$x.", ".$y;
	
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