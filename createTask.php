<?php
/*
=====================================================================
Title:Create Task; 
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789);
=====================================================================
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

$dateCreated = date("Y-m-d");
//insert task into database
$sql = $conn->prepare("INSERT INTO TASK (taskTitle, instruction, activityStyle, dateCreated) VALUES (?, ?, ?, ?)");
$sql->bind_param("ssss", $title, $instruction, $activityStyle, $dateCreated);

if ($sql->execute()){ 
    //get ID of inserted task
    $taskID = $conn->insert_id;
	echo $taskID;
	$sql->close();
	foreach($files as $name)
	{
		if(file_exists($UploadFolder."/".$name) == true){
			//get imageID of the existing image
			$idSql = $conn->prepare("SELECT imageID FROM IMAGE WHERE address=?");
			$path = $UploadFolder."/".$name;
			$idSql->bind_param("s", $path);
			$idSql->execute();
			$idResult = $idSql->get_result();
			if($idResult->num_rows != 0){
				$id = $idResult->fetch_assoc();
				//Assign an image to a task in database	
				$insertQuery = $conn->prepare("INSERT INTO IMAGEASSIGNMENT VALUES (?, ?)");
				$insertQuery->bind_param("ii", $id["imageID"], $taskID);
				if(!$insertQuery->execute()){
					$errorMsg .= "<span style='color:red'>Failed to add image record!<br/>".mysqli_error($conn)."</span><br/>";
				}
				$insertQuery->close();
			}
			else{
				//insert an image to the database if it doesn't exist
				$address = $UploadFolder."/".$name;
				$insertImgQuery = $conn->prepare("INSERT INTO IMAGE(address) VALUES(?)");
				$insertImgQuery->bind_param("s", $address);

				if($insertImgQuery->execute()){
					$imageID = $conn->insert_id;
					//Assign an image to a task in database
					$insertQuery = $conn->prepare("INSERT INTO IMAGEASSIGNMENT VALUES (?, ?)");
					$insertQuery->bind_param("ii", $imageID, $taskID);
					
					if(!$insertQuery->execute())
						$errorMsg .= "<span style='color:red'>Failed to add image record!<br/>".mysqli_error($conn)."</span><br/>";
					$insertQuery->close();
				}
				else
					$errorMsg .= "<span style='color:red'>Failed to add image record 1111!<br/>".mysqli_error($conn)."</span><br/>";
				$insertImgQuery->close();
			}
			$idResult->close();
		}
	}
	
	//Only insert into taskassignment when create a new task in Edit test
	if($testID != 0){
		$index = $_POST["orderInTest"] + 1;
		//check activity style and save pointsInterval for Character Ranking task
		if($activityStyle == "Character Ranking"){
			$pointsInterval = $_POST["pointsInterval"];
			$sql = $conn->prepare("INSERT INTO TASKASSIGNMENT (testID, taskID, orderInTest, pointsInterval) VALUES(?, ?, ?, ?)");
			$sql->bind_param("iiii", $testID, $taskID, $index, $pointsInterval);
		}
		else{
			$sql = $conn->prepare("INSERT INTO TASKASSIGNMENT (testID, taskID, orderInTest) VALUES(?, ?, ?)");
			$sql->bind_param("iii", $testID, $taskID, $index);
		}
		if (!$sql->execute())
			$errorMsg .= "<span style='color:red'>Failed to add record! ".mysqli_error($conn)."</span><br/>";
		$sql->close();
	}
}
else
	$errorMsg .= "<span style='color:red'>Error: ".$sql."<br/>".mysqli_error($conn)."</span>";
echo $errorMsg;
CloseCon($conn);
?>