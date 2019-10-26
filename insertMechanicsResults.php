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
        $sql = $conn->prepare("INSERT INTO RESULTS (mechanic, taskID, preID, testID, otherComment) VALUES (?,?,?,?,?)");
        $sql->bind_param("siiis", $mechanic, $taskID, $preID, $testID, $otherComment);
		//$sql = "INSERT INTO RESULTS (mechanic, taskID, preID, testID, otherComment) VALUES ($mechanic, $taskID, $preID, $testID, $otherComment)";
	}
	else{
        $sql = $conn->prepare("INSERT INTO RESULTS (mechanic, taskID, preID, testID) VALUES (?,?,?,?)");
        $sql->bind_param("siii", $mechanic, $taskID, $preID, $testID);
		//$sql = "INSERT INTO RESULTS (mechanic, taskID, preID, testID) VALUES ($mechanic, $taskID, $preID, $testID)";
	}
    if ($sql->execute())
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
    CloseCon($conn);
?>