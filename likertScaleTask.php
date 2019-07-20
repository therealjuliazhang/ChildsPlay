<html>
	<?php
	//these values should be set by user selecting task
	$testID = '1';
	$taskID = '1';
	$groupID = '1';

	header('Access-Control-Allow-Origin: *');
	session_start();
	include 'db_connection.php';
	$conn = OpenCon();
	//fetch images
	$sql = "SELECT * FROM IMAGE WHERE TASKID = '$taskID'";
	$result = $conn->query($sql);
	$images = array();
	while($row = mysqli_fetch_assoc($result))
	   $images[] = $row;
	mysqli_close($conn);?>
	<head>
		<title>Likert Scale Task</title>
		<!--links for Materialize-->
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type="text/javascript" src="javascript/scripts.js"></script>
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
		}
		#happy{
			margin-left: 20%;
		}
		#sad{
			margin-left: 40%;
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
				<div class="row faces">
					<img id="happy" src="images/happy.jpg" onclick="happyClicked()" width="10%"></img>
					<img id="sad" src="images/sad.jpg" onclick="sadClicked()" width="10%"></img>
				</div>
				<div class="row amber accent-4" style="font-size:18px;font-weight:bold">
					<div class="center-align">
						<span id="preschoolerName">Aiden</span>'s Turn
					</div>
				</div>
			</div>
		</div>
        <!--end body content-->

    </body>
	<script>
		var images = <?php echo(json_encode($images)); ?>;
		var imageURL = images[0]['address'];
		document.getElementById("image").src = imageURL;
		function sadClicked()
		{
            document.getElementById("sad").src="images/fireworks2.gif";
		}
		function happyClicked()
		{
			document.getElementById("happy").src="images/fireworks.gif";
		}
	</script>
</html>
