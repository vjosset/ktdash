<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;
	
	$me = Session::CurrentUser();
	
	if ($me == null) {
		// Not logged in
		header("Location: /login.htm");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			include "header.shtml";
			$pagetitle = "Settings";
			$pagedesc  = "KTDash Settings";
			$pagekeywords = "Settings";
			$pageurl   = "https://ktdash.app/settings.php";
			include "og.php";
		?>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl" ng-init="init();">
		<?php
			include "topnav.shtml";
			include "templates/dialogs.shtml";
		?>
		
		<script type="text/javascript">
			te("settings", "view");
		</script>
		
		<h1 class="orange cinzel">Settings</h1>
		
		<!-- Settings -->
		<div class="container">
			<h2>Display</h2>
			<div class="m-2 row">
				<div class="col-12 col-md-6">
					<h6>Portraits</h6>
					Displays the portraits for operatives and rosters if enabled.<br/>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('display', 'card');" ng-class="settings['display'] == 'card' || settings['display'] == null ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'card' || settings['display'] == null"></i -->
						<i class="pointer far fa-id-card fa-fw"></i><br/>
						Show
					</button>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('display', 'list');" ng-class="settings['display'] == 'list' ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'list'"></i -->
						<i class="pointer fas fa-list fa-fw"></i><br/>
						Hide
					</button>
					<br/><br/>
				</div>
				
				<div class="col-12 col-md-6">
					<h6>Operative Numbers</h6>
					Displays operative numbers in the roster and dashboard if enabled.<br/>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('showopseq', 'y');" ng-class="settings['showopseq'] == 'y' ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['showopseq'] == 'y'"></i -->
						<i class="pointer fas fa-list-ol fa-fw"></i><br/>
						Show
					</button>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('showopseq', 'n');" ng-class="settings['showopseq'] == 'n' || settings['showopseq'] == null ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['showopseq'] == 'n' || settings['showopseq'] == null"></i -->
						<i class="pointer fas fa-bars fa-fw"></i><br/>
						Hide
					</button>
					<br/><br/>
				</div>
				
				<div class="col-12 col-md-6">
					<h6>Narrative Info</h6>
					Shows or hides narrative play information (Battle Honours, Rare Equipment, XP)
					<br/>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('shownarrative', 'y');" ng-class="settings['shownarrative'] == 'y' ? 'btn-primary': 'btn-secondary'">
						<i class="pointer fas fa-check fa-fw"></i><br/>
						Show
					</button>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('shownarrative', 'n');" ng-class="settings['shownarrative'] == 'n' ? 'btn-primary': 'btn-secondary'">
						<i class="pointer fas fa-times fa-fw"></i><br/>
						Hide
					</button>
					<br/><br/>
				</div>
				
				<div class="col-12 col-md-6">
					<h6>Auto-Apply Equipment Modifiers</h6>
					Automatically applies equipment modifiers to operatives and weapons if enabled.
					<br/>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('applyeqmods', 'n');" ng-class="settings['applyeqmods'] == 'n' ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'card' || settings['display'] == null"></i -->
						<i class="pointer fas fa-bars fa-fw"></i><br/>
						Disable
					</button>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('applyeqmods', 'y');" ng-class="settings['applyeqmods'] == 'y' ? 'btn-primary': 'btn-secondary'">
						<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'list'"></i -->
						<i class="pointer fas fa-magic fa-fw"></i><br/>
						Enable
					</button>
					<br/>
					This feature is <strong>EXPERIMENTAL</strong> and may not work as expected or break other functionality.
					<br/><br/>
				</div>
			</div>
			
			<h2 class="line-top-light">Dashboard Defaults</h2>
			<div class="m-2 row">
				<div class="col-12 col-md-6">
					<div class="row">
						<h4 class="d-inline col-6">Starting VP</h4>
						<select class="col-2" name="startvp" ng-model="settings['startvp']" ng-change="setSetting('startvp', settings['startvp']);">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
						</select>
					</div>
					<em>How many Victory Points your roster should start with when deployed or reset</em>
					<br/><br/>
				</div>
				
				<div class="col-12 col-md-6">
					<div class="row">
						<h4 class="d-inline col-6">Starting CP</h4>
						<select class="col-2" name="startcp" ng-model="settings['startcp']" ng-change="setSetting('startcp', settings['startcp']);">
							<option value="0">0</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
						</select>
					</div>
					<em>How many Command Points your roster should start with when deployed or reset</em>
					<br/><br/>
				</div>
				
				<div class="col-12 col-md-6">
					<h4>Auto-Increment CP</h4>
					Automatically increases Command Points when moving to the next Turning Point if enabled.
					<br/>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('autoinccp', 'y');" ng-class="settings['autoinccp'] == 'y' ? 'btn-primary': 'btn-secondary'">
						<i class="pointer fas fa-check fa-fw"></i><br/>
						Yes
					</button>
					<button class="btn h3" style="width: 120px;" ng-click="setSetting('autoinccp', 'n');" ng-class="settings['autoinccp'] == 'n' ? 'btn-primary': 'btn-secondary'">
						<i class="pointer fas fa-times fa-fw"></i><br/>
						No
					</button>
					<br/><br/>
				</div>
			</div>
			
			<!--
			<h2 class="line-top-light">Install</h2>
			<div class="m-2">
				Click <a href="#" onclick="$('#installmodal').modal('show');">here</a> to install this app on your phone.
				<br/><br/>
			</div>
			-->
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>