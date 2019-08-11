<!DOCTYPE html>

<html>
	<?php
	include 'db_connection.php';
	$conn = OpenCon();
	
	$testID = $_GET["testID"];
	$groupID = $_GET["groupID"];
	$taskIndex = $_GET['taskIndex'];
	//fetch task
	$query = "SELECT taskID FROM TASKASSIGNMENT WHERE testID=".$testID;
	$result = $conn->query($query);

	$tasks = array();
	while($value = mysqli_fetch_assoc($result)){
		$taskQuery = "SELECT * FROM TASK WHERE taskID=".$value["taskID"];
		$result2 = $conn->query($taskQuery);
		while($row = mysqli_fetch_assoc($result2))
			$tasks[] = $row;
	}
	$taskID = $tasks[$taskIndex]['taskID'];
	CloseCon($conn);
	?>
    <head>
        <title>Comments</title>
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
		<meta http-equiv="Pragma" content="no-cache" />
		<meta http-equiv="Expires" content="0" />
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type = "text/javascript" src = "https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<style>
		#error{
			font-style: italic;
			color: red;
		}
		</style>
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

        <div class="container grey-text text-darken-1 content">
			<div class="row">
				<div class="col s12">
					<h5 class="blue-text darken-2">Any Comments?</h5>
					<div style="font-size:18px">
						
						Input any relevant information about anything that occurred during the test task:
					</div>
				</div>
			</div>
			
			<div class="row">
				<form class="col s12" method="POST" action="">
				  <div class="row">
					<div class="input-field col s12">
					  <textarea id="textarea1" name="area1" class="materialize-textarea"></textarea>
					  <label for="textarea1">Comments</label>
					</div>
				  </div>
				  <div class="row">
				<div class="col s12">
					<div class="right-align">
						<button type="submit" class="waves-effect waves-light btn blue darken-2" name="nextButton" ><!--onclick="next();"-->Next</button>
						<!--<button class="waves-effect waves-light btn blue darken-4" name="backButton">Back</button>-->
					</div>
				</div>
			</div>
			</form>
			</div>
        </div>
<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();

$conn = OpenCon();
if(isset($_POST['nextButton'])){
	function processText($text) {
		$text = strip_tags($text);
		$text = trim($text);
		$text = htmlspecialchars($text);
		return $text;
	}
	$comment = processText($_POST['area1']);
	
	if($_SESSION["mode"] == "preview"){
		if($taskIndex == (sizeof($tasks)-1))
				header("Location: thankyou.php");
			else{
				$taskIndex++;
				header("Location: instruction.php?testID=".$testID."&groupID=".$groupID."&taskIndex=".$taskIndex);
			}
	}
	else{
		if($comment != ""){
			$sql = "UPDATE TASKASSIGNMENT SET comments = '". $comment ."' WHERE taskID = ".$taskID." AND testID=".$testID;
			if(mysqli_query($conn,$sql)){ //check if the query is executed successfully
				if($taskIndex == (sizeof($tasks)-1))
					header("Location: thankyou.php");
				else{
					$taskIndex++;
					header("Location: instruction.php?testID=".$testID."&groupID=".$groupID."&taskIndex=".$taskIndex);
				}
			} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
			}
		}
		else
			echo "<span id='error'>Please write a comment!</span>";
	}
}
/*
$taskTypeUrl = $_SESSION["url"];
if(isset($_POST['backButton'])){
	header("Location: ".$taskTypeUrl);
}*/
    CloseCon($conn);
?>
			
        
        <!--end body content-->
        
    </body>
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