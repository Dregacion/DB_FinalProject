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
	$resultSet = mysqli_query($connection, "SELECT * FROM users_activity ORDER BY $order $sort");

	if(mysqli_num_rows($resultSet) > 0){


		echo "
			<div class='users_activity'>

				<center><h2> Users Activity </h2></center><br>

				<a href='empty_activity.php' class='a' onclick=\"return confirm('Are you sure you want to delete everything from activity logs? It cannot be undone.');\"> <button style='font-size: 13px;' class='btn btn-default'> <img src='images/empty.png' width='18px;' height='18px;' style='margin-right:8px;'>Empty Activity Logs</button></a> 

				<hr><br>
			";

		$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

		echo "
		<table class='table'>
			<tr>
				<th><a href='?order=Username&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Done by </a></th>
				<th><a href='?order=Activity&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Activity </a></th>
				<th><a href='?order=Changedon&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Done at </a></th>
				<th> Action </th>
			</tr>	
		";

		while($activity = mysqli_fetch_assoc($resultSet)){

			$Done_by =$activity['Username'];
			$Activity = $activity['Activity'];
			$Done_at = $activity['Changedon'];

			echo "
			<tr> 
				<td> $Done_by </td>
				<td> $Activity </td>
				<td> $Done_at </td>
		
				<td><a href=delete_user_activity.php?id=".$activity["id"]." onclick=\"return confirm('Are you sure you want to delete this user activity?')\"; class='delete'><img src='images/delete.png' width='20px;' height='20px;' /></a></td>

			";

	echo "</tr>";

		}

echo "</table>";
		
	}else{	
		
	echo "
		<div style='width: 800px; margin-top: 150px; margin-left: 120px;'>
			<center>
				<h2> There are no records Users Activity. </h2>
				<br> <hr> <br>
			</center>
		</div>

		";
  	}	

echo "
</body>
</html> 
";

?>