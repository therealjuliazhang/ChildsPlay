<html>
<?php
$testID = $_GET["testID"];
$groupID = $_GET["groupID"];
//index of task in array
$taskIndex = isset($_GET['taskIndex']) ? $_GET['taskIndex'] : 0;
$bodyPart = "eye";
?>
    <head>
        <title>Likert Scale Instructions</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
        <div class="row">
        <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
				<div class="row">
					<div class="col s10">
						<a href="#" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
					</div>
					<div class="col s2 offset-s10">
						<a class="waves-effect waves-light btn blue darken-2 right logout" onclick="logout()">Logout</a>
					</div>
				</div>
            </div>
        </nav>
        </div>
        <!--end header-->
        
        <!-- body content -->
        <div class="container grey-text text-darken-1">
			<div class="row">
				<div class="col s12">
					<h5 class="blue-text darken-2">Task Instructions:</h5>
					<div style="font-size:18px">
<?php
//Display instructions for task
include 'db_connection.php';
$conn = OpenCon();
$taskTypeUrl;
$testQuery = "SELECT * FROM TASK WHERE testID=" . $testID;
$result = $conn->query($testQuery);
$tasks = array();
while($row = mysqli_fetch_assoc($result))
	$tasks[] = $row;
$info = "testID=" . $testID . "&groupID=" . $groupID . "&taskIndex=" . $taskIndex;
switch($tasks[$taskIndex]["taskType"]){
	case "Likert Scale":
		echo $tasks[$taskIndex]['instruction'] . 
		"</br>
			<img src=\"images/happy.jpg\" width=\"75px\"><img src=\"images/sad.jpg\" width=\"75px\">
		</br>"; 
		$taskTypeUrl = "likertScaleTask.php?" . $info;
		break;
	case "Identify Body Parts":
		echo $tasks[$taskIndex]['instruction']; 
		$taskTypeUrl = "identifyBodyPartsTask.php?" . $info;
		break;
	case "Character Ranking":
		echo $tasks[$taskIndex]['instruction'];  
		$taskTypeUrl = "characterRankingTask.php?" . $info;
		break;
	case "Drag and Drop":
		echo $tasks[$taskIndex]['instruction']; 
		$taskTypeUrl = "dragAndDropTask.php?" . $info;
		break;
}
CloseCon($conn);
?> 
						After the participant has completed their task, select the grey, quarter-circle button on the top right 
						of the screen to go to the next participant's turn.
						</br>
						<img src="images/greyCircle.png" width="60px">
					</div>
					<h5 class="blue-text darken-2">Images Under Test:</h5>
<?php
//display images under test
$conn = OpenCon();
$testQuery = "SELECT address FROM IMAGE WHERE taskID=" . $tasks[$taskIndex]["taskID"];
$result = $conn->query($testQuery);
$imageAdresses = array();
while($row = mysqli_fetch_assoc($result))
	$imageAdresses[] = $row;
foreach ($imageAdresses as $value) 
  echo '<img src=' . $value['address'] . ' width="100px">';
?>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="right-align">
						<a href= <?php echo $taskTypeUrl; ?> class="waves-effect waves-light btn blue darken-2">Start</a>
						<a onclick="goBack()" class="waves-effect waves-light btn blue darken-4">Back</a>
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
