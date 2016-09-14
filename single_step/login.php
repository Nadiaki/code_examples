<?php
    require_once "checkLogin.php";  //needs this to work. Checks if it exists.
        $login_message = "";
        if(!empty($_POST['email']) && !empty($_POST['password'])){
            //user has submitted form!!
            $checkLogin = checkLoginInfo($_POST['email'], md5($_POST['password']));
            if($checkLogin){
                setLoginSession($_POST['email'], $_POST['password']); //this creates a cookie so you stay logged in.
                header('Location: index.php');
            }
            else{
                //user provided incorrect information then it will redirect you to login.php It will display the below IF (login_invalid)
                header('Location: login.php?login_invalid=1'); // this line has to go before the HTML any HTML... PHP must be at the very top with no spaces.
            }
        }

        if(!empty($_GET['login_invalid'])){ //only runs if the user enters the wrong infomation.
            $login_message = "The login information provided is invalid, try again!";
        }
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
        <ul class="clearfix">
            <a href="index.php#discover"><li>DISCOVER</li></a>
            <a href="explore.php"><li>EXPLORE</li></a>
            <a href="create.php"><li>CREATE</li></a>
            <a href="index.php#experience"><li>EXPERIENCE</li></a>
            <a href="index.php#contact"><li>CONTACT</li></a>
            <a href="login.php"><li>LOG IN</li></a>
        </ul>
    </nav>

<!--END NAV-->

<!--LOGIN FORM-->
<div id="login" class="vh_section">
<?php
  if(isLoggedIn()){
      //Checks if user is logged in
    <div style="text-align:center; margin-top:75px;">You're already logged in. Click to <a href="index.php">continue</a> </div>
  <?php
  }
  else{
?>

        <div id="login_form">
            <h3>Sign in:</h3>
            <div id = "login_message" class = "error"><?php echo $login_message; ?></div>
            <form action = "login.php" method = "POST">
                <table>
                    <tr><td>Email:</td><td><input type="text" id = "email" name = "email" placeholder="email" required></td></tr>
                    <tr><td>Password:</td><td><input type="password" id = "password" name = "password" placeholder="password" required></td></tr>
                    <tr><td></td><td><input type="submit" value="Log in"></td></tr>
                </table>
            </form>
        </div>
        <div id="new_to_ss" class="center_text"><p>New to Single Step?</p>
        <a href="sign_up.php">Click to sign up</a></div>

<?php
	}
?>
</div>

<!--END LOGIN-->

</body>
</html>
