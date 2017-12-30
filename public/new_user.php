<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php


	if(isset($_POST['submit'])){

		$fields_with_max_lengths = array("username" => 25, "firstname" => 25, "lastname" => 25, "password" => 25, "address" => 25, "city" => 25);
		validate_max_lengths($fields_with_max_lengths);

		$fields_with_min_lengths = array("username" => 5, "firstname" => 3, "lastname" => 3, "password" => 6, "address" => 3, "city" => 3);
		validate_min_lengths($fields_with_min_lengths);

		if(empty($errors)){
            
            $added_by = $_SESSION["username"];
			$firstname = mysql_prep($_POST["firstname"]);
			$lastname = mysql_prep($_POST["lastname"]);
			$username = mysql_prep($_POST["username"]);
			$hashed_password = password_encrypt($_POST["password"]);
            $email = mysql_prep($_POST["email"]);
            $address = mysql_prep($_POST["address"]);
            $city = mysql_prep($_POST["city"]);

        /*
            $user_set = mysqli_query($connection, "CALL find_user_by_username('$username')");

            confirm_query($user_set);

            if($user_set && mysqli_num_rows($user_set) >= 1){
                $message = "Username already exists.";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }
        */

            $username_exists = user_username_exists($username);

            if(!$username_exists){
                $message = "Username already exists.";
                echo "<script type='text/javascript'>alert('$message');</script>";

            }else{
                   
                /*    
        			$query  = "INSERT INTO users (";
        			$query .= " First_Name, Last_Name, Username, hashed_password, Email, Address, City";
        			$query .= ") VALUES (";
        			$query .= " '{$firstname}', '{$lastname}', '{$username}', '{$hashed_password}', '{$email}', '{$address}', '{$city}' ";
        			$query .= ")";
                */   
                    
                
                    $query = "CALL insert_into_users('$added_by', '$firstname', '$lastname', '$username', '$hashed_password', '$email', '$address', '$city' )";
                

                    $result = mysqli_query($connection, $query);

        			if($result){
        				// success
                        $message = "User successfully created!";
                        echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"manage_users.php\");</script>"; 
        			}else{
        				//failure
                        $message = "User creation failed!";
                        echo "<script type='text/javascript'>alert('$message');</script>";
        			}
            }

		}else{
            $message = form_errors($errors);
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

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
    
    <div class="add_admin">

        <div class="container">

            <form class="form-horizontal" action="new_user.php" method="post">

                <center><h3>Add New User</h3></center>
                <hr style="width:440px; margin-left: -60px"><br>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="firstname">First Name:</label>
                    <div class="col-sm-10">
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : "" ?>" name="firstname">
                     </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="lastname">Last Name:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : "" ?>" name="lastname" />
                    </div>
                </div>

               <div class="form-group">
                    <label class="control-label col-sm-5" for="username">Username:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : "" ?>"  name="username" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="password">Password:</label>
                    <div class="col-sm-10">          
                        <input type="password" class="form-control" style="width: 300px; height: 35px;" required="required" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : "" ?>" name="password" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="email">E-mail:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" placeholder="name@example.com" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : "" ?>"  name="email" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="address">Address:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : "" ?>"  name="address" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-5" for="city">City:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : "" ?>"  name="city" />
                    </div>
                </div>

                <br>
                <center>
                    <div class="form-group">        
                        <div class="col-sm-offset-5 col-sm-10">
                            <input type="submit" class="btn btn-default" style="margin-right: 20px" name="submit" value="Save"/>
                            <a href="manage_users.php" class="a"><input class="btn btn-default" type="button" onclick="return confirm('Are you sure you want to cancel?')" name="cancel" value="Cancel"/></a>   
                        </div>
                    </div>
                </center> 
                <br>

            </form>

        </div>

    </div>         

</body>

</html>