<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php 

    $user = $_SESSION["username"];

    $safe_username = mysqli_real_escape_string($connection, $user);

    $admin_set = mysqli_query($connection, "CALL find_admin_by_username('$safe_username')");

    confirm_query($admin_set);

    if($admin_set){
        $admin = mysqli_fetch_assoc($admin_set);
    }

?>  

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Images/icon.ico">
    <title>E-Loading Business Record</title>
    <link href="stylesheets/styles.css" rel="stylesheet" type="text/css">
    <link href="bootstrap_css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap_js/bootstrap.min.js"></script>
    <script src="Jquery/jquery.min.js"></script>    
</head>

<body>

	<div class="admin_profile">

		<br>
		<center><h2> Admin Profile </h2></center>

        <center><img src="images/profile_page.png" height="200px;" width="200px;" /></center>

        <a href="edit_admin_profile.php" class="a"><button style="font-size: 13px;" class="btn btn-default"><img src="images/edit.png" width="20px;" height="20px;" style="margin-right:8px;">Edit Profile</button></a> 
        <hr><br>  

		<p> <b>First Name:</b> <span style="margin-left: 30px;"><?php echo htmlentities($admin['First_Name']); ?> </span></p>
		<p> <b>Last Name:</b> <span style="margin-left: 30px;"><?php echo htmlentities($admin["Last_Name"]); ?></span></p>
		<p> &nbsp;<b>Username:</b> <span style="margin-left: 30px;"><?php echo htmlentities($admin["Username"]); ?></span></p>
        <p> <span style="margin-left: 30px;"><b>E-mail:</b></span> <span style="margin-left: 30px;"><?php echo htmlentities($admin["Email"]); ?></span></p>
        <p> <span style="margin-left: 17px;"><b>Address:</b></span> <span style="margin-left: 30px;"> <?php echo htmlentities($admin["Address"]); ?></span></p>
        <p> <span style="margin-left: 50px;"><b>City:</b></span> <span style="margin-left: 30px;"><?php echo htmlentities($admin["City"]); ?></span></p>  

	</div>     

</body>

</html>