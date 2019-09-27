<?php
    session_start();
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
    }
    
    echo "This is the user id ".$userID."<br/>";
    echo "This is the accepted value ".$accepted."<br/>";
    
    //query works if there is a value for userID
    
    $query = "UPDATE USERS SET accepted = ".$accepted." WHERE userID = ".$userID;
    if ($conn->query($query) === TRUE)
    {
        echo "Record updated successfully";
		include 'sendEmail.php';
        //header('location: userPage.php');
    }
    else
    {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
    
?>
