<html>
    <head>
        <title>Child'sPlay</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
            <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
                <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
                    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
                    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                    <script>
                        
                    
                    
                                        
                    document.addEventListener('DOMContentLoaded', function() {
						var elems = document.querySelectorAll('select');
						var instances = M.FormSelect.init(elems);
					});
					
                    
                    
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
							<li class="active"><a href="">Edit</a></li>
                            <li><a href="">Users</a></li>
                        </ul>
                        <ul id="logoutButton" class="right hide-on-med-and-down logout">
                            <li><a class="waves-effect waves-light btn blue darken-2 right" onclick="">Profile</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
        <!--end header-->
        
       
        
        
        
        <!-- body content -->
        <div id="body" class="container">
			<!--start form-->
            <form>

            <div class="row">
                <div class="col s6">
                    <h5 class="blue-text darken-2 header">
                        Task Title:
                    </h5>
                </div>
                <div class="col s6">
                    <h5 class="blue-text darken-2 header">
                        Instruction
                    </h5>
                </div>
            </div>

			
			<div class="row">
				<div class="input-field col s6">
					<input placeholder="Task 10" id="testTitle" type="text">
				</div>


                <div class="input-field col s6">
                    <input placeholder="Identify the eyes of the monster" id="Activity" type="text">
                </div>
			</div>
            </br>

			<div class="row">
                <div class="col s6">
                <h5 class="blue-text darken-2 header">
                    Image
                </h5>
                </div>
                <div class="col s6">
                    <h5 class="blue-text darken-2 header">
                        Activity Style:
                    </h5>
                </div>
			</div>

			
			<div class="row">
				<div class="col s6">
				<!--start upload button + path display-->
				<div class="file-field input-field">
					<div class="waves-effect waves-light btn blue darken-4">
						<span>Upload</span>
						<input type="file">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path" type="text" placeholder="E:\Project 321\Instructions Page\images\testImage.jpg">
					</div>
				</div>
				<!--end upload button + path-->
				</div>
                <div class="col s6">
                    <div class="input-field col s12">
                        <select>
                            <option value="" selected>Identify Body Part</option>
                            <option value="1">Likert Scale</option>
                            <option value="2">Character Ranking</option>
                            <option value="3">Preferred Mechanics</option>
                        </select>
                    </div>
                </div>
			</div>
			<div class="row">
                <img id="OriginalImage" class="image" src="images/Orbi.png" style="width:15%;">
			</div>
			
			</form>
			<!--end form-->
			<br/><br/>
			<div class="row">
			<div class="col s12">
				<p align="right">
					<a class="waves-effect waves-light btn blue darken-2">Create Question</a>
					<a class="waves-effect waves-light btn blue darken-4">Cancel</a>
				</p>
			</div>
			</div>
			
		</div>
		<!--end body content-->
    </body>
    <style>
        
    .brand-logo{
        margin-top:-67px;
    }
    .logout{
        margin-top: 15px;
        margin-right:15px;
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
