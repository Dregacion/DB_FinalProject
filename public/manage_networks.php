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
	$resultSet = mysqli_query($connection, "SELECT * FROM networks ORDER BY $order $sort");

	if(mysqli_num_rows($resultSet) > 0){


		echo "
			<div class='manage_networks'>

				<center><h2> Manage Networks </h2></center><br>
				
				<a href='add_network.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px;' height='20px;' style='margin-right:8px;'>Add New Network</button></a> 
				<hr><br>
			";

		$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

		echo "
		<table class='table'>
			<tr>
				<th><a href='?order=Added_By&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Added By </a></th>
				<th><a href='?order=Network&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Network </a></th>
				<th colspan='2'> Action </th>
			</tr>	
		";

		while($network = mysqli_fetch_assoc($resultSet)){

			$Added_By = $network['Added_By'];
			$Network = $network['Network'];

			echo "
			<tr> 
				<td> $Added_By </td>
				<td> $Network </td>

				<td><a href=delete_network.php?id=".$network["id"]." onclick=\"return confirm('Are you sure you want to delete this network?')\"; class='delete'><img src='images/delete.png' width='20px;' height='20px;' /></a></td>

			";

	echo "</tr>";

		}

echo "</table>";
		
	}else{	
		
	echo "
		<div style='width: 800px; margin-top: 100px; margin-left: 120px;'>
			<center>
				<h2> You have not added any mobile networks yet. </h2>
				<br> <hr> <br>
				<a href='add_network.php' class='a'><button style='font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px' height='20px;' style='margin-right:8px;'>Add New Network</button></a> 
			</center>
		</div>

		";

  	}	

echo "
</body>
</html> 
";

?>