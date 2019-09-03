<!DOCTYPE html>
<html lang="en" dir="ltr">
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

        <div class="navbar-fixed">
            <nav class="nav-extended blue darken-4">
                <div class="nav-wrapper">
                    <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
                    <ul id="nav-mobile" class="left hide-on-med-and-down">
                        <li  class="active"><a href="">Tests</a></li>
                        <li><a href="">Create</a></li>
                        <li><a href="">Results</a></li>
                        <li><a href="">Users</a></li>
                    </ul>
                    <ul id="logoutButton" class="right hide-on-med-and-down logout">
                        <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>

    <!--end header-->
<!--Body part-->
    <div class="navbar-fixed">
    <table id="infoTable" height="200px" class="white-text">
      <tbody class="#1565c0 blue darken-3">
        <tr>
          <td width="50%">
          <div class="tableLeft">
          <h3>Alex Satoru Hanrahan</h3>
          <i class="small material-icons" id="mailIcon">email</i>
          <span id="mailInCell">ash@gmail.com</span>
          </div>
          </td>
          <td width="50%">

          <div id="user">
          <i class="medium material-icons" id="mailIcon">account_box</i>
          <span id="userType">Educator</span><br>
          <a class="waves-effect waves-light btn #2196f3 blue right" id="logoutButton" onclick="logout()">Logout</a>
          </div>

          </td>
        </tr>
      </tbody>
    </table>
    </div>
    <!--Side Bar-->
    <ul id="sidebar" class="sidenav sidenav-fixed #ffffff white">
          <li class="active #ffffff white"><a href="#!">Profile</a></li>
          <li><a href="#!">Tests</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

    <!--main contents-->

<div class="container" >
   <div class="row" id="userDetail">
     <div class="col s12 blue-text darken-2"><h5>Account Information</h5></div>
     <div class="col s3 column01"><h5 class="hInCol">Username:</h5></div>
     <div class='input-field col s9'>
       <input id="uName" disabled value='Alex Satoru' type='text' class='validate inputInCol'>
     </div>

     <div class="col s3 column01"><h5 class="hInCol">Password:</h5></div>
     <div class='input-field col s9'>
       <input id="password" disabled value='********' type='text' class='validate inputInCol'>
     </div>
     <div class="col s12 blue-text darken-2"><h5>Personal Information</h5></div>
     <div class="col s3 valign-wrapper column01"><h5 class="hInCol">Email:</h5></div>
     <div class='input-field col s9'>
      <input id="email" disabled value='ash@gmail.com' type='text' class='validate inputInCol'>
     </div>
     <div class="col s3 column01"><h5 class="hInCol">Location:</h5></div>
     <div class="removable">
     <div class="input-field col s8 locationCell">
       <select class="selectLocation" disabled>
       <option value="">KU Gwynneville Preschool</option>
       <option value="2" selected>Wollongong Preschool</option>
       <option value="3">Keiraville Community Preschool</option>
       </select>
     </div>
     <div class='col s1 hide removeCell'><a class='waves-effect waves-light btn removeButton'><i class='material-icons'>remove</i></a></div>
   </div>
   </div>
 </div>


  <div class="container" id="buttonsContainer">
   <div class="row">
     <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide right" id="addButton" onclick="appendSelect()"><i class="material-icons">add</i></a></div>
     <div class="col s10"></div>
     <div class="col s1"><a class="waves-effect waves-light btn #2196f3 blue right" id="editButton">Edit</a></div>
     <div class="col s1"><a class="waves-effect waves-light btn blue darken-2 right" id="saveButton">Save</a></div>
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
        $(".removeCell").removeClass("hide");
        $(".addCell").removeClass("hide");
        $('select').formSelect();
      })
    });
    //disable inputs
    $(document).ready(function(){
      $("#saveButton").click(function(){
        $("#uName").prop( "disabled", true );
        $("#password").prop( "disabled", true );
        $("#email").prop( "disabled", true );
        $(".selectLocation").prop('disabled', true);
        $(".removeCell").addClass("hide");
        $(".addCell").addClass("hide");
        $('select').formSelect();
      })
    });

    //Add new selector

    function appendSelect() {
            //insert locations into variable
            var location01 = "KU Gwynneville Preschool";
            var location02 = "Wollongong Preschool";
            var location03 = "Keiraville Community Preschool";
            var removeButton = "<a class='waves-effect waves-light btn removeButton'><i class='material-icons' >remove</i></a>";

            var locations = "<div class='removable'><div class='col s3'></div><div class='input-field col s8 locationCell'><select class='selectLocation'><option value='1' disabled selected>Choose location<option>"
                          + location01 + "</option><option>"
                          + location02 + "</option><option>"
                          + location03 + "</option></select></div><div class='col s1 removeCell'>"
                          + removeButton + "</div></div>";
            $("#userDetail").append(locations);
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
    </script>



  <style>


  </style>
</html>
