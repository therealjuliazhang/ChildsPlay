<html>
    <?php
        //get user ID
        // session_start();
        // if(isset($_SESSION['userID']))
        // 	$userID = $_SESSION['userID'];
        // else
        // 	header('login.php');
        $userID = 1; //remove after admin pages are linked up
        //get test ID
        // if(isset($_GET['testID']))
        // 	$testID = $_GET['testID'];
        $testID = 2; //remove after admin pages are linked up
        //connect to database
        include 'db_connection.php';
        $conn = OpenCon();
        //get test name from database
        $sql = "SELECT title FROM TEST WHERE testID=".$testID;
        $result = $conn->query($sql);
        $testTitle = mysqli_fetch_assoc($result)['title'];
        //get tasks
        $tasks = array();
        $sql = "SELECT taskID FROM TASKASSIGNMENT WHERE testID=".$testID;
        $taskIDsResult = $conn->query($sql);
        while($row = mysqli_fetch_assoc($taskIDsResult)){
			$sql = "SELECT * FROM TASK WHERE taskID=".$row["taskID"];
			$result = $conn->query($sql);
			while($value = mysqli_fetch_assoc($result))
				$tasks[] = $value;
		}
    ?>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        <script>
            var testTitle = <?php echo json_encode($testTitle); ?>;
            var tasks = <?php echo json_encode($tasks); ?>;
            var testID = <?php echo json_encode($testID); ?>;
            $(document).ready(function() {
                //display test name
                $("#testTitle").html(testTitle);
                //display tasks
                displayTasks();
            });
            //display all tasks
            function displayTasks(){
                //create table row for each task
                tasks.forEach(function displaytask(task){
                    //get preview link for task
                    var previewURL;
                    switch(task.taskType){
                        case "Likert Scale":
                            previewURL = "likertScaleTask.php?from=edit&taskID=" + task.taskID;
                            break;
                        case "Identify Body Parts":
                            previewURL = "identifyBodyPartsTask.php?from=edit&taskID=" + task.taskID;
                            break;
                        case "Character Ranking":
                            previewURL = "characterRankingTask.php?from=edit&taskID=" + task.taskID;
                            break;
                        case "Preferred Mechanics":
                            previewURL = "preferredMechanicsTask.php?from=edit&taskID=" + task.taskID;
                            break;
                    }
                    $('<tr/>').append([
                        $('<td/>', { text: task.title }),
                        $('<td/>', { text: task.taskType }),
                        $('<td/>', { text: task.activity }),
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
                                href: "EditTaskInEditTest.php"
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
        <div class="row">
            <div class="navbar-fixed">
                <nav class="nav-extended blue darken-4">
                    <div class="nav-wrapper">
                        <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                            <li><a href="">Tests</a></li>
                            <li><a href="">Create</a></li>
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
        <div class="container">
            <h5><div class="blueText">Edit <span id="testTitle"></span></div></h5>
            <table class="striped">
                <thead>
                    <tr class="blueText">
                        <td>Title&nbsp;&nbsp;</td>
                        <td>Task Type</td>
                        <td>Activity</td>
                        <td>Preview</td>
                        <td>Edit</td>
                        <td>Remove</td>
                    </tr>
                </thead>
                <tbody id="tableBody">
                </tbody>
            </table>
            <br/>
            <div align="right">
                <ul id = "dropdown" class = "dropdown-content">
                    <li><a href = "EditExistingTaskInEditTest.php">Existing Tasks</a></li>
                    <li><a href = "CreateNewTaskInEditTest.php">Create New Task</a></li>
                </ul>
                <a class = "btn dropdown-button blue darken-4" href = "#" data-activates = "dropdown">
                    <i class="large material-icons">add</i>
                </a>
            </div>
            <br/><br/><br/>
            <p align="right">
                <a href = "ViewExistingTests.php" class="waves-effect waves-light btn blue darken-2">Confirm</a>
            </p>
        </div>
        <!--end body content-->
    </body>
    <style>
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
    .blueText
    {
        color:#1976D2;
    }
    </style>
</html>
