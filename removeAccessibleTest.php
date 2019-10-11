<!--
Title:Remove Accessible Test; 
Author:Alex Satoru Hanrahan (4836789); 
-->
<?php
    session_start();
    if(isset($_SESSION["userID"]))
        $userID = $_SESSION["userID"];
    else
        header("Location: login.php");
    //get test ID
    if(isset($_GET["testID"]))
        $testID = $_GET["testID"];
    //get selected user ID
    if(isset($_GET["userID"]))
        $selectedUserID = $_GET["userID"];
    //open connection
    include 'db_connection.php';
    $conn = OpenCon();  
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //delete from testassignment
    $sql = "DELETE FROM TESTASSIGNMENT WHERE userID=" .$selectedUserID. " AND testID=" .$testID;  
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    //close connection
    $conn->close();  
    //go back to accessibleTests page
    header("Location: accessibleTest.php?userID=".$selectedUserID);
?>