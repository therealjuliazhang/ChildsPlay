<!DOCTYPE html>

<html>
	<?php
    session_start();
    unset($_SESSION['testID']);
    unset($_SESSION['groupID']);
    unset($_SESSION['tasks']);
    unset($_SESSION['mode']);
    ?>
    <head>
        <title>Thank You</title>
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">
        <link rel = "stylesheet" href = "https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel = "stylesheet" href = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/css/materialize.min.css">
        <script type = "text/javascript" src = "https://code.jquery.com/jquery-2.1.1.min.js"></script>
        <script src = "https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.3/js/materialize.min.js"></script>
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

        <div class="container grey-text text-darken-1 content">
			<div class="row">
				<div class="col s12">
					<h5 class="blue-text darken-2">Thank You!</h5>
					<div style="font-size:18px">
                    That was the last task, thank you very much for facilitating this test, select
                    finish to go back to available tests.
					</div>
                    </br>
                    <a href="educatorTests.php" class="waves-effect waves-light btn blue darken-2 right" name="button1">Finish</a>
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
    </style>
</html>
