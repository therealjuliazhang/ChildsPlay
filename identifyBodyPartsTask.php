<html>
<?php
//these values should be set by user selecting task
$testID = '1';
$taskID = '2';
$groupID = '1';

header('Access-Control-Allow-Origin: *');
session_start();
include 'db_connection.php';
$conn = OpenCon();
//fetch names of preschoolers
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
mysqli_close($conn);?>
<head>
	<title>Identify Body Parts Task</title>
	<!--links for Materialize-->
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script type="text/javascript" src="javascript/scripts.js"></script>
	<script>
	var testID = <?php echo(json_encode($testID)); ?>;
	var taskID = <?php echo(json_encode($taskID)); ?>;

	//canX is canvas x coordinate, canY is y coordinate
	var canvas, ctx, canX, canY = 0;
	var opacity = 1;
	var images = <?php echo(json_encode($images)); ?>;
	//characterNumber determines which image is being tested
	var imageNumber = 0;
	//gets preschoolers array from php
	var preschoolers = <?php echo(json_encode($preschoolers)); ?>;
	//preschoolerNumber determines whos turn it is
	var preschoolerNumber = 0;
	//colour of backround of preschoolers names at bottom
	var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime'];
	
	//creates canvas and displays preschoolers name
	window.onload = function() {
		canvas = document.getElementById("myCanvas");
		ctx = canvas.getContext("2d");
		displayCharacter(imageNumber);
		canvas.addEventListener("mousedown", mouseDown, false);
		canvas.addEventListener("touchstart", touchDown, false);
		document.getElementById("preschoolerName").innerHTML = preschoolers[0]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length];
	}
	
	function mouseDown(e) {
		if (!e)
			var e = event;
		 canX = e.pageX - canvas.offsetLeft;
		 canY = e.pageY - canvas.offsetTop;
		opacity = 1;
		window.requestAnimationFrame(draw);
		//send results to php file
		$.ajax({
				 type: 'POST',
				 url: 'http://localhost/getCoordinates.php',
				 data: { x : canX, y : canY , testID : testID, taskID : taskID, preID : preschoolers[preschoolerNumber]['preID']}
		});
	}
		
	function touchDown(e) {
		if (!e)
			var e = event;
		e.preventDefault();
		canX = e.targetTouches[0].pageX - canvas.offsetLeft;
		canY = e.targetTouches[0].pageY - canvas.offsetTop;
		opacity = 1;
		window.requestAnimationFrame(draw);
		//send results to php file
		$.ajax({
				 type: 'POST',
				 url: 'http://localhost/getCoordinates.php',
				 data: { x : canX, y : canY , testID : testID, taskID : taskID, preID : preschoolers[preschoolerNumber]['preID']}
		});
	}	
	//draws circle
	function draw(){
		ctx.clearRect(0,0,ctx.canvas.width,ctx.canvas.height);
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
	function goNext(){
		preschoolerNumber++;
		if(preschoolerNumber == preschoolers.length){
			//if(imageNumber == images.length)
			//	goToNextPage();
			preschoolerNumber = 0;
			imageNumber++;
			displayCharacter(imageNumber);
		}
		document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerNumber]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length]; 
	}
	
	function displayCharacter(imageNumber){
		document.getElementById("myCanvas").style.background = "url(" + images[imageNumber]['address'] + ")";
		document.getElementById("myCanvas").style.backgroundRepeat = 'no-repeat';
		document.getElementById("myCanvas").style.backgroundSize = 'contain';
		document.getElementById("myCanvas").style.backgroundPosition = 'center top';
	}
	</script>
	<!--link for font awesome icons-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
		#myCanvas{
			padding: 0;
			margin: auto;
			display: block;
		}
		#button{
			position: absolute;
			right: 0px;
		}
		#participant{
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
	
	<canvas id="myCanvas" width="800" height="400">
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
