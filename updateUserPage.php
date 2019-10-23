<?php
/*
=======================================
Title:Update User Page; 
Author:Phuong Linh Bui (5624095), Julia Aoqi Zhang (5797585); 
=======================================
*/
    //session_start();
    include "adminAccess.php";
    include 'db_connection.php';
    $conn = OpenCon();
    $userID="";
    $accepted="";
    $check = false;
    //Get inputs
    if(isset($_POST["userid"]))
    {
        $userID = $_POST["userid"];
        $_SESSION["uID"] = $userID;
        $check = true;
    }
    else
        $check=false;
    if(isset($_POST["accepted"]))
    {
        $accepted = $_POST["accepted"];
        $_SESSION["accepted"] = $accepted;
        $check = true;
    }
    else
    $check = false;
    //query works if there is a value for userID
    if($check){
        $query = "UPDATE USERS SET accepted = ".$accepted." WHERE userID = ".$userID;
        if ($conn->query($query) === TRUE)
        {
            echo "Record updated successfully";
            include 'sendEmail.php';
        }
        else
        {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    }
?>
