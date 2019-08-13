<html>
    <?php 
        include 'db_connection.php';
        $conn = OpenCon();
        //get userID
        if(isset($_GET["userID"]))
            $userID = (int)str_replace('"', '', $_GET["userID"]);
        //get groupID
        if(isset($_GET["groupID"]))
            $groupID = (int)str_replace('"', '', $_GET["groupID"]);
        //get group name from database
        $sql = "SELECT name FROM GROUPTEST WHERE groupID = " . $groupID;
        $result = $conn->query($sql);
        $groupName = mysqli_fetch_assoc($result)["name"];
        //get current location of group		
		$sql = "SELECT name, locationID FROM GROUPTEST WHERE groupID=".$groupID;
        $result = $conn->query($sql);
		$values = mysqli_fetch_assoc($result);
		$groupName = $values["name"];
        $currentLocationID = $values["locationID"];
        //fetch locations for select drop down
        $sql2 = "SELECT * FROM LOCATION";
        $result2 = $conn->query($sql2);
        $locations = array();
        while($row = mysqli_fetch_assoc($result2))
            $locations[] = $row;
        //fetch preschoolerIDs from groupassignment table
        $sql = "SELECT preID FROM GROUPASSIGNMENT WHERE groupID = " . $groupID ." AND userID=".$userID;
        $result = $conn->query($sql);
        $preschoolerIDs = array();
        while($row = mysqli_fetch_assoc($result))
            $preschoolerIDs[] = $row;
        //fetch preschoolers from database
        $preschoolers = array();
        foreach($preschoolerIDs as $value){
            $sql = "SELECT * FROM PRESCHOOLER WHERE preID = " . $value['preID'];
            $result = $conn->query($sql);
            while($row = mysqli_fetch_assoc($result))
                array_push($preschoolers, $row);
        }
    ?>
    <head>
        <title>Edit Group for Educator</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
        <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
    </head>
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
                <h5 class="blue-text darken-2">Edit Group</h5>
                 <form id="form" style="font-size:18px" action='updateGroup.php?userID=<?php echo json_encode($userID); ?>&&groupID=<?php echo json_encode($groupID); ?>' method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input class="validate" id="groupName" type="text" name="groupName" value="<?php echo $groupName;?>" />
                            <label for="groupName">Group Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="locationSelect" class="materialSelect" name="locationSelect" required>
                            <option id="currentLocation"></option>
                            </select>
                            <label id="locationLabel" for="locationSelect" >Group Location</label>
                        </div>
                    </div>
                    Please input the details for each test participant:
                    <div id ="rows"></div>
                    <div class="row right-align">
                        <a class="waves-effect waves-light btn blue darken-4 tooltipped" data-position="right" data-tooltip="Add more" onclick="addEmptyRow()"><i class="material-icons"style="font-size:30px;">add</i></a>
                    </div>
                    <div class="row right-align">
                        <input type="submit" id="startButton" class="submit waves-effect waves-light btn blue darken-2" value="Save Changes">
                        <a href="educatorTests.php#groups" class="waves-effect waves-light btn blue darken-4">Cancel</a>
                    </div>  
                </form>
        </div>
        <!--end body content-->
    </body>
	<script>
        $(document).ready(function() {
            Materialize.updateTextFields();
            //initiate select input
            $('select').material_select();
            $('.materialSelect').on('contentChanged', function() {
                $(this).material_select();
            });
            //set group name
            /*var name = <?php echo json_encode($groupName); ?>;
            $("#groupName").val(name);
				//document.getElementById("groupName").innerHTML = groupName;
            */
			//set locations into select options
            var locations = <?php echo json_encode($locations); ?>;
            var currentLocationID = <?php echo json_encode($currentLocationID); ?>;
            var groupID = <?php echo json_encode($groupID); ?>;
            for(var i=0; i<locations.length; i++){
				var loc = locations[i];
                if(loc['locationID']==currentLocationID){
                    $("#currentLocation").value = loc['locationID'];
                    $("#currentLocation").name = loc['name'];
                    $("#currentLocation").html(loc['name']);
                }
                else{
                    var option = document.createElement("option");
                    option.value = locations[i]['locationID'];
                    option.name = locations[i]['name'];
                    option.innerHTML = locations[i]['name'];
                    $("#locationSelect").append(option);
                }
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
                            type: "post",
                            data: {
                                groupNameForEdit: groupName
                            }
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
        // create preschooler rows
        var preschoolers = <?php echo json_encode($preschoolers); ?>;
        for(var i=0; i<preschoolers.length; i++){
            addRow(preschoolers[i]);
        }
        function addRow(preschooler){
            var newRow = document.createElement("div");
            newRow.className = ("row");
            addInput("name", newRow, preschooler);
            addInput("age", newRow, preschooler);
            addRadio("male", newRow, preschooler);
            addRadio("female", newRow, preschooler);
            var iconDiv = document.createElement("div");
            //implements remove row
            iconDiv.addEventListener("click", function() {
                rowsDiv.removeChild(newRow);
            }, false);
            iconDiv.classList.add("col", "s1", "changeCursor");
            var removeIcon = document.createElement("i");
            removeIcon.classList.add("material-icons", "medium", "icon-red", "tooltipped"); 
            removeIcon.innerHTML = "remove";
            removeIcon.setAttribute("data-position", "right");
            removeIcon.setAttribute("data-tooltip", "Remove row");
            iconDiv.appendChild(removeIcon);
            newRow.appendChild(iconDiv);
            rowsDiv.appendChild(newRow);
            num++;
        }
        //creates text field input
        function addInput(type, row, preschooler){
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
                newInput.value = preschooler['name'];
                newInput.type = "text";
                newLabel.innerHTML = "Name";
            }
            else if(type == "age"){
                newDiv.classList.add("input-field", "col", "s2");
                newInput.id = "age" + num;
                newInput.name = "age" + num;
                newInput.value = preschooler['age'];
                newInput.type = "number";
                newLabel.innerHTML = "Age";
            }
            newLabel.htmlFor = newInput.id;
            newDiv.appendChild(newInput);
            newDiv.appendChild(newLabel);
            row.appendChild(newDiv);
        }
        // //creates radio button
        function addRadio(gender, row, preschooler){
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
                if(preschooler['gender']=="Male")
                    newInput.checked = true;
                newLabel.innerHTML = "Male";
            }
            else if(gender == "female"){
                newInput.id = "genderF" + num;
                newInput.name = "gender" + num;
                newInput.value = "Female";
                if(preschooler['gender']=="Female")
                    newInput.checked = true;
                newLabel.innerHTML = "Female";
            }
            newLabel.htmlFor = newInput.id;
            newP.appendChild(newInput);
            newP.appendChild(newLabel);
            newDiv.appendChild(newP);
            row.appendChild(newDiv);
        }
        //creates empty row for inputing for preschool data
        function addEmptyRow(){
            var newRow = document.createElement("div");
            newRow.className = ("row");
            addEmptyInput("name", newRow);
            addEmptyInput("age", newRow);
            addUncheckedRadio("male", newRow);
            addUncheckedRadio("female", newRow);
            var iconDiv = document.createElement("div");
            //implements remove row
            iconDiv.addEventListener("click", function() {
                rowsDiv.removeChild(newRow);
            }, false);
            iconDiv.classList.add("col", "s1", "changeCursor");
            var removeIcon = document.createElement("i");
            removeIcon.classList.add("material-icons", "medium", "icon-red", "tooltipped"); 
            removeIcon.innerHTML = "remove";
            removeIcon.setAttribute("data-position", "right");
            removeIcon.setAttribute("data-tooltip", "Remove row");
            iconDiv.appendChild(removeIcon);
            newRow.appendChild(iconDiv);
            rowsDiv.appendChild(newRow);
            num++;
        }
        
        // //creates empty text field input
        function addEmptyInput(type, row){
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
        // //creates unchecked radio button
        function addUncheckedRadio(gender, row){
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
     i.icon-red {
        color: #CA3433;
        padding-top: 10px;
    } 
    .changeCursor { 
        cursor: pointer; 
    }
    #startButton{
        padding-top: 7px;
    }
    </style>
</html>
