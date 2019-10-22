<!--=========================================================================================================
Title: Register
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527)
==========================================================================================================-->
<!DOCTYPE html>
<html>
<?php
include 'db_connection.php';
$conn = OpenCon();
//fetch locations for select drop down
$sql = "SELECT * FROM LOCATION";
$result = $conn->query($sql);
$locations = array();
while ($row = mysqli_fetch_assoc($result))
	$locations[] = $row;
?>

<head>
	<title>Register</title>
	<meta name="viewport" content="width = device-width, initial-scale = 1">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
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
			for (var i = 0; i < locations.length; i++) {
				var option = document.createElement("option");
				option.value = locations[i]['locationID'];
				option.name = locations[i]['name'];
				option.innerHTML = locations[i]['name'];
				$("#location").append(option);
				$("#location").trigger('contentChanged');
			}

			//Places error element next to invalid inputs
			$.validator.setDefaults({
				errorElement: 'div',
				errorClass: 'invalid',
				errorPlacement: function(error, element) {
					//element.next("div").remove();
					var e = document.createElement("div");
					$(e).append(error.text()).addClass("showError");
					if (element.attr('type') == "text" || element.attr('type') == "email" || element.attr('type') == "password") {
						$(element).nextAll("div").remove();
						$(element)
							.closest("form")
							.find("label[for='" + element.attr("id") + "']")
							.after(e);
						/*$(element)
							.closest("form")
							.find("label[for='" + element.attr("id") + "']")
							.attr('data-error', error.text())
							.addClass("showError");*/
					} else if (element.hasClass("materialSelect")) {
						//$("element + div").remove();
						$(element).next("div").remove();
						$(element).after(e);
					}
				},
				success: function(div) {
					$(div).remove();
				}
			});
			//set up rules and messages for errors
			$("#form").validate({
				rules: {
					fullname: "required",
					accountType: "required",
					username: {
						required: true,
						usernamevalidate: true,
						remote: {
							url: "checkUsername.php",
							type: "post"
						}
					},
					email: {
						required: true,
						emailvalidate: true,
						remote: {
							url: "checkEmail.php",
							type: "post"
						}
					},
					password1: {
						required: true,
						minlength: 5,
						pwcheck: true
					},
					password2: {
						required: true,
						minlength: 5,
						equalTo: "#password1"
					}
				},
				messages: {
					fullname: {
						required: "Please enter your full name"
					},
					accountType: "Please pick an account type.",
					location: "Pick your location from the drop down menu.",
					username: {
						required: "Please enter a username.",
						usernamevalidate: "Username cannot have space!",
						remote: jQuery.validator.format("Username {0} is already taken.")
					},
					email: {
						required: "Please enter a valid email address.",
						emailvalidate: "Please enter a valid email address.",
						remote: jQuery.validator.format("Email address {0} is already registered.")
					},
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
				},
				submitHandler: function(form) {
					var email = $("#email").val();
					var fullname = $("#fullname").val();
					var accountType = $("#accountType option:selected").val();
					var location = $("#location").val();
					var username = $("#username").val();
					var password1 = $("#password1").val();
					$.post("registerAccount.php", {
							email: email,
							fullname: fullname,
							accountType: accountType,
							location: location,
							username: username,
							password1: password1
						},
						function(data) {
							//show errors
							if (data.includes("span")) {
								$("#results").html(data);
							} else {
								$("#submitBtn").prop('disabled', true);
								window.location = "thankyouForRegister.html";
								$.post(
									"sendEmail.php", {
										registerEmail: email
									}
								);
							}
						}
					);
				}
			});
			//password regular expressions
			$.validator.addMethod("pwcheck", function(value) {
				var regex = /^(?!.*\s)(?=.*\d)(?=.*[a-z]).{5,}$/;
				return regex.test(value);
			});
			//email regular expressions
			$.validator.addMethod("emailvalidate", function(value) {
				var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
				return regex.test(value);
			});
			//username validation not allow space
			$.validator.addMethod("usernamevalidate", function(value) {
				var regex = /^(?!.*\s)([a-zA-Z0-9_.+-])+$/;
				return regex.test(value);
			});
		});
	</script>
	<script>
		function chg(obj) {
			if (obj.options[obj.selectedIndex].value == "educator")
				document.getElementById("10").style.display = "";
			else
				document.getElementById("10").style.display = "none";
		}
	</script>
</head>
<!-- logo -->

<body>
	<div class="container">
		<div class="row">
			<div class="col s12 center">
				<a href="home.html" class="brand-logo"><img class="logoImg" src="images/logo3.png"></a>
			</div>
		</div>
	</div>

	<!-- card -->
	<div class="container bodyContainer">
		<div id="cardWrapper">
			<div class="col s12 valign">
				<div class="card">
					<div class="card-content">
						<span class="card-title">
							<h5 class="center-align">Create Your Account</h5>
						</span>
						<form id="form" action="" method="POST" novalidate="novalidate">
							<div class="row valign-wrapper">
								<div class="col s4">Register as</div>
								<div class="input-field col s8">
									<select onchange="chg(this)" class="materialSelect" id="accountType" name="accountType" required>
										<option value="" selected disabled>Choose your option</option>
										<option value="admin">Admin</option>
										<option value="educator">Educator</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="fullname" name="fullname" type="text" class="validate">
									<label class="labelInCard" for="fullname">Full Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="username" name="username" type="text" class="validate">
									<label class="labelInCard" for="username">User Name</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="email" name="email" type="email" class="validate">
									<label class="labelInCard" for="email">Email</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="password1" name="password1" type="password" class="validate">
									<label class="labelInCard" for="password1">Password</label>
								</div>
							</div>
							<div class="row">
								<div class="input-field col s12">
									<input id="password2" name="password2" type="password" class="validate">
									<label class="labelInCard" for="password2">Confirm Password</label>
								</div>
							</div>
							<div class="row valign-wrapper">
								<div class="input-field col s12" style="display:none" id="10">
									<select name="location[]" id="location" class="materialSelect" required multiple>
										<option value="" disabled selected>Location</option>
										<?php
										/*foreach($locations as $location){
										echo "<option value='".$location["locationID"]."'>".$location["name"]."</option>";
									}*/
										?>
									</select>
								</div>
							</div><br />
							<div class="row">
								<div class="col s12 center">
									<input type="submit" value="Register" name="submitBtn" id="submitBtn" class="btn blue darken-4 middle submitBtn" <?php echo (isset($_POST["submitBtn"])) ? 'disabled="true"' : ''; ?>>
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
						<div id="results"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end card-->
</body>
<style>
	.showError {
		top: 10px;
		width: 300px !important;
		font-style: italic;
		color: red;
	}

	.logoImg {
		height: 70px;
		margin-top: 20px;
	}

	body {
		background-color: #081754;
	}

	.bodyContainer {
		width: 30%;
	}

	.card {
		height: 1100px;
	}

	.loginButton {
		margin-bottom: 20px;
	}

	.btn {
		width: 70%;
		border-radius: 20px;
	}

	.card .card-content {
		padding: 50px;
	}

	.row {
		margin-bottom: 5px;
	}

	.btn02 {
		background-color: #FF8C18;
	}

	.divider {
		margin: 50px 0px;
	}

	h6 {
		margin-bottom: 20px;
	}

	.btn:hover,
	.btn-large:hover {
		background-color: #FF8C18;
	}

	.labelInCard {
		width: 200px;
	}

	#location-error {
		color: #F44336;
	}

	/*
	.btn:hover,
	.btn-large:hover {
		background-color: #FF8C18;
	}
	#accountType-error, #location-error{
		color: red;
		top: -17px;
		position: relative;
		font-style: italic;
	}
*/
</style>

</html>