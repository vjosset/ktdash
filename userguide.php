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
			<em>See also the <a href="https://ktdash.app/img/UserGuide_v0.1.pdf" target="_blank">user-created guide</a> by <a href="/u/skrdla">Skrdla</a> and the <a href="/faq.php">FAQ</a>.</em>
			<br/><br/>
			<h4 id="how-it-works">How It Works</h4>
			<div class="ms-2">
				<ol>
					<li><a href="/signup.html">Sign Up</a> or <a href="login.htm">Log In</a></li>
					<li>Create or import a roster in <a href="#my-rosters">My Rosters</a></li>
					<li>Play your game in the <a href="#dashboard">Dashboard</a></li>
				</ol>
			</div>
			
			<hr/>

			<h4 id="quick-tips">Quick Tips</h4>
			<div class="ms-2">
				<ul>
					<li>Consult the <a href="https://ktdash.app/faq.php">FAQ</a> for the most common questions and solutions.</li>
					<li>Almost all options and actions can be taken from the &quot;three dots&quot; button throughout the app</li>
					<li>Use <a href="https://ktdash.app/u">My Rosters</a> menu to manage your rosters.</li>
					<li>Use the <a href="https://ktdash.app/dashboard">Dashboard</a> to track your game turns, tacops, ploys, operative orders and activations and wounds, etc. Everything you need to play your games without trackers and tokens and wound markers!</li>
					<li>If your opponent also has their roster in KTDash, use the &quot;Select Opponent&quot; option on the <a href="https://ktdash.app/dashboard">Dashboard</a> to keep track of their roster&#39;s TacOps, ploys, and operative wounds.</li>
					<li>Use the <a href="https://ktdash.app/settings.php">Settings</a> to customize the site and application to your liking.</li>
				</ul>
			</div>

			<hr/>

			<h4 id="my-rosters">My Rosters</h4>
			<div class="ms-2">
				<p>
					The <a href="/u">My Rosters</a> screen is where you can manage your teams/rosters.
					From here, you can create, edit, or delete your rosters or import an existing one.
					If you are viewing another user&#39;s page, you can import their rosters into your own as well!
				</p>
				
				<h6 id="creating-a-new-roster">Creating A New Roster</h6>
				<p>
					From <a href="/u">My Rosters</a>, use the three-dots menu to &quot;Add New Roster&quot;.<br>Then enter a name for your roster and select the faction and killteam for your new roster.
					Once the roster is created, it is empty and has no operatives. Use the three-dots menu to &quot;Add Operative&quot;.<br>Use the dialog to select the operative type, and enter a name for that operative or use the name generator. Then, select the weapons for that operative. Finally, click &quot;Add to Team&quot; to save your selection.
					Then repeat for each operative you want to add to your roster.
				</p>
				<p>
					If that sounds too tedious, you can also import a pre-built roster or another user&#39;s roster and then tweak it to your liking.
				</p>
				
				<h6 id="importing-a-roster">Importing A Roster</h6>
				<p>
					When looking at any user&#39;s profile, you can see all their rosters. Click on any of them to view their details, and use the three-dots menu to add a copy of that roster to your own rosters. 
					You can also select from a set of pre-built rosters in the &quot;My Rosters&quot; three-dots menu &quot;Pre-Built Rosters&quot;, then select the three-dots menu on any of these to view their details or import them.
				</p>
				<p>
					Another place to see &quot;spotlighted&quot; rosters is on the killteam&#39;s &quot;Rosters&quot; tab. Same as other roster views, you can use the three-dots menu to import any of these rosters into your own.
				</p>
			</div>
			
			<hr/>

			<h4 id="managing-roster-operatives">Managing Roster Operatives</h4>
			<div class="ms-2">
				<h6 id="operative-cards">Operative Cards</h6>
				<p>The operative cards show all their stats, weapons, abilities, and unique actions. Click or tap of any Weapon rule, Equipment, Ability, or Unique Action to view its details.</p>
				
				<h6 id="operative-options">Operative Options</h6>
				<p>When viewing one of your rosters, you will see a card for each operative. Use the three-dots menu to edit them. This edit dialog lets you change their name, weapons, equipments, and certain special selections based on teams (for example, Chapter Tactics for Angels Of Death).</p>
				<h6 id="operative-portraits">Operative Portraits</h6>
				<p>On each operative card, you can also upload a photo of your mini to make sure you can find them quickly while playing your games. In addition, rosters that have a photo of each operative and a group photo for the roster itself will be put on the spotlight. Spotlighted rosters are shown on each killteam&#39;s &quot;Rosters&quot; tab and are randomly selected for display on the homepage.</p>
			</div>
			<hr/>

			<h4 id="dashboard">Dashboard</h4>
			<div class="ms-2">
				<p>The <a href="/dashboard">Dashboard</a> is where you can play your games. This screen looks very similar to the Roster view, but you will see some differences.</p>
				<h6 id="operatives">Operatives</h6>
				<ul>
					<li>Each operative has a checkbox to indicate whether they have activated during this Turning Point or not</li>
					<li>Each operative has an icon representing its current order. Just click or tap that icon to toggle between Concealed and Engaged. </li>
					<li>The Operative&#39;s Wounds can be increased/decreased. When an operative falls below half of its total Wounds, it is Injured and its stats are updated accordingly.</li>
				</ul>

				<h6 id="selecting-operatives">Selecting Operatives</h6>
				<p>If you built a full roster but only some of your operatives are actually playing, use the Dashboard&#39;s three-dots menu to &quot;Select Operatives&quot;. The Select Operatives dialog lets you choose which operatives are actually playing this game, and includes a tab for killteam composition to help you make the right selection.</p>
				
				<h6 id="selecting-your-opponent">Selecting Your Opponent</h6>
				<p>
					If your opponent is also on KTDash, you can view their roster during your game to see their operatives and current state and wounds, view their active Ploys, and view their available equipments.<br/>
					The opponent view is automatically updated, so your view of their team will always be up to date.
				</p>
				
				<h6 id="using-the-game-trackers">Using The Game Trackers</h6>
				<p>
					Use the TP, MP, and CP trackers to keep track of current Turning Point, Victory Points, and Command Points. Note that increasing the Turning Point will reset all of your operatives from Expended to Ready.<br/>
					Resetting the dashboard will reset all operatives back to their starting Wounds count and reset CP, VP, and TP to their default starting values.
				</p>
			</div>
			
			<hr/>

			<h4 id="settings">Settings</h4>
			<div class="ms-2">
				<p>The <a href="/settings.php">Settings</a> screen is where you can customize the appearance and behavior of the app. Most of these settings are self-explanatory; feel free to play around with them to find what best fits your needs.</p>
			</div>

		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>
