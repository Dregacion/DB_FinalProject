<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>


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

	<div class="calculations">

		<div class="calculate">

			<form class="form-horizontal" action="calculate.php" method="post">

				<h4>LOAD CALCULATION</h4>
				<hr>

				<div class="form-group">
                    <label  style="color:#383d41;" for="network">Please choose a network:</label>                       
                    <div class="col-sm-10"> 
                        <select class="selectpicker form-control" title="Please select Network..." style="width: 300px;" required="required" name="network" value="<?php echo isset($_POST["network"]) ? $_POST["network"] : "" ?>">

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

				<div class="radio">
		            <label><input type="radio" name="choose_to_calculate" required="required" value="load" <?php if (isset($_POST['choose_to_calculate']) && $_POST['choose_to_calculate']=="load") echo "checked";?> >&nbsp;Calculate total amount of load spent to the customers</label>
		        </div>
		        
		        <br>

		        <div class="radio">
		            <label><input type="radio" name="choose_to_calculate" required="required" value="paid" <?php if (isset($_POST['choose_to_calculate']) && $_POST['choose_to_calculate']=="paid") echo "checked";?> >&nbsp;Calculate total amount paid by customers</label>
		        </div>

				<br><br>

			    <div class="form-group">
	                <label for="calculate_from" style="color:#383d41;">Calculate from:</label>
	                <input class="form-control" style="width: 300px;" type="date" required="required" name="calculate_from" value="<?php echo isset($_POST["calculate_from"]) ? $_POST["calculate_from"] : "" ?>" />
	            </div>

	            <div class="form-group">
	                <label for="calculate_to" style="color:#383d41;">Calculate to:</label>
	                <input class="form-control" style="width: 300px;" type="date" required="required" name="calculate_to" value="<?php echo isset($_POST["calculate_to"]) ? $_POST["calculate_to"] : "" ?>" />
	            </div>

	            <br>

		        <div class="form-group">        

		            <div class="col-sm-offset-5 col-sm-10">
		                <input type="submit" class="btn btn-default" style="margin-right: 20px" name="submit" value="Calculate"/>
		                <a href="manage_loads.php" target="iframe_content" class="a"><input class="btn btn-default" type="button" onclick="return confirm('Are you sure you want to cancel?')" name="cancel" value="Cancel"/></a>   
		            </div>

		        </div>

			</form>
		</div>	


		<div class="result">

			<p style="font-size: 27px;"> Hi, <?php echo $_SESSION["username"];?>! </p>
			<hr>
			<center><p style="font-size: 22px; padding: 2.5px;">Please provide all of the required information to generate result.</p></center>
			<hr>
			<center><a href= "manage_loads.php" target="iframe_content" class="a"><input class="btn btn-default" style="width: 290px;" type="button" name="back" value="Back to Load Records"/></a></center>

		</div>

<?php 	if (isset($_POST['submit'])){	

			$network = $_POST["network"];
			$choose_to_calculate = $_POST["choose_to_calculate"];
			$calculate_from = $_POST["calculate_from"];
			$calculate_to = $_POST["calculate_to"];
			
			$found_date1 = found_date($calculate_from, $network);
			$found_date2 = found_date($calculate_to, $network);
			$valid_date = valid_date($calculate_from, $calculate_to);

			if(!$valid_date && !$found_date1){

				$message = "Sorry, the date you entered is invalid and does not exist on the record.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

			}else if(!$valid_date && !$found_date2){

				$message = "Sorry, the date you entered is invalid and does not exist on the record.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

			}else if(!$found_date1 && !$found_date2){

				$message = "Sorry, the range of dates you entered does not exist on the record.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

			}else if(!$found_date1){

				$message = "Sorry, the date you entered for CALCULATE FROM does not exist on the record.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

		    }else if(!$found_date2){

				$message = "Sorry, the date you entered for CALCULATE TO does not exist on the record.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

			}else if(!$valid_date){

				$message = "Sorry, the dates you entered are invalid.";
				echo "<script type='text/javascript'> alert('$message'); </script>"; 

			}else{	?>

				<div class="result">

					<?php

			     		//$range_of_dates = range_of_dates($network, $calculate_from, $calculate_to);

						$safe_network = mysqli_real_escape_string($connection, $network);

						$from = date($calculate_from);
					    $to = date($calculate_to);

			     		$query = "CALL range_of_dates('$safe_network', '$from', '$to' )";

           				$range_of_dates = mysqli_query($connection, $query);


			     		$total_load = 0;
			     		$total_paid = 0;

			     		while($range = mysqli_fetch_assoc($range_of_dates)) {												
							$total_load += $range["Amount_of_Load"];	 
							$total_paid += $range["Amount_Paid"];	 
						} 	


						if($choose_to_calculate == "load"){	

							global $total_load;		?>

							<p> TOTAL AMOUNT OF LOAD: </p>
							<hr>
							<center><p style="font-size: 60px;"> <?php echo $total_load ?> </p></center>
							<hr><br>
							<center><a href= "manage_loads.php" target="iframe_content" class="a"><input class="btn btn-default" style="width: 290px;" type="button" name="back" value="Back to Load Records"/></a></center>

					<?php }else{ 

							global $total_paid; 	?>

							<p> TOTAL AMOUNT PAID: </p>
							<hr>
							<center><p style="font-size: 60px;"> P<?php echo $total_paid ?> </p></center>
							<hr><br>
							<center><a href= "manage_loads.php" target="iframe_content" class="a"><input class="btn btn-default" style="width: 290px;" type="button" name="back" value="Back to Load Records"/></a> </center>

					<?php } ?>

				</div>

			<?php } ?>
	
 <?php } ?>


	</div>

</body>
</html>