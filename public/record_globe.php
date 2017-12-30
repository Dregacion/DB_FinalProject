<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


<?php


	if(isset($_POST['submit'])){
       
		$fields_with_max_lengths = array("number" => 11, "amount_load" => 4, "amount_paid" => 4);
		validate_max_lengths($fields_with_max_lengths);

		$fields_with_min_lengths = array("number" => 11, "amount_load" => 1, "amount_paid" => 1);
		validate_min_lengths($fields_with_min_lengths);

		if(empty($errors)){
			//perform create
            
			$number = mysql_prep($_POST["number"]);
			$amount_load = mysql_prep($_POST["amount_load"]);
			$amount_paid = mysql_prep($_POST["amount_paid"]);      

			$query  = "INSERT INTO globe_records (";
			$query .= " Date, First_Name, Last_Name, Username, Phone_Number, Amount_of_Load, Amount_Paid ";
			$query .= ") VALUES (";
			$query .= " '{$firstname}', '{$lastname}', '{$username}', '{$hashed_password}', '{$email}', '{$address}', '{$city}' ";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if($result){
				// success
				//$_SESSION["message"] = "Admin successfully created!";
                $message = "Globe Load Record successfully saved!";
                echo "<script type='text/javascript'>alert('$message'); window.top.location.replace(\"user_menu.php\");</script>"; 
			}else{
				//failure
				//$_SESSION["message"] = "Admin creation failed!";
                $message = "Globe Load Record has been failed!";
                echo "<script type='text/javascript'>alert('$message');</script>";
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
    
    <div class="record_globe">

        <div class="container">

            <form class="form-horizontal" action="record_smart.php" method="post">

                <center><h3>For Globe Load</h3></center>
                <hr style="width:440px; margin-left: -60px"><br>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="number">Mobile Number:</label>
                    <div class="col-sm-10">
                        <input class="form-control" style="width: 300px;" type="number" required="required" value="<?php echo isset($_POST["number"]) ? $_POST["number"] : "" ?>" name="number">
                     </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="amount_load">Amount of Load:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px;" type="number" required="required" value="<?php echo isset($_POST["amount_load"]) ? $_POST["amount_load"] : "" ?>" name="amount_load" />
                    </div>
                </div>

               <div class="form-group">
                    <label class="control-label col-sm-10" for="amount_paid">Total Amount Paid:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px;" type="number" required="required" value="<?php echo isset($_POST["amount_paid"]) ? $_POST["amount_paid"] : "" ?>"  name="amount_paid" />
                    </div>
                </div>

                <br>
                <center>
                    <div class="form-group">        
                        <div class="col-sm-offset-5 col-sm-10">
                            <input type="submit" class="btn btn-default" style="margin-right: 20px" name="submit" value="Save"/>
                            <a href="user_menu.php" target="_parent" class="a"><input class="btn btn-default" type="button" onclick="return confirm('Are you sure you want to cancel?')" name="cancel" value="Cancel"/></a>   
                        </div>
                    </div>
                </center> 
                <br>

            </form>

        </div>

    </div>         

</body>

</html>