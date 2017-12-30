<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>


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

    <div style="background-color: #383d41;">
        <nav class="navbar navbar-inverse">

          <div class="container-fluid">

                <div class="navbar-header">
                  <a class="navbar-brand" style="color: white;">E-Loading Business Record</a>                 
                </div>

                <div class="navbar_right">

                    <p id="text">You are logged in, <?php echo htmlentities($_SESSION["username"]); ?>! </p>

                    <a href="user_logout.php" class="a"><input style="font-size: 13px;" class="btn btn-default" id="logout" type="button" value="LOG OUT"/></a> 

                </div>

          </div>

        </nav>
    </div>


   <aside class="sidebar" style="width:290px">
    <center><h4> User Menu </h4></center>      
        <hr>
        <div class="sidebar_links">
            <img class="icon" src="images/profile.png"/><a href="user_profile.php" target="iframe_content" class="h">User Profile</a>
            <br><br>
            <img class="icon" src="images/record.png"/><a href="record_loads.php" target="iframe_content" class="h">Record Load Transaction</a>
            <br><br>
            <img class="icon" src="images/history.png"/><a href="load_history.php" target="iframe_content" class="h">User Load History</a>           
        </div>
    </aside>

    <div class="content">
        <iframe name="iframe_content" src="source.php" style="width:1050px"></iframe>
    </div>

</body>

</html>