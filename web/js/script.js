
$(document).ready(function () {

	$('.clear-on-focus').each(function() {
    var default_value = this.value;
    $(this).css('color', '#666');
    $(this).focus(function() {
    	if(this.value == default_value) {
      	this.value = '';
      	$(this).css('color', '#333');
      }
    });
    $(this).blur(function() {
    	if(this.value == '') {
      	this.value = default_value;
   			$(this).css('color', '#666');
    	}
    });
	});

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



