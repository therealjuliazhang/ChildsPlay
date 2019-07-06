<head>
        <title>Likert Scale Task</title>
		<!--links for Materialize-->
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
		<script type="text/javascript" src="javascript/scripts.js"></script>
		<!--link for font awesome icons-->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<style>
		.border{
			border:10px solid #586F80;
			width: 100%;
		}
		.left-align{
			position:relative;
			left: 100%;
		}
		.right-align{
			position:relative;
			right: 100%;
		}
		</style>
    </head>

    <body>
        <!--no header needed for test pages-->
        <!-- body content -->

			<img src="images/greyCircle.png" width="7%" align="right" onclick="goNext();"></img>

		<div class="container">
        
			<table>
				<tr>
					<td width="15%"></td>
					<td width="70%">
						<div class="center-align"><img src="images/Puff.jpg" width="90%"></img></div>
					</td>
					<td width="15%"></td>
				</tr>
				
			</table>
            <!--all container does is create padding on the left & right sides.-->
            <!--row for kid's name-->
		</div>
		
		<table>
		<tr class="border">
					<td width="25%" style="vertical-align:bottom">
						<div class="left-align">
							<!--sad face-->
							<img src="images/sad.jpg" onclick="sadClicked()" width="70%"></img>
						</div>
					</td>
					<td width="50%"></td>
					<td width="25%" style="vertical-align:bottom">
						<div class="right-align">
							<!--happy face-->
							<img id="happy" src="images/happy.jpg" onclick="happyClicked()" width="70%"></img>
						</div>
					</td>
				</tr>
		</table>
		<!--end container-->
        <div class="row amber accent-4" style="font-size:35px;font-weight:bold">
			<div class="center-align">
				<span id="preschoolerName">Aiden</span>'s Turn
			</div>
		</div>
        <!--end body content-->

    </body>
	<script>
		function sadClicked()
		{
			alert("kid hates it");
		}
		function happyClicked()
		{
			alert("kid likes it");
		}
	</script>
    <style>
    </style>
</html>