<!--
Title:Assign Test; 
Author:Alex Satoru Hanrahan (4836789); 
-->
<?php
/*
    session_start();
    if(isset($_SESSION['userID']))
        $userID = $_SESSION['userID'];
    else
        header('login.php');
*/
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
    //get user ID
    if(isset($_GET["userID"]))
       $selectedUserID = $_GET["userID"];
    // $userID = 2; //remove after admin pages are linked up
    //get test ID
    if(isset($_GET["testID"]))
        $testID = $_GET["testID"];
    //check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    //add to testassignment
    $sql = "INSERT INTO TESTASSIGNMENT (userID, testID) VALUES (" .$selectedUserID. ", " .$testID. ")";  
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
    //close connection
    $conn->close();  
    //go back to accessibleTests page
    header("Location: selectAccessibleTest.php?userID=".$selectedUserID);
?>