<?php
/*
=======================================
Title: Check group name 
Author: Alex Satoru Hanrahan (4836789)
=======================================
*/
    //get input
    if(isset($_REQUEST['groupName']))
        $input = $_REQUEST['groupName'];
    //get current group name (needed for editing groupname)
    $currentGroupName = "";
    if(isset($_POST['currentGroupName']))
        $currentGroupName = $_POST['currentGroupName'];
    if($input == $currentGroupName){
        echo json_encode(true);
    }
    else{
        //check if group name already taken by selecting it from database
        include 'db_connection.php';
        $conn = OpenCon();
        $sql = $conn->prepare("SELECT * FROM GROUPTEST WHERE name = ?");
        $sql->bind_param("s", $input);
        $sql->execute();
        $result = $sql->get_result();
        if($result->num_rows != 1)
            echo json_encode(true);
        else
            echo json_encode(false);
    }
?>