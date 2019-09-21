<!DOCTYPE html>
<html>
<?php
session_start();
//include_once 'resultQueries.php';
if(isset($_SESSION['userID']))
	$userID = $_SESSION['userID'];
else
	header('login.php');

if(isset($_SESSION["testID"])){
	//session_destroy();
	unset($_SESSION["testID"]);
}
if(isset($_GET["testID"])){
	$testID = $_GET["testID"];
	$_SESSION["testID"] = $testID;
}
include_once 'resultQueries.php';
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
			$('.dropdown-trigger').dropdown();
			//get results from php
			var results = <?php echo json_encode($results); ?>;
			//get is group results boolean from php
			var isGroupResults = <?php echo json_encode($isGroupResults);?>;
			//print out "Result not found" if all results arrays are empty
			// if(likertResults.length == 0 && rankingResults.length == 0 && mechanicResults.length == 0 /*&& bodyPartsResults == 0*/){
			// 	var output = "No results match!";
			// 	var result = document.getElementById("results");
			// 	result.innerHTML = output;
			// 	result.style.color = "red";
			// 	result.style.fontStyle = "italic";
			// }
			//print out "Result not found" if all results is empty
			if(results.length == 0){
				var output = "No results match!";
				var result = document.getElementById("results");
				result.innerHTML = output;
				result.style.color = "red";
				result.style.fontStyle = "italic";
			}
			//order results by testID and order in test
			results.sort(function (a, b) {  
				return a.orderInTest - b.orderInTest || a.orderInTest - b.orderInTest;
			});
			//display results
			displayResults(results);
		});
		</script>
	</head>
    <body>
        <!--header-->
		<div id="InsertHeader"></div>
		<script>
			//Read header
			$(function(){
			    $("#InsertHeader").load("header.html");
			});
		</script>
        <!--end header-->
        <!--side bar-->
	<ul id="sidebar" class="sidenav sidenav-fixed" >
		<li><h5><a href="#" data-target="slide-out" class="dropdown-trigger">More Tests</a></h5></li>button to activate more tests
		<ul class="dropdown-content" id="slide-out">
		<?php
		$testQuery = "SELECT testID, title FROM TEST";
		$result = $conn->query($testQuery);
		while($row = mysqli_fetch_assoc($result))
			//echo "<li><a href='#'>".$row["title"]."</a></li>";
			echo "<li><a href='?testID=".$row["testID"]."'>".$row["title"]."</a></li>";
		?>
		</ul>

		<li><h5>Filter Results By:</h5></li>
		<form action="" method="post">
		<!--Collapsible group tab-->
		<ul class="collapsible">
			<li>
		   	<div class="collapsible-header"><i class="material-icons">group</i><h6>Group</h6></div>
		    <div class="collapsible-body">
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Location</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<?php
								$locationQuery = "SELECT * FROM LOCATION WHERE locationID != 1";
								$locationResult = $conn->query($locationQuery);
								while($row = mysqli_fetch_assoc($locationResult)){
									echo "<p><label><input type='checkbox' name='location[]' value='".$row["locationID"]."' class='filled-in' />".
									     "<span>".$row["name"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Group</h6></div>
						<div class="collapsible-body">
							<div class="container">
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
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Gender</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<!--start checkbox-->
								<?php
								$genderQuery = "SELECT DISTINCT gender FROM PRESCHOOLER";
								$genderResult = $conn->query($genderQuery);
								while($row = mysqli_fetch_assoc($genderResult)){
									echo "<p><label><input type='checkbox' name='gender[]' value='".$row["gender"]."' class='filled-in' />".
									     "<span>".$row["gender"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
				<ul class="collapsible">
					<li>
						<div class="collapsible-header"><h6>Age</h6></div>
						<div class="collapsible-body">
							<div class="container">
								<?php
								$ageQuery = "SELECT DISTINCT age FROM PRESCHOOLER";
								$ageResult = $conn->query($ageQuery);
								while($row = mysqli_fetch_assoc($ageResult)){
									echo "<p><label><input type='checkbox' name='age[]' value='".$row["age"]."' class='filled-in' />".
									     "<span>".$row["age"]."</span></label></p>";
								}
								?>
								<!--end checkbox-->
							</div> <!--end container-->
						</div>
					</li>
				</ul>
			</div>
			</li>
		</ul>
		<!--End Collapsible group Tab-->
		
		<!--Collapsible Individual Tab-->
		<ul class="collapsible">
					<li>
						<div class="collapsible-header"><i class="material-icons">person</i><h6>Individual</h6></div>
						<div class="collapsible-body">
							<div class="container">
							<?php
								$childQuery = "SELECT DISTINCT name, preID FROM PRESCHOOLER";
								if(isset($testID))
									$childQuery .= " ";
								$childResult = $conn->query($childQuery);
								while($row = mysqli_fetch_assoc($childResult)){
									echo "<p><label><input type='checkbox' name='name[]' value='".$row["preID"]."' class='filled-in' />".
										 "<span>".$row["name"]."</span></label></p>";
									}
								CloseCon($conn);
							?>
							</div>
						</div>
					</li>
				</ul>
				<!--End Collapsible Individual Tab-->
				<ul class="collapsible">
				<li>
					<br/>
					<div class="center-align">
						<button class="btn waves-effect waves-light blue darken-4 sortButton" type="submit" name="submitGroup">Filter</button>
					</div>
				</li>
				</ul>
		</form>
	<!--end filter result form-->		
	</ul>
        <!--end side bar-->
        <!-- body content -->
        <div id="body">
			<!--end slide out menu-->
			<div id="results">
			</div>
		</div>
		<!--end body content-->
		</body>
	<script>
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
	#slide-out{
		width: 300px !important;
		top: 50px !important;
	}
    </style>
</html>
