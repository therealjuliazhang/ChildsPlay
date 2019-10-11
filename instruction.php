<!--
Title:Instruction;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527);
-->
<html>
<?php
session_start();
if(isset($_SESSION["userID"]))
$userID = $_SESSION["userID"];
else
header("Location: login.php");
include 'db_connection.php';
$conn = OpenCon();
if(isset($_SESSION["tasks"])){
	$tasks = $_SESSION["tasks"];
}
else{
	$tasks = array();
}
$from="";
if(isset($_GET["from"])){
	$from = $_GET["from"];
	$_SESSION["from"] = $from;
}
else if(isset($_SESSION["from"]))
$from = $_SESSION["from"];

//find out if it's from edit or create test page to display the appropriate Add button in FilterExistingTasks page
if(isset($_GET["edit"]))
$_SESSION["edit"] = "edit";
else if(isset($_GET["create"]))
$_SESSION["create"] = "create";

if(isset($_GET["testID"])){
	$testID = $_GET["testID"];
	$_SESSION["testID"] = $testID;
}
else if(isset($_SESSION["testID"]))
$testID = $_SESSION["testID"];
else
$testID = 0;

if(isset($_SESSION["groupID"]))
$groupID = $_SESSION["groupID"];

$taskID = isset($_GET["taskID"]) ? $_GET["taskID"]: 0;
$_SESSION["taskID"] = $taskID;

//check the mode if it's passed in the URL
if(isset($_GET["mode"])){
	$mode = $_GET["mode"];
}
//check the mode if it's in session
else if(isset($_SESSION["mode"])){
	$mode = $_SESSION["mode"];
}

//if the task is in preview mode
if($mode == "preview"){
	$tasks = getTasks($conn, $testID, $taskID);
	$groupID = 4;  //group with group ID: 4 is the preview group
	$_SESSION['groupID'] = $groupID;
	$_SESSION["mode"] = "preview";
}
//if task is in start mode
else{
	if(isset($_GET["groupID"])){ //should be true if it is the first task of test
		$groupID = $_GET["groupID"];
		$_SESSION['groupID'] = $groupID;
		$tasks = getTasks($conn, $testID, $taskID);
	}
}



//get tasks and set to session
function getTasks($conn, $testID, $taskID){
	$tasksArray = array();
	if($testID != 0 && $taskID == 0){
		$query = "SELECT taskID FROM TASKASSIGNMENT WHERE testID=".$testID;
		$result = $conn->query($query);
		while($value = mysqli_fetch_assoc($result)){
			$taskQuery = "SELECT * FROM TASK WHERE taskID=".$value["taskID"];
			$result2 = $conn->query($taskQuery);
			while($row = mysqli_fetch_assoc($result2))
			$tasksArray[] = $row;
		}
		if(count($tasksArray) > 0)
		$taskID = $tasksArray[0]["taskID"];
	}
	else if ($taskID != 0){
		$taskQuery = "SELECT * FROM TASK WHERE taskID=".$taskID;
		$result2 = $conn->query($taskQuery);
		while($row = mysqli_fetch_assoc($result2))
		$tasksArray[] = $row;
	}
	$_SESSION["tasks"] = $tasksArray;
	return $tasksArray;
}
$taskIndex = isset($_GET['taskIndex']) ? $_GET['taskIndex'] : 0;
$bodyPart = "eye";
?>
<head>
	<title>Instructions</title>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
</head>
<body>
	<!--header-->
	<div id="InsertHeader"></div>
	<script>
	//Read header
	$(function(){
		$("#InsertHeader").load("testingHeader.html");
	});
	</script>
	<!--end header-->
	<!-- body content -->
	<div class="container">
		<div class="row">
			<div class="col s12">
				<div style="font-size:18px">
					<?php
					//Display instructions for task
					$taskTypeUrl;
					if(count($tasks) == 0){
						echo "Array has no element";
					}
					if(count($tasks) > 0){
						switch($tasks[$taskIndex]["activityStyle"]){
							case "Likert Scale":
							echo "<h4 class='blue-text text-darken-2'>Likert Scale</h4><br>";
							echo "<h5 class='blue-text text-darken-2'>Task Instructions:</h5>";
							echo $tasks[$taskIndex]['instruction'] .
							"</br>
							<img src=\"images/happy.png\" width=\"75px\"><img src=\"images/sad.png\" width=\"75px\">
							</br>";
							$taskTypeUrl = "likertScaleTask.php?taskIndex=" . $taskIndex."&from=".$from;
							echo "After the participant has completed their task, select the grey, quarter-circle button on the top right
							of the screen to go to the next participant's turn.
							</br>
							<img src='images/greyCircle.png' width='60px'>
							";
							break;
							case "Identify Body Parts":
								echo "<h4 class='blue-text text-darken-2'>Identify Body Parts</h4><br>";
								echo "<h5 class='blue-text text-darken-2'>Task Instructions:</h5>";
								echo $tasks[$taskIndex]['instruction'];
								$taskTypeUrl = "identifyBodyPartsTask.php?taskIndex=" . $taskIndex."&from=".$from;
								echo "</br></br>After the participant has completed their task, select the grey, quarter-circle button on the top right
								of the screen to go to the next participant's turn.
								</br>
								<img src='images/greyCircle.png' width='60px'>
								";
								break;
								case "Character Ranking":
								echo "<h4 class='blue-text text-darken-2'>Character Ranking</h4><br>";
								echo "<h5 class='blue-text text-darken-2'>Task Instructions:</h5>";
								echo $tasks[$taskIndex]['instruction'];
								$taskTypeUrl = "characterRankingTask.php?taskIndex=" . $taskIndex."&from=".$from;
								echo "</br></br>After the participant has completed their task, select the grey, quarter-circle button on the top right
								of the screen to go to the next participant's turn.
								</br>
								<img src='images/greyCircle.png' width='60px'>
								";
								break;
								case "Preferred Mechanics":
								echo "<h4 class='blue-text text-darken-2'>Preferred Mechanics</h4><br>";
								echo "<h5 class='blue-text text-darken-2'>Task Instructions:</h5>";
								echo $tasks[$taskIndex]['instruction'];
								$taskTypeUrl = "preferredMechanicsTask.php?taskIndex=" . $taskIndex."&from=".$from;
								echo "</br></br>After the participant has completed their task, click the next button to go to the next participant's turn.	</br>";

								break;
							}
						}
						?>

					</div>
					<h5 class="blue-text darken-2">Images Under Test:</h5>
					<?php
					//display images under test
					if(count($tasks) > 0){
						$testQuery = "SELECT address FROM IMAGE I JOIN IMAGEASSIGNMENT IA ON I.imageID = IA.imageID WHERE IA.taskID=" . $tasks[$taskIndex]["taskID"];
						$result = $conn->query($testQuery);
						$imageAdresses = array();
						while($row = mysqli_fetch_assoc($result))
						$imageAdresses[] = $row;
						foreach ($imageAdresses as $value)
						echo '<img src=' . $value['address'] . ' width="100px">';
					}
					//CloseCon($conn);
					?>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="right-align">
						<a href= <?php echo $taskTypeUrl; ?> class="waves-effect waves-light btn blue darken-4">
							<?php
							if($mode == "preview"){
								echo "Start Preview";
							}
							else if ($mode == "start")
							echo "Start";
							?>
						</a>
						<!-- <a href="?back=true" class="waves-effect waves-light btn blue darken-4">Back</a> -->
						<?php
						if(isset($_GET["back"])){
							if($_SESSION['mode'] == "preview")
							header("Location: educatorTests.php");
							else
							header("Location: selectGroupForTask.php");
						}
						?>
					</div>
				</div>
			</div>
		</div>
		<!--end body content-->
	</body>
	<script>
	function goBack(){
		var taskIndex = <?php echo $taskIndex ?>;
		var testID = <?php echo $testID ?>;
		var groupID = <?php echo $groupID ?>;
		if(taskIndex == 0)
		//if preview (group is preview group), go back to educator tests page
		if(groupID == 4)
		window.location.href = "educatorTests.php";
		else
		window.location.href = "selectGroupForTask.php?testID=" + testID;
		else{
			taskIndex = <?php echo --$taskIndex; ?>;
			window.location.href = "comments.php?testID=" + testID + "&groupID=" + groupID + "&taskIndex=" + taskIndex;
		}
	}
	</script>
	<style>
	.brand-logo{
		margin-top:-67px;
	}
	.logout{
		margin-top: 15px;
		margin-right:15px;
	}
	</style>
	</html>
