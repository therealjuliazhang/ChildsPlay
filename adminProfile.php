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

    <!--end header-->
<!--Body part-->
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
          <li class="active #ffffff white"><a href="#!">Profile</a></li>
          <li><a href="#!">Location</a></li>
          <li><a href="#!">Tests</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

    <!--main contents-->

<form action = "updateAdmin.php" method="post">
    <div class="container" >
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






  </body>

<!--Edit and Save information function-->
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
  </script>



  <style>
  #body {
    padding-left: 330px;
  }
  @media only screen and (max-width : 992px) {
      #body{
          padding-left: 0;
      }
  }
  .brand-logo{
      margin-top:-67px;
  }
  #sidebar{
      margin-top: 264px;
  }
  .nav-wrapper > ul {
      margin-left: 220px;
  }
  .header{
      margin-top: 30px;
  }
  .image{
      margin-top: 10px;
  }
  /*CSS for the table under the header*/
  #infoTable{
  background-color:black;
  position: fixed;
  }
  .tableLeft{
    text-align:right;
    margin-right: 100px;
  }
  #mailInCell{
    font-size:20px;
    vertical-align: top;
  }
  #userIconCell{
    width:200px;
    margin-left: 100px;
  }
  #userType{
    font-size:40px;
    vertical-align: top;
  }

  /*CSS for Account info and Personal Info Container*/
  #userDetail{
    margin-top:150px;
    margin-left:200px;
  }
  .column01{
    height: 50px;
  }
  #addButton{
    margin-right: -3px;
    margin-top: 10px;
  }
  #editButton{
    margin-top: 30px;
  }
  #saveButton{
    margin-top: 30px;
  }
  .hInCol{
    margin-top: 30px;
    margin-bottom: -10px;
  }




  </style>
</html>
