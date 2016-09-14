$(function(){
	setInterval(function(){
		$.get("api/getCallWaiter.php")
		  .done(function( data ) {
			if(data != null && data.length > 0){
				for (var i = 0; i < data.length; i++) {
					noty({text: 'Table ' + data[i].id_table + ' has called for a waiter at ' + data[i].created, type: 'success', closeWith: ['click', 'button']});
				};
			}
		 });
	}, 5000);

});