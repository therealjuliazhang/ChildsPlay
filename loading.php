<!--
=======================================
Title: Loading Page;
Phuong Linh Bui (5624095);
=======================================
-->
<?php
include "adminAccess.php";
include 'db_connection.php';
$conn = OpenCon();
?>
<!DOCTYPE html>
<html>
<head>
  <title>User Page</title>
  <meta name = "viewport" content = "width = device-width, initial-scale = 1">
  <link rel="stylesheet" type="text/css" href="childsPlayStyle.css">
  <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
  <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>

</head>
<body>
  <!--header-->
  <div id="InsertHeader"></div>
  <script>
  //Read header
  $(function(){
    $("#InsertHeader").load("header.html");
  });
  </script>
  <!--end header-->

  <!-- body content -->
  <div style="top:100px;width:100%;text-align:center;position:relative;">
  <div class="preloader-wrapper big active" style="width:200px;height:200px;">
       <div class="spinner-layer spinner-blue">
         <div class="circle-clipper left">
           <div class="circle"></div>
         </div><div class="gap-patch">
           <div class="circle"></div>
         </div><div class="circle-clipper right">
           <div class="circle"></div>
         </div>
       </div>
       <div class="spinner-layer spinner-red">
         <div class="circle-clipper left">
           <div class="circle"></div>
         </div><div class="gap-patch">
           <div class="circle"></div>
         </div><div class="circle-clipper right">
           <div class="circle"></div>
         </div>
       </div>
       <div class="spinner-layer spinner-yellow">
         <div class="circle-clipper left">
           <div class="circle"></div>
         </div><div class="gap-patch">
           <div class="circle"></div>
         </div><div class="circle-clipper right">
           <div class="circle"></div>
         </div>
       </div>
       <div class="spinner-layer spinner-green">
         <div class="circle-clipper left">
           <div class="circle"></div>
         </div><div class="gap-patch">
           <div class="circle"></div>
         </div><div class="circle-clipper right">
           <div class="circle"></div>
         </div>
       </div>
     </div>
  <div style="position:relative;top:40px;font-style:italic"><h5>Loading...</h5></div>
  <div id="results"></div>
  </div>
  <?php
  
  if(isset($_GET["uid"]) && isset($_GET["accepted"])){
    $userID = $_GET["uid"];
    $accepted = $_GET["accepted"];
  }
  ?>
    <!--end body content-->
  </body>
  <script>
  $(document).ready(function() {
    var userid = <?php echo json_encode($userID); ?>;
    var accepted = <?php echo json_encode($accepted); ?>;
    $.post("updateUserPage.php",
          {	
            userid: userid,
            accepted: accepted
          },
          function(data){
            //show errors
            if(data.includes("span")){
              $("#results").html(data);
            }
            else{
              window.location = "userPage.php";
            }
          }
        );
  });
</script>
</html>
