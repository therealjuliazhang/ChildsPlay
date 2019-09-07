<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php
  include 'db_connection.php';
  $conn = OpenCon();

  //need to change and make value hwo is currently logged in
  $userID = 1;
  //get userinfo from database
  $sql = "SELECT * FROM users WHERE userID = " .$userID;
  $users = array();
  $result = $conn ->query($sql);
  while($row = mysqli_fetch_assoc($result))
      $users[] = $row;
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
    <div class="navbar-fixed">
      <nav class="nav-extended blue darken-4">
        <div class="nav-wrapper">
          <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
          <ul id="nav-mobile" class="hide-on-med-and-down">
            <li  class="active"><a href="">Tests</a></li>
            <li><a href="">Create</a></li>
            <li><a href="" >Results</a></li>
            <li><a href="">Users</a></li>
          </ul>
        </div>
      </nav>
    </div>
    <!--Content User Information under the header-->
    <div class="navbar-fixed">
    <table id="infoTable" height="200px" class="white-text">
      <tbody class="#1565c0 blue darken-3">
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
          <a class="waves-effect waves-light btn #2196f3 blue right" id="logoutButton" onclick="logout()">Logout</a>
          </div>

          </td>
        </tr>
      </tbody>
    </table>
    </div>

    <!--Side Bar-->
    <ul id="sidebar" class="sidenav sidenav-fixed #ffffff white">
          <li class="tab is-active"><a href="#!">Profile</a></li>
          <li class="tab"><a>Location</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>


    <!--Main contents-->
    <div class="panel-group">
    <!--html for profile tab-->
    <div class="panel  is-show">
    <div class="container">
       <div class="row" id="userDetail">
         <div class="col s12 blue-text darken-2"><h5>Account Information</h5></div>
         <div class="col s3 column01"><h5 class="hInCol">Username:</h5></div>
         <div class='input-field col s9'>
           <input id="uName" name="uName" disabled type='text' class='validate inputInCol'>
         </div>

         <div class="col s3 column01"><h5 class="hInCol">Password:</h5></div>
         <div class='input-field col s9'>
           <input id="password" name="password" disabled value='********' type='text' class='validate inputInCol'>
         </div>
         <div class="col s12 blue-text darken-2"><h5>Personal Information</h5></div>
         <div class="col s3 valign-wrapper column01"><h5 class="hInCol">Email:</h5></div>
         <div class='input-field col s9'>
          <input id="email" name="mailInput" disabled type='text' class='validate inputInCol'>
         </div>
       </div>
     </div>

      <div class="container">
       <div class="row">
         <div class="col s10"></div>
         <div class="col s1"><a class="waves-effect waves-light btn #2196f3 blue right" id="editButton">Edit</a></div>
         <div class="col s1"><button class="submit waves-effect waves-light btn blue darken-2 right" id="saveButton" type="submit" value="submit">Save</button>
         </div>
       </div>
      </div>
</form>



    </div>

    <!--html for Location tab-->
    <div class="panel">
    <div class="container">
       <div class="row" id="locationInfo">
         <div class="col s11 blue-text darken-2"><h5>Name</h5></div>

         <div class="removable">
         <div class='col s11'>
           <input disabled value='University of Wollongong' type='text' class='validate inputInColB'>
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
        </div>

        <div class="removable">
         <div class='col s11'>
           <input disabled value='Keiraville Community Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s11'>
           <input disabled value='KU Gwynneville Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s11'>
           <input disabled value='Wollongong City Community Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s11'>
           <input disabled value='Balgownie Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>
     </div>

       <div class="row">
         <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide" id="addButtonB" onclick="appendRow()"><i class="material-icons">add</i></a></div>
         <div class="col s1 offset-s10"><a class="waves-effect waves-light btn #2196f3 blue" id="editButtonB">Edit</a></div>
         <div class="col s1"><a class="waves-effect waves-light btn blue darken-2" id="saveButtonB">Save</a></div>
       </div>

    </div>
    </div>
  </div><!--Div for panel group-->

  </body>

  <script>
//enable input
  $(document).ready(function(){
    $("#editButton").click(function(){
      $("#uName").prop( "disabled", false );
      $("#password").prop( "disabled", false );
      $("#email").prop( "disabled", false )
      testValues();
    })
    loadProfileInfo();
  });
//disable input
  $(document).ready(function(){
    $("#saveButton").click(function(){
      $("#uName").prop( "disabled", true );
      $("#password").prop( "disabled", true );
      $("#email").prop( "disabled", true );
    })
  });



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
      $("#userType").text("Admin");
    }
    else 
    {
      $("#userType").text("NotAdmin");
    }
  }




  function testValues(){
    val x = document.getElementById("uName");

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

  //enable input for profile tab
    $(document).ready(function(){
      $("#editButton").click(function(){
        $("#uName").prop( "disabled", false );
        $("#password").prop( "disabled", false );
        $("#email").prop( "disabled", false );
      })
    });

  //disable input for profile tab
    $(document).ready(function(){
      $("#saveButton").click(function(){
        $("#uName").prop( "disabled", true );
        $("#password").prop( "disabled", true );
        $("#email").prop( "disabled", true );
      })
    });

    //enable input for location tab
      $(document).ready(function(){
        $("#editButtonB").click(function(){
          $(".inputInColB").prop( "disabled", false );
          $(".removeButtonB").removeClass("hide");
          $("#addButtonB").removeClass("hide");
        })
      });

    //disable input for location tab
      $(document).ready(function(){
        $("#saveButtonB").click(function(){
          $(".inputInColB").prop( "disabled", true );
          $(".removeButtonB").addClass("hide");
          $("#addButtonB").addClass("hide");
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

  </script>

</html>
