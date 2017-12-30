<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
 

<?php

	if(isset($_POST['submit'])){
       
       /*
		$fields_with_max_lengths = array("number" => 12, "amount_load" => 4, "amount_paid" => 4);
		validate_max_lengths($fields_with_max_lengths);

		$fields_with_min_lengths = array("number" => 11, "amount_load" => 1, "amount_paid" => 1);
		validate_min_lengths($fields_with_min_lengths);
        */

		if(empty($errors)){

            date_default_timezone_set("Asia/Singapore");

            $date = date('Y-m-d');
            $time = date('H:i:s');
            $username = $_SESSION["username"];
			$number = $_POST["number"];
			$amount_load = $_POST["amount_load"];
			$amount_paid = $_POST["amount_paid"]; 
            $network =  mysql_prep($_POST["network"]); 

            /*
			$query  = "INSERT INTO load_records (";
			$query .= " Date, Time, Username, Mobile_Number, Amount_of_Load, Amount_Paid, Network ";
			$query .= ") VALUES (";
			$query .= " '{$date}', '{$time}', '{$username}', {$number}, {$amount_load}, {$amount_paid}, '{$network}' ";
			$query .= ")";
            */

            $query = "CALL insert_into_load_records('$date', '$time', '$username', $number, $amount_load, $amount_paid, '$network' )";

			$result = mysqli_query($connection, $query);

            if($result){
                $message = "Load has been successfully recorded!";
                echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"record_loads.php\");</script>"; 
            }else{
                //failure
                $message = "Sorry, an error occured while saving the transaction.";
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
    
    <div class="record_loads">

        <div class="container">

            <form class="form-horizontal" action="record_loads.php" method="post">

                <center><h3>Record Load Transactions</h3></center>
                <hr style="width:440px; margin-left: -60px"><br>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="number">Mobile Number:</label>
                    <div class="col-sm-10">
                        <input class="form-control" style="width: 300px;" type="number" min="09000000000" max="09999999999" required="required" value="<?php echo isset($_POST["number"]) ? $_POST["number"] : "" ?>" name="number">
                     </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="amount_load">Amount of Load:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px;" type="number" min="2" max="500" required="required" value="<?php echo isset($_POST["amount_load"]) ? $_POST["amount_load"] : "" ?>" name="amount_load" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="amount_paid">Total Amount Paid:</label>
                    <div class="col-sm-10">          
                        <input class="form-control" style="width: 300px;" type="number" min="5" max="510" required="required" value="<?php echo isset($_POST["amount_paid"]) ? $_POST["amount_paid"] : "" ?>"  name="amount_paid" />
                    </div>
                </div>

            <!--    
                <center>
                    <div class="radio">
                        <label><input type="radio" name="network" required="required" value="Globe"><img class="globe_img" src="images/globe_logo.png"/> </label>
                    </div>
                     
                    <div class="radio">
                        <label><input type="radio" name="network" required="required" value="Smart"><img class="smart_img" src="images/smart_logo.png"/></label>
                    </div>
                </center>
            -->


                <div class="form-group">
                    <label class="control-label col-sm-10" for="network">Network:</label>                       
                    <div class="col-sm-10"> 
                        <select class="selectpicker form-control" title="Please select Network..." style="width: 300px;" required="required" name="network">

                            <?php
                                $query  = "SELECT Network ";
                                $query .= "FROM Networks ";                                      

                                $network_set = mysqli_query($connection, $query);
                                confirm_query($network_set);
                            ?>

                            <option selected="selected"></option>

                            <?php 
                                $select = "";
                                while($network = mysqli_fetch_assoc($network_set)) { ?>
                                    <option $select="<?php echo htmlentities($network["Network"]); ?>" ><?php echo htmlentities($network["Network"]); ?></option>
                            <?php } ?>

                        </select>
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