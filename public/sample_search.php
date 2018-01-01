<?php require_once("../includes/db_connection.php"); ?> 
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

 <?php

    if(isset($_POST['search'])){

        $searchFirstName = $_POST['searchFirstName'];
        $searchLastName = $_POST['searchLastName'];
        $searchUsername = $_POST['searchUsername'];
        $searchEmail = $_POST['searchEmail'];
        $searchAddress = $_POST['searchAddress'];
        $searchCity = $_POST['searchCity'];
        $searchAddedBy = $_POST['searchAddedBy'];


        // search in all table columns
        // using concat mysql function
        /*
        $query = "SELECT * FROM users WHERE CONCAT(Added_BY, First_Name, Last_Name, Username, Email, Address, City) LIKE '%".$searchFirstName."%' OR '%".$searchLastName."%' OR '%".$searchUsername."%' OR '%".$searchEmail."%' OR '%".$searchAddress."%' OR '%".$searchCity."%' OR '%".$searchAddedBy."%'";
        */

        if($_POST['searchFirstName'] == NULL AND $_POST['searchLastName'] == NULL AND $_POST['searchUsername'] == NULL AND $_POST['searchEmail'] == NULL AND $_POST['searchAddress'] == NULL AND $_POST['searchCity'] == NULL AND $_POST['searchAddedBy'] == NULL){

            $message = "Please enter a value to search.";
            echo "<script type='text/javascript'>alert('$message');</script>"; 

            $query = "SELECT * ";
            $query .= "FROM users";

            $search_result = mysqli_query($connection, $query);

        }else{

            $query  = "SELECT * FROM ";
            $query .= "users ";
            $query .= "WHERE First_Name LIKE '%".$searchFirstName."%' AND ";
            $query .= "Last_Name LIKE '%".$searchLastName."%' AND ";
            $query .= "Username LIKE '%".$searchUsername."%' AND ";
            $query .= "Email LIKE '%".$searchEmail."%' AND ";
            $query .= "Address LIKE '%".$searchAddress."%' AND ";
            $query .= "City LIKE '%".$searchCity."%' AND ";
            $query .= "Added_By LIKE '%".$searchAddedBy."%' ";

            $search_result = mysqli_query($connection, $query);

        }

    } else {

        $query = "SELECT * ";
        $query .= "FROM users";

        $search_result = mysqli_query($connection, $query);
        
    }

?>


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
        
    <form action="sample_search.php" method="post">

            <input type="text" name="searchFirstName" placeholder="Value To Search FirstName"><br>
            <input type="text" name="searchLastName" placeholder="Value To Search LastName"><br>
            <input type="text" name="searchUsername" placeholder="Value To Search Username"><br>
            <input type="text" name="searchEmail" placeholder="Value To Search Email"><br>
            <input type="text" name="searchAddress" placeholder="Value To Search Address"><br>
            <input type="text" name="searchCity" placeholder="Value To Search City"><br>
            <input type="text" name="searchAddedBy" placeholder="Value To Search AddedBy"><br>

            <input type="submit" name="search" value="Filter"><br><br>
            
        <table class="table">
                <tr>
                    <th>First Name </th>
                    <th> Last Name </th>
                    <th> Username </th>
                    <th> Email </th>
                    <th>Address </th>
                    <th> City </th>
                    <th> Added By </th>
                    <th> Action </th>
                </tr>

    <?php if(mysqli_num_rows($search_result)>0){

            while($user = mysqli_fetch_assoc($search_result)){ ?>    

                <tr> 
                    <td> <?php echo $user['First_Name'] ?> </td>
                    <td> <?php echo $user['Last_Name'] ?> </td>
                    <td> <?php echo $user['Username'] ?> </td>
                    <td> <?php echo $user['Email'] ?> </td>
                    <td> <?php echo $user['Address'] ?> </td>
                    <td> <?php echo $user['City'] ?> </td>
                    <td> <?php echo $user['Added_By'] ?> </td>

                    <td><a href="delete_user.php?id=$user['id']" onclick="return confirm('Are you sure you want to delete this user?')\"; class='delete'><img src='images/delete.png' width="20px;" height='20px;' /></a></td>

                </tr>

            <?php } ?>

    <?php }else{   ?>

            <tr>
                <center>
                    <td colspan="8"><h2> No results found. </td></h2>
                </center>
            </tr>

    <?php } ?>   

        </table>
    </form>
        

</body>
</html>