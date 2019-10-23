<?php
/*
===============================================================
Title:Insert Mechanics Results; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
===============================================================
 */
include "educatorAccess.php";
    // get data
    if(isset($_POST["mechanic"]))
        $mechanic = $_POST["mechanic"];
    if(isset($_POST["taskID"]))
        $taskID = $_POST["taskID"];
    if(isset($_POST["preID"]))
        $preID = $_POST["preID"];
	if(isset($_POST["testID"]))
        $testID = $_POST["testID"];
	if(isset($_POST["otherComment"]))
		$otherComment = $_POST["otherComment"];
    //insert into results table
    include 'db_connection.php';
    $conn = OpenCon();
	
	echo "Mechanic: ".$mechanic."<br/>";
	
	if($mechanic == "Other"){
		$mechanic = "'".$mechanic."'";
		$otherComment = "'".$otherComment."'";
		$sql = "INSERT INTO RESULTS (mechanic, taskID, preID, testID, otherComment) VALUES ($mechanic, $taskID, $preID, $testID, $otherComment)";
	}
	else{
		$mechanic = "'".$mechanic."'";
		$sql = "INSERT INTO RESULTS (mechanic, taskID, preID, testID) VALUES ($mechanic, $taskID, $preID, $testID)";
	}
	echo "Query: ".$sql;
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    CloseCon($conn);
?>