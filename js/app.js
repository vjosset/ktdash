const APIURL = "/api/";

var app = angular.module("kt", ['ngSanitize'])
	// Controller for main app/pages
	.controller("ktCtrl", function($scope, $rootScope) {
		// GLOBAL
		{
			$scope.loading = false;
			$scope.MODE = "";
			
			setInterval(function() {
				// Set tagged links to show the loader on click
				$(".navloader").on("click", function(){ toast("Loading..."); });
			}, 500);
			
			// Settings - All always lowercase (key and value)
			$scope.settings = {
				display: 'card',
				showopseq: 'n',
				startvp: 2,
				startcp: 2
			};
			
			$scope.loadSettings = function() {
				let settingsJson = localStorage.getItem("settings");
				if (settingsJson != "" && settingsJson != null) {
					$scope.settings = JSON.parse(settingsJson.toLowerCase());
				} else {
					// No settings yet, fill in defaults
					$scope.setSetting("display", "card");
					$scope.setSetting("showopseq", "n");
					$scope.setSetting("startvp", "2");
					$scope.setSetting("startcp", "2");
				}
				
				// Set default settings
				if (!$scope.settings["display"]) {
					$scope.setSetting("display", "card");
				}
				if (!$scope.settings["showopseq"]) {
					$scope.setSetting("showopseq", "n");
				}
				if (!$scope.settings["startvp"]) {
					$scope.setSetting("startvp", "2");
				}
				if (!$scope.settings["startcp"]) {
					$scope.setSetting("startcp", "2");
				}
			}
			
			$scope.saveSettings = function() {
				let settingsJson = JSON.stringify($scope.settings).toLowerCase();
				localStorage.setItem("settings", settingsJson);
			}
			
			$scope.setSetting = function(key, value) {
				$scope.settings[key] = value;
				te('settings', 'set', key, value);
				$scope.saveSettings();
			}
			
			$scope.loadSettings();
			
			// Reference to utils.js "te()"
			$scope.te = function(t = '', a = '', l = '', v1 = '', v2 = '', v3 = '') {
				te(t, a, l, v1, v2, v3);
			}
			
			// initHome()
			// Home page load
			$scope.initHome = function() {
				if ($scope.currentuser != null) {
					// Get the user's rosters
					$.ajax({
						type: "GET",
						url: APIURL + "roster.php?uid=" + $scope.currentuser.userid,
						timeout: 5000,
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
			}
		}
		
		// SESSION & LOG IN
		{
			$scope.currentuser = null;
			$scope.loginForm = { "userName": "", "password": ""};
			
			// initSession()
			// Gets the user's current session (if any).
			// If found, sets $scope.currentuser to the user's info.
			$scope.initSession = function() {
				// Get the current session for this user (session ID stored in cookie)
				// Start at each page load
				
				// Get the current user's session and set $scope.currentuser
				$.ajax({
					type: "GET",
					url: APIURL + "session.php",
					timeout: 5000,
					// This call is NOT async so we can use this method to redirect the user for pages that require a session
					async: false,
					dataType: 'json',
					
					// Success
					success: function(data) {
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.currentuser = data;
					},
					
					// Failure
					error: function() {
						$scope.currentuser = null;
					}
				});
			}
			
			// initLogin()
			// Initializes the login form, redirecting the user to "My Rosterss" if they're already logged in.
			// Redirects the user to the page in QueryString "ru" if logged in successfully.
			$scope.initLogin = function() {
				// Check if user is already logged in
				if ($scope.currentuser != null) {
					// Already logged in - Send user to "My Rosters"
					window.location.href = "/rosters.php";
				}
				
				$scope.loading = false;
				var ru = GetQS("ru");
				if (ru == "" || ru == null) {
					// No redirect URL defined, use default
					ru = "/rosters.php";
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
					timeout: 5000,
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
							$scope.loginForm.redirectUrl = "/rosters.php";
						}
						te("session", "login");
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
						te("session", "logout");
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
					window.location.href = "/rosters.php";
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
					timeout: 5000,
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
							timeout: 5000,
							async: true,
							
							// Success
							success: function(data) { // Saved
								// Send the user to "My Rosters"
								window.location.href = "/rosters.php";
							},
							// Failure
							error: function(data, status, error) { // Failed to import sample roster
								// Still send the user to "My Rosters"
								window.location.href = "/rosters.php";
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
							timeout: 5000,
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
								timeout: 5000,
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
					
					console.log(msg);
					
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
							timeout: 5000,
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
								timeout: 5000,
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
					
					te("roster", "importv1");
					
					// All done, reload the page so the user can see their newly-imported teams
					$scope.loading = false;
					toast("Loading...");
					window.location.reload();
				}
			}
			
			// initRosters()
			// Initializes the "My Rosters" page
			$scope.initRosters = function(uid) {
				te("rosters", "view", "", uid);
				$scope.loading = true;
				
				let isMe = ($scope.currentuser != null && uid == $scope.currentuser.userid);
				
				if (isMe) {
					$scope.MODE = "MyRosters";
				} else {
					$scope.MODE = "Rosters";
				}
				
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
					
					// Get the user's rosters
					$.ajax({
						type: "GET",
						url: APIURL + "roster.php?uid=" + uid,
						timeout: 5000,
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
			}
			
			// initRosterGallery()
			// Initializes the "Roster Gallery" page - Landing page for a single roster			
			$scope.initRosterGallery = function(rid) {
				te("roster", "gallery", "", rid);
				$scope.initRoster(rid, true);
			}
			
			$scope.initPrintRoster = function(rid) {
				te("roster", "print", "roster", rid);
				$scope.initRoster(rid, true, window.print);
			}
			
			$scope.printroster = function(roster) {
				te("roster", "print", "roster", roster.rosterid);
				window.open('https://indocpdf.com/api/pdfrender.php?apikey=D7C57EED-CCE5-4EB7-A6DA-BF6D0E724366&showbackground=false&filename=' + roster.rostername + '.pdf&url=https%3A%2F%2Fktdash.app/printroster.php%3Frid=' + roster.rosterid);
			}
			
			$scope.printroster = function(roster) {
				te("roster", "print", "roster", roster.rosterid);
				window.open('https://indocpdf.com/api/pdfrender.php?apikey=D7C57EED-CCE5-4EB7-A6DA-BF6D0E724366&showbackground=false&filename=' + roster.rostername + '.pdf&url=https%3A%2F%2Fktdash.app/printroster.php%3Frid=' + roster.rosterid);
			}
			
			// initRoster()
			// Initializes the "My Roster" page - Landing page for a single roster
			$scope.initRoster = function(rid, skipte, s) {
				if (!skipte) {
					te("roster", "view", "", rid);
				}
				$scope.loading = true;
				$scope.MODE = "Roster";
				
				$.ajax({
					type: "GET",
					url: APIURL + "roster.php?rid=" + rid,
					timeout: 5000,
					async: true,
					dataType: 'json',
					
					// Success
					success: function(data) { // Got the roster
						// Load the roster into "myRoster"
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.myRoster = data;
				
						if ($scope.currentuser != null && data.userid == $scope.currentuser.userid) {
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
								timeout: 5000,
								async: false,
								dataType: 'json',
								success: function(data) {
									// Got it
									$scope.myRoster.killteam = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
								},
								error: function(error) {
									// Failed to save roster
									toast("Could not get killteam: " + error);
									$scope.$apply();
								}
							});
						}
						
						$scope.loading = false;
						$scope.$apply();
						
						if (s) {
							setTimeout(s, 200);
						}
					},
					// Failure
					error: function(data, status, error) { // Failed to get roster
						toast("Could not get roster: \r\n" + error);
						$scope.loading = false;
						$scope.$apply();
					}
				});
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
				te("roster", "delete", "", $scope.deleteRoster.rosterid);
				// Send the delete request to the API
				$.ajax({
					type: "DELETE",
					url: APIURL + "roster.php?rid=" + $scope.deleteRoster.rosterid,
					timeout: 5000,
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
				
							$scope.$apply();
						} else {
							// We're not on the "Rosters" page, so send them there
							window.location.href = "/rosters.php";
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
					url: APIURL + "faction.php?loadkts=1",
					timeout: 5000,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Got factions
						$scope.factions = data;
						$scope.$apply();
					},
					error: function(error) {
						// Failed to get factions
						toast("Could not get factions: " + error);
						$scope.$apply();
					}
				});
				
				// Ready to initialize the new roster popup
				$scope.newroster = {
					"factionid": "",
					"killteamid": "",
					"rostername": "",
					"faction": null,
					"killteam": null
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
					timeout: 5000,
					async: true,
					dataType: 'json',
					data: JSON.stringify(roster),
					success: function(data) {
						toast("Roster " + roster.rostername + " saved!");
						
						te("roster", "create", "", data.rosterid);
						
						// Send the user to their new roster
						window.location.href = "/roster.php?rid=" + data.rosterid;
					},
					error: function(error) {
						// Failed to save roster
						toast("Could not save roster: \r\n" + error);
						$scope.$apply();
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
						timeout: 5000,
						async: true,
						dataType: "text",
						
						// Success
						success: function(data) { // Saved
							// Done
							$scope.$apply();
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
					"RP": roster.RP
				};
				
				// Send the update request to the API
				$.ajax({
					type: "POST",
					url: APIURL + "roster.php",
					timeout: 5000,
					async: true,
					dataType: 'json',
					data: JSON.stringify(data),
					
					// Success
					success: function(data) { // Saved
						// All good
						roster = data;
						
						// Done
						$scope.$apply();
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
						te("roster", "clone", "", roster.userid, roster.rosterid);	
					} else {
						// This is a user importing someone else's roster
						te("roster", "import", "", roster.userid, roster.rosterid);
					}
					toast("Copying team " + roster.rostername + "...");
					
					// Send the POST request to the API
					$.ajax({
						type: "POST",
						url: APIURL + "roster.php?rid=" + roster.rosterid + "&clone=1",
						timeout: 5000,
						async: true,
						
						// Success
						success: function(data) { // Saved
							// All good
							roster = data;
							
							// Send the user to their newly-cloned team
							toast("Team copied - Redirecting...");
							location.href = "/roster.php?rid=" + roster.rosterid;
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
				console.log("initEditRoster(" + roster.rostername + ")");
				$scope.rostertoedit = roster;
				$scope.rostertoedit.newrostername =  roster.rostername;
				$scope.rostertoedit.newnotes =  roster.notes;
				
				// Show the modal
				$('#editrostermodal').modal("show");
			}
			
			// saveEditRoster()
			// Save roster edits
			$scope.saveEditRoster = function() {
				te("roster", "edit", "", $scope.rostertoedit.rosterid);
				$scope.rostertoedit.rostername = $scope.rostertoedit.newrostername;
				$scope.rostertoedit.notes = $scope.rostertoedit.newnotes;
				delete $scope.rostertoedit.newrostername;
				delete $scope.rostertoedit.newnotes;
				
				// Commit to API/DB
				$scope.commitRoster($scope.rostertoedit);
				
				// Close the modal
				$('#editrostermodal').modal("hide");
				
				$scope.$apply();
			}
		
			// initUploadRosterPortrait()
			// Pops-up the portrait uploader for the specified roster
			$scope.initUploadRosterPortrait = function(roster) {
				console.log("initUploadRosterPortrait(" + roster.rosterid + ")");
				$scope.rostertoedit = roster;
				$scope.rostertoedit.timestamp = (new Date()).getTime();
				
				// Reset the file input field
				$("#rosterportraitfile").replaceWith($("#rosterportraitfile").val('').clone(true));
				
				// Show the modal
				$('#rosterportraitmodal').modal("show");
			}
			
			$scope.previewRosterPortrait = function(el) {
				// Refresh the portrait preview box
				console.log("Previewing new portrait");
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
					te("roster", "portrait", "default", $scope.rostertoedit.rosterid);
					// Use the default portrait - Clear this roster's saved portrait from the DB
					imgData = "";
					$.ajax({
						type: "DELETE",
						url: APIURL + "rosterportrait.php?rid=" + $scope.rostertoedit.rosterid,
						timeout: 5000,
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
							te("roster", "portrait", "custom", $scope.rostertoedit.rosterid);

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
				te("roster", "share", "", roster.rosterid);
				$scope.shareroster = roster;
				$scope.shareroster.url = "https://ktdash.app/roster.php?rid=" + roster.rosterid;
				
				// Show the modal
				$('#sharerostermodal').modal("show");
			}
		
			// showShareRosterGallery()
			// Pop-up the "Share Roster Gallery" modal
			$scope.showShareRosterGallery = function(roster) {
				te("roster", "share", "gallery", roster.rosterid);
				$scope.shareroster = roster;
				$scope.shareroster.url = "https://ktdash.app/rostergallery.php?rid=" + roster.rosterid;
				
				// Show the modal
				$('#sharerostergallerymodal').modal("show");
			}
			
			// totalEqPts()
			// Returns the total equipment points for all operatives in the specified roster
			$scope.totalEqPts = function(roster) {
				let total = 0;
				if (roster) {
					for (let i = 0; i < roster.operatives.length; i++) {
						let op = roster.operatives[i];
						for (let j = 0; j < op.equipments.length; j++) {
							total += parseInt(op.equipments[j].eqpts);
						}
					}
				}
				
				// Done
				return total;
			}
		}
		
		// OPERATIVES
		{
			// updateOpW()
			// Increment or decrement the specified operative's wounds
			$scope.updateOpW = function(op, inc) {
				te("dasbhoard", "W", "inc", op.rosteropid, inc);
				op.curW = op.curW + inc;
				if (op.curW < 0) {
					op.curW = 0;
				}
				if (op.curW > parseInt(op.W)) {
					op.curW = parseInt(op.W);
				}
				
				$scope.commitRosterOp(op);
				
				let wasInjured = op.isInjured;
				if (wasInjured == null) {
					wasInjured = false;
				}
				if (op.curW < parseInt(op.W) / 2 && !wasInjured && !(op.factionid == 'CHAOS' && op.killteamid == 'DG')) {
					// Operative is now injured, wasn't injured before (Excludes DeathGuard operatives - Disgustingly Resilient)
					op.isInjured = true;
					
					// Increase the BS/WS on the operative's weapons (lower BS/WS is better)
					// This does NOT apply to Pathfinder Assault Grenadiers
					if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')					) {
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
					}
					
					// Reduce the M on the operative
					op.M = op.M.replace("2&#x2B24;", "1&#x2B24;");
					op.M = op.M.replace("3&#x2B24;", "2&#x2B24;");
					op.M = op.M.replace("4&#x2B24;", "3&#x2B24;");
					op.M = op.M.replace("5&#x2B24;", "4&#x2B24;");
					
				} else if (op.curW >= parseInt(op.W) / 2 && wasInjured) {
					// Operative is no longer injured, was injured before
					op.isInjured = false;
					
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
					}
					
					// Increase the M on the operative
					op.M = op.M.replace("5&#x2B24;", "6&#x2B24;");
					op.M = op.M.replace("4&#x2B24;", "5&#x2B24;");
					op.M = op.M.replace("3&#x2B24;", "4&#x2B24;");
					op.M = op.M.replace("2&#x2B24;", "3&#x2B24;");
					op.M = op.M.replace("1&#x2B24;", "2&#x2B24;");
				}
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
					timeout: 5000,
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
					timeout: 5000,
					async: false,
					datatype: 'json',
					data: JSON.stringify(newop),
					success: function(data) {
						// All good, refresh this team
						$scope.initRoster(newop.rosterid);
						
						te("roster", "addop", "", $scope.myRoster.rosterid, data.rosteropid);
				
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
					timeout: 5000,
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
				var url = APIURL + "name.php?factionid=" + faid + "&killteamid=" + ktid + "&fireteamid=" + ftid + "&opid=" + opid;
				$.ajax({
					type: "GET",
					url: url,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						op[namevar] = data.replace(/[\n\r]/g, '');;
						
						$scope.$apply();
					}
				});
			}
			
			// initDeleteOp()
			// Pops-up the "Delete Operative" modal
			$scope.initDeleteOp = function(op, roster) {
				console.log("initDeleteOperative(" + op.opname + ", " + roster.rostername + ")");
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
				
				$.ajax({
					type: "DELETE",
					url: APIURL + "rosteroperative.php?roid=" + $scope.optodelete.operative.rosteropid,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						// Close the modal
						$('#deleteopmodal').modal("hide");
						
						te("roster", "delop", "", $scope.optodelete.operative.rosterid, $scope.optodelete.operative.rosteropid);
						
						// Reload this roster
						$scope.initRoster($scope.optodelete.roster.rosterid);
						
						// Tell the user their operative has been deleted
						toast("Operative " + $scope.optodelete.operative.opname + " deleted");
					},
					error: function(error) {
						console.log("Could not commit op deletion: " + error);
					}
				});
				
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
				$.ajax({
					type: "POST",
					url: APIURL + "rosteroperative.php",
					timeout: 5000,
					async: false,
					datatype: 'json',
					data: JSON.stringify(newop),
					success: function(data) {
						// All good, refresh this team
						$scope.initRoster(newop.rosterid);
						
						te("roster", "cloneop", "", newop.rosterid, data.rosteropid);
						
						// Tell the user their operative has been added
						toast("Operative " + newop.opname + " added to team!");
					},
					error: function(error) {
						// Failed to save roster
						toast("Could not clone operative: " + error);
					}
				});
			}
			
			// moveOpUp()
			// Moves the specified operative up in the roster (decrease seq)
			$scope.moveOpUp = function(roster, op, index) {
				console.log("moveOpUp(" + roster.rostername + ", " + op.seq + "-" + op.opname + ", " + index + ")");
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
					$.ajax({
						type: "POST",
						url: APIURL + "rosteroperative.php?" + qs,
						timeout: 5000,
						async: true,
						dataType: "text",
						
						// Success
						success: function(data) { // Saved
							// Done
							$scope.$apply();
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not move operative: \r\n" + error);
						}
					});
				}
			}
			
			// moveOpDown()
			// Moves the specified operative down in the roster (increase seq)
			$scope.moveOpDown = function(roster, op, index) {
				console.log("moveOpDown(" + roster.rostername + ", " + op.seq + "-" + op.opname + ", " + index + ")");
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
					eq.isselected = ("," + op.eqids + ",").indexOf("," + eq.eqid + ",") >= 0;
					$scope.tempeditop.equipments.push(eq);
					if (eq.eqtype == 'Weapon') {
						console.log("Found equipment weapon: " + eq.weapon.wepname);
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
					}
				}
				
				// Save all changes
				te("roster", "editop", "", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);
				$scope.commitRosterOp($scope.optoedit);
				
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
				console.log("Previewing new portrait");
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
					te("roster", "opportrait", "default", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);
					
					// Use the default portrait - Clear this operative's saved portrait from the DB
					imgData = "";
					$.ajax({
						type: "DELETE",
						url: APIURL + "operativeportrait.php?roid=" + $scope.optoedit.rosteropid,
						timeout: 5000,
						async: true,
						
						// Success
						success: function(data) { // Saved
							// Hide the modal
							$('#opportraitmodal').modal("hide");
							
							// Reload the operative's portrait
							$scope.refreshOpPortrait($scope.optoedit.rosteropid);
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not remove operative portrait: \r\n" + error);
						}
					});
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
						contentType: false,  // tell jQuery not to set contentType\
						   
						// Success
					    success : function(data) {
							// Hide the modal
							$('#opportraitmodal').modal("hide");
							toast("Operative portrait set!");
							te("roster", "opportrait", "custom", $scope.optoedit.rosterid, $scope.optoedit.rosteropid);

							// Reload the operative's portrait
							$scope.refreshOpPortrait($scope.optoedit.rosteropid);
					    },
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not set operative portrait: \r\n" + error);
						}
					});
				}
			}
		
			// getRosterArchetype()
			// Returns a string representing the archetype for the specified roster, using its operatives' fireteams' archetype
			$scope.getRosterArchetype = function(roster) {
				let rosterArchetype = "";
				if (roster) {
					for (var opnum = 0; opnum < roster.operatives.length; opnum++) {
						let op = roster.operatives[opnum];
						let archetypes = op.archetype.split('/');
						
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
				te("roster", "gettext", "", roster.rosterid);
				let out = "";
				out = "<h6><a href=\"https://ktdash.app/roster.php?rid=" + roster.rosterid + "\">" + roster.rostername + "</a></h6>";
				out += "<a href=\"https://ktdash.app/killteam.php?fa=" + roster.factionid + "&kt=" + roster.killteamid + "\">" + roster.killteam.killteamname + "</a><br/>";
				
				let totalEq = $scope.totalEqPts(roster);
				if (totalEq > 0) {
					out += "Total Equipment Points: " + totalEq + "<br/><br/>";
				}
				
				// out += "<ul>";
				for (let i = 0; i < roster.operatives.length; i++) {
					let op = roster.operatives[i];
					out += (op.seq + 1) + ". " + op.opname + " (" + op.optype + ")<br/>";
					
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
						if (j == 0) {
							out += "<br/>";
						}
						if (j > 0) {
							out += ", ";
						}
						out += eq.eqname + (eq.eqpts > 0 ? " (" + eq.eqpts + " EP)" : "");
					}
					
					out += "<br/><br/>";
				}
				// out += "</ul>";
				
				// Done
				return out;
			}
			
			// initEditOpEq()
			// Pop-up the operative equipment modal
			$scope.initEditOpEq = function(roster, operative) {
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
				te("roster", "print", "op", operative.rosterid, operative.rosteropid);
				window.open('https://indocpdf.com/api/pdfrender.php?apikey=D7C57EED-CCE5-4EB7-A6DA-BF6D0E724366&showbackground=false&filename=' + operative.opname  + '.pdf&url=https%3A%2F%2Fktdash.app/printop.php%3Froid=' + operative.rosteropid);
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
					timeout: 5000,
					async: true,
					
					// Success
					success: function(data) { // Got
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.operative = data;
						
						// Remove baseop for clarity
						delete($scope.operative.baseoperative);
						
						console.log("Got Operative: \r\n" + JSON.stringify($scope.operative));
						
						te("roster", "print", "op", $scope.operative.rosterid, $scope.operative.rosteropid);
						
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
		}
		
		// COMPENDIUM
		{
			// initCompendium()
			// Loads all factions
			$scope.initCompendium = function() {
				te("compendium", "allfactions");
				$scope.loading = true;
				$scope.MODE = "Compendium";
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php",
					timeout: 5000,
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
			
			$scope.initFaction = function() {
				te("compendium", "faction", "", GetQS('fa'));
				$scope.loading = true;
				$scope.MODE = "Compendium";
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php?factionid=" + GetQS('fa') + "&loadkts=1",
					timeout: 5000,
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
			
			$scope.initKillteam = function() {
				te("compendium", "killteam", "", GetQS('fa'), GetQS("kt"));
				// First get the faction
				//	On success, we'll get the killteam
				$scope.loading = true;
				$scope.MODE = "Compendium";
				
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php?factionid=" + GetQS('fa'),
					timeout: 5000,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Got faction
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.faction = data;
						
						// Now get the faction
						$.ajax({
							type: "GET",
							url: APIURL + "killteam.php?fa=" + GetQS('fa') + "&kt=" + GetQS("kt"),
							timeout: 5000,
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
		
		// DASHBOARD
		{
			// Labels for Resource Points
			$scope.RPLabels = {
				"IMP": {
					"NOV": {
						"Label": "Faith Points",
						"Shortcut": "FP"
					},
					"KAS": {
						"Label": "Elite Points",
						"Shortcut": "EP"
					}
				},
				"AEL": {
					"VDT": {
						"Label": "Performance Tally",
						"Shortcut": "PT"
					}
				},
				"CHAOS": {
					"BLD": {
						"Label": "Blooded Tokens",
						"Shortcut": "BT"
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
			$scope.initDashboard = function() {
				te("dashboard", "init");
				$scope.loading = true;
				$scope.MODE = 'Dashboard';
				
				// Require the user to be logged in
				if ($scope.currentuser == null) {
					// Not logged in - Send user to "Log In"
					$scope.loading = false;
					console.log("Not logged in");
					toast("Not logged in!");
					window.location.href = "/login.htm";
				}
				else {
					// User is logged in, get their rosters
					$.ajax({
						type: "GET",
						url: APIURL + "roster.php?loadrosterdetail=1&uid=" + $scope.currentuser.userid,
						timeout: 5000,
						async: true,
						dataType: 'json',
						
						// Success
						success: function(data) { // Got user's rosters
							// Load the rosters into "myRosters"
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.currentuser.rosters = data;
							
							// Get the current deployed roster
							//	May be set from the query string ("Deploy" button on rosters)
							if (GetQS("rid") != "" && GetQS("rid") != null) {
								$scope.setDashboardRosterId(GetQS("rid"));
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
							
							// Get the operatives and set their "Injured" flag where appropriate
							for (let i = 0; i < $scope.dashboardroster.operatives.length; i++) {
								let op = $scope.dashboardroster.operatives[i];
								
								let wasInjured = op.isInjured;
								if (wasInjured == null) {
									wasInjured = false;
								}
								if (op.curW < parseInt(op.W) / 2 && !wasInjured && !(op.factionid == 'CHAOS' && op.killteamid == 'DG')) {
									// Operative is now injured, wasn't injured before (Excludes DeathGuard operatives - Disgustingly Resilient)
									op.isInjured = true;
									
									// Increase the BS/WS on the operative's weapons (lower BS/WS is better)
									// This does NOT apply to Pathfinder Assault Grenadiers
									if (!(op.factionid == 'TAU' && op.killteamid == 'PF' && op.fireteamid == 'PF' && op.opid == 'AG')					) {
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
									}
									
									// Reduce the M on the operative
									op.M = op.M.replace("2&#x2B24;", "1&#x2B24;");
									op.M = op.M.replace("3&#x2B24;", "2&#x2B24;");
									op.M = op.M.replace("4&#x2B24;", "3&#x2B24;");
									op.M = op.M.replace("5&#x2B24;", "4&#x2B24;");
									
								} else if (op.curW >= parseInt(op.W) / 2 && wasInjured) {
									// Operative is no longer injured, was injured before
									op.isInjured = false;
									
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
									}
									
									// Increase the M on the operative
									op.M = op.M.replace("5&#x2B24;", "6&#x2B24;");
									op.M = op.M.replace("4&#x2B24;", "5&#x2B24;");
									op.M = op.M.replace("3&#x2B24;", "4&#x2B24;");
									op.M = op.M.replace("2&#x2B24;", "3&#x2B24;");
									op.M = op.M.replace("1&#x2B24;", "2&#x2B24;");
								}
							}
							
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
				te("dashboard", "selectroster", "", roster.rosterid);
				$scope.dashboardroster = roster;
				$scope.setDashboardRosterId(roster.rosterid);
			}
			
			// Pop-up the roster operative selection modal
			$scope.initSelectRosterOps = function(roster) {
				$scope.selectrosterops = roster;
				
				// Show the modal
				$('#selectrosteropsmodal').modal("show");
			}
			
			// resetDash()
			// Resets the dashboard, returning scores to their default values and resetting operative wounds/curw
			$scope.resetDash = function(roster) {
				te("dashboard", "reset", "", roster.rosterid);
				
				// Update local roster
				roster.CP = $scope.settings["startcp"];
				roster.VP = $scope.settings["startvp"];
				roster.TP = 1;
				roster.RP = 0;
				
				// Push local roster to DB/API
				$scope.commitRoster(roster);
				
				// Reset operatives (not injured)
				for (let i = 0; i < roster.operatives.length; i++) {
					let op = roster.operatives[i];
					
					// No longer wounded - Show their details
					$("#opinfo_" + i).collapse('show');
					
					// Reset their Wounds
					console.log("Setting operative's curW to " + parseInt(op.W));
					op.curW = parseInt(op.W);
					
					// Not activated - Must be an INT to save properly in DB
					op.activated = 0;
					
					// Reset their injury debuffs
					if (op.isInjured) {
						// Operative is no longer injured, was injured before
						op.isInjured = false;
						
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
						}
						
						// Increase the M on the operative
						op.M = op.M.replace("5&#x2B24;", "6&#x2B24;");
						op.M = op.M.replace("4&#x2B24;", "5&#x2B24;");
						op.M = op.M.replace("3&#x2B24;", "4&#x2B24;");
						op.M = op.M.replace("2&#x2B24;", "3&#x2B24;");
						op.M = op.M.replace("1&#x2B24;", "2&#x2B24;");
					}
					
					$scope.commitRosterOp(op);
				}
				
				toast('Dashboard Reset');
			}
		
			$scope.updateCP = function(inc, roster) {
				te("dashboard", "CP", "inc", roster.rosterid, inc);
				roster.CP += inc;
				if (roster.CP < 0) {
					roster.CP = 0;
				}
				$scope.commitRoster(roster);
			}
			
			$scope.updateVP = function(inc, roster) {
				te("dashboard", "VP", "inc", roster.rosterid, inc);
				roster.VP += inc;
				if (roster.VP < 0) {
					roster.VP = 0;
				}
				$scope.commitRoster(roster);
			}
			
			$scope.updateTP = function(inc, roster) {
				te("dashboard", "TP", "inc", roster.rosterid, inc);
				roster.TP += inc;
				if (roster.TP < 1) {
					roster.TP = 1;
				}
				
				if (inc == 1) {
					// Next Turning Point - Reset "Activated" on each operative
					// Push local roster to DB/API
					$scope.commitRoster(roster);
					
					// Reset operatives (not injured)
					for (let i = 0; i < roster.operatives.length; i++) {
						let op = roster.operatives[i];
						op.activated = 0;
						$scope.commitRosterOp(op);
					}
				}
				
				$scope.commitRoster(roster);
			}
		
			
			// Increment Resource Points (e.g. Faith Points for Novitiates)
			$scope.updateRP = function(inc, roster)  {
				te("dashboard", "RP", "inc", roster.rosterid, inc);
				roster.RP += inc;
				if (roster.RP < 1) {
					roster.RP = 0;
				}
				$scope.commitRoster(roster);
			}
		}
		
		// HELPERS
		{
			$scope.replacePlaceholders = function(input) {
				return input
					.replace(/\[TRI\]/g, "&#x25B2;")
					.replace(/\[CIRCLE\]/g, "&#x2B24;")
					.replace(/\[SQUARE\]/g, "&#9632;")
					.replace(/\[PENT\]/g, "&#x2B1F;");
			}
			
			// getShortId()
			// Returns a short ID to use in the DB
			$scope.getShortId = function() {
				// Get a new short ID
				var id = "";
				$.ajax({
					type: "GET",
					url: APIURL + "id.php",
					timeout: 5000,
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
				console.log("Showing popup " + title);
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
			$scope.initwepsr = function(weapon, profile) {
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
								rule.ruletext = "This operative can perform a Shoot action with this weapon if it is within Engagement Range of an enemy operative. When this operative performs a Shoot action and selects this ranged weapon, make a shooting attack against each other operative Visible to and within &#x2B24; of it (even if it has friendly operatives within its Engagement Range) with this weapon - Each of them is a valid target and cannot be in Cover. After all of those shooting attacks have been made, this operative is incapacitated and do not roll for its BOOM! ability. This operative cannot make a shooting attack with this weapon by performing an Overwatch action.";
								break;
							case "BRUTAL":
								rule.ruletext = "Opponent can only parry with critical hits";
								break;
							case "CEASELESS":
								rule.ruletext = "Can re-roll any or all results of 1";
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
								rule.ruletext = "Each time this operative makes a Shoot action using its remote mine, make a shooting attack against each operative within &#9632; of the centre of its Mine token with that weapon. When making those shooting attacks, each operative (friendly and enemy) within &#9632; is a valid target, but when determining if it is in Cover, treat this operative’s Mine token as the active operative. Then remove this operative’s Mine token. An operative cannot make a shooting attack with this weapon by performing an Overwatch action, or if its Mine token is not in the killzone.";
								break;
							case "EXPERT RIPOSTE":
								rule.ruletext = "Each time this operative fights in combat using its duelling blades, in the Resolve Successful Hits step of that combat, each time you parry with a critical hit, also inflict damage equal to the weapon's Critical Damage characteristic.";
								break;
							case "FUS":
							case "FUSILLADE":
								rule.rulename = "Fusillade";
								rule.ruletext = "Distribute the Attack dice between valid targets within &#x2B24; of original target";
								break;
							case "GRAV":
							case "GRAV*":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, if the target has an unmodified Save characteristic of 3+ or better, this weapon has the Lethal 4+ special rule for that attack.";
								break;
							case "HEAVY":
							case "HVY":
								rule.rulename = "Heavy";
								rule.ruletext = "Cannot Shoot in the same activation as Move, Charge, or Fall Back";
								break;
							case "HUMBLING CRUELTY":
								rule.ruletext = "Each time a friendly operative makes a shooting attack with this weapon, in the Resolve Successful hits step of that shooting attack, if the target loses any wounds, the target is injured until the end of the Turning Point";
								break;
							case "HOT":
								rule.ruletext = "For each discarded Attack die result of 1 inflict 3 Mortal Wounds to the bearer";
								break;
							case "IND":
							case "INDIRECT":
								rule.rulename = "Indirect";
								rule.ruletext = "Ignores cover when selecting valid targets. Must still be Visible and not Obscured.";
								break;
							case "LIM":
							case "LIMITED":
								rule.rulename = "Limited";
								rule.ruletext = "Can only be used once per battle";
								break;
							case "NO COVER":
								rule.ruletext = "Target can't retain autosuccess for cover, must roll all Defence dice";
								break;
							case "PARRY HOOK":
								rule.ruletext = "Each time a friendly operative fights in combat with this weapon, in the Resolve Successful Hits step of that combat, each time you parry with a normal hit, you can select one of your opponent''s critical hits to be discarded instead.";
								break;
							case "RELENTLESS":
								rule.ruletext = "Can re-roll any or all Attack dice";
								break;
							case "RENDING":
							case "REND":
								rule.rulename = "Rending";
								rule.ruletext = "If you retain any critical hits, retain 1 normal hit as a critical hit too";
								break;
							case "SILENT":
							case "SIL":
								rule.rulename = "Silent";
								rule.ruletext = "Can Shoot this weapon while on a Conceal order";
								break;
							case "SMART TARGETING":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, you can use this special rule. If you do so, for that shooting attack:<br/><li>Enemy operatives with an Engage order that are not within Engagement Range of friendly operatives are valid targets and cannot be in Cover.</li><li>In the Roll Attack Dice step of that shooting attack, attack dice results of 6 are successful normal hits. All other attack dice results are failed hits.</li>";
								break;
							case "STORM SHIELD":
								rule.ruletext = "If this operative is equipped with a storm shield:<ul><li>It has a 4+ Invulnerable Save</li><li>Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent's successful hits are discarded (instead of one).</li></ul>";
								break;
							case "STUN":
								rule.ruletext = "Shooting: For each critical hit, subtract 1 from APL of target (max 1 per operative)<br/>Fighting: First critical hit discard 1 normal hit of the enemy, Second critical hit subtract 1 from APL of target";
								break;
							case "UNLOAD SLUGS":
								rule.ruletext = "Each time this operative makes a shooting attack with this weapon, in the Roll Attack Dice step of that shooting attack, if the target is within &#x2B1F; of it, you can re-roll any or all of your attack dice.";
								break;
							case "UNWIELDY":
								rule.ruletext = "Shooting costs +1 AP, no Overwatch";
								break;
							case "VICIOUS BLOWS":
								rule.ruletext = "Each time this operative fights in combat:<ul><li>If this operative is the Attacker, this weapon gains the Ceaseless special rule for that combat</li><li>If this operative performed a Charge action during this activation, this weapon gains the Relentless special rule for that combat</li></ul>";
								break;
						}
						
						// Other cases
						if (rulename.startsWith("AP")) {
							let num = rulename.replace("AP", "");
							rule.ruletext = "Remove " + num + " Defence dice from target before roll. Multiple APs do not stack.";
						} else if (rulename.startsWith("BLAST")) {
							let range = rulename.replace("BLAST", "");
							rule.ruletext = "After shooting perform shooting attacks against all operatives within " + range + ". No Overwatch.";
						} else if (rulename.startsWith("INFERNO")) {
							let num = rulename.replace("INFERNO", "");
							rule.ruletext = "Each time a friendly operative fights in combat or makes a shooting attack with this weapon, in the Roll Attack Dice step of that combat or shooting attack, if you retain any critical hits, the target gains " + num + " Inferno tokens. At the end of each Turning Point, roll one D6 for each Inferno token an enemy operative has: on a 4+, that enemy operative suffers 1 mortal wound. After rolling, remove all Inferno tokens that operative has.";
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
							rule.ruletext = "For each successful critical strike, inflict MW" + num + " on each other enemy within &#x25B2; of target";
						} else if (rulename.startsWith("RNG")) {
							let range = rulename.replace("RNG", "");
							rule.rulename = rule.rulename.replace("Rng", "Range");
							rule.ruletext = "Range limit of the weapon";
						} else if (rulename.startsWith("SPLASH")) {
							let num = rulename.replace("SPLASH", "");
							rule.ruletext = "For each critical hit, inflict MW" + num + " to the target and any other operative within &#x2B24; of the target";
						} else if (rulename.startsWith("TOR")) {
							let range = rulename.replace("TORRENT", "");
							range = rulename.replace("TOR", "");
							rule.rulename = "Torrent " + range;
							rule.ruletext = "Make additional attacks against enemy operatives within " + range + " of the previous target";
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
					timeout: 5000,
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
			
		// Always initialize the session
		$scope.initSession();
	}
);