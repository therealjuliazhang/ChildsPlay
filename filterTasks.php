<?php
/*
 Author: Phuong Linh Bui (5624095)
*/
//session_start();
if(isset($_SESSION["from"]))
	$from = $_SESSION["from"];

include 'db_connection.php';
$conn = OpenCon();

$query = "SELECT T.*, TEST.testID, MIN(TEST.dateCreated) AS date FROM TASK T JOIN TASKASSIGNMENT TA ON T.taskID = TA.taskID JOIN TEST ON TEST.testID = TA.testID";

if(isset($_POST["submitFilter"])){
	//get selected start date
	if(isset($_POST["startDate"])){
		$sDate = $_POST["startDate"];
		//format the date to make it compatible to the one sql
		$startDate = "'".date('Y-m-d', strtotime($sDate))."'";
	}
	//get selected end date
	if(isset($_POST["endDate"])){
		$eDate = $_POST["endDate"];
		$endDate = "'".date('Y-m-d', strtotime($eDate))."'";
	}
	//get selected activity style
	if(isset($_POST["activityStyle"])){
		$activityStyle = "'".$_POST["activityStyle"]."'";
	}

	$subqueryDate = "";

	if($startDate != ""){
		$subqueryDate .= " WHERE dateCreated >= $startDate";
	}
	else if ($endDate != "")
		$subqueryDate .= " WHERE dateCreated <= $endDate";
	else if ($startDate != "" && $endDate != "")
		$subqueryDate .= " WHERE dateCreated BETWEEN $startDate AND $endDate";

	$query .= $subqueryDate;

	if($activityStyle != ""){
		$connector = "";
		if (strpos($query, 'WHERE') !== false)
			$connector = " AND";
		else
			$connector = "WHERE";
		$query .= $connector." activityStyle=$activityStyle";
	}
}

$query .= " GROUP BY TA.taskID";
$result = $conn->query($query);
if(mysqli_num_rows($result) == 0)
	echo "<span style='color:red;font-style:italic'>No results found!</span><br/>";
else{
	while($row = mysqli_fetch_assoc($result)){
		//fomart the date
		$formattedCreateDate = date("d/m/Y", strtotime($row["date"])); //j F Y for the following date format: 15 January 2019
		echo "<tr><td style='width:8%' class='taskIdCol'>".$row["taskID"]."</td>".
		"<td style='width:28%' class='indtructionCol'>".$row["instruction"]."</td>".
		"<td style='width:16%' class='activityStyleCol' >".$row["activityStyle"]."</td>".
		"<td style='width:9%' class='dateCreatedCol'>".$formattedCreateDate."</td>".
		"<td style='width:10%' class='previewCol'><a class='waves-effect waves-light btn blue darken-2' href='instruction.php?taskID=".$row["taskID"]."&mode=preview&from=existingTasks'>Preview</a></td>".
		"<td style='width:7%' class='editCol'><a class='waves-effect waves-light btn blue darken-4' href='CreateNewTaskInCreateTest.php?exist=true&taskID=".$row["taskID"]."'>Edit</a></td>";
		if ($from == "create")
			echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='createTest.php?taskID=".$row["taskID"]."'>Add</a></td>";
		else if ($from == "edit")
			echo "<td style='width:7%' class='addCol'><a class='waves-effect waves-light btn blue darken-4' href='editTest.php?taskID=".$row["taskID"]."&testID=".$_SESSION["testID"]."'>Add</a></td>";
	}
}
?>
