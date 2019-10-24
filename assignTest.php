<!--
=======================================
Title:Assign Test; 
Author:Alex Satoru Hanrahan (4836789); 
=======================================
-->
<?php
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
    //get user ID
    if(isset($_GET["userID"]))
       $selectedUserID = $_GET["userID"];
    //get test ID
    if(isset($_GET["testID"]))
        $testID = $_GET["testID"];
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //add to testassignment
    $sql = $conn->prepare("INSERT INTO TESTASSIGNMENT (userID, testID) VALUES (?, ?)");
    $sql->bind_param("ii", $selectedUserID, $testID); 
    if ($sql->execute()) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
    $sql->close();
    //close connection
    CloseCon($conn);  
    //go back to accessibleTests page
    header("Location: selectAccessibleTest.php?userID=".$selectedUserID);
?>