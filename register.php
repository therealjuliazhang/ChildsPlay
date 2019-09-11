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
        <title>Educator Register</title>
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
                    if(element.attr('type') == "text" || element.attr('type') == "email"){
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
						email: "Enter a valid email address.",
                        remote: jQuery.validator.format("The email {0} is already being used by another account.")
                    }
                }
            });
		});

		function validate() {
			var password1 = document.getElementById("password1").value;
			var password2 = document.getElementById("password2").value;
			if(password1 == password2) {
			document.getElementById("tishi").innerHTML="<font color='green'>password correct</font>";
			document.getElementById("submit").disabled = false;
			}
			else {
			document.getElementById("tishi").innerHTML="<font color='red'>password different</font>";
			document.getElementById("submit").disabled = true;
			}
		}
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
						<a class="waves-effect waves-light btn blue darken-2 right login" href="login.php">Login</a>
					</div>
				</div>
            </div>
        </nav>
        <!--end header-->
		<!-- body content -->
		<div class="container grey-text ">
			<div id="cardWrapper" class="row valign-wrapper">
				<div class="col s12 valign">
					<div class="card teal lighten-5">
						<div class="card-content">
							<img src="Images/login icon.png"  height ="10%"style="display:block; margin:auto;"/>
							<span class="card-title grey-text text-darken-2"><b>Create Your Account</b></span>
							<form id="form" style="font-size:20px" action="registerAccount.php" method="post">
								<div class="row valign-wrapper">
									<div class="col s12 right-align">Register as an</div>
									<div class="input-field col s12">
										<select  onchange="chg(this)" name="accountType" required">
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
										<input id="password2" type="password" class="validate" onkeyup="validate()">
										<label for ="password2">Password Again</label>
										<span id="tishi"></span>
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
								<div class="card-action center-align">
									<input type="submit" value="Register" class="btn blue darken-4" id="submit"/>
								</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
        <!--end body content-->
    </body>
    <style>
		body{
			background-image: url("images/loginBackground.jpg");
			background-position: 0px 64px;
			background-repeat: no-repeat;
			background-color: #E1E6E9;
			background-size:100% 100%;
		}
		label[data-error] {
			width: 100%;
		}
		.brand-logo{
			margin-top:-67px;
		}
		.login{
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
    </style>
</html>
