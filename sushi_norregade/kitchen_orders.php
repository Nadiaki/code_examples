<?php
    require_once("header.php");
	require_once("db.php");

	if(!empty($_POST["kitchen_submit"])){
		setOrderStatus($_POST["id_order"], "prepared");
	}

	$orders = getKitchenOrders();
?>

<div id="div-kitchen">

<?php

	foreach($orders as $order){
?>

		<form method="POST" action="kitchen_orders.php">
	    <div class="row selection-wrapper">
	        <div class="small-12 medium-6 columns">
			<?php
			$items = getOrderDetails($order["id"]);
			echo "Table: " . $order["id_table"] . "<br>";
			echo !empty($order["comments"]) ? "Comments: " . $order["comments"] . "<br><br>" : "&nbsp;<br>";

			foreach ($items as $item) {
				echo $item["quantity"]; 
				?>
				&nbsp;
				<?php echo $item["name_dk"]; ?>
				<br>
			<?php
			}


			if($order["status"] == "ordered"){
			?>
				<br>
				<input type="hidden" name="id_order" value="<?php echo $order["id"]; ?>">
				<input type ="submit" class="button" name="kitchen_submit" value="Mark Order as Prepared"></input>
			<?php
			}

			?>
			</div>
		</div>
		</form>
<?php
}
?>
</div>
<?php
    require_once("footer.php");