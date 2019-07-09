<?php
session_start();
include 'db_connection.php';
$conn = OpenCon();
$sql = "SELECT * FROM PRESCHOOLER";
$result = $conn->query($sql);
$preschoolers = array();
//fetches names of preschoolers into array
while($row = mysqli_fetch_assoc($result))
   $preschoolers[] = $row;
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
	<script type="text/javascript" src="javascript/scripts.js"></script>
	<script>
	//preschoolerNumber determines whos turn it is
	var preschoolerNumber = 0;
	//gets preschoolers array from php
	var preschoolers = <?php echo(json_encode($preschoolers)); ?>;
	//colour of backround of preschoolers names at bottom
	var colours = ['amber accent-4', 'red', 'deep-purple', 'deep-orange', ' blue accent-4', 'teal', 'indigo accent-4', 'light-green accent-4', 'green', 'lime']
	var characterURLs = ['/images/Puff.png', '/images/character2.jpg', '/images/character3.jpg', '/images/character4.jpg', '/images/character5.jpg', '/images/character6.png'];
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
			preschoolerNumber = 0;
			displayCharacters();
		}
		document.getElementById("preschoolerName").innerHTML = preschoolers[preschoolerNumber]['name'];
		document.getElementById("participant").className = 'row ' + colours[preschoolerNumber % colours.length]; 
	}
	
	function displayCharacters(){
		var width = 170;
		for(var i = 0; i < characterURLs.length; i++){
			var div = document.createElement("div");
			var img = document.createElement("img");
			img.src = characterURLs[i];
			img.style.height = '200px';
			div.style.position = 'absolute';
			div.style.top = '100px';
			div.style.left = width * i + "px";
			div.appendChild(img);
			document.getElementById("container").appendChild(div);
			div.addEventListener("mousedown", chosen, false);
			div.addEventListener("touchstart", chosen, false);
		}
	}
	
	function chosen(e){
		if (!e)
			var e = event;
		var id = setInterval(frame, 5);
		var pos = 0;
		function frame() {
		  if (pos == 100) {
			clearInterval(id);
		  } else {
			pos++; 
			e.target.style.top = 100-pos + "px"; 
			console.log(e.target.style.top);
		  }
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
			position:absolute;
			bottom: 0px;
			right:0px;
			left:0px
		}
		#container{
			position: relative;
			height = 100%;
			width = 100%;
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