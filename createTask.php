<?php
include 'db_connection.php';
$taskID; //need to select taskID that is just added into database
$UploadFolder = "images";
$names = $_POST["imageAddress"];
$instruction = $_POST["instruction"];
$testID = $_POST["testID"];
$activityStyle = $_POST["activityStyle"];
$activity = $_POST["activity"];
//$from = $_POST["from"];

$files = explode(", ", $names);
	
$conn = OpenCon();

//insert task into database
$sql = "INSERT INTO TASK (instruction, taskType, activity)VALUES ('".$instruction."', '".$activityStyle."', '".$activity."')"; 
if ($conn->query($sql) === TRUE){ 
    echo "New record created successfully";
    //get ID of inserted task
    $taskID = $conn->insert_id;
	
	foreach($files as $name)
	{
		if(file_exists($UploadFolder."/".$name) == true){
			//get imageID of the existing image
			$idSql = "SELECT imageID FROM IMAGE WHERE address='".$UploadFolder."/".$name."'";
			$idResult = $conn->query($idSql);
			if(mysqli_num_rows($idResult) != 0){
				$id = mysqli_fetch_assoc($idResult);
				$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
				// Insert image file name into database	
				$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
				$result = $conn->query($insertQuery);
				if(!$result)
					echo "<span style='color:red'>Failed to add record!<br/>".mysqli_error($conn)."</span>";
				else
					echo "Successfully added record!";
			}
			else{
				$insertImgQuery = "INSERT INTO IMAGE(address) VALUES('images/".$name."')";
				$result = $conn->query($insertImgQuery);
				if($result){
					$idSql = "SELECT imageID FROM IMAGE WHERE address='images/".$name."'";
					$idResult = $conn->query($idSql);
					if($id = mysqli_fetch_assoc($idResult)){
						$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
						// Insert image file name into database
						$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
						$result = $conn->query($insertQuery);
						if(!$result)
							echo "<span style='color:red'>Failed to add record!<br/>".mysqli_error($conn)."</span>";
						else
							echo "Successfully added record!";
					}
				}
			}
		}
	}

	//insert into task assignment
    $sql = "INSERT INTO TASKASSIGNMENT (testID, taskID) VALUES (".$testID.", ".$taskID.")"; 
    if ($conn->query($sql) === TRUE)
        echo "New record added successfully";
    else
        echo "Error: " . $sql . "<br>" . $conn->error;
}
else
   echo "Error: " . $sql . "<br>" . $conn->error;

CloseCon($conn);
?>