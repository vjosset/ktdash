//Shows a "toast" - Short message/notification that disappears after 3 seconds
function toast(msg) {
    // Get the snackbar DIV
    var x = document.getElementById("toast");
	
	// Set the toast message
	x.innerHTML = msg.replace("\r\n", "<br />");

    // Add the "show" class to DIV
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

//Write the toast div in 1 second
setTimeout(function() {$("body").append('<div id="toast"></div>');}, 1000);

