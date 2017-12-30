
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
	//simple logout
/*
	$_SESSION["user_id"] =  null;
	$_SESSION["username"] = null;
	$_SESSION["password"] = null;
*/
	unset($_SESSION["user_id"]);
	unset($_SESSION["username"]);
	unset($_SESSION["password"]);

	redirect_to("index.php");
?>