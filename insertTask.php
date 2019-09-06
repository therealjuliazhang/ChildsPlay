<?php
    //get user image directory
    $imageDirectory = "C:/xampp/htdocs/images/";
    //check if editing or creating test
    if(isset($_GET['from']))
        $from = $_GET['from'];
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
        $imageAddress = $imageDirectory . $_POST['imageFileName'];
    //open database connection
    include 'db_connection.php';
    $conn = OpenCon();
    //insert task into database
    $sql = "INSERT INTO TASK (taskType, activity)VALUES ('".$activityStyle."', '".$activity."')"; 
    if ($conn->query($sql) === TRUE){ 
        echo "New record created successfully";
        //get ID of inserted task
        $taskID = $conn->insert_id;
    }
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    //insert image path into database
    $sql = "INSERT INTO IMAGE (address, imgType, taskID) VALUES ('".$imageAddress."', true, '".$taskID."')"; 
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    //insert into task assignment
    $sql = "INSERT INTO TASKASSIGNMENT (testID, taskID) VALUES (".$testID.", ".$taskID.")"; 
    if ($conn->query($sql) === TRUE)
        echo "New record created successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    //redirect back to page
    if($from == "edit")
        header("Location: EditTest.php?testID=".$testID);
?>
