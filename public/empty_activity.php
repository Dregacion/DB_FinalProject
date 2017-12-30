<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 
	
	$result = mysqli_query($connection, "CALL empty_activity()");

	confirm_query($result);

	if($result && mysqli_affected_rows($connection) >= 1){
		// success
		$message = "Users activity log successfully emptied!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"users_activity.php\");</script>"; 
	}else{
		//failure
		$message = "Deletion of all users activity failed!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"users_activity.php\");</script>"; 
	}

?>