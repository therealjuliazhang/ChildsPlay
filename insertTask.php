<?php
/*
===============================================================
Title:Insert Task; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
===============================================================
*/
include "adminAccess.php";
    //get user image directory
    $imageDirectory = "images/";
    //check if editing or creating test
    if(isset($_GET['from']))
        $from = $_GET['from'];
    //get test ID
    if(isset($_GET['testID']))
        $testID = $_GET['testID'];
    //get activity style
    if(isset($_POST['activityStyle']))
        $activityStyle = $_POST['activityStyle'];
    //get activity
    if(isset($_POST['activity']))
        $activity = $_POST['activity'];
	
	//open database connection
    include 'db_connection.php';
    $conn = OpenCon();
    //insert task into database
    $sql = $conn->prepare("INSERT INTO TASK (taskType, activity) VALUES (?, ?)");
    $sql->bind_param("ss", $activityStyle, $activity);
    if ($sql->execute()){ 
        echo "New record created successfully";
        //get ID of inserted task
        $taskID = $conn->insert_id;
    }
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
	
    //insert into task assignment
    $query = $conn->prepare("INSERT INTO TASKASSIGNMENT (testID, taskID) VALUES (?, ?)");
    $query->bind_param("ii", $testID, $taskID);
    if ($query->execute())
        echo "New record added successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $query->close();
    //redirect back to page
    if($from == "edit")
        header("Location: EditTest.php?testID=".$testID);
?>
