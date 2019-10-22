<?php
/*
Title:Remove Task; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
*/
//session_start();
include "adminAccess.php";
    //get task ID
    if(isset($_GET["taskID"]))
        $taskID = $_GET["taskID"];
	//get the url of createTest page
	$url="";
	if(isset($_SESSION["createURL"]))
		$url = $_SESSION["createURL"];
    //open connection
    include 'db_connection.php';
    $conn = OpenCon();  
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
	//get test ID
    if(isset($_GET["testID"])){
        $testID = $_GET["testID"];
		//delete from taskassignment
		$sql = "DELETE FROM TASKASSIGNMENT WHERE taskID=" .$taskID. " AND testID=" .$testID;  
		if ($conn->query($sql) === TRUE) {
			echo "Record deleted successfully";
		} else {
			echo "Error deleting record: " . $conn->error;
		}
		//close connection
		$conn->close();  
		//go back to edit Test page
		header("Location: editTest.php?testID=$testID");
	}
	else{
		//close connection
		$conn->close();  
		//remove the selected taskID from the url
		if(strpos($url, "&$taskID&") !== false){ 
			$string = "'&".$taskID."'";
			$url = str_replace("&$taskID&", "&", $url);
		}
		else if(strpos($url, "?taskID=$taskID") !== false){
			if(strpos($url, "&") !== false)
				$url = str_replace("$taskID&", "", $url);
			else
				$url = str_replace("?taskID=$taskID", "", $url);
		}
		else if(strpos($url, "&$taskID") !== false){
			$string = "'&".$taskID."'";
			$url = str_replace("&$taskID", "", $url);
		}
		//go back to create Test page
		header("Location: $url");
	}
?>