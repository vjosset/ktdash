<div?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = "User Guide";
		$pagedesc  = "Tutorial for first-time users";
		$pagekeywords = "user guide, guide, tutorial, getting started, FAQ, Help, Support";
		$pageimg   = "https://ktdash.app/img/og/home.png";
		$pageurl   = "https://ktdash.app/userguide.php";
		
		include "og.php"
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php include "topnav.shtml" ?>
		
		<h1 class="orange"><i class="far fa-question-circle fa-fw"></i> User Guide</h1>

		<div class="container">
			<h2>Quick Tips</h2>
			<div class="ms-2">
				<ul>
					<li>
						Consult the <a href="/faq.php">FAQ</a> for the most common questions and solutions.
					</li>
					<li>
						Almost all options and actions can be taken from the "meatball" menu on various cards and menus:<br/>
						<img src="/img/guide/meatball.jpg" class="img-fluid"/>
					</li>
					<li>
						Use <a href="/u">My Rosters</a> menu to manage your rosters.
					</li>
					<li>
						Use the <a href="/dashboard">Dashboard</a> to track your game turns, tacops, ploys, operative orders and activations and wounds, etc.
						Everything you need to play your games wihtout trackers and tokens and wound markers!
					</li>
					<li>
						If your opponent also has their roster in KTDash, use the "Select Opponent" option on the <a href="/dashboard">Dashboard</a> to keep track of their roster's TacOps, ploys, and operative wounds.
					</li>
					<li>
						Use the <a href="/settings.php">Settings</a> to customize the site and application to your liking.
					</li>
				</ul>
			</div>
			
			<hr/>

			<h2>Your Rosters</h2>
			<div class="ms-2">
				There are two main ways to get a new roster: Create a new one from scratch, or import an existing one.<br/>
				<strong>Create A New Roster From Scratch</strong><br/>
				<div>
					Use your "My Rosters" page's action menu to create a new roster, then enter a name for your roster and select its faction and killteam:<br/>
					<img src="/img/guide/createroster1.jpg" class="img-fluid"/><br/>
					<img src="/img/guide/createroster2.jpg" class="img-fluid"/>
				</div>

				<strong>Import An Existing Roster</strong><br/>
				<div>
					You can import any other user's roster, including some <a href="/u/ktdash">pre-built</a> ones from KTDash.
					Just open any roster's menu and select "Import Roster". You will then be sent to your own copy of that roster which you can customize as you see fit.<br/>
					<img src="/img/guide/import.jpg" class="img-fluid"/>
				</div>
			</div>
			
			<hr/>

			<h2>The Dashboard</h2>
			<div class="ms-2">
				[TBD]
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>
