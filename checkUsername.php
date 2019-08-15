<?php
    include 'db_connection.php';
    $conn = OpenCon();
    if(isset($_REQUEST['username']))
        $input = $_REQUEST['username'];
    //check for existing username by selecting user from database
    $sql = "SELECT * FROM USERS WHERE username = '" .$input. "'";
    $result = $conn->query($sql);
    //return "" for error, true for no error
    if(!$result)
        echo json_encode("true");
    else
        echo json_encode("");
?>