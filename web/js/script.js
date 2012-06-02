
$(document).ready(function () {

	mixpanel.track("Page loaded");
	
	$("#my_button").click(function() {
    // This sends us an event every time a user clicks the button
    mixpanel.track("Button clicked"); 
	});

});


function hide_welcome() {

	$('#welcome').slideUp();
    mixpanel.track("Hide welcome message"); 

}



