function sendData() {
alert(1);
var send = id;
			$.ajax({
				url: 'tables/crop.php',
				method: 'POST',
				data: {chose_id: 1},
				success: function(response) {
					alert(response);
				}
			});
}