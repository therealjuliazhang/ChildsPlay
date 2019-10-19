<!--
Title: Forgot Password;
Author: Phuong Linh Bui (5624095);
-->
<html>
<head>
  <title>Childplay Forgot Password</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">      
      <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
      <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
      <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>           
      <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
      <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script> 
<!---
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  --->
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
}
.submitBtn:hover {
    background-color: #FF8C18 !important;/*#FF8C18*/
}
label { display: block; width: 200px; text-align: left;}
</style>
<script>
$(document).ready(function(){
    
    $("#forgotForm").validate({
        rules:{
            email: {
                required: true,
                email: true
            }
        },
        messages:{
            email:{
                required: "<div style='color:red;top:70px;position:relative;font-style:italic;font-size:13px;width:300px;'>Please enter a valid email address.</div>",
                email: "<div style='color:red;top:70px;position:relative;font-style:italic;font-size:13px;width:300px;'>Please enter a valid email address.</div>"
            }
        },
        submitHandler: function(form) { 
            var email = $("#email").val();
            $.post("submitEmailAddress.php",
                    {email: email},
					function(data){
                        //show errors
						if(data.includes("span")){
							$("#results").html(data);
                        }
                        else{
                            $("#results").html(data);
                            $("#submitBtn").prop('disabled', true);
                            $.post(
                                "sendResetPasswordEmail.php",
                                {resetEmail: email}
                            );
                        }
					}
				);
         }
    });
});
</script>
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
                <div class="card-content">
                    <form id="forgotForm" action="" method="post">
                        <h4 class="form-title">Forgot password</h4><div class="row"></div>
                        <!--<div class="row">
                            <div class="input-field col s12">
                            <input id="email" type="email" class="validate">
                            <label for="email" data-error="wrong" data-success="right">Email</label>
                            </div>
                        </div>--->
                        <div class="row">
							<div class="input-field col s12">
								<input name="email" id="email" type="email" class="validate">
                                <label for="email">Email</label>
                                <!--<label for="email" data-error="Please enter a valid email address" data-success="">Email</label>--->
							</div>
						</div>
                        <div class="row"></div>
                        <div class="row">
                            <div class="col s12">
                               <input type="submit" value="Submit" name="submitBtn" id="submitBtn" class="btn blue darken-4 middle submitBtn" <?php echo (isset($_POST["submitBtn"])) ? 'disabled="true"' : ''; ?>>
                            </div>
                        </div>
                    </form>
                    <div id="results"></div>
                    
                </div>
            </div>
        </div>
    </div>
    <!--end card-->
</body>
</html>