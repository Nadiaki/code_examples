<?php
require_once "dbconnect.php";

//return true if logged in, false if not
function isLoggedIn(){ // checks the info stored in the cookie. If its all correct it checks if the cookie is correct and if so it returns true.
	if( !empty($_COOKIE['singlestep_login_email']) && !empty($_COOKIE['singlestep_login_password']) ){
		if(checkLoginInfo($_COOKIE['singlestep_login_email'], $_COOKIE['singlestep_login_password'])){
			return true;
		}
	}
	//for testing purposes and validation, allow user to skip login - You can not login using this either as its not in the database.
	// This is not used!! was for debug purposes but is not coded.
	if(!empty($_GET['skip_login'])){
		$_COOKIE['singlestep_login_email'] = "guest@guest.com";
		$_COOKIE['singlestep_login_password'] = md5('test123');
		return true;
	}

	return false;
}

function getUsernameByEmail($email){
	$conn = getConnection(); // this tells it to use the getConnection function
	$sql = "SELECT * FROM singlestep_profiles WHERE email = '$email' "; // this is what we want from the database.
	return mysqli_query($conn, $sql); //pass the following to getConnection.
}

//return true if login info is valid, false if not
//it receives email and ENCRYPTED password
function checkLoginInfo($email, $password){
	$conn = getConnection(); // this tells it to use the getConnection function
	//count number of records that have the email and password provided, needs to return 1 to be valid (only returns the vaild email and password if it does not exist it will return 0.
	$sql = "SELECT count(*) as counter FROM singlestep_profiles WHERE email = '$email' AND password = '$password' ";
	$result = mysqli_query($conn, $sql);
	$row = $result->fetch_row();
	if($row[0] == 1){
		return true;
	}
	else{
		return false;
	}
}

function setLoginSession($email, $password){
	$validity = time() + 3600; // determins how long the cookie is vaild. 3600 is an hour.
	//			name, value, time it expires
	setcookie("singlestep_login_email", $email, $validity) ; //creates 2 cookies which have email and password.
	setcookie("singlestep_login_password", md5($password), $validity);
}

// this is to log out also not in use.
function clearLoginSession(){
	//browser would see time is in the past and would delete it
	// time() Returns the current time measured in the number of seconds
	// since the Unix Epoch (January 1 1970 00:00:00 GMT).
	$validity = time() - 3600; // sets time in past
	// empty values so it fails validation
	setcookie("singlestep_login_email", "", $validity) ; // sets value of cookie to empty 0.
	setcookie("singlestep_login_password", "", $validity); // time is in past and cookies are empty so you can no longer login.
}

// for creating user account. Gets data from form username email and password then sends it to database with the sql statement.
function createUserProfile($username, $email, $password){
	$conn = getConnection();
	$sql = "INSERT INTO singlestep_profiles(username, email, password) VALUES('$username', '$email', MD5('$password')) ";
	return mysqli_query($conn, $sql); //returns result of the query. if it fails it will return false.
}
