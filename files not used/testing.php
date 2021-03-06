<html> 
    <!-- <body>

    <form action="updateAdmin.php" method="post">

<input type="text" name="uName" placeholder="First Name" />

<input type="text" name="password" placeholder="Last Name" />

<input type="text" name="mailInput" placeholder="email" />

<input type="submit" name="submit" />

</form>          -->

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

    <form action="updateAdmin.php" method="post">
    
    <div class="panel-group">
  
    <div class="panel  is-show">
    <div class="container">
       <div class="row" id="userDetail">
         <div class="col s12 blue-text darken-2"><h5>Account Information</h5></div>
         <div class="col s3 column01"><h5 class="hInCol">Username:</h5></div>
         <div class='input-field col s9'>
           <input id="uName" name="uName" disabled  type='text' class='validate inputInCol'>
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
         <div class="col s1"><a class="waves-effect waves-light btn #2196f3 blue right" onclick="enableField()" id="editButton">Edit</a></div>
         <div class="col s1"><button class="submit waves-effect waves-light btn blue darken-2 right" onclick="disableField()" id="saveButton" type="submit" value="submit">Save</button>
         </div>
       </div>
      </div>
    </div>
</form>

 <!--html for Location tab-->
 <div class="panel">
    <div class="container">
       <div class="row" id="locationInfo">
         <div class="col s4 blue-text darken-2"><h5>Name</h5></div>
         <div class="col s5 blue-text darken-2"><h5>Address</h5></div>
         <div class="col s3 blue-text darken-2"><h5>Date added</h5></div>
         <div class="removable">
         <div class='col s4'>
           <input disabled value='University of Wollongong' type='text' class='validate inputInColB'>
         </div>
         <div class="col s5">
           <input disabled value='2 Northfields Ave, Wollongong NSW 2522' type='text' class='validate inputInColB'>
         </div>
         <div class="col s2">
           31/08/2019
         </div>

         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
        </div>

        <div class="removable">
         <div class='col s4'>
           <input disabled value='Keiraville Community Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s5">
           <input disabled value='36 Gooyong St, Keiraville NSW 2500' type='text' class='validate inputInColB'>
         </div>
         <div class="col s2">
           12/08/2019
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s4'>
           <input disabled value='KU Gwynneville Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s5">
           <input disabled value='22 Berkeley Rd, Gwynneville NSW 2500' type='text' class='validate inputInColB'>
         </div>
         <div class="col s2">
           12/08/2019
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s4'>
           <input disabled value='Wollongong City Community Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s5">
           <input disabled value='261 Keira St, Wollongong NSW 2500' type='text' class='validate inputInColB'>
         </div>
         <div class="col s2">
           12/08/2019
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>

       <div class="removable">
         <div class='col s4'>
           <input disabled value='Balgownie Preschool' type='text' class='validate inputInColB'>
         </div>
         <div class="col s5">
           <input disabled value='21A Ryan St, Balgownie NSW 2519' type='text' class='validate inputInColB'>
         </div>
         <div class="col s2">
           12/08/2019
         </div>
         <div class="col s1">
           <div class='col s1 removeCell'><a class='waves-effect waves-light btn hide removeButtonB'><i class='material-icons'>remove</i></a></div>
         </div>
       </div>
     </div>

       <div class="row">
         <div class="col s1 offset-s11"><a class="waves-effect waves-light btn blue darken-4 addCell hide right" id="addButtonB" onclick="appendRow()"><i class="material-icons">add</i></a></div>
         <div class="col s1 offset-s10"><a class="waves-effect waves-light btn #2196f3 blue right" id="editButtonB">Edit</a></div>
         <div class="col s1"><a class="waves-effect waves-light btn blue darken-2 right" id="saveButtonB">Save</a></div>
       </div>

    </div>
    </div>
  </div><!--Div for panel group-->



</body>


<script>
//enable input
  $(document).ready(function(){
    // $("#editButton").click(function(){
    //   $("#uName").prop( "disabled", false );
    //   $("#password").prop( "disabled", false );
    //   $("#email").prop( "disabled", false )
    //   testValues();
    // })
    loadProfileInfo();
  });
//disable input
//   $(document).ready(function(){
//     $("#saveButton").click(function(){
//       $("#uName").prop( "disabled", true );
//       $("#password").prop( "disabled", true );
//       $("#email").prop( "disabled", true );
//     })
//   });

  function enableField()
  {
      document.getElementById("uName").readonly = false;
      document.getElementById("password").readonly = false;
      document.getElementById("email").readonly = false;
  }

  function disableField()
  {
    document.getElementById("uName").readonly = true;
      document.getElementById("password").readonly = true;
      document.getElementById("email").readonly = true;
  }

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

  //enable input for profile tab
    $(document).ready(function(){
      $("#editButton").click(function(){
        $("#uName").prop( "disabled", false );
        $("#password").prop( "disabled", false );
        $("#email").prop( "disabled", false );
      })
    });

  //disable input for profile tab
    // $(document).ready(function(){
    //   $("#saveButton").click(function(){
    //     $("#uName").prop( "disabled", true );
    //     $("#password").prop( "disabled", true );
    //     $("#email").prop( "disabled", true );
    //   })
    // });

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
        var locationNameInput = "<div class='col s4'><input value='' type='text' class='validate inputInColB'></div>";
        var addressInput = "<div class='col s5'><input value='' type='text' class='validate inputInColB'></div>";
        var dateInput = "<div class='col s2'>12/08/2019</div>";
        var removeButtonB = " <div class='col s1'><div class='col s1 removeCell'><a class='waves-effect waves-light btn removeButtonB'><i class='material-icons'>remove</i></a></div></div>";

        //insert a new row
        var locations = "<div class='removable'>" + locationNameInput + addressInput + dateInput + removeButtonB + "</div>";

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