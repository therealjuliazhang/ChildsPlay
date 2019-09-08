<?php
include 'db_connection.php';
$taskID = 2; //need to select taskID that is just added into database
$UploadFolder = "images";

if(isset($_POST["btnSubmit"])){
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
		$value = uploadImage($temp, $size, $name, $uploadedFiles, $taskID, $errors);
		$_SESSION["names"] = $value;
		displayResult($errors, $uploadedFiles, $counter);
	}
}

if(isset($_POST["multiSubmit"]))
{
	global $uploadedFiles;
	global $errors;
	$values = "";
	
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
		$value = uploadImage($temp, $size, $name, $uploadedFiles, $taskID, $errors);
		$values .= $value;
		if($counter < count($_FILES["files"]["tmp_name"]))
            $values .= ",";
	}
	$_SESSION["names"] = $values;
	displayResult($errors, $uploadedFiles, $counter);
}

if(isset($_POST["createTask"])){
	global $UploadFolder;
	$names = $_SESSION["names"];
	$files = explode(",", $names);
	
	$conn = OpenCon();
	foreach($files as $name)
	{
		if(file_exists($UploadFolder."/".$name) == true){
			//get imageID of the existing image
			$idSql = "SELECT imageID FROM IMAGE WHERE address='".$UploadFolder."/".$name."'";
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
	CloseCon($conn);
}

function uploadImage(&$temp, &$size, &$name, &$uploadedFiles, &$taskID, &$errors){
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
	
	if(file_exists($UploadFolder."/".$name) == true){
		$UploadOk = false;
		array_push($uploadedFiles, $name);
		
		$value .= $name;
		echo "<div style='float:left;margin:25px'><img id='OriginalImage' class='image' style='width:150px' src='images/".$name."'></div>";
	}
	
	if($UploadOk == true){
		move_uploaded_file($temp,$UploadFolder."/".$name); // Upload file to server
		array_push($uploadedFiles, $name);
		
		$value .= $name;
		echo "<div style='float:left;margin:25px'><img id='OriginalImage' class='image' style='width:150px' src='images/".$name."'></div>";
	}
	return $value;
}

//display message if successfully uploaded the file(s) or failed to upload or no file is selected
function displayResult(&$errors, &$uploadedFiles, &$counter){
	$count = 0;
	if($counter>0){
		echo "<br/><div style='clear:left;margin:25px'>";
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