<!DOCTYPE html>
<html>
<?php
 session_start();
if(isset($_SESSION['userID']))
    $userID = $_SESSION['userID'];
else
    header('login.php');
//$userID = 1; //remove after admin pages are linked up
//get test ID
if(isset($_SESSION["testID"]))
	$testID = $_SESSION["testID"];
if(isset($_GET["testID"])){
    $testID = $_GET["testID"];
	$_SESSION["testID"] = $testID;
}	
//connect to database
include 'db_connection.php';
$conn = OpenCon();
//add an existing task to the test
if(isset($_GET["taskID"])){
	$taskID = $_GET["taskID"];
	$sql = "SELECT MAX(orderInTest) AS max FROM TASKASSIGNMENT WHERE testID=".$testID;
	$taskResult = $conn->query($sql);
	while ($row = mysqli_fetch_assoc($taskResult)) {
		$index = $row["max"] + 1;
		$sql = "INSERT INTO TASKASSIGNMENT(testID, taskID, orderInTest) VALUES($testID, $taskID, $index)";
		if(($conn->query($sql) !== TRUE))
			echo "<span style='color:red'>Failed to add record!".mysqli_error($conn)."</span><br/>";
	}
	$_SESSION["orderInTest"] = $index;
}
//get test name and description from database
$sql = "SELECT title, description FROM TEST WHERE testID=" . $testID;
$result = $conn->query($sql);
$test = mysqli_fetch_assoc($result);
//get tasks
$tasks = array();
$sql = "SELECT taskID FROM TASKASSIGNMENT WHERE testID=" . $testID;
$taskIDsResult = $conn->query($sql);
while ($row = mysqli_fetch_assoc($taskIDsResult)) {
    $sql = "SELECT * FROM TASK WHERE taskID=" . $row["taskID"];
    $result = $conn->query($sql);
    while ($value = mysqli_fetch_assoc($result))
        $tasks[] = $value;
}
CloseCon($conn);
?>
<head>
    <title>Child'sPlay</title>
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    <script>
        var test = <?php echo json_encode($test); ?>;
        var tasks = <?php echo json_encode($tasks); ?>;
        var testID = <?php echo json_encode($testID); ?>;
        // document.addEventListener('DOMContentLoaded', function() {
        //     var elems = document.querySelectorAll('.dropdown-trigger');
        //     var instances = M.Dropdown.init(elems);
        // });
        $(document).ready(function() {
            //initialise drop down selector
            $('.dropdown-trigger').dropdown();
            //load header
            $("#InsertHeader").load("header.html");
            //display test name and description
            $("#testTitle").val(test.title);
            $("#description").val(test.description);
            //display tasks
            displayTasks();
            //Places error element next to invalid inputs
            $.validator.setDefaults({
                errorElement: 'div',
                errorClass: 'invalid',
                errorPlacement: function(error, element) {
                    if (element.attr('type') == "text" || element.attr('type') == "number") {
                        $(element)
                            .closest("form")
                            .find("label[for='" + element.attr("id") + "']")
                            .attr('data-error', error.text());
                    }
                }
            })
			
            //validate test title
            $("#form").validate({
                rules: {
					testTitle: {
                        required: true,
							remote: {
							url: "checkTestTitle.php",
							type: "post",
							data: {
								currentTitle: test.title
							}
						}
                    },
                    description: {
						required: true
					},
					remote: {
                        url: "checkTestTitle.php",
                        type: "post",
                        data: {
                            currentTitle: test.title
                        }
                    }
                },
                messages: {
                    testTitle: {
                        required: "Enter a test title.",
                        remote: jQuery.validator.format("{0} is already used by an existing test.")
                    },
					description:{
                        required: "Enter a description."
                    }
                }
            });
        });
        //display all tasks
        function displayTasks() {
            //create table row for each task
            tasks.forEach(function displaytask(task) {
                //get preview link for task
                var previewURL;
				previewURL = "instruction.php?from=edit&mode=preview&taskID=" + task.taskID;
                /*switch (task.activityStyle) {
                    case "Likert Scale":
                        previewURL = "likertScaleTask.php?mode=preview&from=edit&taskID=" + task.taskID;
                        break;
                    case "Identify Body Parts":
                        previewURL = "identifyBodyPartsTask.php?mode=preview&from=edit&taskID=" + task.taskID;
                        break;
                    case "Character Ranking":
                        previewURL = "characterRankingTask.php?mode=preview&from=edit&taskID=" + task.taskID;
                        break;
                    case "Preferred Mechanic":
                        previewURL = "preferredMechanicsTask.php?mode=preview&from=edit&taskID=" + task.taskID;
                        break;
                }*/
                $('<tr/>').append([
                    $('<td/>', {
                        text: task.taskTitle
                    }),
                    $('<td/>', {
                        text: task.activityStyle
                    }),
                    $('<td/>', {
                        text: task.instruction
                    }),
                    $('<td/>').append(
                        $('<a/>', {
                            class: "waves-effect waves-light btn blue darken-2",
                            text: "Preview",
                            href: previewURL
                        })
                    ),
                    $('<td/>').append(
                        $('<a/>', {
                            class: "waves-effect waves-light btn blue darken-4",
                            text: "Edit",
                            //href: "EditTaskInEditTest.php?from=edit&testID=" + testID + "&taskID=" + task.taskID
                            href: "createNewTaskInCreateTest.php?from=edit&testID=" + testID + "&taskID=" + task.taskID
                        })
                    ),
                    $('<td/>').append(
                        $('<a/>', {
                            class: "waves-effect waves-light btn #0d47a1 red darken-1",
                            text: "Remove",
                            href: "removeTask.php?testID=" + testID + "&taskID=" + task.taskID,
                            onclick: "javascript: return confirm('Are you sure you wish to remove this task from this test?');"
                        })
                    )
                ]).appendTo('#tableBody');
            });
        }
    </script>
</head>
<body>
    <!--header-->
    <div id="InsertHeader"></div>
    <!-- body content -->
    <div class="container">
        <form id="form" action="updateTest.php?testID=<?php echo $testID;?>" method="post" class="col s12">
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="Title of Test">
                    <i class="material-icons">help_outline</i>
                </a>Test Title
            </h5>
            <div class="row">
                <div class="input-field col s12">
                    <input class="validate" id="testTitle" name="testTitle" type="text">
                    <label for="testTitle"></label>
                </div>
            </div>
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="Enter description for Task">
                    <i class="material-icons">help_outline</i>
                </a>
                Description
            </h5>
            <div class="row">
                <div class="input-field col s12">
                    <input class="validate" id="description" name="description" type="text">
                    <label for="description"></label>
                </div>
            </div>
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="List of tasks in test">
                    <i class="material-icons">help_outline</i>
                </a>
                Tasks
            </h5>
            <table class="striped">
                <thead>
                    <tr class="blueText">
                        <td>TaskID&nbsp;&nbsp;</td>
                        <td width="20%">Activity Style</td>
                        <td>Instruction</td>
                        <td>Preview</td>
                        <td>Edit</td>
                        <td>Remove</td>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
            <div id="addTaskButton" align="right">
                <a class="dropdown-trigger btn blue darken-4" href='#' data-target="dropdown">
                    <i class="large material-icons">add</i>
                </a>
                <ul id="dropdown" class="dropdown-content">
				    <li><a href='filterExistingTasks.php?from=edit&testID=<?php echo $testID;?>'>Existing Tasks</a></li>
                    <li><a href='createNewTaskInCreateTest.php?from=edit&testID=<?php echo $testID;?>'>Create New Task</a></li>
                </ul>
            </div>
            <!--<div id="comfirmButton">
                <input type="submit" name="submit" class="submit waves-effect waves-light btn blue darken-2 right" value="Save">
            </div>--->
			<br/><br/>
			<div align="left">
			<button name="submit" type="submit" class="submit waves-effect waves-light btn blue darken-2">Save</button>
			</div>
        </form>
    </div>
	<br/><br/>
    <!--end body content-->
</body>
<style>
    #body {
        padding-left: 330px;
    }
    @media only screen and (max-width : 992px) {
        #body {
            padding-left: 0;
        }
    }
    .brand-logo {
        margin-top: -67px;
    }
    .logout {
        margin-top: 15px;
        margin-right: 15px;
    }
    .nav-wrapper>ul {
        margin-left: 220px;
    }
    .header {
        margin-top: 30px;
    }
    .blueText {
        color: #1976D2;
    }
    /* for error label */
    label[data-error] {
        width: 100%;
        font-size: 12px;
    }
    .invalid {
        font-size: 12px;
        color: #EC453C;
    }
    #comfirmButton {
        padding-top: 50px;
        margin-bottom: 100px;
    }
    #addTaskButton {
        padding-top: 10px;
    }
</style>
</html>
