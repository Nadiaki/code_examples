<?php
session_start();

function getConnection(){
	$db = new PDO('mysql:host=localhost;dbname=sushi_norregade;charset=utf8', "root", "");
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	return $db;
}

function getMenuItems($id_category){
	$db = getConnection();
	$stmt = $db->prepare("SELECT food_items.*, sensitivities.name as 'sensitivity_name' FROM food_items 
							LEFT JOIN sensitivities_food ON food_items.id = sensitivities_food.id_food 
							LEFT JOIN sensitivities ON sensitivities_food.id_sensitivity = sensitivities.id 
							WHERE food_items.id_category = :id_category AND in_stock = 1");
	$stmt->bindValue(':id_category', $id_category, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllMenuItems($id_category){
	$db = getConnection();
	$stmt = $db->prepare("SELECT * 
			FROM food_items WHERE id_category = :id_category");
	$stmt->bindValue(':id_category', $id_category, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getOrderDetails($id_order){
	$db = getConnection();
	$stmt = $db->prepare("SELECT * 
		FROM order_items 
		WHERE id_order = :id_order");
	$stmt->bindValue(':id_order', $id_order, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateFoodStockStatus($id, $in_stock){
		$db = getConnection();
		$stmt = $db->prepare("UPDATE food_items SET in_stock = :in_stock WHERE id = :id");
		$stmt->bindValue(':id', $id, PDO::PARAM_INT);
		$stmt->bindValue(':in_stock', $in_stock);
		$stmt->execute();
}

function getCategories(){
	$db = getConnection();
	$stmt = $db->prepare("SELECT id, name_en, name_dk FROM categories ORDER BY id");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertOrder($food_items, $id_table, $comments, $is_all_you_can_eat){
	$db = getConnection();
	$stmt = $db->prepare("INSERT INTO orders(id_table, comments, is_all_you_can_eat) VALUES(:id_table, :comments, :is_all_you_can_eat)");
	$stmt->bindValue(':id_table', $id_table, PDO::PARAM_INT);
	$stmt->bindValue(':comments', $comments);
	$stmt->bindValue(':is_all_you_can_eat', $is_all_you_can_eat, PDO::PARAM_INT);
	$stmt->execute();

	$orderId = $db->lastInsertId();
		
	foreach ($food_items as $food_item) {
		$stmt = $db->prepare("INSERT INTO order_items(id_order, id_food_item, quantity, price, name_dk, name_en) 
			VALUES(:id_order, :id_food_item, :quantity, :price, :name_dk, :name_en)");
		$stmt->bindValue(':id_order', $orderId, PDO::PARAM_INT);
		$stmt->bindValue(':id_food_item', $food_item["foodid"], PDO::PARAM_INT);
		$stmt->bindValue(':quantity', $food_item["quantity"], PDO::PARAM_INT);
		$stmt->bindValue(':price', $is_all_you_can_eat ? 0 : $food_item["price"]);
		$stmt->bindValue(':name_dk', $food_item["namedk"]);
		$stmt->bindValue(':name_en', $food_item["nameen"]);
		$stmt->execute();
	}
}

function registerUser($username, $email, $password, $hasNewsletter){
	$db = getConnection();
	$stmt = $db->prepare("INSERT INTO users(username, email, password, newsletter)
						VALUES(:username, :email, :password, :newsletter)");
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':password', hash("sha512", $password));
	$stmt->bindValue(':username', $username);
	$stmt->bindValue(':newsletter', $hasNewsletter, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->rowCount() == 1;
}

//tries to log in user, returns true if successful or false if not
function performLogin($email, $password){
	$db = getConnection();
	$stmt = $db->prepare("SELECT id FROM users WHERE email = :email AND password = :password");
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':password', hash("sha512", $password));
	$stmt->execute();
	if($stmt->rowCount() == 1){
		$user = $stmt->fetchObject();
		$_SESSION["user_id"] = $user->id;
		return true;
	};

	return false;
}

function isUserLoggedIn(){
	return !empty($_SESSION["user_id"]);
}

function insertBooking($email, $name, $phone, $number_guests, $time_booking, $id_table, $observations){
	$db = getConnection();
	$stmt = $db->prepare("INSERT INTO bookings(email, name, phone, number_guests, time_booking, id_table, observations)
				VALUES(:email, :name, :phone, :number_guests, :time_booking, :id_table, :observations)");
	$stmt->bindValue(':email', $email);
	$stmt->bindValue(':name', $name);
	$stmt->bindValue(':phone', $phone);
	$stmt->bindValue(':number_guests', $number_guests, PDO::PARAM_INT);
	$stmt->bindValue(':time_booking', $time_booking);
	$stmt->bindValue(':id_table', $id_table, PDO::PARAM_INT);
	$stmt->bindValue(':observations', $observations);
	$stmt->execute();
	return $stmt->rowCount() == 1;
}

function calculateBookingTable($time_booking, $number_people){
	$db = getConnection();
	/*	first condition in inner SELECT tests if user is trying to make reservation in the middle of an already existing one
		second condition in inner SELECT tests if user reservation period will overlap with a later reservation	*/
	$stmt = $db->prepare("SELECT id FROM restaurant_tables 
		WHERE id NOT IN 
			(SELECT id_table 
				FROM bookings 
				WHERE (:time_booking >= time_booking AND :time_booking < DATE_ADD(time_booking, INTERVAL 2 HOUR))
					OR (time_booking >= :time_booking AND time_booking < DATE_ADD(:time_booking, INTERVAL 2 HOUR))			
			)
		AND number_people >= :number_people
		ORDER BY number_people, id ASC
		LIMIT 1");
	$stmt->bindValue(':time_booking', $time_booking);
	$stmt->bindValue(':number_people', $number_people, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->fetchColumn();
}

function setOrderStatus($id, $status){
	$db = getConnection();
	$stmt = $db->prepare("UPDATE orders SET status = :status WHERE id = :id ");
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->bindValue(':status', $status);
	$stmt->execute();
}

function getOrderStatus($status){
	$db = getConnection();
	$stmt = $db->prepare("SELECT * FROM orders WHERE status = :status ORDER BY created ASC");
	$stmt->bindValue(':status', $status);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//calling waiter
function callWaiter($id_table){
	$db = getConnection();
	$stmt = $db->prepare("INSERT INTO waiter_calls(id_table) VALUES(:id_table) ");
	$stmt->bindValue(':id_table', $id_table, PDO::PARAM_INT);
	$stmt->execute();
	return $stmt->rowCount() == 1;
}

function processWaiterCalls(){
	$db = getConnection();
	$stmt = $db->prepare("SELECT * FROM waiter_calls WHERE processed = false ORDER BY created ASC");
	$stmt->execute();
	$calls = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($calls as $call) {
			$stmt = $db->prepare("UPDATE waiter_calls SET processed = true WHERE id = :id");
			$stmt->bindValue(':id', $call["id"], PDO::PARAM_INT);
			$stmt->execute();
	}

	return $calls;
}

// backoffice section
//fetch all bookings if no date is passed as parameter
//if a date is passed then fetch all bookings from this day onward
function getBookings($showBookingsAfterDate = null){
	$db = getConnection();
	$whereStatement = "";
	if(!empty($showBookingsAfterDate)){
		$whereStatement = "WHERE time_booking >= :time_booking";
	}
	$sql = "SELECT * FROM bookings $whereStatement ORDER BY time_booking ASC";
	$stmt = $db->prepare("SELECT * FROM bookings ORDER BY time_booking ASC");
	if(!empty($showBookingsAfterDate)){
		$stmt->bindValue(':time_booking', $showBookingsAfterDate->format('Y-m-d'));
	}
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

//kitchen section
function getKitchenOrders(){
	$db = getConnection();
	$stmt = $db->prepare("SELECT * 
		FROM orders
		WHERE status IN ('prepared', 'ordered')
		ORDER BY orders.created ASC");
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//waiter section