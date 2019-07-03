<html>
<head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
		<script>
			window.onload = function() {
			//identify body parts results canvas
			  var c = document.getElementById("myCanvas");
			  var ctx = c.getContext("2d");
			  var img = new Image(240, 297);
			  img.src = 'images/Puff.jpg';
			  ctx.drawImage(img, 0, 0, img.width, img.height);
			//circles on canvas
			  ctx.fillStyle = 'red';
			  ctx.beginPath();
			  ctx.arc(100, 75, 5, 0, 2 * Math.PI);
			  ctx.stroke();
			  ctx.fill();
			  
			  ctx.fillStyle = 'blue';
			  ctx.beginPath();
			  ctx.arc(150, 50, 5, 0, 2 * Math.PI);
			  ctx.stroke();
			  ctx.fill();
			  
			  ctx.fillStyle = 'green';
			  ctx.beginPath();
			  ctx.arc(90, 60, 5, 0, 2 * Math.PI);
			  ctx.stroke();
			  ctx.fill();
			  
			  ctx.fillStyle = 'yellow';
			  ctx.beginPath();
			  ctx.arc(110, 85, 5, 0, 2 * Math.PI);
			  ctx.stroke();
			  ctx.fill();
			}
		</script>
    </head>
    <!--the stuff in the head is all the linking things to Materialize-->
    <!--all the linking's been done, so you shouldn't need to download anything from Materialise-->
    <body>
        <!--header-->
        <div class="row">
		<div class="navbar-fixed">
            <nav class="nav-extended blue darken-4">
                <div class="nav-wrapper">
					<a href="#" class="brand-logo left"><img src="images/logo1.png" ></a>
					<ul id="nav-mobile" class="left hide-on-med-and-down">
						<li><a href="">Tests</a></li>
						<li><a href="">Create</a></li>
						<li class="active"><a href="" >Results</a></li>
						<li><a href="">Users</a></li>
					</ul>
					<ul id="logoutButton" class="right hide-on-med-and-down logout">
						<li><a class="waves-effect waves-light btn blue darken-2 right" onclick="logout()">Logout</a></li>
					</ul>
                </div>
            </nav>
			</div>
        </div>
        <!--end header-->
		
		<!--side bar-->
		<ul id="sidebar" class="sidenav sidenav-fixed" >
		  <li class="active"><a href="">Wollongong Preschool Test 1</a></li>
		  <li><a href="">Wollongong Preschool Test 2</a></li>
		</ul>
		<!--end side bar-->
		
        <!-- body content -->
		<div id="body">
		<h5 class="blue-text darken-2 header">Identify Eye Task:</h5>
		Can you point to the monster's eyes?
		</br>
		<img class="image" src="images/Puff.jpg" style="width:15%;">
		</br>
		<h5 class="blue-text darken-2 header">Results:</h5>
		<canvas class="image" id="myCanvas" width="240" height="297" style="border:1px solid #d3d3d3;">
			Your browser does not support the HTML5 canvas tag.
		</canvas>   
		<!--end body content-->
    </body>
    <style>
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
    .logout{
        margin-top: 15px;
        margin-right:15px;
    }
	#sidebar{
		margin-top: 64px;
	}
	.nav-wrapper > ul {
	  margin-left: 220px;
	}
	.header{
		margin-top: 30px;
	}
	.image{
		margin-top: 10px;
	}
    </style>
</html>