$(function(){
	$(".order-btn").click(function(){
		$(this).attr("disabled", true);
		var orderItems = [];
		var text = "";
		var totalPrice = 0;
		$(".menu-food-item-quantity").each(function(){
			var quantity= $(this).val();
			if(quantity !== "" && quantity !== "0" && quantity != null){
				orderItems.push({
					quantity: quantity,
					price: $(this).data("price"),
					nameen: $(this).data("nameen"),
					namedk: $(this).data("namedk"),
					foodid: $(this).data("foodid")
				});
				
				var en_name = "";
				if ($(this).data("nameen")!="") {
					en_name = " / " + $(this).data("nameen");
				};
				

				text += quantity + " " + $(this).data("namedk") + en_name + "<br>" ;
				totalPrice += parseInt($(this).data("price")) * parseInt(quantity);
				
			}
		});


		if(orderItems.length > 0){
			$.post( "api/createOrder.php", { 'order_items': orderItems, 'table_id': $("#table_id").val(), 'comments': $("#comments").val() })
			  .done(function( data ) {
					noty({text: 'Order created successfully!<br>' + text + 'Total Price: kr. ' + totalPrice + ',-', type: 'success', closeWith: ['click', 'button']});
			 		$(".menu-food-item-quantity").val('');
			 		setTimeout(function(){
			 			$(".order-btn").attr("disabled", false);
			 		}, 5000);
			 });		
		}
	});

	$(".order-btn-all-you-can-eat").click(function(){
		$(this).attr("disabled", true);
		var orderItems = [];
		var text = "";
		$(".menu-food-item-quantity").each(function(){
			var quantity= $(this).val();
			if(quantity !== "" && quantity !== "0" && quantity != null){
				orderItems.push({
					quantity: quantity,
					nameen: $(this).data("nameen"),
					namedk: $(this).data("namedk"),
					foodid: $(this).data("foodid")
				});
				
				var en_name = "";
				if ($(this).data("nameen")!="") {
					en_name = " / " + $(this).data("nameen");
				};
				

				text += quantity + " " + $(this).data("namedk") + en_name + "<br>" ;
			}

		});

		if(orderItems.length > 0){
			$.post( "api/createOrder.php", { 'order_items': orderItems, 'table_id': $("#table_id").val(), 'is_all_you_can_eat': 1, 'comments': $("#comments").val() })
			  .done(function( data ) {
					noty({text: 'Order created successfully!<br>' + text, type: 'success', closeWith: ['click', 'button']});
			 		$(".menu-food-item-quantity").val('');
			 		setTimeout(function(){
			 			$(".order-btn-all-you-can-eat").attr("disabled", false);
			 		}, 5000);
			 });		
		}
	});

	$("#call-waiter").click(function(){
		$.post( "api/createCallWaiter.php", { 'id_table': $(this).data("tableid") })
		  .done(function( data ) {
				noty({text: 'A waiter has been notified and will be with you shortly!', type: 'success', closeWith: ['click', 'button']});
		 		setTimeout(function(){
		 			$(".order-btn").attr("disabled", false);
		 		}, 5000);
		 });	
	});

});