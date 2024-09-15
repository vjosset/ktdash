		<?php
			// Cleanup/formatting
			$pagetitle = $pagetitle == null ? "KTDash.app" : $pagetitle . " | KTDash.app";
			$pagedesc = $pagedesc == null ? "" : $pagedesc;
			$pagedesc = str_replace('\r\n', ' ', str_replace('"', '\'', str_replace('<br/>', ' ', $pagedesc)));
			$pageimg = (!(isset($pageimg)) || $pageimg == null) ? "" : $pageimg;
			$pagekeywords = $pagekeywords == null ? "" : ($pagekeywords . ",");
		?>
		
		<!-- General Meta Tags -->
		<title><?php echo $pagetitle ?></title>
		<meta name="description" content="<?php echo $pagedesc ?>">
		<meta name="keywords" content="<?php echo $pagekeywords ?> killteam, list builder, kill team list builder, Kill Team, kill team app, kill team roster, 2024, 2021, new edition, Warhammer, 40000, 40k, wh40k, Roster, BattleScribe, Datacard, KTDash, dashboard">
		<link rel="canonical" href="<?php echo $pageurl ?>" />
		
		<!-- OpenGraph Tags -->
		<meta property="og:url" content="<?php echo $pageurl ?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?php echo $pagetitle ?>">
		<meta property="og:description" content="<?php echo $pagedesc ?>">
		<meta property="og:image" content="<?php echo $pageimg ?>">

		<!-- Twitter Meta Tags -->
		<meta name="twitter:card" content="summary_large_image">
		<meta property="twitter:domain" content="ktdash.app">
		<meta property="twitter:url" content="<?php echo $pageurl ?>">
		<meta name="twitter:title" content="<?php echo $pagetitle ?>">
		<meta name="twitter:description" content="<?php echo $pagedesc ?>">
		<meta name="twitter:image" content="<?php echo $pageimg ?>">