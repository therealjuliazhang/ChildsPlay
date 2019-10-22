<!--
Title:User Page;
Author:Zhixing Yang(5524726), Phuong Linh Bui (5624095), Alex Satoru Hanrahan (4836789), Julia Aoqi Zhang (5797585), Ren Sugie(5679527);
-->
<?php
include "adminAccess.php";
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
  <div class="preloader-wrapper big active">
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
    <!--end body content-->
  </body>
  <script>
  //Sorting The table contents
  $(document).ready(function() {
  $("table").tablesorter();
  });
  //Initialise tabs
  $(document).ready(function(){
    $('.tabs').tabs();
  });
  //remove a declined row
  $('.declineButton').click(function() {
    $(this).closest('tr').remove();
  });
  //remove an accepted row
  $('.acceptButton').click(function() {
    $(this).closest('tr').remove();
  });

</script>

<style media="screen">
.container{
  margin-top: 25px;
  width: 900px;
}


.tabs .tab a:focus, .tabs .tab a:focus.active {
  background-color: rgba(38, 166, 154, 0.2);
  outline: none;
}
.tabs .tab a:hover, .tabs .tab a.active {
  background-color: rgba(38, 166, 154, 0.2);
  color: #ee6e73;
}
#profileLinkButton {
  padding-left: 16px;
  padding-right: 16px;
}
#profileLinkIcon{
  font-size: 24px;
}
ul.tabs {
  float: center;
  max-width: 99%;
  overflow-x: hidden;
}
.tabs{
  margin-bottom: 10px;
}
.tabs .tab {
  text-transform: none;
}

.tablesorter-header {
  cursor: pointer;
  outline: none;
}
.tablesorter-header-inner::after {
  content: '▼';
  font-size: 12px;
  margin-left: 5px;
}
td .btn{
  width: 120px;
}
.acceptButton:hover, .testButton:hover{
  background-color: #FF8C18!important;
}

</style>
</html>
