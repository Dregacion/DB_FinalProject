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

	$result = mysqli_query($connection, "SELECT * FROM users_activity ORDER BY $order $sort"); 

	if(isset($_POST['search'])){

	    $searchColumn = $_POST['column'];
        $searchValue = $_POST['valueToSearch'];

        if($searchColumn == 'Done by'){

        	$query  = "SELECT * FROM users_activity WHERE Username LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Activity'){

        	$query  = "SELECT * FROM users_activity WHERE Activity LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Done at'){

        	$query  = "SELECT * FROM users_activity WHERE Changedon LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'All'){

            $query = "SELECT * FROM users_activity WHERE CONCAT(Username, Activity, Changedon) LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == NULL AND $searchValue == NULL){

            $message = "Please enter a value to search.";
            echo "<script type='text/javascript'>alert('$message');</script>"; 

            $resultSet = mysqli_query($connection, "SELECT * FROM users_activity ORDER BY $order $sort");

        }else{

        	$resultSet = mysqli_query($connection, "SELECT * FROM users_activity ORDER BY $order $sort");
        }

    } else {

        $resultSet = mysqli_query($connection, "SELECT * FROM users_activity ORDER BY $order $sort"); 
    }
	
?>


<?php

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

	if(mysqli_num_rows($result) > 0){

		$sort == 'DESC' ? $sort = 'ASC' : $sort = 'DESC';

		echo "
			<div class='users_activity'>

				<center><h2> Users Activity </h2></center><br><br>

				<a href='empty_activity.php' class='a' onclick=\"return confirm('Are you sure you want to delete everything from activity logs? It cannot be undone.');\"> <button style='float:left; font-size: 13px;' class='btn btn-default'> <img src='images/empty.png' width='18px;' height='18px;' style='margin-right:8px;'>Empty Activity Logs</button></a> 

				<form action='users_activity.php' method='POST'>

					<input class='form-control' type='submit' name='search' value='SEARCH' style='display:inline; width: 80px; height: 35px; color:white; background-color: #2db7b9; float:right;'>

					<input class='form-control' style='display:inline; width: 250px; height: 35px; float:right; margin-right:20px;' type='text' name='valueToSearch' placeholder='Search..'>


					<div class='form-group'>                    
	                    <div class='col-sm-10'> 
	                        <select class='selectpicker form-control' style='display:inline; float:right; width: 250px; margin-right:20px;' required='required' name='column'>
	                        	
	                            <option selected='selected'>All</option>
	                            <option>Done by</option>
								<option>Activity</option>
								<option>Done at</option>
	                        </select>
	                    </div> 
		   
		            </div>

		            <br><br>
            ";   

    	echo "
		<table class='table'>
			<tr>
				<th><a href='?order=Username&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Done by </a></th>
				<th><a href='?order=Activity&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Activity </a></th>
				<th><a href='?order=Changedon&&sort=$sort' class='table_header' title='Sort ASC/DESC'> Done at </a></th>
				<th> Action </th>
			</tr>	
		";


		if(mysqli_num_rows($resultSet) > 0){
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

		}else{
			echo "
				<tr>
	                <center>
	                    <td colspan='8'><h5> No results found.</h5></td>
	                </center>
	            </tr>
            ";
		}		

echo "
	</table>
	</form>
	";
		
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