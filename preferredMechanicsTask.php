<?php
//get information
session_start();
if(isset($_SESSION["userID"]))
	$userID = $_SESSION["userID"];
else
	$userID = 1;
	//header("Location: login.php");
	
//get mode from session to check if preview mode
if (isset($_SESSION['mode']))
	$mode = $_SESSION['mode'];
else if (isset($_GET["mode"]))
	$mode = $_GET["mode"];

//get testID
if (isset($_SESSION['testID']))
	$testID = $_SESSION['testID'];
if (isset($_SESSION['tasks']))
	$tasks = $_SESSION['tasks'];
//get task index from url
if (isset($_GET['taskIndex']))
	$taskIndex = $_GET['taskIndex'];
	
//the group used for previewing tests
$previewGroupID = 4;
$isPreview = false;
//task id in GET is set if task is being previewed
$from = "";
if (isset($_GET['from']))
	$from = $_GET['from'];

if($mode == "preview"){
	$isPreview = true;
	$groupID = $previewGroupID;
	if (isset($_GET['taskID']))
		$taskID = $_GET['taskID'];
	else
		$taskID = $tasks[$taskIndex]['taskID'];
}
else{ //else if not preview
	$isPreview = false;
	//get group ID
	if (isset($_SESSION['groupID']))
		$groupID = $_SESSION['groupID'];
	$taskID = $tasks[$taskIndex]['taskID'];
}
$_SESSION["taskID"] = $taskID;

include 'db_connection.php';
$conn = OpenCon();
//get task ID
//fetch preschoolers from database
$sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID=".$groupID." AND userID=".$userID;
$result = $conn->query($sql);
$preschoolers = array();
while($row = mysqli_fetch_assoc($result)){
	$sql2 = "SELECT * FROM PRESCHOOLER WHERE preID=".$row["preID"];
	$result2 = $conn->query($sql2);
	while($value = mysqli_fetch_assoc($result2)){
		$preschoolers[] = $value;
	}
}
CloseCon($conn);
?>
<html>
  <head>
    <title>Preferred Mechanics Task</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
    <script>
      //check whether it is in preview mode
      var isPreview = <?php echo(json_encode($isPreview)); ?>;
      var from; //if preview check if from edit page or available test page ect.
      if(isPreview)
        from = <?php echo(json_encode($from)); ?>; // checks from which page preview was opened
      
	  var preschoolers;
      var results = [];
      var preIndex;
	  var testID = <?php echo json_encode($testID); ?>;
      var taskID = <?php echo json_encode($taskID); ?>;
      var taskIndex = <?php echo json_encode($taskIndex); ?>;
      $(document).ready(function(){
        //initialise sidenav
        $('.sidenav').sidenav();
        //get preschoolers
        preschoolers = <?php echo json_encode($preschoolers); ?>;
        //set preschoolers in sidenav tabs
        var firstLi = true;
        preschoolers.forEach(function(preschooler){
          if(firstLi){
            var li = "<li class=\"tab is-active\"><a>" + preschooler.name + "</a></li>";
            firstLi = false;
          }
          else
            var li = "<li class=\"tab\"><a>" + preschooler.name + "</a></li>";
          $("#sidebar").append(li);
        });
        //display active preschoolers name
        var activePreschooler = $("li.is-active").children("a").html();
        $("#nameSpan").html(activePreschooler);
        //Function for switching tabs
        $('.tab').click(function(){
          $('.is-active').removeClass('is-active');
          $(this).addClass('is-active');
          activePreschooler = $("li.is-active").children("a").html();
          $("#nameSpan").html(activePreschooler);
        });
      });
      //save results for preschooler into array
      function save(){
        preIndex = $("li.is-active").index();
        $("[type=checkbox]").each(function(index){
          if(this.checked){
            results.push({preIndex: preIndex});
            switch(index){
              case 0:
                results[results.length-1].mechanic = "Press";
              break;
              case 1:
                results[results.length-1].mechanic = "Zoom/Pinch";
              break;
              case 2:
                results[results.length-1].mechanic = "Swipe/Drag";
              break;
              case 3:
                results[results.length-1].mechanic = "Other";
              break;
            }
          }
        });
		/*var mechanic = results[results.length-1].mechanic;
		var otherComment = "";
			if(mechanic == "Other"){
				otherComment = $("#textarea1").val();
				console.log("Comment: " + otherComment);
			}
			console.log("Check");
		*/
        //end task and submit if last preschooler
        if($("li.is-active").next().length == 0){
          results.forEach(function(result){
            preID = preschoolers[result.preIndex]['preID'];
            var mechanic = result.mechanic;
			var otherComment = "";
				if(mechanic == "Other"){
					otherComment = $("#textarea1").val();
					console.log("Comment: " + otherComment);
				}
			console.log("Check");
			//only save results if in start mode
			if(!isPreview){
				/*$.post("insertMechanicsResults.php", 
					{	mechanic : mechanic,
						taskID : taskID,
						preID : preID,
						testID: testID,
						otherComment : otherComment
					},
					function(data){
						$("#results").html(data);
					});*/
				$.ajax(
					{
					  type: 'POST',
					  url: 'insertMechanicsResults.php',
					  data: { mechanic : mechanic, taskID : taskID, preID : preID, testID: testID, otherComment : otherComment}
					}
				);
			}
          });
		  var taskIndex = <?php echo $taskIndex ?>;
          //if task was preview, go back to previous page
          //if(isPreview)
			  //window.location.href = "comments.php?taskIndex=" + taskIndex + "&from=" + from;
			/*if(from == "edit")
				window.location.href = "editTest.php";
			else if(from == "availableTests")
				window.location.href = "viewExistingTests.php";
			else if (from == "existingTasks")
				window.location.href = "filterExistingQuestions.php";
          }*/
          //else
            //window.location.href = "comments.php?taskIndex=" + taskIndex;
        };
        //go to next preschooler
		var checkboxes = document.querySelectorAll('input[type="checkbox"]');
		
		var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
		if (checkedOne){
			$("li.is-active").next().addClass('is-active');
			$('li.is-active').first().removeClass('is-active');
			activePreschooler = $("li.is-active").children("a").html();
			$("#nameSpan").html(activePreschooler);
			//uncheck boxes
			$('input:checkbox').each(function(){
			  $(this).prop( "checked", false );
			});
		}
      }

		//hide or unhide comment section when 'other' is clicked
		$(document).ready(function(){
			$('#checkBoxOther').click(function(){
				if($(this).prop("checked") == true){
					$(".commentSection").removeClass("hide");
				}
				else if($(this).prop("checked") == false){
					$(".commentSection").addClass("hide");
				}
			});
		});
    </script>
  </head>
<body>
<!--Header-->
    <div class="navbar-fixed">
      <nav class="nav-extended blue darken-4">
        <div class="nav-wrapper">
          <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
        </div>
      </nav>
    </div>
<!--End Header-->
<!--Sidebar-->
  <div>
    <ul id="sidebar" class="sidenav sidenav-fixed #ffffff white tab-group">
    </ul>
  </div>
  <!--End Sidebar-->
  <!--Main content-->
<div class="panel-group">
  <!--Content A (Ren's turn)-->
    <div class="panel is-show">
		<div class="container" id="mainContainer">
			<div class="row">
			<!--1st row-->
			<div class="col s12" id="questionCol"><h5 class="blue-text darken-2">How does <span id="nameSpan"></span> interact with the image?</h5></div>
			<!--2nd row-->
			<form required>
				<div class="col s3 operationCol"><p class="operation">Press:</p></div>
				<div class="col s3 operationCol"><p class="operation">Zoom/Pinch:</p></div>
				<div class="col s3 operationCol"><p class="operation">Swipe/Drag:</p></div>
				<div class="col s3 operationCol"><p class="operation">Other:</P></div>
				<!--3rd row-->
				<form action="#">
					<div class="col s3 operationCol">
						<label>
							<input type="checkbox" />
							<span></span>
						</label>
					</div>
					<div class="col s3 operationCol">
						<label>
							<input type="checkbox" />
							<span></span>
						</label>
					</div>
					<div class="col s3 operationCol">
						<label>
							<input type="checkbox" />
							<span></span>
						</label>
					</div>
					<div class="col s3 operationCol">
						<label>
							<input id="checkBoxOther" type="checkbox" />
							<span></span>
						</label>
					</div>
				</form>
			</form>
			</div>
				<!--Comment Section-->
				<div class="hide commentSection">
					<br/><br/>
					<div class="col s12" id="commentCol"><h6 class="blue-text darken-2">Comment:</h6></div>
					<div class="input-field col s11">
						<textarea id="textarea1" class="materialize-textarea"></textarea>
					</div>
				</div>
		</div>
		<div class="col s12"><a onclick="save()" class="waves-effect waves-light btn blue darken-2 right" id="saveButton">Next</a></div>
        </div>
	</div>
</div>
</body>
<style>
/*CSS for header*/
#body {
padding-left: 330px;
}
@media only screen and (max-width : 992px) {
    #body{
        padding-left: 0;
    }
}
.brand-logo{
    margin-top:-67px;
}
.nav-wrapper > ul {
    margin-left: 220px;
}
.header{
    margin-top: 30px;
}
/*CSS for sidebar*/
#sidebar{
  margin-top: 64px;
}
#submitButton{
  position: fixed;
  bottom: 10px;
  left: 10px;
  z-index: 1000;
  height: 50px;
  width: 280px;
  font-size: 25px;
}
/*CSS for Main content*/
#mainContainer{
  margin-left: 400px;
  margin-top: 80px;
}
.operationCol{
  text-align: center;
}
.operation{
  font-size: 20px;
  margin-right: 100px;
}
#saveButton{
  margin-right: 70px;
  margin-top: 40px;
}
#questionCol{
  height: 70px;
}
#commentCol{

}

.panel{
    display:none;
}
.panel.is-show{
    display:block;
}
.is-active{
  background-color: #eceff1;
}

</style>
</html>
