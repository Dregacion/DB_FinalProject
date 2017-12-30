<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 
	
	$user = $_SESSION["username"];

	$safe_username = mysqli_real_escape_string($connection, $user);
	
	$result = mysqli_query($connection, "CALL empty_history ('$safe_username')");

	confirm_query($result);

	if($result && mysqli_affected_rows($connection) >= 1){
		// success
		$message = "Load History successfully emptied!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"load_history.php\");</script>"; 
	}else{
		//failure
		$message = "Deletion of all history records failed!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"load_history.php\");</script>"; 
	}

?>