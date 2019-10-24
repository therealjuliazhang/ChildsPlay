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
        $sql = $conn->prepare("SELECT title FROM TEST WHERE title = ?");
        $sql->bind_param("s", $inputTitle);
        $sql->execute();
        $result = $sql->get_result();
        //return "" for error, true for no error
        if($result->num_rows > 0)
            echo json_encode(false);
        else
            echo json_encode(true);
        $sql->close();
    }
	else
		echo json_encode(true);
?>