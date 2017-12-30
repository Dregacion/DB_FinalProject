<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 

	$id = $_GET["id"];

	$result = mysqli_query($connection, "CALL delete_load_history($id)");

	confirm_query($result);

	if($result && mysqli_affected_rows($connection) == 1){
		// success
		$message = "Load History successfully deleted!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"load_history.php\");</script>"; 
	}else{
		//failure
		$message = "History deletion failed!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"load_history.php\");</script>"; 
	}

?>