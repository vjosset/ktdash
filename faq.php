<?php
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
		$pagetitle = "FAQ";
		$pagedesc  = "Frequently Asked Questions";
		$pagekeywords = "FAQ, Help, Support";
		$pageimg   = "https://ktdash.app/img/og/home.png";
		$pageurl   = "https://ktdash.app/faq.php";
		
		include "og.php"
		?>
		<style>
		<?php include "css/styles.css"; ?>
		</style>
	</head>
	<body ng-app="kt" ng-controller="ktCtrl">
		<?php include "topnav.shtml" ?>
		
		<h1 class="orange">FAQ</h1>
		
		<div class="p-1 m-1">
			<h4>Is there an app I can install on my phone?</h4>
			<p>
				KTDash does not have a native app (like you would find in the App Store for example), but it can be installed as a
				<a href="https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/Guides/What_is_a_progressive_web_app#progressive_web_apps" target="_blank">Progressive Web App (PWA)</a>.<br/>
				PWAs are really just fancy shortcuts that look like a native app, but are actually running inside your browser.<br/>
				<em>(If anyone wants to build a native app, the API is publicly accessible so the back-end is ready. Contact me on <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> if you want more information).<br/></em>
				To install this PWA on your phone, open the site in your phone's browser and look in your browser options for "Install" or something like that.<br/>
				<img src="/img/install_chrome.jpg" width="250" />
			</p>
			
			<h4>I forgot my password!</h4>
			<p>
				If you forgot your password and can't log in, send me a DM in our <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> and we'll work on resetting it together.<br/>
				Since we don't collect email addresses (and I really don't want them), this is currently the only way to reset your password.
			</p>
			
			<h4>I have an idea for a cool new feature or improvement</h4>
			<p>
				If you want to suggest a new feature or improvement, first check the <a href="https://trello.com/b/YWHG6mhJ/backlog" target="_blank">Trello Backlog</a> to see if it is already logged there. 
				If it is already there, you can vote that feature up to help prioritize the next thing to work on.<br/>
				If you don't find your suggestion already in the backlog, come to the "Feature Requests" channel on the <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> and send it in!<br/>
				Also note that the most commmonly-requested features have been implemented in the <a href="/settings.php">Settings</a>; check there first!
			</p>
			
			<h4>I found a bug in the app!</h4>
			<p>
				Please report bugs in the "Report a Bug" channel of our <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a>!
				Bugs and typos are typically fixed within a day, and often within an hour!
			</p>
			
			<h4>I found a typo</h4>
			<p>
				I HATE typos. Since everything is lovingly loaded by hand, there is bound to be typos and spelling mistakes despite our best efforts. Please report these in the "Report a Bug" channel of our <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a>!
				Bugs and typos are typically fixed within a day, and often within an hour!
			</p>
			
			<h4>What is your privacy policy?</h4>
			<p>
				Our privacy policy is "We don't want your personal information, and whatever we collect will never be shared with anyone ever no-way no-how".<br/>
				That being said, a few things to note:
				<ul>
					<li>We use a cookie to keep you logged in</li>
					<li>We use your browser's <a href="https://www.w3schools.com/jsref/prop_win_localstorage.asp" target="_blank">localStorage</a> to hold your settings and preferences</li>
					<li>We use Google Analytics to track site traffic and performance</li>
					<li>The web server's logs include your IP address and are purged every 30 days</li>
					<li>
						All your rosters are publicly visible. That means that you can easily share your roster with other players,
						but it also means you want to be mindful of the content you load, especially the roster and operative portraits.
					</li>
				</ul>
			</p>
			
			<h4>I heard you have some 3d printing STL models available</h4>
			<p>
				You can find all the STL models we designed for terrain and utilities on
				<a href="https://www.thingiverse.com/jodawznev/designs" target="_blank">Thingiverse</a> or <a href="https://cults3d.com/en/users/jodawznev/3d-models" target="_blank">Cults 3D</a>.
			</p>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>