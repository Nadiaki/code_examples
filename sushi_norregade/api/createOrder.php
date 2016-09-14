<?php
	require_once("../db.php");
	insertOrder($_POST["order_items"], $_POST["table_id"], $_POST["comments"], !empty($_POST["is_all_you_can_eat"]));
?>