<!--
Title:Educator Edit Group;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
-->
<!DOCTYPE html>

<html>
    <?php
        include 'db_connection.php';
        $conn = OpenCon();
        //get userID
        // if(isset($_GET["userID"]))
        //     $userID = (int)str_replace('"', '', $_GET["userID"]);
        session_start();
        if(isset($_SESSION['userID']))
            $userID = $_SESSION['userID'];
        else
            header('login.php');
        //get groupID
        if(isset($_GET["groupID"]))
            $groupID = (int)str_replace('"', '', $_GET["groupID"]);
        //get current group name from database
        $sql = "SELECT name FROM GROUPTEST WHERE groupID = " . $groupID;
        $result = $conn->query($sql);
        $currentGroupName = mysqli_fetch_assoc($result)["name"];
        //get current location of group
		$sql = "SELECT name, locationID FROM GROUPTEST WHERE groupID=".$groupID;
        $result = $conn->query($sql);
		$values = mysqli_fetch_assoc($result);
		$groupName = $values["name"];
        $currentLocationID = $values["locationID"];
        //fetch locations for select drop down
        $sql2 = "SELECT locationID FROM LOCATIONASSIGNMENT WHERE userID=".$userID;
        $result2 = $conn->query($sql2);
        $locations = array();
		while($row = mysqli_fetch_assoc($result2)){
			$query = "SELECT * FROM LOCATION WHERE locationID=".$row["locationID"];
			$qResult = $conn->query($query);
			while($value = mysqli_fetch_assoc($qResult))
				$locations[] = $value;
		}
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
        <script type = "text/javascript" src = "addPreschoolerRow.js"></script>
    </head>
    <body>
        <!--header-->
        <div id="InsertHeader"></div>
        <script>
          //Read header
          $(function(){
            $("#InsertHeader").load("educatorHeader.html");
          });
        </script>
        <!--end header-->
        <!-- body content -->
        <div class="container" style="font-size:18px">
                <h5 class="blue-text darken-2">Edit Group</h5>
                 <form id="form" style="font-size:18px" action='updateGroup.php?userID=<?php echo json_encode($userID); ?>&groupID=<?php echo json_encode($groupID); ?>' method="post">
                    <div class="row">
                        <div class="input-field col s12">
                            <input class="validate" id="groupName" type="text" name="groupName" value="<?php echo $groupName;?>" />
                            <label for="groupName">Group Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select id="locationSelect" class="materialSelect" name="locationSelect" required>
                            <!-- <option id="currentLocation"></option> -->
                            </select>
                            <label id="locationLabel" for="locationSelect" >Group Location</label>
                        </div>
                    </div>
                    Please input the details for each test participant:
                    <div id ="rows"></div>
                    <div class="row right-align">
                        <a class="waves-effect waves-light btn blue darken-4 tooltipped" data-position="right" data-tooltip="Add more" onclick="addRow()"><i class="material-icons"style="font-size:30px;">add</i></a>
                    </div><br/>
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
            /*var name =
            $("#groupName").val(name);
				//document.getElementById("groupName").innerHTML = groupName;
            */
			//set locations into select options
            var locations = <?php echo json_encode($locations); ?>;
            var currentLocationID = <?php echo json_encode($currentLocationID); ?>;
            var groupID = <?php echo json_encode($groupID); ?>;
            var currentGroupName = <?php echo json_encode($currentGroupName); ?>;
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
                                //forEdit: "forEdit",
                                currentGroupName: currentGroupName
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
    </style>
</html>
