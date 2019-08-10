<?php
    $editing;
    if(isset($_POST['groupNameForEdit'])){
        $groupNameForEdit = $_POST['groupNameForEdit'];
        $editing = true;
    }
    else
        $editing = false;
    //fetch group names from database
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM GROUPTEST";
    $result = $conn->query($sql);
    $groups = array();
    while($row = mysqli_fetch_assoc($result))
        $groups[] = $row;
    if(isset($_REQUEST['groupName']))
        $input = $_REQUEST['groupName'];
    $nameExists = false;
    //check if input is the same as group name from database
    for($i=0;$i<sizeof($groups);$i++){
        if($input==$groups[$i]['name']){
            if($editing)
                continue;
            else{
                $nameExists = true;
                break;
            }
        }
    }
    //return "" for error, true for no error
    if($nameExists)
        echo json_encode("");
    else
        echo json_encode("true");
?>