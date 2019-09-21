<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Child'sPlay</title>
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
    <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
</head>
<body>
    <!--header-->
    <div id="InsertHeader"></div>
    <script>
        //Read header
        $(function() {
            document.addEventListener('DOMContentLoaded', function() {
                var elem = document.querySelectorAll('.tooltipped');
                var instance = M.Tooltip.init(elem);
            });
            $("#InsertHeader").load("header.html");
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
                            type: "post"
                        }
                    },
                    description: "required"
                },
                messages: {
                    testTitle: {
                        required: "Enter a test title.",
                        remote: jQuery.validator.format("{0} is already used by an existing test.")
                    },
                    description: "Enter a description for the test."
                }
            });
        });
    </script>
    <!-- body content -->
    <div class="container">
        <form id="form" action="insertTest.php" method="post" class="col s12">
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="Title of Test">
                    <i class="material-icons">help_outline</i>
                </a>Test Title
            </h5>
            <div class="row">
                <div class="input-field col s12">
                    <input class="validate" placeholder="Enter a test title." id="testTitle" name="testTitle" type="text">
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
                    <input class="validate" placeholder="Enter a description for test." id="description" name="description" type="text">
                    <label for="description"></label>
                </div>
            </div>
            <h5 class="blue-text darken-2 header">
                <a class="tooltipped" data-position="left" data-tooltip="List of tasks in test">
                    <i class="material-icons">help_outline</i>
                </a>
                Tasks
            </h5>
            <table class="striped" id="taskTable">
                <thead>
                    <tr class="blueText">
                        <td>TaskID&nbsp;&nbsp;</td>
                        <td>Activity Style</td>
                        <td>Instruction</td>
                        <td>Preview</td>
                        <td>Remove</td>
                    </tr>
                </thead>
                <!--List of tasks--->
                <tbody>
                    <?php
                    /*
					author: Phuong Linh Bui (5624095)
					*/
                    include 'db_connection.php';
                    $conn = OpenCon();
                    $taskList = array();
                    $idList = array();

                    //session_destroy();
                    //unset($_GET["list"]);

                    //get a list of newly created tasks and store it in SESSION
                    if (isset($_GET["taskID"])) {
                        $taskID = $_GET["taskID"];
                        if (!isset($_SESSION["list"])) {
                            $_SESSION["list"] = $taskID;
                            array_push($idList, $taskID);
                        } else {
                            $taskList = explode(",", $_SESSION["list"]);
                            if (!in_array($taskID, $taskList)) {
                                $_SESSION["list"] .= "," . $taskID;
                            }
                            $idList = explode(",", $_SESSION["list"]);
                        }
                        if (isset($_GET["remove"])) {
                            $taskID = $_GET["taskID"];
							//remove the selected task from the list
                            if (($key = array_search($taskID, $idList)) !== false) {
                                unset($idList[$key]);
                                if (count($idList) > 0)
                                    $_SESSION["list"] = join(",", $idList);
                                else {
                                    session_destroy();
                                    unset($_SESSION["list"]);
                                }
                            }
                        }
                    }
                    //display the newly created task(s) into the list of tasks
                    if (count($idList) > 0) {
                        foreach ($idList as $id) {
                            $query = "SELECT * FROM TASK WHERE taskID=$id";
                            $result = $conn->query($query);
                            $row = mysqli_fetch_assoc($result);
                            echo "<tr><td>" . $row["taskID"] . "</td>" .
                                "<td>" . $row["activityStyle"] . "</td>" .
                                "<td>" . $row["instruction"] . "</td>" .
                                "<td><a class='waves-effect waves-light btn blue darken-2'>Preview</a></td>" .
                                "<td><a class='waves-effect waves-light btn blue darken-4' href='?taskID=" . $row["taskID"] . "&remove=true'>Remove</a></td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
            <div align="right">
                <ul id = "dropdown" class = "dropdown-content">
                    <li><a href="filterExistingTasks.php">Existing Tasks</a></li>
                    <li><a href="createNewTaskInCreateTest.php?from=create">Create New Task</a></li>
                </ul>
                <a class="btn dropdown-button blue darken-4" href="" data-activates="dropdown">
                    <i class="large material-icons">add</i>
                </a>
            </div>
            <p align="right">
                <!-- <button type="submit" name="createTest" class="waves-effect waves-light btn blue darken-2">Create Test</button> -->
                <input type="submit" name="submit" class="submit waves-effect waves-light btn blue darken-2 right" value="Create Test">
                <a class="waves-effect waves-light btn blue darken-4 right" onClick="javascript:history.go(-1)">Cancel</a>
            </p>
        </form>
    </div>
    <!--end body content-->
</body>
<script>

</script>

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
    /*for error label*/
    label[data-error] {
        width: 100%;
        font-size: 12px;
    }
    .invalid {
        font-size: 12px;
        color: #EC453C;
    }
</style>

</html>
