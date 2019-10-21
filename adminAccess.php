<?php
    session_start();
    //$adminAccess = false;
    if(!isset($_SESSION['accountType']))
        header('Location: login.php');
    else{
        $accountType = $_SESSION['accountType'];
        if($accountType != 1){
            header('Location: login.php');
            //$adminAccess = true;
            //$_SESSION["adminAccess"] = $adminAccess;
        }
        $userID = $_SESSION["userID"];
    }
    /*
    if(!isset($_SESSION['adminAccess']))
        if($_SESSION['adminAccess'] == false)
            header('Location: login.php');
    */       
?>