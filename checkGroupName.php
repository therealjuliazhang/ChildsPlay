<?php
/*Title: Check group name 
Author: Alex Satoru Hanrahan (4836789)
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
        $sql = "SELECT * FROM GROUPTEST WHERE name = '" .$input. "'";
        $result = $conn->query($sql);
        //return "" for error, true for no error
        if(mysqli_num_rows($result) != 1)
            echo json_encode(true);
        else
            echo json_encode(false);
    }
?>