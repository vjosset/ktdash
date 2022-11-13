<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	
	// Get the specified roster operative
	$roid = getIfSet($_REQUEST['roid'], '');
	
	if ($roid == null || $roid == '') {
		// Invalid Roster Operative ID
		// Operative not found - Go to user's roster
		header("Location: /rosters.php");
		exit;
	}
	
	// Get the operative
	$op = RosterOperative::GetRosterOperative($roid);
	
	if ($op == null) {
		// Invalid Roster Operative ID
		// Operative not found - Go to user's roster
		header("Location: /rosters.php");
		exit;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		
		<?php
		$pagetitle = $op->opname . " - Print Operative";
		$pagedesc  = $op->opname . " - Print Operative";
		$pageimg   = "https://ktdash.app/api/operativeportrait.php?roid=" . $roid;
		$pageurl   = "https://ktdash.app/printop.php?roid=" . $roid;
		
		include "og.php"
		?>
	</head>
	<body>
		<!-- Front of Card -->
		<div>
			<div class="card darkcard m-1 h-100 opcard small lh-sm">
				<div class="card-body m-1 p-0">
					<!-- Print Op Card Title -->
					<div class="card-title row">
						<h2 class="col-8"><?php echo $op->opname ?></h2>
						<div class="col-4 text-end small">
							<?php echo $op->optype ?>
						</div>
					</div>
					
					<!-- Operative Card Content -->
					<div class="opinfo_<?php echo $op->rosteropid ?> p-0">
						<!-- Dashboard Info -->
						<div>
							<h6>W:
							<?php
							for ($i = 0; $i < $op->W; $i++)
							{
								// Flag for "Injured" cutoff
								//if ($i == floor($op->W / 2)) {
								//	echo " | ";
								//}
								?><input type="checkbox" /><?php
							}
							?>
							</h6>
						</div>
						
						<!-- Operative Portrait and Stats Grid -->
						<div class="row m-0 p-0">
							<!-- Dashboard/Roster Portrait -->
							<div class="col-5 m-0 p-0 pointer" style="overflow: hidden;">
								<img id="opportrait_<?php echo $op->rosteropid ?>"
									src="/api/operativeportrait.php?roid=<?php echo $op->rosteropid ?>"
									style="height: 100%; width: 100%; min-height: 100px; max-height: 140px; object-fit:cover; object-position:50% 0%; display:block;" />
							</div>
							
							<!-- Operative Stats -->
							<div class="col-7 p-0">
								<h4>
									<table width="100%" class="text-center">
										<tr>
											<td width="16%">M</td>
											<td width="16%">APL</td>
											<td width="16%">GA</td>
										</tr>
										<tr>
											<td nowrap="true"><?php echo replaceDistance($op->M) ?></td>
											<td><?php echo $op->APL ?></td>
											<td><?php echo $op->GA ?></td>
										</tr>
										<tr>
											<td width="16%">DF</td>
											<td width="16%">SV</td>
											<td width="16%">W</td>
										</tr>
										<tr>
											<td><?php echo $op->DF ?></td>
											<td>&nbsp;<?php echo $op->DF ?></td>
											<td><?php echo $op->W ?></td>
										</tr>
									</table>
								</h4>
							</div>
						</div>
						
						<!-- Weapons -->
						<div class="px-1 small lh-sm">
							<table width="100%" class="line-top-light">
								<thead>
									<tr>
										<td>
											<h6>Weapons</h6>
										</td>
										<td class="text-center">
											<h6>&nbsp;&nbsp;A&nbsp;&nbsp;</h6>
										</td>
										<td class="text-center">
											<h6>&nbsp;&nbsp;BS&nbsp;&nbsp;</h6>
										</td>
										<td class="text-center">
											<h6>&nbsp;&nbsp;D&nbsp;&nbsp;</h6>
										</td>
									</tr>
								</thead>
								
								<!-- Weapons (Regular + Equipment) -->
								<?php
								$weapons = [];
								foreach ($op->weapons as $wep) {
									$weapons[] = $wep;
								}
								foreach ($op->equipments as $eq) {
									if ($eq->eqtype == 'Weapon') {
										$weapons[] = $eq->weapon;
									}
								}
								foreach($weapons as $wep)
								{
									if (count($wep->profiles) == 1)
									{
										?>
										<tr>
											<td width="70%">
											<?php
											switch ($wep->weptype) {
												case "R":
													echo "&#x2295;";
													break;
												case "M":
													echo "&#x2694;";
													break;
												default:
													echo "&#x26ED;";
													break;
											}
											
											echo $wep->wepname;
											if ($wep->profiles[0]->SR != "")
											{
												echo " <em>(" . replaceDistance($wep->profiles[0]->SR) . ")</em>";
											}
											?>
											</td>
											<td class="text-center h6">
												&nbsp;&nbsp;<?php echo $wep->profiles[0]->A ?>&nbsp;&nbsp;
											</td>
											<td class="text-center h6">
												&nbsp;&nbsp;&nbsp;<?php echo $wep->profiles[0]->BS ?>&nbsp;&nbsp;
											</td>
											<td class="text-center h6">
												&nbsp;&nbsp;<?php echo $wep->profiles[0]->D ?>&nbsp;&nbsp;
											</td>
										</tr>
										<?php
									}
									else
									{
										?>
										<tr>
											<td colspan="4">
											<?php
											switch ($wep->weptype) {
												case "R":
													echo "&#x2295;";
													break;
												case "M":
													echo "&#x2694;";
													break;
												default:
													echo "&#x26ED;";
													break;
											}
											
											echo $wep->wepname;
											?>
											</td>
										</tr>
										<?php
										foreach($wep->profiles as $pro)
										{
										?>
											<tr>
												<td>
													&nbsp;&nbsp;&nbsp;&nbsp;
													- <?php echo $pro->name ?>
													<?php if ($pro->SR != "") {?>
													<em>(<?php echo replaceDistance($pro->SR) ?>)</em>
													<?php
													}
													?>
												</td>
												<td class="text-center h6">
													&nbsp;&nbsp;<?php echo $pro->A ?>&nbsp;&nbsp;
												</td>
												<td class="text-center h6">
													&nbsp;&nbsp;&nbsp;<?php echo $pro->BS ?>&nbsp;&nbsp;
												</td>
												<td class="text-center h6">
													&nbsp;&nbsp;<?php echo $pro->D ?>&nbsp;&nbsp;
												</td>
											</tr>
										<?php
										}
									}
								}
								?>
							</table>
						</div>
						
						<!-- Abilities -->
						<?php
						if (count($op->abilities) > 0)
						{
						?>
							<div class="line-top-light px-1 m-0 small lh-sm">
								<h6>Abilities</h6>
								<?php
								if (count($op->abilities) > 1 || strlen($op->abilities[0]->description) > 500)
								{
								?>
									<div style="columns: 100px 2;">
								<?php
								}
								else
								{
								?>
									<div>
								<?php
								}
								
								
								foreach($op->abilities as $ab)
								{
								?>
									<div class="px-1">
										<?php echo $ab->title ?>
									</div>
								<?php
								}
								
								// Close the div for abilities
								echo "</div>";
								?>
							</div>
						<?php
						}
						?>
						
						<!-- Unique Actions -->
						<?php
						if (count($op->uniqueactions) > 0)
						{
						?>
							<div class="line-top-light px-1 m-0 small lh-sm">
								<h6>Unique Actions</h6>
								<?php
								if (count($op->uniqueactions) > 1 || strlen($op->uniqueactions[0]->description) > 500)
								{
								?>
									<div style="columns: 100px 2;">
								<?php
								}
								else
								{
								?>
									<div>
								<?php
								}
								
								
								foreach($op->uniqueactions as $ua)
								{
								?>
									<div class="px-1">
										<?php echo $ua->title ?> (<?php echo $ua->AP ?> AP)
									</div>
								<?php
								}
								
								// Close the div for unique actions
								echo "</div>";
								?>
							</div>
						<?php
						}
						?>
						
						<!-- Equipment -->
						<?php
						if (count($op->equipments) > 0)
						{
						?>
							<div class="line-top-light m-0 small lh-sm">
								<h6>Equipment</h6>
								<?php
								if (count($op->equipments) > 1 || strlen($op->equipments[0]->eqdescription) > 500)
								{
								?>
									<div style="columns: 100px 2;">
								<?php
								}
								else
								{
								?>
									<div>
								<?php
								}
								
								
								foreach($op->equipments as $eq)
								{
								?>
									<div class="px-1">
									<?php
										echo $eq->eqname;
										if ($eq->eqpts > 0) {
											echo " (" . $eq->eqpts . " EP)";
										}
									?>
									</div>
								<?php
								}
								
								// Close the div for unique actions
								echo "</div>";
								?>
							</div>
						<?php
						}
						?>
					</div>
				</div>
				
				<!-- Operative Card Footer -->
				<div class="opinfo_{{ operative.rosteropid }} collapse show card-footer m-0 p-1">
					<!-- Operative Keywords -->
					<div class="align-bottom">
						<em class="small"><?php echo htmlentities($op->keywords, ENT_HTML5  , 'UTF-8') ?></em>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Back of Card -->
		<div>
			<div class="card cdarkcard m-1 h-100 opcard small lh-sm">
				<!-- Abilities -->
				<?php
				if (count($op->abilities) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Abilities</h6>
						<?php
						if (count($op->abilities) > 1 || strlen($op->abilities[0]->description) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->abilities as $ab)
						{
						?>
							<div class="px-1" style="text-align:justify;">
								<strong><?php echo $ab->title ?>: </strong>
								<p class="d-inline"><?php echo replaceDistance($ab->description) ?></p>
							</div>
						<?php
						}
						
						// Close the div for abilities
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<!-- Unique Actions -->
				<?php
				if (count($op->uniqueactions) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Unique Actions</h6>
						<?php
						if (count($op->uniqueactions) > 1 || strlen($op->uniqueactions[0]->description) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->uniqueactions as $ua)
						{
						?>
							<div class="px-1" style="text-align:justify;">
								<strong><?php echo $ua->title ?> (<?php echo $ua->AP ?> AP): </strong>
								<p class="d-inline"><?php echo replaceDistance($ua->description) ?></p>
							</div>
						<?php
						}
						
						// Close the div for unique actions
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
				
				<!-- Equipment -->
				<?php
				if (count($op->equipments) > 0)
				{
				?>
					<div class="line-top-light px-1 m-0">
						<h6>Equipment</h6>
						<?php
						if (count($op->equipments) > 1 || strlen($op->equipments[0]->eqdescription) > 500)
						{
						?>
							<div style="columns: 200px 2;">
						<?php
						}
						else
						{
						?>
							<div>
						<?php
						}
						
						
						foreach($op->equipments as $eq)
						{
						?>
							<div class="px-1" style="text-align:justify;">
								<strong>
								<?php
									echo $eq->eqname;
									if ($eq->eqpts > 0) {
										echo " (" . $eq->eqpts . " EP)";
									}
									echo ":"
								?></strong>
								<p class="d-inline"><?php echo replaceDistance($eq->eqdescription) ?></p>
							</div>
						<?php
						}
						
						// Close the div for unique actions
						echo "</div>";
						?>
					</div>
				<?php
				}
				?>
			</div>
		</div>
		
		<?php include "footer.shtml" ?>
	</body>
</html>