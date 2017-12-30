<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php
	
	$order = "";
	$sort = "";

	if(isset($_GET['order'])){
		$order = $_GET['order'];
	}else{
		$order = 'id';
	}

	if(isset($_GET['sort'])){
		$sort = $_GET['sort'];
	}else{
		$sort = 'DESC';
	} 

echo "
<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='shortcut icon' href='Images/icon.ico'>
    <title>E-Loading Business Record</title>
    <link href='stylesheets/styles.css' rel='stylesheet' type='text/css'>
    <link href='bootstrap_css/bootstrap.min.css' rel='stylesheet'>
    <script src='bootstrap_js/bootstrap.min.js'></script>
    <script src='Jquery/jquery.min.js'></script>    
</head>

<body>
";

	global $connection;
	$resultSet = mysqli_query($connection, "SELECT * FROM users ORDER BY $order $sort");

	if(mysqli_num_rows($resultSet) > 0){


		echo "
			<div class='manage_users'>

				<center><h2> Manage Users </h2></center><br>
				
				<a href='new_user.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px;' height='20px;' style='margin-right:8px;'>Add New User</button></a> 
				<hr><br>
			";

		$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

		echo "
		<table class='table'>
			<tr>
				<th><a href='?order=First_Name&&sort=$sort' class='table_header' title='Sort ASC/DESC'> First Name </a></th>
				<th><a href='?order=Last_Name&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Last Name </a></th>
				<th><a href='?order=Username&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Username </a></th>
				<th><a href='?order=Email&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Email </a></th>
				<th><a href='?order=Address&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Address </a></th>
				<th><a href='?order=City&&sort=$sort' class='table_header' title='Sort ASC/DESC'> City </a></th>
				<th><a href='?order=Added_By&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Added By</a></th>
				<th> Action </th>
			</tr>	
		";

		while($user = mysqli_fetch_assoc($resultSet)){

			$First_Name = $user['First_Name'];
			$Last_Name = $user['Last_Name'];
			$Username = $user['Username'];
			$Email = $user['Email'];
			$Address = $user['Address'];
			$City = $user['City'];
			$Added_By = $user['Added_By'];


			echo "
			<tr> 
				<td> $First_Name </td>
				<td> $Last_Name </td>
				<td> $Username </td>
				<td> $Email </td>
				<td> $Address </td>
				<td> $City </td>
				<td> $Added_By </td>

				<td><a href=delete_user.php?id=".$user["id"]." onclick=\"return confirm('Are you sure you want to delete this user?')\"; class='delete'><img src='images/delete.png' width='20px;' height='20px;' /></a></td>

			";

	echo "</tr>";

		}

echo "</table>";
		
	}else{	
		
	echo "
		<div style='width: 800px; margin-top: 100px; margin-left: 120px;'>
			<center>
				<h2> There are no registered users yet. </h2>
				<br> <hr> <br>
				<a href='new_user.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px' height='20px;' style='margin-right:8px;'>Add New User</button></a> 
			</center>
		</div>

		";

  	}	

echo "
</body>
</html> 
";

?>