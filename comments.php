<!DOCTYPE html>

<html>
	<?php
	$testID = $_GET["testID"];
	$groupID = $_GET["groupID"];
	$taskIndex = $_GET['taskIndex'];
	//fetch task
	$testQuery = "SELECT * FROM TASK WHERE testID=" . $testID;
	include 'db_connection.php';
	$conn = OpenCon();
	$result = $conn->query($testQuery);
	$tasks = array();
	while($row = mysqli_fetch_assoc($result))
		$tasks[] = $row;
	$taskID = $tasks[$taskIndex]['taskID'];
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
				<form class="col s12" method="POST" action="<?php $_PHP_SELF ?>">
				  <div class="row">
					<div class="input-field col s12">
					  <textarea id="textarea1" name="area1" class="materialize-textarea"></textarea>
					  <label for="textarea1">Comments</label>
					</div>
				  </div>
				<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.

session_start();

$conn = OpenCon();
$link = mysqli_connect("localhost", "root", "", "test");

if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$id = $_REQUEST["testID"];

if(isset($_POST['nextButton'])){
	function processText($text) {
		$text = strip_tags($text);
		$text = trim($text);
		$text = htmlspecialchars($text);
		return $text;
	}
	$comment = processText($_POST['area1']);
	if($comment != ""){
		$sql = "UPDATE task SET comments = '". $comment ."' WHERE testID = ".$id." AND comments IS NULL";
		if(mysqli_query($link, $sql)){
		header("Location: index.php");
		} else{
			echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
		}
	} else{
		echo "<span id='error'>Please write a comment!</span>";
	}
}

if(isset($_POST['backButton'])){
	header("Location: task.php?testID=".$id);
}
    CloseCon($conn);
?>
			<div class="row">
				<div class="col s12">
					<div class="right-align">
						<button type="button" class="waves-effect waves-light btn blue darken-2" name="button1" onclick="next();">Next</button>
						<!--<a class="waves-effect waves-light btn blue darken-4" name="button2">Back</a>-->
					</div>
				</div>
			</div>
			</form>
			</div>
        </div>
        
        <!--end body content-->
        
    </body>
	<script>
		function printComment(){
			/*var comment = document.getElementById("textarea1").innerText;
			console.log("This is the comment: " + comment);*/
			var comment = $.trim($("#textarea1").val());
			if(comment != ""){
				alert(comment);
			}
		}
		function next(){
			var taskIndex = <?php echo $taskIndex; ?>;
			var tasks = <?php echo json_encode($tasks); ?>;
			if(taskIndex == tasks.length-1)
				window.location.href = "thankyou.php";
			else{
				var testID = <?php echo $testID; ?>;
				var groupID = <?php echo $groupID; ?>;
				taskIndex++;
				window.location.href = "instruction.php?" + "testID=" + testID + "&groupID=" + groupID + "&taskIndex=" + taskIndex;
				/*var info = "testID=" + testID + "&groupID=" + groupID + "&taskIndex=" + taskIndex;
				switch(tasks[taskIndex]["taskType"]){
					case "Likert Scale":
						window.location.href = "likertScaleTask.php?" + info;
						break;
					case "Identify Body Parts": 
						window.location.href = "identifyBodyPartsTask.php?" + info;
						break;
					case "Character Ranking":
						window.location.href = "characterRankingTask.php?" + info;
						break;
					case "Drag and Drop":
						window.location.href = "dragAndDropTask.php?" + info;
						break;
				}*/
			}
		}
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
