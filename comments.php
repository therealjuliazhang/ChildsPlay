<!--
=======================================================================================
Title:Comments;
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
=======================================================================================
-->
<!DOCTYPE html>
<html>
	<?php
	session_start();
	include 'db_connection.php';
	$conn = OpenCon();
	if(isset($_SESSION["userID"]))
		$userID = $_SESSION["userID"];
	else
		header('Location: login.php');
	if(isset($_SESSION['groupID']))
		$groupID = $_SESSION['groupID'];
	if(isset($_SESSION['testID']))
		$testID = $_SESSION['testID'];

	if(isset($_GET["taskIndex"]))
		$taskIndex = $_GET['taskIndex'];

	if(isset($_SESSION['tasks'])){
		$tasks = $_SESSION['tasks'];
		$taskID = $tasks[$taskIndex]['taskID'];
	}
	if(isset($_SESSION["testID"]))
		$testID = $_SESSION['testID'];


	if(isset($_SESSION["taskID"]))
		$taskID = $_SESSION["taskID"];

	if(isset($_GET["from"])){
		$from = $_GET["from"];
		$_SESSION["from"] = $from;
	}
	else{
		if(isset($_SESSION['from']))
			$from = $_SESSION['from'];
	}
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
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
				<div id="InsertHeader"></div>
				<script>
				//Read header
				$(function(){
					$("#InsertHeader").load("testingHeader.html");
				});
				</script>
        <!--end header-->

        <!-- body content -->
        <div class="container content">
			<div class="row">
				<div class="col s12">
					<h4 class="blue-text text-darken-4">Any Comments?</h4>
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
						<button type="submit" class="waves-effect waves-light btn blue darken-4" name="nextButton" ><!--onclick="next();"-->Next</button>
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

if(isset($_POST['nextButton'])){
	function processText($text) {
		$text = strip_tags($text);
		$text = trim($text);
		$text = htmlspecialchars($text);
		return $text;
	}
	$comment = processText($_POST['area1']);
	if($_SESSION["mode"] == "preview"){
		if($taskIndex == (sizeof($tasks)-1)){
			if($from == "existingTasks"){
				if(isset($_SESSION["edit"]))
					header("Location: filterExistingTasks.php?from=edit");
				else if (isset($_SESSION["create"]))
					header("Location: filterExistingTasks.php?from=create");
			}
			else if($from == "availableTests")
				header("Location: viewExistingTests.php");
			else if($from == "edit")
				header("Location: editTest.php");
			else if($from == "create"){
				$url = $_SESSION["createURL"];
				$index = strpos($url,"taskID");
				$para = substr($url, $index);
				header("Location: createTest.php?".$para);
			}
			else
				header("Location: thankyou.php");
		}
		else{
			$taskIndex++;
			header("Location: instruction.php?groupID=".$groupID."&taskIndex=".$taskIndex);
		}
	}
	else{
		if($comment != ""){
			//check if comment already exists for task
			$stmt = $conn->prepare("SELECT comments FROM TASKASSIGNMENT WHERE taskID = ? AND testID = ?");
			$stmt->bind_param("ii", $taskID, $testID);
			$stmt->execute();
			$result = $stmt->get_result();
			$row = $result->fetch_assoc();
			$previousComments = $row['comments'];
			$stmt->close();
			
			if($previousComments != null)
				$comment = $previousComments."\n".$comment;
			else
				$comment = $previousComments.$comment;
			//update comments for the task
			$sql = $conn->prepare("UPDATE TASKASSIGNMENT SET comments = ? WHERE taskID = ? AND testID = ?");
			$sql->bind_param('sii', $comment, $taskID, $testID);
			
			if($sql->execute()){ //check if the query is executed successfully
				if($taskIndex == (sizeof($tasks)-1))
					header("Location: thankyou.php");
				else{
					$taskIndex++;
					header("Location: instruction.php?groupID=".$groupID."&taskIndex=".$taskIndex);
				}
			} else{
				echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
			}
			$sql->close();
		}
		else{
			if($taskIndex == (sizeof($tasks)-1)){
				header("Location: thankyou.php");
			}
			else{
				$taskIndex++;
				header("Location: instruction.php?groupID=".$groupID."&taskIndex=".$taskIndex);
			}
		}
	}
}
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
	#error{
		font-style: italic;
		color: red;
	}
	.btn:hover {
	  background-color: #FF8C18!important;
	}
    </style>
</html>
