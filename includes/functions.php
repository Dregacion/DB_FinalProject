<?php

function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
}

function mysql_prep($string){
	global $connection;

	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}

function confirm_query($result_set) {
	if(!$result_set) {
		die("Database query failed.");
	}
}

function form_errors($errors = array()){
	$output = "";

	if(!empty($errors)){
		$output .= "<div class =\"error\">";
		$output .= "Please fix the following errors: ";
		$output .= "<ul>";
			foreach($errors as $key => $error) {
				$output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
			}
		$output .= "</ul>";
		$output .= "</div>";
	}

	$message = strip_tags($output);

	return $message;
}


function user_username_exists($username){
	global $connection;

	$safe_username = mysqli_real_escape_string($connection, $username);

	$query  = "SELECT * ";
	$query .= "FROM users ";
	$query .= "WHERE username = '{$safe_username}' ";

	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);

	if($user_set && mysqli_num_rows($user_set) >= 1){
		return false;
	}else{
		return true;
	}
}


function admin_username_exists($username){
	global $connection;

	$safe_username = mysqli_real_escape_string($connection, $username);

	$query  = "SELECT * ";
	$query .= "FROM admin ";
	$query .= "WHERE Username = '{$safe_username}' ";

	$admin_set = mysqli_query($connection, $query);
	confirm_query($admin_set);

	if($admin_set && mysqli_num_rows($admin_set) >= 1){
		return false;
	}else{
		return true;
	}
}


function network_exists($network){
	global $connection;

	$safe_network = mysqli_real_escape_string($connection, $network);

	$query  = "SELECT * ";
	$query .= "FROM networks ";
	$query .= "WHERE Network = '{$safe_network}' ";

	$network_set = mysqli_query($connection, $query);
	confirm_query($network_set);

	if($network_set && mysqli_num_rows($network_set) >= 1){
		return false;
	}else{
		return true;
	}
}


// ADMINS -------------------------------------------------------------------------

function find_admin_by_username($username){
	global $connection;

	$safe_username = mysqli_real_escape_string($connection, $username);

	$query  = "SELECT * ";
	$query .= "FROM admin ";
	$query .= "WHERE username = '{$safe_username}' ";
	$query .= "LIMIT 1";

	$admin_set = mysqli_query($connection, $query);
	confirm_query($admin_set);

	if($admin = mysqli_fetch_assoc($admin_set)){
		return $admin;
	}else{
		return null;
	}
}


//USERS -------------------------------------------------------------------------

function find_user_by_username($username){
	global $connection;

	$safe_username = mysqli_real_escape_string($connection, $username);

	$query  = "SELECT * ";
	$query .= "FROM users ";
	$query .= "WHERE username = '{$safe_username}' ";
	$query .= "LIMIT 1";

	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);

	if($user = mysqli_fetch_assoc($user_set)){
		return $user;
	}else{
		return null;
	}
}



// CALCULATIONS -------------------------------------------------------------------


function found_date($date, $network){
	global $connection;

	$find_date = date($date);
	$safe_network = mysqli_real_escape_string($connection, $network);

		$query  = "SELECT * ";
		$query .= "FROM load_records ";
		$query .= "WHERE Date = '$find_date' AND ";
		$query .= "Network = '$safe_network' ";

	$date_set = mysqli_query($connection, $query);
	confirm_query($date_set);

	if($date_set && mysqli_num_rows($date_set) >= 1){
		return true;
	}else{
		return false;
	}

}

function valid_date($calculate_from, $calculate_to){
	$from = new DateTime($calculate_from);
	$to = new DateTime($calculate_to);

    if($from > $to){
    	return false;
    }else{
    	return true;
    }
}



//AUTHENTICATION ----------------------------------------------------------------------

function logged_in(){
	return isset($_SESSION["admin_id"]);
}

function confirm_logged_in(){
	if(!logged_in()){
		redirect_to("index.php");
	}else{
		return true;
	}
}


function client_logged_in(){
	return isset($_SESSION["user_id"]);
}

function client_confirm_logged_in(){
	if(!client_logged_in()){		
		redirect_to("index.php");
	}else{
		return true;
	}
}

function attempt_login($username, $password){
	$admin = find_admin_by_username($username);

	if($admin){
		//found admin, check password
		if(password_check($password, $admin["hashed_password"])){
			//password matches
			return $admin;
		}else{
			//password does not match
			return false;
		}

	}else{
		//admin not found
		return false;
	}
}

function user_attempt_login($username, $password){
	$user = find_user_by_username($username);

	if($user){
		//found client, check password
		if(password_check($password, $user["hashed_password"])){
			//password matches
			return $user;
		}else{
			//password does not match
			return false;
		}

	}else{
		//client not found
		return false;
	}
}

//PASSWORD ENCRYPTION ----------------------------------------------------------------

function password_encrypt($password){
	$hash_format = "$2y$10$";	//tells PHP to use Blowfish with a cost of 10
	$salt_length = 22;	//blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);

	return $hash;
}

function generate_salt($length){
	//not 100% unique, not 100% random, but good enough for a salt
	//MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));

	//valid characters for a salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);

	//but not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);

	//truncate string to the correct length
	$salt = substr($modified_base64_string, 0, $length);

	return $salt;
}

function password_check($password, $existing_hash){
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
	if($hash === $existing_hash){
		return true;
	}else{
		return false;
	}
}


  
?>