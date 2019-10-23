<!--
=======================================
Title:Educator Profile;
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527);
=======================================
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php
   include 'db_connection.php';
   $conn = OpenCon();
    /*
   session_start();

   if(isset($_SESSION["userID"]))
     $userID = $_SESSION["userID"];
    */
    include "educatorAccess.php";
   //get userinfo from database
   $sql = "SELECT * FROM users WHERE userID = " .$userID;
   $users = array();
   $result = $conn ->query($sql);
   while($row = mysqli_fetch_assoc($result))
       $userArray[] = $row;


    //get location information from database
    $locationArray = array();
    $locationQuery = "SELECT * FROM LOCATION";
    $result = $conn ->query($locationQuery);
    while($row = mysqli_fetch_assoc($result))
      $locationArray[] = $row;
    //get the user current location
    $currentLocationArray = array();
    $sql = "SELECT * FROM LOCATION JOIN LOCATIONASSIGNMENT ON LOCATION.locationID = LOCATIONASSIGNMENT.locationID WHERE LOCATIONASSIGNMENT.userID = " .$userID;
    $result = $conn ->query($sql);
    while($row = mysqli_fetch_assoc($result))
      $currentLocationArray[] = $row;

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
      $(function(){
        $("#InsertHeader").load("educatorHeader.html");
      });
    </script>

    <!--end header-->
<!--Body part-->
    <div class="navbar-fixed">
    <table id="infoTable" style="background-color:#FF8C18" height="200px" class="white-text">
		<tbody> <!-- class="#1565c0 blue darken-3"-->
		<form action="" method="post">
        <tr>
          <td width="50%">
          <div class="tableLeft">
          <h3 id="fullNameTop">Alex Satoru Hanrahan</h3>
          <i class="small material-icons" id="mailIcon">email</i>
          <span id="mailInCell">ash@gmail.com</span>
          </div>
          </td>
          <td width="50%">
            <div id="user">
              <i class="medium material-icons" id="mailIcon">account_box</i>
              <span id="userType">Educator</span><br>
              <!--<a href="home.html" class="waves-effect waves-light btn #2196f3 blue right" id="logoutButton" onclick="logout()">Logout</a>--->
              <button type="submit" id="logoutButton" name="btnLogout" class="waves-effect waves-light btn blue darken-4 right" style="right:67px;top:18px;position:relative;">Logout</button>
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
  <!--main contents-->

  <div class="container" id="educatorProfileContainer">
    <div class="row" id="userDetail">
      <div class="col s12 blue-text text-darken-4"><h4>Account Information</h4></div>
      <div class="col s3 column01"><h6 class="hInCol">Username:</h6></div>
      <div class='input-field col s9'>
        <input id="uName" disabled value='Alex Satoru' type='text' class='validate inputInCol'>
      </div>
      <div class="col s3 column01"><h6 class="hInCol">Password:</h6></div>
      <div class='input-field col s9'>
        <input id="password" disabled value='********' type='text' class='validate inputInCol'>
      </div>
      <!--Password confirm Section-->
      <div class="hide passwordComfirmationRow">
        <div class="col s3 column01"><h6 class="hInCol">Comfirm Password:</h6></div>
        <div class='input-field col s9'>
          <input id="password" value='' type='text' class='validate inputInCol'>
        </div>
      </div>
      <div class="col s12 blue-text text-darken-4"><h4>Personal Information</h4></div>
      <div class="col s3 valign-wrapper column01"><h6 class="hInCol">Email:</h6></div>
      <div class='input-field col s9'>
        <input id="email" disabled value='ash@gmail.com' type='text' class='validate inputInCol'>
      </div>
      <div class="col s3 column01"><h6 class="hInCol">Location:</h6></div>
      <div class="removable">
        <div class="input-field col s8 locationCell">
          <select class="selectLocation" disabled>
          <?php
          foreach($locationArray as $location){
            echo "<option value='".$location["name"]."'>".$location["name"]."</option>";
          }
          ?>
            <!---<option value="">KU Gwynneville Preschool</option>
            <option value="2" selected>Wollongong Preschool</option>
            <option value="3">Keiraville Community Preschool</option>--->
          </select>
        </div>
        <div class='col s1 hide removeCell'><a class='waves-effect waves-light btn removeButton red'><i class='material-icons'>remove</i></a></div>
      </div>
    </div>
  </div>

  <div class="container" id="educatorProfileButtonsContainer">
    <div class="row">
      <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide" id="addButton" onclick="appendSelect()"><i class="material-icons">add</i></a></div>
      <div class="col s1 offset-s11" id="editBUttonDiv"><a class="waves-effect waves-light btn blue darken-4" id="editButton">Edit</a></div>
      <div class="col s1 offset-s11 hide" id="saveButtonDiv"><a class="waves-effect waves-light btn blue darken-2" id="saveButton">Save</a></div>
    </div>
  </div>
</body>

<!--Edit and Save information function-->
<script>
//enable inputs
$(document).ready(function(){
  $("#editButton").click(function(){
    $("#uName").prop( "disabled", false );
    $("#password").prop( "disabled", false );
    $("#email").prop( "disabled", false );
    $(".selectLocation").prop('disabled', false);
    $(".validate").prop('disabled', false);
    $(".removeCell").removeClass("hide");
    $(".addCell").removeClass("hide");
    $(".passwordComfirmationRow").removeClass("hide");
    $("#saveButtonDiv").removeClass("hide");
    $("#editBUttonDiv").addClass("hide");
    $('select').formSelect();
  })
  loadProfileInfo();
  loadLocations();
});
//disable inputs
$(document).ready(function(){
  $("#saveButton").click(function(){
    $("#uName").prop( "disabled", true );
    $("#password").prop( "disabled", true );
    $("#email").prop( "disabled", true );
    $(".selectLocation").prop('disabled', true);
    $(".validate").prop('disabled', true);
    $(".removeCell").addClass("hide");
    $(".addCell").addClass("hide");
    $(".saveButtonDiv").addClass("hide");
    $(".passwordComfirmationRow").addClass("hide");
    $("#saveButtonDiv").addClass("hide");
    $("#editBUttonDiv").removeClass("hide");
    $('select').formSelect();
  })
});

//Add new selector

function appendSelect() {
  var locations = <?php echo json_encode($locationArray); ?>;
  //insert locations into variable
  /*
  var location01 = "KU Gwynneville Preschool";
  var location02 = "Wollongong Preschool";
  var location03 = "Keiraville Community Preschool";
  */
  var removeButton = "<a class='waves-effect waves-light btn removeButton red'><i class='material-icons' >remove</i></a>";
  var locationsDisplay = "<div class='removable'><div class='col s3'></div><div class='input-field col s8 locationCell'><select class='selectLocation'><option value='' disabled selected>Choose location</option>";
  locations.forEach(function(result)
  {
    locationsDisplay += "<option value='" + result["name"] + "'>" + result["name"] + "</option>";
        //format
  });
  locationsDisplay += "</select></div><div class='col s1 removeCell'>" + removeButton + "</div></div>";
/*
  + location01 + "</option><option>"
  + location02 + "</option><option>"
  + location03 + "</option></select></div><div class='col s1 removeCell'>"
  + removeButton + "</div></div>";
  */
  $("#userDetail").append(locationDisplay);
  $('select').formSelect();

  //remove a row
  $('.removeButton').click(function() {
    $(this).closest('.removable').remove();
  });
};

//Initialization for selector
$(document).ready(function(){
  $('select').formSelect();
});

/*
if ($(window).width() < 1280) {
alert('Less than 1280');
}
else {
alert('More than 1280');
}
*/

 //load user's data for profile onto page
 function loadProfileInfo()
    {
      var user = <?php echo json_encode($userArray); ?>;
      //display the data on page
      $("#fullNameTop").text(user[0].fullName);
      $("#mailInCell").text(user[0].email);
      $("#email").val(user[0].email);
      $("#uName").val(user[0].username);
    }

    function loadLocations ()
    {
      var locations = <?php echo json_encode($locationArray); ?>;
      //var formatStart =  "<div class='removable'><div class='col s3'></div><div class='input-field col s8 locationCell'><select class='selectLocation'><option value='1' disabled selected>Choose location";
      var formatBody;
      var format = "<select><option value='' disable selected>List of Locations</option>";
      var formatEnd = "</select>";
      var counter = 1;
     // $("#locationInfo").append(formatStart);
      locations.forEach(function(result)
      {
        console.log(result.name);
        formatBody = "<option value=" + counter + ">" + result.name + "</option>";
        format = format + formatBody;
      });
      format = format + formatEnd;
      $("#locationInfo").append(format);
      counter++;
    }
</script>
<style>
#editBUttonDiv .btn{
  width: 100px;
}
#saveButtonDiv .btn{
  width: 100px;
}
#editButton:hover, #saveButton:hover, #addButton:hover{
  background-color: #FF8C18!important;
}
</style>
</html>
