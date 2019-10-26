<?php
/*
=======================================
Title:Insert Likert Results; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
=======================================
*/
    include "educatorAccess.php";
    // get data
    if(isset($_POST["happy"]))
        $happy = $_POST["happy"];
    if(isset($_POST["taskID"]))
        $taskID = $_POST["taskID"];
    if(isset($_POST["preID"]))
        $preID = $_POST["preID"];
	if(isset($_POST["testID"]))
		$testID = $_POST["testID"];
    //insert into results table
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = $conn->prepare("INSERT INTO RESULTS (happy, taskID, preID, testID) VALUES (?,?,?,?)");
    $sql->bind_param("iiii", $happy, $taskID, $preID, $testID);  
    //$sql = "INSERT INTO RESULTS (happy, taskID, preID, testID) VALUES ($happy, $taskID, $preID, $testID)";//('".$happy."', '".$taskID."', '".$preID."')"; 
    if ($sql->execute())
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $sql->close();
    CloseCon($conn);
?>