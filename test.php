<!--
=======================================
Title:Educator Profile;
Author:Phuong Linh Bui (5624095)
=======================================
-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <?php
  include 'db_connection.php';
  $conn = OpenCon();

  include "educatorAccess.php";

    //get userinfo from database
    $sql = "SELECT * FROM USERS WHERE userID =".$userID;
    $users = array();
    $result = $conn ->query($sql);
    $users = mysqli_fetch_assoc($result);

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
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script><!----->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
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
		<tbody>
		<!--<form action="" method="post">--->
        <tr>
          <td width="50%">
          <div class="tableLeft">
          <h3 id="fullNameTop"><?php echo $users["fullName"]; ?></h3>
          <i class="small material-icons" id="mailIcon">email</i>
          <span id="mailInCell"><?php echo $users["email"]; ?></span>
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
		<!--</form>--->
      </tbody>
    </table>
  </div>
  <!--Side Bar-->
  <!--main contents-->
  <form id="form" action="" method="post">
  <div class="container" id="educatorProfileContainer">
    <div class="row" id="userDetail">
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
      <div class="col s12 blue-text text-darken-4"><h4>Personal Information</h4></div>
      <div class="col s3 valign-wrapper column01"><h6 class="hInCol">Email:</h6></div>
      <div class='input-field col s9'>
        <input id="email" name="email" type="email" class="validate">
      </div>
      <div class="col s3 column01"><h6 class="hInCol">Location:</h6></div>
      <div class="removable">
        <div class="input-field col s9 locationCell">
          <select name="location[]" id="location" class="materialSelect" multiple required>
          <?php
          foreach($locationArray as $location){
            echo "<option value='".$location["name"]."'>".$location["name"]."</option>";
          }
          ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="container" id="educatorProfileButtonsContainer">
    <div class="row">
        <div class="col s1 offset-s11" id="editButtonDiv">
            <a class="waves-effect waves-light btn blue darken-4" id="editButton">Edit</a>
        </div>
        <div class="col s1 offset-s11 hide" id="saveButtonDiv">
            <button type="submit" class="waves-effect waves-light btn blue darken-4" name="saveBtn" id="saveButton">Save</button>
        </div>
    </div>
    <div id="results"></div>
  </div>
  </form>
</body>

<!--Edit and Save information function-->
<script>
//enable inputs
function getSelectedValues(){
  //$("#location option:selected").prop("selected", false);
  var selected = $("#location").val();
  console.log("Selected: " + selected);
}
var locations = <?php echo json_encode($locationArray); ?>;
var currentLocations = <?php echo json_encode($currentLocationArray); ?>;

$.each(currentLocations, function(i,e){
  $("#location option[value='" + e["name"] + "']").prop("selected", true);
});

$("#editButton").click(function(){
                $("#password1").val("");

                $("#username").prop( "disabled", false );
                $("#password1").prop( "disabled", false );
                $("#email").prop( "disabled", false );
                $(".selectLocation").prop('disabled', false);
                $(".validate").prop('disabled', false);
                $(".removeCell").removeClass("hide");
                $(".addCell").removeClass("hide");
                $(".passwordComfirmationRow").removeClass("hide");
                $("#saveButtonDiv").removeClass("hide");
                $("#editButtonDiv").addClass("hide");
                //$('select').formSelect();
            });

$(document).ready(function(){
    var users = <?php echo json_encode($users); ?>;;
    $("#username").val(users["username"]);
    $("#email").val(users["email"]);
    $("#password1").val(users["password"]);
    var currentEmail = users["email"];
    var currentUsername = users["username"];
    /*
    $('.materialSelect').on('contentChanged', function() {
				$(this).material_select();
      });
   */
$('#location').material_select();
  
    $("#username").prop( "disabled", true );
    $("#password").prop( "disabled", true );
    $("#email").prop( "disabled", true );
    $(".selectLocation").prop('disabled', true);
    $(".validate").prop('disabled', true);
    $(".removeCell").addClass("hide");
    $(".addCell").addClass("hide");
    $(".saveButtonDiv").addClass("hide");
    $(".passwordComfirmationRow").addClass("hide");
    $("#saveButtonDiv").addClass("hide");
    $("#editButtonDiv").removeClass("hide");

    

    //inititate select drop down
			$('select').material_select();
			$("select[required]").css({
				display: "inline",
				height: 0,
				padding: 0,
				width: 0
			});
			
    //Places error element next to invalid inputs
			$.validator.setDefaults({
				errorElement: 'div',
				errorClass: 'invalid',
				errorPlacement: function(error, element) {
						var e = document.createElement("div");
						$(e).append(error.text()).addClass("showError");
					if (element.attr('type') == "text" || element.attr('type') == "email" || element.attr('type') == "password") {
						$(element).nextAll("div").remove();
						$(element)
							.closest("form")
							.find("input[name='" + element.attr("id") + "']")
							.after(e);
					} else if (element.hasClass("materialSelect")) {
						$(element).next("div").remove();
						$(element).after(e);
					}
				},
				success: function(div){
					$(div).remove();
				}
      });
      
  $("#form").validate({
				rules: {
					password1: {
						required: true,
						minlength: 5
					},
					password2: {
						required: true,
						minlength: 5,
						equalTo: "#password1"
					}
				},
				messages: {
					password1: {
						required: "Please enter a password.",
						minlength: "Password must be at least 5 characters long."
					},
					password2: {
						required: "Please confirm your password.",
						minlength: "Password must be at least 5 characters long.",
						equalTo: "Passwords entered are different."
					}
				},
				submitHandler: function(form) { 
					var email = $("#email").val();
          var locations = $("#location").val();
          //alert(locations);
          console.log("location: " + locations);
          /*
          $("#location option:selected").each(function(){
            locations.push($(this).val());
          });*/
          //alert(locations[0]);
					var username = $("#username").val();
					var password1 = $("#password1").val();
					$.post("updateEducator.php",
					{	email: email,
						locations: locations,
						username: username,
						password1: password1
					},
					function(data){
						//show errors
						if(data.includes("span")){
							$("#results").html(data);
						}
						else{
                            $("#username").prop( "disabled", true );
                            $("#password1").prop( "disabled", true );
                            $("#email").prop( "disabled", true );
                            $(".selectLocation").prop('disabled', true);
                            $(".validate").prop('disabled', true);
                            $(".removeCell").addClass("hide");
                            $(".addCell").addClass("hide");
                            $(".saveButtonDiv").addClass("hide");
                            $(".passwordComfirmationRow").addClass("hide");
                            $("#saveButtonDiv").addClass("hide");
                            $("#editButtonDiv").removeClass("hide");

							//window.location = "eProfile.php";
						}
					}
					);
				}
			});
});
</script>
<style>
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
#editButton:hover, #saveButton:hover, #addButton:hover, #logoutButton:hover{
  background-color: #FF8C18!important;
}
</style>
</html>
