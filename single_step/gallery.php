<?php //this function is local as its only needed here hence why its here.
    require_once "gallery_functions.php";
    require_once "upload_image.php";

    if(!empty($_POST['submitBtn'])){ //if submitBtn is pressed it will send the data via $_POST. It will send the following info.
        $image = upload_image(); //sends them to the upload folder on the server. Links them to the image database.
        // you could put a name in here upload_image(something) but you will need to define it in the form too.
        $title = $_POST['title'];
        $location = $_POST['location'];
        $description = $_POST['description'];
        addNewGalleryItem($image, $title, $location, $description);
        unset($_POST); //this doesnt work but should have. unset is a special php function which unsets everything.
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

<!--GALLERY-->

<div id="gallery" class="vh_section">
        <div id="upload_to_gallery" class="center max_width">
            <h1>GALLERY</h1>
            <div id="gallery_text" class="half left">
                <p>Praesent et neque a felis feugiat pharetra eget non ligula. Ut aliquam felis magna, in interdum enim lobortis a. Quisque aliquam urna vel nulla euismod suscipit.</p><p>Vivamus nec scelerisque ligula, a dictum nisi. Vivamus bibendum vel metus vel dapibus. Duis in lacus nibh. Vivamus eget quam lorem.</p>
            </div>

            <div id="image_upload" class="half left">
                <form action = "gallery.php" method = "POST" enctype="multipart/form-data"> <!-- you must have post you cant pass image via GET and it needs to be form-data as straight form will only send data. -->
                    <h4>Upload your photos:</h4>
                    <table>
                      <!-- accept image means it can only accept images files jpg, png etc. -->
                    <tr><td>Image:</td><td><input type="file" accept="image/*" name = "image_file" id = "image_file" required></td></tr>
                    <tr><td>Title:</td><td><input type="text" maxlength="30"  name = "title" id = "title" required></td></tr>
                    <tr><td>Location:</td><td><input type="text" maxlength="30"  name = "location" id = "location" required></td></tr>
                    <tr><td>Description:</td><td><textarea maxlength="150" name = "description" id = "description" required></textarea></td></tr>
                    <tr><td></td><td><input type="submit" value="upload" name = "submitBtn" id = "submitBtn"></td></tr>
                    </table>
                </form>
            </div>
            <div class="clearfix"></div>

        </div>


        <h2 class="center_text">Latest photos</h2>
        <div id="gallery_photos">
            <div id="gallery_photos_wrap" class="center max_width">
                <ul>
                    <?php
                        $images = getGalleryItems(); //calls the function
                        while($image = mysqli_fetch_assoc($images)) { //mysqli_fetch_assoc returns an associative array. The array is based upon the gallerys id's.
                          // this is handy as it will return all the data stored in the array. for example title, location all the database tables.
                    ?><li><img src="<?php echo $image['image']; ?>" alt="<?php  echo $image['title']; ?>"/>
                            <div class="photo_details">
                                <h4 class="gallery_image_title"><?php echo $image['title']; ?></h4> <!-- gets the title from the array -->
                                <p class="gallery_image_location"><?php echo $image['location']; ?></p> <!-- gets the location from the array -->
                                <p class="gallery_image_description"><?php echo $image['description']; ?></p> <!-- gets the description (look at the finished product.) -->
                            </div>
                        </li
                    ><?php } ?> <!-- closes the loop and ends the php. The alterantive would be putting all the html in the php. this is cleaner and a better way to do it.  -->
                </ul>
            </div>
        <div class="clearfix"></div></div>
    </div>    


</body>
</html>
