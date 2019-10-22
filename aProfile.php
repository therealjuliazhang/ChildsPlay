<!--
Title:Admin Profile;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Andre Knell (5741622), Ren Sugie(5679527);
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
/*
include 'db_connection.php';
$conn = OpenCon();

session_start();
if(isset($_SESSION['userID']))
  $userID = $_SESSION['userID'];
else
  header('login.php');
*/
//get userinfo from database
$sql = "SELECT * FROM USERS WHERE userID = $userID";
$result = $conn ->query($sql);
$users = mysqli_fetch_assoc($result);

//get location information from database
$sql = "SELECT * FROM LOCATION";
$locationArray = array();
$result = $conn ->query($sql);
while($row = mysqli_fetch_assoc($result))
    $locationArray[] = $row;
?>
<head>
  <title>Profile Page</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>

  
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script src="adminProfile.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>

</head>
<body>
  <!--header-->
  <div id="InsertHeader"></div>
  <script>
  //Read header
  $(document).ready(function(){
    //$(function(){
    $("#InsertHeader").load("header.html");
  });

  function logout(){
	  window.location = "home.html";
  }
  </script>
  <!--Content User Information under the header-->
  <div class="navbar-fixed">
    <table id="infoTable" style="background-color:#FF8C18" height="200px" class="white-text">
      <tbody> <!--class="#1565c0 blue darken-1"-->
	  <form action="" method="post">
        <tr>
          <td width="50%">
            <div class="tableLeft">
              <h3 id="fullNameTop"><?php echo $users["fullName"]; ?></h3>
              <i class="small material-icons" id="mailIcon">email</i>
              <span id="mailInCell"><?php echo $users["email"]; ?></span>
            </div>
          </td>
          <td width="50%">
            <div id="userIconCell">
				<i class="medium material-icons" id="mailIcon">account_box</i>
				<span id="userType">Admin</span><br>
				<!--<a class="waves-effect waves-light btn #2196f3 blue right" id="logoutButton" onclick="logout()">Logout</a>--->
        <button type="submit" name="btnLogout" class="waves-effect waves-light btn blue darken-4 right" style="right:67px;top:18px;position:relative;">Logout</button>
				<?php
				if(isset($_POST["btnLogout"])){
          unset($_SESSION['userID']);
          unset($_SESSION['accountType']);
					header("Location: home.html");
				}
				?>
            </div>
          </td>
        </tr>
		</form>
      </tbody>
    </table>
  </div>

  <!--Side Bar-->
  <ul id="sidebar" class="sidenav sidenav-fixed #ffffff white">
    <li class="tab is-active"><a href="#">Profile</a></li>
    <li class="tab"><a>Location</a></li>
  </ul>
  <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

  <form id="form" method="post" action="">
    <!--Main contents-->
    <div class="panel-group">
      <!--html for profile tab-->
      <div class="panel  is-show">
        <div class="container">
          <div class="row" id="userDetail" style="margin-left:40px">
            <div class="col s12 blue-text text-darken-4"><h4>Account Information</h4></div>
            <div class="col s3 column01"><h6 class="hInCol">Username:</h6></div>
            <div class='input-field col s9'>
                <input id="username" name="username" type="text" class="validate">
            </div>
            <div class="col s3 column01"><h6 class="hInCol">Password:</h6></div>
            <div class='input-field col s9'>
                <input id="password1" name="password1" type="password" class="validate">
            </div>
            <!--Password confirm Section-->
            <div class="hide passwordComfirmationRow">
                <div class="col s3 column01"><h6 class="hInCol">Confirm Password:</h6></div>
                <div class='input-field col s9'>
                    <input id="password2" name="password2" type="password" class="validate">
                </div>
            </div>
            <div class="col s3">
            <a class="waves-effect waves-light btn blue darken-4" id="changeButton">Change password</a>
            </div>
            <div class="col s12 blue-text text-darken-4"><h4>Personal Information</h4></div>
            <div class="col s3 valign-wrapper column01"><h6 class="hInCol">Email:</h6></div>
            <div class='input-field col s9'>
                <input id="email" name="email" type="email" class="validate">
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col s1 offset-s11" id="editButtonDiv"><a class="waves-effect waves-light btn blue darken-4 right" id="editButton">Edit</a></div>
            <div class="col s1 offset-s11 hide" id="saveButtonDiv"><button class="submit waves-effect waves-light btn blue darken-4 right" id="saveButton" type="submit" value="submit">Save</button>
            </div>
          </div>
        </div>
        <div id="results"></div>
      </form>
    </div>

    <!--html for Location tab-->
<form id="form2" method = "post" action="addLocation.php">
<div class="panel">
  <div class="container">
      <div class="row" id="locationInfo" style="margin-left:40px">
        <div class="col s11 blue-text text-darken-4"><h4>Location Names:</h4></div>
     </div>
       <div class="row">
         <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-2 addCell hide right" id="addButtonB" onclick="appendRow()"><i class="material-icons">add</i></a></div>
         <div class="col s1 offset-s10"><a class="waves-effect waves-light btn #2196f3 blue darken-4 right" id="editButtonB">Edit</a></div>
         <div class="col s1"><button class="hide waves-effect waves-light btn blue darken-4 right" id="saveButtonB" type="submit" value = "submit">Save</button></div>
       </div>

    </div>
    </div>
  </div><!--Div for panel group-->
</form>
  </body>

<script>
$("#editButton").click(function(){
  $("#username").prop( "disabled", false );
  $("#email").prop( "disabled", false );
  $("#saveButtonDiv").removeClass("hide");
  $("#editButtonDiv").addClass("hide");
  $("#changeButton").removeClass("hide");
})

$("#changeButton").click(function(){
  $("#password1").prop( "disabled", false );
  $(".passwordComfirmationRow").removeClass("hide");
  $(".validate").prop('disabled', false);
});
//disable input
$(document).ready(function(){
    var users = <?php echo json_encode($users); ?>;;
    $("#username").val(users["username"]);
    $("#email").val(users["email"]);
    $("#password1").val(users["password"]);
    var currentEmail = users["email"];
    var currentUsername = users["username"];
    loadLocationInfo();
    $("#form").validate({
      rules: {
        username: {
          required: true,
          usernamevalidate: true,
          remote: {
            url: "checkUsername.php",
            type: "post",
            data: {
              currentUsername: currentUsername
            }
          }
        },
        email: {
          required: true,
          emailvalidate: true,
          remote: {
            url: "checkEmail.php",
            type: "post",
            data: {
              currentEmail: currentEmail
            }
          }
        },
        password1: {
          required: true,
          minlength: 5,
          pwcheck: true
        },
        password2: {
          required: true,
          minlength: 5,
          equalTo: "#password1"
        }
      },
      messages: {
          username: {
            required: "Please enter a username.",
            usernamevalidate: "Username cannot have space!",
            remote: jQuery.validator.format("Username {0} is already taken.")
          },
          email: {
            required: "Please enter a valid email address.",
            emailvalidate: "Please enter a valid email address.",
             remote: jQuery.validator.format("Email address {0} is already registered.")
          },
          password1: {
            required: "Please enter a password.",
            minlength: "Password must be at least 5 characters long.",
            pwcheck: "Password must include at least one digit and one lowercase letter and no spaces."
          },
          password2: {
            required: "Please confirm your password.",
            minlength: "Password must be at least 5 characters long.",
            equalTo: "Passwords entered are different."
          }
      },
      submitHandler: function(form) { 
        var email = $("#email").val();
        var username = $("#username").val();
        var password1 = null;
        if(!$("#password1").prop("disabled"))
          password1 = $("#password1").val();
        $.post("updateAdmin.php",
          {	email: email,
            username: username,
            password1: password1
          },
          function(data){
            //show errors
            if(data.includes("span")){
              $("#results").html(data);
            }
            else{
              $("#saveButton").prop("disabled", true);
              window.location = "aProfile.php";
            }
          }
        );
      }
    });
});

//FUnction for switching tabs
$(function($){
  $('.tab').click(function(){
    $('.is-active').removeClass('is-active');
    $(this).addClass('is-active');
    $('.is-show').removeClass('is-show');
    // Get the index number from user click
    const index = $(this).index();
    // display the new content
    $('.panel').eq(index).addClass('is-show');
  });
});


//enable input for location tab
$(document).ready(function(){
  $("#editButtonB").click(function(){
    $(".inputInColB").prop( "disabled", false );
    $(".removeButtonB").removeClass("hide");
    $("#addButtonB").removeClass("hide");
    $("#saveButtonDivB").removeClass("hide");
    $("#editButtonDivB").addClass("hide");
  })
});
/*
//disable input for location tab
$(document).ready(function(){
  $("#saveButtonB").click(function(){
    $(".inputInColB").prop( "readonly", true );
    $(".removeButtonB").addClass("hide");
    $("#addButtonB").addClass("hide");
    $("#editButtonDivB").removeClass("hide");
    $("#saveButtonDivB").addClass("hide");
  })
});
*/

//Function for adding and deleting rows
function appendRow() {
  //variables for a new row
  var locationNameInput = "<div class='col s11'><input value='' type='text' class='validate inputInColB'></div>";
  var removeButtonB = " <div class='col s1'><div class='col s1 removeCell'><a class='waves-effect waves-light btn removeButtonB'><i class='material-icons'>remove</i></a></div></div>";
  //insert a new row
  var locations = "<div class='removable'>" + locationNameInput + removeButtonB + "</div>";

  $("#locationInfo").append(locations);

  //remove added rows
  $('.removeButtonB').click(function() {
    $(this).closest('.removable').remove();
  });

};

//remove existing rows
$('.removeButtonB').click(function() {
  $(this).closest('.removable').remove();
});

function loadLocationInfo(){
  var location = <?php echo json_encode($locationArray); ?>;
  var format;
  //display data
  location.forEach(function(result){
    var locationNameInput = "<div class='col s11'><input disabled value='"+ result.name +"' type='text' class='validate inputInColB'></div>";

    var removeButtonB = " <div class='col s1'><div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div></div>";

    var format = "<div class='removable'>" + locationNameInput + removeButtonB + "</div>";
    $("#locationInfo").append(format);
  });
}



     //enable input for location tab
      $(document).ready(function(){
        $("#editButtonB").click(function(){
          $(".inputInColB").prop( "disabled", false );
          $(".removeButtonB").removeClass("hide");
          $("#addButtonB").removeClass("hide");
          $("#saveButtonB").removeClass("hide");
        })
      });

      //disable input for location tab
      $(document).ready(function(){
        $("#saveButtonB").click(function(){
          $(".inputInColB").prop( "readonly", true );
          $(".removeButtonB").addClass("hide");
          $("#addButtonB").addClass("hide");
        })
      });

      //Function for adding and deleting rows
      function appendRow() {

        //variables for a new row
        var locationNameInput = "<div class='col s10'><input name='rowNum[]' value='default' type='text'  class='validate inputInColB' required /><span class='helper-text' data-error='Location cannot be blank'></span></div>";
        var removeButtonB = " <div class='col s1'><div class='col s1 removeCell'><a class='waves-effect waves-light btn  removeButtonB'><i class='material-icons'>remove</i></a></div></div>";

        //insert a new row
        var locations = "<div class='removable'>" + locationNameInput + removeButtonB +"</div>";

        $("#locationInfo").append(locations);


        //remove added rows
        $('.removeButtonB').click(function() {
          $(this).closest('.removable').remove();
        });

      };

      //remove existing rows
      $('.removeButtonB').click(function() {
        $(this).closest('.removable').remove();
      });

      function loadLocationInfo(){
      var location = <?php echo json_encode($locationArray); ?>;
      var format;

      //display data
      location.forEach(function(result){

        var locationNameInput = "<div class='col s10'><input disabled name='locRow[]' value='"+ result.name +"' type='text' class='validate inputInColB' required /><span class='helper-text' data-error='Location cannot be blank'></span></div>";

        var format = "<div class='removable'>" + locationNameInput + "</div>";
        $("#locationInfo").append(format);
      });
    }

 </script>

<style media="screen">
.showError{
	top:10px;
	width:300px !important;
	font-style: italic;
	color: red;
}
#editButtonDiv .btn{
  width: 100px;
}
#saveButtonDiv .btn{
  width: 100px;
}
.btn:hover {
  background-color: #FF8C18!important;
}
</style>

</html>
