<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;

  $importjson =  json_decode(
    "{
	\"factionid\": \"HBR\",
	\"killteamid\": \"DW24\",
	\"edition\": \"kt24\",
	\"killteamname\": \"Long Vigil\",
	\"description\": \"The Deathwatch, known also as the \\\"Long Vigil,\\\" and the \\\"Long Watch,\\\" is a unique Chapter of the Adeptus Astartes comprised solely of Veteran Space Marines that serves the Ordo Xenos of the Imperial Inquisition as its Chamber Militant. They are the warriors of last resort when the Inquisition needs access to firepower greater than that which the Astra Militarum or a team of its own Acolytes or Throne Agents can provide.<br/><br/>It is the sacred task of the Deathwatch to stand sentry against all of these terrible xenos races and many more besides. They are ready to act when such ancient evils rise to threaten Mankind once more. The Space Marines of the Deathwatch form the first, and often only, line of defence against these inhuman horrors.\",
	\"customkeyword\": \"<CHAPTER>\",
	\"ploys\": {
	  \"strat\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"ATSKNF\",
		  \"ployname\": \"And They Shall Know No Fear\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"You can ignore any changes to the stats of friendly LONG VIGIL operatives from being injured.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"CR\",
		  \"ployname\": \"Chapter Rivalries\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Whenever a friendly LONG VIGIL operative is shooting or retaliating, if it’s within 3\\\" of another friendly LONG VIGIL operative,\\nthat first friendly operative’s ranged weapons have the Severe weapon rule.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Targeting Scramblers\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Whenever an enemy operative is shooting against, fighting against or retaliating against a friendly LONG VIGIL operative within 2\\\" of it, your opponent cannot re-roll their attack dice results of 1.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Sanction of the Black Vault\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Once per game, use at the start of any turning point. You may exchange one equipment for another so long as they are not limited and have been used. If either equipment is deployed, as long as no other enemy operatives are within 3\\\", you may remove it from the battlefield and then deploy the new pieces of equipment more than 3\\\" from enemy operatives. You must also follow any other placement rules for that equipment.\"
		}
	  ],
	  \"tac\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"ATS\",
		  \"ployname\": \"Ever Vigilant\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Whenever this operative is fighting or retaliating, you can resolve one of your successes before the normal order. If you do, that success must be used to block.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"ADJT\",
		  \"ployname\": \"Adaptive Tactics\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy during a friendly LONG VIGIL operative's activation, before or after it performs an action. You may change the MISSION TACTIC you selected.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"OID\",
		  \"ployname\": \"Atonement Through Honor\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when a ready friendly LONG VIGIL operative is incapacitated, if it is not within control range of enemy operatives.\\nBefore it is removed from the killzone, it can immediately perform one free action.\\nUnless otherwise specified, the operative would be injured for this.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"DW24\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Transhuman Physiology\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when an operative is shooting a friendly LONG VIGIL operative, in the Roll Defence Dice step.\\nYou can retain one of your normal successes as a critical success instead.\"
		}
	  ]
	},
	\"equipments\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"DW24\",
		\"eqid\": \"AUS\",
		\"eqname\": \"Auspex\",
		\"eqdescription\": \"Once per turning point, when a friendly ANGEL OF DEATH operative performs the Shoot action and you’re selecting a valid target, you can use this rule.\\nIf you do, until the end of the activation (or counteraction), enemy operatives within 8\\\" of it cannot be obscured.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 4
	  },
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"SM\",
		\"eqid\": \"HG\",
		\"eqname\": \"Vortex Bolts\",
		\"eqdescription\": \"Once per turning point, when a friendly LONG VIGIL operative is shooting with a bolt weapon, that weapon gains the Devastating 1 weapon rule.\",
		\"eqpts\": \"2\",
		\"eqtype\": \"Action\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 0
	  },
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"DW24\",
		\"eqid\": \"PS\",
		\"eqname\": \"Purity Seals\",
		\"eqdescription\": \"Once per turning point, when a friendly LONG VIGIL operative is shooting, fighting or retaliating, if you roll two or more fails, you can discard one of them to retain another as a normal success instead.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 1
	  },
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"DW24\",
		\"eqid\": \"BA\",
		\"eqname\": \"Beacon Angelis\",
		\"eqdescription\": \"Once per battle, at the end of the firefight phase you may remove a LONG VIGIL operative that is not within engagement range from the killzone. In the next turning point as a Strategic Gambit you then place them wholly within 6\\\" of your drop zone and more than 6\\\" from enemy operatives. Treat this operative as having performed a reposition action.\",
		\"eqpts\": \"3\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 0
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-AC\",
		\"eqname\": \"Ammo Cache\",
		\"eqdescription\": \"Before the battle, you can set up one of your Ammo Cache markers wholly within your territory. Friendly operatives can perform the following mission action during the battle: <strong>AMMO RESUPPLY (0 AP):</strong> One of your Ammo Cache markers the active operative controls is used during this turning point.<br/> Until the start of the next turning point, whenever this operative is shooting with a weapon from its datacard, you can re-roll one of your attack dice.</br> An operative cannot perform this action while within control range of an enemy operative, if that marker is not yours, or if that marker has been used this turning point.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Action\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 601
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-RW\",
		\"eqname\": \"Razor Wire\",
		\"eqdescription\": \"Razor wire is Exposed and Obstructing terrain. Before the battle, you can set it up wholly within your territory, on the killzone floor and more than 2\\\" from other equipment terrain features.<br/>\\nObstructing: Whenever an operative would cross this terrain feature within 1\\\" of it, treat the distance as an additional 2\\\".\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 602
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-CD\",
		\"eqname\": \"Comms Device\",
		\"eqdescription\": \"Before the battle, you can set up one of your Comms Device markers wholly within your territory.\\nWhile a friendly operative controls this marker, add 3\\\" to the distance requirements of its SUPPORT rules that refer to friendly operatives\\n(e.g. ‘select one friendly operative within 6\\\"’ would be 9\\\" instead).\\nNote that you cannot benefit from your opponent's Comms Device markers.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 603
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-MN\",
		\"eqname\": \"Mines\",
		\"eqdescription\": \"Before the battle, you can set up one of your Mines markers wholly within your territory and more than 2\\\" from other markers and access points.\\nThe first time that marker is within an operative's control range, remove that marker and inflict D3+3 damage on that operative.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 604
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-LB\",
		\"eqname\": \"Light Barricades\",
		\"eqdescription\": \"Light barricades are Light terrain. Before the battle, you can set up any of them wholly within your territory, on the killzone floor and more than 2\\\" from other equipment terrain features.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 605
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-HB\",
		\"eqname\": \"Heavy Barricade\",
		\"eqdescription\": \"A heavy barricade is Heavy terrain. Before the battle, you can set it up wholly within 2\\\" of your drop zone, on the killzone floor and more than 2\\\" from other equipment terrain features.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 606
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-LAD\",
		\"eqname\": \"Ladders\",
		\"eqdescription\": \"Ladders are Exposed terrain. Before the battle, you can set up any of them as follows: <ul> <li>Wholly within your territory.</li> <li>Upright against terrain that is at least 2\\\" tall.</li> <li>More than 2\\\" from other equipment terrain features.</li> <li>More than 1\\\" from doors and access points.</li> </ul> In addition, an operative can either move through ladders as if they aren’t there (but cannot finish on them), or climb them. Once per action, whenever an operative is climbing this terrain feature, treat the vertical distance as 1\\\". Note that if an operative then continues climbing another terrain feature during that action (including another ladder), that distance is determined as normal.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 607
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-PB\",
		\"eqname\": \"Portable Barricade\",
		\"eqdescription\": \"A portable barricade is Light, Protective and Portable terrain.\\nBefore the battle, you can set it up wholly within your territory, on the killzone floor and more than 2\\\" from other equipment terrain features.\\n<br/>\\n<strong>Protective:</strong> While an operative is in cover from this terrain feature, improve its Save stat by 1 (to a maximum of 2+).<br/>\\n<strong>Portable:</strong> This terrain feature only provides cover while an operative is connected to it and if the shield is intervening (ignore its feet).\\nOperatives connected to the inside of it can perform the following action during the battle:<br/>\\n<strong>Move With Barricade (1 AP):</strong>\\nThe same as the Reposition action, except the active operative can move no more than its Move stat minus 2\\\" and cannot climb, drop or jump.<br/>\\nBefore this operative moves, remove the portable barricade it is connected to. After it moves, set up the portable barricade so it is connected again.<br/>\\nThis action is treated as a Reposition action. An operative cannot perform this action while within control range of an enemy operative, or in the same activation in which it performed the Fall Back or Charge action.\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Ability\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 608
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-UG-SMK\",
		\"eqname\": \"Utility Grenade - Smoke\",
		\"eqdescription\": \"When you select this equipment, select two utility grenades (2 smoke, 2 stun, or 1 smoke and 1 stun).\\nEach selection is a unique action your operatives can perform, but your kill team can only perform that action a total number of times during the battle equal to your selection.\\n<br/>\\n<strong>SMOKE GRENADE (1 AP):</strong><br/>\\n<ul>\\n<li>Place one of your Smoke Grenade markers within 6\\\" of this operative. It must be visible to this operative,\\nor on Vantage terrain of a terrain feature that is visible to this operative. The marker creates an area of smoke 1\\\" horizontally and unlimited height vertically from (but not below) it.</li>\\n<li>While an operative is wholly within an area of smoke, it is obscured to operatives more than 2\\\" from it, and vice versa.\\nIn addition, whenever an operative is shooting an enemy operative wholly within an area of smoke, ignore the Piercing weapon rule unless they are within 2\\\" of each other.</li>\\n<li>In the Ready step of the next Strategy phase, roll one D3. Remove that Smoke Grenade marker after a number of activations equal to that D3 have been completed\\nor at the end of the turning point (whichever comes first).</li>\\n<li>An operative cannot perform this action while within control range of an enemy operative, or if you have reached the total number of times your kill team can perform it.</li>\\n</ul>\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Action\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 609
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-UG-STN\",
		\"eqname\": \"Utility Grenade - Stun\",
		\"eqdescription\": \"When you select this equipment, select two utility grenades (2 smoke, 2 stun, or 1 smoke and 1 stun).\\nEach selection is a unique action your operatives can perform, but your kill team can only perform that action a total number of times during the battle equal to your selection.\\n<br/>\\n<strong>STUN GRENADE (1 AP):</strong><br/>\\n<ul>\\n<li>Select one enemy operative visible to and within 6\\\" of this operative. That operative and each other operative within 1\\\" of it takes a stun test. For an operative to take a stun test, roll one D6: on a 3+, subtract 1 from its APL stat until the end of its next activation.</li>\\n<li>An operative cannot perform this action while within control range of an enemy operative, or if you have reached the total number of times your kill team can perform it.</li>\\n</ul>\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Action\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 609
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-XG-FRAG\",
		\"eqname\": \"Explosive Grenade - Frag\",
		\"eqdescription\": \"When you select this equipment, select two explosive grenades (2 frag, 2 krak, or 1 frag and 1 krak).\\n<table class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th><th>A</th><th>BS</th><th>D</th><th>\\n</tr>\\n<tr>\\n<td>Frag Grenade</td><td>4</td><td>4+</td><td>2/4</td>\\n</tr>\\n<tr>\\n<th colspan=\\\"4\\\">Special Rules</th>\\n</tr>\\n<tr>\\n<td>Rng 6\\\", Blast 2\\\", Sat</td>\\n</tr>\\n</table>\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Weapon\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 610,
		\"weapon\": {
		  \"factionid\": \"kt24\",
		  \"killteamid\": \"ALL\",
		  \"fireteamid\": \"EQ\",
		  \"opid\": \"EQ\",
		  \"wepid\": \"UE-XG-FRAG\",
		  \"wepseq\": 0,
		  \"wepname\": \"Frag Grenade\",
		  \"weptype\": \"R\",
		  \"isdefault\": 0,
		  \"profiles\": [
			{
			  \"factionid\": \"kt24\",
			  \"killteamid\": \"ALL\",
			  \"fireteamid\": \"EQ\",
			  \"opid\": \"EQ\",
			  \"wepid\": \"UE-XG-FRAG\",
			  \"profileid\": \"0\",
			  \"name\": \"\",
			  \"A\": \"4\",
			  \"BS\": \"4+\",
			  \"D\": \"2/4\",
			  \"SR\": \"Rng 6\\\", Blast 2\\\", Sat\"
			}
		  ]
		}
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-XG-KRAK\",
		\"eqname\": \"Explosive Grenade - Krak\",
		\"eqdescription\": \"When you select this equipment, select two explosive grenades (2 frag, 2 krak, or 1 frag and 1 krak).\\n<table class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th><th>A</th><th>BS</th><th>D</th><th>\\n</tr>\\n<tr>\\n<td>Krak Grenade</td><td>4</td><td>4+</td><td>4/5</td>\\n</tr>\\n<tr>\\n<th colspan=\\\"4\\\">Special Rules</th>\\n</tr>\\n<tr>\\n<td>Rng 6\\\", Piercing 1, Sat</td>\\n</tr>\\n</table>\",
		\"eqpts\": \"0\",
		\"eqtype\": \"Weapon\",
		\"eqvar1\": \"\",
		\"eqvar2\": \"\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Universal Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 610,
		\"weapon\": {
		  \"factionid\": \"kt24\",
		  \"killteamid\": \"ALL\",
		  \"fireteamid\": \"EQ\",
		  \"opid\": \"EQ\",
		  \"wepid\": \"UE-XG-KRAK\",
		  \"wepseq\": 0,
		  \"wepname\": \"Krak Grenade\",
		  \"weptype\": \"R\",
		  \"isdefault\": 0,
		  \"profiles\": [
			{
			  \"factionid\": \"kt24\",
			  \"killteamid\": \"ALL\",
			  \"fireteamid\": \"EQ\",
			  \"opid\": \"EQ\",
			  \"wepid\": \"UE-XG-KRAK\",
			  \"profileid\": \"0\",
			  \"name\": \"\",
			  \"A\": \"4\",
			  \"BS\": \"4+\",
			  \"D\": \"4/5\",
			  \"SR\": \"Rng 6\\\", Prc1, Sat\"
			}
		  ]
		}
	  }
	],
	\"killteamcomp\": \"A LONG VIGIL KillTeam is composed of: <ul> <li> 1 LONG VIGIL operative selected from the following list: <ul> <li> DEATHWATCH VETERAN WATCH SERGEANT operative equipped with one of the following options:\\n <ul>\\n        <li>Deathwatch Boltgun; Power Weapon</li>\\n        <li>Heavy Thunder Hammer (max one per kill team)</li>\\n     <li>Lightning Claws</li>\\n     <li>\\n                Fists and one of the following options:\\n         <ul>\\n                        <li>Deathwatch Boltgun, Deathwatch Shotgun, Combi-Flamer, Combi-Grav, Combi-Melta, Combi-Plasma, Stalker Pattern Boltgun, or Storm Bolter</li>\\n         </ul>\\n        </li>\\n     <li>\\n                One option from each of the following:\\n         <ul>\\n                        <li>Chainsword, Lightning Claw, Power Fist, Power Maul, Power Weapon, Thunder Hammer, or Xenophase Blade</li>\\n             <li>Bolt Pistol, Grav-Pistol, Hand Flamer, Inferno Pistol, Plasma Pistol, or Storm Shield</li>\\n         </ul>\\n     </li>\\n </ul> <li>WATCH MASTER</li> </ul> </li> <li> \\n 5 LONG VIGIL operatives selected from the following list:\\n <ul>\\n        <li>\\n                DEATHWATCH VETERAN WARRIOR each separately equipped with one of the following options:\\n         <ul>\\n                        <li>Deathwatch Boltgun, Power Weapon</li>\\n             <li>\\n                                Fists and one of the following options:\\n                 <ul>\\n                                        <li>Deathwatch Shotgun, Stalker Pattern Boltgun, or Storm Bolter</li>\\n                 </ul>\\n             </li>\\n         </ul>\\n        </li>\\n     <li>\\n                DEATHWATCH VETERAN FIGHTER each separately equipped with one of the following options:\\n         <ul>\\n                        <li>Heavy Thunder Hammer (max one per kill team)</li>\\n             <li>Lightning Claws</li>\\n             <li>\\n                                One option from each of the following:\\n                 <ul>\\n                                        <li>Chainsword, Lightning Claw, Power Fist, Power Maul, Power Weapon, or Thunder Hammer</li>\\n                     <li>Bolt Pistol, Grav-Pistol, Hand Flamer, Inferno Pistol, Plasma Pistol, or Storm Shield</li>\\n                 </ul>\\n                        </li>\\n         </ul>\\n     </li>\\n     <li>\\n                DEATHWATCH VETERAN GUNNER each separately equipped with Fists and one of the following options:\\n         <ul>\\n                        <li>Combi-Flamer, Combi-Grav, Combi-Melta, Combi-Plasma, Flamer, Grav-Gun, Meltagun, or Plasma Gun</li>\\n         </ul>\\n     </li>\\n     <li>\\n                DEATHWATCH VETERAN HEAVY GUNNER each separately equipped with Fists and one of the following options:\\n         <ul>\\n                        <li>Frag Cannon, Heavy Bolter, Heavy Flamer, Infernus Heavy Bolter, or Missile Launcher</li>\\n         </ul>\\n     </li>\\n </ul>\\n Other than DEATHWATCH VETERAN WARRIOR operatives, your kill team can only include each operative above once. <br/><br/> Some LONG VIGIL rules refer to a 'bolt weapon'. This is a ranged weapon that includes 'bolt' in its name, e.g. stalker bolt rifle, heavy bolt pistol, etc.\",
	\"fireteams\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"DW24\",
		\"fireteamid\": \"DW24\",
		\"seq\": 0,
		\"fireteamname\": \"Deathwatch Veterans\",
		\"archetype\": \"Seek And Destroy/Security\",
		\"description\": null,
		\"killteammax\": 0,
		\"operatives\": [
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"WM\",
			\"opseq\": 0,
			\"opname\": \"Watch Master\",
			\"description\": \"\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"0\",
			\"DF\": \"0\",
			\"SV\": \"3+\",
			\"W\": \"15\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, LEADER, WATCH MASTER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"wepid\": \"GS\",
				\"wepseq\": 0,
				\"wepname\": \"Vigil Spear\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"DW24\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WM\",
					\"wepid\": \"GS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/5\",
					\"SR\": \"PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"wepid\": \"GSM\",
				\"wepseq\": 0,
				\"wepname\": \"Vigil Spear\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"DW24\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WM\",
					\"wepid\": \"GSM\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"5/7\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"HL\",
				\"title\": \"Heroic Leader\",
				\"description\": \"Once per turning point, you can use a firefight ploy for 0CP if this is the specified LONG VIGIL operative (excluding Command Re-roll),\\nor the Adaptive Tactics firefight ploy for 0CP if this operative is in the killzone and not within control range of enemy operatives.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"SGT\",
			\"opseq\": 1,
			\"opname\": \"Deathwatch Sergeant\",
			\"description\": \"Deathwatch Watch Sergeants are deadly combatants and tacticians who carry an array of specialist weapons and have an instinct for divining their prey's next move.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"15\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, LEADER, DEATHWATCH VETERAN, SERGEANT\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"DWBG\",
				\"wepseq\": 0,
				\"wepname\": \"Deathwatch Boltgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"0\",
					\"name\": \"DragonFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Sat\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"1\",
					\"name\": \"HellFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Rending\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"2\",
					\"name\": \"Kraken\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"PrcCrit1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"3\",
					\"name\": \"Vengeance\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"SG\",
				\"wepseq\": 0,
				\"wepname\": \"Deathwatch Shotgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SG\",
					\"profileid\": \"0\",
					\"name\": \"Cryptclearer\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/4\",
					\"SR\": \"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SG\",
					\"profileid\": \"1\",
					\"name\": \"Wyrmsbreath\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"2/2\",
					\"SR\": \"Rng 3\\\", Tor 2\\\"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SG\",
					\"profileid\": \"2\",
					\"name\": \"Xenopurge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/5\",
					\"SR\": \"Rng 6\\\", PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"CF\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CF\",
					\"profileid\": \"0\",
					\"name\": \"Combi-Flamer\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"2/2\",
					\"SR\": \"Combi-DWBG, Rng 6\\\", Tor 2\\\", Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"CG\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Grav\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CG\",
					\"profileid\": \"0\",
					\"name\": \"Grav\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Combi-DWBG, Prc1, Grav, Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"CM\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Melta\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CM\",
					\"profileid\": \"0\",
					\"name\": \"Melta\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"6/3\",
					\"SR\": \"Combi-DWBG, Rng 6\\\", Prc2, Lim, Dev4\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"CP\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Plasma\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CP\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Combi-DWBG, Prc1, Lim\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CP\",
					\"profileid\": \"1\",
					\"name\": \"Overcharge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Combi-DWBG, Prc2, Hot, Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"BP\",
				\"wepseq\": 0,
				\"wepname\": \"Bolt Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"BP\",
					\"profileid\": \"0\",
					\"name\": \"Bolt Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Rng 6\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"GP\",
				\"wepseq\": 0,
				\"wepname\": \"Grav-Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"GP\",
					\"profileid\": \"0\",
					\"name\": \"Grav-Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Rng 6\\\", Prc1, Grav\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"HF\",
				\"wepseq\": 0,
				\"wepname\": \"Hand Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"HF\",
					\"profileid\": \"0\",
					\"name\": \"Hand Flamer\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"2/2\",
					\"SR\": \"Rng 6\\\", Tor 1\\\", Sat\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"IP\",
				\"wepseq\": 0,
				\"wepname\": \"Inferno Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"IP\",
					\"profileid\": \"0\",
					\"name\": \"Inferno Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/3\",
					\"SR\": \"Rng 3\\\", Prc2, Dev3\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"PP\",
				\"wepseq\": 0,
				\"wepname\": \"Plasma Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PP\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Rng 6\\\", Prc1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PP\",
					\"profileid\": \"1\",
					\"name\": \"Supercharge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Rng 6\\\", Prc2, Hot\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"SPG\",
				\"wepseq\": 0,
				\"wepname\": \"Stalker Pattern Boltgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SPG\",
					\"profileid\": \"0\",
					\"name\": \"Stalker Pattern Boltgun\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Hvy (DashOnly), Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SB\",
					\"profileid\": \"0\",
					\"name\": \"Storm Bolter\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Relentless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"F\",
					\"profileid\": \"0\",
					\"name\": \"Fists\",
					\"A\": \"3\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"LCS\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claws\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"LCS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+, Relentless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"CS\",
				\"wepseq\": 0,
				\"wepname\": \"Chainsword\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"CS\",
					\"profileid\": \"0\",
					\"name\": \"Chainsword\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"HTH\",
				\"wepseq\": 0,
				\"wepname\": \"Heavy Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"HTH\",
					\"profileid\": \"0\",
					\"name\": \"Heavy Thunder Hammer\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"6/8\",
					\"SR\": \"Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"LC\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claw\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"LC\",
					\"profileid\": \"0\",
					\"name\": \"Lightning Claw\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"PF\",
				\"wepseq\": 0,
				\"wepname\": \"Power Fist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PF\",
					\"profileid\": \"0\",
					\"name\": \"Power Fist\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"5/7\",
					\"SR\": \"Brutal\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"PM\",
				\"wepseq\": 0,
				\"wepname\": \"Power Maul\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PM\",
					\"profileid\": \"0\",
					\"name\": \"Power Maul\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"PW\",
				\"wepseq\": 0,
				\"wepname\": \"Power Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PW\",
					\"profileid\": \"0\",
					\"name\": \"Power Weapon\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"TH\",
				\"wepseq\": 0,
				\"wepname\": \"Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"TH\",
					\"profileid\": \"0\",
					\"name\": \"Thunder Hammer\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"XB\",
				\"wepseq\": 0,
				\"wepname\": \"Xenophase Blade\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"XB\",
					\"profileid\": \"0\",
					\"name\": \"Xenophase Blade\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Brutal, Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"SGT\",
				\"wepid\": \"SS\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Shield\",
				\"weptype\": \"E\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"-\",
					\"BS\": \"-\",
					\"D\": \"-\",
					\"SR\": \"*Storm Shield\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"AOD\",
				\"fireteamid\": \"AOD\",
				\"opid\": \"CPT\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"abilityid\": \"SS\",
				\"title\": \"*Storm Shield\",
				\"description\": \"If this operative is equipped with a Storm Shield, it ignores the Piercing weapon rule. Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent's successful hits are discarded (instead of one).\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"WAR\",
			\"opseq\": 2,
			\"opname\": \"Deathwatch Warrior\",
			\"description\": \"Deathwatch kill teams comprise experienced warriors equipped with rare weapons and equipment, including specialist ammunition tailored to kill various xenos.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, DEATHWATCH VETERAN, WARRIOR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"DWBG\",
				\"wepseq\": 0,
				\"wepname\": \"Deathwatch Boltgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"0\",
					\"name\": \"DragonFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Sat\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"1\",
					\"name\": \"HellFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Rending\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"2\",
					\"name\": \"Kraken\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"PrcCrit1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"3\",
					\"name\": \"Vengeance\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SG\",
				\"wepseq\": 0,
				\"wepname\": \"Deathwatch Shotgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SG\",
					\"profileid\": \"0\",
					\"name\": \"Cryptclearer\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/4\",
					\"SR\": \"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SG\",
					\"profileid\": \"1\",
					\"name\": \"Wyrmsbreath\",
					\"A\": \"5\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Rng 3\\\", Tor 2\\\"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SG\",
					\"profileid\": \"2\",
					\"name\": \"Xenopurge\",
					\"A\": \"4\",
					\"BS\": \"2+\",
					\"D\": \"3/5\",
					\"SR\": \"Rng 6\\\", PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SPG\",
				\"wepseq\": 0,
				\"wepname\": \"Stalker Pattern Boltgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SPG\",
					\"profileid\": \"0\",
					\"name\": \"Stalker Pattern Boltgun\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Hvy (DashOnly), Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SB\",
					\"profileid\": \"0\",
					\"name\": \"Storm Bolter\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Relentless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"F\",
					\"profileid\": \"0\",
					\"name\": \"Fists\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WAR\",
				\"wepid\": \"PW\",
				\"wepseq\": 0,
				\"wepname\": \"Power Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"WAR\",
					\"wepid\": \"PW\",
					\"profileid\": \"0\",
					\"name\": \"Power Weapon\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"AOD\",
				\"fireteamid\": \"AOD\",
				\"opid\": \"CPT\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"hidden\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"FTR\",
			\"opseq\": 3,
			\"opname\": \"Deathwatch Fighter\",
			\"description\": \"Those Deathwatch Veterans who excel in bloody close combat wield a variety of pistols, blades, and powered hammers that can pulverise almost any foe.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, DEATHWATCH VETERAN, FIGHTER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"BP\",
				\"wepseq\": 0,
				\"wepname\": \"Bolt Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"BP\",
					\"profileid\": \"0\",
					\"name\": \"Bolt Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Rng 6\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"GP\",
				\"wepseq\": 0,
				\"wepname\": \"Grav-Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"GP\",
					\"profileid\": \"0\",
					\"name\": \"Grav-Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Rng 6\\\", Prc1, Grav\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"HF\",
				\"wepseq\": 0,
				\"wepname\": \"Hand Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"HF\",
					\"profileid\": \"0\",
					\"name\": \"Hand Flamer\",
					\"A\": \"4\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Rng 6\\\", Tor 1\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"IP\",
				\"wepseq\": 0,
				\"wepname\": \"Inferno Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"IP\",
					\"profileid\": \"0\",
					\"name\": \"Inferno Pistol\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/3\",
					\"SR\": \"Rng 3\\\", Prc2, Dev3\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"PP\",
				\"wepseq\": 0,
				\"wepname\": \"Plasma Pistol\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"PP\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Rng 6\\\", Prc1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"PP\",
					\"profileid\": \"1\",
					\"name\": \"Supercharge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Rng 6\\\", Prc2, Hot\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"CS\",
				\"wepseq\": 0,
				\"wepname\": \"Chainsword\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"CS\",
					\"profileid\": \"0\",
					\"name\": \"Chainsword\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"HTH\",
				\"wepseq\": 0,
				\"wepname\": \"Heavy Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"HTH\",
					\"profileid\": \"0\",
					\"name\": \"Heavy Thunder Hammer\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"6/8\",
					\"SR\": \"Lethal 5+, Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"LC\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claw\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"LC\",
					\"profileid\": \"0\",
					\"name\": \"Lightning Claw\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"LCS\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claws\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"LCS\",
					\"profileid\": \"0\",
					\"name\": \"Lightning Claws\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+, Relentless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"PF\",
				\"wepseq\": 0,
				\"wepname\": \"Power Fist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"PF\",
					\"profileid\": \"0\",
					\"name\": \"Power Fist\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"5/7\",
					\"SR\": \"Brutal\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"PM\",
				\"wepseq\": 0,
				\"wepname\": \"Power Maul\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"PM\",
					\"profileid\": \"0\",
					\"name\": \"Power Maul\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"PW\",
				\"wepseq\": 0,
				\"wepname\": \"Power Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"PW\",
					\"profileid\": \"0\",
					\"name\": \"Power Weapon\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"TH\",
				\"wepseq\": 0,
				\"wepname\": \"Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"TH\",
					\"profileid\": \"0\",
					\"name\": \"Thunder Hammer\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Shock\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"FTR\",
				\"wepid\": \"SS\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Shield\",
				\"weptype\": \"E\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"FTR\",
					\"wepid\": \"SS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"-\",
					\"BS\": \"-\",
					\"D\": \"-\",
					\"SR\": \"*Storm Shield\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"AOD\",
				\"fireteamid\": \"AOD\",
				\"opid\": \"CPT\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"abilityid\": \"SS\",
				\"title\": \"*Storm Shield\",
				\"description\": \"If this operative is equipped with a Storm Shield, it ignores the Piercing weapon rule. Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent's successful hits are discarded (instead of one).\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"hidden\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"GNR\",
			\"opseq\": 4,
			\"opname\": \"Deathwatch Gunner\",
			\"description\": \"Veteran xenos hunters know the alien has many forms, each as repugnant as the next. Those who prefer to slay at range equip themselves with artificer-wrought rifles and advanced combination assault guns, firing chitin-piercing rounds or shells filled with mutagenic acid.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, DEATHWATCH VETERAN, GUNNER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CF\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CF\",
					\"profileid\": \"0\",
					\"name\": \"Combi-Flamer\",
					\"A\": \"5\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Combi-DWBG, Rng 6\\\", Tor 2\\\", Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CG\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Grav\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CG\",
					\"profileid\": \"0\",
					\"name\": \"Grav\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Combi-DWBG, Prc1, Grav, Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CM\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Melta\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CM\",
					\"profileid\": \"0\",
					\"name\": \"Melta\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"6/3\",
					\"SR\": \"Combi-DWBG, Rng 6\\\", Prc2, Lim, Dev4\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CP\",
				\"wepseq\": 0,
				\"wepname\": \"Combi-Plasma\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CP\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Combi-DWBG, Prc1, Lim\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CP\",
					\"profileid\": \"1\",
					\"name\": \"Overcharge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Combi-DWBG, Prc2, Hot, Lim\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"DWBG\",
				\"wepseq\": 0,
				\"wepname\": \"Deathwatch Boltgun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"0\",
					\"name\": \"DragonFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Sat\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"1\",
					\"name\": \"HellFire\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Rending\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"2\",
					\"name\": \"Kraken\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"PrcCrit1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"DWBG\",
					\"profileid\": \"3\",
					\"name\": \"Vengeance\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"FL\",
				\"wepseq\": 0,
				\"wepname\": \"Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"FL\",
					\"profileid\": \"0\",
					\"name\": \"Flamer\",
					\"A\": \"5\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Rng 6\\\", Tor 2\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"GG\",
				\"wepseq\": 0,
				\"wepname\": \"Grav-Gun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"GG\",
					\"profileid\": \"0\",
					\"name\": \"Grav-Gun\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Prc1, Grav\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"MG\",
				\"wepseq\": 0,
				\"wepname\": \"Meltagun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"MG\",
					\"profileid\": \"0\",
					\"name\": \"Meltagun\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"6/3\",
					\"SR\": \"Rng 6\\\", Prc2, Dev4\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"PG\",
				\"wepseq\": 0,
				\"wepname\": \"Plasma Gun\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"PG\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Prc1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"PG\",
					\"profileid\": \"1\",
					\"name\": \"Supercharge\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Prc2, Hot\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"GNR\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"GNR\",
					\"wepid\": \"F\",
					\"profileid\": \"0\",
					\"name\": \"Fists\",
					\"A\": \"3\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"AOD\",
				\"fireteamid\": \"AOD\",
				\"opid\": \"CPT\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"hidden\",
			\"fireteammax\": 0,
			\"specialisms\": \"Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"DW24\",
			\"fireteamid\": \"DW24\",
			\"opid\": \"HGNR\",
			\"opseq\": 5,
			\"opname\": \"Deathwatch Heavy Gunner\",
			\"description\": \"These Deathwatch Veterans bear the most potent of xenos-killing firepower, and support kill teams facing especially dangerous horrors.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"LONG VIGIL, IMPERIUM, ADEPTUS ASTARTES, DEATHWATCH VETERAN, HEAVY GUNNER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"FC\",
				\"wepseq\": 0,
				\"wepname\": \"Frag Cannon\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"FC\",
					\"profileid\": \"0\",
					\"name\": \"Frag\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Blast 2\\\"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"FC\",
					\"profileid\": \"1\",
					\"name\": \"Shell\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/6\",
					\"SR\": \"Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"HB\",
				\"wepseq\": 0,
				\"wepname\": \"Heavy Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"HB\",
					\"profileid\": \"0\",
					\"name\": \"Heavy Bolter\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Hvy (DashOnly), PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"HF\",
				\"wepseq\": 0,
				\"wepname\": \"Heavy Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"HF\",
					\"profileid\": \"0\",
					\"name\": \"Heavy Flamer\",
					\"A\": \"6\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Hvy (DashOnly), Rng 6\\\", Tor 2\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"IHB\",
				\"wepseq\": 0,
				\"wepname\": \"Infernus Heavy Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"IHB\",
					\"profileid\": \"0\",
					\"name\": \"Heavy Bolter\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Hvy (DashOnly), PrcCrit1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"IHB\",
					\"profileid\": \"1\",
					\"name\": \"Heavy Flamer\",
					\"A\": \"6\",
					\"BS\": \"2+\",
					\"D\": \"2/2\",
					\"SR\": \"Hvy (DashOnly), Rng 6\\\", Tor 2\\\"\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"ML\",
				\"wepseq\": 0,
				\"wepname\": \"Missile Launcher\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"ML\",
					\"profileid\": \"0\",
					\"name\": \"Frag\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/5\",
					\"SR\": \"Hvy (DashOnly), Blast 2\\\"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"ML\",
					\"profileid\": \"1\",
					\"name\": \"Krak\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/7\",
					\"SR\": \"Hvy (DashOnly), Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SM\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"HGNR\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SM\",
					\"fireteamid\": \"DW24\",
					\"opid\": \"HGNR\",
					\"wepid\": \"F\",
					\"profileid\": \"0\",
					\"name\": \"Fists\",
					\"A\": \"3\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"AOD\",
				\"fireteamid\": \"AOD\",
				\"opid\": \"CPT\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly LONG VIGIL operative's activation, it can perform either two Shoot actions or two Fight actions.\\nIf it's two Shoot actions, a bolt weapon must be selected for at least one of them, and if it's a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly LONG VIGIL operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"MT\",
				\"title\": \"Mission Tactics\",
				\"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a MISSION TACTIC from those presented below. All friendly LONG VIGIL operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Furor Tactics:</strong> Until the end of the turning point all bolt weapons gain the Punishing special Rule.</li>\\n<li><strong>Malleus Tactics:</strong> Until the end of the turning point all bolt weapons gain the Lethal 5+ special rule.</li>\\n<li><strong>Purgatus Tactics:</strong> Until the end of the turning point all bolt weapons gain the balanced special rule.</li>\\n</ul>\"
			  }
			],
			\"edition\": \"hidden\",
			\"fireteammax\": 0,
			\"specialisms\": \"Staunch,Marksman\"
		  }
		],
		\"fireteamcomp\": \"\"
	  }
	],
	\"tacops\": [
	  {
		\"tacopid\": \"ZZZ-SAD-01\",
		\"archetype\": \"Seek And Destroy\",
		\"tacopseq\": 1,
		\"title\": \"Champion\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you select your first Champion.<br/><br/>\\n<strong>Additional Rules:</strong><br/>\\nAs a STRATEGIC GAMBIT in each turning point after the first, you can select one friendly operative to be your champion for the turning point.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nIn each turning point after the first, whenever your champion incapacitates an enemy operative you score 1VP, or 2VP if that enemy operative had a wound stat of 12 or more (in either case to a maximum of 2VP per turning point).\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SAD-02\",
		\"archetype\": \"Seek And Destroy\",
		\"tacopseq\": 2,
		\"title\": \"Overrun\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per turning point after the first, if an enemy operative is incapacitated by a friendly operative, and that friendly operative is wholly within your opponent's territory when it does so, you score 1VP.<br/>\\nAt the end of each turning point after the first, if the total APL stat of friendly operatives that both fulfilled the above condition that turning point (regardless of you scoring the VP) and are still wholly within your opponent's territory is 3 or more, you score 1 VP.\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SAD-03\",
		\"archetype\": \"Seek And Destroy\",
		\"tacopseq\": 3,
		\"title\": \"Storm Objectives\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Additional Rules:</strong><br/>\\nAt the end of each friendly operative's activation, if it controls an objective marker that enemy operatives controlled at the start of that activation or that is wholly within your opponent's territory,\\nand that objective marker is not contested by enemy operatives, that objective marker is stormed by friendly operatives this turning point.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per turning point after the first, if an objective marker is stormed by Friendly operatives this turning point, you score 1VP.<br/>\\nAt the end of each turning point after the first, if friendly operatives control an objective marker that was stormed by friendly operatives this turning point, you score 1VP.\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SEC-01\",
		\"archetype\": \"Security\",
		\"tacopseq\": 1,
		\"title\": \"Contain\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of each turning point after the first:<br/>\\n- If there are no enemy operatives wholly within your territory, you score 1 VP.<br/>\\n- If there are no enemy operatives wholly within 6\\\" of your drop zone, you score 1 VP.\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SEC-02\",
		\"archetype\": \"Security\",
		\"tacopseq\": 2,
		\"title\": \"Secure Centre\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of each turning point after the first:<br/>\\n- If the total APL of friendly operatives within 3\\\" of the centre of the killzone is greater than that of enemy operatives, you score 1VP.<br/>\\n- If the total APL of friendly operatives on the centreline but more than 3\\\" from the centre of the killzone is greater than that of enemy operatives, you score 1VP.\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SEC-03\",
		\"archetype\": \"Security\",
		\"tacopseq\": 3,
		\"title\": \"Take Ground\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of each turning point after the first:\\n<ul>\\n<li>In Killzone Volkus: if friendly operatives control any stronghold terrain features within your opponent's territory, you score 2VP; for each ruin (Large or small) terrain feature within your opponent's territory that friendly operatives control, you score 1 VP.</li>\\n<li>In Killzone Gallowdark, for each access point you control that is on the centreline or within your opponent's territory that friendly operatives control, you score 1 VP.</li>\\n<li>In any other kill zone, for each terrain feature with Heavy terrain within your opponent's territory that Friendly operatives control, you score 1 VP.</li>\\nYou can score a maximum of 2VP form this op per turning point.<br/>\\nAn operative contests a stronghold terrain feature it is wholly within.\\nAn operative contests all other terrain features within their control range, or while underneath a terrain feature's Vantage terrain.\\nFriendly operative control each such terrain feature if the total APL stat of those contesting it is greater than that of enemy operatives.\",
		\"edition\": \"kt24\"
	  }
	]
  }");

?>
<!DOCTYPE html>
<html>
	<head>
		<?php include "header.shtml" ?>
		<style><?php include "css/styles.css"; ?></style>
	</head>
	<body>
			<?php
      $killteam = $importjson;
        echo "Importing team " . $killteam->killteamname . "<br/><br/>";
        echo "INSERT INTO Killteam VALUES ('HBR', '$killteam->killteamid', 'kt24', '$killteam->killteamname', '$killteam->description', '$killteam->killteamcomp', '$killteam->customkeyword');";

        // Import the fireteams
        for ($ftidx = 0; $ftidx < count($killteam->fireteams); $ftidx++) {
          $fireteam = $killteam->fireteams[$ftidx];
          echo "INSERT INTO Fireteam VALUES ('$fireteam->factionid', '$fireteam->killteamid', '$fireteam->fireteamid', 0, '$fireteam->description', 0, '$fireteam->fireteamname', '$fireteam->archetype', '$fireteam->fireteamcomp');";

          // Import the operatives
          for ($opidx = 0; $opidx < count($fireteam->operatives); $opidx++) {
            $op =  $fireteam->operatives[$opidx];
            echo "INSERT INTO Operative VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opseq', '$op->opid', '$op->opname', '$op->description', 'kt24', '$op->M', '$op->APL', '$op->GA', '$op->DF', '$op->SV', '$op->W', '$op->keywords', 0, '$op->fireteammax', '$op->specialisms');<br/>";

            // Import the weapons
            for ($wepidx = 0; $wepidx < count($op->weapons); $wepidx++) {
              $wep = $op->weapons[$wepidx];

              echo "INSERT INTO Weapon VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$wep->wepid', '$wep->wepseq', '$wep->wepname', '$wep->weptype', $wep->isdefault);<br/>";

              for ($wpidx = 0; $wpidx < count($wep->profiles); $wpidx++) {
                $wp = $wep->profiles[$wpidx];
                echo "INSERT INTO WeaponProfile VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$wp->wepid', '$wp->profileid', '$wp->name', '$wp->A', '$wp->BS', '$wp->D', '$wp->SR');<br/>";
              }
            }

            // Import the abilities
            for ($abidx = 0; $abidx < count($op->abilities); $abidx++) {
              $ab = $op->abilities[$abidx];
              echo "INSERT INTO Ability VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ab->abilityid', '$ab->title', '$ab->description');<br/>";
            }

            // Import the UniqueActions
            for ($uaidx = 0; $uaidx < count($op->uniqueactions); $uaidx++) {
              $ua = $op->uniqueactions[$uaidx];
              echo "INSERT INTO UniqueAction VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ua->uniqueactionid', '$ua->title', '$ua->AP', '$ua->description');<br/>";
            }
          }
        }

        // Import the Ploys
        $sploys = $killteam->ploys->strat;
        $tploys = $killteam->ploys->tac;

        for ($pidx = 0; $pidx < count($sploys); $pidx++) {
          $ploy = $sploys[$pidx];
          echo "INSERT INTO Ploy VALUES ('HBR', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');<br/>";
        }
        
        for ($pidx = 0; $pidx < count($tploys); $pidx++) {
          $ploy = $tploys[$pidx];
          echo "INSERT INTO Ploy VALUES ('HBR', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');<br/>";
        }

        // Import the Equipments
        for ($eqidx = 0; $eqidx < count($killteam->equipments); $eqidx++) {
          $eq = $killteam->equipments[$eqidx];
          if ($eq->killteamid != 'ALL') {
            echo "INSERT INTO Equipment VALUES ('HBR', '$killteam->killteamid', '$eq->fireteamid', '$eq->opdi', '$eq->eqid', '$eq->eqseq', '$eq->eqpts', '$eq->eqname', '$eq->eqdescription', '$eq->eqtype', '$eq->eqvar1', '$eq->eqvar2', '$eq->eqvar3', '$eq->eqvar4', '$eq->eqcategory');<br/>";
          }
        }

      ?>
	</body>
</html>


	