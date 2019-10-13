<!--
Title:Reset password;
Author:Phuong Linh Bui (5624095);
-->
<html>
<head>
  <title>Childplay Reset Password</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">      
      <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
      <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
      <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
      <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
      <script>
      $(document).ready(function(){
        //set up rules and messages for errors
		$("#resetForm").validate({
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
                    required: "<div style='color:red;top:62px;position:relative;font-style:italic;font-size:13px;width:300px;'>Please enter a password.</div>",
                    //minlength: "Password must be at least 5 characters long."
					minlength: "<div style='color:red;top:62px;position:relative;font-style:italic;font-size:13px;width:300px;'>Password must be at least 5 characters long.</div>"
				},
				password2: {
					required: "<div style='color:red;top:62px;position:relative;font-style:italic;font-size:13px;width:300px;'>Please confirm your password.</div>",
                    //minlength: "Password must be at least 5 characters long.",
                    minlength: "<div style='color:red;top:62px;position:relative;font-style:italic;font-size:13px;width:300px;'>Password must be at least 5 characters long.</div>",
					equalTo: "<div style='color:red;top:62px;position:relative;font-style:italic;font-size:13px;width:300px;'>Passwords entered are different.</div>"
				}
			}
		});
      });
      </script>
<style>
.logoImg{
  height: 70px;
  margin-top: 20px;
}
body{
  background-color: #081754;
}
.bodyContainer{
  width: 30%;
}
.btn{
	width: 70%;
    border-radius: 20px;
}
.card .card-content {
    padding: 50px;
}
.row {
    margin-bottom: 20px;
}/*
.resetBtn:hover {
    background-color: #FF8C18 !important;
}*/
.loginBtn,.loginBtn:hover{
  background-color:#FF8C18;
}
label { display: block; width: 200px; text-align: left;}
</style>
</head>
<body>
    <!-- logo -->
    <div class="container">
        <div class="row">
        <div class="col s12 center">
            <a href="home.html" class="brand-logo"><img class="logoImg" src="images/logo2.png"></a>
        </div>
        </div>
    </div>
    
    <!--card -->
    <div class="container bodyContainer">
        <div id="cardWrapper" class="row valign-wrapper">
            <div class="col s12 center-align">
                <div class="card">
                <div class="card-content" style="height:650px">
                    <form id="resetForm" action="" method="post">
                        <h5 class="form-title">Reset password</h5><div class="row"></div>
                        <div class="row">
                            <div class="input-field col s12">
                            <input id="password1" name="password1" type="password" class="validate">
                            <label for="password1" >New password</label>
                            <span id="error1"></span>
                            </div>
                        </div>
                        <div class="row">
							<div class="input-field col s12">
								<input name="password2" name="password2" type="password" class="validate">
                                <label for="password2" >Confirm new password</label>
							</div>
						</div>
                        <div class="row"></div>
                        <div class="row">
                            <div class="col s12">
                                <input type="submit" value="Reset" name="resetBtn" class="btn blue darken-4 middle resetBtn">
                            </div>
                        </div><br/>
                        <div class="col s12">
							<div class="divider"></div>
                        </div>
                        <div class="row"></div>
                        <div class="col s12">
							<h6>Back to Login page</h6>
						</div><br/><br/>
                        <div class="row">
                            <div class="col s12">
								<a href="login.php" class="btn middle loginBtn">LOGIN</a>
                            </div>
                        </div>
                    </form>
<?php
//session_start();
include "db_connection.php";
$conn = OpenCon();
if(isset($_POST["resetBtn"])){
    if(isset($_POST["password1"]) && !empty($_POST["password1"])){
        $password = $_POST["password1"];
        //check password validation
        if (!preg_match("#.*^(?=.{5,})(?=.*[a-z])(?=.*[0-9]).*$#", $password )){
            echo "<div style='color:red;font-style:italic'><p>Password must include at least 1 letter and 1 number!</p></div>";
        }
        else{
            //check if the passed token in url is the same as in the database
            if(isset($_GET["token"])){
                $token = $_GET["token"];
                $password = md5($password);//encrypt the password before saving in the database
                //update new password in database
                $sql = "UPDATE USERS SET password='$password' WHERE token='$token'";
                $result = $conn->query($sql);
                $count = mysqli_affected_rows($conn);
                if($count == 1){
                    echo "<div style='color:green;font-style:italic'>Reset password successfully!</div>";
                }
                else
                    echo "<div style='color:red;font-style:italic'><p>Failed to reset password!</p></div>";
            }
        }
    }
}
CloseCon($conn);
?>
                </div>
            </div>
        </div>
    </div>
    <!--end card-->
</body>
</html>