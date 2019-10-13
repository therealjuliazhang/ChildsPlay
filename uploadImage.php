<!--
Title:Upload Image; 
Author:Phuong Linh Bui (5624095); 
-->
<?php
$UploadFolder = "images";

if(isset($_FILES["files"])){
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
		$value = uploadImage($temp, $size, $name, $uploadedFiles, $errors);
	}
	displayResult($errors, $uploadedFiles, $counter);
}

if(isset($_FILES["file"])){
	$errors = array();
	$uploadedFiles = array();
	$counter = 1;
	$temp = $_FILES["file"]["tmp_name"]; 
	$name = basename($_FILES["file"]["name"]); // File upload path
	$size = $_FILES["file"]["size"];
	
	if(empty($temp)){
		$counter = 0;
		displayResult($errors, $uploadedFiles, $counter);
	}
	else{
		uploadImage($temp, $size, $name, $uploadedFiles, $errors);
		displayResult($errors, $uploadedFiles, $counter);
	}
}

function uploadImage(&$temp, &$size, &$name, &$uploadedFiles, &$errors){
	$value ="";
	$extension = array("jpeg","jpg","png","gif"); // File extensions accepted
	$bytes = 1024;
	$KB = 1024;
	$totalBytes = $bytes * $KB * 5;
	global $UploadFolder;
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
	//check if the image already existed in the target directory
	if(file_exists($UploadFolder."/".$name) == true){
		$UploadOk = false;
		array_push($uploadedFiles, $name);
		echo "<div style='float:left;margin:25px'><img id='OriginalImage' class='image' style='width:150px' src='images/".$name."'></div>";
	}
	//upload the image to the target directory if it doesn't exist in the directory
	if($UploadOk == true){
		move_uploaded_file($temp,$UploadFolder."/".$name); // Upload file to server
		array_push($uploadedFiles, $name);
		echo "<div style='float:left;margin:25px'><img id='OriginalImage' class='image' style='width:150px' src='images/".$name."'></div>";
	}
}

//display message if successfully uploaded the file(s) or failed to upload or no file is selected
function displayResult(&$errors, &$uploadedFiles, &$counter){
	$count = 0;
	if($counter>0){
		echo "<div style='clear:left;margin:25px'>";
		if(count($errors)>0)
		{
			echo "<span style='color:red;font-style:italic'><b>Errors:</b>";
			echo "<br/><ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
				echo "</ul></span>";
		}
		else{
			echo "<b>Uploaded Files: </b>";
			foreach($uploadedFiles as $fileName)
			{	
				$count++;
				echo $fileName;
				if($count < count($uploadedFiles))
					echo ", ";
			}				
			echo "<br/>".count($uploadedFiles)." file(s) are successfully uploaded.";
		}
		echo "</div>";
	}
	else{
		echo "<span style='color:red;font-style:italic'>Please select file(s) to upload!</span>";
	}
}
?>