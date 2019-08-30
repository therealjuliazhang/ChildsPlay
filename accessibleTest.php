<html>
    <?php
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
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()"> <i class="material-icons" id="profileIcon">account_box</i></a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--end header-->
        <!-- body content -->
        <h5 class="blue-text darken-2 header">Tests accessible to <span id="fullName"></span></h5>
		<div id="testsAccessible">
			<table class="highlight centered">
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Description</th>
							<th>Conducted</th>
                            <!-- <th>Results</th> -->
							<th>Remove</th>
						</tr>
					</thead>
					<tbody id="testsTableBody" class="grey-text text-darken-1">
              <!-- <tr>
              <td>Test 1</td>
              <td>Testing of the new set of monsters with updated eye colours</td>
              <td>11/04/19</td>
			  <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Results</a></td>
              <td><a class="waves-effect waves-light btn #0d47a1 red darken-1">Remove</a></td>
            </tr>
            <tr>
              <td>Test 2</td>
              <td>Test for the updated monsters for the early start day care centre</td>
              <td>12/04/19</td>
			  <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Results</a></td>
              <td><a class="waves-effect waves-light btn #0d47a1 red darken-1">Remove</a></td>
            </tr>
            <tr>
              <td>Test 3</td>
              <td>Ranking test of the old monsters with the updated monsters</td>
              <td>11/04/19</td>
			  <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Results</a></td>
              <td><a class="waves-effect waves-light btn #0d47a1 red darken-1">Remove</a></td>
            </tr> -->
			<!-- <tr>
              <td></td>
              <td></td>
              <td></td>
			  <td></td>
              <td><a href="" class="waves-effect waves-light btn blue darken-2">Add Test</a></td>
            </tr>
		
			<tr>
              <td></td>
              <td></td>
              <td></td>
			  <td></td>
              <td><a href="" class="waves-effect waves-light btn blue darken-4">Cancel</a></td>
            </tr> -->
			</tbody>
		</table>
	</div>
        <!--end body content-->
    </body>
<script>
//remove a declined row
$('.declineButton').click(function() {
  $(this).closest('tr').remove();
});
//remove an accepted row
$('.acceptButton').click(function() {
  $(this).closest('tr').remove();
});
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
            $('<td/>', {
                text: collected
            }),
            $('<td/>').append(
                $('<a/>', {
                    class: "waves-effect waves-light btn #0d47a1 red darken-1",
                    text: "Remove"
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
    </style>
</html>
