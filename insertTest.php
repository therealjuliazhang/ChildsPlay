<?php
/*
=======================================
Title:Insert Test; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
=======================================
*/
include "adminAccess.php";
//session_start();
include "db_connection.php";
$conn = OpenCon();

$errorFlag = false;

$testTitle = $_POST["testTitle"];
echo "Test title: ".$testTitle;

if(isset($_POST["createTest"])){
	$title = "'".$_POST["testTitle"]."'";
	echo "Title: ".$title;
	$description = "'".$_POST["description"]."'";
	$dateCreated = $dateEdited = "'".date("Y-m-d")."'";
	//$taskIds = $_POST["taskIds"];
	//create a new test
	$testQuery = "INSERT INTO TEST(title, description, dateCreated, dateEdited) VALUES ($title, $description, $dateCreated, $dateEdited)";
	if(!($result = $conn->query($testQuery))){
		$errorFlag = true;
		echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>"; 
	}
	else{
		$testID = $conn->insert_id;
		if(isset($_SESSION["createURL"])){
			$url = $_SESSION["createURL"];
			$index = strpos($url,"=");
			$taskList = substr($url, $index+1);
			$idList = explode("&", $taskList);
			$order = 0;
			foreach($idList as $taskID){
				$order++;
				$query = "INSERT INTO TASKASSIGNMENT(testID, taskID, orderInTest) VALUES ($testID, $taskID, $order)";
				if(!$result = $conn->query($query)){
					$errorFlag = true;
					echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>";
				}
				else
					$errorFlag = false;
			}
		}/*
		if(isset($_SESSION["list"])){
			$idList = explode(",", $_SESSION["list"]);
			$index = 0;
			foreach($idList as $taskID){
				$index++;
				$query = "INSERT INTO TASKASSIGNMENT(testID, taskID, orderInTest) VALUES ($testID, $taskID, $index)";
				if(!$result = $conn->query($query)){
					$errorFlag = true;
					echo "<span style='color:red'>Failed to create a new test! ".mysqli_error($conn)."</span><br/>";
				}
				else
					$errorFlag = false;
			}
		}
		else
			$errorFlag = true;*/
	}
	if($errorFlag == false){
		unset($_SESSION["createURL"]);
		header("Location: viewExistingTests.php");
	}
}
