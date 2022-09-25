<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = "Pre-Built Teams";
		$pagedesc  = "Pre-built teams ready to import";
		$pageimg   = "https://ktdash.app/img/og/PrebuiltTeams.png";
		$pageurl   = "https://ktdash.app/prebuilt.php";
		
		include "og.php"
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="initUserTeams('prebuilt');">
		<!--#include virtual="/topnav.shtml" -->
			
		<!-- Dialogs -->
		<?php include "templates/dialogs.shtml" ?>
		
		<h1 class="orange"><span class="fas fa-users fa-fw"></span>&nbsp;Pre-Built Teams</h1>
		
		<!-- loadWaiter -->
		<h3 class="center" ng-show="loading">
			<br/>
			<div>
				<i class="fas fa-undo-alt fa-fw rotate" ></i>
				<br />
				Loading Teams...
			</div>
		</h3>
		<br/>
		<!-- Show this player's teams -->
		<div class="container" ng-hide="loading">
			<div ng-repeat="myTeam in myTeams track by $index">
				<div class="row">
					<div class="col-7">
						<h3 style="display: inline;"><a href="/userteam.php?utid={{ myTeam.userteamid }}">
							{{myTeam.userteamname}}</a>
						</h3>
						<span>
							(<a ng-href="/killteam.php?fa={{myTeam.factionid}}&kt={{myTeam.killteamid}}">{{myTeam.killteamname}}</a>)
						</span>
					</div>
				</div>
				<div>
					{{ myTeam.opList }}
				</div>
				<hr ng-if="!$last" style="margin-left: 10px; margin-right: 10px;" />
			</div>
		</div>
		<!--#include virtual="/footer.shtml" -->
	</body>
</html>