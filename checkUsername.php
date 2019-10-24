<?php
    include 'db_connection.php';
    $conn = OpenCon(); 
    if(isset($_REQUEST['username']))
        $input = $_REQUEST['username'];
    $currentUsername = "";
    if(isset($_POST['currentUsername']))
        $currentUsername = $_POST['currentUsername'];
    if($input == $currentUsername){
        echo json_encode(true);
    }
    else{
        //check for existing username by selecting user from database
        $sql = $conn->prepare("SELECT * FROM USERS WHERE username = ?");
        $sql->bind_param("s", $input);
        $sql->execute();
        $result = $sql->get_result();
        // $sql = "SELECT * FROM USERS WHERE username = '" .$input. "'";
        // $result = $conn->query($sql);

        //return "" for error, true for no error
        if($result->num_rows == 0)
            echo json_encode(true);
        else
            echo json_encode(false);
        $sql->close();
    }
CloseCon($conn);
?>