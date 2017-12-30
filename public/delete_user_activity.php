<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 

	$id = $_GET["id"];

	$result = mysqli_query($connection, "CALL delete_user_activity($id)");

	confirm_query($result);

	if($result && mysqli_affected_rows($connection) == 1){
		// success
		$message = "Record successfully deleted!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"users_activity.php\");</script>"; 
	}else{
		//failure
		$message = "Record deletion failed!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"users_activity.php\");</script>"; 
	}

?>