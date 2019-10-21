<!--
Title:Update User Page; 
Author:Phuong Linh Bui (5624095), Julia Aoqi Zhang (5797585); 
-->
<?php
    //session_start();
    include "adminAccess.php";
    include 'db_connection.php';
    $conn = OpenCon();
    $userID="";
    $accepted="";
    //Get inputs
    if(isset($_GET["uid"]))
    {
        //echo "post uid exists <br/>";
        $userID .= $_GET["uid"];
        $_SESSION["uID"] = $userID;
    }
    if(isset($_GET["accepted"]))
    {
        //echo "post accepted exists <br/>";
        $accepted .= $_GET["accepted"];
		$_SESSION["accepted"] = $accepted;
    }
    
    echo "This is the user id ".$userID."<br/>";
    echo "This is the accepted value ".$accepted."<br/>";
    
    //query works if there is a value for userID
    
    $query = "UPDATE USERS SET accepted = ".$accepted." WHERE userID = ".$userID;
    if ($conn->query($query) === TRUE)
    {
        echo "Record updated successfully";
		include 'sendEmail.php';
        header('location: userPage.php');
    }
    else
    {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
?>
