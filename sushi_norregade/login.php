<?php
include("db.php");
if(isset($_POST["loginSubmit"])){
    if(performLogin($_POST["email"], $_POST["password"])){
        header("Location: index.php");
    }
}

include("header.php");
?>

<!--login form-->
<div id="div-login" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 large-6 columns">
            <div class="text-center">
                <h2>LOG IN</h2>

                <p>Don't have an account? Please <a href="register.php">register.</a></p>
            </div>
            <form action="login.php" method="POST">
                <div class="log-in-form">
                    <label>Email:
                        <input type="text" name="email" placeholder="name@domain.com" required>
                    </label>
                    <label>Password:
                        <input type="password" name="password" required>
                    </label>

                    <button type="submit" name="loginSubmit" class="button expanded">Log In</button>
                </div>
            </form>


        </div>
    </div>
</div>
<!--end login form-->

<!--footer-->
<?php
include("footer.php");
?>
