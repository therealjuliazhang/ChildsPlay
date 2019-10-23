<!--
=======================================
Title:Identify Body Parts Task; 
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren
Sugie(5679527); 
=======================================
-->
<html>
<?php
session_start();
if (isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];
else
	header("Location: login.php");

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

//the group used for previewing tests
$previewGroupID = 4;
$isPreview = false;
//task id in GET is set if task is being previewed
$from = "";
if (isset($_GET['from']))
	$from = $_GET['from'];

if ($mode == "preview") {
	$isPreview = true;
	$groupID = $previewGroupID;
	if (isset($_GET['taskID']))
		$taskID = $_GET['taskID'];
	else
		$taskID = $tasks[$taskIndex]['taskID'];
} else { //else if not preview
	$isPreview = false;
	//get group ID
	if (isset($_SESSION['groupID']))
		$groupID = $_SESSION['groupID'];
	$taskID = $tasks[$taskIndex]['taskID'];
}
$_SESSION["taskID"] = $taskID;
header('Access-Control-Allow-Origin: *');
include 'db_connection.php';
$conn = OpenCon();
//fetch names of preschoolers
// if($mode=="preview")
// $sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$groupID;
// else
// $sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$groupID." AND userID=".$userID;
$sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=" . $groupID;
$result = $conn->query($sql);
$preschoolers = array();
while ($row = mysqli_fetch_assoc($result)) {
	$sql2 = "SELECT * FROM PRESCHOOLER WHERE preID=" . $row["preID"];
	$result2 = $conn->query($sql2);
	while ($value = mysqli_fetch_assoc($result2)) {
		$preschoolers[] = $value;
	}
}
//fetch images
$sql = "SELECT I.imageID, I.address, IA.taskID FROM IMAGE I JOIN IMAGEASSIGNMENT IA ON I.imageID = IA.imageID WHERE taskID = $taskID";
$result = $conn->query($sql);
$images = array();
while ($row = mysqli_fetch_assoc($result))
	$images[] = $row;
CloseCon($conn);
?>

<head>
	<title>Identify Body Parts Task</title>
	<!--links for Materialize-->
	<meta name="viewport" content="width = device-width, initial-scale = 1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script>
		var clicked = false;
		//check whether it is in preview mode
		var isPreview = <?php echo (json_encode($isPreview)); ?>;
		var from; //if preview check if from edit page or available test page ect.
		if (isPreview)
			from = <?php echo (json_encode($from)); ?>; // checks from which page preview was opened
		var taskIndex = <?php echo (json_encode($taskIndex)); ?>;
		var testID = <?php echo (json_encode($testID)); ?>;
		var taskID = <?php echo (json_encode($taskID)); ?>;
		//canX is canvas x coordinate, canY is y coordinate
		var canvas, ctx, canX, canY = 0;
		var opacity = 1;
		var images = <?php echo (json_encode($images)); ?>;
		//imageIndex determines which image in array is being tested
		var imageIndex = 0;
		//gets preschoolers array from php
		var preschoolers = <?php echo (json_encode($preschoolers)); ?>;
		//preschoolerIndex determines whos turn it is
		var preschoolerIndex = 0;
		//colour of backround of preschoolers names at bottom
		var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
		//creates canvas and displays preschoolers name
		window.onload = function() {
			canvas = document.getElementById("myCanvas");
			ctx = canvas.getContext("2d");
			displayCharacter(imageIndex);
			canvas.addEventListener("mousedown", mouseDown, false);
			canvas.addEventListener("touchstart", touchDown, false);
			document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
			document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
		}

		function mouseDown(e) {
			clicked = true;
			if (!e)
				var e = event;
			canX = e.pageX - canvas.offsetLeft;
			canY = e.pageY - canvas.offsetTop;
			opacity = 1;
			window.requestAnimationFrame(draw);
			//change coordinates to percentage of image width/height
			var x = canX / canvas.width;
			var y = canY / canvas.height;
			//send results to php file only in start mode
			if (!isPreview) {
				$.ajax({
					type: 'POST',
					url: 'insertBodyPartsResults.php',
					data: {
						testID: testID,
						x: x,
						y: y,
						taskID: taskID,
						preID: preschoolers[preschoolerIndex]['preID']
					}
				});
			}
		}

		function touchDown(e) {
			clicked = true;
			if (!e)
				var e = event;
			e.preventDefault();
			canX = e.targetTouches[0].pageX - canvas.offsetLeft;
			canY = e.targetTouches[0].pageY - canvas.offsetTop;
			opacity = 1;
			window.requestAnimationFrame(draw);
			//change coordinates to percentage of image width/height
			var x = canX / canvas.width;
			var y = canY / canvas.height;
			//send results to php file only in start mode
			if (!isPreview) {
				$.ajax({
					type: 'POST',
					url: 'insertBodyPartsResults.php',
					data: {
						testID: testID,
						x: x,
						y: y,
						taskID: taskID,
						preID: preschoolers[preschoolerIndex]['preID']
					}
				});
			}
		}
		//draws circle
		function draw() {
			ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
			ctx.fillStyle = 'rgba(50,50,50, ' + opacity + ')';
			ctx.beginPath();
			ctx.arc(canX, canY, 30, 0, 2 * Math.PI);
			ctx.fill();
			ctx.restore();
			if (opacity > 0) {
				opacity -= 0.01;
				window.requestAnimationFrame(draw);
			} else {
				window.cancelAnimationFrame(draw);
			}
		}
		//Next participant
		function goNext() {
			if (clicked == true || isPreview) {
				preschoolerIndex++;
				if (preschoolerIndex == preschoolers.length) {
					imageIndex++;
					if (imageIndex == images.length) {
						//var groupID = <?php echo $groupID ?>;
						var taskIndex = <?php echo $taskIndex ?>;
						//if task was preview, go back to previous page
						if (isPreview)
							window.location.href = "comments.php?taskIndex=" + taskIndex + "&from=" + from;
						/*if(from == "edit")
						window.location.href = "editTest.php";
					else if(from == "availableTests")
						window.location.href = "viewExistingTests.php";
					else if (from == "existingTasks")
						window.location.href = "filterExistingQuestions.php";
				}*/
						else
							window.location.href = "comments.php?taskIndex=" + taskIndex;
					}
					preschoolerIndex = 0;
					displayCharacter(imageIndex);
				}
				document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerIndex]['name'];
				document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
				clicked = false;
			}
		}

		function displayCharacter(imageIndex) {
			var img = new Image();
			img.src = images[imageIndex]['address'];
			var canvas = document.getElementById("myCanvas");
			context = canvas.getContext('2d');
			img.onload = function() {
				//get ratio of width to height of image
				var ratio = img.width / img.height;
				//set height of canvas so that canvas is to scale
				canvas.width = canvas.height * ratio;
			}
			canvas.style.background = "url(" + images[imageIndex]['address'] + ")";
			canvas.style.backgroundRepeat = 'no-repeat';
			canvas.style.backgroundSize = 'contain';
			canvas.style.backgroundPosition = 'center top';
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

		#myCanvas {
			padding: 0;
			margin: auto;
			display: block;
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

		.center-align {
			margin-top: 15px;
			font-size: 50px;
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
	<img id="button" src="images/greyCircle.png" alt="image not workning" width="7%" onclick="goNext();"></img>

	<canvas id="myCanvas" height="400">
		Your browser does not support the HTML5 canvas tag.
	</canvas>

	<div id="participant" class="row" style="font-size:18px;font-weight:bold">
		<div class="center-align">
			<span id="preschoolerName">
			</span>'s Turn
		</div>
	</div>
	<!--end body content-->
</body>

</html>