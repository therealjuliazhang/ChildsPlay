<?php
/*
=======================================
Title: Check location
Author: Alex Satoru Hanrahan (4836789)
=======================================
*/
    //get input
    if(isset($_POST['location']))
        $location = $_POST['location'];

    //get current group name (needed for editing groupname)
    // $currentGroupName = "";
    // if(isset($_POST['currentGroupName']))
    //     $currentGroupName = $_POST['currentGroupName'];
    // if($input == $currentGroupName){
    //     echo json_encode(true);
    // }
    // else{
    
    //check if group name already taken by selecting it from database
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT name FROM LOCATION WHERE name='".$location."'";
    $result = $conn->query($sql);
    // return false for error, true for no error
    if(mysqli_num_rows($result) == 0)
        echo json_encode(true);
    else
        echo json_encode(false);
?>