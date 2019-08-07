<?php
    //fetch groups
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM GROUPTEST";
    $result = $conn->query($sql);
    $groups = array();
    while($row = mysqli_fetch_assoc($result))
        $groups[] = $row;
    if(isset($_REQUEST['groupName']))
        $input = $_REQUEST['groupName'];
    // $valid = true;
    $nameExists = false;
    // $inputEmpty = false;
    // if(!isset($input) || trim($input) == ''){
    //     $valid = false;
        // $inputEmpty = true;
    // }
    // else{
        for($i=0;$i<sizeof($groups);$i++){
            if($input==$groups[$i]['name']){
                // echo true;
                // $valid = false;
                $nameExists = true;
                break;
            }
        }
    // }
    // if($valid){
        // echo false;
    // }
    // else{
        if($nameExists)
            echo json_encode("");
        else
            echo json_encode("true");
            // echo json_encode("This name is already used by an existing group.");
        // else if($inputEmpty)
        //     echo json_encode("Enter a group name.");
    // }
?>