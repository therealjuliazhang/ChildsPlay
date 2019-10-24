<!--
================================================================================================================================================================
Title:Admin Profile;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Andre Knell (5741622), Ren Sugie(5679527);
=================================================================================================================================================================
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
//get userinfo from database
$sql = "SELECT * FROM USERS WHERE userID = " .$userID;
$users = array();
$result = $conn ->query($sql);
while($row = mysqli_fetch_assoc($result))
$users[] = $row;

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
    <script src="educatorProfile.js"></script>
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
              <h3 class="" id="fullNameTop"></h3>
              <i class="small material-icons" id="mailIcon">email</i>
              <span id="mailInCell">mfin@gmail.com</span>
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
    <li class="tab is-active"><a href="#!">Profile</a></li>
    <li class="tab"><a>Location</a></li>
  </ul>
  <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

  <form id="detailForm" method="post" action="updateAdmin.php">
    <!--Main contents-->
    <div class="panel-group">
      <!--html for profile tab-->
      <div class="panel  is-show">
        <div class="container">
          <div class="row" id="userDetail" style="margin-left:40px">
            <div class="col s12 blue-text text-darken-4"><h4>Account Information</h4></div>
            <div class="col s3 column01"><h6 class="hInCol">Username:</h6></div>
            <div class='input-field col s9'>
              <input id="uName" name="uName" disabled type='text' class='validate inputInCol'>
            </div>
            <div class="col s3 column01"><h6 class="hInCol">Password:</h6></div>
            <div class='input-field col s9'>
              <input id="password" name="password" disabled value='********' type='text' class='validate inputInCol'>
            </div>
            <div class="col s12 blue-text text-darken-4"><h4>Personal Information</h4></div>
            <div class="col s3 valign-wrapper column01"><h6 class="hInCol">Email:</h6></div>
            <div class='input-field col s9'>
              <input id="email" name="mailInput" disabled type='text' class='validate inputInCol'>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col s1 offset-s11" id="editButtonDiv"><a class="waves-effect waves-light btn blue darken-4 right" id="editButton">Edit</a></div>
            <div class="col s1 offset-s11 hide" id="saveButtonDiv"><button class="submit waves-effect waves-light btn blue darken-2 right" id="saveButton" type="submit" value="submit">Save</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!--html for Location tab-->
<form id="form" method = "post" action="addLocation.php">
<div class="panel">
  <div class="container">
      <div class="row" id="locationInfo" style="margin-left:40px">
        <div class="col s11 blue-text text-darken-4"><h4>Location Names:</h4></div>

     </div>

       <div class="row">
         <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide right" id="addButtonB" onclick="appendRow()"><i class="material-icons">add</i></a></div>
         <div class="col s1 offset-s10"><a class="waves-effect waves-light btn #2196f3 blue darken-4 right" id="editButtonB">Edit</a></div>
         <div class="col s1"><button class="waves-effect waves-light btn blue darken-2 right" id="saveButtonB" type="submit" value = "submit">Save</button></div>
       </div>

    </div>
    </div>
  </div><!--Div for panel group-->
</form>
  </body>

<script>


//enable input
$(document).ready(function(){
  $("#editButton").click(function(){
    $("#uName").prop( "disabled", false );
    $("#password").prop( "disabled", false );
    $("#email").prop( "disabled", false );
    $("#saveButtonDiv").removeClass("hide");
    $("#editButtonDiv").addClass("hide");

    testValues();
  })
  loadProfileInfo();
  loadLocationInfo();
});

//loads user info onto page
function loadProfileInfo()
{
  var user = <?php echo json_encode($users); ?>;
  var format = "apple";
  //display fullname
  $("#fullNameTop").text(user[0].fullName);
  $("#mailInCell").text(user[0].email);
  $("#email").val(user[0].email);
  $("#uNameCell").val(user[0].username);
  $("#uName").val(user[0].username);
  if (user[0].accountType == 1)
  {
    var user = <?php echo json_encode($users); ?>;
    //display fullname
    $("#fullNameTop").text(user[0].fullName);
    $("#mailInCell").text(user[0].email);
    $("#email").val(user[0].email);
    $("#uNameCell").val(user[0].username);
    $("#uName").val(user[0].username);
    if (user[0].accountType == 1)
    {
      $("#userType").text("Admin");
    }
    else
    {
      $("#userType").text("NotAdmin");
    }
  }
  else
  {
    $("#userType").text("NotAdmin");
  }
}

function testValues(){
  var x = document.getElementById("uName");

  console.log(x);


}

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
    $("#saveButtonB").removeClass("hide");
    $("#editButtonB").addClass("hide");
  })
});

//remove existing rows
$('.removeButtonB').click(function() {
  $(this).closest('.removable').remove();
});

function loadLocationInfo(){
  var location = <?php echo json_encode($locationArray); ?>;
  var format;
  //display data
  location.forEach(function(result){
    var locationNameInput = "<div class='col s11'><input disabled value='"+ result.name +"' type='text' class='validate inputInColB' required></div>";

    var removeButtonB = " <div class='col s1'><div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div></div>";

    var format = "<div class='removable'>" + locationNameInput + removeButtonB + "</div>";
    $("#locationInfo").append(format);
  });
}
//enable input for location tab
      $(document).ready(function(){
        $("#editButtonB").click(function(){
          $(".inputInColB").prop( "readonly", false );
          $(".removeButtonB").removeClass("hide");
          $("#addButtonB").removeClass("hide");
        })
      });

      //disable input for location tab
      $(document).ready(function(){
        $("#detailForm").validate({
          rules: {
            uName: {
              required: true
            },
            mailInput:{
              required: true,
              email: true
            }
          },
          messages: {
            uName: {
              required: "Username can't be empty"
              },
            mailInput: {
              required: "Email can't be blank",
              email: "Enter a valid email address"
            }
          }
        });
        
      });

      //Function for adding and deleting rows
      function appendRow() {

        //variables for a new row
        var locationNameInput = "<div class='col s11'><input name='rowNum[]' value='default' type='text'  class='validate inputInColB' required><span class='helper-text' data-error='Location cannot be blank'></span></div>";

        //insert a new row
        var locations = "<div class='removable'>" + locationNameInput + "</div>";

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

        var locationNameInput = "<div class='col s11'><input disabled name='locRow[]' value='"+ result.name +"' type='text' class='validate inputInColB' required><span class='helper-text' data-error='Location cannot be blank'></span></div>";

        var format = "<div class='removable'>" + locationNameInput + "</div>";
        $("#locationInfo").append(format);
      });
    }

 </script>
<style media="screen">
.container .btn{
  width: 80px;
}
#editButton:hover, #saveButton:hover, #editButtonB:hover, #saveButtonB:hover, #addButtonB:hover {
  background-color: #FF8C18!important;
}
</style>
</html>
