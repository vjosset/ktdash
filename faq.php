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
		
		<h1 class="orange"><i class="far fa-question-circle fa-fw"></i> FAQ</h1>
		
		<div class="p-1 m-1 twocols">
			<div class="section">
				<h5>Is there a User Guide for new users?</h5>
				<p>
					Thanks to user <a href="/u/skrdla">Skrdla</a>, there is!<br/>
					<a href="/img/UserGuide_v0.1.pdf" target="_blank">User Guide v0.1</a>
				</p>

				<h5>Is there an app I can install on my phone?</h5>
				<p>
					KTDash does not have a native app (like you would find in the App Store for example), but it can be installed as a
					<a href="https://developer.mozilla.org/en-US/docs/Web/Progressive_web_apps/Guides/What_is_a_progressive_web_app#progressive_web_apps" target="_blank">Progressive Web App (PWA)</a>.<br/>
					PWAs are really just fancy shortcuts that look like a native app, but are actually running inside your browser.<br/>
					<em>(If anyone wants to build a native app, the API is publicly accessible so the back-end is ready. Contact me on <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> if you want more information).<br/></em>
					To install this PWA on your phone, open the site in your phone's browser and look in your browser options for "Install" or something like that.<br/>
					<img src="/img/install_chrome.jpg" width="250" />
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>I forgot my password!</h5>
				<p>
					If you forgot your password and can't log in, send me a DM in our <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> and we'll work on resetting it together.<br/>
					Since we don't collect email addresses (and I really don't want them), this is currently the only way to reset your password.
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>What do the icons mean on my roster?</h5>
				<p>
					The icons on your roster indicate three things:
					<ul>
						<li><i class="fas fa-star fa-fw" title="Spotlight"></i>: If a roster has a star icon, it means that roster was selected for the spotlight and will be featured on the killteam's "Rosters" tab and randomly selected to be shown on the home page</li>
						<li><i class="fas fa-eye fa-fw" title="View Count"></i>: The eye icon indicates how many times the roster was viewed by another user</li>
						<li><i class="fas fa-file-import fa-fw" title="Import Count"></i>: The "arrow file" icon indicates how many times the roster was imported by another user</li>
					</ul>
				</p>
			</div>

			<hr/>

			<div class="section">
				<h5>I have an idea for a cool new feature or improvement</h5>
				<p>
					If you want to suggest a new feature or improvement, first check the <a href="https://trello.com/b/YWHG6mhJ/backlog" target="_blank">Backlog</a> to see if it is already logged there. 
					If it is already there, you can vote that feature up to help prioritize the next thing to work on.<br/>
					If you don't find your suggestion already in the backlog, come to the "Feature Requests" channel on the <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a> and send it in!<br/>
					Also note that the most commmonly-requested features have already been implemented in the <a href="/settings.php">Settings</a>; check there first!<br/>
					If you want to contribute to the application, check out the code <a href="https://github.com/vjosset/ktdash" target="_blank">repo</a>.
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>I found a bug or typo!</h5>
				<p>
					Please report bugs and typos (I HATE typos) in the "Report a Bug" channel of our <a href="https://discord.gg/zyuVDgYNeY" target="_blank">Discord</a>.
					Since everything is lovingly loaded by hand, there is bound to be typos and spelling mistakes despite our best efforts.<br/>
					Bugs and typos are typically fixed within a day, and often within an hour!
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>What is your privacy policy?</h5>
				<p>
					Our privacy policy is "We don't want your personal information, and whatever we collect will never be shared with anyone ever no-way no-how".<br/>
					That being said, a few things to note:
					<ul>
						<li>We use a cookie to keep you logged in</li>
						<li>We use your browser's <a href="https://www.w3schools.com/jsref/prop_win_localstorage.asp" target="_blank">localStorage</a> to hold your settings and preferences</li>
						<li>We use Google Analytics to track site traffic and performance</li>
						<li>The web server's logs include your IP address and are purged every 30 days</li>
						<li>
							All your rosters are publicly visible. That means that you can easily share your rosters with other people,
							but it also means you want to be mindful of the content you load, especially the roster and operative portraits.
						</li>
					</ul>
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>I heard you have some 3d printing STL models available</h5>
				<p>
					You can find all the STL models we designed for terrain and utilities on
					<a href="https://www.thingiverse.com/jodawznev/designs" target="_blank">Thingiverse</a> or <a href="https://cults3d.com/en/users/jodawznev/3d-models" target="_blank">Cults 3D</a>.
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>Can I donate/give you money? Is there a Patreon, Ko-Fi or other option?</h5>
				<p>
					No thank you. This is a labor of love and I really don't need or want any money.<br/>
					If you really want to give $5 to someone who needs it, look up your local wildlife rescue, women's shelter, or adult literacy program, and tell them I sent you!
				</p>
			</div>

			<hr/>
			
			<div class="section">
				<h5>Is there a way for me to get the data that KTDash uses?</h5>
				<p>
					Right <a href="https://github.com/vjosset/killteamjson" target="_blank">here</a> or use the <a href="https://github.com/vjosset/ktdash/blob/v2/docs/api.md" target="_blank">API</a>.
				</p>
			</div>

			<hr/>

			<div class="section">
				<h5>How do i make my own homebrew teams?</h5>
				<p>
					There is no self-service way to load a homebrew team, it's something you'd have to send me to get loaded and it takes a long time.
					There is an item on the <a href="https://trello.com/b/YWHG6mhJ/backlog" target="_blank">backlog</a> to add that functionality but it's a ton of work.
				</p>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>