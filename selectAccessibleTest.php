<!DOCTYPE html>

<html>
    <?php
        //get user ID
        session_start();
        // if(isset($_SESSION['userID']))
        //     $userID = $_SESSION['userID'];
        // else
        //     header('login.php');
        $userID = 2; //remove this after admin pages are linked up
        //open connection to database
        include 'db_connection.php';
        $conn = OpenCon();
        //get tests IDs of tests assigned to user
        $assignedTests = array();
        $sql = "SELECT testID FROM TESTASSIGNMENT WHERE userID=".$userID;
        $testIDsResult = $conn->query($sql);
        while($row = mysqli_fetch_assoc($testIDsResult))
            $assignedTests[] = $row['testID'];
        //get tests not assigned to user
        $availableTests = array();
        $assignedTestsForQuery = join("','",$assignedTests);
        $sql = "SELECT * FROM TEST WHERE testID NOT IN ('$assignedTestsForQuery')";
        $availableTestsResult = $conn->query($sql);
        while($row = mysqli_fetch_assoc($availableTestsResult))
            $availableTests[] = $row;
    ?>
    <head>
        <title>Select Test</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    </head>
    <body>
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
        <h5 class="blue-text darken-2 header">Available Tests</h5>
		<div id="availableTest">
            <table class="highlight centered">
                <thead class="blue-text darken-2">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th>Last Edit</th>
                        <th>Give Access</th>
                    </tr>
                </thead>
                <tbody id="testsTableBody" class="grey-text text-darken-1">
			    </tbody>
            </table>
            <a id="back" href="accessibleTest.php" class="right waves-effect waves-light btn blue darken-4">Back</a>
		</div>
        <!--end body content-->
    </body>
<script>
$(document).ready(function() {
    //display available tests in table
    var tests = <?php echo json_encode($availableTests); ?>;
    tests.forEach(function displayTest(test){
        $('<tr/>').append([
            $('<td/>', { text: test.title }),
            $('<td/>', { text: test.description }),
            $('<td/>', { text: test.dateCreated }),
            $('<td/>', { text: test.dateEdited }),
            $('<td/>').append(
                $('<a/>', {
                    class: "waves-effect waves-light btn #0d47a1 blue darken-2",
                    href: "assignTest.php?testID=" + test.testID,
                    text: "Assign"
                })
            )
        ]).appendTo('#testsTableBody');
    });
});
</script>
    <style>
	#body {
		padding-left: 330px;
		padding-bottom: 50px;
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
	#profileIcon{
		position: absolute;
		top: -14px;
		left: 15px;
	}
    #back{
        margin-top:20px;
        margin-right:55px;
    }
    </style>
</html>
