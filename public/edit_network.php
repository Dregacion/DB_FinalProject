<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php      

    $network_set = mysqli_query($connection, "Select * from networks");

    if($network_set){
        $network = mysqli_fetch_assoc($network_set);
    }

?>

<?php  

    $id = $_GET["id"];  

    if(isset($_POST['submit'])){
 
        $fields_with_max_lengths = array("network" => 25);
        validate_max_lengths($fields_with_max_lengths);

        $fields_with_min_lengths = array("network" => 2);
        validate_min_lengths($fields_with_min_lengths);
        
        if(empty($errors)){

            $added_by = $_SESSION["username"];
            $network = mysql_prep($_POST["network"]);
        
            $query = "CALL update_network('$id','$added_by', '$network')";
  

            $result = mysqli_query($connection, $query);

            if($result && mysqli_affected_rows($connection) == 1){
                $message = "Mobile Network successfully updated!";
                echo "<script type='text/javascript'>alert('$message'); window.location.replace(\"manage_networks.php\");</script>"; 

            }else{
                $message = "Mobile Network update failed.";
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

    <div class="add_network">

        <div class="container">

            <form class="form-horizontal" action="edit_network.php?id=<?php echo urlencode($network["id"]); ?>" method="post"><br>

                <center><h3>Edit Mobile Network</h3></center>
                <hr style="width:440px; margin-left: -60px"><br>

                <div class="form-group">
                    <label class="control-label col-sm-10" for="network">Mobile Network:</label>
                    <div class="col-sm-10">
                        <input class="form-control" style="width: 300px; height: 35px;" type="text" required="required" value="<?php echo isset($_POST["network"]) ? $_POST["network"] : htmlentities($network["Network"]); ?>" name="network">
                     </div>
                </div>

                <br>
                <center>
                    <div class="form-group">        
                        <div class="col-sm-offset-5 col-sm-10">
                            <input type="submit" class="btn btn-default" style="margin-right: 20px" name="submit" value="Save"/>
                            <a href="manage_networks.php" class="a"><input class="btn btn-default" type="button" onclick="return confirm('Are you sure you want to cancel?')" name="cancel" value="Cancel"/></a>   
                        </div>
                    </div>
                </center> 
                <br>

            </form>

        </div>

    </div>     


</body>

</html>