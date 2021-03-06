<!--
==========================================================================================
Title:Educator Add Group;
Author:Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Ren Sugie(5679527);
==========================================================================================
-->
<!DOCTYPE html>

<html>
<?php
include 'db_connection.php';
$conn = OpenCon();
include "educatorAccess.php";
//fetch locations for select drop down
$locations = array();
$sql = $conn->prepare("SELECT locationID FROM LOCATIONASSIGNMENT WHERE userID=?");
$sql->bind_param("i", $userID);
$sql->execute();
$result = $sql->get_result();
while($row = $result->fetch_assoc()){
  $sql2 = "SELECT * FROM LOCATION WHERE locationID=".$row["locationID"];
  $result2 = $conn->query($sql2);
  while($value = mysqli_fetch_assoc($result2))
    $locations[] = $value;
}
$sql->close();
?>
<head>
  <title>Add New Group For Educator</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script type = "text/javascript" src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script type = "text/javascript" src = "https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
  <script type = "text/javascript" src = "addPreschoolerRow.js"></script>
</head>
<!--the stuff in the head is all the linking things to Materialize-->
<!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
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
    <h4 class="blue-text text-darken-4">Add New Group</h4>
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
        <a class="addButton waves-effect waves-light btn blue darken-4 tooltipped" data-position="right" data-tooltip="Add more" onclick="addRow(); updateToolTips()"><i class="material-icons"style="font-size:30px;">add</i></a>
      </div>
      <div class="row right-align">
        <input type="submit" name="submit" class="submit waves-effect waves-light btn blue darken-2 buttons" value="Save">
        <a href="educatorTests.php#groups" class="waves-effect waves-light btn blue darken-4  buttons">Cancel</a>
      </div>
    </form>
  </div>
  <!--end body content-->
</body>
<script>
$(document).ready(function() {
  //initiate tooltip
  $('.tooltipped').tooltip();
  //Initialize Selector
  $(document).ready(function(){
    $('select').material_select();
  });
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
  //set locations into select options
  var locations = <?php echo json_encode($locations); ?>;
  for(var i=0; i<locations.length; i++){
    var option = document.createElement("option");
    option.value = locations[i]['locationID'];
    option.name = locations[i]['name'];
    option.innerHTML = locations[i]['name'];
    document.getElementById("locationSelect").appendChild(option);
  }
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
        remote: jQuery.validator.format("{0} is already an existing group made by other user.")
      },
      locationSelect: {
        required: "Please pick your location from the drop down menu."
      }
    }
  });
});
// add rows for preschooler data
var num = 1;
var rowsDiv = document.getElementById("rows");
for(var i=0; i<3; i++){
  addRow();
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
.icon-red {
  color: #CA3433;
  padding-top: 10px;
}
/*changes cursor when hovring over remove button*/
.changeCursor {
  cursor: pointer;
}

.buttons{
  width: 100px;
}
.submit:hover, .addButton:hover, .buttons:hover{
  background-color: #FF8C18!important;
}
</style>
</html>
