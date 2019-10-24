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
    
    //check if group name already taken by selecting it from database
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = $conn->prepare("SELECT name FROM LOCATION WHERE name=?");
    $sql->bind_param("s", $location);
    $sql->execute();
    $result = $sql->get_result();
    // $sql = "SELECT name FROM LOCATION WHERE name='".$location."'";
    // $result = $conn->query($sql);

    // return false for error, true for no error
    if($result->num_rows == 0)
        echo json_encode(true);
    else
        echo json_encode(false);
    $sql->close();
?>