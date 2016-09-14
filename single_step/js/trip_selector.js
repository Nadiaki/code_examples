$(document).ready(function(){
	$("input[type='checkbox'].tripPrice").on('change', function(){ // every time a checkbox is checked/unchecked then it will change the balue stored in total price.
		// .on is a listenern everythime something changes it notices per say. 
		total_price = calculatePrice();
		setPrice(total_price);
	});
});


function calculatePrice(){
	var total_price = 0; //0 until you check anything.
	// select all inputs of type checkbox, with class trip selector that have property 'checked'
	$("input[type='checkbox'].tripPrice:checked").each(function(){ //each works like an if in php. each time a checkbox is checked
		total_price = parseFloat(total_price) + parseFloat($(this).val()); // total price = total price + the latest checkbox.
		// parseFloat is to turn them into numbers and make it do math on them instead of just adding the numbers together
	});
	return total_price;
}

function setPrice(total_price){
	$("#total_trip_price").html(total_price + "kr"); //finds the total_trip_price span and then changes the value to reflect the total_price.
}

// this works with create.php each checkbox on the page has a value. This Jquery page uses those checkboxes.
// . means class # means id. Like in CSS. div.tripprice means it is a div with the class trip price.
