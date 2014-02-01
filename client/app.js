$(function() {
	// Socket.IOƒT[ƒo‚ÆÚ‘±
	var socket = io.connect('http://localhost:8888/');
	
	var $input = $('input[type="text"]');
	var $ul    = $('ul');
	
	function addMessage(message) {
		var $li = $('<li>').text(message).appendTo($ul);
	}
	
	$('form').on('submit', function(event) {
		event.preventDefault();
		
		var val = $input.val();
		socket.send(val);
		addMessage(val);
	});
	
	socket.on('message', function(data) {
		addMessage(data);
	});
});