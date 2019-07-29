<?php
    //fetch groups
    include 'db_connection.php';
    $conn = OpenCon();
    $sql = "SELECT * FROM GROUPTEST";
    $result = $conn->query($sql);
    $groups = array();
    while($row = mysqli_fetch_assoc($result))
        $groups[] = $row;
    if(isset($_REQUEST['groupName'])){
        $input = $_REQUEST['groupName'];
        for($i=0;$i<sizeof($groups);$i++){
            if($input==$groups[$i]['name'])
                echo json_encode("Name is already used by an existing group.");
            else
                echo false;
        }
    }
?>