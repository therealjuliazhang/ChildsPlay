<?php
    include 'db_connection.php';
    $conn = OpenCon();
    if(isset($_REQUEST['email']))
        $input = $_REQUEST['email'];
    $currentEmail = "";
    if(isset($_POST['currentEmail']))
        $currentEmail = $_POST['currentEmail'];
    if($input == $currentEmail){
        echo json_encode(true);
    }
    else{
        //check for existing username by selecting user from database
        $sql = $conn->prepare("SELECT * FROM USERS WHERE email = ?");
        $sql->bind_param("s", $input);
        $sql->execute();
        $result = $sql->get_result();
        //return "" for error, true for no error
        if($result->num_rows == 0)
            echo json_encode(true);
        else
            echo json_encode(false);
        $sql->close();
    }
    CloseCon($conn);
?>