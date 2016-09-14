<?php
require_once("db.php");
include("header.php");
?>

<!--login form-->
<div id="div-registration" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 large-6 columns">
            <div class="text-center">
                <h2>REGISTER ACCOUNT</h2>

                <p>Already registered? Please <a href="login.php">log in.</a></p>
            </div>

            <form action="register_conclusion.php" method="POST">
                <div class="registration-form">
                    <label>Username:
                        <input type="text" name="username" required>
                    </label>
                    <label>Email:
                        <input type="email" name="email" placeholder="name@domain.com" required>
                    </label>
                    <label>Password:
                        <input type="password" name="password" required>
                    </label>
                    <label>Repeat password:
                        <input type="password" name="retype_password" required>
                    </label>
                    <input id="newsletter" type="checkbox" checked="checked" name="newsletter">
                    <label for="newsletter">I'd like to receive offers and newsletter</label>

                    <button type="submit" class="button expanded" name="registerSubmit">Register account</button>
                </div>
            </form>


        </div>
    </div>
</div>
<!--end login form-->

<!--footer-->
<?php
require_once("footer.php");
?>