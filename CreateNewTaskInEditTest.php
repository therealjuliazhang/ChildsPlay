<html>
<?php 
	//check if user logged in
	session_start();
	if(isset($_SESSION['userID']))
		$userID = $_SESSION['userID'];
	else
		header('login.php');
	//get test ID
	if(isset($_GET['testID']))
		$testID = (int)$_GET['testID'];
	
	//check if editing or creating test
    $from = "edit";
    //get test ID
    if(isset($_GET['testID']))
        $testID = $_GET['testID'];
		
$testID=1; //NEED TO REMOVE LATER
	?>
<head>
    <title>Child'sPlay</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="uploadImage.js"></script>
	<script>
	function createNewTask(){
		var imageAddress = $("#imageAddress").val();
		var instruction = $("#instruction").val();
		var selected = $("#activityStyle option:selected").val();
		var activity = $("#taskTitle").val();
		var testID = <?php echo json_encode($testID);?>;
		var from = <?php echo json_encode($from);?>;
		
		$.post("createTask.php", 
			{	imageAddress: imageAddress,
				instruction: instruction,
				activityStyle: selected,
				activity: activity,
				testID: testID
			},
			function(data){
				$("#results").html(data);
			}
		);
		//redirect back to page
		if(from == "edit")
			window.location = "EditTest.php?testID=" + testID;
	}
	</script>
	</head>
    <body>
        <!--header-->
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li><a href="">Create</a></li>
							<li class="active"><a href="">Edit</a></li>
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
			
			<!---<iframe name="votar" style="display:none;"></iframe>---->
            <form method="post" action="">
                <div class="row">
                    <div class="col s6">
                        <h5 class="blue-text darken-2 header">
                            Task Title:
                        </h5>
                    </div>
                    <div class="col s6">
                        <h5 class="blue-text darken-2 header">
                            Activity Style:
                        </h5>
                    </div>
                </div>


				<div class="row">
					<div class="input-field col s6">
						<input id="taskTitle" type="text">
					</div>
                    <div class="input-field col s6">
                        <select name="activityStyle" id="activityStyle" onchange="loadContent()">
                            <option value="Identify Body Part" selected>Identify Body Part</option>
                            <option value="Likert Scale">Likert Scale</option>
                            <option value="Character Ranking">Character Ranking</option>
                            <option value="Preferred Mechanics">Preferred Mechanics</option>
                        </select>
                    </div>
				</div>

				<div class="row">

				</div>
                <div class="row">
                    <h5 class="blue-text darken-2 header col s6">
                        Image
                    </h5>
                    <h5 class="blue-text darken-2 header col s6">
                        Instruction
                    </h5>
                </div>
				<div class="row">
					<div class="col s6">
					<!--start upload button + path display-->
					<form action="uploadImage.php" method="post" enctype="multipart/form-data">
						<div class="file-field input-field">
							<div id="imgUpload" class="waves-effect waves-light btn blue darken-4">
							<span>Upload</span>
							<input id="file" type="file" name="file" />
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text" name="imageFileName" id="imageAddress" webkitdirectory directory multiple/>
							</div>
						</div>
					</form>
						<!--end upload button + path-->
					</div>
					<div class="input-field col s6">
                        <input name="activity" id="instruction" type="text">
                    </div>
				</div>
				<!--Placeholder to display uploaded image(s)--->
				<div id="imageUpload"></div>
				<div class="row">
					<div class="col s12">
						<p align="right">
							<button name="createTaskBtn" id="submitBtn" class="waves-effect waves-light btn blue darken-2" onclick="createNewTask();">Create Task</button>
							<a class="waves-effect waves-light btn blue darken-4">Cancel</a>
						</p>
					</div>
				</div>
				<div id="results"></div>
			</form>
		</div>
		<!--end body content-->
    </body>
    <style>
		.brand-logo{
        position:absolute;
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
