<html>
    <head>
        <title>Likert Scale Instructions</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type="text/javascript" src="javascript/scripts.js"></script>
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
include 'db_connection.php';
$conn = OpenCon();

$testQuery = "SELECT questionType FROM TASK WHERE testID=1";
$tests = $conn->query($testQuery);

if($tests->num_rows > 0) {
	while($row = $tests->fetch_assoc()){
		if($row["questionType"] == "likert"){
			echo "Ask each participant individually if he/she likes the monster and ask him/her, 'if you 
						like the monster, press the happy face, if you don't like the monster, press the sad 
						face'."; 
		}
	}
} else {
	echo "0 results";
}
CloseCon($conn);
?> 					
						</br>
						<img src="images/happy.jpg" width="75px"><img src="images/sad.jpg" width="75px">
						</br>
						After the participant has responded, select the grey, quarter-circle button on the top right 
						of the screen to go to the next participant's turn.
						</br>
						<img src="images/greyCircle.png" width="60px">
					</div>
					<h5 class="blue-text darken-2">Image Under Test:</h5>
					<img src="images/Puff.jpg" width="100px">
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="right-align">
						<a class="waves-effect waves-light btn blue darken-2" onclick="runTest()">Start</a>
						<a class="waves-effect waves-light btn blue darken-4" onclick="backToTestList()">Back</a>
					</div>
				</div>
			</div>
        </div>
        
        <!--end body content-->
        
    </body>
	<script>
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
