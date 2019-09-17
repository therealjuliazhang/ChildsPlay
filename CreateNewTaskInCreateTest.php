<?php
	session_start();
	include 'db_connection.php';
	$conn = OpenCon();
			//get user ID
			// if(isset($_SESSION['userID']))
			// 	$userID = $_SESSION['userID'];
			// else
			// 	header('login.php');
	$userID = 1; //remove after admin pages are linked up
			//get test ID
			// if(isset($_GET['testID']))
			// 	$testID = $_GET['testID'];
	$testID = 2; //remove after admin pages are linked up
			//get user image directory
			$imageDirectory = "C:\xampp\htdocs\images";
	$from = "create";
	
	//$exist = false;
	if(isset($_GET["taskID"])){
		$taskID = $_GET["taskID"];
		$query = "SELECT instruction, activityStyle, address FROM TASK T JOIN IMAGEASSIGNMENT IA ON T.taskID = IA.taskID".
				" JOIN IMAGE I ON IA.imageID = I.imageID WHERE T.taskID = $taskID";
		$result = $conn->query($query);
		while($row = mysqli_fetch_assoc($result)){
			$instruction = $row["instruction"];
			$activityStyle = $row["activityStyle"];
			$imageAddress = $row["address"];
			//$exist = true;
		}
	}
	if(isset($_GET["exist"]))
		$exist = $_GET["exist"];
	else
		$exist = false;
?>
<html>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="uploadImage.js"></script>
		<script>
		//go back to the previous page when Cancel button is clicked
		function goBack(){
			var from = <?php echo json_encode($from);?>;
			var exist = <?php echo json_encode($exist);?>;
			if(exist)
				window.location = "filterExistingQuestions.php";
			else if(from == "create")
				window.location = "createTest.php";
			else
				window.location = "editTest.php";
		}
		
		function createNewTask(){
			var imageAddress = $("#imageAddress").val();
			var instruction = $("#instruction").val();
			var activityStyle = $("#activityStyle option:selected").val();
			var testID = <?php echo json_encode($testID);?>;
			var from = <?php echo json_encode($from);?>;
			var div = document.getElementById("results");
			var exist = <?php echo json_encode($exist);?>;
			
			if(imageAddress == ""){
				div.style.color = "red";
				div.style.fontStyle = "italic";
				div.innerHTML = "Please select image(s) to upload!";
			}
			else{
				$.post("createTask.php", 
					{	imageAddress: imageAddress,
						instruction: instruction,
						activityStyle: activityStyle,
						testID: testID
					},
					function(data){
						if(data.includes("span")){
							//errors = data;
							$("#results").html(data);
						}
						else{
							taskID = data;
							$("#results").html(data);
							//redirect back to page
							if(from == "edit")
								window.location = "editTest.php?testID=" + testID;
							else if(from == "create")
								window.location = "createTest.php?taskID=" + taskID;
							if(exist == true)
								window.location = "filterExistingQuestions.php";
						}	
					}
				);
			}
		}
		</script>
	</head>
    <body>
	<?php
	//(isset($_POST["activityStyle"])) ? $activityStyle = $_POST["activityStyle"] : $activityStyle = 1;
	?>
        <!--header-->
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li class="active"><a href="">Create</a></li>
                            <li><a href="">Users</a></li>
                        </ul>
                        <ul id="logoutButton" class="right hide-on-med-and-down logout">
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="">Profile</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--end header-->
        <!-- body content -->
        <div id="body" class="container">
			<!--start form-->
            <form action="" method="post">
                <div class="row">
                    <div class="col s6">
                    <h5 class="blue-text darken-2 header">
                        <a class="tooltipped" data-position="left" data-tooltip="Choose activity style from list">
                            <i class="material-icons">help_outline</i>
                        </a>
                        Activity Style:
                    </h5>
                    </div>
                    <div class="col s6">
                        <h5 class="blue-text darken-2 header">
                            <a class="tooltipped" data-position="left" data-tooltip="Activity for Task">
                                <i class="material-icons">help_outline</i>
                            </a>
                            Instruction
                        </h5>
                    </div>
                </div>
				<div class="row">
					<div class="input-field col s6">
						<select name="activityStyle" id="activityStyle" onchange="loadContent()">
						<?php echo "Style: ".$activityStyle;?>
							<option <?php if(isset($activityStyle)) if($activityStyle == "Identify Body Part") echo "selected";?> value="Identify Body Part">Identify Body Part</option>
							<option <?php if(isset($activityStyle)) if($activityStyle == "Likert Scale") echo "selected";?> value="Likert Scale">Likert Scale</option>
							<option <?php if(isset($activityStyle)) if($activityStyle == "Character Ranking") echo "selected";?> value="Character Ranking">Character Ranking</option>
							<option <?php if(isset($activityStyle)) if($activityStyle == "Preferred Mechanic") echo "selected";?> value="Preferred Mechanic">Preferred Mechanics</option>
						</select>
					</div>
                    <div class="input-field col s6">
                        <input id="instruction" name="instruction" value="<?php echo isset($instruction) ? $instruction:""; ?>" type="text">
                    </div>
				</div>
				
				<div class="row" id="pointRow">
				<!---
				<h5 class="blue-text darken-2 header">Points system</h5>
                <div class="input-field col s7">
                    <input name="points" id="points" type="number">
                </div>
				--->
				</div>
				
				<h5 class="blue-text darken-2 header">
					<a class="tooltipped" data-position="left" data-tooltip="Click to upload image">
						<i class="material-icons">help_outline</i>
					</a>
					Image
				</h5>
				<div class="row">
					<div class="col s12">
						<!--start upload button + path display-->
						<form action="uploadImage.php" method="post" enctype="multipart/form-data">
						<div class="file-field input-field">
							<div id="imgUpload" class="waves-effect waves-light btn blue darken-4">
							<span>Upload</span>
							<input id="file" type="file" name="file" />
							</div>
							<div class="file-path-wrapper" id="upload">
								<input class="file-path validate" type="text" name="imageFileName" id="imageAddress"
								value="<?php if(isset($imageAddress)){ 
												$image = explode("/",$imageAddress); 
												echo $image[1];
											}	
								?>" webkitdirectory directory multiple/>
								
							</div>
						</div>
						</form>
						<!--end upload button + path-->
					</div>
				</div>
				<!--Placeholder to display uploaded image(s)--->
				<div id="imageUpload"></div>
				<div class="row">
					<div class="col s12">
						<p align="right">
							<button name="createTaskBtn" id="submitBtn" class="submit waves-effect waves-light btn blue darken-2" onclick="createNewTask();">Create Task</button>
							<button class="waves-effect waves-light btn blue darken-4" type="submit" onclick="goBack();">Cancel</button>
						</p>
					</div>
					
				</div>
				<div class="row">
					<div id="results"></div>
				</div>
			</form>
			<!--end form-->
		</div>
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
    .nav-wrapper > ul {
        margin-left: 220px;
    }
    .header{
        margin-top: 30px;
    }
    .image{
        margin-top: 10px;
    }
    </style>
</html>