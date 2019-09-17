<?php
    //get user image directory
    $imageDirectory = "images/";
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
	/*
    //get image address
    if(isset($_POST['imageFileName']))
        $imageAddress = $imageDirectory . $_POST['imageFileName'];
    */
	
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
    
	//include_once 'createTask.php';
	/*
	//insert image path into database
    $sql = "INSERT INTO IMAGE (address) VALUES ('".$imageAddress."')"; 
    if ($conn->query($sql) === TRUE){
		$idSql = "SELECT imageID FROM IMAGE WHERE address=$imageAddress";
		$result = $conn->query($idSql);
		if($id = mysqli_fetch_assoc($result)){
			$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
			// Insert image file name into database	
			$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
			$result = $conn->query($insertQuery);
			if(!$result)
				echo "Error: " . $sql . "<br>" . $conn->error;
			else
				echo "New record created successfully";
		}
	}
	*/
	
	
    //insert into task assignment
    $sql = "INSERT INTO TASKASSIGNMENT (testID, taskID) VALUES (".$testID.", ".$taskID.")"; 
    if ($conn->query($sql) === TRUE)
        echo "New record added successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
    //redirect back to page
    if($from == "edit")
        header("Location: EditTest.php?testID=".$testID);
?>
