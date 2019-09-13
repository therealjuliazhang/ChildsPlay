<?php
/*
author: Phuong Linh Bui (5624095)
*/
session_start();
include "db_connection.php";
$conn = OpenCon();

$errorFlag = false;

if(isset($_POST["createTest"])){
	$title = "'".$_POST["testTitle"]."'";
	echo "Title: ".$title;
	$description = "'".$_POST["description"]."'";
	$dateCreated = $dateEdited = "'".date("Y-m-d")."'";
	//$taskIds = $_POST["taskIds"];
	//create a new test
	$testQuery = "INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES ($title, $description, $dateCreated, $dateEdited)";
	if(!$result = $conn->query($testQuery)){
		$errorFlag = true;
		echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>"; 
	}
	else{
		$testID = $conn->insert_id;
		$idList = explode(",", $_SESSION["list"]);
		foreach($idList as $taskID){
			$query = "INSERT INTO TASKASSIGNMENT(testID, taskID) VALUES ($testID, $taskID)";
			if(!$result = $conn->query($query))
				$errorFlag = true;
			else
				$errorFlag = false;
		}
		if($errorFlag == false){
			session_destroy();
			unset($_SESSION["list"]);
			//echo $testID;
			header("Location: CreateTest.php");
		}
	}
}
?>
