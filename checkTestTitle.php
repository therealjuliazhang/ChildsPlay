<?php
    //get input test title
    if(isset($_REQUEST['testTitle']))
        $inputTitle = $_REQUEST['testTitle'];
    //get current test title (needed for editing groupname)
    $currentTitle = "";
    if(isset($_POST['currentTitle']))
        $currentTitle = $_POST['currentTitle'];
	
    if ($inputTitle != $currentTitle){
        //check if group name already taken by selecting it from database
        include 'db_connection.php';
        $conn = OpenCon();
        $sql = "SELECT title FROM TEST WHERE title = '" .$inputTitle. "'";
        $result = $conn->query($sql);
        //return "" for error, true for no error
        if(mysqli_num_rows($result) > 0)
            echo json_encode("");
        else
			echo json_encode("true");
    }
	else
		echo json_encode("true");
?>