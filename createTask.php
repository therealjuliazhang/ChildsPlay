<?php
/*
author: Phuong Linh Bui (5624095)
*/
include 'db_connection.php';
$conn = OpenCon();
session_start();
if(isset($_SESSION['userID']))
    $userID = $_SESSION['userID'];
else
    header('login.php');
$taskID; //need to select taskID that is just added into database
$UploadFolder = "images";
$names = $_POST["imageAddress"];
$instruction = $_POST["instruction"];

$activityStyle = $_POST["activityStyle"];
$files = explode(", ", $names);
$errorMsg = "";

$instructionValue = '"'.$instruction.'"';
$styleValue = '"'.$activityStyle.'"';
//insert task into database
$sql = "INSERT INTO TASK (instruction, activityStyle) VALUES ($instructionValue, $styleValue)"; 
if ($conn->query($sql) === TRUE){ 
    //get ID of inserted task
    $taskID = $conn->insert_id;
	echo $taskID;
	foreach($files as $name)
	{
		if(file_exists($UploadFolder."/".$name) == true){
			//get imageID of the existing image
			$idSql = "SELECT imageID FROM IMAGE WHERE address='".$UploadFolder."/".$name."'";
			$idResult = $conn->query($idSql);
			if(mysqli_num_rows($idResult) != 0){
				$id = mysqli_fetch_assoc($idResult);
				$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
				//Assign an image to a task in database	
				$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
				$result = $conn->query($insertQuery);
				
				if(!$result)
					$errorMsg .= "<span style='color:red'>Failed to add image record! ".mysqli_error($conn)."</span><br/>";
			}
			else{
				//insert an image to the database if it doesn't exist
				$insertImgQuery = "INSERT INTO IMAGE(address) VALUES('images/".$name."')";
				$result = $conn->query($insertImgQuery);
				if($result){
					$idSql = "SELECT imageID FROM IMAGE WHERE address='images/".$name."'";
					$idResult = $conn->query($idSql);
					if($id = mysqli_fetch_assoc($idResult)){
						$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
						//Assign an image to a task in database
						$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
						$result = $conn->query($insertQuery);
						
						if(!$result)
							$errorMsg .= "<span style='color:red'>Failed to add image record!<br/>".mysqli_error($conn)."</span><br/>";
					}
				}
			}
		}
	}
	
	//Only insert into taskassignment when create a new task in Edit test
	if(isset($_POST["testID"])){
		$testID = $_POST["testID"];
		//insert into task assignment
		$index = $_POST["orderInTest"] + 1;
		$taskTitle = "'"."Task ".$index."'";
		$sql = "INSERT INTO TASKASSIGNMENT (testID, taskID, taskTitle, orderInTest) VALUES($testID, $taskID, $taskTitle, $index)"; 
		//$result = $conn->query($sql);
		
		if ($conn->query($sql) !== TRUE)
			$errorMsg .= "<span style='color:red'>Failed to add record! ".mysqli_error($conn)."</span><br/>";
	}
}
else
	$errorMsg .= "<span style='color:red'>Error: ".$sql."<br/>".mysqli_error($conn)."</span>";
echo $errorMsg;

CloseCon($conn);
?>