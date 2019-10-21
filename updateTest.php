<?php 
/*
Title:Update Test; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
*/
include "adminAccess.php";
//connect to database
include 'db_connection.php';
$conn = OpenCon();
//get test ID
if(isset($_GET["testID"]))
    $testID = $_GET["testID"];
//get input test title and description
if(isset($_POST["testTitle"]))
    $testTitle = $_POST["testTitle"];
if(isset($_POST["description"]))
    $description = $_POST["description"];
//update title
$sql = "UPDATE TEST SET title = '" .$testTitle. "' WHERE testID = " .$testID;
if ($conn->query($sql) === TRUE)
    echo "Record updated successfully";
else
    echo "Error updating record: " . $conn->error;
//update description
$sql = "UPDATE TEST SET description = '" .$description. "' WHERE testID = " .$testID;
if ($conn->query($sql) === TRUE)
    echo "Record updated successfully";
else
    echo "Error updating record: " . $conn->error;
//update last edit
$date = date('Y/m/d');
$sql = "UPDATE TEST SET dateEdited = '" .$date. "' WHERE testID = " .$testID;
if ($conn->query($sql) === TRUE)
    echo "Record updated successfully";
else
    echo "Error updating record: " . $conn->error;
//close database connection
CloseCon($conn);
//redirect to edit test page
header("Location: viewExistingTests.php");