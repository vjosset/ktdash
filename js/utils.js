//Shows a "toast" - Short message/notification that disappears after 3 seconds
function toast(msg) {
    // Get the snackbar DIV
    var x = document.getElementById("toast");
	
	// Set the toast message
	x.innerHTML = msg.replace("\r\n", "<br />");

    // Add the "show" class to DIV
    x.className = "show";
	
	//console.log("Toast: " + msg);

    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}




let apiurl = "https://ktdash.app/api/";

function GetQS(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function GetReqFAid() {
	let factionid = GetQS("factionid");
	if (factionid == "" || factionid == null) {
		factionid = GetQS("faid");
	}
	if (factionid == "" || factionid == null) {
		factionid = GetQS("fa");
	}
	
	return factionid;
}

function GetReqKTid() {
	let killteamid = GetQS("killteamid");
	if (killteamid == "" || killteamid == null) {
		killteamid = GetQS("ktid");
	}
	if (killteamid == "" || killteamid == null) {
		killteamid = GetQS("kt");
	}
	
	return killteamid;
}

function GetReqFTid() {
	let fireteamid = GetQS("fireteamid");
	if (fireteamid == "" || fireteamid == null) {
		fireteamid = GetQS("ftid");
	}
	if (fireteamid == "" || fireteamid == null) {
		fireteamid = GetQS("ft");
	}
	
	return fireteamid;
}

function GetReqOPid() {
	let operativeid = GetQS("operativeid");
	if (operativeid == "" || operativeid == null) {
		operativeid = GetQS("opid");
	}
	if (operativeid == "" || operativeid == null) {
		operativeid = GetQS("op");
	}
	
	return operativeid;
}

function GetArrayRandom(arr) {
	return arr[Math.floor(Math.random() * arr.length)];
}

function te(t = '', a = '', l = '', v1 = '', v2 = '', v3 = '', r = '') {
	try {
		$.ajax({
			type: "POST",
			url: apiurl + "event.php",
			timeout: 5000,
			async: true,
			data: {
				t: t,
				a: a,
				l: l,
				v1: v1,
				v2: v2,
				v3: v3,
				u: window.location.href,
				s: sessionStorage.getItem("sessiontype"),
				r: document.referrer
			},
			
			// Success
			success: function(data) {
				// Do nothing
			},
			
			// Failure
			error: function(error) {
				// Something went wrong
			}
		});
	}
	catch (ex) {
		// Do nothing
		console.log("te(" + t + ", " + a + ", " + l + ", " + v1 + ", " + v2 + ", " + v3 + ") failed: \r\n" + ex);
	}
	
	try {
		gtag('event', t + "." + a, {
			'event_category': t,
			'event_label': a
		});
	} catch (ex) {
		// Do nothing
	}
}

function padzero(num, pad) {
	num = num.toString();
    while (num.length < pad) {
		num = "0" + num;
	}
    return num;
}

function array_move(arr, old_index, new_index) {
    if (new_index >= arr.length) {
        var k = new_index - arr.length + 1;
        while (k--) {
            arr.push(undefined);
        }
    }
    arr.splice(new_index, 0, arr.splice(old_index, 1)[0]);
    return arr; // for testing
};

// Set the session type based on PWA or browser
if (GetQS("source") == "pwa") {
	//console.log("Setting session type to pwa");
	sessionStorage.setItem("sessiontype", "pwa");
} else if (sessionStorage.getItem("sessiontype") != "pwa") {
	//console.log("Setting session type to browser");
	sessionStorage.setItem("sessiontype", "browser");
}

// Track page view
te('page', 'view');