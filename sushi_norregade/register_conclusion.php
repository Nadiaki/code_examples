<?php
require_once("db.php");
if(isset($_POST["registerSubmit"])){
    if($_POST["password"] != $_POST["retype_password"]){
        echo "Passwords do not match!";
    }
    else{
        $registerSuccess = registerUser($_POST["username"], $_POST["email"], $_POST["password"], !empty($_POST["newsletter"]));
    }
}

include("header.php");
?>

<!--login form-->
<div id="div-registration" class="rice-light">
    <div class="row align-center">
        <div class="small-12 medium-8 large-6 columns">
		    <?php 
		    if(!empty($registerSuccess)){
		    ?>   
		        <div data-alert class="callout success align-center text-center">
		          <p>Thank you for registering with us!</p>
		          <p>Click <a href="login.php">here</a> to login</p>
		        </div>
		    <?php 
		    }
		    else{
		    ?>
		        <div data-alert class="callout alert align-center text-center">
		          <p>There seems to have been a problem processing your registration.</p>
		          <p>Please <a href="register.php">try again</a> or contact us by phone at +45 33 12 70 70</p>
		        </div>
		    <?php    
		    }
		    ?>  
        </div>
    </div>
</div>
<!--end login form-->

<!--footer-->
<?php
    require_once("footer.php");
?>