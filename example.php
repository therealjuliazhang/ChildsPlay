<!--
Title:Example; 
Author:Phuong Linh Bui (5624095); 
-->
<?php
/*include 'results.php';
if(isset($_POST["action"])){
	echo "Successfully connect";
}*/
?>
<html>
<head>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
-->
    <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script><!---->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
</head>
<body>
<label for="access_rights">Select Access Rights</label>
<select id="access_rights" onchange="displayValues();" multiple>  
  <option value="default" disabled>Choose your options</option>        
  <option value="create">Create</option>                     
  <option value="read">Read</option>                         
  <option value="update">Update</option>                     
  <option value="delete">Delete</option>                 
</select> 
<script>
$(document).ready(function() {
    $('select').material_select();
});
var selectedOptions=[
  "create",
  "update"
];

$.each(selectedOptions, function(i,e){
    $("#access_rights option[value='" + e + "']").prop("selected", true);
});

function displayValues(){
	var selected = $("#access_rights").val();
	console.log("Selected: " + selected);
}
</script>
</body>
</html>
  