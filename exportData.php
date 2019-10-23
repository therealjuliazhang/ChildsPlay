<?php
/*
=======================================
Title:Export Data; 
Author:Phuong Linh Bui (5624095); 
=======================================
*/
//session_start();
include "adminAccess.php";
if(isset($_SESSION["records"])){
	$records = $_SESSION["records"];
	$filename = "results.csv";
	//set headers to download file rather than displayed
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename="' . $filename . '";');
		
	$delimiter = ",";
	//create a file pointer
	$file = fopen("php://output", "w");
	//set column headers
	$fields = array('Activity Style', 'Instruction', 'Image', 'Likert Scale', 'Likert Count', 'Coordinate X', 'Coordinate Y', 'Preferred Mechanics', 'Mechanics Count', 'Other Specified', 'Points Interval', 'Total Scores', 'Comment');
	fputcsv($file, $fields, $delimiter);
	
	foreach($records as $value){
		//output each row of the data, format line as csv and write to file pointer
		$split = explode("/", $value["address"]);
		$image = $split[1];
		$happyValue = isset($value["happy"]) ? $value["happy"] : "";
		$happy = "";
		if($happyValue == "1")
			$happy = "happy";
		else if($happyValue == "0")
			$happy = "sad";
		$likertCount = isset($value["likertCount"]) ? $value["likertCount"] : "";
		$x = isset($value["x"]) ? $value["x"] : "";
		$y = isset($value["y"]) ? $value["y"] : "";
		$mechanic = isset($value["mechanic"]) ? $value["mechanic"] : "";
		$mechanicCount = isset($value["mechanicCount"]) ? $value["mechanicCount"] : "";
		$otherCmt = isset($value["otherComment"]) ? $value["otherComment"] : "";
		$pointsInterval = isset($value["pointsInterval"]) ? $value["pointsInterval"] : "";
		$score = isset($value["totalScore"]) ? $value["totalScore"] : "";
		$lineData = array($value["activityStyle"], $value["instruction"], $image, $happy, $likertCount, $x, $y, $mechanic, $mechanicCount, $otherCmt, $pointsInterval, $score, $value["comments"]);
		fputcsv($file, $lineData, $delimiter);
	}	
	//output all remaining data on a file pointer
	fpassthru($file);
	exit;
}
unset($_SESSION["records"]);
?>