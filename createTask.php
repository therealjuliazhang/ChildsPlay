<?php
/*
=======================================
Title:Create Task; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
=======================================
*/
include 'db_connection.php';
$conn = OpenCon();
include "adminAccess.php";

$taskID;
$UploadFolder = "images";
$names = $_POST["imageAddress"];
$instruction = $_POST["instruction"];
$title = $_POST["taskTitle"];

$testID = $_POST["testID"];

$activityStyle = $_POST["activityStyle"];
$files = explode(", ", $names);
$errorMsg = "";

$instructionValue = '"'.$instruction.'"';
$styleValue = '"'.$activityStyle.'"';
$taskTitle = '"'.$title.'"';
$dateCreated = '"'.date("Y-m-d").'"';
//insert task into database
$sql = "INSERT INTO TASK (taskTitle, instruction, activityStyle, dateCreated) VALUES ($taskTitle, $instructionValue, $styleValue, $dateCreated)"; 
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
			
				if($conn->query($insertQuery) === FALSE){
					$errorMsg .= "<span style='color:red'>Failed to add image record!<br/>".mysqli_error($conn)."</span><br/>";
				}
				
			}
			else{
				//insert an image to the database if it doesn't exist
				$address = "'".$UploadFolder."/".$name."'";
				$insertImgQuery = "INSERT INTO IMAGE(address) VALUES($address)";
				$result = $conn->query($insertImgQuery);
				$imageID = $conn->insert_id;
				if($result){
					$imageID = $conn->insert_id;
					//Assign an image to a task in database
					$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES ($imageID, $taskID)";
					$insertResult = $conn->query($insertQuery);
					
					if(!$insertResult)
						$errorMsg .= "<span style='color:red'>Failed to add image record!<br/>".mysqli_error($conn)."</span><br/>";
				}
				else
					$errorMsg .= "<span style='color:red'>Failed to add image record 1111!<br/>".mysqli_error($conn)."</span><br/>";
			}
		}
	}
	
	//Only insert into taskassignment when create a new task in Edit test
	if($testID != 0){
		$index = $_POST["orderInTest"] + 1;
		//check activity style and save pointsInterval for Character Ranking task
		if($activityStyle == "Character Ranking"){
			$pointsInterval = $_POST["pointsInterval"];
			$sql = "INSERT INTO TASKASSIGNMENT (testID, taskID, orderInTest, pointsInterval) VALUES($testID, $taskID, $index, $pointsInterval)";
		}
		else
			$sql = "INSERT INTO TASKASSIGNMENT (testID, taskID, orderInTest) VALUES($testID, $taskID, $index)"; 
		if ($conn->query($sql) !== TRUE)
			$errorMsg .= "<span style='color:red'>Failed to add record! ".mysqli_error($conn)."</span><br/>";
	}
}
else
	$errorMsg .= "<span style='color:red'>Error: ".$sql."<br/>".mysqli_error($conn)."</span>";
echo $errorMsg;

CloseCon($conn);
?>