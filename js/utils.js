var apiurl = "https://corridors.vjosset.com/api/";

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

function trackEvent(cat, act, lbl) {
	try {
		if (act == null) {
			act = "[None]";
		}
		if (lbl == null) {
			lbl = "";
		}
		console.log("trackEvent(" + cat + ", " + act + ", " + lbl + ")");
		gtag('event', cat + "." + act, {
			'event_category': cat,
			'event_label': lbl
		});
	} catch (ex) { }
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
