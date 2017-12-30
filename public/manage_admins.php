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
	$resultSet = mysqli_query($connection, "SELECT * FROM admin ORDER BY $order $sort");

	if(mysqli_num_rows($resultSet) > 0){


		echo "
			<div class='manage_admins'>

				<center><h2> Manage Admins </h2></center><br>
				
				<a href='new_admin.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px;' height='20px;' style='margin-right:8px;'>Add New Admin</button></a> 
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

		while($admin = mysqli_fetch_assoc($resultSet)){

			$First_Name = $admin['First_Name'];
			$Last_Name = $admin['Last_Name'];
			$Username = $admin['Username'];
			$Email = $admin['Email'];
			$Address = $admin['Address'];
			$City = $admin['City'];
			$Added_By = $admin['Added_By'];


			echo "
			<tr> 
				<td> $First_Name </td>
				<td> $Last_Name </td>
				<td> $Username </td>
				<td> $Email </td>
				<td> $Address </td>
				<td> $City </td>
				<td> $Added_By </td>
			";

			if($admin['Username'] != $_SESSION["username"]){

			echo "
				<td><a href=delete_admin.php?id=".$admin["id"]." onclick=\"return confirm('Are you sure you want to delete this admin?')\"; class='delete'><img src='images/delete.png' width='20px;' height='20px;' /></a></td>
				";

			}else{

				echo "
				<td><img src='images/check.png' width='20px;' height='20px;' /></td>
				";
			}

	echo "</tr>";

		}

echo "</table>";
		
	}else{	
		
	echo "
		<div style='width: 800px; margin-top: 100px; margin-left: 120px;'>
			<center>
				<h2> There are no registered admins yet. </h2>
				<br> <hr> <br>
				<a href='new_admin.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px' height='20px;' style='margin-right:8px;'>Add New Admin</button></a> 
			</center>
		</div>

		";

  	}	

echo "
</body>
</html> 
";

?>