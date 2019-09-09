<!DOCTYPE html>

<html>
    <?php
        $baseURL = "localhost";
        include 'db_connection.php';
        $conn = OpenCon();
        session_start();
        //$userID = $_SESSION['userID'];
        $userID = 2; //remove this after admin pages are linked up
        //get user's fullname from database
        $sql = "SELECT fullName FROM USERS WHERE userID=".$userID;
        $result = $conn->query($sql);
        $fullName = mysqli_fetch_assoc($result)['fullName'];
        //get user's tests
        $tests = array();
        $sql = "SELECT testID, dateConducted FROM TESTASSIGNMENT WHERE userID=".$userID;
        $testIDsResult = $conn->query($sql);
        while($row = mysqli_fetch_assoc($testIDsResult)){
            $sql = "SELECT * FROM TEST WHERE testID=".$row['testID'];
            $testsResult = $conn->query($sql);
            while($value = mysqli_fetch_assoc($testsResult)){
                $dateConducted = $row['dateConducted'];
                array_push($value, $dateConducted);
                $tests[] = $value;
            }
        }
    ?>
    <head>
        <title>Accessible Test</title>
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
	<div class="container">
        <h5 class="blue-text darken-2 header">Tests accessible to <span id="fullName"></span></h5>
		<div id="testsAccessible">
			<table class="highlight centered">
                <thead class="blue-text darken-2">
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Conducted</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody id="testsTableBody" class="grey-text text-darken-1">
                </tbody>
            </table>
            <a id="addTest" class="right waves-effect waves-light btn blue darken-4" href="selectAccessibleTest.php">Add Test</a>
        </div>
	</div>
        <!--end body content-->
    </body>
<script>
$(document).ready(function() {
    //display users name
    var fullName = <?php echo json_encode($fullName); ?>;
    $("#fullName").html(fullName);
    //display users accessible tests in table
    var tests = <?php echo json_encode($tests); ?>;
    tests.forEach(function displayTest(test){
        var collected;
        //get date collected
        if(test['0'] == null)
            collected = "Not yet conducted."
        else
            collected = test['0'];
        $('<tr/>').append([
            $('<td/>', { text: test.title }),
            $('<td/>', { text: test.description }),
            $('<td/>', { text: collected }),
            $('<td/>').append(
                $('<a/>', {
                    class: "waves-effect waves-light btn #0d47a1 red darken-1 remove",
                    text: "Remove",
                    href: "removeAccessibleTest.php?testID=" + test.testID,
                    onclick: "javascript: return confirm('Are you sure you wish to make the test inaccessible to this user?');"
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
    #addTest{
        margin-top:20px;
        margin-right:55px;
    }
    </style>
</html>
