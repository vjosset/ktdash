<?php
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
			<div class="m-2">
				<h6>Portraits</h6>
				<button class="btn h3" style="width: 150px;" ng-click="setSetting('display', 'card');" ng-class="settings['display'] == 'card' || settings['display'] == null ? 'btn-primary': 'btn-secondary'">
					<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'card' || settings['display'] == null"></i -->
					<i class="pointer far fa-id-card fa-fw"></i><br/>
					Show
				</button>
				<button class="btn h3" style="width: 150px;" ng-click="setSetting('display', 'list');" ng-class="settings['display'] == 'list' ? 'btn-primary': 'btn-secondary'">
					<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['display'] == 'list'"></i -->
					<i class="pointer fas fa-list fa-fw"></i><br/>
					Hide
				</button>
				
				<br/><br/>
				
				<h6>Operative Numbers</h6>
				<button class="btn h3" style="width: 150px;" ng-click="setSetting('showopseq', 'y');" ng-class="settings['showopseq'] == 'y' ? 'btn-primary': 'btn-secondary'">
					<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['showopseq'] == 'y'"></i -->
					<i class="pointer fas fa-list-ol fa-fw"></i><br/>
					Show
				</button>
				<button class="btn h3" style="width: 150px;" ng-click="setSetting('showopseq', 'n');" ng-class="settings['showopseq'] == 'n' || settings['showopseq'] == null ? 'btn-primary': 'btn-secondary'">
					<!-- i class="fas fa-check fa-fw" style="top: 2px; left: 2px;" ng-if="settings['showopseq'] == 'n' || settings['showopseq'] == null"></i -->
					<i class="pointer fas fa-list fa-fw"></i><br/>
					Hide
				</button>
			</div>
			
			<h2>Dashboard Defaults</h2>
			<div class="m-2">
				<h6>Default VP</h6>
				<em>How many VPs your roster should start with when deployed or reset</em><br/>
				<select class="formcontrol" name="startvp" ng-model="settings['startvp']" ng-change="setSetting('startvp', settings['startvp']);">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
				
				<br/><br/>
				
				<h6>Default CP</h6>
				<em>How many CPs your roster should start with when deployed or reset</em><br/>
				<select class="formcontrol" name="startcp" ng-model="settings['startcp']" ng-change="setSetting('startcp', settings['startcp']);">
					<option value="0">0</option>
					<option value="1">1</option>
					<option value="2">2</option>
				</select>
			</div>
			
			<h2>Install</h2>
			<div class="m-2">
				Click <a href="#" onclick="$('#installmodal').modal('show');">here</a> to install this app on your phone.
				<br/><br/>
			</div>
		</div>
		<?php include "footer.shtml" ?>
	</body>
</html>