<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php  

    $admin = find_admin_by_username($_SESSION["username"]);
/*    
    $user = $_SESSION["username"];

    $safe_username = mysqli_real_escape_string($connection, $user);

    $admin_set = mysqli_query($connection, "CALL find_admin_by_username('$safe_username')");

    confirm_query($admin_set);

    if($admin_set){
        $admin = mysqli_fetch_assoc($admin_set);
    }
*/
?> 


<?php   

    if(isset($_POST['submit'])){
 
        $required_fields = array("firstname", "lastname", "username", "password");
        validate_presences($required_fields);
        
        
        $fields_with_max_lengths = array("firstname" => 25, "lastname" => 25, "username" => 25, "password" => 25, "address" => 25, "city" => 25);
        validate_max_lengths($fields_with_max_lengths);

        $fields_with_min_lengths = array("firstname" => 3, "lastname" => 3, "username" => 5, "password" => 6, "address" => 3, "city" => 3);
        validate_min_lengths($fields_with_min_lengths);
        
        if(empty($errors)){
            //perform update

            $id = $admin["id"];
            $firstname = mysql_prep($_POST["firstname"]);
            $lastname = mysql_prep($_POST["lastname"]);
            $username = mysql_prep($_POST["username"]);
            $hashed_password = password_encrypt($_POST["password"]);
            $email = mysql_prep($_POST["email"]);
            $address = mysql_prep($_POST["address"]);
            $city = mysql_prep($_POST["city"]);

          
        /*
            $query  = "UPDATE admin SET ";
            $query .= "First_Name = '{$firstname}', ";
            $query .= "Last_Name = '{$lastname}', ";
            $query .= "Username = '{$username}', ";
            $query .= "hashed_password = '{$hashed_password}', ";
            $query .= "Email = '{$email}', ";
            $query .= "Address = '{$address}', ";
            $query .= "City = '{$city}' ";
            $query .= "WHERE id = {$id} ";
            $query .= "LIMIT 1";
        */
        
            $query = "CALL update_admin_profile($id, '$firstname', '$lastname', '$username', '$hashed_password', '$email', '$address', '$city' )";
  

            $result = mysqli_query($connection, $query);

            if($result && mysqli_affected_rows($connection) == 1){
                $message = "Profile successfully updated! Please log out your account to save some changes.";
                echo "<script type='text/javascript'>alert('$message'); window.top.location.replace(\"logout.php\");</script>"; 

            }else{
                $message = "Profile update failed.";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }
            
        }else{
             $message = form_errors($errors);
             echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }
?>


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

    <div class="edit_profile">

        <div class="container">

            <form class="form-horizontal" action="edit_admin_profile.php" method="post">

                <center><h3>Edit Your Profile</h3></center>
                <hr style="width:440px; margin-left: -60px"><br>

            <div class="form-group">
                <label class="control-label col-sm-5" for="firstname">First Name:</label>
                <div class="col-sm-10">
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["firstname"]) ? $_POST["firstname"] : htmlentities($admin["First_Name"]); ?>"  name="firstname" />
                 </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="lastname">Last Name:</label>
                <div class="col-sm-10">          
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["lastname"]) ? $_POST["lastname"] : htmlentities($admin["Last_Name"]); ?>" name="lastname" />
                </div>
            </div>

           <div class="form-group">
                <label class="control-label col-sm-5" for="username">Username:</label>
                <div class="col-sm-10">          
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : htmlentities($admin["Username"]); ?>"  name="username" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="password">Password:</label>
                <div class="col-sm-10">          
                    <input type="password" class="form-control" style="width: 300px; height: 35px;" required="required" value="<?php echo isset($_POST["password"]) ? $_POST["password"] : ""; ?>" name="password" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="email">E-mail:</label>
                <div class="col-sm-10">          
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" placeholder="name@example.com" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : htmlentities($admin["Email"]); ?>"  name="email" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="address">Address:</label>
                <div class="col-sm-10">          
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["address"]) ? $_POST["address"] : htmlentities($admin["Address"]); ?>"  name="address" />
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-5" for="city">City:</label>
                <div class="col-sm-10">          
                    <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["city"]) ? $_POST["city"] : htmlentities($admin["City"]); ?>"  name="city" />
                </div>
            </div>

            <br>
            <center>
                <div class="form-group">        
                    <div class="col-sm-offset-5 col-sm-10">
                            <input type="submit" class="btn btn-default" style="margin-right: 20px" name="submit" value="Save"/>
                            <a href="admin_profile.php" class="a"><input class="btn btn-default" type="button" onclick="return confirm('Are you sure you want to cancel?')" name="cancel" value="Cancel"/></a>   
                    </div>
                </div>
            </center> 
            <br>

            </form>

        </div>

    </div>


</body>

</html>