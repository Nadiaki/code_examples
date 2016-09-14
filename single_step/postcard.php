<?php
	require_once "postcard_functions.php";
	require_once "checkLogin.php"; //not in use...

	//redirect to login page if user is not logged in NOT IN USE (Obviously)
	//if(!isLoggedIn()){
	//	header('Location: login.php');
	//}

//all the variables the postcard uses to store the database. - These are the default ones which appear until you change anything or get new ones.
	$postcard_image_class = "pc_image_vis";
	$postcard_caption_position_class = "caption_lower_right";
	$postcard_captions_font_class = "font_geomanist_bold";
	$caption_font_color = "#fffaf5";
	$border_color = "#001024";
	$border_size = "0.5em";
	$postcard_back_font = "walter_turncoat";
	$default_caption_text = "Discover the beauty of Vis";
	$default_address1 = "Lars Nielsen";
	$default_address2 = "Lygten 16";
	$default_address3 = "Copenhagen NW";
	$default_postcard_back_text = "Croatia is absolutely amazing! Beautiful nature, interesting history, friendly locals...everything you need for a perfect holiday. You have to come with us next time!";
	$default_postcard_back_signature = "Hugs, Laura";


//everything below here is got from the database after you preview.
// GET is used to assign the value of the postcard. (you can get form post cards by entering there id into the browser) if it does not exist it uses the default.
    if(!empty($_GET["postcard_id"])){
        $id = $_GET["postcard_id"];
        $postcard = getPostcardById($id);
        if(mysqli_num_rows($postcard) == 1){
            //if we got one row
            $row = mysqli_fetch_assoc($postcard);

						// the above loop gets the data from the database and these change to reflect whats stored there.
			$postcard_image_class = $row["image"];
			$postcard_caption_position_class = $row["caption_position"];
			$postcard_captions_font_class = $row["caption_font"];
			$caption_font_color = $row["caption_font_color"];
			$border_color = $row["border_color"];
			$border_size = $row["border_type"];
			$postcard_back_font = $row["message_font"];
			$caption_text = $row["caption_text"];
			$postcard_back_text = $row["message"];
			$postcard_back_signature = $row["signature"];
			$address1 = $row["address1"];
			// optional fields
			if(!empty($row["address2"])){
			    $address2 = $row["address2"];
			}
			if(!empty($row["address3"])){
			    $address3 = $row["address3"];
			}
        }

    }

		//all of this works by changing which classes are applied to items.

// get the values and insert them.
	if(!empty($_POST["submitBtn"])){
		$postcard_image_class = $_POST["pc_preselect"]; //the image is not an image in the traditional sense it is a class.
		$postcard_caption_position_class = $_POST["caption_pos"];
		$postcard_captions_font_class = $_POST["caption_font"];
		$caption_font_color = $_POST["caption_font_color"];
		$border_color = $_POST["border_color"];
		$border_size = $_POST["pc_border"];
		$postcard_back_font = $_POST["back_font"];
		$caption_text = $_POST["caption_text"];
		$postcard_back_text = $_POST["postcard_back_text"];
		$postcard_back_signature = $_POST["postcard_back_signature"];
		$address1 = $_POST["address1"];
		// optional fields
		if(!empty($_POST["address2"])){
			$address2 = $_POST["address2"];
		}
		if(!empty($_POST["address3"])){
			$address3 = $_POST["address3"];
		}

		// save the postcard by its ID
		$id = addNewPostcard($postcard_image_class, $caption_text, $postcard_caption_position_class, $postcard_captions_font_class, $caption_font_color,
			 	$border_size, $border_color, $postcard_back_text, $postcard_back_signature, $address1, $address2, $address3, $postcard_back_font);
		header("Location: postcard.php?postcard_id=$id"); //redirect to the same page by the ID (so they can see the postcard they created).


	}

?>
<!DOCTYPE html>
<html>
<head>
    <title>SINGLE STEP - tailor-made travels</title>
    <meta charset="utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Architects+Daughter' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Walter+Turncoat' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=The+Girl+Next+Door' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="main.css" rel="stylesheet" type="text/css" />
    <link rel="Shortcut Icon" href="images/favicon.ico" />

</head>


<body>
<!--NAV-->
    <nav>
        <a href="index.php"><img src="images/logo.png" alt="Single Step logo" id="nav_logo"/></a>
        <ul>
            <li><a href="index.php#discover">DISCOVER</a></li>
            <li><a href="explore.php">EXPLORE</a></li>
            <li><a href="create.php">CREATE</a></li>
            <li><a href="index.php#experience">EXPERIENCE</a></li>
            <li><a href="index.php#contact">CONTACT</a></li>
            <li><a href="login.php">LOG IN</a></li>
        </ul>
    </nav>

		<div id="postcard_page" class="vh_section">
        <div id="pc_wrap" class="max_width center">
            <h1>CREATE A POSTCARD</h1>
            <div id="pc_form" class="one_third left">
                <form  action = "postcard.php" method = "POST" enctype="multipart/form-data">
                    <fieldset id="pc_form_front">
                        <h4>Front</h4>
                        Choose image: <br/>
                        <select name="pc_preselect" id="pc_preselect">
												<!--     If the image is pc_image_dubrovnik then make that the default one and therefore what is displayed.   -->
                        <!--                                           if condition is true                           then        else     -->
                        <option value="pc_image_dubrovnik" <?php echo ($postcard_image_class == "pc_image_dubrovnik") ? "selected" : ""; ?> >Dubrovnik at night</option>
                        <option value="pc_image_kornati" <?php echo ($postcard_image_class == "pc_image_kornati") ? "selected" : ""; ?> >Clear waters of Kornati</option>
                        <option value="pc_image_vis" <?php echo ($postcard_image_class == "pc_image_vis") ? "selected" : ""; ?> >Lighthouse at Vis</option>
                    </select><br/>
                    or upload your own: <input type="file" accept="image/*"> <br/>
										Caption position:
                    <input type="text"
                    	placeholder="<?php echo $default_caption_text; ?>"
                    	name = "caption_text" id = "caption_text"
                    	value = "<?php echo (!empty($caption_text)) ? $caption_text : ""; ?>"
                    	required><br/>
                    Caption position:
                    <select name="caption_pos">
											<!--                                           if condition is true                           then        else     -->
                        <option value="upper_left" <?php echo ($postcard_caption_position_class == "caption_upper_left") ? "selected" : ""; ?> >upper left</option>
                        <option value="upper_right" <?php echo ($postcard_caption_position_class == "caption_upper_right") ? "selected" : ""; ?> >upper right</option>
                        <option value="lower_left" <?php echo ($postcard_caption_position_class == "caption_lower_left") ? "selected" : ""; ?> >lower left</option>
                        <option value="lower_right"  selected="selected"> <?php echo ($postcard_caption_position_class == "caption_lower_right") ? "selected" : ""; ?> >lower right</option>
                    </select><br/>
                    Caption font:<br/>
                    <input type="radio" name="caption_font" value="geomanist_book" <?php echo ($postcard_captions_font_class == "geomanist_book") ? "checked" : ""; ?> >GEOMANIST Book<br/>
                    <input type="radio" name="caption_font" value="geomanist_bold" <?php echo ($postcard_captions_font_class == "geomanist_bold") ? "checked" : ""; ?> ><span class="geo_bold">GEOMANIST Bold</span><br/>
                    <input type="radio" name="caption_font" value="geomanist_ultra" <?php echo ($postcard_captions_font_class == "geomanist_ultra") ? "checked" : ""; ?> ><span class="geo_ultra">GEOMANIST Ultra</span><br/>
                    Caption font color: <input type="color" id = "caption_font_color" name = "caption_font_color" value = "<?php echo $caption_font_color; ?>" ><br/>
                    Border:<br/>
										<!--                                           if condition is true                           then        else     -->
                    <input type="radio" name="pc_border" value="thin" <?php echo ($border_size == "0.5em") ? "checked" : ""; ?> >thin<br/>
                    <input type="radio" name="pc_border" value="thick" <?php echo ($border_size == "1em") ? "checked" : ""; ?> >thick<br/>
                    <input type="radio" name="pc_border" value="none" <?php echo ($border_size == "0") ? "checked" : ""; ?> >none<br/>
                    Border color: <input type="color" id = "border_color" name = "border_color" value = "<?php echo $border_color; ?>"><br/>
                    <input type="submit" value="Preview" name = "submitBtn"><input type="reset" value="Reset"><br/>
                </fieldset>
                <fieldset>
                    <legend>Back:</legend>
                    Message:<br/>
										<!-- if there is a back text then echo it -->
                    <textarea placeholder="<?php echo $default_postcard_back_text; ?>"
                    	rows="7" cols="25" id = "postcard_back_text" name = "postcard_back_text" required><?php echo (!empty($postcard_back_text)) ?  $postcard_back_text : ""; ?></textarea>
                    <br/>
                    Signature:<br/>
                    <input type="text" placeholder="<?php echo $default_postcard_back_signature; ?>"
                    	id = "postcard_back_signature" name = "postcard_back_signature"
                    	value = "<?php echo (!empty($postcard_back_signature)) ? $postcard_back_signature : ""; ?>" required><br/>
                    To:<br/>
                    <input type="text" placeholder="<?php echo $default_address1; ?>"
                    	id = "address1" name = "address1"
                    	value = "<?php echo (!empty($address1)) ? $address1 : ""; ?>" required><br/>
                    <input type="text" placeholder="<?php echo $default_address2; ?>"
                    	id = "address2" name = "address2"
                    	value = "<?php echo (!empty($address2)) ? $address2 : ""; ?>"><br/>
                    <input type="text" placeholder="<?php echo $default_address3; ?>"
                    	id = "address3" name = "address3"
                    	value = "<?php echo (!empty($address3)) ? $address3 : ""; ?>"><br/>
                    Font:<br/>
                    <input type="radio" name="back_font" value="girl_nextdoor" <?php echo ($postcard_back_font == "girl_nextdoor") ? "checked" : ""; ?> ><span class="girl_nextdoor">The Girl Next Door</span><br/>
                    <input type="radio" name="back_font" value="architects_daughter" <?php echo ($postcard_back_font == "architects_daughter") ? "checked" : ""; ?> ><span class="architects_daughter">Architect's Daughter</span><br/>
                    <input type="radio" name="back_font" value="walter_turncoat" <?php echo ($postcard_back_font == "walter_turncoat") ? "checked" : ""; ?> ><span class="walter_turncoat">Walter Turncoat</span><br/>
                    <input type="submit" value="Preview" name = "submitBtn"><br/>
                </fieldset>
                <fieldset>
                    <legend>Share with a friend:</legend>
                    Name: <input type="text" placeholder="Lars"><br/>
                    Email address: <input type="email" placeholder="lars@email.dk"><br/>
                    <input type="submit" value="Send">
                </fieldset>
            </form>

        </div>

					<!-- All of the below classes and styles are controlled by PHP. Depending on what they have been set by the preview (from the database).-->
				<div id="pc_preview" class="two_thirds left clearfix">
            <div id="pc_front" class = "<?php echo $postcard_image_class; ?>" style = "border: <?php echo "$border_size solid $border_color"; ?>">
                <div id="prev_caption"
                	class = "<?php echo "$postcard_caption_position_class $postcard_captions_font_class"; ?>"
                	style = "color: <?php echo $caption_font_color; ?> ">
                	<?php echo (!empty($caption_text)) ? $caption_text : $default_caption_text; ?></div>
            </div>
            <div id="pc_back" class = "<?php echo $postcard_back_font; ?> ">
							<div id="prev_message" class="fifty left">
                    <div id="prev_message_body" ><?php echo (!empty($postcard_back_text)) ? $postcard_back_text : $default_postcard_back_text; ?></div>
                    <div id="prev_message_signature">
                    	<?php echo (!empty($postcard_back_signature)) ? $postcard_back_signature : $default_postcard_back_signature; ?>
                    </div>
                </div>

                <div id="prev_address" class="fifty left">
                    <p>To:</p>
                    <p><?php echo (!empty($address1)) ? $address1 : $default_address1; ?></p>
                    <p><?php echo (!empty($address2)) ? $address2 : ""; ?></p>
                    <p><?php echo (!empty($address3)) ? $address3 : ""; ?></p>
                </div>
            </div>
        </div>


    </div>

</body>
</html>
