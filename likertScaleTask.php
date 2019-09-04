<html>
	<?php
	header('Access-Control-Allow-Origin: *');
	session_start();
	if(isset($_SESSION["userID"]))
		$userID = $_SESSION["userID"];
	else
		header('login.php');
	if(isset($_SESSION["groupID"]))
		$groupID = $_SESSION["groupID"];
	if(isset($_SESSION["tasks"]))
		$tasks = $_SESSION['tasks'];
	if(isset($_GET["taskIndex"]))
		$taskIndex = $_GET['taskIndex'];
	include 'db_connection.php';
	$conn = OpenCon();
	$taskID = $tasks[$taskIndex]['taskID'];
	//fetch images
	$sql = "SELECT * FROM IMAGE WHERE TASKID = '$taskID'";
	$result = $conn->query($sql);
	$images = array();
	while($row = mysqli_fetch_assoc($result))
	   $images[] = $row;
	//fetch preschoolers
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
    mysqli_close($conn);
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
		</style>
    </head>
    <body>
    <!--header-->
        <div class="row">
            <div class="navbar-fixed">
            <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>

                <ul id="logoutButton" class="right hide-on-med-and-down logout">
                    <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()">Profile</a></li>
                </ul>
            </div>
        </nav>
    </div>
    </div>
    <!--end header-->
        <!-- body content -->
		<img src="images/greyCircle.png" width="7%" align="right" onclick="goNext();"></img>
		<div class="container">
			<div class="center-align"><img id="image" width="28%"></img></div>
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
		var taskIndex = <?php echo(json_encode($taskIndex)); ?>;
		var tasks = <?php echo(json_encode($tasks)); ?>;
		var taskID = tasks[taskIndex]['taskID'];
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
			preschoolerIndex++;
			if(preschoolerIndex == preschoolers.length){
				var groupID = <?php echo $groupID ?>;
				var taskIndex = <?php echo $taskIndex ?>;
				window.location.href = "comments.php?taskIndex=" + taskIndex;
			}
			preID = preschoolers[preschoolerIndex]['preID'];
			document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerIndex]['name'];
			document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
			document.getElementById("sad").src="images/sad.png";
			document.getElementById("happy").src="images/happy.png";
		}
		function sadClicked(){
            document.getElementById("sad").src="images/transparent.png";
			//insert data
			$.ajax({
				type: 'POST',
				url: 'http://localhost/insertLikertResults.php',
				data: { happy : 0, taskID : taskID, preID : preID}
			});
		}
		function happyClicked(){
			document.getElementById("happy").src="images/transparent.png";
			//insert data
			$.ajax({
				type: 'POST',
				url: 'http://localhost/insertLikertResults.php',
				data: { happy : 1, taskID : taskID, preID : preID}
			});
		}
	</script>
</html>
