<?php
    // get data
    if(isset($_POST["mechanic"]))
        $mechanic = $_POST["mechanic"];
    if(isset($_POST["taskID"]))
        $taskID = $_POST["taskID"];
    if(isset($_POST["preID"]))
        $preID = $_POST["preID"];
    //insert into results table
    include 'db_connection.php';
    $conn = OpenCon();  
    $sql = "INSERT INTO RESULTS (mechanic, taskID, preID) VALUES ('".$mechanic."', '".$taskID."', '".$preID."')"; 
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
?>