<!--
Title:Results;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Andre Knell (5741622), Ren Sugie(5679527);
Last Edited: 21/10/2019;
-->
<!DOCTYPE html>
<html>
<?php
session_start();
if(isset($_SESSION['userID']))
	$userID = $_SESSION['userID'];
else
	header('Location: login.php');

if(isset($_SESSION["testID"])){
	unset($_SESSION["testID"]);
}/*
if(isset($_GET["testID"])){
$testID = $_GET["testID"];
$_SESSION["testID"] = $testID;
}*/
include_once 'resultQueries.php';
?>
<head>
	<title>Results</title>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
	<script src="displayResults.js"></script>
	<script>
	//rotate arrow icon when tab is clicked
	$(document).ready(function(){
		$('.tabsInSidebar').click(function() {
			var iconId = $(this).children('i').eq(1).attr('id');

			if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForTests"){
				$("#arrowForTests").html("keyboard_arrow_right");
			}
			else if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForResults"){
				$("#arrowForResults").html("keyboard_arrow_right");
			}
			else if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForIndividualResults"){
				$("#arrowForIndividualResults").html("keyboard_arrow_right");
			}
		});
		$('.tabsInSidebar').click(function() {
			var iconId = $(this).children('i').eq(1).attr('id');

			if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForTests"){
				$("#arrowForTests").html("keyboard_arrow_down");
			}
			else if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForResults"){
				$("#arrowForResults").html("keyboard_arrow_down");
			}
			else if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForIndividualResults"){
				$("#arrowForIndividualResults").html("keyboard_arrow_down");
			}
		});
		//rotate arrow icon when tab in group tan section is clicked
		$('.tabsInGroupResults').click(function() {
			var iconId = $(this).children('i').eq(0).attr('id');
			if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForLocation"){
				$("#arrowForLocation").html("keyboard_arrow_down");
			}
			else if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForGroup"){
				$("#arrowForGroup").html("keyboard_arrow_down");
			}
			else if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForGender"){
				$("#arrowForGender").html("keyboard_arrow_down");
			}
			else if($(this).closest('li').hasClass( "active" ) == false && iconId == "arrowForAge"){
				$("#arrowForAge").html("keyboard_arrow_down");
			}
		});
		$('.tabsInGroupResults').click(function() {
			var iconId = $(this).children('i').eq(0).attr('id');
			if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForLocation"){
				$("#arrowForLocation").html("keyboard_arrow_right");
			}
			else if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForGroup"){
				$("#arrowForGroup").html("keyboard_arrow_right");
			}
			else if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForGender"){
				$("#arrowForGender").html("keyboard_arrow_right");
			}
			else if($(this).closest('li').hasClass( "active" ) == true && iconId == "arrowForAge"){
				$("#arrowForAge").html("keyboard_arrow_right");
			}
		});


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
		displayResults(results, isGroupResults);
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
		<!--<li><h5><a href="#" data-target="slide-out" class="dropdown-trigger">More Tests</a></h5></li>
		<ul class="dropdown-content" id="slide-out">
		<li><a href="results.php">All tests</a></li>
		<?php
		$testQuery = "SELECT testID, title FROM TEST";
		$result = $conn->query($testQuery);
		while($row = mysqli_fetch_assoc($result))
		echo "<li><a href='?testID=".$row["testID"]."'>".$row["title"]."</a></li>";
		?>
	</ul>--->

	<div><li><h5 style="padding-left:18px;">Filter By</h5></li></div>
	<form action="" method="post">
		<!--Collapsible tests tab-->
		<ul class="collapsible">
			<li>
				<div class="collapsible-header tabsInSidebar"><i class="material-icons">assessment</i><h6>Tests</h6><i id="arrowForTests" class="material-icons">keyboard_arrow_right</i></div>
				<div class="collapsible-body">
					<div class="container">
						<div><label><input type="checkbox" class="filled-in" /><span>All tests</span></label></div>
						<?php
						$testQuery = "SELECT testID, title FROM TEST";
						$result = $conn->query($testQuery);
						while($row = mysqli_fetch_assoc($result)){
							echo "<div><label><input type='checkbox' name='test[]' value='".$row["testID"]."' class='filled-in' />".
							"<span>".$row["title"]."</span></label></div>";
						}
						?>
					</div>
				</div>
			</li>
		</ul>
		<!--Collapsible group tab-->
		<ul class="collapsible">
			<li>
				<div class="collapsible-header tabsInSidebar"><i class="material-icons">group</i><h6>Group Results</h6><i id="arrowForResults" class="material-icons">keyboard_arrow_right</i></div>
				<div class="collapsible-body">
					<ul class="collapsible">
						<li>
							<div class="collapsible-header tabsInGroupResults"><h6 style="padding-left:6px">Location</h6><i id="arrowForLocation" class="material-icons right">keyboard_arrow_right</i></div>
							<div class="collapsible-body">
								<div class="container">
									<!--start checkbox-->
									<?php
									$locationQuery = "SELECT * FROM LOCATION WHERE locationID != 1";
									$locationResult = $conn->query($locationQuery);
									while($row = mysqli_fetch_assoc($locationResult)){
										echo "<div><label><input type='checkbox' name='location[]' value='".$row["locationID"]."' class='filled-in' />".
										"<span>".$row["name"]."</span></label></div>";
									}
									?>
									<!--end checkbox-->
								</div> <!--end container-->
							</div>
						</li>
					</ul>
					<ul class="collapsible">
						<li>
							<div class="collapsible-header tabsInGroupResults"><h6 style="padding-left:6px">Group</h6><i id="arrowForGroup" class="material-icons right">keyboard_arrow_right</i></div>
							<div class="collapsible-body">
								<div class="container">
									<!--start checkbox-->
									<?php
									$groupQuery = "SELECT * FROM GROUPTEST";
									$groupResult = $conn->query($groupQuery);
									while($row = mysqli_fetch_assoc($groupResult)){
										echo "<div><label><input type='checkbox' name='group[]' value='".$row["groupID"]."' class='filled-in' />".
										"<span>".$row["name"]."</span></label></div>";
									}
									?>
									<!--end checkbox-->
								</div> <!--end container-->
							</div>
						</li>
					</ul>
					<ul class="collapsible">
						<li>
							<div class="collapsible-header tabsInGroupResults"><h6 style="padding-left:6px">Gender</h6><i id="arrowForGender" class="material-icons right">keyboard_arrow_right</i></div>
							<div class="collapsible-body">
								<div class="container">
									<!--start checkbox-->
									<?php
									$genderQuery = "SELECT DISTINCT gender FROM PRESCHOOLER";
									$genderResult = $conn->query($genderQuery);
									while($row = mysqli_fetch_assoc($genderResult)){
										echo "<div><label><input type='checkbox' name='gender[]' value='".$row["gender"]."' class='filled-in' />".
										"<span>".$row["gender"]."</span></label></div>";
									}
									?>
									<!--end checkbox-->
								</div> <!--end container-->
							</div>
						</li>
					</ul>
					<ul class="collapsible">
						<li>
							<div class="collapsible-header tabsInGroupResults"><h6 style="padding-left:6px">Age</h6><i id="arrowForAge" class="material-icons right">keyboard_arrow_right</i></div>
							<div class="collapsible-body">
								<div class="container">
									<?php
									$ageQuery = "SELECT DISTINCT age FROM PRESCHOOLER";
									$ageResult = $conn->query($ageQuery);
									while($row = mysqli_fetch_assoc($ageResult)){
										echo "<div><label><input type='checkbox' name='age[]' value='".$row["age"]."' class='filled-in' />".
										"<span>".$row["age"]."</span></label></div>";
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
				<div class="collapsible-header tabsInSidebar"><i class="material-icons">person</i><h6>Individual Results</h6><i id="arrowForIndividualResults" class="material-icons right">keyboard_arrow_right</i></div>
				<div class="collapsible-body">
					<div class="container">
						<?php
						$childQuery = "SELECT DISTINCT name, preID FROM PRESCHOOLER";
						if(isset($testID))
						$childQuery .= " ";
						$childResult = $conn->query($childQuery);
						while($row = mysqli_fetch_assoc($childResult)){
							echo "<div><label><input type='checkbox' name='name[]' value='".$row["preID"]."' class='filled-in' />".
							"<span>".$row["name"]."</span></label></div>";
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
	<div align="right" style="position:fixed;top:80px;right:25px"><a href="exportData.php" ><img src="images/Excel-2-icon.png" width="40px" height="40px"/></a></div>
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
.dropdown-content{
	max-height:350px;
}
/**/

#body {
	padding-left: 330px;
	padding-bottom: 50px;
}
@media only screen and (max-width : 992px) {
	#body{
		padding-left: 0;
	}
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
	width: 95px;
}
.topPadding{
	padding-top: 50px;
}
#slide-out{
	width: 300px !important;
	top: 50px !important;
}
.sortButton:hover{
	background-color: #FF8C18!important;
}
.collapsible-header {
	border-bottom-color: #D3D3D3!important;
	border-bottom-style: solid!important;
	border-bottom-width: 1px!important;
}

#arrowForTests {
	padding-left: 150px;
}
#arrowForResults {
	padding-left: 82px;
}
#arrowForIndividualResults {
	padding-left: 40px;
}
#arrowForLocation{
	padding-left: 75px;
}
#arrowForGroup{
	padding-left: 92px;
}
#arrowForGender{
	padding-left: 84px;
}
#arrowForAge{
	padding-left: 109px;
}
</style>
</html>
