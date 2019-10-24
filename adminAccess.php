<?php
    session_start();
    if(!isset($_SESSION['accountType']))
        header('Location: login.php');
    else{
        $accountType = $_SESSION['accountType'];
        if($accountType != 1){
            header('Location: login.php');
        }
        $userID = $_SESSION["userID"];
    }   
?>