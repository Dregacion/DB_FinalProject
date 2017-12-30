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

                    <a href="logout.php" class="a"><input style="font-size: 13px;" class="btn btn-default" id="logout" type="button" value="LOG OUT"/></a> 

                </div>

          </div>

        </nav>
    </div>


   <aside class="sidebar">
    <center><h4> Admin Menu </h4></center>      
        <hr>
        <div class="sidebar_links">
            <img class="icon" src="images/profile.png"/><a href="admin_profile.php" target="iframe_content" class="h">Admin Profile</a>
            <br><br>
            <img class="icon" src="images/activity.png"/><a href="users_activity.php" target="iframe_content" class="h">Users Activity</a>
            <br><br>
            <img class="icon" src="images/admin.png"/><a href="manage_admins.php" target="iframe_content" class="h">Manage Admins</a>
            <br><br>
            <img class="icon" src="images/users.png"/><a href="manage_users.php" target="iframe_content" class="h">Manage Users</a>
            <br><br>
            <img class="icon" src="images/networks.png"/><a href="manage_networks.php" target="iframe_content" class="h">Manage Networks</a>
            <br><br>
            <img class="icon" src="images/manage_loads.png"/><a href="manage_loads.php" target="iframe_content" class="h">Manage Mobile Loads</a>
            <br><br>
        </div>
        <hr>
    <!--    
        <div class="sidebar_links">  
            <img class="icon" src="images/smart.png"/><a href="smart_loads.php" target="iframe_content" class="h">Manage Smart Loads</a>
            <br><br>
            <img class="icon" src="images/globe.png"/><a href="globe_loads.php" target="iframe_content" class="h">Manage Globe Loads</a>          
        </div>
    -->    
    </aside>

    <div class="content">
        <iframe name="iframe_content" src="source.php"></iframe>
    </div>



</body>

</html>