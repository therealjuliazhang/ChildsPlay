<?php
/*
	Author: Phuong Linh Bui (5624095)
*/
//connect to database
include 'db_connection.php';
$conn = OpenCon();
$filteredPreIDs = array();
$isGroupResults = true;
//likert result query
$query1 = "SELECT DISTINCT happy, count(happy) AS likertCount, R.taskID, T.instruction, I.imageID, address, comments, orderInTest, R.testID  
		FROM RESULTS R INNER JOIN IMAGEASSIGNMENT IA ON R.taskID = IA.taskID INNER JOIN IMAGE I ON IA.imageID = I.imageID INNER JOIN TASK T ON R.taskID = T.taskID INNER JOIN TASKASSIGNMENT TA ON TA.taskID = T.taskID
		WHERE happy IS NOT NULL"; 
//body parts result query				
$query2 = "SELECT R.taskID, I.imageID, address, x, y, T.instruction, comments, orderInTest, R.testID  
		FROM RESULTS R INNER JOIN IMAGEASSIGNMENT IA ON R.taskID = IA.taskID INNER JOIN IMAGE I ON IA.imageID = I.imageID INNER JOIN TASK T ON R.taskID = T.taskID INNER JOIN TASKASSIGNMENT TA ON TA.taskID = T.taskID
		WHERE x IS NOT NULL";
//mechanic result query
$query3 = "SELECT DISTINCT mechanic, count(mechanic) AS mechanicCount, T.instruction, R.taskID, I.imageID, address, comments, orderInTest, R.testID  
		FROM RESULTS R INNER JOIN IMAGEASSIGNMENT IA ON R.taskID = IA.taskID INNER JOIN IMAGE I ON IA.imageID = I.imageID INNER JOIN TASK T ON R.taskID = T.taskID INNER JOIN TASKASSIGNMENT TA ON TA.taskID = T.taskID
		WHERE mechanic IS NOT NULL";
//character ranking result query		
$query4 = "SELECT R.imageID, address, sum(score) AS totalScore, R.taskID, R.preID, T.instruction, comments, orderInTest, R.testID  
		FROM RANKING R INNER JOIN IMAGE I ON R.imageID = I.imageID INNER JOIN TASK T ON R.taskID = T.taskID INNER JOIN TASKASSIGNMENT TA ON TA.taskID = T.taskID";		

$testFilter = "";
//get the selected testID from the list
if(isset($_SESSION["testID"])){	
	$testID = $_SESSION["testID"];
	$testFilter = "R.testID=".$testID;
	$query1 .= " AND ".$testFilter;
	$query2 .= " AND ".$testFilter;
	$query3 .= " AND ".$testFilter;
	$query4 .= " WHERE ".$testFilter;
}		
//if(isset($_POST["submitGroup"])){
	$locationQuery = "SELECT groupID FROM GROUPTEST";
	$groupList = array();
	//check if any location option is selected
	if(isset($_POST["location"])){
		$i = 0;
		$countIDs = count($_POST["location"]);
		$selected = "";
		while($i < $countIDs){
			$selected .= $_POST["location"][$i];
			if($i < $countIDs - 1){
				$selected .= ",";
			}
			$i++;
		}
		$locationQuery .= " WHERE locationID IN (".$selected.")";
	}
	$locationResult = $conn->query($locationQuery);
	while ($row = mysqli_fetch_assoc($locationResult)){
		$groupList[] = $row["groupID"]; //get a list of groupIDs from selected locations
	}
	$groupQuery = "SELECT preID FROM GROUPASSIGNMENT";
	$subQuery = "";
	$selectedGroups = array();
	//check if any group option is selected
	$selected = "";
	if(isset($_POST["group"])){
		$i = 0;
		$countIDs = count($_POST["group"]);
		while($i < $countIDs){
			$selected .= $_POST["group"][$i];
			if($i < $countIDs - 1){
				$selected .= ",";
			}
			array_push($selectedGroups, $_POST["group"][$i]);
			$i++;
		}
	}
	//get common groupID from selected locations and selected groups
	$groupIntersection = array();
	$preList1 = array();
	if(count($groupList) > 0){
		if(count($selectedGroups) > 0){// && count($groupList) > 0){ //check if any group is selected
			$groupIntersection = (array_intersect($selectedGroups, $groupList));
			if(count($groupIntersection) > 0){
				$ids = join(",",$groupIntersection);
				$subQuery = " WHERE groupID IN (".$ids.")";
			}
		}
		else if(count($selectedGroups) == 0){// && count($groupList) > 0){ //no group is selected
			$ids = join(",",$groupList);
			$subQuery = " WHERE groupID IN (".$ids.")"; //get list of groupIDs from selected locations
		}
		$groupQuery .= $subQuery;
		$groupResult = $conn->query($groupQuery);
		//$preList1 = array();
		while($row = mysqli_fetch_assoc($groupResult)){
			$preList1[] = $row["preID"];
		}
	}
	
	$genderQuery = "SELECT preID FROM PRESCHOOLER";
	//check if any gender option is selected
	if(isset($_POST["gender"])){
		$i = 0;
		$countIDs = count($_POST["gender"]);
		$selected = "'";
		while($i < $countIDs){
			$selected .= $_POST["gender"][$i]."'";
			if($i < $countIDs - 1){
				$selected .= ",";
			}
			$i++;
		}
		$genderQuery .= " WHERE gender IN (".$selected.")";
	}
	$genderResult = $conn->query($genderQuery);
	$preList2 = array();
	while($row = mysqli_fetch_assoc($genderResult)){
		$preList2[] = $row["preID"];
	}
	
	$ageQuery = "SELECT preID FROM PRESCHOOLER";
	//check if any age option is selected
	if(isset($_POST["age"])){
		$i = 0;
		$countIDs = count($_POST["age"]);
		$selected = "";
		while($i < $countIDs){
			$selected .= $_POST["age"][$i];
			echo "Select age: ".$selected;
			if($i < $countIDs - 1){
				$selected .= ",";
			}
			$i++;
		}
		$ageQuery .= " WHERE age IN (".$selected.")";
	}
	$ageResult = $conn->query($ageQuery);
	$preList3 = array();
	while($row = mysqli_fetch_assoc($ageResult)){
		$preList3[] = $row["preID"];
	}
	
	//check if any preschooler's name is selected
	if(isset($_POST["name"])){
		$idList = array();
		$i = 0;
		$countIDs = count($_POST["name"]);
		$selected = "";
		while($i < $countIDs){
			$selected .= $_POST["name"][$i];
			array_push($idList, $selected);
			$i++;
		}
		$filteredPreIDs = $idList;
	}
	else
		$filteredPreIDs = array_intersect($preList1, $preList2, $preList3);
	//foreach ($filteredPreIDs as $id)
		//echo "Array: ".$id;
	if(count($filteredPreIDs) > 0){
		if(count($filteredPreIDs) > 1){
			$preIDsForQuery = join("','",$filteredPreIDs);
		}
		else
			$preIDsForQuery = $filteredPreIDs[0];
		$filter = "preID IN ('$preIDsForQuery')";
		
		
		$query1 .= " AND ".$filter;
		$query2 .= " AND ".$filter;
		$query3 .= " AND ".$filter;
		if($testFilter != "")
			$query4 .= " AND ".$filter;
		else
			$query4 .= " WHERE ".$filter;
	}
//}

$query1 .= " GROUP BY happy, R.taskID";
$query3 .= " GROUP BY mechanic, R.taskID";
$query4 .= " GROUP BY imageID ORDER BY totalScore DESC";

//array for all results
$results = array();

if(!(count($filteredPreIDs) == 0)){
	// get results for likert scale
	$result1 = $conn->query($query1);
	while($row1 = mysqli_fetch_assoc($result1))
		array_push($results, $row1);
	// get results for identify body parts
	$result2 = $conn->query($query2);
	while($row2 = mysqli_fetch_assoc($result2))
		array_push($results, $row2);	
	// get results for preferred mechanics
	$result3 = $conn->query($query3);
	while($row3 = mysqli_fetch_assoc($result3))
		array_push($results, $row3);
	// get results for character ranking
	$result4 = $conn->query($query4);
	while($row4 = mysqli_fetch_assoc($result4))
		array_push($results, $row4);		
}
	//unset($_SESSION["testID"]);
?>

