const prompt = document.getElementById("installmodal");
const installButton = prompt.querySelector('.prompt__install');
const closeButton = prompt.querySelector('.prompt__close');

let installEvent;

function getInstalled() {
	return localStorage.getItem('install-prompt');
}

function setInstalled() {
	localStorage.setItem('install-prompt', true);
}

function clearInstalled() {
	localStorage.removeItem('install-prompt');
}

// This event will only fire if the user does not have the pwa installed
window.addEventListener('beforeinstallprompt', (event) => {
	event.preventDefault();

	// Show the install prompt
	if (getInstalled()) {
		// Already showed the prompt in the past and user declined to install
		// Don't show it again
	} else {
		// Never showed the prompt before, ask the user if they want to install
		$("#installmodal").modal("show");
	}

	// Store the event for later use
	installEvent = event;
});

installButton.addEventListener('click', () => {
	console.log("installbutton_click");
	// hide the prompt banner
    $("#installmodal").modal("hide");

	// trigger the prompt to show to the user
	clearInstalled();
	installEvent.prompt();

	// check what choice the user made
	installEvent.userChoice.then((choice) => {
		// if the user declined, we don't want to show the button again
		// set localStorage to true
		if (choice.outcome !== 'accepted') {
			setInstalled();
		}

		installEvent = null;
	});
});

closeButton.addEventListener('click', () => {
	// set localStorage to true
	setInstalled();

	// hide the prompt banner
	$("#installmodal").modal("hide");

	installEvent = null;
});