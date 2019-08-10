<html>
	<?php
	$testID = $_GET["testID"];
	//if there is no groupId then it is a preview and groupID is set to 1 (preview group)
	$groupID = isset($_GET['groupID']) ? $_GET['groupID'] : 1;
	$taskIndex = $_GET['taskIndex'];
	header('Access-Control-Allow-Origin: *');
	session_start();
	include 'db_connection.php';
	$conn = OpenCon();
	//fetch task
	$testQuery = "SELECT * FROM TASK WHERE testID=" . $testID;
	$result = $conn->query($testQuery);
	$tasks = array();
	while($row = mysqli_fetch_assoc($result))
		$tasks[] = $row;
	$taskID = $tasks[$taskIndex]['taskID'];
	//fetch images
	$sql = "SELECT * FROM IMAGE WHERE TASKID = '$taskID'";
	$result = $conn->query($sql);
	$images = array();
	while($row = mysqli_fetch_assoc($result))
	   $images[] = $row;
	//fetch preschoolers
	$sql = "SELECT * FROM PRESCHOOLER WHERE GROUPID = '$groupID'";
	$result = $conn->query($sql);
	$preschoolers = array();
	while($row = mysqli_fetch_assoc($result))
	$preschoolers[] = $row;
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
		.bottom{
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		.faces{
			border:5px solid #586F80;
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

		</style>
    </head>

    <body>
        <!--no header needed for test pages-->
        <!-- body content -->

		<img src="images/greyCircle.png" width="7%" align="right" onclick="goNext();"></img>

		<div class="container">
			<div class="center-align"><img id="image" width="28%"></img></div>
			<!--all container does is create padding on the left & right sides.-->
			</div>

		<div class="bottom">
			<div id="participant" class="row" style="font-size:18px;font-weight:bold">

				<div class="bottomInBottom">
				<div class="row faces">
					<img id="happy" src="images/happy.jpg" onclick="happyClicked()" width="10%"></img>
					<img id="sad" src="images/sad.jpg" onclick="sadClicked()" width="10%"></img>
				</div>

				<div class="center-align">
					<span id="preschoolerName">
					</span>'s Turn
				</div>
				</div>
			</div>
		</div>

        <!--end body content-->

    </body>
	<script>
		var taskIndex = <?php echo(json_encode($taskIndex)); ?>;
		var images = <?php echo(json_encode($images)); ?>;
		var imageURL = images[0]['address'];
		document.getElementById("image").src = imageURL;
		//gets preschoolers array from php
		var preschoolers = <?php echo(json_encode($preschoolers)); ?>;
		//preschoolerIndex determines whos turn it is
		var preschoolerIndex = 0;
		//colour of backround of preschoolers names at bottom
		var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
		document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];

		function goNext(){
			preschoolerIndex++;
			if(preschoolerIndex == preschoolers.length){
				var testID = <?php echo $testID ?>;
				var groupID = <?php echo $groupID ?>;
				var taskIndex = <?php echo $taskIndex ?>;
				window.location.href = "comments.php?testID=" + testID + "&groupID=" + groupID + "&taskIndex=" + taskIndex;
			}
			document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerIndex]['name'];
			document.getElementById("participant").className = 'row ' + colours[preschoolerIndex % colours.length];
			document.getElementById("sad").src="images/sad.jpg";
			document.getElementById("happy").src="images/happy.jpg";
		}

		function sadClicked(){
            document.getElementById("sad").src="images/fireworks2.gif";
		}

		function happyClicked(){
			document.getElementById("happy").src="images/fireworks.gif";
		}
	</script>
</html>
