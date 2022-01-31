		<?php
			// Cleanup/formatting
			$pagetitle = $pagetitle . " | KTDash.app";
			$pagedesc = str_replace('\r\n', ' ', str_replace('"', '\'', str_replace('<br/>', ' ', $pagedesc)));
		?>
		
		<!-- OpenGraph Tags -->
		<title><?= $pagetitle ?></title>
		<meta name="description" content="<?= $pagedesc ?>">

		<!-- Facebook Meta Tags -->
		<meta property="og:url" content="<?=$pageurl?>">
		<meta property="og:type" content="website">
		<meta property="og:title" content="<?=$pagetitle?>">
		<meta property="og:description" content="<?=$pagedesc?>">
		<meta property="og:image" content="<?=$pageimg?>">

		<!-- Twitter Meta Tags -->
		<meta name="twitter:card" content="summary_large_image">
		<meta property="twitter:domain" content="ktdash.app">
		<meta property="twitter:url" content="<?=$pageurl?>">
		<meta name="twitter:title" content="<?=$pagetitle?>">
		<meta name="twitter:description" content="<?=$pagedesc?>">
		<meta name="twitter:image" content="<?=$pageimg?>">