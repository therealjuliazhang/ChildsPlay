<?php
    session_start();
    //get user ID
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
    //add to testassignment
    $sql = "INSERT INTO TESTASSIGNMENT (userID, testID) VALUES (" .$userID. ", " .$testID. ")";  
    if ($conn->query($sql) === TRUE) {
        echo "Record inserted successfully";
    } else {
        echo "Error inserting record: " . $conn->error;
    }
    //close connection
    $conn->close();  
    //go back to accessibleTests page
    header("Location: selectAccessibleTest.php");
?>