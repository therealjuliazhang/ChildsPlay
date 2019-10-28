<!--
=======================================
Title:Reset password;
Author:Phuong Linh Bui (5624095);
=======================================
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
          //Places error element next to invalid inputs
			$.validator.setDefaults({
				errorElement: 'div',
				errorClass: 'invalid',
				errorPlacement: function(error, element) {
					if (element.attr('type') == "password") {
						$(element).nextAll("div").remove();
						var e = document.createElement("div");
						$(e).append(error.text()).addClass("showError");
						$(element)
							.closest("form")
							.find("label[for='" + element.attr("id") + "']")
							.after(e);
					}
				},
				success: function(div){
					$(div).remove();
				}
			});
        //set up rules and messages for errors
		$("#resetForm").validate({
			rules: {
				password1: {
					required: true,
                    pwcheck: true,
					minlength: 5,
                    
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
                    minlength: "Password must be at least 5 characters long.",
                    pwcheck: "Password must include at least one digit and one lowercase letter and no spaces."
				},
				password2: {
					required: "Please confirm your password.",
                    minlength: "Password must be at least 5 characters long.",
					equalTo: "Passwords entered are different."
				}
			}
		});
        //password regular expressions
		$.validator.addMethod("pwcheck", function(value) {
			var regex = /^(?!.*\s)(?=.*\d)(?=.*[a-z]).{5,}$/;
			return regex.test(value);
		});
      });
      </script>
<style>
.showError{
	top:10px;
	width:300px !important;
	font-style: italic;
	color: red;
    text-align: left;
}
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
            <a href="home.html" class="brand-logo"><img class="logoImg" src="images/logo3.png"></a>
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
                            </div>
                        </div>
                        <div class="row">
							<div class="input-field col s12">
								<input id="password2" name="password2" type="password" class="validate">
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
        //check if the passed token in url is the same as in the database
        if(isset($_GET["token"])){
            $token = $_GET["token"];
            $password = md5($password);//encrypt the password before saving in the database

            $pwcheck = $conn->prepare("SELECT password FROM USERS WHERE token=?");
            $pwcheck->bind_param("s", $token);
            $pwcheck->execute();
            $result1 = $pwcheck->get_result();
            $oldPassword = "";
            //get the old password
            while($value = $result1->fetch_assoc())
                $oldPassword = $value["password"];
            $pwcheck->close();
            //if the new password is different from the old password, update the database
            if($password != $oldPassword){
                //update new password in database
                $sql = $conn->prepare("UPDATE USERS SET password=? WHERE token=?");
                $sql->bind_param("ss", $password, $token);
                $sql->execute();
                $count = $sql->affected_rows;
                $sql->close();
                if($count == 1){
                    echo "<div style='color:green;font-style:italic'>Reset password successfully!</div>";
                }
                else
                    echo "<div style='color:red;font-style:italic'><p>Failed to reset password!</p></div>";
            }
            //don't need to update database if the new password is the same as old password
            else
                echo "<div style='color:green;font-style:italic'>Reset password successfully!</div>";
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