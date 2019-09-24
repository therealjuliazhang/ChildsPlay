<!DOCTYPE html>
<html>
    <head>
		<?php
		session_start();
		include 'db_connection.php';
		$conn = OpenCon();
		//get user ID
		if(isset($_SESSION['userID']))
			$userID = $_SESSION['userID'];
		else
			header('login.php');
			// $userID = 1; //remove after admin pages are linked up
		//get test ID
		if(isset($_GET['testID']))
		 	$testID = $_GET['testID'];
		//$testID = 2; //remove after admin pages are linked up
		$from = "";	
		
		if(isset($_GET["from"]))
			$from = $_GET["from"];
		//get the orderInTest of a task
		if(isset($_GET["index"])){
			$index = $_GET["index"]; 
		}
		//retrieve task data in Edit Test
		$imageAddresses = array();
		if(isset($_GET["taskID"])){
			$taskID = $_GET["taskID"];
			$query = "SELECT taskTitle, instruction, activityStyle, address, pointsInterval FROM TASK T JOIN IMAGEASSIGNMENT IA ON T.taskID = IA.taskID".
					" JOIN IMAGE I ON IA.imageID = I.imageID JOIN TASKASSIGNMENT TA ON TA.taskID = T.taskID WHERE T.taskID = $taskID";
			$result = $conn->query($query);
			while($row = mysqli_fetch_assoc($result)){
				$taskTitle = $row["taskTitle"];
				$instruction = $row["instruction"];
				$activityStyle = $row["activityStyle"];
				array_push($imageAddresses, $row["address"]);
				$pointsInterval = $row["pointsInterval"];
			}
		}
		?>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
		<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons" />
		<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
		<script src="uploadImage.js"></script>
		<script>
		function createNewTask(){
			var imageAddress = $("#imageAddress").val();
			var instruction = $("#instruction").val();
			var activityStyle = $("#activityStyle option:selected").val();
			
			var pointsInterval = 0;
			if(activityStyle == "Character Ranking")
				pointsInterval = $("#points").val();
			
			var testID = <?php if(isset($testID))
								$testID = $testID;
							  else $testID = 0;
					       	echo json_encode($testID);?>;
			var from = <?php echo json_encode($from);?>;
			var orderInTest = <?php if(isset($index))
								$index = $index;
							  else $index = 0;
					       	echo json_encode($index);?>;
			var div = document.getElementById("results");
			
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
						testID: testID,
						orderInTest: orderInTest,
						pointsInterval: pointsInterval
					},
					function(data){
						//show errors
						if(data.includes("span")){
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
							/*if(exist == true)
								window.location = "filterExistingTasks.php";*/
						}	
					}
				);
			}
		}
	/**/
		function selectActivityStyle(){
			var pointsInterval = 0;
			var activityStyle = <?php 
			if(isset($activityStyle))
				echo json_encode($activityStyle);
			else
				echo json_encode("");  ?>;
			if((activityStyle) == "Character Ranking"){
				pointsInterval = <?php if(isset($pointsInterval)) 
										echo json_encode($pointsInterval);
									else
										echo json_encode(0);
								?>;
			}
			var selected = $("#activityStyle option:selected").val();
			$.post("selectOption.php", {option_value: selected},
				function(data){
					var input = document.getElementById("file");
					var upload = document.getElementById("upload");
					var noti = document.createElement("label");
					if(data == "Character Ranking"){
						input.setAttribute("name", "files[]");
						input.setAttribute("multiple", "multiple");
						//create the points input when user selects Character Ranking activity style
						var header = document.createElement("h5");
						header.setAttribute("class", "blue-text darken-2 header");
						header.innerHTML = "Points interval";
						var div = document.createElement("div");
						div.setAttribute("class", "input-field col s7");
						var pointInput = document.createElement("input");
						pointInput.setAttribute("id", "points");
						pointInput.setAttribute("name", "points");
						pointInput.setAttribute("type", "number");
						pointInput.setAttribute("value", pointsInterval);
						div.appendChild(pointInput);
						var wrapper = document.getElementById("pointRow");
						wrapper.appendChild(header);
						wrapper.appendChild(div);
						
						//delete the previous label
						upload.removeChild(upload.lastChild);
						//add the label telling user that they can upload multiple images for Character Ranking task
						noti.innerHTML = "You can upload multiple images for Character Ranking activity style";
						upload.appendChild(noti);
					}
					else{
						input.setAttribute("name", "file");
						input.removeAttribute("multiple");
						//delete the previous label
						upload.removeChild(upload.lastChild);
						//add the label telling user that they can only upload one image for other tasks
						noti.innerHTML = "Please select one image to upload";
						upload.appendChild(noti);
						//delete the point input for other tasks
						var contents = document.getElementById("pointRow");
						while (contents.hasChildNodes()) {
							contents.removeChild(contents.lastChild);
						}
					}
				}
			);
		}
		</script>
	</head>
    <body>
	<?php
	//(isset($_POST["activityStyle"])) ? $activityStyle = $_POST["activityStyle"] : $activityStyle = 1;
	?>
        <!--header-->
        <div id="InsertHeader"></div>
        <script>
          //Read header
          $(function(){
            $("#InsertHeader").load("header.html");
          });
        </script>
        <!--end header-->
        <!-- body content -->
        <div id="body" class="container">
			<!--start form-->
            <form action="" method="post">	
				<div class="row">
                    <div class="col s6">
						<h5 class="blue-text darken-2 header">
							<a class="tooltipped" data-position="left" data-tooltip="Enter the task title">
								<i class="material-icons">help_outline</i>
							</a>
							Task Title:
						</h5>
						<div class="input-field">
							<input id="title" name="title" type="text" value=<?php echo isset($taskTitle) ? $taskTitle:"";?>>
						</div>
                    </div>
                    <div class="col s6">
                        <h5 class="blue-text darken-2 header">
                            <a class="tooltipped" data-position="left" data-tooltip="Activity for Task">
                                <i class="material-icons">help_outline</i>
                            </a>
                           Activity Style:
                        </h5>
						<div class="input-field">
							<select name="activityStyle" id="activityStyle" onchange="loadContent()">
							<?php echo "Style: ".$activityStyle;?>
							<option <?php if(isset($activityStyle)){ if($activityStyle == "Identify Body Part") echo "selected";}?> value="Identify Body Part">Identify Body Part</option>
							<option <?php if(isset($activityStyle)){ if($activityStyle == "Likert Scale") echo "selected";}?> value="Likert Scale">Likert Scale</option>
							<option <?php if(isset($activityStyle)){ if($activityStyle == "Character Ranking") echo "selected";}?> value="Character Ranking">Character Ranking</option>
							<option <?php if(isset($activityStyle)) if($activityStyle == "Preferred Mechanics") echo "selected";?> value="Preferred Mechanics">Preferred Mechanics</option>
							</select>
						</div>
                    </div>
				</div>
                <div class="row">   
                    <h5 class="blue-text darken-2 header">
                        <a class="tooltipped" data-position="left" data-tooltip="Activity for Task">
                            <i class="material-icons">help_outline</i>
                        </a>
                        Instruction
                    </h5>
					<div class="input-field col s12">
						<input id="instruction" name="instruction" value="<?php echo isset($instruction) ? $instruction:""; ?>" type="text" />
					</div>
                </div>
				<div class="col s12" id="pointRow"></div>
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
								value="<?php 
								$index = 0;
								if(count($imageAddresses) > 0){
									foreach($imageAddresses as $imageAddress){
										$image = explode("/",$imageAddress); 
										echo $image[1];
										if($index < count($imageAddresses) - 1)
											echo ", ";
										$index++;
									}
								}	
								?>" webkitdirectory directory multiple/>
								
							</div>
						</div>
						</form>
						<!--end upload button + path-->
					</div>
				</div>
				<!--Place to display uploaded image(s)--->
				<div id="imageUpload"></div>
				<div class="row">
					<div class="col s12">
						<p align="right">
							<button name="createTaskBtn" id="submitBtn" class="submit waves-effect waves-light btn blue darken-2" onclick="createNewTask();">Create Task</button>
							<a class="waves-effect waves-light btn blue darken-4" onClick="javascript:history.go(-1)">Cancel</a>
						</p>
					</div>
				</div>
				<div id="results"></div>
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
