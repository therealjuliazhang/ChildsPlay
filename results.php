<html>
<?php
//connect to database
include 'db_connection.php';
$conn = OpenCon();
session_start();
if(isset($_SESSION['userID']))
	$userID = $_SESSION['userID'];
$tasks = array();

//get tasks
$sql1 = "SELECT * FROM TASK";
$result1 = $conn->query($sql1);
while($row1 = mysqli_fetch_assoc($result1))
	array_push($tasks, $row1);

//Get all IDs of preschoolers who pass filter checks and put inside filteredPreIDs[]; 
$filteredPreIDs = [1, 2, 3, 4, 5];
$preIDsForQuery = join("','",$filteredPreIDs);

// get results for likert scale  
$sql = "SELECT DISTINCT happy, count(happy) AS likertCount, R.taskID, T.activity, imageID, address       
        FROM RESULTS R INNER JOIN IMAGE I ON R.taskID = I.taskID INNER JOIN TASK T ON R.taskID = T.taskID
        WHERE happy IS NOT NULL AND preID IN ('$preIDsForQuery')
		GROUP BY happy"; 
$result = $conn->query($sql);
$likertResults = array();
while($row = mysqli_fetch_assoc($result))
	array_push($likertResults, $row);

// get results for identify body parts
$sql = "SELECT R.taskID, imageID, address, x, y, T.activity
        FROM RESULTS R INNER JOIN IMAGE I ON R.taskID = I.taskID INNER JOIN TASK T ON R.taskID = T.taskID
		WHERE x IS NOT NULL AND preID IN ('$preIDsForQuery')";
$result = $conn->query($sql);
$bodyPartsResults = array();
while($row = mysqli_fetch_assoc($result))
	array_push($bodyPartsResults, $row);

// get results for preferred mechanics
$sql = "SELECT DISTINCT mechanic, count(mechanic) AS mechanicCount, T.activity, R.taskID, imageID, address
FROM RESULTS R INNER JOIN IMAGE I ON R.taskID = I.taskID INNER JOIN TASK T ON R.taskID = T.taskID
WHERE mechanic IS NOT NULL AND preID IN ('$preIDsForQuery')
GROUP BY mechanic, R.taskID";
$result = $conn->query($sql);
$mechanicResults = array();
while($row = mysqli_fetch_assoc($result))
	array_push($mechanicResults, $row);

// get results for character ranking
$sql = "SELECT R.imageID, address, sum(score) AS totalScore, R.taskID, R.preID, T.activity
        FROM RANKING R INNER JOIN IMAGE I ON R.imageID = I.imageID INNER JOIN TASK T ON R.taskID = T.taskID
        WHERE preID IN ('$preIDsForQuery')
        GROUP BY imageID
		ORDER BY totalScore DESC";
$result = $conn->query($sql);
$rankingResults = array();
while($row = mysqli_fetch_assoc($result))
	array_push($rankingResults, $row);
?>
    <head>
        <title>Child'sPlay</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
		<script src="displayResults.js"></script>
		<script>
		$(document).ready(function(){
			//initialize materialize sidenav
			$('.sidenav').sidenav();
			$('.collapsible').collapsible();
			//get results from php 
			var rankingResults = <?php echo json_encode($rankingResults); ?>;
			var likertResults = <?php echo json_encode($likertResults); ?>;
			var bodyPartsResults = <?php echo json_encode($bodyPartsResults); ?>;
			var mechanicResults = <?php echo json_encode($mechanicResults); ?>;
			//display results
			displayRanking(rankingResults);
			displayLikert(likertResults);
			displayMechanics(mechanicResults);
		});
		</script>
	</head>
    <body>
        <!--header-->
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li><a href="">Create</a></li>
                            <li class="active"><a href="" >Results</a></li>
                            <li><a href="">Users</a></li>
                        </ul>
                        <ul id="logoutButton" class="right hide-on-med-and-down logout">
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--end header-->
        <!--side bar-->
		<ul id="sidebar" class="sidenav sidenav-fixed" >
			<!-- <li><h5><a href="#" data-target="slide-out" class="sidenav-trigger">More Tests</a></h5></li>button to activate more tests -->
			<li><h5>Filter Results By</h5></li>
			<form action="" method="post">
			<li>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Location</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" name="location[]" class="filled-in"/>
									<span>All Locations</span>
								</label>
								</p>
								<!--end checkbox-->
								<h6>OR</h6>
								<!--start checkbox-->
								<?php
								$locationQuery = "SELECT * FROM LOCATION";
								$locationResult = $conn->query($locationQuery);
								while($row = mysqli_fetch_assoc($locationResult)){
									echo "<p><label><input type='checkbox' name='location[]' value='".$row["locationID"]."' class='filled-in' />".
									     "<span>".$row["name"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" name="3" class="filled-in"/>
									<span>Location 2</span>
								</label>
								</p>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</li>
			<li>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Group</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>All Groups</span>
								</label>
								</p>
								<!--end checkbox-->
								<h6>OR</h6>
								<!--start checkbox-->
								<?php
								$groupQuery = "SELECT * FROM GROUPTEST";
								$groupResult = $conn->query($groupQuery);
								while($row = mysqli_fetch_assoc($groupResult)){
									echo "<p><label><input type='checkbox' name='group[]' value='".$row["groupID"]."' class='filled-in' />".
									     "<span>".$row["name"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</li>

			<li>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Gender</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>All Genders</span>
								</label>
								</p>
								<!--end checkbox-->
								<h6>OR</h6>
								<!--start checkbox-->
								<?php
								$genderQuery = "SELECT DISTINCT gender FROM PRESCHOOLER";
								$genderResult = $conn->query($genderQuery);
								while($row = mysqli_fetch_assoc($genderResult)){
									echo "<p><label><input type='checkbox' name='gender[]' class='filled-in' />".
									     "<span>".$row["gender"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</li>
			<li>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Age</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>All Ages</span>
								</label>
								</p>
								<!--end checkbox-->
								<h6>OR</h6>
								<!--start checkbox-->
								<?php
								$ageQuery = "SELECT DISTINCT age FROM PRESCHOOLER";
								$ageResult = $conn->query($ageQuery);
								while($row = mysqli_fetch_assoc($ageResult)){
									echo "<p><label><input type='checkbox' name='age[]' class='filled-in' />".
									     "<span>".$row["age"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</li>
			<li>
				<br/>
				<div class="center-align">
					<button class="btn waves-effect waves-light blue darken-4 sortButton" type="submit" name="action">Filter</button>
				</div>
			</li>
			</form>
			<!--end filter result form-->
		</ul>
        <!--end side bar-->
        <!-- body content -->
        <div id="body">
			<!--end slide out menu-->
			<div id="results">
				<!-- IDENTIFY BODY PARTS TASK -->
				<!-- <h5 class="blue-text darken-2 header">Identify Eye Task:</h5>
				Can you point to the monster's eyes?
				</br>
				<img class="image" src="images/Puff.jpg" style="width:15%;">
				</br>
				<h5 class="blue-text darken-2 header">Results:</h5>
				<canvas class="image" id="myCanvas" width="240" height="297" style="border:1px solid #d3d3d3;">
					Your browser does not support the HTML5 canvas tag.
				</canvas>
				<div class="row">
					<form class="col s12">
						<div class="input-field col s8">
							<textarea id="textarea1" class="materialize-textarea"></textarea>
							<label for="textarea1">Comments</label>
						</div>
					</form>
				</div> -->
			</div>
		</div>
		<!--end body content-->
		</body>
	<script>
		//identify body parts results
		//window.onload = function() {
			//identify body parts results canvas
			// var c = document.getElementById("myCanvas");
			// var ctx = c.getContext("2d");
			// var img = new Image(240, 297);
			// img.src = 'images/Puff.jpg';
			// ctx.drawImage(img, 0, 0, img.width, img.height);
			//circles on canvas
			// ctx.fillStyle = 'red';
			// ctx.beginPath();
			// ctx.arc(100, 75, 5, 0, 2 * Math.PI);
			// ctx.stroke();
			// ctx.fill();
			// ctx.fillStyle = 'blue';
			// ctx.beginPath();
			// ctx.arc(150, 50, 5, 0, 2 * Math.PI);
			// ctx.stroke();
			// ctx.fill();
			// ctx.fillStyle = 'green';
			// ctx.beginPath();
			// ctx.arc(90, 60, 5, 0, 2 * Math.PI);
			// ctx.stroke();
			// ctx.fill();
			// ctx.fillStyle = 'yellow';
			// ctx.beginPath();
			// ctx.arc(110, 85, 5, 0, 2 * Math.PI);
			// ctx.stroke();
			// ctx.fill();
		//}
		//function to scroll back to top of page
		function backToTop(){
			document.body.scrollTop = 0;
			document.documentElement.scrollTop = 0;
		}
	</script>
    <style>
	#body {
		padding-left: 330px;
		padding-bottom: 50px;
	}
    @media only screen and (max-width : 992px) {
        #body{
            padding-left: 0;
        }
    }
    .brand-logo{
        margin-top:-67px;
    }
    .logout{
        margin-top: 15px;
        margin-right:15px;
    }
    #sidebar{
        margin-top: 64px;
    }
    .nav-wrapper > ul {
        margin-left: 220px;
    }
    .header{
        margin-top: 30px;
    }
    .image{
        margin-top: 10px;
    }
    #tableDiv{
        width: 400px;
    }
	.sortButton{
		margin-bottom: 80px;
	}
	.topPadding{
		padding-top: 50px;
	}
    </style>
</html>
