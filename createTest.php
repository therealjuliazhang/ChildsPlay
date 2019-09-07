<?php
include 'db_connection.php';
$taskID = 2; //need to select taskID that is just added into database

if(isset($_POST["btnSubmit"])){
	$errors = array();
	$uploadedFiles = array();
	$counter = 1;
	$temp = $_FILES["file"]["tmp_name"]; 
	$name = basename($_FILES["file"]["name"]); // File upload path
	$size = $_FILES["file"]["size"];
	
	uploadImage($temp, $size, $name, $uploadedFiles, $taskID, $errors);
	displayResult($errors, $uploadedFiles, $counter);
}

if(isset($_POST["multiSubmit"]))
{
	$errors = array();
	$uploadedFiles = array();
	//count the number of files in temporary directory
	$counter = 0;
	
	foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
		$temp = $_FILES["files"]["tmp_name"][$key]; 
		$name = basename($_FILES["files"]["name"][$key]); // File upload path
		$size = $_FILES["files"]["size"][$key];
		if(empty($temp))
		{
			break;
		}
		$counter++;
		uploadImage($temp, $size, $name, $uploadedFiles, $taskID, $errors);
	}
	displayResult($errors, $uploadedFiles, $counter);
}

function uploadImage(&$temp, &$size, &$name, &$uploadedFiles, &$taskID, &$errors){
	//include 'db_connection.php';
	$conn = OpenCon();
	//temporary directory where PHP interpreter puts the uploaded file
	$extension = array("jpeg","jpg","png","gif"); // File extensions accepted
	$bytes = 1024;
	$KB = 1024;
	$totalBytes = $bytes * $KB * 5;
	$UploadFolder = "images";
	$UploadOk = true;
	
	//check the size of each uploaded image
	if($size > $totalBytes)
	{
		$UploadOk = false;
		array_push($errors, $name." file size is larger than the 5 MB.");
	}
	//get the file extension
	$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION)); 
	
	// Check whether file type is valid
	if(in_array($ext, $extension) == false){
		$UploadOk = false;
		array_push($errors, $name." is invalid file type.");
	}
	
	if(file_exists($UploadFolder."/".$name) == true){
		$UploadOk = false;
		array_push($uploadedFiles, $name);
		//get imageID of the existing image
		$idSql = "SELECT imageID FROM IMAGE WHERE address='images/".$name."'";
		$idResult = $conn->query($idSql);
		if($id = mysqli_fetch_assoc($idResult)){
			$insertValuesSQL = "('".$id["imageID"]."', ".$taskID.")";
			// Insert image file name into database	
			$insertQuery = "INSERT INTO IMAGEASSIGNMENT VALUES $insertValuesSQL";
			$result = $conn->query($insertQuery);
			if(!$result)
				array_push($errors, "Failed to add record");
		}
	}
	
	if($UploadOk == true){
		move_uploaded_file($temp,$UploadFolder."/".$name); // Upload file to server
		array_push($uploadedFiles, $name);

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
					array_push($errors, "Failed to add record");
			}
		}
	}
	CloseCon($conn);
}

function displayResult(&$errors, &$uploadedFiles, &$counter){
	if($counter>0){
		if(count($errors)>0)
		{
			echo "<b>Errors:</b>";
			echo "<br/><ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
				echo "</ul><br/>";
		}
		else{
			echo "<b>Uploaded Files:</b>";
			echo "<br/><ul>";
			foreach($uploadedFiles as $fileName)
			{
				echo "<li>".$fileName."</li>";
			}
			echo "</ul><br/>";				
			echo count($uploadedFiles)." file(s) are successfully uploaded.";
		}
	}
	else{
		echo "Please, Select file(s) to upload.";
	}
}
?>