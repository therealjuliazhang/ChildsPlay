<html>
	<?php
		//these should be gotten from somewhere else, not hard coded.
		$userID = 2;
		$testID = 1;
		//connect to database
		include 'db_connection.php';
		$conn = OpenCon();
		
		$tasks = array();
		$sql = "SELECT taskID FROM TASKASSIGNMENT WHERE testID = " .$testID;
		$result = $conn->query($sql);
		while($row = mysqli_fetch_assoc($result)){
			//get tasks
			$sql1 = "SELECT * FROM TASK WHERE taskID=".$row["taskID"];
			$result1 = $conn->query($sql1);
			while($row1 = mysqli_fetch_assoc($result1)){
				array_push($tasks, $row1);
			}
		}
		
		//get character ranking task results
		$rankingResults = array();
		$countSad = 0;
		$countHappy = 0;
		foreach($tasks as $value){
			if($value['taskType']=="Character Ranking"){
				$sql = "SELECT * FROM ranking WHERE testID = " .$testID. " AND taskID = " .$value['taskID'];
				$result = $conn->query($sql);
				while($row = mysqli_fetch_assoc($result))
					$rankingResults[] = $row;
			}
			else if($value['taskType'] == "Likert Scale"){
				$resultQuery = "SELECT happy FROM RESULTS WHERE testID=".$testID." AND taskID=".$value["taskID"]; //can retrieve preID as well if Holly cares about result of each kid
				$result2 = $conn->query($resultQuery);
				while($row2 = mysqli_fetch_assoc($result2)){
					if($row2["happy"] == false){
						$countSad++;
					}
					else if($row2["happy"] == true){
						$countHappy++;
					}
				}
			}
		}
		//get images for each task
		$images = array();
		foreach($tasks as $task){
			$sql3 = "SELECT * FROM image WHERE taskID = " .$task['taskID'];
			$result3 = $conn->query($sql3);
			while($row3 = mysqli_fetch_assoc($result3))
				$images[] = $row3;
		}
	?>
    <head>
        <title>Child'sPlay</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

	</head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
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
			<li><h5><a href="#" data-target="slide-out" class="sidenav-trigger">More Tests</a></h5></li><!--button to activate more tests-->
			<li><h5>Sort Results By</h5></li>
			<form action="">
			<li>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Location</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>All Locations</span>
								</label>
								</p>
								<!--end checkbox-->
								<h6>OR</h6>
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>Location 1</span>
								</label>
								</p>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
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
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>Male</span>
								</label>
								</p>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>Female</span>
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
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>Group 1</span>
								</label>
								</p>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>Group 2</span>
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
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>3 Years Old</span>
								</label>
								</p>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>4 Years Old</span>
								</label>
								</p>
								<!--end checkbox-->
								<!--start checkbox-->
								<p>
								<label>
									<input type="checkbox" class="filled-in"/>
									<span>5 Years Old</span>
								</label>
								</p>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</li>
			<li>
				<br/>
				<div class="center-align">
					<button class="btn waves-effect waves-light blue darken-4 sortButton" type="submit" name="action">Sort</button>
				</div>
			</li>
			</form>
			<!--end sort result form-->
		</ul>
        <!--end side bar-->

        <!-- body content -->
        <div id="body">
            <!--the slide out menu-->
            <ul id="slide-out" class="sidenav">
                <li><a href="">Wollongong Preschool Test 1</a></li>
                <li><a href="">Wollongong Preschool Test 2</a></li>
                <li><a href="">Wollongong Preschool Test 3</a></li>
                <li><a href="">Wollongong Preschool Test 4</a></li>
            </ul>
			<!--end slide out menu-->
			<div id="results">
				<!-- LIKERT SCALE TASK -->
				<h5 class="blue-text darken-2 header">Likert Scale:</h5>
				Do you like this monster?
				<br>
				<img class="image" src="images/Puff.jpg" style="width:15%;">
				<br>
				<h5 class="blue-text darken-2 header">Results:</h5>
				<!-- Chart.JS -->
				<canvas id="likertChart" width="800px;">CanvasNotSupported</canvas>
				<div class="row">
					<form class="col s12">
						<div class="input-field col s8">
							<textarea id="textarea1" class="materialize-textarea"></textarea>
							<label for="textarea1">Comments</label>
						</div>
					</form>
				</div>
				<!-- IDENTIFY BODY PARTS TASK -->
				<h5 class="blue-text darken-2 header">Identify Eye Task:</h5>
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
				</div>
				
				<!-- DRAG AND DROP TASK -->
				<!-- <h5 class="blue-text darken-2 header">Drag and Drop Task:</h5>
				Testing their ability to drag and drop the monsters.
				<br>
				<img class="image" src="images/Puff.jpg" style="width:15%;">
				<h5 class="blue-text darken-2 header">Results:</h5>
				<canvas id="dragAndDropChart" width="800px;">CanvasNotSupported</canvas>
				<div class="row">
					<form class="col s12">
						<div class="input-field col s8">
							<textarea id="textarea1" class="materialize-textarea"></textarea>
							<label for="textarea1">Comments</label>
						</div>
					</form>
				</div>
				<div class="center-align">
					<a class="waves-effect waves-light btn blue darken-4" id="backToTopButton" onclick="backToTop()">Back To Top</a>
				</div>
				<br/> -->
			</div>
		</div>
		<!--end body content-->
		</body>
	<script>
		//get all images for all tasks in this test
		var testImages = <?php echo json_encode($images); ?>;
		//get results for all character ranking tasks in this test
		var rankingResults = <?php echo json_encode($rankingResults); ?>;
		//identify body parts results
		window.onload = function() {
			//identify body parts results canvas
			var c = document.getElementById("myCanvas");
			var ctx = c.getContext("2d");
			var img = new Image(240, 297);
			img.src = 'images/Puff.jpg';
			ctx.drawImage(img, 0, 0, img.width, img.height);
			//circles on canvas
			ctx.fillStyle = 'red';
			ctx.beginPath();
			ctx.arc(100, 75, 5, 0, 2 * Math.PI);
			ctx.stroke();
			ctx.fill();
			ctx.fillStyle = 'blue';
			ctx.beginPath();
			ctx.arc(150, 50, 5, 0, 2 * Math.PI);
			ctx.stroke();
			ctx.fill();
			ctx.fillStyle = 'green';
			ctx.beginPath();
			ctx.arc(90, 60, 5, 0, 2 * Math.PI);
			ctx.stroke();
			ctx.fill();
			ctx.fillStyle = 'yellow';
			ctx.beginPath();
			ctx.arc(110, 85, 5, 0, 2 * Math.PI);
			ctx.stroke();
			ctx.fill();
		}
		$(document).ready(function(){
			$('.sidenav').sidenav();
			$('.collapsible').collapsible();
			displayTaskResults();
		});
		//displays all the task results
		function displayTaskResults(){
			var tasks = <?php echo json_encode($tasks); ?>;
			//for each task
			tasks.forEach(function(task){
				//check the task type
				switch(task.taskType) {
				case "Likert Scale":
					displayLikertScale(task);
					break;
				case "Identify Body Parts":
					displayIdentifyBodyParts(task);
					break;
				case "Character Ranking":
					displayCharacterRanking(task);
					break;
				case "Preferred Mechanics":
					displayPreferredMechanics(task);
					break;
				default:
				}
			});
		};
		//likert scale task results
		function displayLikertScale(task){
			var ctx = document.getElementById("likertChart").getContext('2d');
			var likertChart = new Chart(ctx, {
				type: "horizontalBar", // Make the graph horizontal
				data: {
				labels:  ["Happy", "Sad"],
				datasets: [{
				label: "Number of Answers",
				data: [<?php echo $countHappy;?>, <?php echo $countSad;?>],
				backgroundColor: ['rgba(255, 159, 64, 0.2)',
                'rgba(153, 102, 255, 0.2)'],
				borderColor:['rgba(255, 159, 64, 1)',
                'rgba(153, 102, 255, 1)'],
				borderWidth: 1
				}]},
				options: {
					responsive: false,
					title: {
					display: true,
					fontSize: 15,
					text: "Results"
					},
					legend: {
						//position: 'right',
					display: false,
					},
					scales: {
						xAxes: [{ // Ｘ Axes Option
							ticks: {
								beginAtZero: true,
								stepSize: 1
							}}],
						yAxes: []
					}
				}
			});
		};
		//display likert scale task results
		function displayIdentifyBodyParts(task){
		
		}
		//display Character ranking task results
		function displayCharacterRanking(task){
			//get images for this task
			var taskImages = getTaskImages(task.taskID);
			//get ranking results for this task
			var taskRankingResults = getTaskRankingResults(task.taskID);
			//calculate total scores and rankings
			var rankedImages = rankImages(taskImages, taskRankingResults);
			//create html
			var header = "<h5 class=\"blue-text darken-2 header\">" + task.taskType + " (Test ID: " + task.testID + ", Task ID: " + task.taskID + ")</h5\>";
			var resultsHeader = "<h5 class=\"blue-text darken-2 header\">Results:</h5>";
			var tableHeader = "<div id=\"tableDiv\"><table class=\"centered\"><thead><tr><th>Rank: </th><th>Points: </th><th>Image: </th></tr></thead>";
			var tableBody = "<tbody>" + createTableRows(rankedImages) + "</tbody></table></div>";
			var table = tableHeader + tableBody;
			var commentsDiv = "<div class=\"row\"><form class=\"col s12\"><div class=\"input-field col s8\">"
			var textArea = "<textarea id=\"textarea1\" class=\"materialize-textarea\"";
			if(task.comments != null){
				textArea += " value=" + task.comments;
			}
			textArea += "></textarea><label for=\"textarea1\">Comments</label></div></form></div><div class=\"row\"><form class=\"col s12\"><div class=\"input-field col s8\>";
			commentsDiv += textArea;
			$("#results").append(header, task.instruction, resultsHeader, table, commentsDiv);
			//adds score attribute to images and sorts them from highest score to lowest score
			function rankImages(images, results){
				//calculate total scores and set it to image.score
				images.forEach(function(image){ 
					image.score = 0;
					results.forEach(function(result){
						if (parseInt(image.imageID) == parseInt(result.imageID)){
							image.score += parseInt(result.score);
						}
					});	
				});	
				//sorts images by score
				images.sort((a, b) => (a.score < b.score) ? 1 : -1);
				return images;
			}
			//returns the html for the table rows based on the ranked images
			function createTableRows(rankedImages){
				var rankNumber = 0;
				var html = "";
				rankedImages.forEach(function(rankedImage){
					rankNumber++;
					var rank = rank_of(rankNumber);
					html += "<tr><td>" + rank + "</td>";
					html += "<td>" + rankedImage.score + "</td>";
					html += "<td><img class=\"image\" src=\"" + rankedImage.address + "\" style=\"width:15%;\"></td></tr>";
				});
				return html;
				//convert rank number to ordinal suffix e.g. 1 to 1st
				function rank_of(number) {
					var j = number % 10,
						k = number % 100;
					if (j == 1 && k != 11) {
						return number + "st";
					}
					if (j == 2 && k != 12) {
						return number + "nd";
					}
					if (j == 3 && k != 13) {
						return number + "rd";
					}
					return number + "th";
				}
			}
		}
		//display likert scale task results
		function displayPreferredMechanics(task){

		}
		//drag and drop task results
		// var ctx = document.getElementById("dragAndDropChart").getContext('2d');
		// var likertChart = new Chart(ctx, {
		// 	type: "horizontalBar", // Make the graph horizontal
		// 	data: {
		// 	labels:  ["Successful", "Unsuccessful"],
		// 	datasets: [{
		// 	   label: "Number of Answers",
		// 	   data: [6, 2],
		// 	   backgroundColor: ["green", "yellow"]
		// 	}]},
		// 	options: {
		// 		responsive: false,
		// 		title: {
		// 		display: true,
		// 		fontSize: 10,
		// 		text: "Results"
		// 		},
		// 		legend: {
		// 		display: false,
		// 		},
		// 		scales: {
		// 			xAxes: [{ // Ｘ Axes Option
		// 				ticks: {
		// 					min: 0
		// 				}}],
		// 			yAxes: []
		// 		}
		// 	}
		// });
		//function to scroll back to top of page
		function getTaskImages(taskID){
			var taskImages = [];
			testImages.forEach(function(image){ 
				if(image.taskID == taskID)
					taskImages.push(image);
			});
			return taskImages;
		}
		function getTaskRankingResults(taskID){
			var taskRankingResults = [];
			rankingResults.forEach(function(result){ 
				if(result.taskID == taskID)
					taskRankingResults.push(result);
			});
			return taskRankingResults;
		}
		function backToTop()
		{
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
    </style>
</html>
