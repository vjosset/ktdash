const APIURL = "/api/";
const APITimeout = 30000;

var app = angular.module("kt", ['ngSanitize'])
	// Controller for main app/pages
	.controller("ktCtrl", function($scope, $rootScope, $http) {
		// GLOBAL
		{
			$scope.loading = false;
			$scope.MODE = "";
			
			setInterval(function() {
				// Set tagged links to show the loader on click
				$(".navloader").on("click", function(){ toast("Loading..."); });
			}, 500);
			
			// Shape/symbol mappings
			$scope.symbolMap = {
				"[CIRCLE]": "",
				"[TRI]": "",
				"[SQUARE]": "",
				"[PENT]": ""
			};
			
			// Settings - All always lowercase (key and value)
			$scope.settings = {
				display: 'card',
				showopseq: 'n',
				startvp: 2,
				startcp: 3,
				applyeqmods: 'n',
				hideappliedeqmods: 'n',
				shownarrative: 'y',
				autoinccp: 'n',
				defaultoporder: 'engage',
				showopid: 'n',
				useoptypeasname: 'n',
				closequarters: 'n',
				opnamefirst: 'y'
			};
			
			$scope.loadSettings = function() {
				let settingsJson = localStorage.getItem("settings");
				if (settingsJson != "" && settingsJson != null) {
					$scope.settings = JSON.parse(settingsJson.toLowerCase());
				} else {
					// No settings yet, fill in defaults
					$scope.setSetting("edition", "", true);
					$scope.setSetting("display", "card", true);
					$scope.setSetting("showopseq", "n", true);
					$scope.setSetting("startvp", "2", true);
					$scope.setSetting("startcp", "3", true);
					$scope.setSetting("applyeqmods", "n", true);
					$scope.setSetting("hideappliedeqmods", "n", true);
					$scope.setSetting("shownarrative", "y", true);
					$scope.setSetting("autoinccp", "n", true);
					$scope.setSetting("defaultoporder", "engage", true);
					$scope.setSetting("showopid", "n", true);
					$scope.setSetting("useoptypeasname", "n", true);
					$scope.setSetting("closequarters", "n", true);
					$scope.setSetting("opnamefirst", "y", true);
				}
				
				// Set default settings
				if (!$scope.settings["edition"]) {
					$scope.setSetting("edition", "", true);
				}
				if (!$scope.settings["display"]) {
					$scope.setSetting("display", "card", true);
				}
				if (!$scope.settings["showopseq"]) {
					$scope.setSetting("showopseq", "n", true);
				}
				if (!$scope.settings["startvp"]) {
					$scope.setSetting("startvp", "2", true);
				}
				if (!$scope.settings["startcp"]) {
					$scope.setSetting("startcp", "3", true);
				}
				if (!$scope.settings["applyeqmods"]) {
					$scope.setSetting("applyeqmods", "n", true);
				}
				if (!$scope.settings["hideappliedeqmods"]) {
					$scope.setSetting("hideappliedeqmods", "n", true);
				}
				if (!$scope.settings["shownarrative"]) {
					$scope.setSetting("shownarrative", "y", true);
				}
				if (!$scope.settings["autoinccp"]) {
					$scope.setSetting("autoinccp", "n", true);
				}
				if (!$scope.settings["defaultoporder"]) {
					$scope.setSetting("defaultoporder", "engage", true);
				}
				if (!$scope.settings["showopid"]) {
					$scope.setSetting("showopid", "n", true);
				}
				if (!$scope.settings["useoptypeasname"]) {
					$scope.setSetting("useoptypeasname", "n", true);
				}
				if (!$scope.settings["closequarters"]) {
					$scope.setSetting("closequarters", "n", true);
				}
				if (!$scope.settings["opnamefirst"]) {
					$scope.setSetting("opnamefirst", "y", true);
				}
				
				$scope.saveSettings(false);
			}
			
			$scope.saveSettings = function(dotoast = false) {
				//console.log("Saving settings: \r\n" + JSON.stringify($scope.settings).toLowerCase());
				let settingsJson = JSON.stringify($scope.settings).toLowerCase();
				localStorage.setItem("settings", settingsJson);
				
				if (dotoast) {
					toast("Settings saved!");
				}
			}
			
			$scope.setSetting = function(key, value, skipte = false) {
				$scope.settings[key] = value;
				if (!skipte) {
					//te('settings', 'set', key, value);
				}
				$scope.saveSettings();
			}
			
			$scope.loadSettings();
			
			// Reference to utils.js "te()"
			$scope.te = function(t = '', a = '', l = '', v1 = '', v2 = '', v3 = '', r = '') {
				te(t, a, l, v1, v2, v3, r);
			}
			
			// initHome()
			// Home page load
			$scope.initHome = function() {
				$scope.MODE = 'Home';
				/*
				if ($scope.currentuser != null) {
					// Get the user's rosters
					$.ajax({
						type: "GET",
						url: APIURL + "roster.php?uid=" + $scope.currentuser.userid,
						timeout: APITimeout,
						async: true,
						dataType: 'json',
						
						// Success
						success: function(data) { // Got user's rosters
							// Load the rosters into "myRosters"
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.myRosters = data;
							
							$scope.loading = false;
							$scope.$apply();
						},
						// Failure
						error: function(data, status, error) { // Failed to get rosters
							toast("Could not get rosters: \r\n" + error);
							$scope.loading = false;
							$scope.$apply();
						}
					});
				}
				*/
				
				// Get a random spolighted roster
				$.ajax({
					type: "GET",
					url: APIURL + "roster.php?randomspotlight=1",
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					
					// Success
					success: function(data) { // Got random spotlighted rosters
						// Load the random spotlighted roster into "myRoster"
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.myRoster = data;
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to get roster
						$scope.$apply();
					}
				});
				
				// Get all killteams
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php?loadkts=1&edition=" + $scope.settings["edition"],
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					
					// Success
					success: function(data) { // Got all killteams
						// Load the results into "factions"
						$scope.factions = data;

						// Sort the factions by edition, then faction, then killteam
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to get roster
						$scope.$apply();
					}
				});
			}
		}
		
		// SESSION & LOG IN
		{
			$scope.currentuser = null;
			$scope.loginForm = { "userName": "", "password": ""};
			
			// initSession_orig()
			// Gets the user's current session (if any).
			// If found, sets $scope.currentuser to the user's info.
			$scope.initSession_orig = function() {
				// Get the current session for this user (session ID stored in cookie)
				// Start at each page load
				
				let preload = document.body.getAttribute("currentuser");
				if (preload) {
					// Already pre-loaded this user, use that instead of a round-trip to the API
					//console.log("Got pre-loaded user: " + preload);
					$scope.currentuser = JSON.parse($scope.replacePlaceholders(preload));
					$scope.loading = false;
				}
				else 
				{
					// Get the current user's session and set $scope.currentuser
					//console.log("No pre-loaded user");
					$.ajax({
						type: "GET",
						url: APIURL + "session.php",
						timeout: APITimeout,
						// This call is NOT async so we can use this method to redirect the user for pages that require a session
						async: false,
						dataType: 'json',
						
						// Success
						success: function(data) {
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							//console.log("Setting currentuser to " + JSON.stringify(data));
							$scope.currentuser = data;
						},
						
						// Failure
						error: function() {
							//console.log("Setting currentuser to null");
							$scope.currentuser = null;
						}
					});
				}
			}
			
			// initSession()
			// Gets the user's current session (if any).
			// If found, sets $scope.currentuser to the user's info.
			$scope.initSession = function() {
				// Get the current session for this user (session ID stored in cookie)
				// Start at each page load
				//console.log("initSession()");
				
				let preload = document.body.getAttribute("currentuser");
				if (preload) {
					// Already pre-loaded this user, use that instead of a round-trip to the API
					$scope.currentuser = JSON.parse($scope.replacePlaceholders(preload));
					$scope.loading = false;
				}
				else 
				{
					// Get the current user's session and set $scope.currentuser
					$http.get(APIURL + "session.php")
					.then(function(response)
						{
							if (response.status != "200" || !response.data) {
								// There was an error
								//console.log("Setting currentuser to null");
								$scope.currentuser = null;
							} else {
								// No error
								//console.log("Got response: " + JSON.stringify(response));
								//console.log("Got data: " + JSON.stringify(response.data));
								data = JSON.parse($scope.replacePlaceholders(JSON.stringify(response.data)));
								//console.log("Setting currentuser to " + JSON.stringify(data));
								$scope.currentuser = data;
							}
						}
					).catch(function(data) {
						// There was an error
						//console.log("initSession() error - Setting currentuser to null: \r\n" + data);
						$scope.currentuser = null;
					});
				}
			}
			
			// initLogin()
			// Initializes the login form, redirecting the user to "My Rosterss" if they're already logged in.
			// Redirects the user to the page in QueryString "ru" if logged in successfully.
			$scope.initLogin = function() {
				// Check if user is already logged in
				if ($scope.currentuser != null) {
					// Already logged in - Send user to "My Rosters"
					window.location.href = "/u";
				}
				
				$scope.loading = false;
				var ru = GetQS("ru");
				if (ru == "" || ru == null) {
					// No redirect URL defined, use default
					ru = "/u";
				}
				$scope.loginForm.redirectUrl = ru;
			}
			
			// logIn()
			// Logs the user in, using the $scope.loginForm object's properties
			$scope.logIn = function() {
				//Show the "Logging In" waiter
				$scope.loading = true;
				
				// Hide the previous error message
				$scope.loginForm.error = null;
				
				$.ajax({
					type: "POST",
					url: APIURL + "session.php",
					data: { username: $scope.loginForm.userName, password: $scope.loginForm.password },
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					// Success
					success: function(data) { // Logged in successfully
						// Hide the waiter
						$scope.loading = false;
						
						// Set the current user
						$scope.currentuser = data;
						
						// Send the user to the redirect url
						if ($scope.loginForm.redirectUrl == null || $scope.loginForm.redirectUrl == "") {
							// No redirect specified - Send user to "My Rosters"
							$scope.loginForm.redirectUrl = "/u";
						}
						//te("session", "login");
						window.location.href = $scope.loginForm.redirectUrl;
					},
					// Failure
					error: function(data, status, error) { // Failed to log in
						// Hide the waiter
						$scope.loading = false;
						
						// Reset the current user
						$scope.currentuser = null;
						
						// Show the log in error
						$scope.loginForm.error = error;
						$scope.$apply();
					}
				});
			}
			
			// logIn2()
			// Logs the user in, using the $scope.loginForm object's properties
			$scope.logIn2 = function() {
				//Show the "Logging In" waiter
				$scope.loading = true;
				
				// Hide the previous error message
				$scope.loginForm.error = null;
				
				$http.post(
					APIURL + "session.php",
					JSON.stringify({ username: $scope.loginForm.userName, password: $scope.loginForm.password })
				).catch(error => {
					// Log in failed
					// Hide the waiter
					$scope.loading = false;
					
					// Reset the current user
					$scope.currentuser = null;
					
					// Show the log in error
					$scope.loginForm.error = error.statusText;
				})
				.then(function(response) {
					// Log in successful
					// Hide the waiter
					$scope.loading = false;
					
					// Set the current user
					$scope.currentuser = response.data;
					
					// Send the user to the redirect url
					if ($scope.loginForm.redirectUrl == null || $scope.loginForm.redirectUrl == "") {
						// No redirect specified - Send user to "My Rosters"
						$scope.loginForm.redirectUrl = "/u";
					}
					//te("session", "login");
					window.location.href = $scope.loginForm.redirectUrl;
				});
			}
			
			// logOut()
			// Logs the user out by deleting their session and its cookie, then sends the user to the home page.
			$scope.logOut = function() {
				//Log the user out
				$.ajax({
					type: "DELETE",
					url: APIURL + "session.php",
					timeout: 500,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Logged out, redirect to home
						//te("session", "logout");
						window.location.href = "/";
					},
					error: function(data, status, error) {
						// Do nothing I guess?
					}
				});
			}
		}
		
		// SIGN UP
		{
			// The "Sign Up" form object
			$scope.signUpForm = {};
			
			// initSignUp()
			// Initializes the "Sign Up" form and redirects to My Rosters if user is already logged in.
			$scope.initSignUp = function() {
				// Check if user is already logged in
				if ($scope.currentuser != null) {
					// Already logged in - Send user to "My Rosters"
					window.location.href = "/u";
				}
			};
			
			// signUp()
			// Signs the user up by creating a new user record, signing them in, and sending them to the "My Rosters" page.
			$scope.signUp = function() {
				$scope.signUpForm.error = null;
				
				$.ajax({
					type: "POST",
					url: APIURL + "user.php",
					data: {
						username: $scope.signUpForm.userName,
						password: $scope.signUpForm.password,
						confirmpassword: $scope.signUpForm.confirmPassword
					},
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					success: function(data) { // Success
						// User is now logged in
						$scope.loading = false;
						
						// Set their session
						$scope.currentuser = data;
						te("session", "signup");
						
						// Load a default roster for this user to get them started
						$.ajax({
							type: "POST",
							url: APIURL + "roster.php?rid=PB-INTS&clone=1&rostername=Sample Team: Intercessors",
							timeout: APITimeout,
							async: true,
							
							// Success
							success: function(data) { // Saved
								// Send the user to "My Rosters"
								window.location.href = "/u";
							},
							// Failure
							error: function(data, status, error) { // Failed to import sample roster
								// Still send the user to "My Rosters"
								window.location.href = "/u";
							}
						});
					},
					error: function(data, status, error) { // Error
						$scope.currentuser = null;
						$scope.signUpForm.error = error;
						$scope.loading = false;
						$scope.$apply();
					}
				});
			};
		}
		
		// ROSTERS
		{
			$scope.initImportV1Team = function() {
				$scope.loading = true;
				
				// Check that the user is logged in
				if ($scope.currentuser == null) {
					// Not logged in - Send user to "Log In"
					$scope.loading = false;
					toast("Not logged in!");
					window.location.href = "/login.htm";
				} else {
					// Parse the input
					let importstring = GetQS("t");
					if (importstring == null || importstring == "") {
						toast("No team to import");
					} else {
						let data = importstring.split("|");
					
						let roster = {
							"userid": $scope.currentuser.userid,
							"rostername": data[0],
							"factionid": data[1],
							"killteamid": data[2],
							"operatives": []
						};
						
						// Send the request to the API
						$.ajax({
							type: "POST",
							url: APIURL + "roster.php",
							timeout: APITimeout,
							async: false,
							dataType: 'json',
							data: JSON.stringify(roster),
							success: function(data) {
								roster = data;
							},
							error: function(error) {
								// Failed to save roster
								toast("Could not import team " + team.teamname + ": \r\n" + error);
							}
						});
						
						
						// We should now have a roster ID, use it to import the operatives for this roster
						for (let j = 3; j < data.length; j++) {
							let opdata = data[j].split("/");
							
							let op = {
								"userid": $scope.currentuser.userid,
								"rosterid": roster.rosterid,
								"factionid": roster.factionid,
								"killteamid": roster.killteamid,
								"fireteamid": opdata[0],
								"seq": (j - 3), // Make sure they stay in order
								"opid": opdata[1],
								"opname": opdata[2],
								"wepids": opdata[3]
							};
							
							// Send the request to the API
							$.ajax({
								type: "POST",
								url: APIURL + "rosteroperative.php",
								timeout: APITimeout,
								async: false,
								dataType: 'json',
								data: JSON.stringify(op),
								success: function(data) {
									op = data;
								},
								error: function(error) {
									// Failed to save roster
									toast("Could not import operative " + op.opname + ": \r\n" + error);
								}
							});
						}
						
						// All done, send the user to their new roster
						$scope.importedroster = roster;
					}
				}
				
				$scope.loading = false;
			}
			
			// applyEqMods()
			// Applies equipment mods to the operatives in the specified roster
			$scope.applyEqMods = function (roster) {
				if (roster != null && $scope.settings.applyeqmods == 'y') {
					for (let opnum = 0; opnum < roster.operatives.length; opnum++) {
						let op = roster.operatives[opnum];
						$scope.resetOperativeToBase(op);
						
						// Operative is reset, along with its weapons
						// Now apply equipment mods to the operative and its weapons
						//console.log("   Applying Equipment Mods");
						for (eqnum = 0; eqnum < op.equipments.length; eqnum++) {
							let eq = op.equipments[eqnum];
							//console.log("      Eq #" + eqnum + ": " + eq.eqname + " (" + eq.eqtype + ", '" + eq.eqvar1 + "', '" + eq.eqvar2 + "', '" + eq.eqvar3 + "', '" + eq.eqvar4 + "')");
							
							if (eq.eqtype.toLowerCase().includes("ability")) {
								let ab = {
									title: eq.eqname,
									description: eq.eqdescription
								};
								op.abilities.push(ab);
								eq.autoapplied = true;
							}
							
							if (eq.eqtype.toLowerCase().includes("action")) {
								// Parse the AP cost of this unique action
								let ap = 1;
								if (eq.eqdescription.includes("0 AP")) {
									ap = 0;
								}
								if (eq.eqdescription.includes("1 AP")) {
									ap = 1;
								}
								if (eq.eqdescription.includes("2 AP")) {
									ap = 2;
								}
								let ua = {
									title: eq.eqname,
									description: eq.eqdescription,
									AP: ap
								};
								op.uniqueactions.push(ua);
								eq.autoapplied = true;
							}
							
							if (eq.eqtype.toLowerCase().includes("wepmod")) {
								let wepstomod = [];
								if (eq.eqvar1.startsWith("weptype:")) {
									// Mod applies to a specific weapon type
									let weptype = eq.eqvar1.replace("weptype:", "");
									//console.log("            Matching weptype " + weptype);
									
									// Find the weapon that has this type that this operative is equipped with
									for (let opwepnum = 0; opwepnum < op.weapons.length; opwepnum++) {
										let opwep = op.weapons[opwepnum];
										if (opwep.weptype == weptype) {
											// This is the one
											wepstomod.push(opwep);
										}
									}
								} else if (eq.eqvar1.startsWith("wepid:")) {
									// Mod applies to a specific weapon id
									let wepid = eq.eqvar1.replace("wepid:", "");
									//console.log("            Matching wepid " + wepid);
									
									// Find the weapon that has this ID that this operative is equipped with
									for (let opwepnum = 0; opwepnum < op.weapons.length; opwepnum++) {
										let opwep = op.weapons[opwepnum];
										if (("," + wepid + ",").includes("," + opwep.wepid + ",")) {
											// This is the one
											wepstomod.push(opwep);
										}
									}
								} else if (eq.eqvar1.startsWith("wepname:")) {
									// Mod applies to a specific weapon name
									let wepname = eq.eqvar1.replace("wepname:", "");
									//console.log("            Matching wepname " + wepname);
									
									// Find the weapons that has this name that this operative is equipped with
									for (let opwepnum = 0; opwepnum < op.weapons.length; opwepnum++) {
										let opwep = op.weapons[opwepnum];
										//console.log("Checking weapon name " + wepname.toLowerCase() + " against " + opwep.wepname.toLowerCase());
										if (opwep.wepname.toLowerCase().includes(wepname.toLowerCase())) {
											// This is the one
											wepstomod.push(opwep);
										}
									}
								}
								
								if (wepstomod.length > 0) {
									// We found the weapons to modify, now apply the mod to those weapons
									for (let weptomodnum = 0; weptomodnum < wepstomod.length; weptomodnum++) {
										let weptomod = wepstomod[weptomodnum];
										eq.autoapplied = true;
										let mods = eq.eqvar2.split("|");
										for (let modnum = 0; modnum < mods.length; modnum++) {
											let mod = mods[modnum];
											let modstat = mod.split(":")[0];
											let modval = mod.split(":")[1];
											switch(modstat) {
												case "A":
													// Udpate Attacks
													for (let pnum = 0; pnum < weptomod.profiles.length; pnum++) {
														//console.log("         Applying Special Rule " + modval);
														weptomod.profiles[pnum].A = parseInt(weptomod.profiles[pnum].A) + parseInt(modval);
													}
													break;
												case "SR":
													// New special rule - Loop through the weapon's profiles and add this special rule to them
													for (let pnum = 0; pnum < weptomod.profiles.length; pnum++) {
														//console.log("         Applying Special Rule " + modval);
														if (weptomod.profiles[pnum].SR != '') {
															weptomod.profiles[pnum].SR += ", "
														}
														weptomod.profiles[pnum].SR += modval;
													}
													break;
												case "D":
													// Upgrade damage - Loop through the weapon's profiles and update their damage
													for (let pnum = 0; pnum < weptomod.profiles.length; pnum++) {
														//console.log("         Applying Damage mod " + modval);
														let origD = weptomod.profiles[pnum].D;
														let orignormalD = parseInt(origD.split("/")[0]);
														let origcriticalD = parseInt(origD.split("/")[1]);
														
														let modnormalD = parseInt(modval.split("/")[0]);
														let modcriticalD = parseInt(modval.split("/")[1]);
														
														let newD = (orignormalD + modnormalD) + "/" + (origcriticalD + modcriticalD);
														
														weptomod.profiles[pnum].D = newD;
													}
													break;
												case "BS":
													// Upgrade BS - Loop through the weapon's profiles and upgrade their BS
													for (let pnum = 0; pnum < weptomod.profiles.length; pnum++) {
														//console.log("         Applying BS mod " + modval);
														let origBS = weptomod.profiles[pnum].BS;
														if (modval.startsWith("-")) {
															// Improve (reduce) BS for this weapon
															let newBS = (parseInt(origBS.replace("+", "")) - parseInt(modval.replace("-", ""))) + "+";
															weptomod.profiles[pnum].BS = newBS;
														} else if (modval.startsWith("+")) {
															// Impair (increase) BS for this weapon
															let newBS = (parseInt(origBS.replace("+", "")) + parseInt(modval.replace("+", ""))) + "+";
															weptomod.profiles[pnum].BS = newBS;
														} else {
															// Replace BS for this weapon
															weptomod.profiles[pnum].BS = modval;
														}
													}
												default:
													break;
											}
										}
									}
								}
							}
							
							if (eq.eqtype.toLowerCase().includes("opmod")) {
								// Pick the characteristic to mod
								//console.log("OpMod");
								switch (eq.eqvar1) {
									case "M":
										//console.log("            M - var2: " + eq.eqvar2);
										if (eq.eqvar2.startsWith("+")) {
											//console.log("         Adding " + eq.eqvar2 + " to M (" + op.M + ")");
											op.M += eq.eqvar2;
											eq.autoapplied = true;
											//console.log("op.M: " + op.M);
										}
										else if (eq.eqvar2 == "-" + $scope.PlaceHolders["[CIRCLE]"]) {
											//console.log("-[CIRCLE]");
											//console.log("Old M: " + op.M);
											op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"] + "*"); // Can't go below 2 [CIRCLE]
											op.M = op.M.replace("3" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"]);
											op.M = op.M.replace("4" + $scope.PlaceHolders["[CIRCLE]"], "3" + $scope.PlaceHolders["[CIRCLE]"]);
											op.M = op.M.replace("5" + $scope.PlaceHolders["[CIRCLE]"], "4" + $scope.PlaceHolders["[CIRCLE]"]);
											eq.autoapplied = true;
											//console.log("New M: " + op.M);
										}
										break;
									case "W":
										//console.log("            W");
										if (eq.eqvar2.startsWith("+")) {
											//console.log("         Adding " + eq.eqvar2 + " to W");
											if (op.curW == parseInt(op.W)) {
												// Also increase current Wounds
												op.curW += parseInt(eq.eqvar2)
											}
											op.W = parseInt(op.W) + parseInt(eq.eqvar2);
											eq.autoapplied = true;
										}
										//console.log("New W: " + op.W);
										break;
									case "APL":
										break;
									case "SV":
										//console.log("            SV");
										if (eq.eqvar2 != "") {
											if (eq.eqvar2.startsWith("+") || eq.eqvar2.startsWith("-")) {
												//console.log("         Adding " + eq.eqvar2 + " to W");
												let SV = parseInt(op.SV.replace("+", ""));
												op.SV = SV + parseInt(eq.eqvar2) + "+";
											}
											else {
												//console.log("         Setting " + eq.eqvar1 + " to " + eq.eqvar2);
												op.SV = eq.eqvar2;
											}
											eq.autoapplied = true;
										}
										break;
									case "DF":
										break;
									case "GA":
										break;
								}
							}
						}
					}
				}
				
				// Close quarters special rules
				if ($scope.settings["closequarters"] == "y") {
					console.log("CloseQuarters");
					// Add the Lethal 5+ to Blast X, Splash X and/or Torrent X
					if (roster != null) {
						for (let opnum = 0; opnum < roster.operatives.length; opnum++) {
							let op = roster.operatives[opnum];
							
							// Do weapons first
							for (let wepnum = 0; wepnum < op.weapons.length; wepnum++) {
								let wep = op.weapons[wepnum];
								for (let pronum = 0; pronum < wep.profiles.length; pronum++) {
									let SR = wep.profiles[pronum].SR.toLowerCase();
									if (SR.indexOf("lethal") < 0  && (SR.indexOf("tor") > -1 || SR.indexOf("splash") > -1 || SR.indexOf("blast") > -1)) {
										wep.profiles[pronum].SR += ", Lethal 5+ (CQ)";
									}
								}
							}
							
							// Now do equipments
							for (let eqnum = 0; eqnum < op.equipments.length; eqnum++) {
								let eq = op.equipments[eqnum];
								if (eq.weapon) {
									let wep = eq.weapon;
									for (let pronum = 0; pronum < wep.profiles.length; pronum++) {
										let SR = wep.profiles[pronum].SR.toLowerCase();
										if (SR.indexOf("lethal") < 0  && (SR.indexOf("tor") > -1 || SR.indexOf("splash") > -1 || SR.indexOf("blast") > -1)) {
											wep.profiles[pronum].SR += ", Lethal 5+ (CQ)";
										}
									}
								}
							}
						}
					}
				}
			}
			
			// importV1Teams()
			// Auto-import from localStorage at "My Rosters" load
			//	NOT the same as the importer for the beta; this will be used when we go live
			$scope.importV1Teams = function() {
				// Check if the logged-in user has some teams that were not imported from v1 (localStorage)
				let oldTeamsJson = window.localStorage.getItem("myteams");
				if (oldTeamsJson != null && oldTeamsJson != "") {
					// At least one team to try to convert
					let oldTeams = JSON.parse(oldTeamsJson);
					let msg = "We found the following teams to import into v2:\r\n";
					for (let i = 0; i < oldTeams.length; i++) {
						msg += oldTeams[i].teamname + "\r\n";
					}
					
					toast("Importing teams from v1...");
					$scope.loading = true;
					
					//console.log(msg);
					
					// Prepare and send the request for each team from localStorage
					for (let i = 0; i < oldTeams.length; i++) {
						let team = oldTeams[i];
						
						toast("Importing team #" + (i + 1) + "/" + oldTeams.length + ": " + team.teamname + "...");
						
						// Create a new roster for the specified faction and killteam
						let roster = {
							"userid": $scope.currentuser.userid,
							"factionid": team.factionid,
							"killteamid": team.killteamid,
							"rostername": team.teamname
						};
						
						// Send the request to the API
						$.ajax({
							type: "POST",
							url: APIURL + "roster.php",
							timeout: APITimeout,
							async: false,
							dataType: 'json',
							data: JSON.stringify(roster),
							success: function(data) {
								roster = data;
							},
							error: function(error) {
								// Failed to save roster
								toast("Could not import team " + team.teamname + ": \r\n" + error);
							}
						});
						
						// We should now have a roster ID, use it to import the operatives for this roster
						for (let j = 0; j < team.operatives.length; j++) {
							let oldOp = team.operatives[j];
							
							// Create a new roster for the specified faction and killteam
							let op = {
								"userid": $scope.currentuser.userid,
								"rosterid": roster.rosterid,
								"factionid": oldOp.factionid,
								"killteamid": oldOp.killteamid,
								"fireteamid": oldOp.fireteamid,
								"opid": oldOp.opid,
								"opname": oldOp.opname,
								"wepids": oldOp.wepids
							};
							
							// Send the request to the API
							$.ajax({
								type: "POST",
								url: APIURL + "rosteroperative.php",
								timeout: APITimeout,
								async: false,
								dataType: 'json',
								data: JSON.stringify(op),
								success: function(data) {
									op = data;
								},
								error: function(error) {
									// Failed to save roster
									toast("Could not import operative " + oldOp.opname + ": \r\n" + error);
								}
							});
						}
					}
					
					// Now delete these teams since they've been imported/converted
					localStorage.removeItem("myteams");
						
					// Team finished importing
					toast("All v1 teams have been imported");
					
					//te("roster", "importv1");
					
					// All done, reload the page so the user can see their newly-imported teams
					$scope.loading = false;
					toast("Loading...");
					window.location.reload();
				}
			}
			
			// initRosters()
			// Initializes the "My Rosters" page
			$scope.initRosters = function(uid) {
				//te("rosters", "view", "", uid);
				$scope.loading = true;
				
				if ($scope.MODE == "MyRosters") {
					$scope.importV1Teams();
				}
				
				// Check if user is already logged in
				if ((uid == null || uid == "") && $scope.currentuser == null) {
					// Not logged in - Send user to "Log In"
					$scope.loading = false;
					toast("Not logged in!");
					window.location.href = "/login.htm";
				} else {
					// User is logged in or a specified user's rosters were requested
					if (uid == "" || uid == null) {
						// No user id specified, use the current logged-in user
						uid = $scope.currentuser.userid;
					}
				
					let isMe = ($scope.currentuser != null && uid == $scope.currentuser.userid);
					//console.log("isMe: " + isMe);
					//console.log("uid: " + uid);
					
					if (isMe) {
						$scope.MODE = "MyRosters";
					} else {
						$scope.MODE = "Rosters";
					}
					
					let preload = document.body.getAttribute("myRosters");
					if (preload) {
						// Already pre-loaded these rosters, use that instead of a round-trip to the API
						$scope.myRosters = JSON.parse($scope.replacePlaceholders(preload));
					
						// Now clear the preload so we show updated information everytime a change is made
						document.body.setAttribute("myRosters", "");
						
						$scope.loading = false;
					}
					else {
						// Get the user's rosters
						$http.get(APIURL + "roster.php?uid=" + uid)
						.then(function(response)
							{
								let data = response.data;
								// Got user's rosters
								// Load the rosters into "myRosters"
								data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
								$scope.myRosters = data;
								
								$scope.loading = false;
							}
						).catch(function(data)
						{
							// Failure
							console.log("Failed to get rosters: \r\n" + data);
							console.log(JSON.stringify(data));
							toast("Could not get rosters: \r\n" + error);
							$scope.loading = false;
						});
					}
				}
			}
			
			// initRosterGallery()
			// Initializes the "Roster Gallery" page - Landing page for a single roster			
			$scope.initRosterGallery = function(rid) {
				let temprid = "";
				if (!rid) {
					// No roster id provided, try to pull the roster's JSON from the html (will be an attribute on body)
					var data = document.body.getAttribute("myRoster");
					temprid = (JSON.parse(data)).rosterid;
				}
				if (temprid != "") {
					//te("roster", "gallery", "", temprid);
				} else {
					//te("roster", "gallery", "", rid);
				}
				$scope.initRoster(rid, true);
			}

			$scope.initPrintRoster = function(roster) {
				console.log("initPrintRoster(" + roster.rosterid + ")");
				$scope.myRoster = roster;
				
				// Show the modal
				console.log("Showing modal...");
				$('#rosterprintmodal').modal("show");
			}
			
			$scope.printroster = function(roster, format) {
				//te("roster", "print", "roster", roster.rosterid);

				let printploys = document.getElementById('chkprintploys').checked ? "1" : "0";

				switch(format) {
					case 'PV':
					case 'PH':
					case 'BV':
					case 'BH':
					case 'TH':
					case 'TV':
						window.open("/api/pdfrender.php?scope=rostercards&cardsize=" + format + "&printploys=" + printploys + "&rid=" + roster.rosterid);
						break;
					case 'plainbig':
						window.open("/api/pdfrender.php?scope=roster&cols=1&printploys=" + printploys + "&rid=" + roster.rosterid);
						break;
					case 'plain':
					case null:
					case '':
						window.open("/api/pdfrender.php?scope=roster&cols=2&printploys=" + printploys + "&rid=" + roster.rosterid);
						break;
				}
			}
			
			$scope.initRosterForPrint = function(rid, skipte, s) {
				// We're viewing this roster for printing/PDF render, pre-load the settings for the PDF renderer
				//	TODO: Pull these from the URL; user will pass their current settings to the renderer
				$scope.setSetting("edition", "", true);
				$scope.setSetting("display", "card", true);
				$scope.setSetting("showopseq", "n", true);
				$scope.setSetting("startvp", "2", true);
				$scope.setSetting("startcp", "3", true);
				$scope.setSetting("applyeqmods", "y", true);
				$scope.setSetting("hideappliedeqmods", "y", true);
				$scope.setSetting("shownarrative", "n", true);
				$scope.setSetting("autoinccp", "n", true);
				$scope.setSetting("defaultoporder", "engage", true);
				$scope.setSetting("showopid", "n", true);
				$scope.setSetting("useoptypeasname", "n", true);
				$scope.setSetting("closequarters", "n", true);
				$scope.setSetting("opnamefirst", "y", true);

				// Now we can initRoster
				$scope.initRoster(rid, skipte, s);

				// Now summarize long abilities and unique actions
				$scope.myRoster.longabilities = [];
				$scope.myRoster.longuniqueactions = [];

				for (let opnum = 0; opnum < $scope.myRoster.operatives.length; opnum++) {
					let op = $scope.myRoster.operatives[opnum];
					for (let abnum = 0; abnum < op.abilities.length; abnum++) {
						let ab = op.abilities[abnum];
						if (ab.description.length > 550) {
							// Check if we already logged this ability in longabilities
							let alreadylogged = false;
							for (let longabnum = 0; longabnum < $scope.myRoster.longabilities.length; longabnum++) {
								let longab = $scope.myRoster.longabilities[longabnum];
								if (longab.description == ab.description) {
									// Already logged, nothing to do here
									alreadylogged = true;
								}
							}

							if (!alreadylogged) {
								$scope.myRoster.longabilities.push(JSON.parse(JSON.stringify(ab)));
							}

							// Truncate this ability on the operative itself
							ab.description = '<em>(See Below)</em>';
						}
					}
				}
				
				for (let opnum = 0; opnum < $scope.myRoster.operatives.length; opnum++) {
					let op = $scope.myRoster.operatives[opnum];
					for (let uanum = 0; uanum < op.uniqueactions.length; uanum++) {
						let ua = op.uniqueactions[uanum];
						if (ua.description.length > 550) {
							// Check if we already logged this ability in longuniqueactions
							let alreadylogged = false;
							for (let longuanum = 0; longuanum < $scope.myRoster.longuniqueactions.length; longuanum++) {
								let longua = $scope.myRoster.longuniqueactions[longua];
								if (longua.description == ua.description) {
									// Already logged, nothing to do here
									alreadylogged = true;
								}
							}

							if (!alreadylogged) {
								$scope.myRoster.longuniqueactions.push(JSON.parse(JSON.stringify(ua)));
							}

							// Truncate this uniqueaction on the operative itself
							ua.description = '<em>(See Below)</em>';
						}
					}
				}

				$scope.MODE = 'Print';
			}

			// initRoster()
			// Initializes the "My Roster" page - Landing page for a single roster
			$scope.initRoster = function(rid, skipte, s) {
				if (!skipte) {
					//te("roster", "view", "", rid);
				}
				$scope.loading = true;
				$scope.MODE = "Roster";
				
				let preload = document.body.getAttribute("myRoster");
				if (preload && preload != "") {
					// Already pre-loaded this roster, use that instead of a round-trip to the API
					$scope.myRoster = JSON.parse($scope.replacePlaceholders(preload));
					
					// Auto-apply equipment mods
					$scope.applyEqMods($scope.myRoster);
				
					if ($scope.currentuser != null && $scope.myRoster.userid == $scope.currentuser.userid) {
						// Logged-in user has the same ID as the requested roster, this is one of their rosters
						$scope.MODE = "MyRoster";
					} else {
						// User is not logged in or requested roster belongs to someone else
						$scope.MODE = "Roster";
					}
					
					// Now clear the preload so we don't show operatives more than once when edited
					document.body.setAttribute("myRoster", "");
					
					$scope.loading = false;
				}
				else {
					// RosterID passed in - Pull it from the API
					$http.get(APIURL + "roster.php?rid=" + rid)
					.then(function(response)
						{
							// Load the roster into "myRoster"
							let data = response.data;
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.myRoster = data;
					
							if ($scope.currentuser != null && $scope.myRoster.userid == $scope.currentuser.userid) {
								// Logged-in user has the same ID as the requested roster, this is one of their rosters
								$scope.MODE = "MyRoster";
							} else {
								// User is not logged in or requested roster belongs to someone else
								$scope.MODE = "Roster";
							}
							
							// Get the roster's killteam and fireteam info
							if (!$scope.myRoster.killteam || $scope.myRoster.killteam == null) {
								// Not yet loaded - Get it
								$.ajax({
									type: "GET",
									url: APIURL + "killteam.php?fa=" + $scope.myRoster.factionid + "&kt=" + $scope.myRoster.killteamid,
									timeout: APITimeout,
									async: false,
									dataType: 'json',
									success: function(data) {
										// Got it
										$scope.myRoster.killteam = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
										
										// Apply eq mods
										$scope.applyEqMods($scope.myRoster);
									},
									error: function(error) {
										// Failed to save roster
										toast("Could not get killteam: " + error);
									}
								});
							}
							
							$scope.loading = false;
							
							if (s) {
								setTimeout(s, 200);
							}
						}
					).catch(function(data) 
						{
						// Failure
						toast("Could not get roster: \r\n" + data);
						$scope.loading = false;
					});
				}
			}
			
			// showrosterkillteaminfo()
			// Pops-up the killteam info for the specified roster
			$scope.showrosterkillteaminfo = function(roster) {
				// Get all info for this roster's killteam
				$.ajax({
					type: "GET",
					url: APIURL + "killteam.php?fa=" + roster.factionid + "&kt=" + roster.killteamid,
					timeout: APITimeout,
					async: true,
					
					// Success
					success: function(data) { // Got info
						// All good - Replace distance placeholders and assign to the roster
						roster.killteam = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not get killteam info for this roster: \r\n" + error);
					}
				});
				
				// Show the modal
				$('#rosterkillteaminfomodal').modal("show");
			}
			
			// initDeleteRoster()
			// Pops-up the roster deletion modal
			$scope.initDeleteRoster = function(roster) {
				$scope.deleteRoster = roster;
				
				// Show the modal
				$('#deleterostermodal').modal("show");
			}
			
			// saveDeleteRoster()
			// Commits the roster deletion
			$scope.saveDeleteRoster = function() {
				//te("roster", "delete", "", $scope.deleteRoster.rosterid);
				toast("Deleting Roster \"" + $scope.deleteRoster.rostername + "\"...");
				// Send the delete request to the API
				$.ajax({
					type: "DELETE",
					url: APIURL + "roster.php?rid=" + $scope.deleteRoster.rosterid,
					timeout: APITimeout,
					async: true,
					
					// Success
					success: function(data) { // Saved this operative
						// All good
						
						// Close the modal
						$('#deleterostermodal').modal("hide");
						
						// Let the user know
						toast("Roster \"" + $scope.deleteRoster.rostername + "\" deleted");
						
						// Remove this roster from the scope	
						if ($scope.myRosters) {						
							let idx = $scope.myRosters.indexOf($scope.deleteRoster);
							if (idx > -1) {
								$scope.myRosters.splice(idx, 1);
							}
						
							// Update roster list
							$scope.initRosters();
						} else {
							// We're not on the "My Rosters" page, so send them there
							window.location.href = "/u";
						}
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not delete this roster: \r\n" + error);
				
						// Close the modal
						$('#deleterostermodal').modal("hide");
					}
				});
			}
		
			// initNewRoster()
			// Pops-up the new roster modal
			$scope.initNewRoster = function() {
				// Load the factions and killteams
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php?loadkts=1&edition=" + $scope.settings["edition"],
					timeout: APITimeout,
					async: false,
					dataType: 'json',
					success: function(data) {
						// Got factions
						$scope.factions = data;
					},
					error: function(error) {
						// Failed to get factions
						toast("Could not get factions: " + error);
					}
				});
				
				// Ready to initialize the new roster popup
				$scope.newroster = {
					"factionid": "",
					"killteamid": "",
					"rostername": "",
					"faction": null,
					"killteam": null,
					"portraitcopyok": 0,
					"keyword": ""
				};
				
				// Show the modal
				$('#newrostermodal').modal("show");
			}
			
			// createRoster()
			// Saves a new roster
			$scope.createRoster = function() {
				// Validate the input
				if ($scope.newroster.killteam == null) {
					// No killteam selected
					toast("Please select a KillTeam");
					return;
				}
				if ($scope.newroster.rostername.trim() == "") {
					// No roster name specified
					toast("Please enter a roster name");
					return;
				}
				
				// Create a new roster for the specified faction and killteam
				var roster = {
					"userid": $scope.currentuser.userid,
					"factionid": $scope.newroster.faction.factionid,
					"killteamid": $scope.newroster.killteam.killteamid,
					"rostername": $scope.newroster.rostername,
					"CP": $scope.settings["startcp"],
					"VP": $scope.settings["startvp"]
				};
				
				// Send the request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "roster.php?pushdown=1",
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					data: JSON.stringify(roster),
					success: function(data) {
						toast("Roster " + roster.rostername + " saved!");
						
						//te("roster", "create", "", data.rosterid);
						
						// Send the user to their new roster
						window.location.href = "/r/" + data.rosterid;
					},
					error: function(error) {
						// Failed to save roster
						toast("Could not save roster: \r\n" + error);
					}
				});
				
				// Close the modal
				$('#newrostermodal').modal("hide");
			};
		
			// moveRosterUp()
			// Moves the specified roster up in the list (decrease seq)
			$scope.moveRosterUp = function(roster, index) {
				// Decrement the index for this roster
				if (index > 0) {
					// Roster is not the first one in the list - We will swap its seq with the one above/before it
					// Find the roster that used to be at the previous seq and increase its seq
					let prev = $scope.myRosters[index - 1];
					
					// Now prepare the request to swap their seqs
					let qs = "swapseq=1&rid1=" + roster.rosterid + "&seq1=" + prev.seq;
					qs += "&rid2=" + prev.rosterid + "&seq2=" + roster.seq;
					
					// Update local seqs
					roster.seq = roster.seq - 1;
					prev.seq = prev.seq + 1;
					
					// Now make sure the array indexes match the seqs
					[$scope.myRosters[index], $scope.myRosters[index - 1]] = [$scope.myRosters[index - 1], $scope.myRosters[index]];
					
					// Commit the changes to the API/DB
					$.ajax({
						type: "POST",
						url: APIURL + "roster.php?" + qs,
						timeout: APITimeout,
						async: true,
						dataType: "text",
						
						// Success
						success: function(data) { // Saved
							// Done
						},
						// Failure
						error: function(data, status, error) { // Failed to save roster
							toast("Could not move roster: \r\n" + error);
						}
					});
				}
			}
			
			// moveRosterTop()
			// Moves the specified roster to the top
			$scope.moveRosterTop = function(roster, index) {
				if (index > 0) {
					// Now prepare the request to push it first
					let qs = "setseq=1&rid=" + roster.rosterid + "&seq=-100";
					
					// Update local seqs
					roster.seq = -100;
					
					// Now make sure the array indexes match the seqs
					$scope.myRosters.unshift($scope.myRosters.splice(index, 1)[0]);
					
					// Commit the changes to the API/DB
					$.ajax({
						type: "POST",
						url: APIURL + "roster.php?" + qs,
						timeout: APITimeout,
						async: true,
						dataType: "text",
						
						// Success
						success: function(data) { // Saved
							// Done - Reload rosters in the right order
							$scope.initRosters(roster.userid);
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not move roster: \r\n" + error);
						}
					});
				}
			}			
			
			// moveRosterDown()
			// Moves the specified roster down in the list (increase seq)
			$scope.moveRosterDown = function(roster, index) {
				// Same as moving the next team up
				if (index >= $scope.myRosters.length) {
					// Already at the end - nothing to do
				} else {
					$scope.moveRosterUp($scope.myRosters[index + 1], index + 1);
				}
			}
			
			// moveRosterBottom()
			// Moves the specified roster to the bottom
			$scope.moveRosterBottom = function(roster, index) {
				if (!(index >= $scope.myRosters.length)) {
					// Roster is not the last one in the list
					
					// Now prepare the request to push it last
					let qs = "setseq=1&rid=" + roster.rosterid + "&seq=1000";
					
					// Update local seqs
					roster.seq = 1000;
					
					// Now make sure the array indexes match the seqs
					$scope.myRosters.splice($scope.myRosters.length - 1, 0, $scope.myRosters.splice(index, 1)[0]);
					
					// Commit the changes to the API/DB
					$.ajax({
						type: "POST",
						url: APIURL + "roster.php?" + qs,
						timeout: APITimeout,
						async: true,
						dataType: "text",
						
						// Success
						success: function(data) { // Saved
							// Done - Reload rosters in the right order
							$scope.initRosters(roster.userid);
						},
						// Failure
						error: function(data, status, error) { // Failed to save roster
							toast("Could not move roster: \r\n" + error);
						}
					});
				}
			}
			
			// commitRoster()
			// Commits the specified roster to the DB/API.
			$scope.commitRoster = function(roster) {
				//console.log("Committing roster");
				//console.log(roster);
				// Prepare just the relevant data points for the roster to commit
				let data = {
					"userid": roster.userid,
					"rosterid": roster.rosterid,
					"rostername": roster.rostername,
					"factionid": roster.factionid,
					"killteamid": roster.killteamid,
					"seq": roster.seq,
					"notes": roster.notes,
					"CP": roster.CP,
					"TP": roster.TP,
					"VP": roster.VP,
					"RP": roster.RP,
					"ployids": roster.ployids,
					"portraitcopyok": roster.portraitcopyok,
					"keyword": roster.keyword,
					"reqpts": roster.reqpts,
					"stratnotes": roster.stratnotes,
					"eqnotes": roster.eqnotes,
					"specopnotes": roster.specopnotes
					//,
					//"tacopids": roster.tacopids
				};
				
				// Send the update request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "roster.php",
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					data: JSON.stringify(data),
					
					// Success
					success: function(data) { // Saved
						// All good
						roster = data;
						
						// Done
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not save this roster: \r\n" + error);
					}
				});
			}
		
			// cloneRoster()
			// Clones the specified roster into the current user's rosters
			// Can be used for imports or clones
			$scope.cloneRoster = function(roster) {
				if ($scope.currentuser == null) {
					// Not logged in - Cannot import
					toast("Cannot import this roster - You are not logged in");
				} else {
					if (roster.userid == $scope.currentuser.userid) {
						// This is a user cloning one of their own rosters
						//te("roster", "clone", "", roster.userid, roster.rosterid);	
					} else {
						// This is a user importing someone else's roster
						//te("roster", "import", "", roster.userid, roster.rosterid);
					}
					toast("Copying team " + roster.rostername + "...");
					
					// Send the POST request to the API
					$.ajax({
						type: "POST",
						url: APIURL + "roster.php?rid=" + roster.rosterid + "&clone=1",
						timeout: APITimeout,
						async: true,
						
						// Success
						success: function(data) { // Saved
							// All good
							roster = data;
							
							// Send the user to their newly-cloned team
							toast("Team copied - Redirecting...");
							location.href = "/r/" + roster.rosterid;
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not save this roster: \r\n" + error);
						}
					});
				}
			}
			
			// initEditRoster();
			// Pops-up the roster edit modal
			$scope.initEditRoster = function(roster) {
				//console.log("initEditRoster(" + roster.rostername + ")");
				$scope.rostertoedit = roster;
				$scope.rostertoedit.newrostername =  roster.rostername;
				$scope.rostertoedit.newnotes =  roster.notes;
				$scope.rostertoedit.newkeyword =  roster.keyword;
				$scope.rostertoedit.newportraitcopyok =  roster.portraitcopyok;
				
				// Show the modal
				$('#editrostermodal').modal("show");
			}
			
			// initEditRosterNarr();
			// Pops-up the roster narrative info modal
			$scope.initEditRosterNarr = function(roster) {
				//console.log("initEditRosterNarr(" + roster.rostername + ")");
				$scope.rostertoedit = roster;
				$scope.rostertoedit.newrostername =  roster.rostername;
				$scope.rostertoedit.newnotes =  roster.notes;
				$scope.rostertoedit.newkeyword =  roster.keyword;
				$scope.rostertoedit.newportraitcopyok =  roster.portraitcopyok;
				$scope.rostertoedit.newreqpts =  roster.reqpts;
				$scope.rostertoedit.newstratnotes =  roster.stratnotes;
				$scope.rostertoedit.neweqnotes =  roster.eqnotes;
				$scope.rostertoedit.newspecopnotes =  roster.specopnotes;
				
				// Show the modal
				$('#editrosternarrmodal').modal("show");
			}
			
			// saveEditRoster()
			// Save roster edits
			$scope.saveEditRoster = function() {
				//te("roster", "edit", "", $scope.rostertoedit.rosterid);

				// Track the old and new custom keywords so we can update the operatives if it changes
				let oldkeyword = $scope.rostertoedit.keyword == "" ? $scope.rostertoedit.killteamcustomkeyword : $scope.rostertoedit.keyword;
				let newkeyword = $scope.rostertoedit.newkeyword == "" ? $scope.rostertoedit.killteamcustomkeyword : $scope.rostertoedit.newkeyword;
				oldkeyword = oldkeyword.replace("<", "").replace(">", "");
				newkeyword = newkeyword.replace("<", "").replace(">", "");

				$scope.rostertoedit.rostername = $scope.rostertoedit.newrostername;
				$scope.rostertoedit.notes = $scope.rostertoedit.newnotes;
				$scope.rostertoedit.keyword = $scope.rostertoedit.newkeyword;
				$scope.rostertoedit.portraitcopyok = $scope.rostertoedit.newportraitcopyok;
				$scope.rostertoedit.reqpts = $scope.rostertoedit.newreqpts;
				$scope.rostertoedit.stratnotes = $scope.rostertoedit.newstratnotes;
				$scope.rostertoedit.eqnotes = $scope.rostertoedit.neweqnotes;
				$scope.rostertoedit.specopnotes = $scope.rostertoedit.newspecopnotes;
				delete $scope.rostertoedit.newrostername;
				delete $scope.rostertoedit.newnotes;

				console.log("Old Keyword: " + oldkeyword + ", New Keyword: " + newkeyword);
				if (oldkeyword != newkeyword) {
					// Propagate the custom keyword to the operatives
					for (let opnum = 0; opnum < $scope.rostertoedit.operatives.length; opnum++) {
						let op = $scope.rostertoedit.operatives[opnum];
						op.keywords = op.keywords.replace("<" + oldkeyword + ">", "<" + newkeyword + ">");
					}
				}
				
				// Commit to API/DB
				$scope.commitRoster($scope.rostertoedit);
				
				// Close the (s)
				$('#editrostermodal').modal("hide");
				$('#editrosternarrmodal').modal("hide");
				
				$scope.$apply();
			}

			$scope.getRosterCustomkeyword = function(roster) {
				if (roster) {
					return roster.killteamcustomkeyword;
				}
			}
		
			// initUploadRosterPortrait()
			// Pops-up the portrait uploader for the specified roster
			$scope.initUploadRosterPortrait = function(roster) {
				//console.log("initUploadRosterPortrait(" + roster.rosterid + ")");
				$scope.rostertoedit = roster;
				$scope.rostertoedit.timestamp = (new Date()).getTime();
				
				// Reset the file input field
				$("#rosterportraitfile").replaceWith($("#rosterportraitfile").val('').clone(true));
				
				// Show the modal
				$('#rosterportraitmodal').modal("show");
			}
			
			$scope.previewRosterPortrait = function(el) {
				// Refresh the portrait preview box
				//console.log("Previewing new portrait");
				let file = $('#rosterportraitfile')[0].files[0];
				if(file){
					const reader = new FileReader();
					reader.onload = function(){
						const result = reader.result;
						$("#rosterportraitpreview").attr("src", result);
					};
					reader.readAsDataURL(file);
				}
			}
			
			$scope.refreshRosterPortrait = function(roid) {
				// Force a refresh of the roster's portrait
				let newimg = "/api/rosterportrait.php?rid=" + $scope.rostertoedit.rosterid + "&cb=" + (new Date()).getTime();
				$("#rosterportrait_" + $scope.rostertoedit.rosterid).attr("src", newimg);
			}
			
			// saveUploadRosterPortrait()
			// Save the specified operative portrait
			$scope.saveUploadRosterPortrait = function() {
				// Upload the image to the API for this roster
				let imgData = "";
				if ($scope.rostertoedit.usedefaultportrait) {
					//te("roster", "portrait", "default", $scope.rostertoedit.rosterid);
					// Use the default portrait - Clear this roster's saved portrait from the DB
					imgData = "";
					$.ajax({
						type: "DELETE",
						url: APIURL + "rosterportrait.php?rid=" + $scope.rostertoedit.rosterid,
						timeout: APITimeout,
						async: true,
						
						// Success
						success: function(data) { // Saved
							// Hide the modal
							$('#rosterportraitmodal').modal("hide");
							
							// Reload the roster's portrait
							$scope.refreshRosterPortrait($scope.rostertoedit.rosterid);
						},
						// Failure
						error: function(data, status, error) { // Failed to save roster
							toast("Could not remove roster portrait: \r\n" + error);
						}
					});
				} else {
					// Use the specified file - Push to the API
					// Send the update to the API
					var formData = new FormData();
					formData.append('file', $('#rosterportraitfile')[0].files[0]);

					$.ajax({
						url : APIURL + "rosterportrait.php?rid=" + $scope.rostertoedit.rosterid,
						type : 'POST',
						data : formData,
						processData: false,  // tell jQuery not to process the data
						contentType: false,  // tell jQuery not to set contentType\
						   
						// Success
					    success : function(data) {
							// Hide the modal
							$('#rosterportraitmodal').modal("hide");
							toast("Roster portrait set!");
							//te("roster", "portrait", "custom", $scope.rostertoedit.rosterid);

							// Reload the roster's portrait
							$scope.refreshRosterPortrait($scope.rostertoedit.rosterid);
					    },
						// Failure
						error: function(data, status, error) { // Failed to save roster
							toast("Could not set roster portrait: \r\n" + error);
						}
					});
				}
			}
		
			// showShareRoster()
			// Pop-up the "Share Roster" modal
			$scope.showShareRoster = function(roster) {
				//te("roster", "share", "", roster.rosterid);
				$scope.shareroster = roster;
				$scope.shareroster.url = "https://ktdash.app/r/" + roster.rosterid;
				
				// Show the modal
				$('#sharerostermodal').modal("show");

				console.log("Roster plaintext description: " + "\r\n" + $scope.getRosterPlainTextDescription(roster));
			}
		
			// showShareRosterGallery()
			// Pop-up the "Share Roster Gallery" modal
			$scope.showShareRosterGallery = function(roster) {
				//te("roster", "share", "gallery", roster.rosterid);
				$scope.shareroster = roster;
				$scope.shareroster.url = "https://ktdash.app/r/" + roster.rosterid + "/g";
				
				// Show the modal
				$('#sharerostergallerymodal').modal("show");
			}

			$scope.shareRoster = function(roster) {
				// Prepare the share content/object
				let shareData = {
					title: roster.rostername + " by " + roster.username,
					text: "Check out this roster on KTDash!",
					url: "https://ktdash.app/r/" + roster.rosterid,
				};

				// Trigger the native share dialog
				navigator.share(shareData);
			}
			
			$scope.shareRosterGallery = function(roster) {
				// Prepare the share content/object
				let shareData = {
					title: roster.rostername + " by " + roster.username,
					text: "Check out this roster on KTDash!",
					url: "https://ktdash.app/r/" + roster.rosterid + "/g",
				};

				// Trigger the native share dialog
				navigator.share(shareData);
			}
			
			$scope.shareRosterDescription = function(roster) {
				// Prepare the share content/object
				let shareData = {
					title: roster.rostername + " by " + roster.username,
					text: $scope.getRosterPlainTextDescription(roster),
					url: "",
				};

				// Trigger the native share dialog
				navigator.share(shareData);
			}
			
			// totalEqPts()
			// Returns the total equipment points for all operatives in the specified roster
			$scope.totalEqPts = function(roster) {
				let total = 0;
				if (roster) {
					for (let i = 0; i < roster.operatives.length; i++) {
						let op = roster.operatives[i];
						if (roster.killteamid != 'NPO')
						{
							if($scope.MODE != 'Dashboard' || !op.hidden) {
								for (let j = 0; j < op.equipments.length; j++) {
									total += parseInt(op.equipments[j].eqpts);
								}
							}
						} else {
							// Use the total Wounds instead of equipment points
							total += parseInt(op.W);
						}
					}
				}
				
				// Done
				return total;
			}
			
			// totalOpEqPts()
			// Returns the total equipment points for all operatives in the specified roster
			$scope.totalOpEqPts = function(op) {
				let total = 0;
				if (op) {
					if ($scope.MODE != 'Dashboard' || !op.hidden) {
						for (let j = 0; j < op.equipments.length; j++) {
							total += parseInt(op.equipments[j].eqpts);
						}
					}
				}
				
				// Done
				return total;
			}
		
			// deploy()
			// Marks this roster to be deployed to the dashboard
			$scope.deploy = function(roster) {
				toast("Loading...");
				$scope.setDashboardRosterId(roster.rosterid);
				window.location.href = "/dashboard";
			}
		
			$scope.toggleSpotlight = function(roster, on) {
				console.log("toggleSpotlight(" + roster.rosterid + ", " + on + ");");
				
				$.ajax({
					type: "POST",
					url: APIURL + "rosterspotlight.php?rid=" + roster.rosterid + "&on=" + on,
					timeout: APITimeout,
					async: true,
					
					// Success
					success: function(data) { // Saved
						// All good
						roster.spotlight = on;
						
						// Done
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not set spotlight: \r\n" + error);
					}
				});
			}
		}
		
		// OPERATIVES
		{
			// opCanBeInjured()
			// Returns a boolean indicating whether the specified operative can be injured (NOT DeathGuard, Talons/Custodes, Stalwart)
			$scope.opCanBeInjured = function(op) {
				console.log("opCanBeInjured(" + op.factionid + "/" + op.killteamid + ")");
				let canNotBeInjured = 
					(op.factionid == 'CHAOS' && op.killteamid == 'DG') // Deathguard Disgustingly Resilient
					||
					(op.factionid == 'IMP' && op.killteamid == 'TOE' && op.fireteamid == 'CG') // Talons of the Emperor The Emperor's Chosen
					||
					((',' + op.eqids + ',').includes(',BH-STA-STA,')) // Battle Honour "Stalwart"
					;
				console.log("Cannot be injured: " + canNotBeInjured);
				
				return !canNotBeInjured;
			}
			
			// updateOpW()
			// Increment or decrement the specified operative's wounds
			$scope.updateOpW = function(op, inc) {
				//te("dashboard", "W", "inc", op.rosterid, op.rosteropid, inc);
				op.curW = op.curW + inc;
				if (op.curW < 0) {
					op.curW = 0;
				}
				if (op.curW > parseInt(op.W)) {
					op.curW = parseInt(op.W);
				}
				
				let wasinjured = op.isinjured;
				if (wasinjured == null) {
					wasinjured = 0;
				}
				
				let opcanbeinjured = $scope.opCanBeInjured(op);
				
				if (op.curW < parseInt(op.W) / 2 && wasinjured == 0 && opcanbeinjured) {
					// Operative is now injured, wasn't injured before (Excludes DeathGuard operatives - Disgustingly Resilient)
					op.isinjured = 1;
					
					// Increase the BS/WS on the operative's weapons (lower BS/WS is better)
					// This does NOT apply to Pathfinder Assault Grenadiers
					if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')					) {
						for (let i = 0; i < op.weapons.length; i++) {
							let wep = op.weapons[i];
							if (wep.weptype == "M" || wep.weptype == "R") {
								// Only ranged and melee weapons; psychic attacks are not affected
								for (let j = 0; j < wep.profiles.length; j++) {
									wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "6");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "5");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "4");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "3");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("1", "2");
								}
							}
						}
										
						for (let i = 0; i < op.equipments.length; i++) {
							let eq = op.equipments[i];
							if (eq.eqtype == 'Weapon' && eq.weapon != null) {
								let wep = eq.weapon;
								if (wep.weptype == "M" || wep.weptype == "R") {
									// Only ranged and melee weapons; psychic attacks are not affected
									for (let j = 0; j < wep.profiles.length; j++) {
										wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "6");
										wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "5");
										wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "4");
										wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "3");
										wep.profiles[j].BS = wep.profiles[j].BS.replace("1", "2");
									}
								}
							}
						}
					}
					
					// Reduce the M on the operative
					op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"] + "*"); // Can't go below 2 [CIRCLE]
					op.M = op.M.replace("3" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("4" + $scope.PlaceHolders["[CIRCLE]"], "3" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("5" + $scope.PlaceHolders["[CIRCLE]"], "4" + $scope.PlaceHolders["[CIRCLE]"]);
					
				} else if (op.curW >= parseInt(op.W) / 2 && wasinjured == 1) {
					// Operative is no longer injured, was injured before
					op.isinjured = 0;
					
					// Reduce the BS/WS on the operative's weapons (lower BS/WS is better)
					// This does NOT apply to Pathfinder Assault Grenadiers
					if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')) {
						for (let i = 0; i < op.weapons.length; i++) {
							let wep = op.weapons[i];
							if (wep.weptype == "M" || wep.weptype == "R") {
								for (let j = 0; j < wep.profiles.length; j++) {
									wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "1");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "2");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "3");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "4");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("6", "5");
								}
							}
						}
										
						for (let i = 0; i < op.equipments.length; i++) {
							let eq = op.equipments[i];
							if (eq.eqtype == 'Weapon' && eq.weapon != null) {
								let wep = eq.weapon;
								if (wep.weptype == "M" || wep.weptype == "R") {
									for (let j = 0; j < wep.profiles.length; j++) {
									wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "1");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "2");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "3");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "4");
									wep.profiles[j].BS = wep.profiles[j].BS.replace("6", "5");
									}
								}
							}
						}
					}
					
					// Increase the M on the operative
					op.M = op.M.replace("5" + $scope.PlaceHolders["[CIRCLE]"], "6" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("4" + $scope.PlaceHolders["[CIRCLE]"], "5" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("3" + $scope.PlaceHolders["[CIRCLE]"], "4" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"] + "*", "MAKEMETWO"); // Can't go below 2 [CIRCLE]
					op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"], "3" + $scope.PlaceHolders["[CIRCLE]"]);
					op.M = op.M.replace("MAKEMETWO", "2" + $scope.PlaceHolders["[CIRCLE]"]);
				}
				
				// Commit to DB
				$scope.commitRosterOp(op);
			}
		
			// opHasEq()
			// Returns a boolean indicating whether the specified operative has any equipments of the specified type.
			// If type is not specified, returns a boolean indicating whether the operative has any equipments.
			$scope.opHasEq = function(op, eqtype, eqvar1) {
				if (op == null) {
					return false;
				}
				return $scope.getOpEq(op, eqtype, eqvar1).length > 0;
			}
			
			// eqIsAbility()
			// Returns a boolean indicating whether the specified equipment is an Ability.
			$scope.eqIsAbility = function(eq) {
				return eq.eqtype == 'Ability';
			}
			
			// eqIsAction()
			// Returns a boolean indicating whether the specified equipment is a Unique Action.
			$scope.eqIsAction = function(eq) {
				return eq.eqtype == 'Action';
			}
			
			// eqIsWeapon()
			// Returns a boolean indicating whether the specified equipment is a Weapon.
			$scope.eqIsWeapon = function(eq) {
				return eq.eqtype == 'Weapon';
			}
			
			// getOpEq()
			// Returns an array of the specified operative's equipments of the specified type.
			// If type is not specified, returns an array of the specified operative's equipments.
			$scope.getOpEq = function(op, eqtype, eqvar1) {
				if (op == null) {
					return [];
				}
				
				if (eqtype == null) {
					// Look for any equipment
					if (op.equipments != null && Array.isArray(op.equipments) && op.equipments.length > 0) {
						return op.equipments;
					} else {
						return [];
					}
				} else {
					// Look for equipment of the requested type
					if (op.equipments != null && Array.isArray(op.equipments) && op.equipments.filter(eq => eq.eqtype == eqtype && eq.eqvar1 == eqvar1).length > 0) {
						return op.equipments.filter(eq => eq.eqtype == eqtype && eq.eqvar1 == eqvar1);
					} else {
						return [];
					}
				}
			}
		
			// initAddOp()
			// Pops-up the "Add Operative" modal
			$scope.initAddOp = function(roster) {
				// Prepare the dialog to add an operative to the selected team
				if ($scope.addop == null || $scope.roster != $scope.addop.roster) {
					// Only reset the operative if this is for a different team than last time use added an operative
					$scope.addop = {
						"faction": roster.faction,
						"factionid": roster.factionid,
						"killteam": roster.killteam,
						"killteamid": roster.killteamid,
						"roster": roster,
						"fireteam": roster.killteam.fireteams[0],
						"fireteamid": roster.killteam.fireteams[0].fireteamid,
						"operative": roster.killteam.fireteams[0].operatives[0],
						"opid": roster.killteam.fireteams[0].operatives[0].opid,
						"opname": ""
					};
				}
					
				$scope.generateOpName($scope.addop.factionid, $scope.addop.killteamid, $scope.addop.fireteamid, $scope.addop.opid, $scope.addop, 'opname');

				// Show the modal
				$('#addoptorostermodal').modal("show");
			}
			
			// commitRosterOp()
			// Commits the specified roster to the DB/API.
			$scope.commitRosterOp = function(operative) {
				// Send the update request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "rosteroperative.php",
					timeout: APITimeout,
					async: true,
					data: JSON.stringify(operative),
					
					// Success
					success: function(data) { // Saved
						// All good, response contains the updated operative - Refresh it
						operative = data;
						
						// Done
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not save this operative: \r\n" + error);
					}
				});
			}
		
			// Add the selected operative
			$scope.addOperative = function() {
				// Validate the input
				if ($scope.addop.operative == null) {
					// No operative selected
					toast("Please select an operative");
					return;
				}
				
				// Validate the input
				if ($scope.addop.opname == null || $scope.addop.opname.trim() == "") {
					// No name entered
					toast("Please enter a name for this operative");
					return;
				}
				
				// Copy the selected operative from the form
				let newop = {
					"userid": $scope.currentuser.userid,
					"rosterid": $scope.myRoster.rosterid,
					"factionid": $scope.addop.operative.factionid,
					"killteamid": $scope.addop.operative.killteamid,
					"fireteamid": $scope.addop.operative.fireteamid,
					"opid": $scope.addop.operative.opid,
					"opname": $scope.addop.opname,
					"wepids": "",
					"eqids": "",
					"curW": $scope.addop.W,
					"notes": ""
				};
				
				// Parse the weapons
				newop.wepids = "";
				for (let i = 0; i < $scope.addop.operative.weapons.length; i++) {
					if ($scope.addop.operative.weapons[i].isselected) {
						if (newop.wepids.length > 0) {
							// Put a comma between weapons
							newop.wepids += ",";
						}
						newop.wepids += $scope.addop.operative.weapons[i].wepid;
					}
				}
				
				// Validate the input
				if (newop.wepids == "" && $scope.addop.operative.weapons.length > 0) {
					// No weapons selected
					toast("Please select weapons for this operative");
					return;
				}
				
				// Parse the equipment
				newop.eqids = "";
				if ($scope.addop.operative.equipments) {
					for (let i = 0; i < $scope.addop.operative.equipments.length; i++) {
						if ($scope.addop.equipments.weapons[i].isselected) {
							if (newop.eqids.length > 0) {
								// Put a comma between equipments
								newop.eqids += ",";
							}
							newop.eqids += $scope.addop.operative.equipments[i].eqids;
						}
					}
				}
				
				// Commit this new operative to the API/DB
				$.ajax({
					type: "POST",
					url: APIURL + "rosteroperative.php",
					timeout: APITimeout,
					async: false,
					datatype: 'json',
					data: JSON.stringify(newop),
					success: function(data) {
						// All good, refresh this team
						$scope.initRoster(newop.rosterid);
						
						//te("roster", "addop", "", $scope.myRoster.rosterid, data.rosteropid);
				
						// Close the modal
						$('#addoptorostermodal').modal("hide");
						
						// Tell the user their operative has been added
						toast("Operative " + $scope.addop.opname + " added to team!");
					},
					error: function(error) {
						// Failed to save roster
						toast("Could not add operative to roster: " + error);
					}
				});
			}
			
			// Generate a name for an operative
			$scope.getaddopname = function() {
				var url = APIURL + "name.php?factionid=" + $scope.addop.operative.factionid + "&killteamid=" + $scope.addop.operative.killteamid + "&fireteamid=" + $scope.addop.operative.fireteamid + "&opid=" + $scope.addop.operative.opid;
				$.ajax({
					type: "GET",
					url: url,
					timeout: APITimeout,
					async: true,
					dataType: 'text',
					success: function(data) {
						$scope.addop.opname = data.replace(/[\n\r]/g, '');
						
						$scope.$apply();
					}
				});
			}
			
			// Generate a name for an operative
			$scope.generateOpName = function(faid, ktid, ftid, opid, op, namevar) {
				console.log("Op: " + JSON.stringify(op));
				if ($scope.settings["useoptypeasname"] != 'n') {
					// Copy optype to name
					op[namevar] = op.operative.opname;
				} else {
					// Auto-generate a new name
					var url = APIURL + "name.php?factionid=" + faid + "&killteamid=" + ktid + "&fireteamid=" + ftid + "&opid=" + opid;
					$.ajax({
						type: "GET",
						url: url,
						timeout: APITimeout,
						async: true,
						dataType: 'text',
						success: function(data) {
							op[namevar] = data.replace(/[\n\r]/g, '');;
							
							$scope.$apply();
						}
					});
				}
			}
			
			// initDeleteOp()
			// Pops-up the "Delete Operative" modal
			$scope.initDeleteOp = function(op, roster) {
				//console.log("initDeleteOperative(" + op.opname + ", " + roster.rostername + ")");
				$scope.optodelete = {
					"operative": op,
					"roster": roster,
				};

				// Show the modal
				$('#deleteopmodal').modal("show");
			}
			
			// deleteOp()
			// Delete the specified operative from its team
			$scope.deleteOp = function() {	
				let idx = $scope.optodelete.roster.operatives.indexOf($scope.optodelete.operative);
				if (idx > -1) {
					$scope.optodelete.roster.operatives.splice(idx, 1);
				}
				
				$http.delete(APIURL + "rosteroperative.php?roid=" + $scope.optodelete.operative.rosteropid)
				.then(function(response)
					{
						// Close the modal
						$('#deleteopmodal').modal("hide");
						
						//te("roster", "delop", "", $scope.optodelete.operative.rosterid, $scope.optodelete.operative.rosteropid);
						
						// Tell the user their operative has been deleted
						toast("Operative " + $scope.optodelete.operative.opname + " deleted");
						
						// Make sure changes are reflected
						$scope.$apply();
					}
				).catch(function(response)
					{
						//console.log("Could not commit op deletion: " + response.statusText);
					}
				);
				
			}
			
			// cloneOp()
			// Adds a copy of the specified operative to the same roster
			$scope.cloneOp = function(origop) {
				// Copy the new operative from the original
				let newop = {
					"userid": $scope.currentuser.userid,
					"rosterid": origop.rosterid,
					"factionid": origop.factionid,
					"killteamid": origop.killteamid,
					"fireteamid": origop.fireteamid,
					"opid": origop.opid,
					"opname": origop.opname + "(copy)",
					"wepids": origop.wepids,
					"eqids": origop.eqids,
					"curW": origop.W,
					"notes": ""
				};
				
				// Commit this new operative to the API/DB
				$http.post(APIURL + "rosteroperative.php",
					JSON.stringify(newop)
				).then(function(response)
					{
						let data = response.data;
						
						// Replace placeholders
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						
						// All good, add this operative to the team
						$scope.myRoster.operatives.push(data);
						
						//te("roster", "cloneop", "", newop.rosterid, data.rosteropid);
						
						// Tell the user their operative has been added
						toast("Operative " + newop.opname + " added to team!");
					}
				).catch(function(response)
					{
						// Failed to save roster
						toast("Could not clone operative: " + response.statusText);
					}
				);
			}

			$scope.opIsDead = function(operative) {
				return operative.curW <= 0 || $scope.opIsSlain(operative);
			}

			$scope.opIsSlain = function(operative) {
				// Check if this operative has the "Slain" battle scar
				// Loop through this operative's equipment looking for this "Slain" battle scar
				for (let eqnum = 0; eqnum < operative.equipments.length; eqnum++) {
					let eq = operative.equipments[eqnum];
					if (eq.eqcategory == 'Battle Scar' && eq.eqname == 'Slain') {
						return true;
					}
				}
				return false;
			}
			
			// moveOpUp()
			// Moves the specified operative up in the roster (decrease seq)
			$scope.moveOpUp = function(roster, op, index) {
				//console.log("moveOpUp(" + roster.rostername + ", " + op.seq + "-" + op.opname + ", " + index + ")");
				// Decrement the seq for this operative
				if (index > 0) {
					// Operative is not the first one in the list - We will swap its seq with the one above/before it
					// Find the operative that used to be at the previous seq and increase its seq
					let prev = roster.operatives[index - 1];
					
					// Now prepare the request to swap their seqs
					let qs = "swapseq=1&rid=" + roster.rosterid + "&roid1=" + op.rosteropid + "&seq1=" + prev.seq;
					qs += "&roid2=" + prev.rosteropid + "&seq2=" + op.seq;
					
					// Update local seqs
					op.seq = op.seq - 1;
					prev.seq = prev.seq + 1;
					
					// Now make sure the array indexes match the seqs
					[roster.operatives[index], roster.operatives[index - 1]] = [roster.operatives[index - 1], roster.operatives[index]];
					
					// Commit the changes to the API/DB
					$http.post(APIURL + "rosteroperative.php?" + qs)
					.then(function(response) 
						{
							// Done
							//$scope.$apply();
						}
					).catch(function(response) 
						{
							// Failed to save operative
							toast("Could not move operative: \r\n" + response.statusText);
						}
					);
				}
			}
			
			// moveOpDown()
			// Moves the specified operative down in the roster (increase seq)
			$scope.moveOpDown = function(roster, op, index) {
				//console.log("moveOpDown(" + roster.rostername + ", " + op.seq + "-" + op.opname + ", " + index + ")");
				// Same as moving the next operative up
				if (index >= roster.operatives.length) {
					// Already at the end - nothing to do
				} else {
					$scope.moveOpUp(roster, roster.operatives[index + 1], index + 1);
				}
			}
			
			// initEditOp()
			// Pops-up the "Edit Operative" modal
			$scope.initEditOp = function(op, roster) {
				// Prepare the op to edit (will be used in saveEditOperative())
				$scope.optoedit = op;
				$scope.optoeditroster = roster;
				
				// Create a deep-copy clone of this op to be edited
				$scope.tempeditop = JSON.parse(JSON.stringify(op));
				
				// Set the weapon selections from all available, marking the right ones as selected for this operative
				$scope.tempeditop.weapons = [];
				for (let wepnum = 0; wepnum < op.baseoperative.weapons.length; wepnum++) {
					let wep = JSON.parse(JSON.stringify(op.baseoperative.weapons[wepnum]));
					wep.isselected = ("," + op.wepids + ",").indexOf("," + wep.wepid + ",") >= 0;
					$scope.tempeditop.weapons.push(wep);
				}
				
				// Rebuild equipments from all available, marking the right ones as selected for this operative
				$scope.tempeditop.equipments = [];
				for (let eqnum = 0; eqnum < roster.killteam.equipments.length; eqnum++) {
					let eq = JSON.parse(JSON.stringify(roster.killteam.equipments[eqnum]));
					if ((eq.fireteamid == op.fireteamid && (eq.opid == op.opid || eq.opid == '')) || (eq.fireteamid == '' && eq.opid == '')) {
						eq.isselected = ("," + op.eqids + ",").indexOf("," + eq.eqid + ",") >= 0;
						$scope.tempeditop.equipments.push(eq);
						if (eq.eqtype == 'Weapon') {
							//console.log("Found equipment weapon: " + eq.weapon.wepname);
						}
					}
				}
				
				// Show the modal
				$('#editopmodal').modal("show");
			}
			
			// saveEditOp()
			// Save the changes to the edited operative
			$scope.saveEditOp = function() {
				// Set the new operative name
				$scope.optoedit.opname = $scope.tempeditop.opname;
				
				// Parse the weapons to build the wepids
				$scope.optoedit.wepids = "";
				$scope.optoedit.weapons = [];
				for (let i = 0; i < $scope.tempeditop.weapons.length; i++) {
					if ($scope.tempeditop.weapons[i].isselected) {
						if ($scope.optoedit.wepids.length > 0) {
							// Put a comma between weapon IDs
							$scope.optoedit.wepids += ",";
						}
						
						// Add this weapon to the operative
						$scope.optoedit.wepids += $scope.tempeditop.weapons[i].wepid;
						
						// Make sure to track this locally too
						$scope.optoedit.weapons.push($scope.tempeditop.weapons[i]);
					}
				}
				
				// Parse the equipments to build the eqids
				$scope.optoedit.eqids = "";
				$scope.optoedit.equipments = [];
				for (let i = 0; i < $scope.tempeditop.equipments.length; i++) {
					if ($scope.tempeditop.equipments[i].isselected) {
						if ($scope.optoedit.eqids.length > 0) {
							// Put a comma between equipment IDs
							$scope.optoedit.eqids += ",";
						}
						
						// Add this equipment to the operative
						$scope.optoedit.eqids += $scope.tempeditop.equipments[i].eqid;
						
						// Make sure to track this locally too
						$scope.optoedit.equipments.push($scope.tempeditop.equipments[i]);
						//console.log("Added equipment " + JSON.stringify($scope.tempeditop.equipments[i]));
					}
				}
				
				// Set the selected specialism
				$scope.optoedit.specialism = $scope.tempeditop.specialism;
				
				// Save all changes
				//te("roster", "editop", "", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);
				$scope.commitRosterOp($scope.optoedit);
				
				// Auto-apply equipment mods
				$scope.applyEqMods($scope.optoeditroster);
				
				// Close the modal
				$('#editopmodal').modal("hide");
				
				// Tell the user their operative has been saved
				toast("Operative " + $scope.optoedit.opname + " saved");
			}
			
			// initUploadOpPortrait()
			// Pops-up the portrait uploader for the specified operative
			$scope.initUploadOpPortrait = function(operative) {
				$scope.optoedit = operative;
				$scope.optoedit.timestamp = (new Date()).getTime();
				
				// Reset the file input field
				$("#opportraitfile").replaceWith($("#opportraitfile").val('').clone(true));
				
				// Show the modal
				$('#opportraitmodal').modal("show");
			}
			
			$scope.previewOpPortrait = function(el) {
				// Refresh the portrait preview box
				//console.log("Previewing new portrait");
				let file = $('#opportraitfile')[0].files[0];
				if(file){
					const reader = new FileReader();
					reader.onload = function(){
						const result = reader.result;
						$("#opportraitpreview").attr("src", result);
					};
					reader.readAsDataURL(file);
				}
			}
			
			$scope.refreshOpPortrait = function(roid) {
				// Force a refresh of the operative's portrait (uses background-image)
				let newimg = "/api/operativeportrait.php?roid=" + $scope.optoedit.rosteropid + "&cb=" + (new Date()).getTime();
				$("#opportrait_" + $scope.optoedit.rosteropid).attr("src", newimg);
			}
			
			// saveUploadOpPortrait()
			// Save the specified operative portrait
			$scope.saveUploadOpPortrait = function() {
				// Upload the image to the API for this operative
				let imgData = "";
				if ($scope.optoedit.usedefaultportrait) {
					//te("roster", "opportrait", "default", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);
					
					// Use the default portrait - Clear this operative's saved portrait from the DB
					imgData = "";
					$http.delete(APIURL + "operativeportrait.php?roid=" + $scope.optoedit.rosteropid)
					.then(function(response)
						{
							let data = response.data;
							// Hide the modal
							$('#opportraitmodal').modal("hide");
							
							// Reload the operative's portrait
							$scope.optoedit.hascustomportrait = 0;
							$scope.refreshOpPortrait($scope.optoedit.rosteropid);
						}
					).catch(function(response) 
						{ // Failed to save operative
							toast("Could not remove operative portrait: \r\n" + response.statusText);
						}
					);
				} else {
					// Use the specified file - Push to the API
					// Send the update to the API
					var formData = new FormData();
					formData.append('file', $('#opportraitfile')[0].files[0]);

					$.ajax({
						url : APIURL + "operativeportrait.php?roid=" + $scope.optoedit.rosteropid,
						type : 'POST',
						data : formData,
						processData: false,  // tell jQuery not to process the data
						contentType: false,  // tell jQuery not to set contentType
						   
						// Success
						success : function(data) {
							// Hide the modal
							$('#opportraitmodal').modal("hide");
							toast("Operative portrait set!");
							$scope.optoedit.hascustomportrait = 1;
							te("roster", "opportrait", "custom", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);

							// Reload the operative's portrait
							$scope.refreshOpPortrait($scope.optoedit.rosteropid);
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not set operative portrait: \r\n" + error);
						}
					});
					
					/*
					$http.post(
						APIURL + "operativeportrait.php?roid=" + $scope.optoedit.rosteropid,
						JSON.stringify(formData),
						{
							'Content-Type': 'multipart/form-data',
							'Accept': 'application/json'
						}
					).then(function(response) 
						{
							let data = response.data;
							// Hide the modal
							$('#opportraitmodal').modal("hide");
							toast("Operative portrait set!");
							te("roster", "opportrait", "custom", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);

							// Reload the operative's portrait
							$scope.refreshOpPortrait($scope.optoedit.rosteropid);
					    }
					).catch(function(response) 
						{
							// Failure
							toast("Could not set operative portrait: \r\n" + response.statusText);
						}
					);
					*/
				}
			}
		
			// getRosterArchetype()
			// Returns a string representing the archetype for the specified roster, using its operatives' fireteams' archetype
			$scope.getRosterArchetype = function(roster) {
				let rosterArchetype = "";
				if (roster) {
					//console.log("Getting archetype for " + roster.rostername);
					for (var opnum = 0; opnum < roster.operatives.length; opnum++) {
						let op = roster.operatives[opnum];
						let archetypes = op.archetype.split('/');
						//console.log("   Checking op #" + opnum + " (" + op.opname + "): " + archetypes);
						
						for (let archnum = 0; archnum < archetypes.length; archnum++) {
							let arch = archetypes[archnum];
							
							if (!rosterArchetype.includes(arch)) {
								// Append this roster archetype to the output
								if (rosterArchetype.length > 0) {
									// Put a slash between archetypes
									rosterArchetype += "/";
								}
								rosterArchetype += arch;
							}
						}
					}
				}
				
				// Done
				return rosterArchetype;
			}
			
			$scope.getRosterTextDescription = function(roster) {
				//te("roster", "gettext", "", roster.rosterid);
				let out = "";
				out = "<h4 class=\"d-inline\"><a href=\"https://ktdash.app/r/" + roster.rosterid + "\">" + roster.rostername + "</a></h4> ";
				out += "(<a href=\"https://ktdash.app/fa/" + roster.factionid + "/kt/" + roster.killteamid + "\">" + roster.killteam.killteamname + "</a>)<br/>";
				
				let totalEq = $scope.totalEqPts(roster);
				if (totalEq > 0) {
					out += "Total Equipment Points: " + totalEq + "<br/><br/>";
				}
				
				for (let i = 0; i < roster.operatives.length; i++) {
					let op = roster.operatives[i];
					out += "<h5>" + (op.seq + 1) + ". " + op.opname + " (" + op.optype + ")</h5>";
					
					// Weapons
					for (let j = 0; j < op.weapons.length; j++) {
						let wep = op.weapons[j];
						if (j > 0) {
							out += ", ";
						}
						out += wep.wepname;
					}
					
					for (let j = 0; j < op.equipments.length; j++) {
						let eq = op.equipments[j];
						if (j == 0 || (j > 0 && eq.eqcategory != op.equipments[j - 1].eqcategory)) {
							out += "<br/>" + eq.eqcategory + ": ";
						} else {
							out += ", ";
						}
						out += eq.eqname + (eq.eqpts > 0 ? " (" + eq.eqpts + " EP)" : "");
					}
					
					out += "<br/><br/>";
				}
				
				// Done
				return out;
			}
			
			$scope.getRosterPlainTextDescription = function(roster) {
				//te("roster", "getplaintext", "", roster.rosterid);
				let out = "";
				out = roster.rostername + "\r\n";
				out += roster.killteamname + " by " + roster.username + "\r\n";
				out += "https://ktdash.app/r/" + roster.rosterid + "\r\n\r\n";
				
				let totalEq = $scope.totalEqPts(roster);
				if (totalEq > 0) {
					out += "Total Equipment Points: " + totalEq + "\r\n\r\n";
				}

				for (let i = 0; i < roster.operatives.length; i++) {
					let op = roster.operatives[i];
					out += (op.seq + 1) + ". " + op.opname + " (" + op.optype + ")\r\n";
					
					// Weapons
					for (let j = 0; j < op.weapons.length; j++) {
						let wep = op.weapons[j];
						if (j > 0) {
							out += ", ";
						}
						out += wep.wepname;
					}
					
					for (let j = 0; j < op.equipments.length; j++) {
						let eq = op.equipments[j];
						if (j == 0 || (j > 0 && eq.eqcategory != op.equipments[j - 1].eqcategory)) {
							out += "\r\n" + eq.eqcategory + ": ";
						} else {
							out += ", ";
						}
						out += eq.eqname + (eq.eqpts > 0 ? " (" + eq.eqpts + " EP)" : "");
					}
					
					out += "\r\n\r\n";
				}
				
				// Done
				return out;
			}
			
			// initEditOpEq()
			// Pop-up the operative equipment modal
			$scope.initEditOpEq = function(roster, operative) {
				if (operative.userid == $scope.currentuser.userid) {
					$scope.opeq = {
						"operative": operative,
						"equipments": roster.killteam.equipments
					};
					
					// Set the current selection
					for (let eqnum = 0; eqnum < $scope.opeq.equipments.length; eqnum++) {
						let eq = $scope.opeq.equipments[eqnum];
						eq.isselected = false;
						
						if ($scope.opeq.operative.equipments == null) {
							$scope.opeq.operative.equipments = [];
						}
						
						for (let opeqnum = 0; opeqnum < $scope.opeq.operative.equipments.length; opeqnum++) {
							if ($scope.opeq.operative.equipments[opeqnum].eqid == eq.eqid) {
								// This operative has this equipment selected
								eq.isselected = true;
							}
						}
					}
					
					// Show the modal
					$('#editopeqmodal').modal("show");
				}
			}
			
			// saveEditOpEq()
			// Commit operative equipment selections
			$scope.saveEditOpEq = function() {
				// Remove the operative's previous equipment
				$scope.opeq.operative.equipments = [];
				$scope.opeq.operative.eqids = "";
				
				// Add the selected equipment to the operative
				for (let i = 0; i < $scope.opeq.equipments.length; i++) {
					if ($scope.opeq.equipments[i].isselected) {
						if ($scope.opeq.operative.eqids.length > 0) {
							// Put a comma between equipments
							$scope.opeq.operative.eqids += ",";
						}
						$scope.opeq.operative.eqids += $scope.opeq.equipments[i].eqid;
						
						$scope.opeq.operative.equipments.push($scope.opeq.equipments[i]);
					}
				}
				
				// Commit changes
				$scope.commitRosterOp($scope.opeq.operative);
				
				// Hide the modal
				$('#editopeqmodal').modal("hide");
			}
			
			$scope.printop = function(operative) {
				//te("roster", "print", "op", operative.rosterid, operative.rosteropid);
				window.open("/api/pdfrender.php?scope=op&roid=" + operative.rosteropid);
			}
		
			// initPrintOp()
			// Load the specified operative to be printed
			$scope.initPrintOp = function(roid) {
				// Get the operative
				$scope.loading = true;
				
				// Set the mode
				$scope.MODE = 'Roster';
				
				$.ajax({
					type: "GET",
					url: APIURL + "rosteroperative.php?roid=" + roid,
					timeout: APITimeout,
					async: true,
					
					// Success
					success: function(data) { // Got
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.operative = data;
						
						// Remove baseop for clarity
						delete($scope.operative.baseoperative);
						
						//console.log("Got Operative: \r\n" + JSON.stringify($scope.operative));
						
						//te("roster", "print", "op", $scope.operative.rosterid, $scope.operative.rosteropid);
						
						// Done
						$scope.loading = false;
						$scope.$apply();
						print();
					},
					// Failure
					error: function(data, status, error) { // Failed to get operative
						$scope.loading = false;
						toast("Could not get operative: \r\n" + error);
					}
				});
			}
			
			// updateXP()
			// Increments or decrements the specified RosterOperative's XP
			$scope.updateXP = function(inc, op) {
				//te("roster", "XP", "inc", op.rosterid, op.rosteropid, inc);
				op.xp += inc;
				if (op.xp < 0) {
					op.xp = 0;
				}
				$scope.commitRosterOp(op);
			}
			
			// updateRested()
			// Increments or decrements the specified RosterOperative's Rested counter
			$scope.updateRested = function(inc, op) {
				//te("roster", "rested", "inc", op.rosterid, op.rosteropid, inc);
				op.rested += inc;
				if (op.rested < 0) {
					op.rested = 0;
				}
				$scope.commitRosterOp(op);
			}
		}
		
		// COMPENDIUM
		{
			// initCompendium()
			// Loads all factions
			$scope.initCompendium = function() {
				//te("compendium", "allfactions");
				$scope.loading = true;
				$scope.MODE = "Compendium";
				
				let preload = document.body.getAttribute("factions");
				if (preload && preload != "") {
					// Already pre-loaded the factions
					$scope.factions = JSON.parse($scope.replacePlaceholders(preload));
					
					// Now clear the preload so we don't show operatives more than once when edited
					document.body.setAttribute("factions", "");
					
					$scope.loading = false;
				}
				else {
					$.ajax({
						type: "GET",
						url: APIURL + "faction.php?edition=" + $scope.settings["edition"],
						timeout: APITimeout,
						async: true,
						dataType: 'json',
						success: function(data) {
							// Got factions
							$scope.factions = data;
							$scope.loading = false;
							$scope.$apply();
						},
						error: function(error) {
							// Failed to get factions
							toast("Could not get factions: " + error);
							$scope.loading = false;
							$scope.$apply();
						}
					});
				}
			}
			
			$scope.initFaction = function(fa) {
				if (fa == null) {
					// Not passed in, get from query string
					fa = GetQS('fa');
				}
				//te("compendium", "faction", "", fa);
				$scope.loading = true;
				$scope.MODE = "Compendium";
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php?factionid=" + fa + "&loadkts=1&edition=" + $scope.settings["edition"],
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Got faction
						$scope.faction = data;
						$scope.loading = false;
						$scope.$apply();
					},
					error: function(error) {
						// Failed to get faction
						toast("Could not get faction: " + error);
						$scope.loading = false;
						$scope.$apply();
					}
				});
			}
			
			$scope.initKillteam = function(fa, kt) {
				if (fa == null) {
					// Not passed in, get from query string
					fa = GetQS('fa');
				}
				if (kt == null) {
					kt = GetQS("kt");
				}
				//te("compendium", "killteam", "", fa, kt);
				
				$scope.loading = true;
				$scope.MODE = "Compendium";
				
				let preloadkt = document.body.getAttribute("killteam");
				let preloadfa = document.body.getAttribute("faction");
				if (preloadkt && preloadfa) {
					// Already pre-loaded this killteam, use that instead of a round-trip to the API
					$scope.killteam = JSON.parse($scope.replacePlaceholders(preloadkt));
					$scope.faction = JSON.parse($scope.replacePlaceholders(preloadfa));
					$scope.loading = false;
				}
				else 
				{
					// First get the faction
					//	On success, we'll get the killteam
					
					$.ajax({
						type: "GET",
						url: APIURL + "faction.php?factionid=" + fa,
						timeout: APITimeout,
						async: true,
						dataType: 'json',
						success: function(data) {
							// Got faction
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.faction = data;
							
							// Now get the faction
							$.ajax({
								type: "GET",
								url: APIURL + "killteam.php?fa=" + fa + "&kt=" + kt,
								timeout: APITimeout,
								async: true,
								dataType: 'json',
								success: function(data) {
									// Got faction
									data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
									$scope.killteam = data;
									$scope.loading = false;
									$scope.$apply();
								},
								error: function(error) {
									// Failed to get factions
									toast("Could not get Killteam: " + error);
									$scope.loading = false;
									$scope.$apply();
								}
							});
						},
						error: function(error) {
							// Failed to get faction
							toast("Could not get faction: " + error);
							$scope.loading = false;
							$scope.$apply();
						}
					});
				}
			}
		}
		
		// DASHBOARD
		{
			// Labels for Resource Points
			$scope.RPLabels = {
				"IMP": {
					"NOV": {
						"Label": "Faith Points",
						"Shortcut": "FP"
					},
					"NOV24": {
						"Label": "Faith Points",
						"Shortcut": "FP"
					},
					"KAS": {
						"Label": "Elite Points",
						"Shortcut": "EP",
						"StartValue": 10
					}
				},
				"AEL": {
					"VDT": {
						"Label": "Performance Tally",
						"Shortcut": "PT"
					},
					"MND": {
						"Label": "Soul Harvest Tokens",
						"Shortcut": "SH"
					}
				},
				"CHAOS": {
					"BLD": {
						"Label": "Blooded Tokens",
						"Shortcut": "BT"
					},
					"NC": {
						"Label": "Prescience Tokens",
						"Shortcut": "PT"
					}
				}
			};
			$scope.OpTokens = {
				"CHAOS": {
					"BLD": {
						"Label": "Blooded",
						"Shortcut": "BT",
						"Type": "boolean"
					}
				},
				"AEL": {
					"HOTA": {
						"Label": "Pain",
						"Shortcut": "PT",
						"Type": "int"
					}
				}
			}
			
			$scope.dashboardopponentrosterid = localStorage.getItem("dashboardopponentrosterid");
			
			// selectDashOpponent()
			// Sets dashboardopponentroster based on current dashboardopponentrosterid
			$scope.selectDashOpponent = function() {
				// Get the selected roster
				//te("dashboard", "selectopponentroster", $scope.getDashboardRosterId(), $scope.dashboardopponentrosterid);
				localStorage.setItem("dashboardopponentrosterid", $scope.dashboardopponentrosterid);
				$http.get(APIURL + "roster.php?rid=" + $scope.dashboardopponentrosterid + "&loadrosterdetail=1")
				.then(function(response)
					{
						// Got the opposing roster
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(response.data)));
						$scope.dashboardopponentroster = data;
						toast("Opponent roster " + data.rostername + " set");
						setInterval($scope.refreshDashOpponent, 1000);
						$('#dashboardopponentmodal').modal('hide');
					}
				).catch(function(ex)
				{
					// Failure
					toast("Could not get opponent roster: \r\n" + ex.statusText);
				});
			}
			
			$scope.refreshingDashOpponent = false;
			$scope.refreshDashOpponent = function() {
				// Only if "Opponent" is the currently-active tag
				if ($("#opponentdash-tab").hasClass("active") && !$scope.refreshingDashOpponent) {
					$scope.refreshingDashOpponent = true;
					$http.get(APIURL + "roster.php?rid=" + $scope.dashboardopponentrosterid + "&loadrosterdetail=1&skipviewcount=1")
					.then(function(response)
						{
							// Got the opposing roster
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(response.data)));
							$scope.dashboardopponentroster = data;
							$scope.refreshingDashOpponent = false;
						}
					);
				}
			}
			
			// getDashboardRosterId()
			// Returns the currently-selected roster id for the dashboard
			$scope.getDashboardRosterId = function() {
				return localStorage.getItem("dashboardrosterid");
			}
			
			// setDashboardRosterId()
			// Set the currently-selected roster id for the dashboard
			$scope.setDashboardRosterId = function(rosterid) {
				localStorage.setItem("dashboardrosterid", rosterid);
			}
			
			// initDashboard()
			// Initializes the dashboard
			$scope.initDashboard = function(rid) {
				if (rid == null) {
					// Not passed in, get from query string
					rid = GetQS('rid');
				}
				
				//te("dashboard", "init");
				$scope.loading = true;
				$scope.MODE = 'Dashboard';
				
				// Require the user to be logged in
				if ($scope.currentuser == null) {
					// Not logged in - Send user to "Log In"
					$scope.loading = false;
					//console.log("Not logged in");
					toast("Not logged in!");
					window.location.href = "/login.htm";
				}
				else {
					// User is logged in, get their rosters
					$.ajax({
						type: "GET",
						url: APIURL + "roster.php?loadrosterdetail=1&uid=" + $scope.currentuser.userid,
						timeout: APITimeout,
						async: true,
						dataType: 'json',
						
						// Success
						success: function(data) { // Got user's rosters
							// Load the rosters into "myRosters"
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.currentuser.rosters = data;
							
							// Get the current deployed roster
							//	May be set from the query string ("Deploy" button on rosters)
							if (rid != "" && rid != null) {
								$scope.setDashboardRosterId(rid);
							}
							
							$scope.dashboardrosterid = $scope.getDashboardRosterId();
							if ($scope.dashboardrosterid == null || $scope.dashboardrosterid == "") {
								// Just select the first roster for the current user
								$scope.dashboardrosterid = $scope.currentuser.rosters[0].rosterid;
								$scope.setDashboardRosterId($scope.dashboardrosterid);
							}
							
							// Now check that this roster actually exists
							$scope.dashboardroster = null;
							for (let i = 0; i < $scope.currentuser.rosters.length; i++) {
								if ($scope.currentuser.rosters[i].rosterid == $scope.dashboardrosterid) {
									// Found it
									$scope.dashboardroster = $scope.currentuser.rosters[i];
								}
							}
							
							if ($scope.dashboardroster == null) {
								// Did not find the assigned roster, use the first one instead
								$scope.dashboardrosterid = $scope.currentuser.rosters[0].rosterid;
								$scope.setDashboardRosterId($scope.dashboardrosterid);
								$scope.dashboardroster = $scope.currentuser.rosters[0];
								$scope.setDashboardRosterId($scope.dashboardrosterid);
							}
				
							// Parse selected ploys for this roster
							for (let ploynum = 0; ploynum < $scope.dashboardroster.killteam.ploys.strat.length; ploynum++) {
								let ploy = $scope.dashboardroster.killteam.ploys.strat[ploynum];
							}
							
							// Get the operatives and set their "Injured" flag where appropriate
							for (let i = 0; i < $scope.dashboardroster.operatives.length; i++) {
								let op = $scope.dashboardroster.operatives[i];
								
								let wasinjured = op.isinjured;
								if (wasinjured == null) {
									wasinjured = 0;
								}
								if (op.curW < parseInt(op.W) / 2 && wasinjured == 0 && !(op.factionid == 'CHAOS' && op.killteamid == 'DG')) {
									// Operative is now injured, wasn't injured before (Excludes DeathGuard operatives - Disgustingly Resilient)
									op.isinjured = 1;
									
									// Increase the BS/WS on the operative's weapons (lower BS/WS is better)
									// This does NOT apply to Pathfinder Assault Grenadiers
									if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')					) {
										// Normal weapons
										for (let i = 0; i < op.weapons.length; i++) {
											let wep = op.weapons[i];
											for (let j = 0; j < wep.profiles.length; j++) {
												wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "6");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "5");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "4");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "3");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("1", "2");
											}
										}
										
										// Equipment Weapons
										for (let i = 0; i < op.equipments.length; i++) {
											let eq = op.equipments[i];
											if (eq.eqtype == 'Weapon' && eq.weapon != null) {
												let wep = eq.weapon;
												console.log("Injuring weapon " + wep.wepid + ": " + wep.wepname);
												for (let j = 0; j < wep.profiles.length; j++) {
													wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "6");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "5");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "4");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "3");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("1", "2");
												}
											}
										}
									}
									
									// Reduce the M on the operative
									op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"], "1" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("3" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("4" + $scope.PlaceHolders["[CIRCLE]"], "3" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("5" + $scope.PlaceHolders["[CIRCLE]"], "4" + $scope.PlaceHolders["[CIRCLE]"]);
									
								} else if (op.curW >= parseInt(op.W) / 2 && wasinjured == 1) {
									// Operative is no longer injured, was injured before
									op.isinjured = 0;
									
									// Reduce the BS/WS on the operative's weapons (lower BS/WS is better)
									// This does NOT apply to Pathfinder Assault Grenadiers
									if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')) {
										for (let i = 0; i < op.weapons.length; i++) {
											let wep = op.weapons[i];
											for (let j = 0; j < wep.profiles.length; j++) {
												wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "1");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "2");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "3");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "4");
												wep.profiles[j].BS = wep.profiles[j].BS.replace("6", "5");
											}
										}
										
										for (let i = 0; i < op.equipments.length; i++) {
											let eq = op.equipments[i];
											if (eq.eqtype == 'Weapon' && eq.weapon != null) {
												let wep = eq.weapon;
												for (let j = 0; j < wep.profiles.length; j++) {
													wep.profiles[j].BS = wep.profiles[j].BS.replace("2", "1");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("3", "2");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("4", "3");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("5", "4");
													wep.profiles[j].BS = wep.profiles[j].BS.replace("6", "5");
												}
											}
										}
									}
									
									// Increase the M on the operative
									op.M = op.M.replace("5" + $scope.PlaceHolders["[CIRCLE]"], "6" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("4" + $scope.PlaceHolders["[CIRCLE]"], "5" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("3" + $scope.PlaceHolders["[CIRCLE]"], "4" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("2" + $scope.PlaceHolders["[CIRCLE]"], "3" + $scope.PlaceHolders["[CIRCLE]"]);
									op.M = op.M.replace("1" + $scope.PlaceHolders["[CIRCLE]"], "2" + $scope.PlaceHolders["[CIRCLE]"]);
								}
							}
							
							// Apply eq mods
							$scope.applyEqMods($scope.dashboardroster);
							
							// Done
							$scope.loading = false;
							$scope.$apply();
						},
						// Failure
						error: function(data, status, error) { // Failed to get rosters
							toast("Could not get rosters: \r\n" + error);
							$scope.loading = false;
							$scope.$apply();
						}
					});
				}
			}
			
			// selectDashboardRoster()
			// Sets the specified roster as the dashboard roster
			$scope.selectDashboardRoster = function(roster) {
				console.log("selectDashboardRoster(" + roster.rosterid + ")");
				//te("dashboard", "selectroster", "", roster.rosterid);
				$scope.dashboardroster = roster;
				$scope.setDashboardRosterId(roster.rosterid);
				
				// Apply eq mods
				$scope.applyEqMods($scope.dashboardroster);
				
				// Check for injured
				//[TBD]
				
				// Parse selected ploys
				console.log("Checking ploys: " + roster.killteam.ploys.strat.length);
				for (let ploynum = 0; ploynum < roster.killteam.ploys.strat.length; ploynum++) {
					let ploy = roster.killteam.ploys.strat[ploynum];
					console.log("Checking ploy " + ploy.ployid + " against " + roster.ployids);
					$scope.toggleStratPloy(roster, ploy, ("," + roster.ployids + ",").includes("," + ploy.ployid + ","));
				}
			}
			
			// Pop-up the roster operative selection modal
			$scope.initSelectRosterOps = function(roster) {
				$scope.selectrosterops = roster;
				
				// Show the modal
				$('#selectrosteropsmodal').modal("show");
			}
			
			$scope.resetOperativeToBase = function(op) {
				op.M   = op.baseoperative.M;
				op.APL = op.baseoperative.APL;
				op.GA  = op.baseoperative.GA;
				op.DF  = op.baseoperative.DF;
				op.SV  = op.baseoperative.SV;
				op.W   = op.baseoperative.W;
				
				// Reset this operative's Abilities and Unique Actions
				op.abilities = JSON.parse(JSON.stringify(op.baseoperative.abilities));
				op.uniqueactions = JSON.parse(JSON.stringify(op.baseoperative.uniqueactions));
				
				// Reset this operative's weapons to their base definitions
				//console.log("   Resetting weapons");
				op.weapons = [];
				let wepids = op.wepids.split(",");
				for (let opwepidnum = 0; opwepidnum < wepids.length; opwepidnum++) {
					let wepid = wepids[opwepidnum];
					
					// Find this weapon in the base operative's weapons
					for (let baseopwepnum = 0; baseopwepnum < op.baseoperative.weapons.length; baseopwepnum++) {
						let baseopwep = op.baseoperative.weapons[baseopwepnum];
						if (baseopwep.wepid == wepid) {
							// Found the weapon, reset its stats
							////console.log("      Resetting weapon to base stats");
							opwep = JSON.parse(JSON.stringify(baseopwep));
							op.weapons.push(opwep);
						}
					}
				}
			}
			
			// resetDash()
			// Resets the dashboard, returning scores to their default values and resetting operative wounds/curw
			$scope.resetDash = function(roster) {
				//te("dashboard", "reset", "", roster.rosterid);
				
				// Update local roster
				roster.CP = parseInt($scope.settings["startcp"]);
				roster.VP = parseInt($scope.settings["startvp"]);
				roster.TP = 1;
				roster.RP = 0;
				
				if ($scope.RPLabels[roster.factionid] && $scope.RPLabels[roster.factionid][roster.killteamid] && $scope.RPLabels[roster.factionid][roster.killteamid].StartValue > 0) {
					roster.RP = $scope.RPLabels[roster.factionid][roster.killteamid].StartValue;
				}
				
				$scope.applyEqMods(roster);
				
				// Push local roster to DB/API
				$scope.commitRoster(roster);
				
				// Reset operatives (not injured)
				for (let i = 0; i < roster.operatives.length; i++) {
					let op = roster.operatives[i];
					
					// Reset their Wounds
					op.curW = parseInt(op.W);
					
					// Not activated - Must be an INT to save properly in DB
					op.activated = 0;
					
					// Set their order to user's default
					op.oporder = $scope.settings["defaultoporder"];
					
					// Not injured
					op.isinjured = 0;
					
					$scope.commitRosterOp(op);
				}
				
				// Deactivate Strategic Ploys
				for (let i = 0; i < $scope.dashboardroster.killteam.ploys.strat.length; i++) {
					let p = $scope.dashboardroster.killteam.ploys.strat[i];
					p.active = false;
					$scope.toggleStratPloy($scope.dashboardroster, p, false);
				}
				
				toast('Dashboard Reset');
			}
		
			$scope.updateCP = function(inc, roster) {
				//te("dashboard", "CP", "inc", roster.rosterid, inc);
				roster.CP += inc;
				if (roster.CP < 0) {
					roster.CP = 0;
				}
				$scope.commitRoster(roster);
			}
			
			$scope.updateVP = function(inc, roster) {
				//te("dashboard", "VP", "inc", roster.rosterid, inc);
				roster.VP += inc;
				if (roster.VP < 0) {
					roster.VP = 0;
				}
				$scope.commitRoster(roster);
			}
			
			$scope.updateTP = function(inc, roster) {
				//te("dashboard", "TP", "inc", roster.rosterid, inc);
				roster.TP += inc;
				if (roster.TP < 1) {
					roster.TP = 1;
				}
				
				if (inc == 1) {
					// Next Turning Point
					
					// Update CP if setting is enabled
					if ($scope.settings["autoinccp"] == "y") {
						roster.CP += 1;
					}
					
					//// Push local roster to DB/API
					//$scope.commitRoster(roster);
					
					// Reset operatives (not injured, not activated)
					for (let i = 0; i < roster.operatives.length; i++) {
						let op = roster.operatives[i];
						op.activated = 0;
						$scope.commitRosterOp(op);
					}
					
					// Deactivate previous TP's Strategic Ploys
					for (let i = 0; i < $scope.dashboardroster.killteam.ploys.strat.length; i++) {
						let p = $scope.dashboardroster.killteam.ploys.strat[i];
						p.active = false;
						$scope.toggleStratPloy($scope.dashboardroster, p, false);
					}
				}
				
				$scope.commitRoster(roster);
			}
		
			// Increment Resource Points (e.g. Faith Points for Novitiates)
			$scope.updateRP = function(inc, roster)  {
				//te("dashboard", "RP", "inc", roster.rosterid, inc);
				roster.RP += inc;
				if (roster.RP < 1) {
					roster.RP = 0;
				}
				$scope.commitRoster(roster);
			}
			
			// toggleStratPloy()
			// Activates or deactivates the specified strategic ploy on the dashboardroster
			$scope.toggleStratPloy = function(roster, ploy, active) {
				ploy.active = active;
				
				let origployids = roster.ployids;
				
				console.log("toggleStratPloy(" + roster.rosterid + ", " + ploy.ployid + ", " + active + ")");
				
				// Make sure it's not null
				if (roster.ployids == null) {
					roster.ployids = "";
				}
					
				if (active) {
					// Add this ploy to the roster
					if (!roster.ployids.includes(ploy.ployid)) {
						if (roster.ployids.length > 0) {
							roster.ployids += ",";
						}
						roster.ployids += ploy.ployid;
					}
					
					// Add this ploy to each operative in the roster
					for (let opnum = 0; opnum < roster.operatives.length; opnum++) {
						let op = roster.operatives[opnum];
						let ab = {
							title: "[SP] " + ploy.ployname,
							description: "<em>Strategic Ploy<br/></em>" + ploy.description
						};
						op.abilities.push(ab);
					}
				} else {
					// Remove this ploy from the roster
					roster.ployids = roster.ployids.replace(ploy.ployid + ",", "").replace("," + ploy.ployid, "").replace(ploy.ployid, "");
					
					// Remove this ploy from each operative in the roster
					for (let opnum = 0; opnum < roster.operatives.length; opnum++) {
						let op = roster.operatives[opnum];
						for (let abnum = op.abilities.length - 1; abnum >= 0; abnum--) {
							let ab = op.abilities[abnum];
							if (ab.title == "[SP] " + ploy.ployname) {
								// This is the ploy to deactivate - Remove it from the operative's abilities
								op.abilities.splice(abnum, 1);
							}
						}
					}
				}
				
				// Clean up the roster's ployids
				// Remove double commas
				roster.ployids = roster.ployids.replace(",,", ",");
				if (roster.ployids[roster.ployids.length - 1] == ",") {
					// Remove trailing comma
					roster.ployids = roster.ployids.substring(0, roster.ployids.length - 2);
				}
				if (roster.ployids == ",") {
					// Remove solo comma
					roster.ployids = "";
				}
				
				// Now push this change to the API to make it persistent
				if (roster.ployids != origployids) {
					$scope.commitRoster(roster);
				}
			}
		
			// setOperativeOrder()
			// Sets the specified operative's order and commits the operative.
			// If the specified operative does not belong to the current user, this method does nothing.
			$scope.setOperativeOrder = function(operative, order) {
				if (operative.userid == $scope.currentuser.userid) {
					operative.oporder = order;
					$scope.commitRosterOp(operative);
				}
			}

			// activateTacOp()
			$scope.activateTacOp = function(roster, tacop, activate) {
				if (activate) {
					// Activate this tacop for this roster
					let rto = {
						userid: roster.userid,
						rosterid: roster.rosterid,
						tacopid: tacop.tacopid,
						revealed: 0,
						VP1: 0,
						VP2: 0
					}

					// Send a POST request to the API
					$.ajax({
						type: "POST",
						url: APIURL + "rostertacop.php",
						timeout: APITimeout,
						async: true,
						dataType: 'json',
						data: JSON.stringify(rto),
						
						// Success
						success: function(data) {
							// Got it, all good
							tacop.active = 1;
							tacop.revealed = 0;
							tacop.VP1 = 0;
							tacop.VP2 = 0;

							$scope.$apply();
						},
						error: function(data, status, error)  {
							// Failed
							toast("Error activating TacOp:\r\n" + error);
						}
					});
				} else {
					// Deactivate this tacop for this roster
					let rto = {
						userid: roster.userid,
						rosterid: roster.rosterid,
						tacopid: tacop.tacopid
					}

					// Send a DELETE request to the API
					$.ajax({
						type: "DELETE",
						url: APIURL + "rostertacop.php",
						timeout: APITimeout,
						async: true,
						dataType: 'text',
						data: JSON.stringify(rto),
						
						// Success
						success: function(data) {
							// Got it, all good
							tacop.active = 0;
							tacop.revealed = 0;
							tacop.VP1 = 0;
							tacop.VP2 = 0;
						},
						error: function(data, status, error)  {
							// Failed
							toast("Error deactivating TacOp:\r\n" + error);
							console.log("Error deactivating TacOp: " + error);
						}
					});
				}
			}

			// revealTacOp()
			$scope.revealTacOp = function(roster, tacop, reveal) {
				// Reveal this tacop
				let rto = {
					userid: roster.userid,
					rosterid: roster.rosterid,
					tacopid: tacop.tacopid,
					revealed: tacop.revealed ? 1 : 0,
					VP1: tacop.VP1,
					VP2: tacop.VP2
				}

				// Send a POST request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "rostertacop.php",
					timeout: APITimeout,
					async: true,
					dataType: 'json',
					data: JSON.stringify(rto),
					
					// Success
					success: function(data) {
						// Got it, all good
						tacop.revealed = reveal;
					},
					error: function(error) {
						// Failed
						toast("Error revealing TacOp:\r\n" + error);
					}
				});
			}

			// setTacOpScore()
			$scope.setTacOpScore = function(roster, tacop, vp1, vp2) {
				console.log("setTacOpScore(" + vp1 + ", " + vp2 + ")");

				// Set the score for this tacop
				let rto = {
					userid: roster.userid,
					rosterid: roster.rosterid,
					tacopid: tacop.tacopid,
					revealed: tacop.revealed ? 1 : 0,
					VP1: vp1,
					VP2: vp2
				}

				// Send a POST request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "rostertacop.php",
					timeout: APITimeout,
					async: true,
					dataType: 'text',
					data: JSON.stringify(rto),
					
					// Success
					success: function(data) {
						// Got it, all good
						tacop.VP1 = vp1;
						tacop.VP2 = vp2;
					},
					error: function(error) {
						// Failed
						toast("Error scopring TacOp:\r\n" + error);
					}
				});
			}
		}
		
		// HELPERS
		{
			$scope.PlaceHolders = {
				"[TRI]": "<span class='material-symbols-outlined'>change_history</span>",
				"[CIRCLE]": "<span class='material-symbols-outlined'>radio_button_unchecked</span>",
				"[SQUARE]": "<span class='material-symbols-outlined'>crop_square</span>",
				"[PENT]": "<span class='material-symbols-outlined'>pentagon</span>"
			}
			
			$scope.RevPlaceHolders = {
				"<span class='material-symbols-outlined'>change_history</span>": "[TRI]",
				"<span class='material-symbols-outlined'>radio_button_unchecked</span>": "[CIRCLE]",
				"<span class='material-symbols-outlined'>crop_square</span>": "[SQUARE]",
				"<span class='material-symbols-outlined'>pentagon</span>": "[PENT]"
			}
			
			$scope.replacePlaceholders_Old = function(input) {
				if ($scope.currentuser && $scope.currentuser.userid == 'vince') {
					// Testing new approach for symbols
					return $scope.replacePlaceholders2(input);
				} else {
					// Basic text/string replace for symbols
					return input
						.replace(/\[TRI\]/g, "&#x25B2;")
						.replace(/\[CIRCLE\]/g, "&#x2B24;")
						.replace(/\[SQUARE\]/g, "&#9632;")
						.replace(/\[PENT\]/g, "&#x2B1F;");
				}
			}
			
			// Using Material fonts from Google
			$scope.replacePlaceholders = function(input) {
				for (let key in $scope.PlaceHolders) {
					let keyTemp = key;
					keyTemp = "/" + keyTemp.replace("[", "\[").replace("]", "\]") + "/g";
					input = input.replaceAll(key, $scope.PlaceHolders[key]);
				}
				
				return input;
			}
			
			// getShortId()
			// Returns a short ID to use in the DB
			$scope.getShortId = function() {
				// Get a new short ID
				var id = "";
				$.ajax({
					type: "GET",
					url: APIURL + "id.php",
					timeout: APITimeout,
					async: false,
					dataType: 'text',
					
					// Success
					success: function(data) {
						id = data;
					},
					
					// Failure
					error: function(error) {
						id = error;
					}
				});
				
				// Done
				return id.trim();
			}
			
			// showPopup()
			// Shows a popup modal with the specified title and message
			$scope.showpopup = function(title, message) {
				//console.log("Showing popup " + title);
				$scope.popup = {
					"title": title,
					"text": message
				}
				
				$("#popupmodal").modal("show");
			}
			
			$scope.showPhoto = function(title, photourl) {
				$scope.imagepopup = {
					"title": title,
					"image": photourl + "#" + (new Date()).getTime()
				}
				
				$("#imagemodal").modal("show");
			}
			
			// toggleDisplay()
			// Toggles the display of the element with the specified ID
			$scope.toggleDisplay = function(eid) {
				$(eid).toggle();
			}
			
			// initwepsr()
			// Shows a popup modal for the specified weapon and profile
			$scope.initwepsr = function(edition, weapon, profile) {
				$scope.wepsr = weapon;
				$scope.wepsr.profile = profile;
				
				// Now parse the weapon's special rules
				$scope.wepsr.rules = [];
				let weprules = profile.SR.split(",");
				for (let i = 0; i < weprules.length; i++) {
					let rule = {
						"rulename": weprules[i].trim(),
						"ruletext": weprules[i].trim()
					}
					
					if (rule.rulename.startsWith("*")) {
						// One-off special weapon rules (e.g. "*Detonate" or "*Custom"); skip these in the popup.
						// Their description should be in the operative's abilities.
						rule.ruletext = "(see Abilities)";
					}
					else 
					{
						let rulename = weprules[i].trim().toUpperCase();
						switch (rulename) {
							case "BARRAGE":
								rule.ruletext = "Cover is measured from above";
								break;
							case "BAL":
							case "BALANCED":
								rule.rulename = "Balanced";
								rule.ruletext = "Can re-roll one Attack die";
								break;
							case "BOMB SQUIG":
								rule.ruletext = "This operative can perform a Shoot action with this weapon if it is within Engagement Range of an enemy operative. When this operative performs a Shoot action and selects this ranged weapon, make a shooting attack against each other operative within its Engagement Range - Each of them is a valid target and cannot be in Cover. After all of those shooting attacks have been made, this operative is incapacitated and do not roll for its BOOM! ability. This operative cannot make a shooting attack with this weapon by performing an Overwatch action.";
								break;
							case "BRUTAL":
								rule.ruletext = "Opponent can only parry with critical hits";
								break;
							case "CEASELESS":
								switch (edition) {
									case 'kt21':
										rule.ruletext = "Can re-roll any or all results of 1";
										break;
									case 'kt24':
										rule.ruletext = "Can re-roll any or all results of one value (e.g. all results of 2)";
										break;
								}
								break;
							case "COMBI-DWBG":
								rule.ruletext = "Can be combined with a DeathWatch Boltgun";
								break;
							case "COMBI-BOLTGUN":
								rule.ruletext = "Can be combined with a Boltgun";
								break;
							case "DAEMONIC ENERGIES":
								rule.ruletext = "Each time this operative fights in combat, in the Roll Attack Dice step of that combat, each time you retain a critical hit, the target suffers 2 Mortal Wounds.";
								break;
							case "DETONATE":
								rule.ruletext = "Each time this operative makes a Shoot action using its remote mine, make a shooting attack against each operative within " + $scope.PlaceHolders["[CIRCLE]"] + " of the centre of its Mine token with that weapon. When making those shooting attacks, each operative (friendly and enemy) within " + $scope.PlaceHolders["[CIRCLE]"] + " is a valid target, but when determining if it is in Cover, treat this operative’s Mine token as the active operative. An operative cannot be a valid target if Heavy terrain is wholly intervening (must be able to draw a Cover line from the centre of the Mine token to any part of the intended target’s base without crossing Heavy terrain). Then remove this operative’s Mine token. An operative cannot make a shooting attack with this weapon by performing an Overwatch action, or if its Mine token is not in the killzone.";
								break;
							case "EXPERT RIPOSTE":
								rule.ruletext = "Each time this operative fights in combat using its duelling blades, in the Resolve Successful Hits step of that combat, each time you parry with a critical hit, also inflict damage equal to the weapon's Critical Damage characteristic.";
								break;
							case "FUS":
							case "FUSILLADE":
								rule.rulename = "Fusillade";
								rule.ruletext = "Distribute the Attack dice between valid targets within " + $scope.PlaceHolders["[CIRCLE]"] + " of original target";
								break;
							case "GRAV":
							case "GRAV*":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, if the target has an unmodified Save characteristic of 3+ or better, this weapon has the Lethal 4+ special rule for that attack.";
								break;
							case "HVY": /* TODO: DIFFERENT FOR 24!! */
							case "HEAVY":
								rule.rulename = "Heavy";
								rule.ruletext = "Cannot Shoot in the same activation as Move, Charge, or Fall Back";
								break;
							case "HUMBLING CRUELTY":
								rule.ruletext = "Each time a friendly operative makes a shooting attack with this weapon, in the Resolve Successful hits step of that shooting attack, if the target loses any wounds, the target is injured until the end of the Turning Point";
								break;
							case "HOT":
								switch (edition) {
									case 'kt21':
										rule.ruletext = "For each discarded Attack die result of 1 inflict 3 Mortal Wounds to the bearer";
										break;
									case 'kt24':
										rule.ruletext = "After using this weapon, roll 1D6. If the result is less than the weapon's HIT stat, inflict Damage on that operative equal to the result multiplied by 2. If it is used multiple times in one action (e.g. Blast), roll only 1D6.";
										break;
								}
								break;
							case "IND":
							case "INDIRECT":
								rule.rulename = "Indirect";
								rule.ruletext = "Ignores cover when selecting valid targets. Must still be Visible and not Obscured.";
								break;
							case "LASH WHIP":
								rule.rulename = "Lash Whip";
								rule.ruletext = "While an enemy operative is within Engagement Range of friendly operatives equipped with this weapon, subtract 1 from that enemy operative's Attacks characteristics.";
								break;
							case "NO COVER":
								rule.ruletext = "Target can't retain autosuccess for cover, must roll all Defence dice";
								break;
							case "NOOBS":
							case "NOOBSCURE":
								rule.rulename = "No Obscure";
								rule.ruletext = "Enemy operatives cannot be Obscured.";
								break;
							case "PARRY HOOK":
								rule.ruletext = "Each time a friendly operative fights in combat with this weapon, in the Resolve Successful Hits step of that combat, each time you parry with a normal hit, you can select one of your opponent''s critical hits to be discarded instead.";
								break;
							case "PUN":
							case "PUNISHING":
								rule.ruletext = "If you retain any critical successes, you can retain one of your fails as a normal success instead of discarding it.";
								break;
							case "RELENTLESS":
								rule.ruletext = "Can re-roll any or all Attack dice";
								break;
							case "REND":
							case "RENDING":
								rule.rulename = "Rending";
								rule.ruletext = "If you retain any critical hits, retain 1 normal hit as a critical hit instead.";
								break;
							case "SAT":
							case "SATURATE":
								rule.rulename = "Saturate";
								rule.ruletext = "The defender cannot retain Cover saves."
								break;
							case "SEEK":
								rule.rulename = "Seek";
								rule.ruletext = "When selecting a valid target, operatives cannot use terrain for cover."
								break;
							case "SEEKLT":
							case "SEEKLIGHT":
							case "SEEK LIGHT":
								rule.rulename = "Seek Light";
								rule.ruletext = "When selecting a valid target, operatives cannot use light terrain for cover. While this can allow such operatives to be targeted (assuming they are Visible), it does not remove their Cover save (if any)."
								break;
							case "SEV":
							case "SEVERE":
								rule.rulename = "Severe";
								rule.ruletext = "If you do not retain any critical successes, you can change one of your normal successes to a critical success. Any rules that take effect as a result of retaining a critical success (e.g. Devastating, Piercing Crits, etc.) still do."
								break;
							case "SHOCK":
								rule.rulename = "Shock";
								rule.ruletext = "The first time you strike with a critical success in each sequence, also discard one of your opponent's unresolved normal successes (or a critical success if there are none)."
								break;
							case "SIL":
							case "SILENT":
								rule.rulename = "Silent";
								rule.ruletext = "Can Shoot this weapon while on a Conceal order";
								break;
							case "SIPHON LIFE FORCE":
								rule.ruletext = "Each time a friendly operative makes a shooting attack with this weapon, in the Resolve Successful Hits step of that shooting attack, if you resolve two or more attack dice, you can select one friendly LEGIONARY operative within " + $scope.PlaceHolders["[PENT]"] + " of the target to regain 1D3 lost wounds.";
								break;
							case "SMART TARGETING":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, you can use this special rule. If you do so, for that shooting attack:<br/><li>Enemy operatives with an Engage order that are not within Engagement Range of friendly operatives are valid targets and cannot be in Cover.</li><li>In the Roll Attack Dice step of that shooting attack, attack dice results of 6 are successful normal hits. All other attack dice results are failed hits.</li>";
								break;
							case "STORM SHIELD":
								rule.ruletext = "If this operative is equipped with a storm shield:<ul><li>It has a 4+ Invulnerable Save</li><li>Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent's successful hits are discarded (instead of one).</li></ul>";
								break;
							case "STUN":
								switch (edition) {
									case 'kt21':
										rule.ruletext = "Shooting: If you retain any critical hits, subtract 1 from APL of target<br/>Fighting: First critical strike discard 1 normal hit of the target, Second critical strike subtract 1 from APL of target";
										break;
									case 'kt24':
										rule.ruletext = "If you retain any critical hits, subtract 1 from APL of target until the end of its next activation";
										break;
								}
								break;
							case "UNLOAD SLUGS":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, in the Roll Attack Dice step of that shooting attack, if the target is within " + $scope.PlaceHolders["[PENT]"] + " of it, you can re-roll any or all of your attack dice.";
								break;
							case "UNWIELDY":
								rule.ruletext = "Shooting costs +1 AP, no Overwatch";
								break;
							case "VICIOUS BLOWS":
								rule.ruletext = "Each time this operative fights in combat:<ul><li>If this operative is the Attacker, this weapon gains the Ceaseless special rule for that combat</li><li>If this operative performed a Charge action during this activation, this weapon gains the Relentless special rule for that combat</li></ul>";
								break;
						}
						
						// Other cases
						// KT2024
						if (rulename.startsWith("ACC")) {
							let num = rulename.replace("ACC", "");
							rule.rulename = "Accurate " + num;
							rule.ruletext = "You can retain up to " + num + " Attack Dice as normal successes without rolling them.";
						} else if (rulename.startsWith("HVY") && rulename.length > 3) {
							let sp = rulename.replace("HVY", "");
							rule.rulename = "Heavy " + sp;
							rule.ruletext = "An operative cannot use this weapon in an activation in which it moved, and it cannot move in an activation in which it used this weapon. This rule has no effect on preventing the Guard action.";
							if (sp != "") {
								sp = sp.replace("(REPONLY)", "Reposition");
								sp = sp.replace("(DASHONLY)", "Dash");
								rule.ruletext += "<br/>Only the " + sp + " action is allowed."
							}
						} else if (rulename.startsWith("PRCCRIT")) {
							let num = rulename.replace("PRCCRIT", "");
							rule.rulename = "Piercing Crits " + num;
							rule.ruletext = "If you retain any critical successes, the defender collects " + num + " less Defence dice.";
						} else if (rulename.startsWith("PRC")) {
							let num = rulename.replace("PRC", "");
							rule.rulename = "Piercing " + num;
							rule.ruletext = "The defender collects " + num + " less Defence dice.";
						} else if (rulename.indexOf("DEV") > -1) {
							let rng = rulename.split("D")[0];
							let dam = rulename.split("V")[1];
							rule.rulename = rng + "Devastating " + dam;
							if (rng != "") {
								rule.ruletext = "Each retained critical success immediately inflicts " + dam + " damage on the operative this weapon is being used against and each other operative Visible To and within " + rng + " of it. Note that success isn't discarded after doing so - it can still be resolved later in the sequence.";
							} else {
								rule.ruletext = "Each retained critical success immediately inflicts " + dam + " damage on the operative this weapon is being used against.";
							}
						} else if (rulename.startsWith("LIM")) {
							let num = rulename.replace("LIMITED", "").replace("LIM", "");
							if (num == "") {
								num = 1;
							}
							rule.rulename = "Limited " + num;
							rule.ruletext = "After an operative uses this weapon " + num + " times, they no longer have it. If it is used multiple times in one action (e.g. Blast) treat this as one use.";
						}
						// KT2021
						if (rulename.startsWith("AP")) {
							let num = rulename.replace("AP", "");
							rule.ruletext = "Remove " + num + " Defence dice from target before roll. Multiple APs do not stack.";
						} else if (rulename.startsWith("BLAST")) {
							let range = rulename.replace("BLAST", "").toLowerCase();
							rule.ruletext = "Each time this weapon is fired, after making the attack against the target, make a shooting attack against each other operative Visible To and within " + range + " of the original target. Each of them is a valid target and cannot be in Cover.";
							if (edition != 'kt24') {
								rule.ruletext += "<br/>An operative cannot make a shooting attack with this weapon by performing an Overwatch action.";
							} 
						} else if (rulename.startsWith("INFERNO")) {
							let num = rulename.replace("INFERNO", "");
							rule.ruletext = "Each time a friendly operative fights in combat or makes a shooting attack with this weapon, in the Roll Attack Dice step of that combat or shooting attack, if you retain any critical hits, the target gains " + num + " Inferno tokens. At the end of each Turning Point, roll one D6 for each Inferno token an enemy operative has: on a 4+, that enemy operative suffers 1 mortal wound. After rolling, remove all Inferno tokens that operative has.";
						} else if (rulename.startsWith("LETHAL") && rulename.endsWith("(CQ)")) {
							let num = rulename.replace("LETHAL", "");
							rule.ruletext = "Close Quarters: Inflict critical hits on 5+ instead of 6+";
						} else if (rulename.startsWith("LETHAL")) {
							let num = rulename.replace("LETHAL", "");
							rule.ruletext = "Inflict critical hits on " + num + " instead of 6+";
						} else if (rulename.startsWith("MW")) {
							let num = rulename.replace("MW", "");
							rule.ruletext = "For each critical hit retained, inflict " + num + " Mortal Wounds to target";
						} else if (rulename.startsWith("P") && rulename.length == 2) {
							let num = rulename.replace("P", "");
							rule.ruletext = "Weapon gains AP" + num + " rule if you retain a critical hit";
						} else if (rulename.startsWith("REAP")) {
							let num = rulename.replace("REAP", "");
							rule.ruletext = "For each successful critical strike, inflict MW" + num + " on each other enemy within " + $scope.PlaceHolders["[TRI]"] + " of the operative using this weapon or the original target.";
						} else if (rulename.startsWith("RNG")) {
							let range = rulename.replace("RNG", "");
							rule.rulename = rule.rulename.replace("Rng", "Range");
							rule.ruletext = "Range limit of the weapon";
						} else if (rulename.startsWith("SPLASH")) {
							let num = rulename.replace("SPLASH", "");
							rule.ruletext = "For each critical hit, inflict MW" + num + " to the target and any other operative within " + $scope.PlaceHolders["[CIRCLE]"] + " of the target";
						} else if (rulename.startsWith("TOR")) {
							let range = rulename.replace("TORRENT", "");
							range = rulename.replace("TOR", "").toLowerCase();
							rule.rulename = "Torrent " + range;
							switch (edition) {
								case 'kt21':
									rule.ruletext = "Each time a friendly operative performs a Shoot action or Overwatch action and selects this weapon, after making the shooting attack against the target, it can make a shooting attack with this weapon against each other valid target within " + range + " of the original target and each other.";
									break;
								case 'kt24':
									rule.ruletext = "Each time a friendly operative performs a Shoot action or Overwatch action and selects this weapon, after making the shooting attack against the target, it can make a shooting attack with this weapon against each other valid target within " + range + " of the original target.";
									break;
							}
						}
					}
						
					// Add this rule
					$scope.wepsr.rules.push(rule);
				}
				
				// Now show the popup
				$("#wepsrmodal").modal("show");
			}
		
			// Init name generator
			$scope.generatenametype = "HUMAN-M";
			$scope.generatedname = "";
			
			// generatename()
			// Generates a name for the name type
			$scope.generatename = function() {
				var url = APIURL + "name.php?nametype=" + $scope.generatenametype;
				$.ajax({
					type: "GET",
					url: url,
					timeout: APITimeout,
					async: true,
					dataType: 'text',
					success: function(data) {
						$scope.generatedname = data.replace(/[\n\r]/g, '');;
						
						$scope.$apply();
					}
				});
			}
		
			// getKillTeamComp()
			// Returns an HTML string with the specified kill team's composition,
			// including fire team compositions where needed
			$scope.getKillTeamComp = function(killteam) {
				let out = "";
				out = "<h2>" + killteam.killteamname + "</h2>" + killteam.killteamcomp;
				
				if (killteam.fireteams.length > 1) {
					for (let i = 0; i < killteam.fireteams.length; i++) {
						let ft = killteam.fireteams[i];
						
						if (ft.fireteamcomp != '' && ft.fireteamcomp != killteam.killteamcomp) {
							out += "<hr/><h5>Fireteam: " + ft.fireteamname + "</h5>" + ft.fireteamcomp;
						}
					}
				}
				
				// Done
				return out;
			}
		}

		// Always check if the user's current browser supports native sharing
		$scope.canshare = navigator.canShare;
			
		// Always initialize the session
		$scope.initSession();
	}
);
