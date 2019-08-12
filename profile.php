<!DOCTYPE html>
<html lang="en" dir="ltr">
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
    <!--
    Need to be modified : Table border,position aberration between icon and <h>tag
    -->
    <div class="navbar-fixed">
    <table id="infoTable" height="200px" >
      <tbody class="#bbdefb blue lighten-4">
        <tr>
          <td width="50%">
          <div class="tableLeft">
          <h3 class="blue-text text-darken-4">Michael Finley</h3>
          <i class="small material-icons" id="mailIcon">email</i>
          <span id="mailInCell" class="blue-text text-darken-1">mfin@gmail.com</span>
          </div>
          </td>
          <td width="50%">

          <div id="user">
          <i class="medium material-icons" id="mailIcon">account_box</i>
          <span class="blue-text text-darken-4" id="userType">Admin</span>
          </div>

          </td>
        </tr>
      </tbody>
    </table>
    </div>
    <!--Side Bar-->
    <ul id="sidebar" class="sidenav sidenav-fixed #bbdefb blue lighten-4">
          <li class="active #ffffff white"><a href="#!">Profile</a></li>
          <li><a href="#!">Location</a></li>
          <li><a href="#!">Tests</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>

    <!--main contents-->
    <div id="userDetail">
      <table id="userInfo">
       <thead>
         <tr>
             <th colspan="3">Account Information</th>
         </tr>
       </thead>

       <tbody>
         <tr>
           <td class="row1">Username:</td>
           <td class="row2">Holly</td>
           <td class="row3"><a>Edit</a></td>
         </tr>
         <tr>
           <td class="row1">Password:</td>
           <td class="row2">********</td>
           <td class="row3"><a>Edit</a></td>
         </tr>

         <thead>
           <tr>
               <th colspan="3">Personal Information</th>
           </tr>
         </thead>

         <tbody>
           <tr>
             <td class="row1">Email:</td>
             <td class="row2">mfin@gmail.com</td>
             <td class="row3"><a>Edit</a></td>
           </tr>
           <tr>
             <td class="row1">Location:</td>
             <td class="row2">Wollongong Preschool</td>
             <td class="row3"><a>Edit</a></td>
           </tr>
       </tbody>
     </table>
     <a class="waves-effect waves-light btn blue darken-2 logoutButton right" onclick="logout()">Logout</a>
    </div>


  </body>

  <script>

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
  .logoutButton{
      margin-top: 15px;
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
  #tableDiv{
      width: 400px;
  }
.sortButton{
  margin-bottom: 80px;
  }

  #bodyPart{
    margin-left: 10%;
    margin-right: 10%;
  }

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
  #user{
    margin-left: 100px;
  }
  #userType{
    font-size:40px;
    vertical-align: top;
  }
  .active{
    color:white;
  }
  #userDetail{
    margin-top:150px;
    margin-left:400px;
    width:500px;
  }
  .row1{
    width:20%;
  }
  .row2{
    width:40%;
  }
  .row3{
    text-align:right;
  }

  </style>
</html>
