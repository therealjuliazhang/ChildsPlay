<html>
    <head>
        <title>User Page</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
    </head>
    <body>
        <!--header-->
        <div class="row">
        <nav class="nav-extended blue darken-4">
            <div class="nav-wrapper">
				<div class="row">
					<div class="col s10">
						<a href="educatorTests.php" class="brand-logo"><img src="images/logo1.png" height="200px"></a>
					</div>
					<div class="col s2 offset-s10 ">
						<a class="waves-effect waves-light btn blue darken-2 center-align" id="profileLink" href="adminProfile.php"> <i class="material-icons" id="profileIcon">account_box</i></a>
						<!--<a class="waves-effect waves-light btn blue darken-2" id="profileLink" href="adminProfile.php"><i class="material-icons">account_box</i></a>-->
					</div>
				</div>
            </div>
        </nav>
        </div>
        <!--end header-->

        <!-- body content -->
        <div class="container">
			<ul class="tabs ">
				<li class="tab col s3"><a class="blue-text darken-2" href="#pendingUsers">Pending Users</a></li>
				<li class="tab col s3"><a class="blue-text darken-2" href="#educators">Educators</a></li>
        <li class="tab col s3"><a class="blue-text darken-2" href="#admin">Admin</a></li>
				<div class="indicator blue darken-2" style="z-index:1"></div>
			</ul>
			<table id="pendingUsers" class="striped">
				<thead class="blue-text darken-2">
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Organization</th>
						<th>Role</th>
            <th width="10%">Accept</th>
            <th width="10%">Decline</th>
					</tr>
				</thead>
				<tbody class="grey-text text-darken-1">
          <tr>
            <td>Jenny Carter</td>
            <td>jenny75@gmail.com</td>
            <td>Mulberry hill preschool</td>
            <td>Educator</td>
            <td><a class="waves-effect waves-light btn">Accept</a></td>
            <td><a class="waves-effect waves-light btn #ff5252 red accent-2">Decline</a></td>
          </tr>
          <tr>
            <td>Kerry Price</td>
            <td>kezz1@hotmail.com</td>
            <td>Smith preschool</td>
            <td>Educator</td>
            <td><a class="waves-effect waves-light btn">Accept</a></td>
            <td><a class="waves-effect waves-light btn #ff5252 red accent-2">Decline</a></td>
          </tr>
          <tr>
            <td>Geff Smith</td>
            <td>gf356</td>
            <td>University of Wollongong</td>
            <td>Admin</td>
            <td><a class="waves-effect waves-light btn">Accept</a></td>
            <td><a class="waves-effect waves-light btn #ff5252 red accent-2">Decline</a></td>
          </tr>
				</tbody>
			</table>
			<div id="educators">
				<table class="striped">
					<thead class="blue-text darken-2">
						<tr>
							<td>Name</td>
							<td>Email</td>
							<td>Organisation</td>
              <td>Accessible Tests</td>
						</tr>
					</thead>
					<tbody class="grey-text text-darken-1">
            <tr>
              <td>Josh Mcartney</td>
              <td>Josh55@gmail.com</td>
              <td>Mullberry hill preschool</td>
              <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Tests</a></td>
            </tr>
            <tr>
              <td>Jasmine Flores</td>
              <td>jezz1@hotmail.com</td>
              <td>Smith preschool</td>
              <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Tests</a></td>
            </tr>
            <tr>
              <td>Natalie Read</td>
              <td>nr79@gmail.com</td>
              <td>Miranda kindergarden</td>
              <td><a class="waves-effect waves-light btn #0d47a1 blue darken-4">Tests</a></td>
            </tr>
					</tbody>
				</table>
			</div>
      <div id="admin">
        <table class="striped">
					<thead class="blue-text darken-2">
						<tr>
							<th>Name</th>
							<th>Email</th>
							<th>Organisation</th>
						</tr>
					</thead>
          <tbody class="grey-text text-darken-1">
            <tr>
							<td>Holly Tootell</td>
							<td>holly@gmail.com</td>
							<td>University of Wollongong</td>
						</tr>
            <tr>
							<td>Mark Freeman</td>
							<td>mark@gmail.com</td>
							<td>University of Wollongong</td>
						</tr>
            <tr>
							<td>Geff Smith</td>
							<td>gh356@uowmail.edu.au</td>
							<td>University of Wollongong</td>
						</tr>
          </tbody>

        </table>
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
	.tabs .tab .active {
	  background-color: rgba(38, 166, 154, 0.2);
	}
	#profileLink{
		margin-top: 15px;
	}
	#profileIcon{
		position: absolute;
		top: -14px;
		left: 15px;

	}
    </style>
</html>
