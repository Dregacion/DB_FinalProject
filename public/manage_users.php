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


	$result = mysqli_query($connection, "SELECT * FROM users ORDER BY $order $sort"); 


	if(isset($_POST['search'])){

	    $searchColumn = $_POST['column'];
        $searchValue = $_POST['valueToSearch'];

        if($searchColumn == 'First Name'){

        	$query  = "SELECT * FROM users WHERE First_Name LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Last Name'){

        	$query  = "SELECT * FROM users WHERE Last_Name LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Username'){

        	$query  = "SELECT * FROM users WHERE Username LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'E-mail'){

        	$query  = "SELECT * FROM users WHERE Email LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Address'){

        	$query  = "SELECT * FROM users WHERE Address LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'City'){

        	$query  = "SELECT * FROM users WHERE City LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'Added By'){

        	$query  = "SELECT * FROM users WHERE Added_By LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == 'All'){

            $query = "SELECT * FROM users WHERE CONCAT(First_Name, Last_Name, Username, Email, Address, City, Added_By) LIKE '%".$searchValue."%'";

            $resultSet  = mysqli_query($connection, $query);

        }else if($searchColumn == NULL AND $searchValue == NULL){

            $message = "Please enter a value to search.";
            echo "<script type='text/javascript'>alert('$message');</script>"; 

            $resultSet = mysqli_query($connection, "SELECT * FROM users ORDER BY $order $sort");

        }else{

        	$resultSet = mysqli_query($connection, "SELECT * FROM users ORDER BY $order $sort");
        }

    } else {

        $resultSet = mysqli_query($connection, "SELECT * FROM users ORDER BY $order $sort"); 
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
			<div class='manage_users'>

				<center><h2> Manage Users </h2></center><br><br>

				<a href='new_user.php' class='a'><button style='float:left; font-size: 13px;' class='btn btn-default'><img src='images/add.png' width='20px;' height='20px;' style='margin-right:8px;'>Add New User</button></a> 
	
				<form action='manage_users.php' method='POST'>

					<input class='form-control' type='submit' name='search' value='SEARCH' style='display:inline; width: 80px; height: 35px; color:white; background-color: #2db7b9; float:right;'>

					<input class='form-control' style='display:inline; width: 250px; height: 35px; float:right; margin-right:20px;' type='text' name='valueToSearch' placeholder='Search..'>


					<div class='form-group'>                    
		                    <div class='col-sm-10'> 
		                        <select class='selectpicker form-control' style='display:inline; float:right; width: 250px; margin-right:20px;' required='required' name='column'>
		                        	
		                            <option selected='selected'>All</option>
		                            <option>First Name</option>
									<option>Last Name</option>
									<option>Username</option>
		                            <option>E-mail</option>
									<option>Address</option>
									<option>City</option>
									<option>Added By</option>

		                        </select>
		                    </div> 
		   
		            </div>

		            <br><br>
            ";   

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

		if(mysqli_num_rows($resultSet) > 0){

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