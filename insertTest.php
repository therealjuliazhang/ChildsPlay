<?php
/*
===================================================================================
Title:Insert Test; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
===================================================================================
*/
include "adminAccess.php";
include "db_connection.php";
$conn = OpenCon();

$errorFlag = false;
$testTitle = $_POST["testTitle"];

if(isset($_POST["createTest"])){
	$title = $_POST["testTitle"];
	$description = $_POST["description"];
	$dateCreated = $dateEdited = date("Y-m-d");
	//insert new test in database
	$stmt = $conn->prepare("INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES (?, ?, ?, ?)");
	$stmt->bind_param("ssss", $title, $description, $dateCreated, $dateEdited);
	
	if(!($stmt->execute())){
		$errorFlag = true;
		echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>"; 
	}
	else{
		$testID = $conn->insert_id;
		if(isset($_SESSION["createURL"])){
			$url = $_SESSION["createURL"];
			$index = strpos($url,"=");
			if($index !== false){
				$taskList = substr($url, $index+1);
				$idList = explode("&", $taskList);
				$order = 0;
				foreach($idList as $taskID){
					$order++;
					$query = $conn->prepare("INSERT INTO TASKASSIGNMENT(testID, taskID, orderInTest) VALUES (?, ?, ?)");
					$query->bind_param("iii", $testID, $taskID, $order);
					if(!$query->execute()){
						$errorFlag = true;
						echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>";
					}
					else
						$errorFlag = false;
					$query->close();
				}
			}
		}
	}
	$stmt->close();
	CloseCon($conn);

	if($errorFlag == false){
		unset($_SESSION["createURL"]);
		header("Location: viewExistingTests.php");
	}
}
