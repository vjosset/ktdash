<?php
	if ($_SERVER['REQUEST_METHOD'] != "GET") {
		header('HTTP/1.0 400 Invalid Request');
		die();
	}
	
	$root = $_SERVER['DOCUMENT_ROOT'];
	require_once $root . '/include.php';
	global $dbcon;

  $importjson =  json_decode(
    "
  {
	\"factionid\": \"HBR\",
	\"killteamid\": \"GK24\",
	\"edition\": \"kt24\",
	\"killteamname\": \"Grey Knights\",
	\"description\": \"The Grey Knights are a secret and mysterious Chapter of Space Marines specifically tasked with combating the dangerous Daemonic entities of the Warp and all those mortals who wield the corrupt power of the Chaos Gods. They were created by the Emperor with the aid of Malcador the Sigillite at the time of the Horus Heresy to serve as Humanity''s greatest weapon against the threat posed by the existence of Chaos. They have the honour of being implanted with gene-seed engineered directly from the genome of the Emperor Himself. <br/><br/>Unlike other Astartes, every Grey Knight is a potent psyker. Yet, in the 10,000 standard years of Imperial history, no Grey Knight has ever been corrupted by the Ruinous Powers of Chaos. Additionally, the Grey Knights do not follow the tenets of the Codex Astartes in the matter of force organisation.\",
	\"customkeyword\": \"\",
	\"ploys\": {
	  \"strat\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"GK24\",
		  \"ployid\": \"FM\",
		  \"ployname\": \"Focused Mind\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Immediately add 2 Willpower points to your pool.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"GK24\",
		  \"ployid\": \"ATSKNF\",
		  \"ployname\": \"And They Shall Know No Fear\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"You can ignore any changes to the stats of friendly GREY KNIGHT operatives from being injured.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"GK24\",
		  \"ployid\": \"TOC\",
		  \"ployname\": \"Tide Of Celerity\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Until the end of the Turning Point, each time a friendly GREY KNIGHT operative performs a Charge action, it can move an additional 1\\\" for that action.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"GK24\",
		  \"ployid\": \"TOS\",
		  \"ployname\": \"Tide Of Shadows\",
		  \"ploytype\": \"S\",
		  \"CP\": \"1\",
		  \"description\": \"Until the end of the Turning Point, each time an enemy operative on a Vantage Point makes a shooting attack against this operative,\\neach friendly GREY KNIGHT operative that has a Conceal order, is in Cover provided by Light terrain and is more than 6\\\" from that enemy operative cannot be treated as being on an Engage order for that shooting attack as a result of that Vantage Point.\"
		}
	  ],
	  \"tac\": [
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"GK24\",
		  \"ployid\": \"OID\",
		  \"ployname\": \"Anathema\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this Firefight Ploy when a friendly GREY KNIGHT operative is selected as the target for a combat. Until the end of that combat, subtract 1 from the Attacks characteristic of the attacker''s melee weapons.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"AOD\",
		  \"ployid\": \"TP\",
		  \"ployname\": \"Transhuman Physiology\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when an operative is shooting a friendly GREY KNIGHT operative, in the Roll Defence Dice step.\\nYou can retain one of your normal successes as a critical success instead.\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"AOD\",
		  \"ployid\": \"MOD\",
		  \"ployname\": \"Mists of Deimos\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use at the start of any GREY KNIGHT operative''s activation. This operative can perform the Fall Back action for 1 less AP. This operative can perform the Charge action while within control range of an enemy operative, and can leave that operative''s control range to do so (but then normal requirements for that move apply).\"
		},
		{
		  \"factionid\": \"HBR\",
		  \"killteamid\": \"AOD\",
		  \"ployid\": \"RS\",
		  \"ployname\": \"Radiant Strike\",
		  \"ploytype\": \"T\",
		  \"CP\": \"1\",
		  \"description\": \"Use this firefight ploy when a friendly GREY KNIGHT operative is performing the Fight action during an activation in which it has performed the Charge action, at the start of the Resolve Attack Dice step.\\nUntil the end of that action:\\n<ul>\\n<li>Its melee weapon has the Shock weapon rule.</li>\\n<li>The first time you strike during that sequence, inflict 1 additional damage (to a maximum of 7).</li>\\n</ul><br/><strong>Shock:</strong> The first time you strike with a critical success in each sequence, also discard one of your opponent''s unresolved normal successes (or a critical success if there are none).\"
		}
	  ]
	},
	\"equipments\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"GK24\",
		\"eqid\": \"PA\",
		\"eqname\": \"Psybolt Ammnunition\",
		\"eqdescription\": \"Add 1 to the Damage characteristics of all storm bolter weapons for the battle.\",
		\"eqpts\": \"3\",
		\"eqtype\": \"WepMod\",
		\"eqvar1\": \"wepid:SB\",
		\"eqvar2\": \"D:1/1\",
		\"eqvar3\": \"\",
		\"eqvar4\": \"\",
		\"eqcategory\": \"Equipment\",
		\"fireteamid\": \"\",
		\"opid\": \"\",
		\"eqseq\": 0
	  },
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"AOD\",
		\"eqid\": \"PS\",
		\"eqname\": \"Purity Seals\",
		\"eqdescription\": \"Once per turning point, when a friendly GREY KNIGHT operative is shooting, fighting or retaliating, if you roll two or more fails, you can discard one of them to retain another as a normal success instead.\",
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
		\"killteamid\": \"GK24\",
		\"eqid\": \"SB\",
		\"eqname\": \"Sanctic Blessing\",
		\"eqdescription\": \"Add +1 to your Psychic Might roll when determining how many Might points you gain each strategy phase.\",
		\"eqpts\": \"2\",
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
		\"factionid\": \"HBR\",
		\"killteamid\": \"GK24\",
		\"eqid\": \"HW\",
		\"eqname\": \"Hexagrammic Ward\",
		\"eqdescription\": \"Once per battle, when an enemy operative that is Visible to this operative performs a psychic action, this operative can use this ability.\\nIf it does so, roll 1D6: On a 3+, that action''s psychic power is not resolved (the action points subtracted for that action are not refunded).\",
		\"eqpts\": \"2\",
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
	\"killteamcomp\": \"A GREY KNIGHT KillTeam is composed of: <ul> <li> 1 GREY KNIGHT operative selected from the following list: <ul> <li> BROTHERHOOD LIBRARIAN equipped with a Storm Bolter and one of the following options: <ul> <li>Nemesis Force Weapon, or Nemesis Warding Stave</li> </ul> </li> <li> GREY KNIGHT JUSTICAR operative equipped with a Storm Bolter and one of the following options:\\n <ul><li>Nemesis Daemon Hammer, Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li></ul>\\n </ul> </li> <li> 5 GREY KNIGHT operatives selected from the following list: <ul>\\n <li>\\n        GREY KNIGHT WARRIOR equipped with a Storm Bolter and one of the following options:\\n     <ul>\\n                <li>Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li>\\n     </ul>\\n </li>\\n    <li>\\n        GREY KNIGHT PURIFIER equipped with a Storm Bolter and one of the following options:\\n     <ul>\\n                <li>Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li>\\n    </ul>\\n </li>\\n  <li>\\n        GREY KNIGHT INTERCEPTOR equipped with a Storm Bolter and one of the following options:\\n     <ul>\\n                <li>Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li>\\n     </ul>\\n </li>\\n  GREY KNIGHT PURGATOR equipped with Fists and one of the following options:\\n     <ul>\\n                <li>Incinerator, Psilencer, or Psycannon</li>\\n     </ul>\\n </li>\\n </ul><br/>Your kill team can only include up to one GREY NIGHT PURGATOR operative. <br/><br/> Some GREY KNIGHT rules refer to a ''bolt weapon''. This is a ranged weapon that includes ''bolt'' in its name, e.g. stalker bolt rifle, heavy bolt pistol, etc.\",
	\"fireteams\": [
	  {
		\"factionid\": \"HBR\",
		\"killteamid\": \"GK24\",
		\"fireteamid\": \"GK24\",
		\"seq\": 0,
		\"fireteamname\": \"Grey Knights\",
		\"archetype\": \"Seek And Destroy/Security\",
		\"description\": \"\",
		\"killteammax\": 0,
		\"operatives\": [
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"LIB\",
			\"opseq\": 0,
			\"opname\": \"Brotherhood Librarian\",
			\"description\": \"Justicars are the lynchpin of their team. In psychic communion, they lead their brothers in carefully divined tactical ploys, arcane battle rites, and psychic rituals.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"15\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, LEADER, JUSTICAR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NFW\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Force Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NFW\",
					\"profileid\": \"0\",
					\"name\": \"\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NWS\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Warding Stave\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NWS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"*Ward\"
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
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Master Librarian\",
				\"description\": \"This model may manifest psychic powers without spending Willpower points.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"WARD\",
				\"title\": \"*Ward\",
				\"description\": \"If this operative is equipped with a Nemesis Warding Stave, whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"JST\",
			\"opseq\": 0,
			\"opname\": \"Grey Knight Justicar\",
			\"description\": \"Justicars are the lynchpin of their team. In psychic communion, they lead their brothers in carefully divined tactical ploys, arcane battle rites, and psychic rituals.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"15\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, LEADER, JUSTICAR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NDH\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Daemon Hammer\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NDH\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"4+\",
					\"D\": \"5/6\",
					\"SR\": \"Stun\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NF\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Falchions\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Balanced\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NFW\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Force Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NFW\",
					\"profileid\": \"0\",
					\"name\": \"\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"wepid\": \"NWS\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Warding Stave\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"JST\",
					\"wepid\": \"NWS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"*Ward\"
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
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"WARD\",
				\"title\": \"*Ward\",
				\"description\": \"If this operative is equipped with a Nemesis Warding Stave, whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"WAR\",
			\"opseq\": 0,
			\"opname\": \"Grey Knight Warrior\",
			\"description\": \"Grey Knights are martial elites clad in ward-etched armour. They combine the genetic augmentation of Space Marines with an indomitable psychic might, smiting those who traffic with the daemonic wherever they hide.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, WARRIOR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NF\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Falchions\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Balanced\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NFW\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Force Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NFW\",
					\"profileid\": \"0\",
					\"name\": \"\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NWS\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Warding Stave\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NWS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"*Ward\"
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
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"WARD\",
				\"title\": \"*Ward\",
				\"description\": \"If this operative is equipped with a Nemesis Warding Stave, whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"PUR\",
			\"opseq\": 0,
			\"opname\": \"Grey Knight Purifier\",
			\"description\": \"Grey Knights are martial elites clad in ward-etched armour. They combine the genetic augmentation of Space Marines with an indomitable psychic might, smiting those who traffic with the daemonic wherever they hide.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"12\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, PURIFIER\",
			\"weapons\": [
			  {
				\"factionid\": \"CHAOS\",
				\"killteamid\": \"CULT24\",
				\"fireteamid\": \"CULT24\",
				\"opid\": \"MW\",
				\"wepid\": \"IG\",
				\"wepseq\": 0,
				\"wepname\": \"Psychic Overload\",
				\"weptype\": \"R\",
				\"isdefault\": 1,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"PUR\",
					\"wepid\": \"PO\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"4\",
					\"BS\": \"4+\",
					\"D\": \"0/0\",
					\"SR\": \"Psychic, Rng 6\\\", Lethal 4+, Dev2\"
				  }
				],
				\"isselected\": true
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NF\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Falchions\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Balanced\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NFW\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Force Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NFW\",
					\"profileid\": \"0\",
					\"name\": \"\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NWS\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Warding Stave\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NWS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"*Ward\"
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
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"WARD\",
				\"title\": \"*Ward\",
				\"description\": \"If this operative is equipped with a Nemesis Warding Stave, whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"INT\",
			\"opseq\": 0,
			\"opname\": \"Grey Knight Interceptor\",
			\"description\": \"Grey Knights are martial elites clad in ward-etched armour. They combine the genetic augmentation of Space Marines with an indomitable psychic might, smiting those who traffic with the daemonic wherever they hide.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"11\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, WARRIOR\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"SB\",
				\"wepseq\": 0,
				\"wepname\": \"Storm Bolter\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NF\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Falchions\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NF\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"Balanced\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NFW\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Force Weapon\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NFW\",
					\"profileid\": \"0\",
					\"name\": \"\",
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
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"WAR\",
				\"wepid\": \"NWS\",
				\"wepseq\": 0,
				\"wepname\": \"Nemesis Warding Stave\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"WAR\",
					\"wepid\": \"NWS\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/5\",
					\"SR\": \"*Ward\"
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
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  },
			  {
				\"factionid\": \"VOT\",
				\"killteamid\": \"HKS24\",
				\"fireteamid\": \"HKS24\",
				\"opid\": \"JMP\",
				\"abilityid\": \"JP\",
				\"title\": \"Personal Teleporter\",
				\"description\": \"Once per game, when this operative performs an action in which it moves, it can FLY. If it does, don’t move it.\\nInstead, remove it from the killzone and set it back up wholly within a distance equal to its Move stat (or 3\\\" if it was a Dash) of its original location,\\nmeasuring the horizontal distance only (in a killzone that uses the close quarters rules, e.g. Killzone: Gallowdark, this distance cannot be measured over or through Wall terrain,\\nand that operative cannot be set up on the other side of an access point – in other words it cannot FLY through an open hatchway).\\nNote that it gains no additional distance when performing the Charge action.\\nIt must be set up in a location it can be placed, and unless it’s the Charge action, it cannot be set up within control range of an enemy operative.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"WARD\",
				\"title\": \"*Ward\",
				\"description\": \"If this operative is equipped with a Nemesis Warding Stave, whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Combat,Staunch,Marksman\"
		  },
		  {
			\"factionid\": \"HBR\",
			\"killteamid\": \"GK24\",
			\"fireteamid\": \"GK24\",
			\"opid\": \"PURG\",
			\"opseq\": 0,
			\"opname\": \"Grey Knight Purgator\",
			\"description\": \"It takes years of intensive training for a Grey Knight to master the psychically charged specialist weapons of their Chapter, but those who do are capable of unleashing barrages of esoteric firepower that rip through the heaviest opposition.\",
			\"M\": \"6\\\"\",
			\"APL\": \"3\",
			\"GA\": \"1\",
			\"DF\": \"3\",
			\"SV\": \"3+\",
			\"W\": \"14\",
			\"keywords\": \"GREY KNIGHT, IMPERIUM, SANCTIC ASTARTES, PSYKER, GUNNER\",
			\"weapons\": [
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"GNR\",
				\"wepid\": \"INC\",
				\"wepseq\": 0,
				\"wepname\": \"Incinerator\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"GNR\",
					\"wepid\": \"INC\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"6\",
					\"BS\": \"2+\",
					\"D\": \"2/3\",
					\"SR\": \"Hvy (RepOnly), Rng 6\\\", Tor 2\\\", Sat\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"GNR\",
				\"wepid\": \"PSL\",
				\"wepseq\": 0,
				\"wepname\": \"Psilencer\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"GNR\",
					\"wepid\": \"PSL\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"6\",
					\"BS\": \"3+\",
					\"D\": \"3/4\",
					\"SR\": \"Hvy (RepOnly), Ceaseless\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"GNR\",
				\"wepid\": \"PSC\",
				\"wepseq\": 0,
				\"wepname\": \"Psycannon\",
				\"weptype\": \"R\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"GNR\",
					\"wepid\": \"PSC\",
					\"profileid\": \"0\",
					\"name\": \"\",
					\"A\": \"5\",
					\"BS\": \"3+\",
					\"D\": \"4/6\",
					\"SR\": \"Hvy (RepOnly), PrcCrit1\"
				  }
				],
				\"isselected\": false
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"GNR\",
				\"wepid\": \"F\",
				\"wepseq\": 0,
				\"wepname\": \"Fists\",
				\"weptype\": \"M\",
				\"isdefault\": 0,
				\"profiles\": [
				  {
					\"factionid\": \"HBR\",
					\"killteamid\": \"GK24\",
					\"fireteamid\": \"GK24\",
					\"opid\": \"GNR\",
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
				\"killteamid\": \"DW24\",
				\"fireteamid\": \"DW24\",
				\"opid\": \"WM\",
				\"abilityid\": \"AS\",
				\"title\": \"Astartes\",
				\"description\": \"During each friendly GREY KNIGHT operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it''s two Shoot actions, a bolt weapon must be selected for at least one of them, and if it''s a bolt sniper rifle or heavy bolter, 1 additional AP must be spent for the second action if both actions are using that weapon.<br/>\\nEach friendly GREY KNIGHT operative can counteract regardless of its order.\"
			  },
			  {
				\"factionid\": \"HBR\",
				\"killteamid\": \"GK24\",
				\"fireteamid\": \"GK24\",
				\"opid\": \"JST\",
				\"abilityid\": \"BOP\",
				\"title\": \"Brotherhood of Psykers\",
				\"description\": \"<em>PSYCHIC</em><br/>\\nIn the ready step of each Strategy phase, your killteam gains 1D3 Willpower points.\\nYou can spend your Willpower points in the Firefight phase to manifest the following psychic powers as an action:\\n<ul>\\n<li>Astral Aim: <em>PSYCHIC</em> Until the end of the Turning Point, this operative''s ranged weapons gain the Saturate special rule.</li>\\n<li>Aegis Shield: <em>PSYCHIC</em> Until the end of the Turning Point, ignore the Piercing weapon rule.</li>\\n<li>Hammerhand: <em>PSYCHIC</em> Until the end of the Turning Point, each time this operative fights in combat, in the Resolve Successful Hits step of that combat, the first time it strikes, inflict 1 additional damage on the target.</li>\\n</ul> Each Psychic power may only be used once per turning point.\"
			  }
			],
			\"edition\": \"kt24\",
			\"fireteammax\": 0,
			\"specialisms\": \"Staunch,Marksman\"
		  }
		],
		\"fireteamcomp\": \"A GREY KNIGHT kill team includes one GREY KNIGHT JUSTICAR operative equipped with a Storm Bolter and one of the following options:\\n <ul><li>Nemesis Daemon Hammer, Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li></ul>\\n It also includes five GREY KNIGHT operatives selected from the following list:\\n <ul>\\n <li>\\n        GREY KNIGHT WARRIOR equipped with a Storm Bolter and one of the following options:\\n     <ul>\\n                <li>Nemesis Daemon Hammer, Nemesis Falchions, Nemesis Force Weapon, or Nemesis Warding Stave</li>\\n     </ul>\\n </li>\\n        GREY KNIGHT GUNNER equipped with Fists and one of the following options:\\n     <ul>\\n                <li>Incinerator, Psilencer, or Psycannon</li>\\n     </ul>\\n </li>\\n </ul>\\n Your kill team can only include up to one GREY NIGHT GUNNER operative.\"
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


	