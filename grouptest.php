<!--
=======================================
Title:Group Tasks; 
Author:Alex Satoru Hanrahan (4836789), Ren Sugie(5679527); 
=======================================
-->
<!DOCTYPE html>
<html>
    <head>
        <title>Preview Test</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type="text/javascript" src="javascript/scripts.js"></script>
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
        <div class="row">
          <div id="InsertHeader"></div>
          <script>
            //Read header
            $(function(){
              $("#InsertHeader").load("header.html");
            });
          </script>
        </div>
        <!--end header-->

        <!-- body content -->

        <div class="container grey-text text-darken-1">
			<div class="row">
				<div class="col s12">
					<div class="right-align">
						<a class="waves-effect waves-light btn blue darken-2" onclick="backToGroupList()"> < < Back</a>
						<a class="waves-effect waves-light btn blue darken-4" onclick="runTest()">Next > ></a>
					</div>
				</div>
			</div>
			<div class="row">
				<h5 class="blue-text darken-2">Test Group</h5>
			</div>
			<div class="row">
				<div class="col s12">
					<div style="font-size:18px">
						Please input the location or preschool name:
						<input placeholder="Location name" id="location_name" value="Wollongong" type="text" class="validate">
						Please input the details for each test participant:
					</div>
				</div>
			</div>
			<div class="row"  style="font-size:18px">
				<div class="col s6">
					<b>Name:</b>
				</div>
				<div class="col s2">
					<b>Age:</b>
				</div>
				<div class="col s2">
					<b>Male:</b>
				</div>
				<div class="col s2">
					<b>Female:</b>
				</div>
			</div>
			<form style="font-size:18px">
				<div class="row">

				<?php
				session_start();
				if(isset($_SESSION['childnames'])){
    foreach ($_SESSION['childnames'] as $arr) {
        echo "Tester: ". $arr . "<br />";
        unset($_SESSION['childnames']);
    }
}?>
					<div class="col s6">
						<input value="Julia" id="name2" type="text" class="validate">
					</div>
					<div class="col s2">
						<input value="6" id="age1" type="text" class="validate">
					</div>
					<div class="col s2">
						<p class="center-align">
							<input name="group1" type="radio" id="genderM1" />
								<label for="genderM1"></label>
						</p>
					</div>
					<div class="col s2">
						<p class="center-align">
								<input name="group1" type="radio" id="genderF1" checked />
									<label for="genderF1"></label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col s6">
						<input value="Alex" id="name2" type="text" class="validate">
					</div>
					<div class="col s2">
						<input value="6" id="age2" type="text" class="validate">
					</div>
					<div class="col s2">
						<p class="center-align">
							<input name="group2" type="radio" id="genderM2" checked />
								<label for="genderM2"></label>
						</p>
					</div>
					<div class="col s2">
						<p class="center-align">
								<input name="group2" type="radio" id="genderF2" />
									<label for="genderF2"></label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col s6">
						<input value="Eric" id="name3" type="text" class="validate">
					</div>
					<div class="col s2">
						<input value="6" id="age3" type="text" class="validate">
					</div>
					<div class="col s2">
						<p class="center-align">
							<input name="group3" type="radio" id="genderM3" checked />
								<label for="genderM3"></label>
						</p>
					</div>
					<div class="col s2">
						<p class="center-align">
								<input name="group3" type="radio" id="genderF3" />
									<label for="genderF3"></label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col s6">
						<input value="Kate" id="name4" type="text" class="validate">
					</div>
					<div class="col s2">
						<input value="6" id="age4" type="text" class="validate">
					</div>
					<div class="col s2">
						<p class="center-align">
							<input name="group4" type="radio" id="genderM4" />
								<label for="genderM4"></label>
						</p>
					</div>
					<div class="col s2">
						<p class="center-align">
								<input name="group4" type="radio" id="genderF4" checked />
									<label for="genderF4"></label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="col s6">
						<input value="Ren" id="name5" type="text" class="validate">
					</div>
					<div class="col s2">
						<input value="6" id="age5" type="text" class="validate">
					</div>
					<div class="col s2">
						<p class="center-align">
							<input name="group5" type="radio" id="genderM5" checked />
								<label for="genderM5"></label>
						</p>
					</div>
					<div class="col s2">
						<p class="center-align">
								<input name="group5" type="radio" id="genderF5" />
									<label for="genderF5"></label>
						</p>
					</div>
				</div>

				<div class="row">
					<div class="right-align">
						<a class="waves-effect waves-light btn blue darken-4" onclick="addMore()">Add More</a>
					</div>
				</div>
			</form>




        </div>

        <!--end body content-->

    </body>
	<script>
	</script>
    <style>
	.brand-logo{
		margin-top:-67px;
	}
	.logout{
		margin-top: 15px;
		margin-right:15px;
	}
    </style>
</html>
