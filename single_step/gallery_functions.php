<?php
require_once "dbconnect.php";

function getGalleryItems(){ //you could also define limit here $limit=6 then tell it LIMIT $limit
	$conn = getConnection();
	$sql = "SELECT * FROM singlestep_gallery ORDER BY id DESC LIMIT 6"; //gets everything from the gallery displays in decending order and displays the latest 6. It ignores no matter how many are in there.
	return mysqli_query($conn, $sql);
}

function addNewGalleryItem($image, $title, $location, $description){
	$conn = getConnection(); //gets the connection
	$sql = "INSERT INTO singlestep_gallery(image, title, location, description) VALUES('$image', '$title', '$location', '$description')"; // inserts in the the database the follow info from the form (upload photos)
	return mysqli_query($conn, $sql);
}
