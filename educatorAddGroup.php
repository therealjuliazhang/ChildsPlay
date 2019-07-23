<html>
    <head>
        <title>Add New Group For Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
        <div class="row">
        <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
				<div class="row">
					<div class="col s10">
						<a href="#" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
					</div>
					<div class="col s2 offset-s10">
						<a class="waves-effect waves-light btn blue darken-2 right logout" onclick="logout()">Logout</a>
					</div>
				</div>
            </div>
        </nav>
        </div>
        <!--end header-->
        
        <!-- body content -->
        <div class="container grey-text text-darken-1" style="font-size:18px">
            <div class="row">
                <div class="col s12">
                    <h5 class="blue-text darken-2">Add New Group</h5></br>
                    Please input the details for each test participant:</br></br>
                    <div class="col s6"><b>Name:</b></div>
                    <div class="col s2"><b>Age:</b></div>
                    <div class="col s2" ><b style="padding-left:20px;">Male:</b></div>
                    <div class="col s2"><b>Female:</b></div></br>
                    <form id="form" style="font-size:18px"></form>
                </div>
                <div class="row">
                    <div class="right-align">
                        <a class="waves-effect waves-light btn blue darken-4" onclick="addMore()">Add More</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="right-align">
                    <a class="waves-effect waves-light btn blue darken-2" onclick="startTest()">Start Test</a>
                    <a href="educatorTests.php" class="waves-effect waves-light btn blue darken-4">Cancel</a>
                </div>
            </div>
        </div>
        <!--end body content-->
        
    </body>
	<script>
        var num = 1;
        var form = document.getElementById("form");
        for(var i=0; i < 5; i++){
            addMore();
            num++;
        }
        
        function addMore(){
            addInput("name");
            addInput("age");
            addRadio("male");
            addRadio("female");
        }

        function addInput(type){
            var newDiv = document.createElement("div");
            var newInput = document.createElement("input");
            newInput.type = "text";
            newInput.className = "validate";
            if (type == "name"){
                newDiv.classList.add("col", "s6");
                newInput.id = "name" + num;
            }
            else if(type == "age"){
                newDiv.classList.add("col", "s2");
                newInput.id = "age" + num;
            }
            newDiv.appendChild(newInput);
            form.appendChild(newDiv);
        }
        
        function addRadio(gender){
            var newDiv = document.createElement("div");
            newDiv.classList.add("col", "s2");
            var newP = document.createElement("p");
            newP.className = "center-align";
            var newInput = document.createElement("input");
            newInput.type = 'radio';
            if (gender == "male"){
                newInput.id = "genderM" + num;
            }
            else if(gender == "female"){
                newInput.id = "genderF" + num;
            }
            var newLabel = document.createElement("label");
            newLabel.for = newInput.id;
            newP.appendChild(newInput);
            newP.appendChild(newLabel);
            newDiv.appendChild(newP);
            form.appendChild(newDiv);
        }

        function startTest(){
            //insert group to database
            //get number of kids
            var groupSize = document.getElementById("form").childElementCount / 4;
        }

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