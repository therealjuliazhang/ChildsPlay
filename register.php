<!DOCTYPE html>
<html>
<?php
include 'db_connection.php';
$conn = OpenCon();
//fetch locations for select drop down
$sql = "SELECT * FROM LOCATION";
$result = $conn->query($sql);
$locations = array();
while($row = mysqli_fetch_assoc($result))
$locations[] = $row;
?>
<head>
	<title>Register</title>
	<meta name = "viewport" content = "width = device-width, initial-scale = 1">
	<link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
	<script>
	$(document).ready(function() {
		//inititate select drop down
		$('select').material_select();
		$("select[required]").css({
			display: "inline",
			height: 0,
			padding: 0,
			width: 0
		});
		$('.materialSelect').on('contentChanged', function() {
			$(this).material_select();
		});
		//set locations into select options
		var locations = <?php echo json_encode($locations); ?>;
		for(var i=0; i<locations.length; i++){
			var option = document.createElement("option");
			option.value = locations[i]['locationID'];
			option.name = locations[i]['name'];
			option.innerHTML = locations[i]['name'];
			document.getElementById("location").appendChild(option);
			$("#location").trigger('contentChanged');
		}
		//Places error element next to invalid inputs
		$.validator.setDefaults({
			errorElement : 'div',
			errorClass: 'invalid',
			errorPlacement: function(error, element) {
				if(element.attr('type') == "text" || element.attr('type') == "email" || element.attr('type') == "password"){
					$(element)
					.closest("form")
					.find("label[for='" + element.attr("id") + "']")
					.attr('data-error', error.text());
				}
				else if(element.hasClass("materialSelect")){
					element.after(error);
				}
			}
		})
		//set up rules and messages for errors
		$("#form").validate({
			rules: {
				username: {
					required: true,
					remote: {
						url: "checkUsername.php",
						type: "post"
					}
				},
				email: {
					required: true,
					email: true,
					remote: {
						url: "checkEmail.php",
						type: "post"
					}
				},
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
				accountType: "Pick an account type.",
				location: "Pick your location from the drop down menu.",
				username: {
					required: "Enter a username.",
					remote: jQuery.validator.format("Username {0} is already taken.")
				},
				email: {
					required: "Enter an email.",
					email: "Enter a valid email address."
				},
				password1: {
					required: "Enter a password.",
					minlength: "Password must be at least 5 characters long."
				},
				password2: {
					required: "Confirm your password.",
					minlength: "Password must be at least 5 characters long.",
					equalTo: "Passwords entered are different."
				}
			}
		});
	});

	// function validate() {
	// 	var password1 = document.getElementById("password1").value;
	// 	var password2 = document.getElementById("password2").value;
	// 	if(password1 == password2) {
	// 	document.getElementById("tishi").innerHTML="<font color='green'>password correct</font>";
	// 	document.getElementById("submit").disabled = false;
	// 	}
	// 	else {
	// 	document.getElementById("tishi").innerHTML="<font color='red'>password different</font>";
	// 	document.getElementById("submit").disabled = true;
	// 	}
	// }
	</script>
	<script>
	function chg(obj)
	{
		if(obj.options[obj.selectedIndex].value =="educator")
		document.getElementById("10").style.display="";
		else
		document.getElementById("10").style.display="none";
	}
	</script>
</head>
<!--the stuff in the head is all the linking things to Materialize-->
<!--all the linking's been done, so you shouldn't need to download anything from Materialise-->

<!-- logo -->
<body>
	<div class="container">
    <div class="row">
      <div class="col s12 center">
        <a href="home.html" class="brand-logo"><img class="logoImg" src="images/logo2.png"></a>
      </div>
    </div>
  </div>

	<!-- card -->
	<div class="container bodyContainer">
		<div id="cardWrapper">
			<div class="col s12 valign">
				<div class="card">
					<div class="card-content">
						<span class="card-title"><h5 class="center-align">Create Your Account</h5></span>
						<form id="form" action="registerAccount.php" method="post">
							<div class="row valign-wrapper">
								<div class="col s4">Register as an</div>
								<div class="input-field col s8">
									<select  onchange="chg(this)" name="accountType" required>
										<option value="" disabled selected>Choose your option</option>
										<option value="admin">Admin</option>
										<option value="educator">Educator</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="fullname" name="fullname" type="text" class="validate">
									<label for="fullname">Full Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="username" name="username" type="text" class="validate">
									<label for="username">User Name</label>
								</div>
							</div>
							<div class="row">
								<div name="email" class="input-field col s12">
									<input name="email" type="email" class="validate">
									<label for="email">Email</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="password1" name="password1" type="password" class="validate">
									<label for="password1">Password</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="password2" name="password2" type="password" class="validate" >
									<label for ="password2">Password Again</label>
								</div>
							</div>
							<div class="row valign-wrapper" >
								<div class="input-field col s12" style="display:none"  id="10">
									<select name="location[]" id="location" class="materialSelect" required multiple>
										<option value=""disabled selected >Location</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col s12 center">
									<input type="submit" value="Register" class="btn blue darken-4" id="submit"/>
								</div>
							</div>
							<div class="row center">
								<div class="col s12">
                  <div class="divider"></div>
                </div>
								<div class="col s12">
                  <h6>Already have an account?</h6>
                </div>
								<div class="col s12">
                  <a href="login.php" class="waves-effect waves-light btn btn02">LOGIN</a>
                </div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!--end card-->
</body>
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
.card{
  height: 1100px;
}
.loginButton{
  margin-bottom: 20px;
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
}
.btn02{
  background-color:#FF8C18
}
.divider{
	margin: 50px 0px;
}
h6{
	margin-bottom: 20px;
}
.btn:hover, .btn-large:hover {
    background-color: #FF8C18;
}

</style>
</html>
