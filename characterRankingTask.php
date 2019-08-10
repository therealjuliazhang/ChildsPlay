<html>
<?php
$testID = $_GET["testID"];
$groupID = $_GET["groupID"];
$taskIndex = $_GET['taskIndex'];
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
//fetch preschoolers from database
$sql = "SELECT * FROM PRESCHOOLER WHERE GROUPID = '$groupID'";
$result = $conn->query($sql);
$preschoolers = array();
while($row = mysqli_fetch_assoc($result))
   $preschoolers[] = $row;
//fetch images
$sql = "SELECT * FROM IMAGE WHERE TASKID = '$taskID'";
$result = $conn->query($sql);
$images = array();
while($row = mysqli_fetch_assoc($result))
   $images[] = $row;
mysqli_close($conn);
?>

<head>
	<title>Character Ranking Task</title>
	<!--links for Materialize-->
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script>
	var testID = <?php echo(json_encode($testID)); ?>;
	var taskID = <?php echo(json_encode($taskID)); ?>;

	//preschoolerNumber determines whos turn it is
	var preschoolerNumber = 0;
	//gets preschoolers array from php
	var preschoolers = <?php echo(json_encode($preschoolers)); ?>;
	//colour of backround of preschoolers names at bottom
	var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
	//characters being tested
	var images = <?php echo(json_encode($images)); ?>;
	var pointsToGive = images.length;
	//creates canvas and displays preschoolers name
	window.onload = function() {
		displayCharacters();
		document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length];
	}
	//Next participant
	function goNext(){
		preschoolerNumber++;
		if(preschoolerNumber == preschoolers.length){
			var testID = <?php echo $testID ?>;
			var groupID = <?php echo $groupID ?>;
			var taskIndex = <?php echo $taskIndex ?>;
			window.location.href = "comments.php?testID=" + testID + "&groupID=" + groupID + "&taskIndex=" + taskIndex;
		}

		var previousPreschoolerName = document.getElementById("preschoolerName").innerHTML;
		document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerNumber]['name'];;
		document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length];
		var chosenCharacters = document.getElementsByClassName("character");
		for (var i = 0; i < chosenCharacters.length; i++){
			chosenCharacters[i].classList.remove("chosen");
			chosenCharacters[i].setAttribute("points", 0);
		}
		pointsToGive = images.length;
	}

	function displayCharacters(){
		var width = 170;
		for(var i = 0; i < images.length; i++){
			var div = document.createElement("div");
			var img = document.createElement("img");
			img.src = images[i]['address'];
			img.style.height = '200px';
			div.style.left = width * i + "px";
			div.className = 'character';
			div.setAttribute('points', 0);
			div.setAttribute('imageID', images[i]['imageID']);
			div.appendChild(img);
			div.onclick = function(){
				this.setAttribute('points', parseInt(this.getAttribute("points")) + pointsToGive);
				pointsToGive--;
				requestAnimationFrame(() => {
					this.classList.add("chosen");
				})
				//send results to php file
				$.ajax({
						 type: 'POST',
						 url: 'http://localhost/getRanking.php/',
						 data: { imageID : this.getAttribute("imageID"), score : this.getAttribute("points"), testID : testID, taskID : taskID, preID : preschoolers[preschoolerNumber]['preID']},
						 success: function(imageID){
							console.log(imageID);
						}
				});
			};
			div.onTouchStart = function(){
				requestAnimationFrame(() => {
					this.classList.add("chosen");
				})
				//send results to php file
				$.ajax({
						 type: 'POST',
						 url: 'http://localhost/getRanking.php/',
						 data: { imageID : imageID, score : this.getAttribute("points"), testID : testID, taskID : taskID, preID : preschoolers[preschoolerNumber]['preID']}
				});
			};
			document.getElementById("container").appendChild(div);
		}
	}
	</script>
	<!--link for font awesome icons-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		#button{
			position: absolute;
			right: 0px;
		}
		#participant{
			height: 220px;
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		#container{
			position: relative;
			height: 100%;
			width: 93%;
		}
		.character {
			position: absolute;
			top: 150px;
			transition: top 4000ms;
		}
		.character.chosen {
			top: -350px;
		}
		.center-align{
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
	</style>
</head>
<body>
	<!-- body content -->
	<img id="button" src="images/greyCircle.png" alt= "image not workning" width="7%" onclick="goNext();"></img>
	<div id="container"></div>
	<div id="participant" class="row" style="font-size:18px;font-weight:bold">
		<div class="center-align">
			<span id="preschoolerName">
			</span>'s Turn
		</div>
	</div>
	<!--end body content-->
</body>
</html>
