<?php
require_once "dbconnect.php";

//sends all the things you select on the postcard form the the database

function addNewPostcard($image, $caption_text, $caption_position, $caption_font,
					$caption_font_color, $border_type, $border_color, $message,
					$signature, $address1, $address2, $address3, $message_font){
	$conn = getConnection();
	$sql = "INSERT INTO singlestep_postcards
				(image, caption_text, caption_position, caption_font,
					caption_font_color, border_type, border_color, message,
					signature, address1, address2, address3, message_font)
				VALUES('$image', '$caption_text', '$caption_position', '$caption_font',
					'$caption_font_color', '$border_type', '$border_color', '$message',
					'$signature', '$address1', '$address2', '$address3', '$message_font')";
	mysqli_query($conn, $sql);
	//get the auto generated ID of the most recent query - using the get function (see url) when you PREVIEW!
	return mysqli_insert_id($conn);
}

function getPostcardById($id){
	$conn = getConnection();
	$sql = "SELECT * FROM singlestep_postcards WHERE id = $id";
	return mysqli_query($conn, $sql);
}
