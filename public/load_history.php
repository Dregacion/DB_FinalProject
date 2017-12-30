<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php
	
	$user = $_SESSION["username"];
    $safe_username = mysqli_real_escape_string($connection, $user);
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
	$resultSet = mysqli_query($connection, "SELECT * FROM view_load_records WHERE Username = '$safe_username' ORDER BY $order $sort");

	if(mysqli_num_rows($resultSet) > 0){


		echo "
			<div class='smart_loads'>

				<center><h2> Your Load History </h2></center><br>

				<hr><br>
			";

		$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';
		
		echo "
		<table class='table'>
			<tr>
				<th><a href='?order=Username&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Username </a></th>
				<th><a href='?order=Date&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Date<br>(YYYY-M-D) </a></th>
				<th><a href='?order=Time&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Time 24-hour<br>(HH:MM:SS) </a></th>
				<th><a href='?order=Mobile_Number&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Mobile Number </a></th>
				<th><a href='?order=Amount_of_Load&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Load Amount </a></th>
				<th><a href='?order=Amount_Paid&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Amount Paid </a></th>
				<th><a href='?order=Network&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Network </a></th>
			</tr>	
		";

		while($load = mysqli_fetch_assoc($resultSet)){

			$Username = $load['Username'];
			$Date = $load['Date'];
			$Time = $load['Time'];
			$Mobile_Number = $load['Mobile_Number'];
			$Amount_of_Load = $load['Amount_of_Load'];
			$Amount_Paid = $load['Amount_Paid'];
			$Network = $load['Network'];

			echo "
			<tr> 

				<td> $Username </td>
				<td> $Date </td>
				<td> $Time </td>
				<td> 0$Mobile_Number </td>
				<td> $Amount_of_Load </td>
				<td> $Amount_Paid </td>
				<td> $Network </td>
			";

	echo "</tr>";

		}

echo "</table>";
		
	}else{	
		
	echo "
		<div style='width: 800px; margin-top: 100px; margin-left: 120px;'>
			<center>
				<h2> You have no recently recorded transactions yet. </h2>
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