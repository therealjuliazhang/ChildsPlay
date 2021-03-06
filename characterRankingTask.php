<!--
==========================================================================================================================================
Title:Character Ranking Task; 
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527); 
==========================================================================================================================================
-->
<html>
<?php
//get information
session_start();
//connect to database
include 'db_connection.php';
$conn = OpenCon();
//get user ID from session
if (isset($_SESSION['userID']))
	$userID = $_SESSION['userID'];
else
	header('Location: login.php');
//the group used for previewing tests
$previewGroupID = 4;
//get mode from session to check if preview mode
if (isset($_SESSION['mode']))
	$mode = $_SESSION['mode'];
else if (isset($_GET["mode"]))
	$mode = $_GET["mode"];
//get testID
if (isset($_SESSION['testID']))
	$testID = $_SESSION['testID'];
if (isset($_SESSION['tasks']))
	$tasks = $_SESSION['tasks'];
//get task index from url
if (isset($_GET['taskIndex']))
	$taskIndex = $_GET['taskIndex'];
$from = "";
if (isset($_GET['from']))
	$from = $_GET['from'];
if ($mode == "preview") { //mode is set to preview if a test is being previewed
	$groupID = $previewGroupID;
	$isTaskPreview = true;
	if (isset($_GET['taskID']))
		$taskID = $_GET['taskID'];
	else
		$taskID = $tasks[$taskIndex]['taskID'];
	//set points interval to 5 if preview mode
	$pointsInterval = 5;
} else { //else if not preview
	$isTaskPreview = false;
	//get group ID
	if (isset($_SESSION['groupID']))
		$groupID = $_SESSION['groupID'];
	$taskID = $tasks[$taskIndex]['taskID'];
	//get points interval from task assignment table
	$sql = "SELECT pointsInterval FROM TASKASSIGNMENT WHERE taskID=" . $taskID;
	$result = $conn->query($sql);
	$pointsInterval = mysqli_fetch_assoc($result)['pointsInterval'];
}
$_SESSION["taskID"] = $taskID;
//fetch preschoolers from database
// if ($mode == "preview")
	// $sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=" . $groupID;
// else
	// $sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=" . $groupID . " AND userID=" . $userID;
$sql = $conn->prepare("SELECT preID FROM GROUPASSIGNMENT WHERE groupID=?");
$sql->bind_param("i", $groupID);
$sql->execute();
$result = $sql->get_result();
$preschoolers = array();
while ($row = $result->fetch_assoc()) {
	$sql2 = "SELECT * FROM PRESCHOOLER WHERE preID=" . $row["preID"];
	$result2 = $conn->query($sql2);
	while ($value = mysqli_fetch_assoc($result2)) {
		$preschoolers[] = $value;
	}
}
$sql->close();
//fetch images
$query = $conn->prepare("SELECT I.imageID, I.address, IA.taskID FROM IMAGE I JOIN IMAGEASSIGNMENT IA ON I.imageID = IA.imageID WHERE taskID = ?");
$query->bind_param("i", $taskID);
$query->execute();
$result = $query->get_result();
//$sql = "SELECT I.imageID, I.address, IA.taskID FROM IMAGE I JOIN IMAGEASSIGNMENT IA ON I.imageID = IA.imageID WHERE taskID = $taskID";
//$result = $conn->query($sql);
$images = array();
while ($row = $result->fetch_assoc())
	$images[] = $row;
$query->close();
CloseCon($conn);
?>

<head>
	<title>Character Ranking Task</title>
	<!--links for Materialize-->
	<meta name="viewport" content="width = device-width, initial-scale = 1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script>
		clicked = false;
		//check whether task/test is being preview
		var isTaskPreview = <?php echo (json_encode($isTaskPreview)); ?>;
		var from; //if preview check if from edit page or available test page ect.
		if (isTaskPreview)
			from = <?php echo (json_encode($from)); ?>; // checks from which page preview was opened
		//get task ID and test ID
		var taskID = <?php echo (json_encode($taskID)); ?>;
		var testID = <?php echo (json_encode($testID)); ?>;
		//get points interval for setting points
		var pointsInterval = <?php echo (json_encode($pointsInterval)); ?>;
		//preschoolerNumber determines whos turn it is
		var preschoolerNumber = 0;
		//gets preschoolers array from php
		var preschoolers = <?php echo (json_encode($preschoolers)); ?>;
		//colour of backround of preschoolers names at bottom
		var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
		//characters being tested
		var images = <?php echo (json_encode($images)); ?>;
		//amount of points to give to first character chosen
		var pointsToGive = images.length * pointsInterval;
		//array for storing scores and ranking results
		var results = [];
		//creates canvas and displays preschoolers name
		window.onload = function() {
			displayCharacters();
			document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
			document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length];
		}
		//go to next participant
		function goNext() {
			let equalFirsts = false;
			if (clicked == true || isTaskPreview) {
				preschoolerNumber++;
				if (preschoolerNumber == preschoolers.length) {
					//check if there is an equal first place ranking
					equalFirsts = getEqualFirsts(results);
					if(equalFirsts != false)
						preschoolerNumber = 0;
					else{
						var taskIndex = <?php echo $taskIndex ?>;
						if (isTaskPreview)
							window.location.href = "comments.php?taskIndex=" + taskIndex + "&from=" + from;
						else
							window.location.href = "comments.php?taskIndex=" + taskIndex;
					}
				}
			}
			//change name to next preschooler
			document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerNumber]['name'];
			document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length];
			const characters = document.getElementsByClassName("character");
			//if equalFirsts, display only those characters that came first
			if(equalFirsts != false){
				for (let i = 0; i < characters.length; i++) {
					//remove character if not in equalFirsts
					if(!equalFirsts.includes(characters[i].getAttribute("imageid"))){
						characters[i].remove();
						i--;
					}
				}
			}
			//reset characters to not chosen state
			for (let i = 0; i < characters.length; i++) {
				characters[i].classList.remove("chosen");
				characters[i].setAttribute("points", 0);
			}
			pointsToGive = characters.length * pointsInterval;
			clicked = false;
		}
		function displayCharacters() {
			var width = 170;
			for (var i = 0; i < images.length; i++) {
				var div = document.createElement("div");
				var img = document.createElement("img");
				img.src = images[i]['address'];
				img.style.height = '200px';
				div.style.left = width * i + "px";
				div.className = 'character';
				div.setAttribute('points', 0);
				div.setAttribute('imageID', images[i]['imageID']);
				div.appendChild(img);
				div.onclick = function() {
					clicked = true;
					this.setAttribute('points', parseInt(this.getAttribute("points")) + pointsToGive);
					pointsToGive -= pointsInterval;
					this.classList.add("chosen");
					//only save results if task is in start mode
					if (!isTaskPreview) {
						//send results to php file
						$.ajax({
							type: 'POST',
							url: 'insertCharacterRankingResults.php',
							data: {
								imageID: this.getAttribute("imageID"),
								score: this.getAttribute("points"),
								testID: testID,
								taskID: taskID,
								preID: preschoolers[preschoolerNumber]['preID']
							},
						});
						//save results in array
						var data = {
								imageID: this.getAttribute("imageID"),
								score: this.getAttribute("points"),
								testID: testID,
								taskID: taskID,
								preID: preschoolers[preschoolerNumber]['preID']
							}
						results.push(data);
					}
				};
				div.onTouchStart = function() {
					clicked = true;
					this.setAttribute('points', parseInt(this.getAttribute("points")) + pointsToGive);
					pointsToGive -= pointsInterval;
					this.classList.add("chosen");
					//only save results if task is in start mode
					if (!isTaskPreview) {
						//send results to php file
						$.ajax({
							type: 'POST',
							url: 'insertCharacterRankingResults.php',
							data: {
								imageID: this.getAttribute("imageID"),
								score: this.getAttribute("points"),
								testID: testID,
								taskID: taskID,
								preID: preschoolers[preschoolerNumber]['preID']
							},
						});
						//save results in array
						var data = {
								imageID: this.getAttribute("imageID"),
								score: this.getAttribute("points"),
								testID: testID,
								taskID: taskID,
								preID: preschoolers[preschoolerNumber]['preID']
							}
						results.push(data);
					}
				};
				document.getElementById("characters").appendChild(div);
			}
		}
		//checks if there are equal firsts rankings and returns those images that came first
		function getEqualFirsts(results){
			let imageScores = [];
			//get all the image IDs
			const imageIds = [...new Set(results.map(result => result.imageID))]
			//for each image 
			imageIds.forEach(function(imageID){
				let totalScore = 0;
				//get results for this image
				const imageResults = results.filter(result => {
					return result.imageID === imageID;
				})
				//add up score for this image
				let score = 0;
				for(let i=0; i<imageResults.length; i++){
					score += parseInt(imageResults[i].score);
				}
				imageScores.push({ID: imageID, score: score});
			});
			//get highest scoring image/s
			const highestScore = Math.max.apply(Math, imageScores.map(function(imageScore) { return imageScore.score; }));
			const highestImages = imageScores.filter(result => result.score == highestScore);
			//if more than one ranking first, return their image IDs
			if(highestImages.length > 1){
				const highestImageIds = [...new Set(highestImages.map(result => result.ID))]
				return highestImageIds;
			}
			else return false;
		}
	</script>
	<!--link for font awesome icons-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		.brand-logo {
			margin-top: -67px;
		}

		.logout {
			margin-top: 15px;
			margin-right: 15px;
		}

		#button {
			position: absolute;
			right: 0px;
			margin-top: -20px;
		}

		#participant {
			height: 100px;
			position: absolute;
			bottom: 0px;
			right: 0px;
			left: 0px
		}

		#container {
			text-align: center;
			width: 100%;
			height: 80pt;
		}

		.character {
			margin: 1px;
			width: 18%;
			text-align: left;
			display: inline-block;
		}

		.character.chosen {
			display: none;
		}

		.center-align {
			margin-top: 13px;
			font-size: 50px;
		}

		#characters {
			text-align: center;
			width: 100%;
			height: 80pt;
			padding-top: 125px;
		}
	</style>
</head>
<body>
	<!-- body content -->
	<!--header-->
	<div id="InsertHeader"></div>
	<script>
		//Read header
		$(function() {
			$("#InsertHeader").load("testingHeader.html");
		});
	</script>
	<!--end header-->
	<img id="button" src="images/greyCircle.png" alt="image not workning" width="7%" onclick="goNext();"/>
	<div id="container">
		<div id="characters"> </div>
	</div>
	<div id="participant" class="row" style="font-size:18px;font-weight:bold">
		<div class="center-align">
			<span id="preschoolerName">
			</span>'s Turn
		</div>
	</div>
	<!--end body content-->
</body>
</html>