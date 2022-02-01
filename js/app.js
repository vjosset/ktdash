const APIURL = "/api/";

var app = angular.module("kt", ['ngSanitize'])
	// Controller for main app/pages
	.controller("ktCtrl", function($scope, $rootScope) {
		// HELPERS
		{
			$scope.showpopup = function(title, message) {
				$scope.popup = {
					"title": title,
					"text": message
				}
				
				$("#popupmodal").modal("show");
			}
			
			$scope.toggleDisplay = function(eid) {
				$(eid).toggle();
			}
			
			$scope.getarray = function(l) {
				return new Array(parseInt(l));
			}
			
			$scope.loading = true;
			
			$scope.trackEvent = function(cat, act, lbl) {
				trackEvent(cat, act, lbl);
			}
			
			$scope.initwepsr = function(weapon, profile) {
				$scope.wepsr = weapon;
				$scope.wepsr.profile = profile;
				
				// Now parse the weapon's special rules
				$scope.wepsr.rules = [];
				let weprules = profile.SR.split(",");
				for (let i = 0; i < weprules.length; i++) {
					let rule = {
						"rulename": weprules[i],
						"ruletext": weprules[i]
					}
					
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
						case "DETONATE":
					rule.ruletext = "Each time this operative makes a Shoot action using its remote mine, make a shooting attack against each operative within &#9632; of the centre of its Mine token with that weapon. When making those shooting attacks, each operative is treated as being Visible and not Obscured, but when determining if it is in Cover, treat this operative’s Mine token as the active operative. Then remove this operative’s Mine token. An operative cannot make a shooting attack with this weapon by performing an Overwatch action, or if its Mine token is not in the killzone.";
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
						case "RELENTLESS":
							rule.ruletext = "Can re-roll any or all Attack dice";
							break;
						case "RENDING":
						case "REND":
							rule.rulename = "Rending";
							rule.ruletext = "If you retain any critical hits, retain 1 normal hit as a critical hit too";
							break;
						case "SILENT":
							rule.ruletext = "Can Shoot this weapon while on a Conceal order";
							break;
						case "SMART TARGETING":
							rule.ruletext = "Each time this operative makes a shooting attack with this weapon, you can use this special rule. If you do so, for that shooting attack:<br/><li>Enemy operatives with an Engage order that are not within Engagement Range of friendly operatives are valid targets and cannot be in Cover.</li><li>In the Roll Attack Dice step of that shooting attack, attack dice results of 6 are successful normal hits. All other attack dice results are failed hits.</li>";
							break;
						case "STORM SHIELD":
							rule.ruletext = "If this operative is equipped with a storm shield:<li>It has a 4+ Invulnerable Save</li><li>Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent's successful hits are discarded (instead of one).</li>";
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
					
					
					// Add this rule
					$scope.wepsr.rules.push(rule);
				}
				
				// Now show the popup
				$("#wepsrmodal").modal("show");
			}
			
			$scope.cleanSpecialChars = function(json, encode) {
				if (encode) {
					// Encode - Convert shape to [TRI]
					// Revert special characters
					json = json
						.replace(/\&#x25B2;/g, "[TRI]")
						.replace(/\&#x2B24;/g, "[CIRCLE]")
						.replace(/\&#9632;/g, "[SQUARE]")
						.replace(/\&#x2B1F;/g, "[PENT]")
						.replace(/ \(1\\\"\)/g, "[TRI]")
						.replace(/ \(2\\\"\)/g, "[CIRCLE]")
						.replace(/ \(3\\\"\)/g, "[SQUARE]")
						.replace(/ \(6\\\"\)/g, "[PENT]");
				} else {
					// Decode - Convert [TRI] to shape
					switch ($scope.settings.distance) {
						case "shapes":
							json = json
								.replace(/\[TRI\]/g, "&#x25B2;")
								.replace(/\[CIRCLE\]/g, "&#x2B24;")
								.replace(/\[SQUARE\]/g, "&#9632;")
								.replace(/\[PENT\]/g, "&#x2B1F;");
							break;
						case "inches":
							json = json
								.replace(/\[TRI\]/g, " (1\\\")")
								.replace(/\[CIRCLE\]/g, " (2\\\")")
								.replace(/\[SQUARE\]/g, " (3\\\")")
								.replace(/\[PENT\]/g, " (6\\\")");
							break;
					}
				}
				
				return json;
			}
		}
		
		// SETTINGS/PREFERENCES
		{
			let settings = window.localStorage.getItem("settings");
			if (settings == "" || settings == null) {
				$scope.settings = {
					"distance": "shapes",
					"dashportraits": false
				};
			} else {
				$scope.settings = JSON.parse(settings);
			}
			
			$scope.saveSettings = function() {
				window.localStorage.setItem("settings", JSON.stringify($scope.settings));
				
				toast("Settings saved");
			}
		}
		
		// DASHBOARD
		{
			$scope.dashboard = {
				myteam: {},
				playerteams: {},
				CP: 2,
				TP: 1,
				VP: 2
			};
			
			let dash = localStorage.getItem("dashboard");
			if (dash != null && dash != "") {
				// We have a dashboard
				dash = $scope.cleanSpecialChars(dash, false);
				$scope.dashboard = JSON.parse(dash);
			}
			
			$scope.updateVP = function(inc)  {
				$scope.dashboard.VP = $scope.dashboard.VP + inc;
				if ($scope.dashboard.VP < 0) {
					$scope.dashboard.VP = 0;
				}
			}
			
			$scope.updateCP = function(inc)  {
				$scope.dashboard.CP = $scope.dashboard.CP + inc;
				if ($scope.dashboard.CP < 0) {
					$scope.dashboard.CP = 0;
				}
			}
			
			$scope.updateTP = function(inc)  {
				$scope.dashboard.TP = $scope.dashboard.TP + inc;
				if ($scope.dashboard.TP < 1) {
					$scope.dashboard.TP = 1;
				}
			}
			
			$scope.selectDashTeam = function(team) {
				$scope.dashboard.myteam = team;
				
				for (let i =0; i < team.operatives.length; i++) {
					if (team.operatives[i].curW == null) {
						team.operatives[i].curW = parseInt(team.operatives[i].W);
					}
				}
				
				$scope.commitTeams();
			}
			
			$scope.updateOpW = function(op, inc) {
				op.curW = op.curW + inc;
				if (op.curW < 0) {
					op.curW = 0;
				}
				if (op.curW > parseInt(op.W)) {
					op.curW = parseInt(op.W);
				}
				
				let wasInjured = op.isInjured;
				if (wasInjured == null) {
					wasInjured = false;
				}
				if (op.curW < parseInt(op.W) / 2 && !wasInjured) {
					// Operative is now injured, wasn't injured before
					op.isInjured = true;
					
					// Increase the BS/WS on the operative's weapons (lower BS/WS is better)
					// This does NOT apply to Pathfinder Assault Grenadiers
					if (op.factionid != 'TAU' && op.killteamid != 'PF' && op.fireteamid != 'PF' && op.opid != 'AG') {
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
				} else if (op.curW >=  parseInt(op.W) / 2 && wasInjured) {
					// Operative is no longer injured, was injured before
					op.isInjured = false;
					
					// Reduce the BS/WS on the operative's weapons (lower BS/WS is better)
					// This does NOT apply to Pathfinder Assault Grenadiers
					if (op.factionid != 'TAU' && op.killteamid != 'PF' && op.fireteamid != 'PF' && op.opid != 'AG') {
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
				
				trackEvent('dashboard', 'opwounds', inc);
				
				$scope.commitTeams();
			}
			
			$scope.resetDash = function() {
				trackEvent("dashboard", "reset", "");
				
				// Reset CP, TP (Turning Point), VP
				$scope.dashboard.CP = 2;
				$scope.dashboard.TP = 1;
				$scope.dashboard.VP = 2;
				
				// Reset operatives (not injured)
				for (let i = 0; i < $scope.dashboard.myteam.operatives.length; i++) {
					let op = $scope.dashboard.myteam.operatives[i];
					
					// Reset their Wounds
					op.curW = parseInt(op.W);
					
					// Reset Hidden
					op.hidden = false;
					
					// Reset Notes
					op.notes = "";
					
					// Reset their injury debuffs
					if (op.isInjured) {
						// Operative is no longer injured, was injured before
						op.isInjured = false;
						
						// Reduce the BS/WS on the operative's weapons (lower BS/WS is better)
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
						
						// Increase the M on the operative
						op.M = op.M.replace("5&#x2B24;", "6&#x2B24;");
						op.M = op.M.replace("4&#x2B24;", "5&#x2B24;");
						op.M = op.M.replace("3&#x2B24;", "4&#x2B24;");
						op.M = op.M.replace("2&#x2B24;", "3&#x2B24;");
						op.M = op.M.replace("1&#x2B24;", "2&#x2B24;");
					}
				}
				
				$scope.commitTeams();
			}
		
			$scope.initEditOpEq = function(operative) {
				$scope.opeq = {
					"operative": operative,
					"equipments": JSON.parse(JSON.stringify($scope.getKillteam(operative.factionid, operative.killteamid).equipments))
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
			
			$scope.saveEditOpEq = function() {
				// Remove the operative's previous equipment
				$scope.opeq.operative.equipments = [];
				
				// Add the selected equipment to the operative
				for (let i = 0; i < $scope.opeq.equipments.length; i++) {
					if ($scope.opeq.equipments[i].isselected) {
						$scope.opeq.operative.equipments.push($scope.opeq.equipments[i]);
					}
				}
				
				// Commit changes
				$scope.commitTeams();
				
				// Hide the modal
				$('#editopeqmodal').modal("hide");
			}
		
			$scope.initSelectTeamOps = function(team) {
				$scope.selectteamops = {
					"team": team
				};
				
				// Show the modal
				$('#selectteamopsmodal').modal("show");
			}
		}
		
		// PLAYER TEAMS
		{
			/*
				myteams - Array of teams
					team
						factionid
						killteamid
						killteam
						teamname
						operatives - Array of operations
							factionid
							killteamid
							fireteamid
							opid
							weapons - Array of weapons
								[...]
								weaponprofiles - Array of weapon profiles
									[...]
				myteam - Currently-selected team from myteams
			*/
			
			$scope.getTeamType = function(team) {
				/*
				Loop through operatives
					Get their fireteamid
					If fireteamid not in list, append to list
				*/
				
				let teamtype = "";
				for (let i = 0; i < team.operatives.length; i++) {
					if (!teamtype.contains(team.operatives[i].fireteamid)) {
						if (teamtype.length > 0) {
							// Put a comma between elements
							teamtype += ", ";
						}
						// Append this fireteam
						teamtype += team.operatives[i].fireteamid;
					}
				}
				
				return teamtype;
				//return team.killteam.killteamname;
			}
			
			$scope.initNewTeam = function() {
				$scope.newteam = {
					"factionid": "",
					"killteamid": "",
					"teamname": "",
					"faction": null,
					"killteam": null
				};
				
				// Show the modal
				$('#newteammodal').modal("show");
			}
			
			$scope.createTeam = function() {
				// Validate the input
				if ($scope.newteam.killteam == null) {
					// No killteam selected
					toast("Please select a KillTeam");
					return;
				}
				if ($scope.newteam.teamname.trim() == "") {
					// No team name specified
					toast("Please enter a team name");
					return;
				}
				
				// Create a new team for the specified faction and killteam
				var team = {
					"factionid": $scope.newteam.faction.factionid,
					"killteamid": $scope.newteam.killteam.killteamid,
					"teamname": $scope.newteam.teamname,
					"killteam": $scope.newteam.killteam,
					"operatives": []
				}
				trackEvent("myteams", "savenewteam", team.factionid + "/" + team.killteamid);
				
				// Add this team to the user's collection of teams (stored in local storage)
				$scope.myteams.splice(0, 0, team);
				
				// Commit to local storage
				$scope.commitTeams();
				
				// Close the modal
				$('#newteammodal').modal("hide");
				
				// Tell the user their team has been created
				toast("Team " + $scope.newteam.teamname + " created!");
			};
			
			$scope.initRenameTeam = function(team) {
				$scope.renameTeam = team;
				$scope.renameTeam.newteamname =  team.teamname;
				
				// Show the modal
				$('#renameteammodal').modal("show");
			}
			
			$scope.saveRenameTeam = function() {
				trackEvent("myteams", "renameteam", $scope.renameTeam.factionid + "/" + $scope.renameTeam.killteamid);
				
				$scope.renameTeam.teamname = $scope.renameTeam.newteamname;
				delete $scope.renameTeam.newteamname;
				
				// Commit to local storage
				$scope.commitTeams();
				
				// Close the modal
				$('#renameteammodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Team " + $scope.renameTeam.teamname + " renamed");
			}
			
			$scope.initDeleteTeam = function(team) {
				$scope.deleteTeam = team;
				
				// Show the modal
				$('#deleteteammodal').modal("show");
			}
			
			$scope.saveDeleteTeam = function() {
				trackEvent("myteams", "deleteteam", $scope.deleteTeam.factionid + "/" + $scope.deleteTeam.killteamid);
				
				// Remove the team from the collection				
				let idx = $scope.myteams.indexOf($scope.deleteTeam);
				if (idx > -1) {
					$scope.myteams.splice(idx, 1);
				}
				
				// Commit to local storage
				$scope.commitTeams();
				
				// Close the modal
				$('#deleteteammodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Team " + $scope.deleteTeam.teamname + " deleted");
			}
			
			$scope.initAddOp = function(team) {
				// Prepare the dialog to add an operative to the selected team
				if ($scope.addop == null || $scope.team != $scope.addop.team) {
					// Only reset the operative if this is for a different team than last time use added an operative
					$scope.addop = {
						"faction": team.faction,
						"killteam": team.killteam,
						"team": team,
						"fireteam": team.killteam.fireteams[0],
						"operative": team.killteam.fireteams[0].operatives[0],
						"opname": ""
					};
				}
				
				// Always reset the name
				$scope.addop.opname = "";

				// Show the modal
				$('#addoptoteammodal').modal("show");
			}
			
			$scope.addOperative = function() {
				trackEvent("myteams", "addop", $scope.addop.operative.factionid + "/" + $scope.addop.operative.killteamid + "/" + $scope.addop.operative.fireteamid + "/" + $scope.addop.operative.opid);
				
				// Validate the input
				if ($scope.addop.operative == null) {
					// No killteam selected
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
				let newop = JSON.parse(JSON.stringify($scope.addop.operative));
				
				// Remove unused properties
				delete newop.faction;
				delete newop.killteam;
				delete newop.fireteam;
				delete newop.operative;
				
				newop.optype = $scope.addop.operative.opname;
				newop.opname = $scope.addop.opname;
				
				// Parse the weapons
				newop.weapons = [];
				for (let i = 0; i < $scope.addop.operative.weapons.length; i++) {
					if ($scope.addop.operative.weapons[i].isselected) {
						newop.weapons.push(JSON.parse(JSON.stringify($scope.addop.operative.weapons[i])));
					}
				}
				
				// Add this operative to the team
				$scope.addop.team.operatives.push(newop);
				
				// Delete this operative's assigned "team" property
				delete newop.team;
				
				// Commit to local storage
				$scope.commitTeams();
				
				// Close the modal
				$('#addoptoteammodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Operative " + $scope.addop.opname + " added to team!");
			}
			
			$scope.getaddopname = function() {
				trackEvent("myteams", "genopname", $scope.addop.operative.factionid + "&killteamid=" + $scope.addop.operative.killteamid + "&fireteamid=" + $scope.addop.operative.fireteamid + "&opid=" + $scope.addop.operative.opid);
				var url = APIURL + "/name.php?factionid=" + $scope.addop.operative.factionid + "&killteamid=" + $scope.addop.operative.killteamid + "&fireteamid=" + $scope.addop.operative.fireteamid + "&opid=" + $scope.addop.operative.opid;
				$.ajax({
					type: "GET",
					url: url,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						$scope.addop.opname = data;
						
						$scope.$apply();
					}
				});
			}
			
			$scope.generateOpName = function(faid, ktid, ftid, opid, op, namevar) {
				trackEvent("myteams", "genopname", faid + "_" + ktid + "_" + ftid + "_" + opid);
				var url = APIURL + "/name.php?factionid=" + faid + "&killteamid=" + ktid + "&fireteamid=" + ftid + "&opid=" + opid;
				$.ajax({
					type: "GET",
					url: url,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						op[namevar] = data;
						
						$scope.$apply();
					}
				});
			}
			
			$scope.initEditOp = function(op, team) {
				// Prepare the dialog to edit the operative
				$scope.editop = op;
				$scope.editop.newopname = op.opname;
				
				// Find the operative archetype for this operative
				//console.log("Looking for operative archetype " + op.factionid + "/" + op.killteamid + "/" + op.fireteamid + "/" + op.opid);
				for (let facnum = 0; facnum < $scope.factions.length; facnum++) {
					let faction = $scope.factions[facnum];
					if (faction.factionid == op.factionid) {
						//console.log("Found factionid");
						// Found the faction - Now look for the killteam
						for (let ktnum = 0; ktnum < faction.killteams.length; ktnum++) {
							let killteam = faction.killteams[ktnum];
							if (killteam.killteamid == op.killteamid) {
								// Found the killteam
								//	Assign the equipment list
								$scope.editop.killteam = killteam;
								
								//	Now look for the fire team
								for (let ftnum = 0; ftnum < killteam.fireteams.length; ftnum++) {
									let fireteam = killteam.fireteams[ftnum];
									if (fireteam.fireteamid == op.fireteamid) {
										//console.log("Found fireteamid");
										// Found the fireteam - Now look for the operative
										for (let opnum = 0; opnum < fireteam.operatives.length; opnum++) {
											if (fireteam.operatives[opnum].opid == op.opid) {
												// This is our operative archetype
												//console.log("Found operative archetype");
												$scope.editop.operative = fireteam.operatives[opnum];
												
												// Now match the weapon selections
												for (let wepnum = 0; wepnum < op.weapons.length; wepnum++) {
													let opwep = op.weapons[wepnum];
													// Look for this weapon in the operative archetype's weapons
													for (let i = 0; i < $scope.editop.operative.weapons.length; i++) {
														if ($scope.editop.operative.weapons[i].wepid == opwep.wepid) {
															$scope.editop.operative.weapons[i].isselected = true;
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}

				// Show the modal
				$('#editopmodal').modal("show");
			}
			
			$scope.saveEditOperative = function() {
				trackEvent("myteams", "editop", $scope.editop.factionid + "/" + $scope.editop.killteamid + "/" + $scope.editop.fireteamid + "/" + $scope.editop.opid);
				
				// Set the new operative name
				$scope.editop.opname = $scope.editop.newopname;
				
				// Parse the weapons
				$scope.editop.weapons = [];
				for (let i = 0; i < $scope.editop.operative.weapons.length; i++) {
					if ($scope.editop.operative.weapons[i].isselected) {
						$scope.editop.weapons.push(JSON.parse(JSON.stringify($scope.editop.operative.weapons[i])));
					}
				}
				
				// Remove the archetype before saving
				delete $scope.editop.operative;
				
				// Save all changes
				$scope.commitTeams();
				
				// Close the modal
				$('#editopmodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Operative " + $scope.editop.opname + " saved");
			}
			
			$scope.initRemoveOperative = function(op, team) {
				
				$scope.optoremove = {
					"operative": op,
					"team": team,
				};

				// Show the modal
				$('#removeopmodal').modal("show");
			}
			
			$scope.removeOperative = function() {	
				trackEvent("myteams", "deleteop", $scope.optoremove.operative.factionid + "/" + $scope.optoremove.operative.killteamid + "/" + $scope.optoremove.operative.fireteamid + "/" + $scope.optoremove.operative.opid);
				let idx = $scope.optoremove.team.operatives.indexOf($scope.optoremove.operative);
				if (idx > -1) {
					$scope.optoremove.team.operatives.splice(idx, 1);
				}
				
				// Commit to local storage
				$scope.commitTeams();
				
				// Close the modal
				$('#removeopmodal').modal("hide");
				
				// Tell the user their operative has been added
				toast("Operative " + $scope.optoremove.operative.opname + " deleted");
				
				// Commit to local storage
				$scope.commitTeams();
			}
			
			$scope.moveTeamUp = function(team, index) {
				trackEvent("myTeams", "moveteam", "up");
				
				// Decrement the index for this team
				if (index > 0) {
					// Team is not the first one in the list - Reduce its index
					array_move($scope.myteams, index, index - 1);
				}
				
				$scope.commitTeams();
			}
			
			$scope.moveTeamDown = function(team, index) {
				trackEvent("myteams", "moveteam", "down");
				
				// Increment the index for this team
				if (index < $scope.myteams.length - 1) {
					// Team is not the last one in the list - Increase its index
					array_move($scope.myteams, index, index + 1);
				}
				
				$scope.commitTeams();
			}
			
			$scope.moveOpUp = function(team, op, index) {
				trackEvent("myteams", "moveop", "up");		
				
				// Decrement the index for this operative
				if (index > 0) {
					// Operative is not the first one in the team - Reduce its index
					array_move(team.operatives, index, index - 1);
				}
				
				$scope.commitTeams();
			}
			
			$scope.moveOpDown = function(team, op, index) {
				trackEvent("myteams", "moveop", "down");		
				
				// Increment the index for this operative
				if (index < team.operatives.length - 1) {
					// Operative is not the last one in the team - Increase its index
					array_move(team.operatives, index, index + 1);
				}
				
				$scope.commitTeams();
			}
			
			$scope.commitTeams = function() {
				// Commit the team to local storage
				
				// Start by making a copy
				let json = JSON.stringify($scope.myteams);
				
				// Revert special characters
				json = $scope.cleanSpecialChars(json, true);
				let teams = JSON.parse(json);
				
				// Remove unnecessary info from stored team (to reduce local storage size)
				for (let teamnum = 0; teamnum < teams.length; teamnum++) {
					let team = teams[teamnum];
					
					// Remove the killteam member (don't need a full copy of the killteam on each team)
					delete team.killteam;
					
					for (let opnum = 0; opnum < team.operatives.length; opnum++) {
						// Remove the team on this operative
						delete team.operatives[opnum].team;
					}
				}
				
				// Store the compressed copy of the team
				window.localStorage.setItem("myteams", $scope.cleanSpecialChars(JSON.stringify(teams), true));
				
				// Save the dashboard too
				window.localStorage.setItem("dashboard", $scope.cleanSpecialChars(JSON.stringify($scope.dashboard), true));
			}
		
			$scope.getShareUrl = function(team) {
				// Prepare the URL
				let url = "/viewteam.htm?importjson=";
				
				// Prepare the data
				let tmp = {
					"teamname": team.teamname,
					"factionid": team.factionid,
					"killteamid": team.killteamid,
					"operatives": []
				};
				
				// Prepare the operatives
				for (let opnum = 0; opnum < team.operatives.length; opnum++) {
					let op = team.operatives[opnum];
					
					let tmpop = {
						"fireteamid": op.fireteamid,
						"opid": op.opid,
						"opname": op.opname,
						"weapons": []
					}
					
					for (let wepnum = 0; wepnum < op.weapons.length; wepnum++) {
						let wep = op.weapons[wepnum];
						
						tmpop.weapons.push(wep.wepid);
					}
					
					// Add this temp op
					tmp.operatives.push(tmpop);
				}
				
				// Done
				return url + JSON.stringify(tmp);
			}
			
			$scope.getShareUrl2 = function(team) {
				// Prepare the URL
				let url = "/viewteam.php?importteam=";
				
				let encode = "";
				encode += team.teamname + "|";
				encode += team.factionid + "|";
				encode += team.killteamid;
				
				// Prepare the data
				let tmp = [];
				tmp.push(team.teamname);
				tmp.push(team.factionid);
				tmp.push(team.killteamid);
				
				let ops = [];
				for (let opnum = 0; opnum < team.operatives.length; opnum++) {
					let op = team.operatives[opnum];
					
					let tmpencode = "";
					tmpencode += op.fireteamid + "/";
					tmpencode += op.opid + "/";
					tmpencode += op.opname + "/";
					
					let tmpop = [];
					tmpop.push(op.fireteamid);
					tmpop.push(op.opid);
					tmpop.push(op.opname);
					
					// Prepare the operative's weapons
					let weps = [];
					
					for (let wepnum = 0; wepnum < op.weapons.length; wepnum++) {
						weps.push(op.weapons[wepnum].wepid);
						tmpencode += op.weapons[wepnum].wepid + ",";
					}
					
					tmpop.push(weps);
					
					ops.push(tmpop);
					
					encode += "|" + tmpencode;
				}
				tmp.push(ops);
				
				// Done
				//return url + JSON.stringify(tmp);
				return url + encode;
			}
		
			$scope.cloneTeam = function(team, index) {
				let newteam = JSON.parse(JSON.stringify(team));
				newteam.teamname = newteam.teamname + " - Copy";
				
				$scope.myteams.splice(index + 1, 0, newteam);
				
				toast("Copied as new team \"" + newteam.teamname + "\"");
			}
		
			$scope.initImportTeam = function(importjson) {
				// Found a team to import, parse it for display
				let tmp = JSON.parse(importjson);
				
				// Prepare the team
				let importTeam = {
					"factionid": tmp.factionid,
					"killteamid": tmp.killteamid,
					"teamname": tmp.teamname,
					"operatives": []
				};
				
				// Set the killteam
				importTeam.killteam = $scope.getKillteam(importTeam.factionid, importTeam.killteamid);
				
				// Now find the operatives
				for (let i = 0; i < tmp.operatives.length; i++) {
					let oparchetype = $scope.getOperative(importTeam.factionid, importTeam.killteamid, tmp.operatives[i].fireteamid, tmp.operatives[i].opid);
					let op = JSON.parse(JSON.stringify(oparchetype));
					op.optype = op.opname;
					op.opname = tmp.operatives[i].opname;
					
					// Remove all weapons
					op.weapons = [];
					
					let reqwepids = tmp.operatives[i].weapons;
					
					for (let reqwepnum = 0; reqwepnum < reqwepids.length; reqwepnum++) {
						let reqwepid = reqwepids[reqwepnum];
						
						// Find the weapon in the operative archetype
						for (let wepnum = 0; wepnum < oparchetype.weapons.length; wepnum++) {
							if (oparchetype.weapons[wepnum].wepid == reqwepid) {
								// Found it!
								op.weapons.push(oparchetype.weapons[wepnum]);
							}
						}
					}
					
					// Put this operative in the team
					importTeam.operatives.push(op);
				}
				
				$scope.importTeam = importTeam;
			}
			
			// Newer, shorter format for team imports
			$scope.initImportTeam2 = function(importstring) {
				let data = importstring.split("|");
				
				let importTeam = {
					"teamname": data[0],
					"factionid": data[1],
					"killteamid": data[2],
					"operatives": []
				};
				
				// Set the killteam
				importTeam.killteam = $scope.getKillteam(importTeam.factionid, importTeam.killteamid);
				
				for (let opnum = 3; opnum < data.length; opnum++) {
					let opdata = data[opnum].split("/");
					
					let oparchetype = $scope.getOperative(importTeam.factionid, importTeam.killteamid, opdata[0], opdata[1]);
					let op = JSON.parse(JSON.stringify(oparchetype));
					op.optype = op.opname;
					op.opname = opdata[2];
					op.fireteam = $scope.getFireteam(op.factionid, op.killteamid, op.fireteamid);
					
					op.weapons = [];
					
					// Now parse the weapons
					let reqwepids = opdata[3].split(",");
					
					for (let reqwepnum = 0; reqwepnum < reqwepids.length; reqwepnum++) {
						let reqwepid = reqwepids[reqwepnum];
						
						// Find the weapon in the operative archetype
						for (let wepnum = 0; wepnum < oparchetype.weapons.length; wepnum++) {
							if (oparchetype.weapons[wepnum].wepid == reqwepid) {
								// Found it!
								op.weapons.push(oparchetype.weapons[wepnum]);
							}
						}
					}
					
					// Done, add this operative to the team
					importTeam.operatives.push(op);
				}
				
				// Set the team to be imported				
				$scope.importTeam = importTeam;
			}
		
			$scope.saveImportTeam = function() {
				trackEvent("myTeams", "importteam", $scope.importTeam.factionid + "/" + $scope.importTeam.killteamid + "_" + $scope.importTeam.teamname);
				
				$scope.myteams.splice(0, 0, $scope.importTeam);
				$scope.commitTeams();
				
				// Now send the user to "My Teams"
				document.location.href = "/myteams.htm";
			}
		
			$scope.showShareTeam = function(team) {
				$scope.shareteam = team;
				$scope.shareteam.url = $scope.getShareUrl2(team);
				
				// Show the modal
				$('#shareteammodal').modal("show");
			}
		}
		
		// COMPENDIUM
		{
			// Compendium data
			$scope.factions = [];
		
			$scope.init = function(mode) {
				// Get the full compendium
				var url = APIURL + "/faction.php";
				if (mode == 'DB') {
					url = "/killteams.json";
				}
				$.ajax({
					type: "GET",
					url: url,
					timeout: 5000,
					async: true,
					dataType: 'json',
					success: function(data) {
						// Clear loaded factions
						$scope.factions = [];
						
						factionid = GetReqFAid();
						killteamid = GetReqKTid();
						fireteamid = GetReqFTid();
						operativeid = GetReqOPid();
						
						// Loop data and load the requested faction/killteam/fireteam/operative
						// For each faction
						for (let facnum = 0; facnum < data.length; facnum++) {
							let faction = data[facnum];
							// debugger;
							if (faction.factionid == factionid || factionid == null || factionid == "") {
								// This is the requested faction, or no faction requested
								// Copy the faction from original data
								let myfaction = (JSON.parse(JSON.stringify(faction)))
								// Clear out the killteams in the faction
								myfaction.killteams = [];
								// Assign the faction
								$scope.factions.push(myfaction);
								
								// For each killteam
								for (let ktnum = 0; ktnum < faction.killteams.length; ktnum++) {
									let killteam = faction.killteams[ktnum];
									// debugger;
									if (killteam.killteamid == killteamid || killteamid == null || killteamid == "") {
										// This is the requested killteam, or no killteam requested
										// Copy the killteam from original data
										let mykillteam = (JSON.parse(JSON.stringify(killteam)))
										// Clear out the fireteams in the killteam
										mykillteam.fireteams = [];
										// Assign the killteam
										myfaction.killteams.push(mykillteam);
										
										// For each fireteam
										for (let ftnum = 0; ftnum < killteam.fireteams.length; ftnum++) {
											let fireteam = killteam.fireteams[ftnum];
											// debugger;
											if (fireteam.fireteamid == fireteamid || fireteamid == null || fireteamid == "") {
												// This is the requestd fireteam, or no fireteam requested
												// Copy the fireteam from original data
												let myfireteam = (JSON.parse(JSON.stringify(fireteam)))
												// Clear out the operatives in the fireteam
												myfireteam.operatives = [];
												// Assign the fireteam
												mykillteam.fireteams.push(myfireteam);
												
												// For each operative
												for (let opnum = 0; opnum < fireteam.operatives.length; opnum++) {
													let operative = fireteam.operatives[opnum];
													// debugger;
													if (operative.opid == operativeid || operativeid == null || operativeid == "") {
														// This is the requested operative, or no operative requested
														// Copy the operative from original data
														let myoperative = (JSON.parse(JSON.stringify(operative)))
														// Assign the operative
														myfireteam.operatives.push(myoperative);
													}
												}
											}
										}
									}
								}
							}
						}
										
						// Do some cleanup on the data (special symbols) for readability
						var json = JSON.stringify($scope.factions);
						json = $scope.cleanSpecialChars(json, false);
						
						// Reassign the compendium now that the JSON is cleaned up
						$scope.factions = JSON.parse(json);
						
						// Set the page title
						if (window.location.href.endsWith(".htm")) {
							if (factionid != null && factionid != "") {
								document.title = $scope.factions[0].factionname + " | KTDash.app";
							}
							if (killteamid != null && killteamid != "") {
								document.title = $scope.factions[0].killteams[0].killteamname + " | KTDash.app";
							}
						}
						
						// Get the user's teams from local storage
						let myteamsjson = window.localStorage.getItem("myteams");
						if (myteamsjson == "" || myteamsjson == null || myteamsjson == "{}" || myteamsjson == "[]") {
							// Start with sample team "Talon Squad"
							myteamsjson = "[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"teamname\":\"Sample Team: Talon Squad\",\"operatives\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"opname\":\"Lyandro Karras\",\"description\":\"Deathwatch Watch Sergeants are deadly combatants and tacticians who carry an array of specialist weapons and have an instinct for divining their prey's next move.\",\"M\":\"3&#x2B24;\",\"APL\":\"3\",\"GA\":\"1\",\"DF\":\"3\",\"SV\":\"3+\",\"W\":\"12\",\"keywords\":\"SPACE MARINE, IMPERIUM, ADEPTUS ASTARTES, <CHAPTER>, PRIMARIS, LEADER, DEATHWATCH VETERAN, SERGEANT\",\"weapons\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"CG\",\"wepname\":\"Combi-Grav\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"CG\",\"profileid\":\"0\",\"name\":\"Grav\",\"A\":\"4\",\"BS\":\"2+\",\"D\":\"4/5\",\"SR\":\"Combi-DWBG, AP1, Grav*, Lim\",\"$$hashKey\":\"object:170\"}],\"$$hashKey\":\"object:109\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"DWBG\",\"wepname\":\"DeathWatch Boltgun\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"DWBG\",\"profileid\":\"0\",\"name\":\"DragonFire\",\"A\":\"4\",\"BS\":\"2+\",\"D\":\"3/4\",\"SR\":\"No Cover\",\"$$hashKey\":\"object:191\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"DWBG\",\"profileid\":\"1\",\"name\":\"HellFire\",\"A\":\"4\",\"BS\":\"2+\",\"D\":\"3/4\",\"SR\":\"Rending\",\"$$hashKey\":\"object:192\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"DWBG\",\"profileid\":\"2\",\"name\":\"Kraken\",\"A\":\"4\",\"BS\":\"2+\",\"D\":\"3/4\",\"SR\":\"P1\",\"$$hashKey\":\"object:193\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"DWBG\",\"profileid\":\"3\",\"name\":\"Vengeance\",\"A\":\"4\",\"BS\":\"2+\",\"D\":\"4/4\",\"SR\":\"\",\"$$hashKey\":\"object:194\"}],\"$$hashKey\":\"object:112\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"PW\",\"wepname\":\"Power Weapon\",\"weptype\":\"M\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"SGT\",\"wepid\":\"PW\",\"profileid\":\"0\",\"name\":\"Power Weapon\",\"A\":\"5\",\"BS\":\"2+\",\"D\":\"4/6\",\"SR\":\"Lethal 5+\",\"$$hashKey\":\"object:315\"}],\"$$hashKey\":\"object:130\",\"isselected\":true}],\"uniqueactions\":[],\"abilities\":[],\"fireteammax\":0,\"$$hashKey\":\"object:99\",\"optype\":\"DeathWatch Sergeant\",\"curW\":12},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"opname\":\"Darrion Rauth\",\"description\":\"Deathwatch kill teams comprise experienced warriors equipped with rare weapons and equipment, including specialist ammunition tailored to kill various xenos.\",\"M\":\"3&#x2B24;\",\"APL\":\"3\",\"GA\":\"1\",\"DF\":\"3\",\"SV\":\"3+\",\"W\":\"11\",\"keywords\":\"SPACE MARINE, IMPERIUM, ADEPTUS ASTARTES, <CHAPTER>, PRIMARIS, DEATHWATCH VETERAN, WARRIOR\",\"weapons\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"DWBG\",\"wepname\":\"DeathWatch Boltgun\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"DWBG\",\"profileid\":\"0\",\"name\":\"DragonFire\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"No Cover\",\"$$hashKey\":\"object:562\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"DWBG\",\"profileid\":\"1\",\"name\":\"HellFire\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"Rending\",\"$$hashKey\":\"object:563\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"DWBG\",\"profileid\":\"2\",\"name\":\"Kraken\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"P1\",\"$$hashKey\":\"object:564\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"DWBG\",\"profileid\":\"3\",\"name\":\"Vengeance\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"4/4\",\"SR\":\"\",\"$$hashKey\":\"object:565\"}],\"$$hashKey\":\"object:549\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"F\",\"wepname\":\"Fists\",\"weptype\":\"M\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"WAR\",\"wepid\":\"F\",\"profileid\":\"0\",\"name\":\"Fists\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"\",\"$$hashKey\":\"object:597\"}],\"$$hashKey\":\"object:553\",\"isselected\":true}],\"uniqueactions\":[],\"abilities\":[],\"fireteammax\":0,\"$$hashKey\":\"object:137\",\"optype\":\"DeathWatch Warrior\",\"notes\":\"\",\"curW\":11,\"isInjured\":false},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"HGNR\",\"opname\":\"Maximmion Voss\",\"description\":\"These Deathwatch Veterans bear the most potent of xenos-killing firepower, and support kill teams facing especially dangerous horrors.\",\"M\":\"3&#x2B24;\",\"APL\":\"3\",\"GA\":\"1\",\"DF\":\"3\",\"SV\":\"3+\",\"W\":\"11\",\"keywords\":\"SPACE MARINE, IMPERIUM, ADEPTUS ASTARTES, <CHAPTER>, PRIMARIS, DEATHWATCH VETERAN, HEAVY GUNNER\",\"weapons\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"HGNR\",\"wepid\":\"HF\",\"wepname\":\"Heavy Flamer\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"HGNR\",\"wepid\":\"HF\",\"profileid\":\"0\",\"name\":\"Heavy Flamer\",\"A\":\"6\",\"BS\":\"2+\",\"D\":\"2/2\",\"SR\":\"Hvy, Rng &#x2B1F;, Tor &#x2B24;\",\"$$hashKey\":\"object:335\"}],\"$$hashKey\":\"object:311\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"HGNR\",\"wepid\":\"F\",\"wepname\":\"Fists\",\"weptype\":\"M\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"HGNR\",\"wepid\":\"F\",\"profileid\":\"0\",\"name\":\"Fists\",\"A\":\"3\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"\",\"$$hashKey\":\"object:357\"}],\"$$hashKey\":\"object:314\",\"isselected\":true}],\"uniqueactions\":[],\"abilities\":[],\"fireteammax\":0,\"$$hashKey\":\"object:135\",\"optype\":\"DeathWatch Heavy Gunner\",\"notes\":\"\",\"curW\":11,\"isInjured\":false},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"FTR\",\"opname\":\"Siefer Zeed\",\"description\":\"Those Deathwatch Veterans who excel in bloody close combat wield a variety of pistols, blades, and powered hammers that can pulverise almost any foe.\",\"M\":\"3&#x2B24;\",\"APL\":\"3\",\"GA\":\"1\",\"DF\":\"3\",\"SV\":\"3+\",\"W\":\"11\",\"keywords\":\"SPACE MARINE, IMPERIUM, ADEPTUS ASTARTES, <CHAPTER>, PRIMARIS, DEATHWATCH VETERAN, FIGHTER\",\"weapons\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"FTR\",\"wepid\":\"BP\",\"wepname\":\"Bolt Pistol\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"FTR\",\"wepid\":\"BP\",\"profileid\":\"0\",\"name\":\"Bolt Pistol\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"Rng &#x2B1F;\",\"$$hashKey\":\"object:171\"}],\"$$hashKey\":\"object:144\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"FTR\",\"wepid\":\"PW\",\"wepname\":\"Power Weapon\",\"weptype\":\"M\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"FTR\",\"wepid\":\"PW\",\"profileid\":\"0\",\"name\":\"Power Weapon\",\"A\":\"5\",\"BS\":\"3+\",\"D\":\"4/6\",\"SR\":\"Lethal 5+\",\"$$hashKey\":\"object:219\"}],\"$$hashKey\":\"object:155\",\"isselected\":true}],\"uniqueactions\":[],\"abilities\":[],\"fireteammax\":0,\"$$hashKey\":\"object:133\",\"optype\":\"DeathWatch Fighter\",\"notes\":\"\",\"curW\":11},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"opname\":\"Ignatio Solarion\",\"description\":\"Veteran xenos hunters know the alien has many forms, each as repugnant as the next. Those who prefer to slay at range equip themselves with artificer-wrought rifles and advanced combination assault guns, firing chitin-piercing rounds or shells filled with mutagenic acid.\",\"M\":\"3&#x2B24;\",\"APL\":\"3\",\"GA\":\"1\",\"DF\":\"3\",\"SV\":\"3+\",\"W\":\"11\",\"keywords\":\"SPACE MARINE, IMPERIUM, ADEPTUS ASTARTES, <CHAPTER>, PRIMARIS, DEATHWATCH VETERAN, GUNNER\",\"weapons\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"CM\",\"wepname\":\"Combi-Melta\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"CM\",\"profileid\":\"0\",\"name\":\"Melta\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"4/5\",\"SR\":\"Combi-DWBG, Rng &#x2B1F;, AP2, Lim, MW4\",\"$$hashKey\":\"object:256\"}],\"$$hashKey\":\"object:229\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"DWBG\",\"wepname\":\"DeathWatch Boltgun\",\"weptype\":\"R\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"DWBG\",\"profileid\":\"0\",\"name\":\"DragonFire\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"No Cover\",\"$$hashKey\":\"object:269\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"DWBG\",\"profileid\":\"1\",\"name\":\"HellFire\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"Rending\",\"$$hashKey\":\"object:270\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"DWBG\",\"profileid\":\"2\",\"name\":\"Kraken\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"P1\",\"$$hashKey\":\"object:271\"},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"DWBG\",\"profileid\":\"3\",\"name\":\"Vengeance\",\"A\":\"4\",\"BS\":\"3+\",\"D\":\"4/4\",\"SR\":\"\",\"$$hashKey\":\"object:272\"}],\"$$hashKey\":\"object:231\",\"isselected\":true},{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"F\",\"wepname\":\"Fists\",\"weptype\":\"M\",\"profiles\":[{\"factionid\":\"IMP\",\"killteamid\":\"SM\",\"fireteamid\":\"DW\",\"opid\":\"GNR\",\"wepid\":\"F\",\"profileid\":\"0\",\"name\":\"Fists\",\"A\":\"3\",\"BS\":\"3+\",\"D\":\"3/4\",\"SR\":\"\",\"$$hashKey\":\"object:306\"}],\"$$hashKey\":\"object:236\",\"isselected\":true}],\"uniqueactions\":[],\"abilities\":[],\"fireteammax\":0,\"$$hashKey\":\"object:134\",\"optype\":\"DeathWatch Gunner\",\"notes\":\"\",\"curW\":11}],\"$$hashKey\":\"object:1171\"}]";
							window.localStorage.setItem("myteams", myteamsjson);
						}
						myteamsjson = $scope.cleanSpecialChars(myteamsjson, false);
						$scope.myteams = JSON.parse(myteamsjson);
						
						// Fill in the additional info for the player's teams
						for (let teamnum = 0; teamnum < $scope.myteams.length; teamnum++) {
							let team = $scope.myteams[teamnum];
							
							// Find this team's killteam
							team.killteam = $scope.getKillteam(team.factionid, team.killteamid);
							
							// Find this team's operatives' fireteams
							for (let opnum = 0; opnum < team.operatives.length; opnum++) {
								team.operatives[opnum].fireteam = $scope.getFireteam(team.factionid, team.killteamid, team.operatives[opnum].fireteamid);
								
								// Set the wepids for this operative
								team.operatives[opnum].wepids = team.operatives[opnum].weapons.map(w => w.wepid).join(",");
							}
							
						}
						
						// Default the dashboard to the user's first team
						//console.log("dashboard.myteam: " + JSON.stringify($scope.dashboard.myteam));
						if ($scope.dashboard.myteam == null || JSON.stringify($scope.dashboard.myteam) == "{}") {
							$scope.selectDashTeam($scope.myteams[0]);
						}
						
						// Check for a team to import
						let importjson = GetQS("importjson");
						if (importjson != "" && importjson != null) {
							$scope.initImportTeam(importjson);
						}
						
						let importteam = GetQS("importteam");
						if (importteam != "" && importteam != null) {
							$scope.initImportTeam2(importteam);
						}
						
						$scope.loading = false;
						$scope.$apply();
					},
					error: function(data, status, error) {
						console.log("Error getting data: " + error);
						toast("Error loading compendium:<br/>" + error);
						$scope.loading = false;
					}
				});
			}
		
			$scope.getFaction = function(factionid) {
				for (let i = 0; i < $scope.factions.length; i++) {
					if ($scope.factions[i].factionid == factionid) {
						// Found it
						return $scope.factions[i];
					}
				}
				
				// Didn't find it
				return null;
			}
			
			$scope.getKillteam = function(factionid, killteamid) {
				let faction = $scope.getFaction(factionid);
				
				if (faction == null) {
					return null;
				}
				
				for (let i = 0; i < faction.killteams.length; i++) {
					if (faction.killteams[i].killteamid == killteamid) {
						// Found it
						return faction.killteams[i];
					}
				}
				
				// Didn't find it
				return null;
			}
			
			$scope.getFireteam = function(factionid, killteamid, fireteamid) {
				let killteam = $scope.getKillteam(factionid, killteamid);
				
				if (killteam == null) {
					return null;
				}
				
				for (let i = 0; i < killteam.fireteams.length; i++) {
					if (killteam.fireteams[i].fireteamid == fireteamid) {
						// Found it
						return killteam.fireteams[i];
					}
				}
				
				// Didn't find it
				return null;
			}
			
			$scope.getOperative = function(factionid, killteamid, fireteamid, opid) {
				let fireteam = $scope.getFireteam(factionid, killteamid, fireteamid);
				
				if (fireteam == null) {
					return null;
				}
				
				for (let i = 0; i < fireteam.operatives.length; i++) {
					if (fireteam.operatives[i].opid == opid) {
						// Found it
						return fireteam.operatives[i];
					}
				}
				
				// Didn't find it
				return null;
			}
		
			$scope.generatenametype = "HUMAN-M";
			$scope.generatedname = "";
			
			$scope.generatename = function() {
				var url = APIURL + "/name.php?nametype=" + $scope.generatenametype;
				$.ajax({
					type: "GET",
					url: url,
					timeout: 5000,
					async: true,
					dataType: 'text',
					success: function(data) {
						$scope.generatedname = data;
						
						$scope.$apply();
					}
				});
			}
			
			$scope.generatename();
		}
	})
;

