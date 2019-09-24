<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
include 'db_connection.php';
$conn = OpenCon();

session_start();
if(isset($_SESSION['userID']))
  $userID = $_SESSION['userID'];
else
  header('login.php');
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
  <title>ProfilePage</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
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
    <table id="infoTable" height="200px" class="white-text">
      <tbody class="#1565c0 blue darken-3">
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
				<button type="submit" name="btnLogout" class="waves-effect waves-light btn #2196f3 blue right">Logout</button>
				<?php
				if(isset($_POST["btnLogout"])){
					unset($_SESSION['userID']);
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

  <form method="post" action="updateAdmin.php">
    <!--Main contents-->
    <div class="panel-group">
      <!--html for profile tab-->
      <div class="panel  is-show">
        <div class="container">
          <div class="row" id="userDetail">
            <div class="col s12 blue-text darken-2"><h5>Account Information</h5></div>
            <div class="col s3 column01"><h5 class="hInCol">Username:</h5></div>
            <div class='input-field col s9'>
              <input id="uName" name="uName" readonly type='text' class='validate inputInCol'>
            </div>
            <div class="col s3 column01"><h5 class="hInCol">Password:</h5></div>
            <div class='input-field col s9'>
              <input id="password" name="password" readonly value='********' type='text' class='validate inputInCol'>
            </div>
            <div class="col s12 blue-text darken-2"><h5>Personal Information</h5></div>
            <div class="col s3 valign-wrapper column01"><h5 class="hInCol">Email:</h5></div>
            <div class='input-field col s9'>
              <input id="email" name="mailInput" readonly type='text' class='validate inputInCol'>
            </div>
          </div>
        </div>
        <div class="container">
          <div class="row">
            <div class="col s1 offset-s11" id="editButtonDiv"><a class="waves-effect waves-light btn #2196f3 blue right" id="editButton">Edit</a></div>
            <div class="col s1 offset-s11 hide" id="saveButtonDiv"><button class="submit waves-effect waves-light btn blue darken-2 right" id="saveButton" type="submit" value="submit">Save</button>
            </div>
          </div>
        </div>
      </form>
    </div>

    <!--html for Location tab-->
<form method = "post" action="addLocation.php">
<div class="panel">
  <div class="container">
      <div class="row" id="locationInfo">
        <div class="col s11 blue-text darken-2"><h5>Name</h5></div>
      
     </div>

       <div class="row">
         <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide right" id="addButtonB" onclick="appendRow()"><i class="material-icons">add</i></a></div>
         <div class="col s1 offset-s10"><a class="waves-effect waves-light btn #2196f3 blue right" id="editButtonB">Edit</a></div>
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
    $("#uName").prop( "readonly", false );
    $("#password").prop( "readonly", false );
    $("#email").prop( "readonly", false );
    $("#saveButtonDiv").removeClass("hide");
    $("#editButtonDiv").addClass("hide");

    testValues();
  })
  loadProfileInfo();
  loadLocationInfo();
});
//disable input
$(document).ready(function(){
  $("#saveButton").click(function(){
    $("#uName").prop( "readonly", true );
    $("#password").prop( "readonly", true );
    $("#email").prop( "readonly", true );
    $("#saveButtonDiv").addClass("hide");
    $("#editButtonDiv").removeClass("hide");

  })
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
    $(".inputInColB").prop( "readonly", false );
    $(".removeButtonB").removeClass("hide");
    $("#addButtonB").removeClass("hide");
    $("#saveButtonDivB").removeClass("hide");
    $("#editButtonDivB").addClass("hide");
  })
});

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
          $(".inputInColB").prop( "readonly", false );
          $(".removeButtonB").removeClass("hide");
          $("#addButtonB").removeClass("hide");
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
        var locationNameInput = "<div class='col s11'><input name='rowNum[]' value='default' type='text' class='validate inputInColB'></div>";

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
    
        var locationNameInput = "<div class='col s11'><input readonly name='locRow[]' value='"+ result.name +"' type='text' class='validate inputInColB'></div>";

        

        var format = "<div class='removable'>" + locationNameInput + "</div>";
        $("#locationInfo").append(format);
      });
    }

 </script>

</html>
