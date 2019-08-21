<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <title>ProfilePage</title>
    <meta name = "viewport" content = "width = device-width, initial-scale = 1">
    <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
  </head>

<body>
<!--Header-->
    <div class="navbar-fixed">
    <nav class="nav-extended blue darken-4">
    <div class="nav-wrapper">
    <a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
    <ul id="nav-mobile" class="left hide-on-med-and-down">
    <li  class="active"><a href="">Tests</a></li>
    <li><a href="">Create</a></li>
    <li><a href="" >Results</a></li>
    <li><a href="">Users</a></li>
    </ul>
    </div>
    </nav>
    </div>
<!--End Header-->
<!--Sidebar-->
<div>
<ul id="sidebar" class="sidenav sidenav-fixed #ffffff white tab-group">
      <li class="tab is-active"><a>Ren</a></li>
      <li class="tab"><a>Alex</a></li>
      <li class="tab"><a>Julia</a></li>
</ul>
<a class="waves-effect waves-light btn blue darken-2" id="submitButton">Submit</a>

</div>
<!--End Sidebar-->
<!--Main content-->
<div class="panel-group">
<!--Content A (Ren's turn)-->
<div class="panel is-show">
<div class="container" id="mainContainer">
  <div class="row">
    <!--1st row-->
    <div class="col s12" id="questionCol"><h5 class="blue-text darken-2">How Does Ren interact with the image?</h5></div>
    <!--2nd row-->
    <div class="col s3 operationCol"><p class="operation">Press:</p></div>
    <div class="col s3 operationCol"><p class="operation">Zoom/Pinch:</p></div>
    <div class="col s3 operationCol"><p class="operation">Swipe/Drag:</p></div>
    <div class="col s3 operationCol"><p class="operation">Other:</P></div>
    <!--3rd row-->
    <div class="col s3 operationCol">
      <form action="#">
      <label>
      <input type="checkbox" />
      <span></span>
      </label>
    </div>
    <div class="col s3 operationCol">
      <label>
      <input type="checkbox" />
      <span></span>
      </label>
    </div>
    <div class="col s3 operationCol">
      <label>
      <input type="checkbox" />
      <span></span>
      </label>
    </div>
    <div class="col s3 operationCol">
      <label>
      <input type="checkbox" />
      <span></span>
      </label>
      </form>
    </div>
  <!--4th and other row-->
  <div class="col s12" id="commentCol"><h5 class="blue-text darken-2">Comment:</h5></div>
  <div class="col s12">
    <form class="col s12">
    <div class="input-field col s12">
    <textarea id="textarea1" class="materialize-textarea"></textarea>
    </div>
    </form>
  </div>
  <div class="col s12"><a class="waves-effect waves-light btn blue darken-2 right" id="saveButton">save</a></div>
  </div>

</div>
</div>

<!--Content B(Alex's turn)-->
<div class="panel">
  <div class="container" id="mainContainer">
    <div class="row">
      <!--1st row-->
      <div class="col s12" id="questionCol"><h5 class="blue-text darken-2">How Does Alex interact with the image?</h5></div>
      <!--2nd row-->
      <div class="col s3 operationCol"><p class="operation">Press:</p></div>
      <div class="col s3 operationCol"><p class="operation">Zoom/Pinch:</p></div>
      <div class="col s3 operationCol"><p class="operation">Swipe/Drag:</p></div>
      <div class="col s3 operationCol"><p class="operation">Other:</P></div>
      <!--3rd row-->
      <div class="col s3 operationCol">
        <form action="#">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
        </form>
      </div>
    <!--4th and other row-->
    <div class="col s12" id="commentCol"><h5 class="blue-text darken-2">Comment:</h5></div>
    <div class="col s12">
      <form class="col s12">
      <div class="input-field col s12">
      <textarea id="textarea1" class="materialize-textarea"></textarea>
      </div>
      </form>
    </div>
    <div class="col s12"><a class="waves-effect waves-light btn blue darken-2 right" id="saveButton">save</a></div>
    </div>

  </div>
</div>

<!--Content B(Julia's turn)-->
<div class="panel">
  <div class="container" id="mainContainer">
    <div class="row">
      <!--1st row-->
      <div class="col s12" id="questionCol"><h5 class="blue-text darken-2">How Does Julia interact with the image?</h5></div>
      <!--2nd row-->
      <div class="col s3 operationCol"><p class="operation">Press:</p></div>
      <div class="col s3 operationCol"><p class="operation">Zoom/Pinch:</p></div>
      <div class="col s3 operationCol"><p class="operation">Swipe/Drag:</p></div>
      <div class="col s3 operationCol"><p class="operation">Other:</P></div>
      <!--3rd row-->
      <div class="col s3 operationCol">
        <form action="#">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
      </div>
      <div class="col s3 operationCol">
        <label>
        <input type="checkbox" />
        <span></span>
        </label>
        </form>
      </div>
    <!--4th and other row-->
    <div class="col s12" id="commentCol"><h5 class="blue-text darken-2">Comment:</h5></div>
    <div class="col s12">
      <form class="col s12">
      <div class="input-field col s12">
      <textarea id="textarea1" class="materialize-textarea"></textarea>
      </div>
      </form>
    </div>
    <div class="col s12"><a class="waves-effect waves-light btn blue darken-2 right" id="saveButton">save</a></div>
    </div>

  </div>
</div>
</div>

</body>
<script>

//Initialization of Sidebar
$(document).ready(function(){
    $('.sidenav').sidenav();
  });
//FUnction for switching tabs
$(function($){
	$('.tab').click(function(){
  	$('.is-active').removeClass('is-active');
  	$(this).addClass('is-active');
  	$('.is-show').removeClass('is-show');
    // Get the index number from user click
  	const index = $(this).index();
    // display the new content
  	$('.panel').eq(index).addClass('is-show');
  });
});
</script>



<style>
/*CSS for header*/
#body {
padding-left: 330px;
}
@media only screen and (max-width : 992px) {
    #body{
        padding-left: 0;
    }
}
.brand-logo{
    margin-top:-67px;
}
.nav-wrapper > ul {
    margin-left: 220px;
}
.header{
    margin-top: 30px;
}
/*CSS for sidebar*/
#sidebar{
  margin-top: 64px;
}
#submitButton{
  position: fixed;
  bottom: 10px;
  left: 10px;
  z-index: 1000;
  height: 50px;
  width: 280px;
  font-size: 25px;
}
/*CSS for Main content*/
#mainContainer{
  margin-left: 400px;
  margin-top: 80px;
}
.operationCol{
  text-align: center;
}
.operation{
  font-size: 20px;
  margin-right: 100px;
}
#saveButton{
  margin-right: 21px;
}
#questionCol{
  height: 70px;
}
#commentCol{
  margin-top: 100px;
}

.panel{
    display:none;
}
.panel.is-show{
    display:block;
}
.is-active{
  background-color: #eceff1;
}

</style>
</html>
