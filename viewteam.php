<?php
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		// Parse this team name from the input
		$inputdata = explode('|', $_REQUEST['importteam'], 4);
		$teamname = $inputdata[0];
		$factionid = $inputdata[1];
		$killteamid = $inputdata[2];
		
		$faction = Faction::GetFaction($factionid);
		$killteam = KillTeam::GetKillTeam($factionid, $killteamid);
		
		$pagetitle = $teamname . " - " . $killteam->killteamname . " KillTeam";
		$pagedesc  = "Import " . $killteam->killteamname . " KillTeam " . $teamname;
		$pageimg   = "https://ktdash.app/img/portraits/". $factionid . "/" . $killteamid . "/" . $killteamid . ".png";
		$pageurl   = "https://ktdash.app/viewteam.php?mportteam=" . $_REQUEST['importteam'];
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="init();">
		<?php include "topnav.shtml" ?>
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<script type="text/javascript">
			trackEvent("myteams", "viewimportteam", GetQS("importteam").split("|")[0]);
		</script>
		
		<!-- Show the imported team -->
		<h1 class="cinzel orange">Import Team</h1>
		<div class="container">
			<div model="importTeam">
				<div class="row cinzel orange">
					<div class="col-8">
						<h3 class="cinzel orange">
							{{ importTeam.teamname }}
						</h3>
						<em class="oswald small">({{ importTeam.killteam.killteamname }} KillTeam)</em>
					</div>
					<div class="col-4 oswald text-end" ng-click="saveImportTeam();">
						<i class="far fa-plus-square fa-fw"></i> Import
					</div>
				</div>
				<div id="teamops_{{$index}}" ng-if="importTeam.operatives.length == 0" class="oswald collapse show">
					(This team doesn't have any operatives)
				</div>
				<div id="teamops_{{$index}}" ng-if="importTeam.operatives.length > 0" class="collapse show">
					<div ng-if="importTeam.operatives.length > 0" ng-repeat="operative in importTeam.operatives track by $index">
						<div class="row">
							<div class="col-8 cinzel">
								<div class="h4 cinzel">{{ operative.opname }}</div>
							</div>
							<div class="col-4 text-end oswald">
								<!-- i class="fas fa-arrow-up fa-fw" ng-click="moveOpUp(team, operative, $index);"></i -->
								<!-- i class="fas fa-arrow-down fa-fw" ng-click="moveOpDown(team, operative, $index);"></i -->
								<i class="fas fa-edit fa-fw" ng-click="initEditOp(operative, team);"></i>
								<!-- i class="fas fa-trash-alt fa-fw" ng-click="initRemoveOperative(operative, team);"></i -->
							</div>
						</div>
						<div class="container oswald">
							<em>{{ operative.fireteam.fireteamname }} - {{ operative.optype }}</em>
							<br/>
							<span ng-repeat="weapon in operative.weapons" class="d-inline">
								{{ weapon.weptype == "R" ? "&#x2295;" : "&#x2694;" }} {{ weapon.wepname }}
								{{$last ? '' : ', '}}							
							</span>
						</div>
						<hr/>
						
						<!-- div class="row cinzel text-center line-top-light">
							<div class="col-12 text-start">
								{{ operative.opname }}
								<em class="small oswald">({{ operative.optype }}) </em>
							</div>
						</div>
						<div class="row cinzel text-center">
							<div class="col-2">M</div>
							<div class="col-2">APL</div>
							<div class="col-2">GA</div>
							<div class="col-2">DF</div>
							<div class="col-2">SV</div>
							<div class="col-2">W</div>
						</div>
						<div class="row cinzel text-center">
							<div class="col-2" ng-bind-html="operative.M"></div>
							<div class="col-2" ng-bind-html="operative.APL"></div>
							<div class="col-2" ng-bind-html="operative.GA"></div>
							<div class="col-2" ng-bind-html="operative.DF"></div>
							<div class="col-2" ng-bind-html="operative.SV"></div>
							<div class="col-2" ng-bind-html="operative.W"></div>
						</div>
						
						<div class="oswald">
							<span ng-repeat="weapon in operative.weapons track by $index" class="d-inline">
								{{ weapon.weptype == "R" ? "&#x2295;" : "&#x2694;" }} {{ weapon.wepname }}
								{{$last ? '' : ', '}}							
							</span>
						</div -->
					</div>
				</div>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>