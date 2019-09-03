<?php
    session_start();
    //if(isset($_SESSION["userID"]))
    //    $userID = $_SESSION["userID"];
    $userID = 2; //remove after admin pages are linked up
    //get test ID
    if(isset($_GET["testID"]))
        $testID = $_GET["testID"];
    //open connection
    include 'db_connection.php';
    $conn = OpenCon();  
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //delete from testassignment
    $sql = "DELETE FROM TESTASSIGNMENT WHERE userID=" .$userID. " AND testID=" .$testID;  
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    //close connection
    $conn->close();  
    //go back to accessibleTests page
    header("Location: accessibleTest.php");
?>