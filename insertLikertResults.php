<?php
    // get data
    if(isset($_POST["happy"]))
        $happy = $_POST["happy"];
    if(isset($_POST["taskID"]))
        $taskID = $_POST["taskID"];
    if(isset($_POST["preID"]))
        $preID = $_POST["preID"];
    //insert into results table
    include 'db_connection.php';
    $conn = OpenCon();  
    $sql = "INSERT INTO RESULTS (happy, taskID, preID) VALUES ('".$happy."', '".$taskID."', '".$preID."')"; 
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
?>