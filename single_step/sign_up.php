<?php
   require_once "checkLogin.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>SINGLE STEP - tailor-made travels</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="main.css" rel="stylesheet" type="text/css" />
    <link rel="Shortcut Icon" href="images/favicon.ico" />

</head>

<body>
<!--NAV-->
    <nav>
        <a href="index.php"><img src="images/logo.png" alt="Single Step logo" id="nav_logo"/></a>
        <ul>
            <a href="index.php#discover"><li>DISCOVER</li></a>
            <a href="explore.php"><li>EXPLORE</li></a>
            <a href="create.php"><li>CREATE</li></a>
            <a href="index.php#experience"><li>EXPERIENCE</li></a>
            <a href="index.php#contact"><li>CONTACT</li></a>
            <a href="login.php"><li>LOG IN</li></a>
        </ul>
    </nav>

<!--END NAV-->

<!--SIGN UP FORM-->
<?php

    $form_visibility = true;
    $message = "";
    if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['pass_confirm'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $pass_confirm = $_POST['pass_confirm'];
    }

    //creating a new profile?
    if(!empty($username) && !empty($email) && !empty($password) && !empty($pass_confirm)){
        //checks if the 2 passwords are identical
        if ($password === $pass_confirm) {
					//it will return FALSE is there's a database error!
					if(createUserProfile($username, $email, $password) === false){
					    $message = "There was an error creating profile, please check information and try again or contact our support";
					}
					else{
					    $message = "Profile Created, enjoy your new Single Step account! Click to <a href = 'login.php'>login</a>";
					    $form_visibility = false;
					}
				//if passwords are not identical:
				}else{
					$message = "Your passwords were not identical, please try again.";
				}
    }
?>


<div id="signup" class="vh_section">
<?php
    if($form_visibility === true){
?>

  <div id="signup" class="vh_section">
    <div id="signup_form">
      <h3>Sign up:</h3>
      <form action = "sign_up.php" method = "POST">
        <table>
        	<tr><td><div id = "error_message" class = "error"><?php echo $message; ?></td></tr>
			<tr><td>User name:</td><td><input type="text" id="username" name="username" placeholder="Username" required></td></tr>
			<tr><td>E-mail:</td><td><input type="email" id = "email" name = "email" placeholder="Your email" required></td> </tr>
			<tr><td>Password:</td><td><input type="password" id="password" name="password" placeholder="password"></td></tr>
			<tr><td>Confirm password:</td><td><input type="password" id="pass_confirm" name="pass_confirm" placeholder="password"></td></tr>
			<tr><td></td><td><input type="reset" value="Reset"><input type="submit" value="Submit"></td></tr>
        </table>
      </form>

    </div>
  </div>

 	<?php
		}else{
	?>
   	<div style="text-align:center; margin-top:75px;"><?php echo $message; ?></div>
  <?php
		}
	?>
</div>
</body>
</html>
