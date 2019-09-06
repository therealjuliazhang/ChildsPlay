<?php
    //get test ID
    if(isset($_GET["testID"]))
        $testID = $_GET["testID"];
    //get task ID
    if(isset($_GET["taskID"]))
        $taskID = $_GET["taskID"];
    //open connection
    include 'db_connection.php';
    $conn = OpenCon();  
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
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
    header("Location: EditTest.php?testID=".$testID);
?>