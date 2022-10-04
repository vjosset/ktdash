const APIURL = "/api/";

var app = angular.module("kt", ['ngSanitize'])
	// Controller for main app/pages
	.controller("ktCtrl", function($scope, $rootScope) {
		// GLOBAL
		{
			$scope.loading = false;
			$scope.MODE = "";
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
						// Send the user to "My Rosters"
						window.location.href = "/rosters.php";
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
			// initRosters()
			// Initializes the "My Rosters" page
			$scope.initRosters = function(uid) {
				$scope.loading = true;
				
				let isMe = ($scope.currentuser != null && uid == $scope.currentuser.userid);
				
				if (isMe) {
					$scope.MODE = "MyRosters";
				} else {
					$scope.MODE = "Rosters";
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
			
			// initRoster()
			// Initializes the "My Roster" page - Landing page for a single roster
			$scope.initRoster = function(rid) {
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
					},
					// Failure
					error: function(data, status, error) { // Failed to get roster
						toast("Could not get roster: \r\n" + error);
						$scope.loading = false;
						$scope.$apply();
					}
				});
			}
		
			/*
			// commitRosterOp()
			// Commits the specified operative to the DB
			$scope.commitRosterOp = function(op) {
				// Prepare the object to PUT
				let opdata = {
					userid: op.userid,
					rosterid: op.rosterid,
					rosteropid: op.rosteropid,
					seq: op.seq,
					opname: op.opname,
					
					factionid: op.factionid,
					killteamid: op.killteamid,
					fireteamid: op.fireteamid,
					opid: op.opid,
					
					eqids: op.eqids,
					wepids: op.wepids,
					
					curW: op.curW,
					notes: op.notes
				};
				
				$.ajax({
					type: "PUT",
					url: APIURL + "rosteroperative.php",
					timeout: 5000,
					async: true,
					dataType: 'json',
					data: JSON.stringify(opdata),
					
					// Success
					success: function(data) { // Saved this operative
						// All good
						toast("Saved");
					},
					// Failure
					error: function(data, status, error) { // Failed to save operative
						toast("Could not save operative: \r\n" + error);
						$scope.$apply();
					}
				});
			}
			*/
			
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
				// Send the delete request to the API
				$.ajax({
					type: "DELETE",
					url: APIURL + "roster.php?utid=" + $scope.deleteRoster.rosterid,
					timeout: 5000,
					async: true,
					
					// Success
					success: function(data) { // Saved this operative
						// All good
						
						// Remove this roster from the scope									
						let idx = $scope.myRosters.indexOf($scope.deleteRoster);
						if (idx > -1) {
							$scope.myRosters.splice(idx, 1);
						}
						
						// Update roster list
						$scope.initRosters();
						
						// Done
						toast("Roster \"" + $scope.deleteRoster.rostername + "\" deleted");
				
						// Close the modal
						$('#deleterostermodal').modal("hide");
						$scope.$apply();
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
					"seq": 0 // Always put new teams first
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
				// Prepare just the relevant data points for the roster to commit
				let data = {
					"userid": roster.userid,
					"rosterid": roster.rosterid,
					"rostername": roster.rostername,
					"factionid": roster.factionid,
					"killteamid": roster.killteamid,
					"seq": roster.seq,
					"notes": roster.notes
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
							location.href = "/roster.php?rid=" + roster.rosterid;
						},
						// Failure
						error: function(data, status, error) { // Failed to save operative
							toast("Could not save this roster: \r\n" + error);
						}
					});
				}
			}
			
			// initRenameRoster();
			// Pops-up the roster rename modal
			$scope.initRenameRoster = function(roster) {
				console.log("initRenameRoster(" + roster.rostername + ")");
				$scope.renameRoster = roster;
				$scope.renameRoster.newrostername =  roster.rostername;
				
				// Show the modal
				$('#renamerostermodal').modal("show");
			}
			
			// saveRenameRoster()
			// Save roster rename
			$scope.saveRenameRoster = function() {				
				$scope.renameRoster.rostername = $scope.renameRoster.newrostername;
				delete $scope.renameRoster.newrostername;
				
				// Commit to API/DB
				$scope.commitRoster($scope.renameRoster);
				
				// Close the modal
				$('#renamerostermodal').modal("hide");
				
				$scope.$apply();
			}
		}
		
		// OPERATIVES
		{
			// updateOpW()
			// Increment or decrement the specified operative's wounds
			$scope.updateOpW = function(op, inc) {
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
				
				if (op.curW == 0) {
					// This operative is now dead/incapacitated - Collapse its info
					// First, find this operative
					for (let i = 0; i < $scope.dashboard.myroster.operatives.length; i++) {
						if ($scope.dashboard.myroster.operatives[i] == op) {
							// This is our operative - Hide their details
							$("#opinfo_" + i).collapse('hide');
						}
					}
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
						"killteam": roster.killteam,
						"team": roster,
						"fireteam": roster.killteam.fireteams[0],
						"operative": roster.killteam.fireteams[0].operatives[0],
						"opname": ""
					};
				}
				
				// Always reset the name
				$scope.addop.opname = "";

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
					dataType: 'json',
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
				var url = APIURL + "/name.php?factionid=" + $scope.addop.operative.factionid + "&killteamid=" + $scope.addop.operative.killteamid + "&fireteamid=" + $scope.addop.operative.fireteamid + "&opid=" + $scope.addop.operative.opid;
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
				var url = APIURL + "/name.php?factionid=" + faid + "&killteamid=" + ktid + "&fireteamid=" + ftid + "&opid=" + opid;
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
					url: APIURL + "/rosteroperative.php?roid=" + $scope.optodelete.operative.rosteropid,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						// Close the modal
						$('#deleteopmodal').modal("hide");
						
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
				// Prepare the dialog to edit the operative
				
				// Prepare the op to edit (will be used in saveEditOperative())
				$scope.optoedit = op;
				
				// Create a deep-copy clone of this op to be edits
				$scope.editop = JSON.parse(JSON.stringify(op));
				
				// Clear weapons
				$scope.editop.weapons = [];
				
				// Set the weapon selections
				for (let wepnum = 0; wepnum < op.baseoperative.weapons.length; wepnum++) {
					let wep = JSON.parse(JSON.stringify(op.baseoperative.weapons[wepnum]));
					wep.isselected = ("," + op.wepids + ",").indexOf("," + wep.wepid + ",") >= 0;
					$scope.editop.weapons.push(wep);
				}
				
				// Clear equipments
				$scope.editop.equipments = [];
				
				// Rebuild equipments from all available, marking the right ones as selected for this operative
				for (let eqnum = 0; eqnum < roster.killteam.equipments.length; eqnum++) {
					let eq = JSON.parse(JSON.stringify(roster.killteam.equipments[eqnum]));
					eq.isselected = ("," + op.eqids + ",").indexOf("," + eq.eqid + ",") >= 0;
					$scope.editop.equipments.push(eq);
				}
				
				// Show the modal
				$('#editopmodal').modal("show");
			}
			
			// saveEditOp()
			// Save the changes to the edited operative
			$scope.saveEditOp = function() {
				// Set the new operative name
				$scope.optoedit.opname = $scope.editop.opname;
				
				// Parse the weapons to build the wepids
				$scope.optoedit.wepids = "";
				for (let i = 0; i < $scope.editop.weapons.length; i++) {
					if ($scope.editop.weapons[i].isselected) {
						if ($scope.optoedit.wepids.length > 0) {
							// Put a comma between weapon IDs
							$scope.optoedit.wepids += ",";
						}
						
						// Add this weapon to the operative
						$scope.optoedit.wepids += $scope.editop.weapons[i].wepid;
					}
				}
				
				// Parse the equipments to build the eqids
				$scope.optoedit.eqids = "";
				for (let i = 0; i < $scope.editop.equipments.length; i++) {
					if ($scope.editop.equipments[i].isselected) {
						if ($scope.optoedit.eqids.length > 0) {
							// Put a comma between equipment IDs
							$scope.optoedit.eqids += ",";
						}
						
						// Add this equipment to the operative
						$scope.optoedit.eqids += $scope.editop.equipments[i].eqid;
					}
				}
				
				// Remove the model before saving
				delete $scope.editop.operative;
				
				// Save all changes
				$scope.commitRosterOp($scope.optoedit);
				
				// Close the modal
				$('#editopmodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Operative " + $scope.editop.opname + " saved");
			}
		}
		
		// COMPENDIUM
		{
			// initCompendium()
			// Loads all factions
			$scope.initCompendium = function() {
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
				$scope.popup = {
					"title": title,
					"text": message
				}
				
				$("#popupmodal").modal("show");
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
							case "INDIRECT":
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
		}
			
		// Always initialize the session
		$scope.initSession();
	}
);