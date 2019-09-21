<html>
<head>
  <title>Childplay Login</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
</head>
<body>
  <!--header-->
  <nav class="nav-extended blue darken-4">
    <div class="nav-wrapper">
      <div class="row">
        <div class="col s6">
          <a href="home.html" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
        </div>
        <div class="col s6">

        </div>
        <div class="right col s2 offset-s2">
          <a class="waves-effect waves-light btn blue darken-2 right logout" href="register.php">Register</a>
        </div>
      </div>
    </div>
  </nav>
  <!--end header-->
  <!-- body content -->
  <div class="container grey-text">
    <div id="cardWrapper" class="row valign-wrapper">
      <div class="col s12 valign center-align">
        <div class="card teal lighten-5">
          <div class="card-content">
            <img src="Images/login icon.png" height ="70px"/>
            <form id="form" style="font-size:20px" action="loginUser.php" method="post">
              <div class="row">
                <div class="input-field col s12">
                  <input id="userName" name="username" type="text" class="validate">
                  <label class="center-align" for="userName">User Name</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="password" name="password" type="password" class="validate">
                  <label for="password">Password</label>
                </div>
              </div>
              <div class="card-action">
                <?php
                if(isset($_GET["msg"])){
                  echo "<span style=\"font-size: 12px; color: #EC453C;\">Incorrect username or password.</span>";
                }
                ?>
                <input type="submit" value="Login" class="btn blue darken-4 middle">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--end body content-->
</body>
<script>
$(document).ready(function() {
  //Places error element next to invalid inputs
  $.validator.setDefaults({
    errorElement : 'div',
    errorClass: 'invalid',
    errorPlacement: function(error, element) {
      $(element)
      .closest("form")
      .find("label[for='" + element.attr("id") + "']")
      .attr('data-error', error.text());
    }
  })
  //set up rules and messages for errors
  $("#form").validate({
    rules: {
      username: "required",
      password: "required"
    },
    messages: {
      username: "Enter your username.",
      password: "Enter your password."
    }
  });
});
</script>
<style>
body{
  background-image: url("images/loginBackground.jpg");
  background-position: 0px 64px;
  background-repeat: no-repeat;
  background-size:100% 100%;
}
label[data-error] {
  width: 100%;
  font-size: 12px;
}
.brand-logo{
  margin-top:-67px;
}
.logout{
  margin-top: 15px;
  margin-right:15px;
}
.card {
  margin-top: 30px;
  display: flex;
  align-items: center;
  justify-content: center;
  width:80%;
  margin-left:11%;
}
.card form {
  max-width: 100%;
}
.card-content{
  width: 45%;
}
.icon_style{
  position: absolute;
  right: 10px;
  top: 10px;
  font-size: 20px;
  color: white;
  cursor:pointer;
}
</style>
</html>
