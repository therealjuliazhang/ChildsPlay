<head>
	<title>Identify Body Parts Task</title>
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
	<script>
	var canvas, ctx, canX, canY = 0;
	
	window.onload = function() {
		canvas = document.getElementById("myCanvas");
		ctx = canvas.getContext("2d");
		var img = new Image(543, 648);
		
		img.onload = function() {
			ctx.drawImage(img, 543/2-543/3, 648/2-648/3, 543/1.5, 648/1.5);
		}
		img.src = 'images/Puff.jpg';
		canvas.addEventListener("mousedown", mouseDown, false);
		canvas.addEventListener("touchstart", touchDown, false);
	}
	function mouseDown(e) {
		if (!e)
			var e = event;
		canX = e.pageX - canvas.offsetLeft;
		canY = e.pageY - canvas.offsetTop;
		ctx.fillStyle = 'red';
		ctx.beginPath();
		ctx.arc(canX, canY, 5, 0, 2 * Math.PI);
		ctx.stroke();
		ctx.fill();
	}
		
	function touchDown(e) {
		if (!e)
			var e = event;
		e.preventDefault();
		canX = e.targetTouches[0].pageX - canvas.offsetLeft;
		canY = e.targetTouches[0].pageY - canvas.offsetTop;
		ctx.fillStyle = 'red';
		ctx.beginPath();
		ctx.arc(canX, canY, 5, 0, 2 * Math.PI);
		ctx.stroke();
		ctx.fill();
	}	
	</script>
</head>
<body>
	<!-- body content -->
	<img id="button" src="images/greyCircle.png" width="7%" onclick="goNext();"></img>
	<canvas id="myCanvas" width="543" height="648">
		Your browser does not support the HTML5 canvas tag.
	</canvas>  
	<!--end body content-->
</body>
<script>
</script>
<style>
	#myCanvas{
		padding: 0;
		margin: auto;
		display: block;
	}
	#button{
		position: absolute;
		right: 0px;
	}
</style>
</html>