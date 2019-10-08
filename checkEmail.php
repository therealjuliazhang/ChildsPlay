<!--
Title:Check Email; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789); 
-->
<?php
    include 'db_connection.php';
    $conn = OpenCon();
    if(isset($_REQUEST['email']))
        $input = $_REQUEST['email'];
    //check for existing username by selecting user from database
    $sql = "SELECT * FROM USERS WHERE email = '" .$input. "'";
    $result = $conn->query($sql);
    //return "" for error, true for no error
    if(mysqli_num_rows($result)==0)
        echo json_encode("true");
    else
        echo json_encode("");
?>