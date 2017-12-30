<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>



<?php
    $username = "";

    if (isset($_POST['submit'])){
        //Process the form

        //Validations
        $required_fields = array("username", "password");
        validate_presences($required_fields);

        if(empty($errors)) {
        //ATTEMPT LOGIN
            
            $username = $_POST["username"];
            $password = $_POST["password"];

            $found_admin = attempt_login($username, $password);
            $found_client = user_attempt_login($username, $password);

            if($found_admin){
                //success, Mark user as logged in
                $_SESSION["admin_id"] = $found_admin["id"];
                $_SESSION["username"] = $found_admin["Username"];
                $_SESSION["password"] = $found_admin["hashed_password"];

                redirect_to("admin_menu.php");

            }elseif($found_client){
                //success, Mark user as logged in
                $_SESSION["user_id"] = $found_client["id"];
                $_SESSION["username"] = $found_client["Username"];
                $_SESSION["password"] = $found_client["hashed_password"];

                redirect_to("user_menu.php");

            }else{
                 //failure
                //$_SESSION["message"] = "Username/Password not found!";
                $message = "Username/Password not found!";
                echo "<script type='text/javascript'>alert('$message');</script>";
            }

        }else{
            $message = form_errors($errors);
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
    }    

?>



</!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="Images/icon.ico">
    <title>E-Loading Business Record</title>
    <link href="bootstrap_css/styles.css" rel="stylesheet">
    <link href="bootstrap_css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap_js/bootstrap.min.js"></script>
    <script src="Jquery/jquery.min.js"></script>    

    <style type="text/css">

        .login_form{
            background-color: #383d41;
            width: 350px; 
            float:right; 
            margin-top: 100px;
            padding: 25px; 
            margin-right: 120px; 
            border-radius: 25px;
            opacity: .9;
        }

        .title{
            width: 650px;
            float:left;
            margin-top: 100px;            
            margin-left: 120px;
        }  

        p{
            font-size: 70px;
            font-family: "CALIBRI";
        }

        .btn{
            background-color: darkgray;
            color: #383d41;
            cursor:pointer
        }

        .btn:hover{
            background-color: white;
            color: #383d41;
            cursor:pointer;
            border-style: solid;
            border-width: 1px;
            border-color: #383d41;
        }

    </style>

</head>

<body>

    <div style="background-color: #383d41;">
        <nav class="navbar navbar-inverse">

          <div class="container-fluid">

                <div class="navbar-header">
                  <a class="navbar-brand" style="color: white;">E-Loading Business Record</a>
                </div>

          </div>

        </nav>
    </div>

    <div class="title">
        <center>
            <br>
            <img src="images/home_title.png" width="660px;" height="210px;">
           
        </center>
    </div>

    <div class="login_form">
         <form action="index.php" method="POST">

            <center><h4 style="color:white;"> LOG IN </h4></center>
            <hr>

            <div class="form-group">
                <label for="username" style="color:white;">Username:</label>
                <input class="form-control" style="width: 300px;" type="text" required="required" name="username" value="<?php echo isset($_POST["username"]) ? $_POST["username"] : "" ?>" />
            </div>

            <div class="form-group">
                <label for="pwd" style="color:white;">Password:</label>
                <input type="password" class="form-control" style="width: 300px;" required="required" name="password">
            </div>
            <br>

            <center><input type="submit" class="btn btn-default" name="submit" value="LOG IN"/></center>

        </form> 
    </div>


</body>

</html>