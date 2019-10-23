<?php
/*
=======================================
Title:Reset password;
Author:Phuong Linh Bui (5624095);
=======================================
*/
session_start();
include "db_connection.php";
$conn = OpenCon();

//if(isset($_POST["submitBtn"])){  
    if(isset($_POST["email"]) && !empty($_POST["email"])){
        $input = $_POST["email"];
        //check if the email is already registered in database
        $sql = "SELECT * FROM USERS WHERE email = '" .$input. "'";
        $result = $conn->query($sql);
        //if email already existed, send an email with reset password link to user, otherwise return error message
        if(mysqli_num_rows($result)==1){
            echo "<div style='color:red;font-style:italic'><p>An email has been sent to you with a link to reset your password.</p></div>";
        }
        else
            echo "<span style='color:red;font-style:italic'><p>No user is registered with this email address!</p></span>";
    }
    CloseCon($conn);
//}
?>