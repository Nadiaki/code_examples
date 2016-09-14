<?php

function upload_image($image_field = null){
	//taken and adapted from W3Schools
	$uploadOk = 1; //by default it is one to avoid a error stragiht away.
	$errorMessage = "";
	$target_dir = "uploads/"; //uploads the uploads folder.
	//if function received the name of the form field responsible for the image, if not use a default one to make it compatible with previous work...
	$image_field = (!empty($image_field)) ? $image_field : 'image_file'; //if you define no name then it will take the one from the file.
	//
	if(empty($_FILES[$image_field]["name"])){ 	//no image received? no point continuing - if no name is found in the form then there is no image.
		return false;
	}
	//get the extension from our image file/name
	$imageFileType = pathinfo($target_dir.$_FILES[$image_field]["name"],PATHINFO_EXTENSION); //pathinfo gets a path with the file name PATHINFO_EXTENSION gets the extention (jpg png)
	//generate a random number for the file name, to avoid repetitions, cant forget to add the extension to it...
	//(should avoid problems I was getting with images of the same name...)

	$target_file = $target_dir . md5(mt_rand()).".".$imageFileType; // It assigns the image a random number (mt_rand) it avoids problems if images with the same name are uploaded as every uploaded image will be renamed to a random number.

	// Allow only certain file formats (images) - W3schools
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" //this checks if the PATHINFO_EXTENSION is correct (one of the following filetypes) if not it returns an error.
	&& $imageFileType != "gif" ) {
	    $errorMessage = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
	}
	// Check if $uploadOk is not set to 0 (in case of an error before this)
	if ($uploadOk == 1) {
		//this seems to be the function that actually moves the image, if it returns false then means it had an error
		//http://php.net/manual/en/function.move-uploaded-file.php
		if (!move_uploaded_file($_FILES[$image_field]["tmp_name"], $target_file)) { //tells the server to move the image to the specified upload folder. $target_dir = uploads.
		    $errorMessage = "Sorry, there was an error uploading your file.";
		    $uploadOk = 0;
		}
	}
	//ended up not using the error messages, but will keep them, never know if they might come in handy in the future
	if($uploadOk){
		//return path to image that was uploaded in case of sucess
		return $target_file;
	}
	else{
		//upload failed
		return false;
	}
}
