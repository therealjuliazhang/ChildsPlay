<?php
    //get user image directory
	$imageDirectory = "C:\xampp\htdocs\images";
    //get test ID
    if(isset($_GET['testID']))
        $testID = $_GET['testID'];
    //get activity style
    if(isset($_POST['activityStyle']))
        $activityStyle = $_POST['activityStyle'];
    //get activity
    if(isset($_POST['activity']))
        $activity = $_POST['activity'];
    //get image address
    if(isset($_POST['imageFileName']))
        $imageFileName = $imageDirectory . $_POST['imageFileName'];
    //open database connection
    include 'db_connection.php';
    $conn = OpenCon();
    //insert task into database
    $sql = "INSERT INTO TASK (taskType, activity)VALUES ('".$activityStyle."', '".$activity."')"; 
    if ($conn->query($sql) === TRUE){ 
        echo "New record created successfully";
        $check = true;
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
        $check = false;
    }	
    //get new task ID
    
    //insert image path into database
    $sql = "INSERT INTO IMAGE (taskType, activity)VALUES ('".$activityStyle."', '".$activity."')"; 
    if ($conn->query($sql) === TRUE){ 
        echo "New record created successfully";
        $check = true;
    }
    else{
        echo "Error: " . $sql . "<br>" . $conn->error;
        $check = false;
    }	
?>
