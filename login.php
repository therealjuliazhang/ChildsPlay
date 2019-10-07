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
  <div class="container">
    <div class="row">
      <div class="col s12 center">
        <a href="home.html" class="brand-logo"><img class="logoImg" src="images/logo2.png"></a>
      </div>
    </div>
  </div>
  
  <!-- body content -->
  <div class="container bodyContainer">
    <div id="cardWrapper" class="row valign-wrapper">
      <div class="col s12 center-align">
        <div class="card">
          <div class="card-content">
            <form id="form" action="loginUser.php" method="post">
              <div class="row">
                <div class="input-field col s12">
                  <input id="userName" placeholder="Username" name="username" type="text" class="validate">
                </div>
              </div>
              <div class="row">
                <div class="input-field col s12">
                  <input id="password" placeholder="Password" name="password" type="password" class="validate">
                </div>
              </div>
              <?php
              if(isset($_GET["msg"])){
                $msg = $_GET["msg"];
                if($msg == "notaccepted")
                echo "<span style='font-size:12px;color:#EC453C;'>Your account has not been accepted or rejected by admin. Please check your email for more details!</span>";
                else
                echo "<span style=\"font-size: 12px; color: #EC453C;\">Incorrect username or password.</span>";
              }
              ?>
			  <br/>
              <div class="row">
                <div class="col s12">
                  <input type="submit" value="Login" class="btn blue darken-4 middle loginButton">
                </div>
              </div>
              <div class="col s12 center">
                <a href="#">Forgot your password?</a>
              </div>
			  <br/><br/><br/>
              <div class="row">
                <div class="col s12">
				<div class="divider"></div>
                  <!--<hr style="border:1px" />--->
                </div>
              </div>
              <div class="row">
                <div class="col s12">
                  <h5>Don't have an account?</h5>
                </div>
                <div class="col s12"> <br> </div>
                <div class="col s12">
                  <a href="register.php" class="waves-effect waves-light btn orange darken-4">Sign up for Child'sPlay</a>
                </div>
              </div>

            </div>
          </form>
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
.logoImg{
  height: 50px;
  margin-top: 20px;
}
body{
  background-color: #081754;
}
.bodyContainer{
  width: 30%;
}
.card{
  height: 800px;
}
.loginButton{
  margin-bottom: 20px;
}
.btn{
  width: 100%;
}


</style>
</html>
