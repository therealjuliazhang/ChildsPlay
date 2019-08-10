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
        <title>Add New Group For Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
        <!-- <script type = "text/javascript" src = "formValidation.js"></script> -->
        <!-- <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/additional-methods.min.js"></script> -->
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
                <h5 class="blue-text darken-2">Add New Group</h5>
                 <form id="form" style="font-size:18px" action="insertGroup.php" method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input class="validate" id="groupName" type="text" name="groupName" >
                            <label for="groupName">Group Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="locationSelect" class="materialSelect" name="locationSelect" required>
                            <option value="" >Choose your location</option>
                            </select>
                            <label id="locationLabel" for="locationSelect" >Group Location</label>
                        </div>
                    </div>
                    Please input the details for each test participant:
                    <div id ="rows"></div>
                    <div class="row right-align">
                        <a class="waves-effect waves-light btn blue darken-4" onclick="addRow()"><i class="material-icons"style="font-size:30px;">add</i></a>
                    </div>
                    <div class="row right-align">
                        <input type="submit" id="startButton" class="submit waves-effect waves-light btn blue darken-2" value="Start Test">
                        <a href="educatorTests.php" class="waves-effect waves-light btn blue darken-4">Cancel</a>
                    </div>  
                </form>
        </div>
        <!--end body content-->
    </body>
	<script>
        $(document).ready(function() {
            //initiate select input
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
                document.getElementById("locationSelect").appendChild(option);
            }
            $("#locationSelect").trigger('contentChanged');
            //Places error element next to invalid inputs
            $.validator.setDefaults({
                errorElement : 'div',
                errorClass: 'invalid',
                errorPlacement: function(error, element) {
                    if(element.attr('type') == "text" || element.attr('type') == "number"){
                        $(element)
                        .closest("form")
                        .find("label[for='" + element.attr("id") + "']")
                        .attr('data-error', error.text());
                    }
                    else if(element.hasClass("materialSelect")){
                        element.after(error);
                    }   
                    else if(element.attr('type')=="radio"){
                        element.before(error);
                    } 
                }
            })
            //set up rules and messages for errors
            $("#form").validate({
                rules: {
                    groupName: {
                        required: true,
                        remote: {
                            url: "checkGroupName.php",
                            type: "post"
                        }
                    }
                },
                messages: {
                    groupName: {
                        required: "Enter a group name.",
                        remote: jQuery.validator.format("{0} is already used by an existing group.")
                    },
                    locationSelect: "Pick your location from the drop down menu."
                }
            });
        });
        // add rows for preschooler data
        var num = 1;
        var rowsDiv = document.getElementById("rows");
        for(var i=0; i<3; i++){
            addRow();
        }
        // //creates a row for inputing for preschool data
        function addRow(){
            var newRow = document.createElement("div");
            newRow.className = ("row");
            addInput("name", newRow);
            addInput("age", newRow);
            addRadio("male", newRow);
            addRadio("female", newRow);
            var iconDiv = document.createElement("div");
            //implements remove row
            iconDiv.addEventListener("click", function() {
                rowsDiv.removeChild(newRow);
            }, false);
            iconDiv.classList.add("col", "s1", "changeCursor");
            var removeIcon = document.createElement("i");
            removeIcon.classList.add("material-icons", "medium", "icon-red"); 
            removeIcon.innerHTML = "remove";
            iconDiv.appendChild(removeIcon);
            newRow.appendChild(iconDiv);
            rowsDiv.appendChild(newRow);
            num++;
        }
        // //creates text field input
        function addInput(type, row){
            var newDiv = document.createElement("div");
            var newInput = document.createElement("input");
            var newLabel = document.createElement("label");
            newInput.className = "validate";
            newInput.setAttribute('required', "");
            newInput.setAttribute('aria-disabled', true);
            if (type == "name"){
                newDiv.classList.add("input-field", "col", "s5");
                newInput.id = "name" + num;
                newInput.name = "name" + num;
                newInput.type = "text";
                newLabel.innerHTML = "Name";
            }
            else if(type == "age"){
                newDiv.classList.add("input-field", "col", "s2");
                newInput.id = "age" + num;
                newInput.name = "age" + num;
                newInput.type = "number";
                newLabel.innerHTML = "Age";
            }
            newLabel.htmlFor = newInput.id;
            newDiv.appendChild(newInput);
            newDiv.appendChild(newLabel);
            row.appendChild(newDiv);
        }
        // //creates radio button
        function addRadio(gender, row){
            var newDiv = document.createElement("div");
            var newP = document.createElement("p");
            var newInput = document.createElement("input");
            var newLabel = document.createElement("label");
            newDiv.classList.add("col", "s2");
            newInput.type = 'radio';
            newInput.required = true;
            if (gender == "male"){
                newInput.id = "genderM" + num;
                newInput.name = "gender" + num;
                newInput.value = "Male";
                newLabel.innerHTML = "Male";
            }
            else if(gender == "female"){
                newInput.id = "genderF" + num;
                newInput.name = "gender" + num;
                newInput.value = "Female";
                newLabel.innerHTML = "Female";
            }
            newLabel.htmlFor = newInput.id;
            newP.appendChild(newInput);
            newP.appendChild(newLabel);
            newDiv.appendChild(newP);
            row.appendChild(newDiv);
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
    p{
        padding-top:8px;
    }
    label[data-error] {
        width: 100%;
        font-size: 12px;
    }
    .invalid{
        font-size: 12px;
        color: #EC453C;
    } 
    /*for the red remove button*/
     i.icon-red {
        color: #CA3433;
        padding-top: 10px;
    } 
    /*changes cursor when hovring over remove button*/
    .changeCursor { 
        cursor: pointer; 
    }
    #startButton{
        padding-top: 7px;
    }
    </style>
</html>
