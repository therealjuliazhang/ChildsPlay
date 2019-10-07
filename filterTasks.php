<?php
/*
 Author: Phuong Linh Bui (5624095)
*/

if (isset($_SESSION["from"]))
	$from = $_SESSION["from"];
if (isset($_GET["from"]))
	$from = $_GET["from"];

$url = "createTest.php?taskID=";
if(isset($_SESSION["createURL"]))
	$url = $_SESSION["createURL"];

if(strpos($url, "?") === false)
	$url .= "?taskID=";
else
	$url .= "&";
	
include 'db_connection.php';
$conn = OpenCon();

$sql = "SELECT * FROM TASK";
//if editing test, get taskIDs in test
if ($from == "edit") {
	$taskIDs = array();
	$query = "SELECT taskID FROM TASKASSIGNMENT WHERE testID = ".$testID;
	$taskIDsResult = $conn->query($query);
	
	//$sql = "SELECT T.*, TEST.testID, MIN(TEST.dateCreated) AS date FROM TASK T JOIN TASKASSIGNMENT TA ON T.taskID = TA.taskID JOIN TEST ON TEST.testID = TA.testID";
	
	if(mysqli_num_rows($taskIDsResult)> 0){
		$sql .= " WHERE taskID NOT IN (";
		//$sql = "SELECT T.*, TEST.testID, MIN(TEST.dateCreated) AS date FROM TASK T JOIN TASKASSIGNMENT TA ON T.taskID = TA.taskID JOIN TEST ON TEST.testID = TA.testID WHERE T.taskID NOT IN (";
		$index = 0;
		while ($row = mysqli_fetch_assoc($taskIDsResult)){
			$sql .= $row["taskID"];
			if($index < mysqli_num_rows($taskIDsResult) - 1)
				$sql .= ",";
			$index++;
		}
		$sql .= ")";
	}
} /*else
	//$sql = "SELECT T.*, TEST.testID, MIN(TEST.dateCreated) AS date FROM TASK T JOIN TASKASSIGNMENT TA ON T.taskID = TA.taskID JOIN TEST ON TEST.testID = TA.testID";
	$sql = "SELECT * FROM TASK";*/
$startDate = "";
$endDate = "";
$activityStyle = "";
if (isset($_POST["submitFilter"])) {
	//get selected start date
	if (isset($_POST["startDate"])) {
		$sDate = $_POST["startDate"];
		//format the date to make it compatible to the one sql
		$startDate = "'" . date('Y-m-d', strtotime($sDate)) . "'";
	}
	//get selected end date
	if (isset($_POST["endDate"])) {
		$eDate = $_POST["endDate"];
		$endDate = "'" . date('Y-m-d', strtotime($eDate)) . "'";
	}
	//get selected activity style
	if (isset($_POST["activityStyle"])) {
		$activityStyle = "'" . $_POST["activityStyle"] . "'";
	}

	$subqueryDate = "";
	
	if (strpos($sql, "WHERE") !== false)
		$connector = " AND";
	else
		$connector = " WHERE";
	if ($sDate != "" && $eDate != "") {
		$subqueryDate .= $connector." dateCreated BETWEEN $startDate AND $endDate";
	} else if ($eDate != "")
		$subqueryDate .= $connector." dateCreated <= $endDate";
	else if ($sDate != "")
		$subqueryDate .= $connector." dateCreated >= $startDate";

	$sql .= $subqueryDate;

	if ($activityStyle != "") {
		$connector = "";
		if (strpos($sql, "WHERE") !== false)
			$connector = " AND";
		else
			$connector = " WHERE";
		$sql .= $connector . " activityStyle=$activityStyle";
	}
}

//$sql .= " GROUP BY TA.taskID";
$result = $conn->query($sql);
if (mysqli_num_rows($result) == 0)
	echo "<span style='color:red;font-style:italic'>No results found!</span><br/>";
else {
	while ($row = mysqli_fetch_assoc($result)) {
		//format the date
		$formattedCreateDate = date("d/m/Y", strtotime($row["dateCreated"])); //j F Y for the following date format: 15 January 2019
		echo "<tr><td style='width:8%' class='taskIdCol'>".$row["taskTitle"]."</td>".
		"<td style='width:28%' class='indtructionCol'>".$row["instruction"]."</td>".
		"<td style='width:16%' class='activityStyleCol' >".$row["activityStyle"]."</td>".
		"<td style='width:9%' class='dateCreatedCol'>".$formattedCreateDate."</td>".
		"<td style='width:10%' class='previewCol'><a class='waves-effect waves-light btn blue darken-2' href='instruction.php?taskID=".$row["taskID"].
		"&mode=preview&from=existingTasks&".$from."'>Preview</a></td>";
		if($from == "create"){
			echo "<td style='width:7%' class='editCol'><a class='waves-effect waves-light btn blue darken-4'".
			" href='createNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."&from=".$from."'>Edit</a></td>";
			echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='" .$url. $row["taskID"] . "'>Add</a></td>";
		}
		/*"<td style='width:7%' class='editCol'><a class='waves-effect waves-light btn blue darken-4'".
		" href='CreateNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."&testID=".$_SESSION["testID"]."&from=".$from."'>Edit</a></td>";
		if ($from == "create")
			echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='createTest.php?taskID=" . $row["taskID"] . "'>Add</a></td>";*/
		else if ($from == "edit"){
			echo "<td style='width:7%' class='editCol'><a class='waves-effect waves-light btn blue darken-4'".
			" href='createNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."&testID=".$_SESSION["testID"]."&from=".$from."'>Edit</a></td>";
			echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='editTest.php?taskID=" . $row["taskID"] . "&testID=" . $_SESSION["testID"] . "'>Add</a></td>";
		}
			//echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='editTest.php?taskID=" . $row["taskID"] . "&testID=" . $_SESSION["testID"] . "'>Add</a></td>";
	}
}
