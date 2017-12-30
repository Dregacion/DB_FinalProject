<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php      
    $user = $_SESSION["username"];

    $safe_username = mysqli_real_escape_string($connection, $user);

    $user_set = mysqli_query($connection, "CALL find_user_by_username('$safe_username')");

    confirm_query($user_set);

    if($user_set){
        $user = mysqli_fetch_assoc($user_set);
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

	<div class="user_profile">

		<br>
		<center><h2> User Profile </h2></center>

        <center><img src="images/profile_page.png" height="200px;" width="200px;" /></center>
        
        <a href="edit_user_profile.php" class="a"><button style="font-size: 13px;" class="btn btn-default"><img src="images/edit.png" width="20px;" height="20px;" style="margin-right:8px;">Edit Profile</button></a> 
        <hr><br>

		<p> <b>First Name:</b> <span style="margin-left: 30px;"><?php echo htmlentities($user["First_Name"]); ?> </span></p>
		<p> <b>Last Name:</b> <span style="margin-left: 30px;"><?php echo htmlentities($user["Last_Name"]); ?></span></p>
		<p> &nbsp;<b>Username:</b> <span style="margin-left: 30px;"><?php echo htmlentities($user["Username"]); ?></span></p>
        <p> <span style="margin-left: 30px;"><b>E-mail:</b></span> <span style="margin-left: 30px;"><?php echo htmlentities($user["Email"]); ?></span></p>
        <p> <span style="margin-left: 17px;"><b>Address:</b></span> <span style="margin-left: 30px;"> <?php echo htmlentities($user["Address"]); ?></span></p>
        <p> <span style="margin-left: 50px;"><b>City:</b></span> <span style="margin-left: 30px;"><?php echo htmlentities($user["City"]); ?></span></p>  

	</div>

</body>

</html>