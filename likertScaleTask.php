<html>
	<?php
	header('Access-Control-Allow-Origin: *');
	session_start();
	if(isset($_SESSION["userID"]))
		$userID = $_SESSION["userID"];
	else
		// $userID = 1;
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

	if($mode == "preview"){
		$isPreview = true;
		$groupID = $previewGroupID;
		if (isset($_GET['taskID']))
			$taskID = $_GET['taskID'];
		else
			$taskID = $tasks[$taskIndex]['taskID'];
	}
	else{ //else if not preview
		$isPreview = false;
		//get group ID
		if (isset($_SESSION['groupID']))
			$groupID = $_SESSION['groupID'];
		$taskID = $tasks[$taskIndex]['taskID'];
	}
	$_SESSION["taskID"] = $taskID;

	include 'db_connection.php';
	$conn = OpenCon();
	//fetch images
	$sql = "SELECT I.imageID, I.address, IA.taskID FROM IMAGE I JOIN IMAGEASSIGNMENT IA ON I.imageID = IA.imageID WHERE taskID = $taskID";
	$result = $conn->query($sql);
	$images = array();
	while($row = mysqli_fetch_assoc($result))
	   $images[] = $row;
	//fetch preschoolers
	if($mode=="preview")
		$sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$groupID;
	else
		$sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$groupID." AND userID=".$userID;
	$result = $conn->query($sql);
	$preschoolers = array();
	while($row = mysqli_fetch_assoc($result)){
		$sql2 = "SELECT * FROM PRESCHOOLER WHERE preID=".$row["preID"];
		$result2 = $conn->query($sql2);
		while($value = mysqli_fetch_assoc($result2)){
			$preschoolers[] = $value;
		}
	}
	CloseCon($conn);
	?>
	<head>
		<title>Likert Scale Task</title>
		<!--links for Materialize-->
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<!--link for font awesome icons-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
    <!--header-->
        <div class="row">
            <div class="navbar-fixed">
            <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
            </div>
        </nav>
    </div>
    </div>
    <!--end header-->
        <!-- body content -->
		<img id="button" src="images/greyCircle.png" width="7%" align="right" onclick="goNext();"></img>
		<div class="container">
			<div class="center-align"><img id="image" height="45%"></img></div>
			<!--all container does is create padding on the left & right sides.-->
			</div>
		<div class="bottom">
			<div id="participant" class="row" style="font-size:18px;font-weight:bold">
				<div class="bottomInBottom">
				<div class="col s6 faceCol"><img id="happy" class="right" src="images/happy.png" onclick="happyClicked()" width="150px"></img></div>
				<div class="col s6 faceCol"><img id="sad"  src="images/sad.png" onclick="sadClicked()" width="150px"></img></div>
				<div class="center-align">
                    <div id="nameWrapper" style="font-size:40px;">
					<span id="preschoolerName">
					</span>'s Turn
                    </div>
				</div>
				</div>
			</div>
		</div>
        <!--end body content-->
    </body>
	<script>
	    var faceClicked = false;
		//check whether it is in preview mode
		var isPreview = <?php echo(json_encode($isPreview)); ?>;
		// console.log("Is preview " + isPreview);
		var from; //if preview check if from edit page or available test page ect.
		if(isPreview)
			from = <?php echo(json_encode($from)); ?>; // checks from which page preview was opened

		var taskIndex = <?php echo(json_encode($taskIndex)); ?>;
		var testID = <?php echo(json_encode($testID)); ?>;
		var taskID = <?php echo(json_encode($taskID)); ?>;
		var images = <?php echo(json_encode($images)); ?>;
		var imageURL = images[0]['address'];
		document.getElementById("image").src = imageURL;
		//gets preschoolers array from php
		var preschoolers = <?php echo(json_encode($preschoolers)); ?>;
		//preschoolerIndex determines whos turn it is
		var preschoolerIndex = 0;
		var preID = preschoolers[preschoolerIndex]['preID'];
		//colour of backround of preschoolers names at bottom
		var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
		document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
		function goNext(){
			if(faceClicked == true || isPreview){
				preschoolerIndex++;
				if(preschoolerIndex == preschoolers.length){
					var taskIndex = <?php echo $taskIndex ?>;
					//if task was preview, go back to edit test page
					if(isPreview)
						window.location.href = "comments.php?taskIndex=" + taskIndex + "&from=" + from;
						/*if(from == "edit")
							window.location.href = "editTest.php";
						else if(from == "availableTests")
							window.location.href = "viewExistingTests.php";
						else if (from == "existingTasks")
							window.location.href = "filterExistingQuestions.php";*/
					else
						window.location.href = "comments.php?taskIndex=" + taskIndex;
				}
				preID = preschoolers[preschoolerIndex]['preID'];
				document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerIndex]['name'];
				document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
				document.getElementById("sad").src="images/sad.png";
				document.getElementById("happy").src="images/happy.png";
				faceClicked = false;
			}
		}
		function sadClicked(){
			faceClicked = true;
            document.getElementById("sad").src="images/transparent.png";
			if(!isPreview){
			//insert data only when in start mode
			$.ajax({
				type: 'POST',
				url: 'insertLikertResults.php',
				data: { happy : 0, taskID : taskID, preID : preID, testID: testID}
			});
			}
		}
		function happyClicked(){
			faceClicked = true;
			document.getElementById("happy").src="images/transparent.png";
			//insert data only when in start mode
			if(!isPreview){
			$.ajax({
				type: 'POST',
				url: 'insertLikertResults.php',
				data: { happy : 1, taskID : taskID, preID : preID, testID: testID}
			});
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
		.bottom{
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		.faces{
			text-align: center;
		}
		#happy{
			margin-right: 5%;
		}
		#sad{
			margin-left: 5%;
		}
		#participant{
			height: 220px;
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		.bottomInBottom{
			position: absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		.faceCol{
			height: 150px;
		}
		#button{
			margin-top:-20px;
		}
		.center-align{
			margin-top: 100px;
			font-size: 50px;
		}
		.container{
			margin-top:-85px;
		}
		</style>
</html>
