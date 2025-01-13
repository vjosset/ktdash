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
	\"killteamid\": \"SHV24\",
	\"edition\": \"kt24\",
	\"killteamname\": \"Space Hulk Veterans\",
	\"description\": \"Terminators are Space Marine Veterans who have earned the right to wear Tactical Dreadnought Armour, better known as Terminator Armour. They are their Chapter''s greatest infantry assets, each essentially serving as a walking tank.\\n<br/><br/>\\nTactical Dreadnought Armour combines the technological developments of power armour with the sealed environmental suits designed for starship crews that work in highly unstable or corrosive environments such as inside the high pressure casings of Plasma Reactor shields. It can even withstand the colossal impact of high speed orbital micro debris. <br/><br/>Homebrew team by CT-7331, updated by Guitarninja.\",
	\"customkeyword\": \"\",
	\"ploys\": {
	  \"strat\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"ATSKNF\",
		  \"ployname\": \"And They Shall Know No Fear\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"You can ignore any changes to the stats of friendly SPACE HULK VETERAN operatives from being injured (including their weapons'' stats).\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"BOH\",
		  \"ployname\": \"Bulwark Of Humanity\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Until the end of the Turning Point, whenever an attack dice inflicts damage of 3 or more on to a friendly SPACE HULK VETERAN operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"SA\",
		  \"ployname\": \"Shock Assault\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when a friendly SPACE HULK VETERAN operative is performing the Fight action during an activation in which it has performed the Charge action, at the start of the Resolve Attack Dice step.\\nUntil the end of that action:\\n<ul>\\n<li>Its melee weapon has the Shock weapon rule.</li>\\n<li>The first time you strike during that sequence, inflict 1 additional damage (to a maximum of 7).\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Tactical Precision\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Until the end of the Turning Point, while a friendly SPACE HULK VETERAN operative is within 3\\\" of and Visible to a friendly LEADER operative, each time it fights in combat or makes a shooting attack, in the Roll Attack Dice step of that combat or shooting attack, operatives'' weapons have the balanced weapon rule.\"
		}
	  ],
	  \"tac\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"OID\",
		  \"ployname\": \"Only In Death Does Duty End\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when a ready friendly SPACE HULK VETERAN operative is incapacitated.\\nBefore it is removed from the killzone, it can immediately perform one free action.\\nUnless otherwise specified, the operative would be injured for this.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"TS\",
		  \"ployname\": \"Teleport Strike\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this Firefight Ploy before deploying your kill team. Select one SPACE HULK VETERAN operative, this operative is not deployed in the Killzone.\\nInstead, during any of its activations, it can deploy anywhere in the Killzone that is more than 6\\\" away from enemy operatives.\\n<br/>\\nOperatives deployed via Teleport Strike count as having made a Reposition action this Turning Point.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"SOTA\",
		  \"ployname\": \"Standard Of The Ancients\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when a friendly SPACE HULK VETERAN operative is activated. Select one objective marker within 3\\\" and visible to that operative. Until the end of the battle or until you use this ploy again (whichever comes first), when determining control of that objective marker, treat friendly operatives’ APL stat as 1 higher. Note this isn’t a change to the APL stat, so any changes are cumulative with this.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"SHV24\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Transhuman Physiology\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when an operative is shooting a friendly SPACE HULK VETERAN operative, in the Roll Defence Dice step.\\nYou can retain one of your normal successes as a critical success instead.\"
		}
	  ]
	},
	\"equipments\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"SHV24\",
		\"eqid\": \"AUS\",
		\"eqname\": \"Targeting Optics\",
		\"eqdescription\": \"Once per turning point, when a friendly SPACE HULK VETERAN operative performs the Shoot action and you’re selecting a valid target, you can use this rule.\\nIf you do, until the end of the activation (or counteraction), enemy operatives within 8\\\" of it cannot be obscured.\",
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
		\"killteamid\": \"SHV24\",
		\"eqid\": \"NAR\",
		\"eqname\": \"Narthecium\",
		\"eqdescription\": \"Once per game, a friendly SPACE HULK VETERAN operative can following action:<br/>\\n<strong>Narthecium (1 AP):</strong>\\nSelect one other friendly SPACE HULK VETERAN operative visible to and within 1\\\" of this operative.\\nThat operative regains 2D3 lost Wounds. This operative cannot perform this action while within Engagement Range of an enemy operative.\",
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
		\"killteamid\": \"SHV24\",
		\"eqid\": \"PS\",
		\"eqname\": \"Purity Seals\",
		\"eqdescription\": \"Once per turning point, when a friendly SPACE HULK VETERAN operative is shooting, fighting or retaliating, if you roll two or more fails, you can discard one of them to retain another as a normal success instead.\",
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
		\"killteamid\": \"SHV24\",
		\"eqid\": \"TH\",
		\"eqname\": \"Teleport Homer\",
		\"eqdescription\": \"Once per game, a friendly SPACE HULK VETERAN operative can following action:<br/>\\n<strong>Plant Teleport Homer (1 AP):</strong>\\nPlace a Teleport Homer token within 1\\\" of this operative.\\nThis operative cannot perform this action if it is within Engagement Range of an enemy operative.\\nA friendly operative deploying via Teleport Strike can deploy directly onto the Teleport Homer token, even if it is within Engagement Range of an enemy operative.\",
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
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-AC\",
		\"eqname\": \"Ammo Cache\",
		\"eqdescription\": \"Before the battle, you can set up one of your Ammo Cache markers wholly within your territory. Friendly operatives can perform the following mission action during the battle:\\r <strong>AMMO RESUPPLY (0 AP):</strong> One of your Ammo Cache markers the active operative controls is used during this turning point.<br/>\\r Until the start of the next turning point, whenever this operative is shooting with a weapon from its datacard, you can re-roll one of your attack dice.</br>\\r An operative cannot perform this action while within control range of an enemy operative, if that marker is not yours, or if that marker has been used this turning point.\",
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
		\"eqdescription\": \"Before the battle, you can set up one of your Comms Device markers wholly within your territory.\\nWhile a friendly operative controls this marker, add 3\\\" to the distance requirements of its SUPPORT rules that refer to friendly operatives\\n(e.g. ‘select one friendly operative within 6\\\"’ would be 9\\\" instead).\\nNote that you cannot benefit from your opponent''s Comms Device markers.\",
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
		\"eqdescription\": \"Before the battle, you can set up one of your Mines markers wholly within your territory and more than 2\\\" from other markers and access points.\\nThe first time that marker is within an operative''s control range, remove that marker and inflict D3+3 damage on that operative.\",
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
		\"eqdescription\": \"Ladders are Exposed terrain. Before the battle, you can set up any of them as follows:\\r <ul>\\r <li>Wholly within your territory.</li>\\r <li>Upright against terrain that is at least 2\\\" tall.</li>\\r <li>More than 2\\\" from other equipment terrain features.</li>\\r <li>More than 1\\\" from doors and access points.</li>\\r </ul>\\r In addition, an operative can either move through ladders as if they aren’t there (but cannot finish on them), or climb them.\\r Once per action, whenever an operative is climbing this terrain feature, treat the vertical distance as 1\\\".\\r Note that if an operative then continues climbing another terrain feature during that action (including another ladder), that distance is determined as normal.\",
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
		\"eqdescription\": \"When you select this equipment, select two explosive grenades (2 frag, 2 krak, or 1 frag and 1 krak).\\n<table class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th><th>A</th><th>BS</th><th>D</th><th>\\n</tr>\\n<tr>\\n<td>Frag Grenade</td><td>4</td><td>4+</td><td>2/4</td>\\n</tr>\\n<tr>\\n<th colspan=\\\"4\\\">Special Rules</th>\\n</tr>\\n<tr>\\n<td>Rng 6\\\", Blast 2\\\", Saturate</td>\\n</tr>\\n</table>\",
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
			  \"SR\": \"Rng 6\\\", Blast 2\\\", Saturate\"
			}
		  ]
		}
	  },
	  {
		\"factionid\": \"kt24\",
		\"killteamid\": \"ALL\",
		\"eqid\": \"UE-XG-KRAK\",
		\"eqname\": \"Explosive Grenade - Krak\",
		\"eqdescription\": \"When you select this equipment, select two explosive grenades (2 frag, 2 krak, or 1 frag and 1 krak).\\n<table class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th><th>A</th><th>BS</th><th>D</th><th>\\n</tr>\\n<tr>\\n<td>Krak Grenade</td><td>4</td><td>4+</td><td>4/5</td>\\n</tr>\\n<tr>\\n<th colspan=\\\"4\\\">Special Rules</th>\\n</tr>\\n<tr>\\n<td>Rng 6\\\", Piercing 1, Saturate</td>\\n</tr>\\n</table>\",
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
			  \"SR\": \"Rng 6\\\", Prc1, Saturate\"
			}
		  ]
		}
	  }
	],
	\"killteamcomp\": \"A SPACE HULK VETERAN killteam includes:\\n<ul>\\n        <li>\\n                1 SPACE HULK VETERAN SERGEANT operative with one of the following options:\\n                <ul>\\n                        <li>Storm Bolter and Power Weapon</li>\\n                        <li>Thunder Hammer and Storm Shield</li>\\n                        <li>Dual Lightning Claws</li>\\n                </ul>\\n        </li>\\n        <li>\\n                4 SPACE HULK VETERAN operatives selected from the following list:\\n                <ul>\\n                        <li>SPACE HULK VETERAN WARRIOR each separately equipped with Storm Bolter and Power Fist or Chainfist</li>\\n                        <li>\\n                                SPACE HULK VETERAN GUNNER equipped with Power Fist of Chainfist and one of the following options:\\n                                <ul>\\n                                        <li>Assault Cannon</li>\\n                                        <li>Heavy Flamer</li>\\n                                        <li>Storm Bolter and Cyclone Missile Laumcher</li>\\n                                </ul>\\n                        </li>\\n                        <li>\\n                                SPACE HULK VETERAN FIGHTER equipped with a Thunder Hammer and Storm Shield, or Dual Lightning Claws\\n                        </li>\\n                </ul>\\n        </li>\\n</ul>\\n\\nYour kill team can only include up to one SPACE HULK VETERAN GUNNER and one SPACE HULK VETERAN FIGHTER operative.\",
	\"fireteams\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"SHV24\",
		\"fireteamid\": \"SHV24\",
		\"seq\": 0,
		\"fireteamname\": \"Space Hulk Veterans\",
		\"archetype\": \"Seek and Destroy/Security\",
		\"description\": \"\",
		\"killteammax\": 0,
		\"operatives\": [
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"SHV24\",
			\"fireteamid\": \"SHV24\",
			\"opid\": \"SGT\",
			\"opseq\": 0,
			\"opname\": \"Space Hulk Veteran Sergeant\",
			\"description\": \"Each Terminator is a Veteran and competent battlefield leader in their own right.\\nThose who prove their leadership will be promoted to Sergeant and be tasked with leading squads of Terminators into battle.\\nThese level-header and brave Veterans are capable of achieving the most difficult of missions almost singlehandedly.\",
			\"M\": \"5\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"18\",
			\"keywords\": \"SPACE HULK VETERAN, IMPERIUM, ADEPTUS ASTARTES, TERMINATOR, SERGEANT, LEADER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"SGT\",
					\"wepid\": \"SB\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"2+\",
					\"D\": \"3/4\",
					\"SR\": \"Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"wepid\": \"PW\",
				\"wepseq\": 0,
				\"wepname\": \"Power Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"SGT\",
					\"wepid\": \"PW\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"2+\",
					\"D\": \"4/6\",
					\"SR\": \"Lethal 5+\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"wepid\": \"LC\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claws\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"SGT\",
					\"wepid\": \"LC\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"2+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+, Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"wepid\": \"TH\",
				\"wepseq\": 0,
				\"wepname\": \"Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"SGT\",
					\"wepid\": \"TH\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/7\",
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
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"abilityid\": \"CT\",
				\"title\": \"Crux Terminatus\",
				\"description\": \"Whenever an operative is shooting a friendly SPACE HULK VETERAN operative, worsen the x of the Piercing weapon rule by 1 (if any). Note that Piercing 1 would therefore be ignored.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"abilityid\": \"SS\",
				\"title\": \"*Storm Shield\",
				\"description\": \"If this operative is equipped with a Storm Shield, each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent''s successful hits are discarded (instead of one).\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"SGT\",
				\"abilityid\": \"TDM\",
				\"title\": \"Tactical Dreadnought Master\",
				\"description\": \"Once during each of this operative’s activations, it can perform the Pick Up Marker, Place Marker or a mission action for 1 less AP.\"
			  }
			],
			\"edition\": \"hidden\",
			\"fireteammax\": 0,
			\"specialisms\": \"\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"SHV24\",
			\"fireteamid\": \"SHV24\",
			\"opid\": \"GNR\",
			\"opseq\": 1,
			\"opname\": \"Space Hulk Veteran Gunner\",
			\"description\": \"Terminator Gunners provide devastating and accurate fire for their brothers.\\nArmed with either an Assault Cannon to unleash hails of long range firepower at the enemy, or Heavy Flamers to cover entrenched enemies in torrents of flame.\",
			\"M\": \"5\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"17\",
			\"keywords\": \"SPACE HULK VETERAN, IMPERIUM, ADEPTUS ASTARTES, TERMINATOR, GUNNER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"AC\",
				\"wepseq\": 0,
				\"wepname\": \"Assault Cannon\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"AC\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Hvy (RepOnly), Ceaseless, PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"HF\",
				\"wepseq\": 0,
				\"wepname\": \"Heavy Flamer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"HF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"6\",
					\"BS\": \"2+\",
					\"D\": \"3/3\",
					\"SR\": \"Hvy (RepOnly), Rng 6\\\", Tor 2\\\", Sat\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GUNS\",
				\"wepid\": \"PC\",
				\"wepseq\": 0,
				\"wepname\": \"Plasma Cannon\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GUNS\",
					\"wepid\": \"PC\",
					\"profileid\": \"0\",
					\"name\": \"Standard\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"4/6\",
					\"SR\": \"Blast 2\\\", Hvy (DashOnly), Prc1\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GUNS\",
					\"wepid\": \"PC\",
					\"profileid\": \"1\",
					\"name\": \"Supercharge\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Blast 2\\\", Hvy (DashOnly), Hot, Lethal 5+, Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CML\",
				\"wepseq\": 0,
				\"wepname\": \"Cyclone Missile Launcher\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CML\",
					\"profileid\": \"0\",
					\"name\": \"Frag\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/5\",
					\"SR\": \"Hvy (DashOnly), Blast 2\\\"\"
				  },
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CML\",
					\"profileid\": \"1\",
					\"name\": \"Krak\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"5/7\",
					\"SR\": \"Prc1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"SB\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"PF\",
				\"wepseq\": 0,
				\"wepname\": \"Power Fist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"PF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/7\",
					\"SR\": \"Brutal\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"wepid\": \"CF\",
				\"wepseq\": 0,
				\"wepname\": \"Chainfist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"GNR\",
					\"wepid\": \"CF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Brutal, Rending\"
				  }
				],
				\"isselected\": false
			  }
			],
			\"uniqueactions\": [],
			\"abilities\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"GNR\",
				\"abilityid\": \"CT\",
				\"title\": \"Crux Terminatus\",
				\"description\": \"Whenever an operative is shooting a friendly SPACE HULK VETERAN operative, worsen the x of the Piercing weapon rule by 1 (if any). Note that Piercing 1 would therefore be ignored.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"SHV24\",
			\"fireteamid\": \"SHV24\",
			\"opid\": \"FTR\",
			\"opseq\": 2,
			\"opname\": \"Space Hulk Veteran Fighter\",
			\"description\": \"Always seen at the spearhead of any Astartes assault, Terminators will use close combat weapons such as the Thunder Hammer and Lightning Claws to crush their enemies in ruthless assaults.\\nWith these brutally efficient weapons, combined with their battlefield experience and immense bulk, they make short work of the enemies of Mankind.\",
			\"M\": \"5\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"17\",
			\"keywords\": \"SPACE HULK VETERAN, IMPERIUM, ADEPTUS ASTARTES, TERMINATOR, FIGHTER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"FTR\",
				\"wepid\": \"LC\",
				\"wepseq\": 0,
				\"wepname\": \"Lightning Claws\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"FTR\",
					\"wepid\": \"LC\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Lethal 5+, Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"FTR\",
				\"wepid\": \"TH\",
				\"wepseq\": 0,
				\"wepname\": \"Thunder Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"FTR\",
					\"wepid\": \"TH\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/7\",
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
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"FTR\",
				\"abilityid\": \"CT\",
				\"title\": \"Crux Terminatus\",
				\"description\": \"Whenever an operative is shooting a friendly SPACE HULK VETERAN operative, worsen the x of the Piercing weapon rule by 1 (if any). Note that Piercing 1 would therefore be ignored.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"FTR\",
				\"abilityid\": \"SS\",
				\"title\": \"*Storm Shield\",
				\"description\": \"If this operative is equipped with a Storm Shield, each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent''s successful hits are discarded (instead of one).\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"SHV24\",
			\"fireteamid\": \"SHV24\",
			\"opid\": \"WAR\",
			\"opseq\": 3,
			\"opname\": \"Space Hulk Veteran Warrior\",
			\"description\": \"Only the greatest heroes of Mankind are permitted to wear Terminator armour.\\nCenturies of battlefield experience combined with some of the Imperium''s most devastating weaponry make these Veterans the perfect battlefield asset to achieve a number of missions, from boarding newly discovered Space Hulks to assaulting enemy Titans.\",
			\"M\": \"5\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"17\",
			\"keywords\": \"SPACE HULK VETERAN, IMPERIUM, ADEPTUS ASTARTES, TERMINATOR, WARRIOR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"WAR\",
					\"wepid\": \"SB\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"WAR\",
				\"wepid\": \"PF\",
				\"wepseq\": 0,
				\"wepname\": \"Power Fist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"WAR\",
					\"wepid\": \"PF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/7\",
					\"SR\": \"Brutal\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"WAR\",
				\"wepid\": \"CF\",
				\"wepseq\": 0,
				\"wepname\": \"Chainfist\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"WAR\",
					\"wepid\": \"CF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Brutal, Rending\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"WAR\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"SHV24\",
					\"fireteamid\": \"SHV24\",
					\"opid\": \"WAR\",
					\"wepid\": \"F\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
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
				\"killteamid\": \"SHV24\",
				\"fireteamid\": \"SHV24\",
				\"opid\": \"WAR\",
				\"abilityid\": \"CT\",
				\"title\": \"Crux Terminatus\",
				\"description\": \"Whenever an operative is shooting a friendly SPACE HULK VETERAN operative, worsen the x of the Piercing weapon rule by 1 (if any). Note that Piercing 1 would therefore be ignored.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"\"
		  }
		],
		\"fireteamcomp\": \"A SPACE HULK VETERAN killteam includes:\\n<ul>\\n        <li>\\n                One SPACE HULK VETERAN SERGEANT operative with one of the following options:\\n                <ul>\\n                        <li>Storm Bolter and Power Weapon</li>\\n                        <li>Thunder Hammer and Storm Shield</li>\\n                        <li>Dual Lightning Claws</li>\\n                </ul>\\n        </li>\\n        <li>\\n                Three SPACE HULK VETERAN operatives selected from the following list:\\n                <ul>\\n                        <li>SPACE HULK VETERAN WARRIOR each separately equipped with Storm Bolter and Power Fist or Chainfist</li>\\n                        <li>\\n                                SPACE HULK VETERAN GUNNER equipped with Power Fist of Chainfist and one of the following options:\\n                                <ul>\\n                                        <li>Assault Cannon</li>\\n                                        <li>Heavy Flamer</li>\\n                                        <li>Storm Bolter and Cyclone Missile Laumcher</li>\\n                                </ul>\\n                        </li>\\n                        <li>\\n                                SPACE HULK VETERAN FIGHTER equipped with a Thunder Hammer and Storm Shield, or Dual Lightning Claws\\n                        </li>\\n                </ul>\\n        </li>\\n</ul>\\n\\nYour kill team can only onluce up to one SPACE HULK VETERAN GUNNER and one SPACE HULK VETERAN FIGHTER operative.\"
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
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per turning point after the first, if an enemy operative is incapacitated by a friendly operative, and that friendly operative is wholly within your opponent''s territory when it does so, you score 1VP.<br/>\\nAt the end of each turning point after the first, if the total APL stat of friendly operatives that both fulfilled the above condition that turning point (regardless of you scoring the VP) and are still wholly within your opponent''s territory is 3 or more, you score 1 VP.\",
		\"edition\": \"kt24\"
	  },
	  {
		\"tacopid\": \"ZZZ-SAD-03\",
		\"archetype\": \"Seek And Destroy\",
		\"tacopseq\": 3,
		\"title\": \"Storm Objectives\",
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Additional Rules:</strong><br/>\\nAt the end of each friendly operative''s activation, if it controls an objective marker that enemy operatives controlled at the start of that activation or that is wholly within your opponent''s territory,\\nand that objective marker is not contested by enemy operatives, that objective marker is stormed by friendly operatives this turning point.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per turning point after the first, if an objective marker is stormed by Friendly operatives this turning point, you score 1VP.<br/>\\nAt the end of each turning point after the first, if friendly operatives control an objective marker that was stormed by friendly operatives this turning point, you score 1VP.\",
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
		\"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal:</strong> When you first score VP from this op.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of each turning point after the first:\\n<ul>\\n<li>In Killzone Volkus: if friendly operatives control any stronghold terrain features within your opponent''s territory, you score 2VP; for each ruin (Large or small) terrain feature within your opponent''s territory that friendly operatives control, you score 1 VP.</li>\\n<li>In Killzone Gallowdark, for each access point you control that is on the centreline or within your opponent''s territory that friendly operatives control, you score 1 VP.</li>\\n<li>In any other kill zone, for each terrain feature with Heavy terrain within your opponent''s territory that Friendly operatives control, you score 1 VP.</li>\\nYou can score a maximum of 2VP form this op per turning point.<br/>\\nAn operative contests a stronghold terrain feature it is wholly within.\\nAn operative contests all other terrain features within their control range, or while underneath a terrain feature''s Vantage terrain.\\nFriendly operative control each such terrain feature if the total APL stat of those contesting it is greater than that of enemy operatives.\",
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
        //echo "INSERT INTO Killteam VALUES ('$killteam->factionid', '$killteam->killteamid', '$killteam->edition', '$killteam->killteamname', '$killteam->description', '$killteam->killteamcomp', '$killteam->customkeyword');";

        // Import the fireteams
        for ($ftidx = 0; $ftidx < count($killteam->fireteams); $ftidx++) {
          $fireteam = $killteam->fireteams[$ftidx];
          //echo "INSERT INTO Fireteam VALUES ('$fireteam->factionid', '$fireteam->killteamid', '$fireteam->fireteamid', 0, '$fireteam->description', 0, '$fireteam->fireteamname', '$fireteam->archetype', '$fireteam->fireteamcomp');";

          // Import the operatives
          for ($opidx = 0; $opidx < count($fireteam->operatives); $opidx++) {
            $op =  $fireteam->operatives[$opidx];
            //echo "INSERT INTO Operative VALUES ('$op->factionid', '$op->killteamid', '$op->fireteamid', '$op->opseq', '$op->opid', '$op->opname', '$op->descirption,', '$op->edition', '$op->M', '$op->APL', '$op->GA', '$op->DF', '$op->SV', '$op->W', '$op->keywords', 0, '$op->fireteammax', '$op->specialisms');<br/>";

            // Import the weapons
            for ($wepidx = 0; $wepidx < count($op->weapons); $wepidx++) {
              $wep = $op->weapons[$wepidx];

              //echo "INSERT INTO Weapon VALUES ('$wep->factionid', '$wep->killteamid', '$wep->fireteamid', '$wep->opid', '$wep->wepid', '$wep->wepseq', '$wep->wepname', '$wep->weptype', $wep->isdefault);<br/>";

              for ($wpidx = 0; $wpidx < count($wep->profiles); $wpidx++) {
                $wp = $wep->profiles[$wpidx];
                //echo "INSERT INTO WeaponProfile VALUES ('$wp->factionid', '$wp->killteamid', '$wp->fireteamid', '$wp->opid', '$wp->wepid', '$wp->profileid', '$wp->name', '$wp->A', '$wp->BS', '$wp->D', '$wp->SR');<br/>";
              }
            }

            // Import the abilities
            for ($abidx = 0; $abidx < count($op->abilities); $abidx++) {
              $ab = $op->abilities[$abidx];
              //echo "INSERT INTO Ability VALUES ('$killteam->factionid', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ab->abilityid', '$ab->title', '$ab->description');<br/>";
            }

            // Import the UniqueActions
            for ($uaidx = 0; $uaidx < count($op->uniqueactions); $uaidx++) {
              $ua = $op->uniqueactions[$uaidx];
              //echo "INSERT INTO UniqueAction VALUES ('$killteam->factionid', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ua->uniqueactionid', '$ua->title', '$ua->AP', '$ua->description');<br/>";
            }
          }
        }

        // Import the Ploys
        $sploys = $killteam->ploys->strat;
        $tploys = $killteam->ploys->tac;

        for ($pidx = 0; $pidx < count($sploys); $pidx++) {
          $ploy = $sploys[$pidx];
          //echo "INSERT INTO Ploy VALUES ('$killteam->factionid', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');<br/>";
        }
        
        for ($pidx = 0; $pidx < count($tploys); $pidx++) {
          $ploy = $tploys[$pidx];
          //echo "INSERT INTO Ploy VALUES ('$killteam->factionid', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');<br/>";
        }

        // Import the Equipments
        for ($eqidx = 0; $eqidx < count($killteam->equipments); $eqidx++) {
          $eq = $killteam->equipments[$eqidx];
          if ($eq->killteamid != 'ALL') {
            //echo "INSERT INTO Equipment VALUES ('$killteam->factionid', '$killteam->killteamid', '$eq->fireteamid', '$eq->opdi', '$eq->eqid', '$eq->eqseq', '$eq->eqpts', '$eq->eqname', '$eq->eqdescription', '$eq->eqtype', '$eq->eqvar1', '$eq->eqvar2', '$eq->eqvar3', '$eq->eqvar4', '$eq->eqcategory');<br/>";
          }
        }

      ?>
	</body>
</html>


	