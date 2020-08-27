<?php

//Declaring variables to prevent errors
$fname = ""; //first name
$lname = ""; //last name
$em = ""; //email
$em2 = ""; //email2
$password = ""; //password
$password2 = ""; //password2
$date = ""; //Sign up date
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

	//register form values

	//first name
	$fname = strip_tags($_POST['reg_fname']); //removes html tags
	$fname = str_replace('', '', $fname);// removes spaces
	$fanme = ucfirst(strtolower($fname)); // Uppercase first letter
	$_SESSION['reg_fname'] = $fname;

	//last name
	$lname = strip_tags($_POST['reg_lname']); //removes html tags
	$lname = str_replace('', '', $lname);// removes spaces
	$lanme = ucfirst(strtolower($lname)); // Uppercase first letter
	$_SESSION['reg_lname'] = $lname;

	//email
	$em = strip_tags($_POST['reg_email']); //removes html tags
	$em = str_replace('', '', $em);// removes spaces
	$em = ucfirst(strtolower($em)); // Uppercase first letter
	$_SESSION['reg_email'] = $em;

	//email2
	$em2 = strip_tags($_POST['reg_email2']); //removes html tags
	$em2 = str_replace('', '', $em2);// removes spaces
	$em2 = ucfirst(strtolower($em2)); // Uppercase first letter
	$_SESSION['reg_email2'] = $em2;

	//password
	$password = strip_tags($_POST['reg_password']); //removes html tags
	$password2 = strip_tags($_POST['reg_password2']); //removes html tags

	$date = date("Y-m-d"); //this gets the current date

	if($em == $em2) {
		//Check if email is in valid format
		if(filter_var($em, FILTER_VALIDATE_EMAIL)) {

			$em = filter_var($em, FILTER_VALIDATE_EMAIL);

			//Check if email already exists
			$e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

			//Count the number of rows returned
			$num_rows = mysqli_num_rows($e_check);

			if($num_rows > 0) {
				array_push($error_array, "Email already in use<br>");
			}

		}
		else {
			array_push($error_array, "Invalid email format<br>");
		}
		

	}
	else {
		array_push($error_array, "Emails don't match<br>");
	}


	if(strlen($fname) > 25 || strlen($fname) < 2) {
		array_push($error_array, "Your first name must be between 2 and 25 characters<br>");
	}

	if(strlen($lname) > 25 || strlen($lname) < 2) {
		array_push($error_array, "Your last name must be between 2 and 25 characters<br>");
	}

	if($password != $password2){
		array_push($error_array, "Your passwords do not match<br>");
	}
	else{
		if(preg_match('/[^A-Za-z0-9]/', $password)){
			array_push($error_array, "Your password can only contain english characters or numbers<br>");
		}
	}

	if(strlen($password > 30 || strlen($password) < 5)){
		array_push($error_array, "Your password must be between 5 and 30 charcters<br>");
	}


	if(empty($error_array)) {
		$password = md5($password); //encypt password

		//generate username by concatenating first name and last name
		$username = strtolower($fname . "_" . $lname);
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

		$i = 0;

		while (mysqli_num_rows($check_username_query) != 0) {
			$i++;
			$username = $username . "_" . $i;
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
		}

		$rand = rand(1, 2);

		if($rand == 1)
		$profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
		else if($rand == 2)
		$profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

		$query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username','$em','$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

		array_push($error_array, "<span style='color: #14C800'>You're all set! Go ahead and login!</span><br>");


		$_SESSION['reg_fname'] ="";
		$_SESSION['reg_lname'] ="";
		$_SESSION['reg_email'] ="";
		$_SESSION['reg_email2'] ="";
	}

}
?>