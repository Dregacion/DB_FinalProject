<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php 
	//$admin = find_admin_by_id($_GET["id"]);

	$id = $_GET["id"];

	$result = mysqli_query($connection, "CALL delete_admin($id)");

	confirm_query($result);

	if($result && mysqli_affected_rows($connection) == 1){
		// success
		$message = "Admin successfully deleted!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"manage_admins.php\");</script>"; 
	}else{
		//failure
		$message = "Admin deletion failed!";
        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"manage_admins.php\");</script>"; 
	}

?>
