<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	// Get the requested roster id
	$rid = getIfSet($_REQUEST['r'], '');
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rid']);
	}
	if ($rid == null || $rid == '') {
		$rid = getIfSet($_REQUEST['rosterid']);
	}
	
	$myRoster = Roster::GetRoster($rid);
	if ($myRoster == null) {
		// Roster not found
		//	Send them to My Rosters I guess?
		header("Location: /rosters.php");
		exit;
	}
	$myRoster->loadOperatives();
	$me = Session::CurrentUser();
	$ismine = $me != null && $me->userid == $myRoster->userid;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = $myRoster->rostername . " - Print Roster";
			$pagedesc  = $myRoster->rostername . " - Print Roster";
			$pageimg   = "https://ktdash.app/api/rosterportrait.php?rid={$myRoster->rosterid}";
			$pageurl   = "https://ktdash.app/printroster.php?rid={$myRoster->rosterid}";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initRoster('<?php echo $myRoster->rosterid ?>', false, 'print');">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<div class="orange container-fluid m-0 p-0">
			<h1 class="m-0 p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Killteam Composition">
				<span ng-bind="myRoster.rostername"><?php echo $myRoster->rostername ?></span> ({{ myRoster.killteamname }})
			</h1>
		</div>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Roster...
			</div>
		</h3>
		
		<!-- Show this roster and its operatives -->
		<div class="ng-cloak p-0 m-1 container" ng-hide="loading">
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives
			</div>
			
			<!-- Show this roster's operatives -->
			<div id="operatives" ng-if="myRoster.operatives.length > 0">
				<div ng-repeat="operative in myRoster.operatives" class="px-1" style="page-break-after: always;">
					<!-- Operative Name -->
					<h2>{{ operative.opname }}</h2>
					
					<div class="row">
						<div class="col-5">
							<!-- Operative Type -->
							{{ operative.optype }}
						</div>
						<div class="col-7 text-end">
							<!-- Wounds Tracker -->
							<h6 class="d-inline">W:</h6> <input type="checkbox" ng-repeat="i in [1, 2, 3, 4, 5, 6, 7, 8, 9 , 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]" ng-if="i <= operative.W">
						</div>
					</div>
					
					<!-- Operative Stats -->
					<div class="row">
						<h4 class="col-2 orange text-center">M</h4>
						<h4 class="col-2 orange text-center">APL</h4>
						<h4 class="col-2 orange text-center">GA</h4>
						<h4 class="col-2 orange text-center">DF</h4>
						<h4 class="col-2 orange text-center">SV</h4>
						<h4 class="col-2 orange text-center">W</h4>
					</div>
					<div class="row">
						<h4 class="col-2 text-center" ng-bind-html="operative.M"></h4>
						<h4 class="col-2 text-center">{{ operative.APL }}</h4>
						<h4 class="col-2 text-center">{{ operative.GA }}</h4>
						<h4 class="col-2 text-center">{{ operative.DF }}</h4>
						<h4 class="col-2 text-center">{{ operative.SV }}</h4>
						<h4 class="col-2 text-center">{{ operative.W }}</h4>
					</div>
					
					<!-- Weapons -->
					<div class="px-1">
						<table ng-if="operative.weapons.length > 0" width="100%" class="line-top-light">
							<thead>
								<tr>
									<td>
										<h5>Weapons</h5>
									</td>
									<td class="text-center">
										<h6>&nbsp;&nbsp;A&nbsp;&nbsp;</h6>
									</td>
									<td class="text-center">
										<h6>&nbsp;&nbsp;BS&nbsp;&nbsp;</h6>
									</td>
									<td class="text-center">
										<h6>&nbsp;&nbsp;D&nbsp;&nbsp;</h6>
									</td>
								</tr>
							</thead>
							
							<!-- Regular Weapons -->
							<tbody ng-repeat="weapon in operative.weapons">
								<!-- Single Profile -->
								<tr ng-if="weapon.profiles.length < 2">
									<td>						
										<ANY ng-switch="weapon.weptype" class="fas fa-fw">
										  <ANY ng-switch-when="R">&#x2295;</ANY>
										  <ANY ng-switch-when="M">&#x2694;</ANY>
										  <ANY ng-switch-default>&#x26ED;</ANY>
										</ANY>
										{{ weapon.wepname }}
										<div class="pointer d-inline" ng-if="weapon.profiles[0].SR != ''" ng-bind-html=" '(' + weapon.profiles[0].SR + ')'" ng-click="initwepsr(weapon, weapon.profiles[0]);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ weapon.profiles[0].A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5" ng-style="{ color: operative.isInjured ? 'gainsboro' : '' }">
										&nbsp;&nbsp;&nbsp;{{ weapon.profiles[0].BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ weapon.profiles[0].D }}&nbsp;&nbsp;
									</td>
								</tr>
								
								<!-- Multi-Profile -->
								<tr ng-if="weapon.profiles.length > 1">
									<td colspan="4">						
										<ANY ng-switch="weapon.weptype" class="fas fa-fw">
										  <ANY ng-switch-when="R">&#x2295;</ANY>
										  <ANY ng-switch-when="M">&#x2694;</ANY>
										  <ANY ng-switch-default>&#x26ED;</ANY>
										</ANY>
										{{ weapon.wepname }}
									</td>
								</tr>
								<tr ng-if="weapon.profiles.length > 1" ng-repeat="profile in weapon.profiles">
									<td>
										&nbsp;&nbsp;&nbsp;&nbsp;
										- {{ profile.name }}
										<div class="pointer d-inline" ng-if="profile.SR != ''" ng-bind-html=" '(' + profile.SR + ')'" ng-click="initwepsr(weapon, profile);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ profile.A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5" ng-style="{ color: operative.isInjured ? 'gainsboro' : '' }">
										&nbsp;&nbsp;&nbsp;{{ profile.BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ profile.D }}&nbsp;&nbsp;
									</td>
								</tr>
							</tbody>
							
							<!-- Equipment Weapons -->
							<tbody ng-repeat="eq in operative.equipments">
								<!-- Single Profile -->
								<tr ng-if="eq.weapon.profiles.length < 2">
									<td>						
										&#x26ED;
										{{ eq.weapon.wepname }}
										<div class="d-inline" ng-if="eq.weapon.profiles[0].SR != ''" ng-bind-html=" '(' + eq.weapon.profiles[0].SR + ')'" ng-click="initwepsr(eq.weapon, eq.weapon.profiles[0]);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ eq.weapon.profiles[0].A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5" ng-style="{ color: operative.isInjured ? 'gainsboro' : '' }">
										&nbsp;&nbsp;&nbsp;{{ eq.weapon.profiles[0].BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ eq.weapon.profiles[0].D }}&nbsp;&nbsp;
									</td>
								</tr>
								
								<!-- Multi-Profile -->
								<tr ng-if="eq.weapon.profiles.length > 1">
									<td colspan="4">						
										&#x26ED;
										{{ eq.weapon.wepname }}
									</td>
								</tr>
								<tr ng-if="eq.weapon.profiles.length > 1" ng-repeat="profile in weapon.profiles">
									<td>
										&nbsp;&nbsp;&nbsp;&nbsp;
										- {{ profile.name }}
										<div class="d-inline" ng-if="profile.SR != ''" ng-bind-html=" '(' + profile.SR + ')'" ng-click="initwepsr(weapon, profile);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ profile.A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5" ng-style="{ color: operative.isInjured ? 'gainsboro' : '' }">
										&nbsp;&nbsp;&nbsp;{{ profile.BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h5">
										&nbsp;&nbsp;{{ profile.D }}&nbsp;&nbsp;
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<!-- Abilities -->
					<div class="line-top-light px-1 m-0" ng-if="operative.abilities.length > 0">
						<h5>Abilities</h5>
						<div class="px-1" ng-repeat="ab in operative.abilities">
							<h6 class="d-inline">{{ ab.title }}</h6>
							<p class="px-2" ng-bind-html="ab.description"></p>
						</div>
					</div>
					
					<!-- Unique Actions -->
					<div class="line-top-light px-1 m-0" ng-if="operative.uniqueactions.length > 0">
						<h5>Abilities</h5>
						<div class="px-1" ng-repeat="ua in operative.uniqueactions">
							<h6 class="d-inline">{{ ua.title }} ({{ ua.AP }} AP)</h6>
							<p class="px-2" ng-bind-html="ua.description"></p>
						</div>
					</div>
					
					<!-- Equipment -->
					<div class="line-top-light px-1 m-0" ng-if="operative.equipments.length > 0">
						<h5>Equipment</h5>
						<div class="px-1" ng-repeat="eq in operative.equipments">
							<h6 class="d-inline">{{ eq.eqname }} <span ng-if="eq.eqpts > 0">({{ eq.eqpts }} EP)</span></h6>
							<p class="px-2" ng-bind-html="eq.eqdescription"></p>
						</div>
					</div>
					
					<hr />
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>