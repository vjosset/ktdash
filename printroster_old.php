<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
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
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initPrintRoster('<?php echo $myRoster->rosterid ?>', true, 'print');">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<div class="orange container-fluid m-0 p-0">
			<h2 class="m-0 p-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Killteam Composition">
				<span ng-bind="myRoster.rostername"><?php echo $myRoster->rostername ?></span>
				<span class="ng-cloak" ng-hide="loading">({{ myRoster.killteamname }})</span>
			</h2>
		</div>
		<a href="https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?>">https://ktdash.app/roster.php?rid=<?php echo $myRoster->rosterid ?></a>
		<br/><br/>
		
		<!-- loadWaiter -->
		<h4 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Roster...
			</div>
		</h4>
		
		<div class="row ng-cloak" style="page-break-after: always;">
			<div class="col-8">
				<!-- Roster Summary -->
				<div class="ng-cloak">
					<div id="operatives" ng-if="myRoster.operatives.length > 0">
						<div ng-repeat="operative in myRoster.operatives" class="px-1">
							<h6 class="d-inline">{{ operative.opname }}</h6> {{ operative.optype }} 
							<br/>
							
							<ANY class="d-inline" ng-repeat="weapon in operative.weapons">{{ $first ? "" : ", " }}
								<ANY ng-switch="weapon.weptype" class="fas fa-fw">
								  <ANY ng-switch-when="R">&#x2295;</ANY>
								  <ANY ng-switch-when="M">&#x2694;</ANY>
								  <ANY ng-switch-default>&#x26ED;</ANY>
								</ANY> {{ weapon.wepname }}</ANY><br/>
							
							<ANY class="d-inline" ng-repeat="eq in operative.equipments">{{ $first ? "" : ", " }} {{ eq.eqname }}<span ng-if="eq.eqpts > 0"> ({{ eq.eqpts }} EP)</span></ANY>
							<br ng-if="operative.equipments.length > 0"/>
							<br/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-4 text-end">
				<!-- Roster QR Code -->
				<img ng-src="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=https://ktdash.app/roster.php?rid={{ myRoster.rosterid }}" />
			</div>
		</div>
		
		<!-- Show this roster and its operatives -->
		<div class="ng-cloak p-0 m-1 container-fluid" ng-hide="loading">
			<div ng-if="myRoster.operatives == null || myRoster.operatives.length == 0">
				This roster does not have any operatives
			</div>
			
			<!-- Show this roster's operatives -->
			<div id="operatives" ng-if="myRoster.operatives.length > 0">
				<div ng-repeat="operative in myRoster.operatives" class="px-1" style="page-break-inside: avoid; page-break-before: auto;">
					<div class="row">
						<div class="col-7">
							<!-- Operative Name -->
							<h2>{{ operative.opname }}</h2>
						</div>
						<div class="col-5 text-end">
							<!-- Operative Type -->
							{{ operative.optype }}<br/>
							<!-- Wounds Tracker -->
							<h6 class="d-inline">W:</h6> <input type="checkbox" ng-repeat="i in [1, 2, 3, 4, 5, 6, 7, 8, 9 , 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21]" ng-if="i <= operative.W">
						</div>
					</div>
					
					<!-- Keywords -->
					<em class="text-tiny">{{ operative.keywords }}</em>
					
					<!-- Operative Stats -->
					<div class="row">
						<h5 class="col-2 orange text-center">M</h5>
						<h5 class="col-2 orange text-center">APL</h5>
						<h5 class="col-2 orange text-center">GA</h5>
						<h5 class="col-2 orange text-center">DF</h5>
						<h5 class="col-2 orange text-center">SV</h5>
						<h5 class="col-2 orange text-center">W</h5>
					</div>
					<div class="row">
						<h5 class="col-2 text-center" ng-bind-html="operative.M"></h5>
						<h5 class="col-2 text-center">{{ operative.APL }}</h5>
						<h5 class="col-2 text-center">{{ operative.GA }}</h5>
						<h5 class="col-2 text-center">{{ operative.DF }}</h5>
						<h5 class="col-2 text-center">{{ operative.SV }}</h5>
						<h5 class="col-2 text-center">{{ operative.W }}</h5>
					</div>
					
					<!-- Weapons -->
					<div class="px-1">
						<table ng-if="operative.weapons.length > 0" width="100%" class="line-top-light">
							<thead>
								<tr>
									<td>
										<h6>Weapons</h6>
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
									<td width="70%">						
										<ANY ng-switch="weapon.weptype" class="fas fa-fw">
										  <ANY ng-switch-when="R">&#x2295;</ANY>
										  <ANY ng-switch-when="M">&#x2694;</ANY>
										  <ANY ng-switch-default>&#x26ED;</ANY>
										</ANY>
										{{ weapon.wepname }}
										<div class="pointer d-inline" ng-if="weapon.profiles[0].SR != ''" ng-bind-html=" '(' + weapon.profiles[0].SR + ')'" ng-click="initwepsr(weapon, weapon.profiles[0]);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;{{ weapon.profiles[0].A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;&nbsp;{{ weapon.profiles[0].BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
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
									<td width="70%">
										&nbsp;&nbsp;&nbsp;&nbsp;
										- {{ profile.name }}
										<div class="pointer d-inline" ng-if="profile.SR != ''" ng-bind-html=" '(' + profile.SR + ')'" ng-click="initwepsr(weapon, profile);" style="font-style:italic;"></div>
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;{{ profile.A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;&nbsp;{{ profile.BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
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
									<td class="text-center h6">
										&nbsp;&nbsp;{{ eq.weapon.profiles[0].A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;&nbsp;{{ eq.weapon.profiles[0].BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
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
									<td class="text-center h6">
										&nbsp;&nbsp;{{ profile.A }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;&nbsp;{{ profile.BS }}&nbsp;&nbsp;
									</td>
									<td class="text-center h6">
										&nbsp;&nbsp;{{ profile.D }}&nbsp;&nbsp;
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<!-- Abilities -->
					<div class="line-top-light px-1 m-0" ng-if="operative.abilities.length > 0">
						<h6>Abilities</h6>
						<div ng-style="(operative.abilities.length > 1 || operative.abilities[0].description.length > 500) && {'columns': '200px 2'}">
							<div class="px-1" ng-repeat="ab in operative.abilities">
								<strong>{{ ab.title }}: </strong>
								<p class="d-inline px-2" ng-bind-html="ab.description" style="text-align:justify;"></p>
							</div>
						</div>
					</div>
					
					<!-- Unique Actions -->
					<div class="line-top-light px-1 m-0" ng-if="operative.uniqueactions.length > 0">
						<h6>Unique Actions</h6>
						<div ng-style="(operative.uniqueactions.length > 1 || operative.uniqueactions[0].description.length > 500) && {'columns': '200px 2'}">
							<div class="px-1" ng-repeat="ua in operative.uniqueactions">
								<strong>{{ ua.title }} ({{ ua.AP }} AP): </strong>
								<p class="d-inline px-2" ng-bind-html="ua.description" style="text-align:justify;"></p>
							</div>
						</div>
					</div>
					
					<!-- Equipment -->
					<div class="line-top-light px-1 m-0" ng-if="operative.equipments.length > 0">
						<h6>Equipment</h6>
						<div ng-style="(operative.equipments.length > 1 || operative.equipments[0].eqdescription.length > 500) && {'columns': '200px 2'}">
							<div class="px-1" ng-repeat="eq in operative.equipments">
								<strong>{{ eq.eqname }} <span ng-if="eq.eqpts > 0">({{ eq.eqpts }} EP)</span>: </strong>
								<p class="d-inline px-2" ng-bind-html="eq.eqdescription" style="text-align:justify;"></p>
							</div>
						</div>
					</div>
					
					<br/><br/>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>