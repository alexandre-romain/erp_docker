// JavaScript Document
// This is an example jQuery snippet that makes the dialogs work
$(document).ready(function() {
	// We have two control functions that show or hide dialogs
	function showDialog(id){
		// Find the dialog and show it
		var dialog = $('#' + id),
				card = dialog.find('.dialog-card');
		dialog.fadeIn();
		// Center it on screen
		card.css({
			'margin-top' : -card.outerHeight()/2
		});
	}
	function hideAllDialogs(){
		// Hide all visible dialogs
		$('.dialog-overlay').fadeOut();
	}
	// Here is how to use these functions
	$('.dialog-confirm-button, .dialog-reject-button').on('click', function () {
		// Hide the dialog when the confirm button is pressed
		hideAllDialogs();
	});
	$('.dialog-overlay').on('click', function (e) {
		if(e.target == this){
			// If the overlay was clicked/touched directly, hide the dialog
			hideAllDialogs();
		}
	});
	$(document).keyup(function(e) {
		if (e.keyCode == 27) {
			// When escape is pressed, hide all dialogs

			hideAllDialogs();
		}
	});
	// Here, we are listening for clicks on the "show dialog" buttons,
	// and showing the correct dialog
	$('.dialog-show-button').on('click', function () {
		// Take the contents of the  "data-show-dialog" attribute
		var toShow = $(this).data('show-dialog');
		showDialog(toShow);
	});
	$('table').delegate('.dialog-show-button', 'click', function () {
		// Take the contents of the  "data-show-dialog" attribute
		var toShow = $(this).data('show-dialog');
		showDialog(toShow);
	});
});