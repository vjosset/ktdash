const APIURL = "/api/";

var app = angular.module("kt", ['ngSanitize'])
	// Controller for main app/pages
	.controller("ktCtrl", function($scope, $rootScope) {
		// GLOBAL
		{
			$scope.loading = false;
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
			// Initializes the login form, redirecting the user to "My Teams" if they're already logged in.
			// Redirects the user to the page in QueryString "ru" if logged in successfully.
			$scope.initLogin = function() {
				// Check if user is already logged in
				if ($scope.currentuser != null) {
					// Already logged in - Send user to "My Teams"
					console.log("Already logged in - Sending user to My Teams");
					window.location.href = "/userteams.htm";
				}
				
				$scope.loading = false;
				trackEvent('auth', 'form');
				var ru = GetQS("ru");
				if (ru == "" || ru == null) {
					// No redirect URL defined, use default
					ru = "/userteams.htm";
				}
				console.log("Loaded login form with RU: " + ru);
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
							// No redirect specified - Send user to "My Teams"
							$scope.loginForm.redirectUrl = "/userteams.htm";
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
			// Initializes the "Sign Up" form and redirects to My Teams if user is already logged in.
			$scope.initSignUp = function() {
				// Check if user is already logged in
				if ($scope.currentuser != null) {
					// Already logged in - Send user to "My Teams"
					console.log("Already logged in - Sending user to My Teams");
					window.location.href = "/userteams.htm";
				}
			};
			
			// signUp()
			// Signs the user up by creating a new user record, signing them in, and sending them to the "My Teams" page.
			$scope.signUp = function() {
				$scope.signUpForm.error = null;
				
				console.log("signUp()");
				
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
						// Send the user to "My Teams"
						window.location.href = "/userteams.htm";
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
		
		// MY TEAMS
		{
			// initMyTeams()
			// Initializes the "My Teams" page
			$scope.initMyTeams = function() {
				$scope.loading = true;
				
				// Check if user is already logged in
				if ($scope.currentuser == null) {
					// Not logged in - Send user to "Log In"
					$scope.loading = false;
					toast("Not logged in!");
					window.location.href = "/login.htm";
				} else {
					// User is logged in
					// Get the user's teams
					$.ajax({
						type: "GET",
						url: APIURL + "userteam.php",
						timeout: 5000,
						async: true,
						dataType: 'json',
						
						// Success
						success: function(data) { // Got user's teams
							// Load the teams into "myTeams"
							data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
							$scope.myTeams = data;
							
							$scope.loading = false;
							$scope.$apply();
						},
						// Failure
						error: function(data, status, error) { // Failed to get teams
							toast("Could not get teams: \r\n" + error);
							$scope.loading = false;
							$scope.$apply();
						}
					});
				}
			}
			
			// initMyTeam()
			// Initializes the "My Team" page - Landing page for a single team
			$scope.initMyTeam = function(utid) {
				$scope.loading = true;
				console.log("Getting team " + utid);
				
				$.ajax({
					type: "GET",
					url: APIURL + "userteam.php?utid=" + utid,
					timeout: 5000,
					async: true,
					dataType: 'json',
					
					// Success
					success: function(data) { // Got the team
						// Load the team into "myTeam"
						data = JSON.parse($scope.replacePlaceholders(JSON.stringify(data)));
						$scope.myTeam = data;
						
						console.log("Got team: " + JSON.stringify($scope.myTeam));
						
						$scope.loading = false;
						$scope.$apply();
					},
					// Failure
					error: function(data, status, error) { // Failed to get team
						toast("Could not get team: \r\n" + error);
						$scope.loading = false;
						$scope.$apply();
					}
				});
			}
		}
		
		// COMPENDIUM
		{
			// initCompendium()
			// Loads all factions
			$scope.initCompendium = function() {
				$scope.loading = true;
				$.ajax({
					type: "GET",
					url: APIURL + "faction.php",
					timeout: 5000,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Got factions
						console.log("Got factions: " + JSON.stringify(data));
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
							url: APIURL + "killteam.php?factionid=" + GetQS('fa') + "&killteamid=" + GetQS("kt"),
							timeout: 5000,
							async: true,
							dataType: 'json',
							success: function(data) {
								// Got factions
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
			
			// Always initialize the session
			$scope.initSession();
		}
	}
);