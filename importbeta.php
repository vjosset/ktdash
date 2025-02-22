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
        \"killteamid\": \"DAEM24\",
        \"edition\": \"kt24\",
        \"killteamname\": \"Chaos Daemons\",
        \"description\": \"A Chaos Daemon, or simply Daemon, also known as a \\\"Neverborn\\\" amongst the forces of Chaos, is an intelligent and usually malevolent entity of the Warp comprised of purely psychic energy. Daemons are sentient embodiments of Chaos and collectively the greatest servants of the Chaos Gods and of Chaos itself as a universal force. \\n <br/><br/>\\n Daemons are created at the whim of one of the four major Chaos Gods from a fraction of the god''s own power within the Immaterium and act as an extension of its will. A Daemon''s appearance and intrinsic character reflect the god''s own nature. These Daemons may be reabsorbed into the god''s psychic signature in the Warp at their whim.\",
        \"customkeyword\": \"\",
        \"ploys\": {
          \"strat\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"QS\",
              \"ployname\": \"Prey on the Weak\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the turning point, when a friendly CHAOS DAEMON operative performs the Fight or Shoot action against a wounded target, that attack gains the Ceaseless weapon rule.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"QS\",
              \"ployname\": \"Daemonsight\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Whenever you are selecting a valid target for a friendly CHAOS DAEMON operative, enemy operatives within 6\\\" cannot use Light terrain for cover. While this can allow such operatives to be targeted (assuming they are visible), it does not remove their cover save (if any).\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"QS\",
              \"ployname\": \"Reality Shift\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"You can immediately change the order of up to three friendly CHAOS DAEMON operatives that are not within control range of enemy operatives.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"DN\",
              \"ployname\": \"Symbol of Terror\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, when determining control of an objective marker that any friendly LEADER operatives are within range of, treat enemy operatives'' total APL as being 1 less. Note that this is not a modifier.\"
            }
          ],
          \"tac\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"BR\",
              \"ployname\": \"Warp Walk\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this firefight ploy during a friendly CHAOS DAEMON operative''s activation, when it performs an action in which it moves. Until the end of that activation, that operative can move through parts of terrain features as if they were not there, but must and those moves in a location it can be placed.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"ER\",
              \"ployname\": \"Ephemeral Regeneration\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy when a friendly CHAOS DAEMON operative is activated. That friendly operative regains 2D3 lost wounds.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"ER\",
              \"ployname\": \"Daemonic Mockery\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this firefight ploy when a friendly CHAOS DAEMON operative is retaliating or an enemy operative is shooting it, after your opponent rolls their attack dice, but before re-rolls. Until the end of the sequence, your opponent cannot re-roll their attack dice (if your opponent declared the use of any firefight ploys during that sequence that would allow them to re-roll, that ploy is cancelled and the CP spent on it is refunded).\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"ployid\": \"WS\",
              \"ployname\": \"Time Surge\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy when a friendly CHAOS DAEMON operative is selected as the target of a ranged attack. Until the end of the Turning Point, each time a shooting attack is made against that friendly operative, in the Roll Defence Dice step of that shooting attack, you can re-roll any or all of your defence dice.\"
            }
          ]
        },
        \"equipments\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"DAEM24\",
            \"eqid\": \"BH\",
            \"eqname\": \"Daemonic Icon\",
            \"eqdescription\": \"Use this equipment when a friendly CHAOS DAEMON operative is activated. Select one objective marker within 3\\\" and visible to that operative. Until the end of the battle or until you use this equipment again (whichever comes first), when determining control of that objective marker, treat friendly operatives’ APL stat as 1 higher. Note this isn’t a change to the APL stat, so any changes are cumulative with this.\",
            \"eqpts\": \"1\",
            \"eqtype\": \"Ability\",
            \"eqvar1\": \"\",
            \"eqvar2\": \"\",
            \"eqvar3\": \"\",
            \"eqvar4\": \"\",
            \"eqcategory\": \"Equipment\",
            \"fireteamid\": \"DAEM24\",
            \"opid\": \"\",
            \"eqseq\": 0
          },
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"DAEM24\",
            \"eqid\": \"BH\",
            \"eqname\": \"Instrument of Chaos\",
            \"eqdescription\": \"Once per Turning point a friendly CHAOS DAEMON operative can use this equipment. If it does, until the end of the Turning Point, each time a friendly CHAOS DAEMON operative within 3\\\" and visible to this operative fights in combat, in the Roll Attack Dice step of that combat, if it performed a Charge action during that activation, you can re-roll one of your attack dice.\",
            \"eqpts\": \"1\",
            \"eqtype\": \"Ability\",
            \"eqvar1\": \"\",
            \"eqvar2\": \"\",
            \"eqvar3\": \"\",
            \"eqvar4\": \"\",
            \"eqcategory\": \"Equipment\",
            \"fireteamid\": \"DAEM24\",
            \"opid\": \"\",
            \"eqseq\": 0
          },
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"DAEM24\",
            \"eqid\": \"GT\",
            \"eqname\": \"Grisly Trophy\",
            \"eqdescription\": \"Once per Battle, when a friendly CHAOS DAEMON operative incapacitates an enemy operative within 2\\\" of it, you can use this rule. If you do, that friendly operative gains one of your Grisly Trophy tokens (if it does not already have one). Whenever a friendly CHAOS DAEMON operative that has one of your Grisly Trophy tokens is visible to and within 2\\\" of an enemy operative, subtract 1 from the ATK stat of that enemy operative''s weapons.\",
            \"eqpts\": \"1\",
            \"eqtype\": \"Ability\",
            \"eqvar1\": \"\",
            \"eqvar2\": \"\",
            \"eqvar3\": \"\",
            \"eqvar4\": \"\",
            \"eqcategory\": \"Equipment\",
            \"fireteamid\": \"DAEM24\",
            \"opid\": \"\",
            \"eqseq\": 0
          },
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"DAEM24\",
            \"eqid\": \"RD\",
            \"eqname\": \"Ritual Daggers\",
            \"eqdescription\": \"Operatives are equipped with the following melee weapon for the battle:\\n<table width=\\\"100%\\\" class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th>\\n        <th>A</th>\\n        <th>BS</th>\\n        <th>D</th>\\n</tr>\\n    <tr>\\n<td>Ritual Dagger</td>\\n        <td>3</td>\\n        <td>4+</td>\\n        <td>3/4</td>\\n</tr>\\n    <tr><th colspan=\\\"4\\\">Special Rules</th></tr>\\n    <tr><td colspan=\\\"4\\\">Balanced</td></tr>\\n</table>\",
            \"eqpts\": \"2\",
            \"eqtype\": \"Weapon\",
            \"eqvar1\": \"\",
            \"eqvar2\": \"\",
            \"eqvar3\": \"\",
            \"eqvar4\": \"\",
            \"eqcategory\": \"Equipment\",
            \"fireteamid\": \"\",
            \"opid\": \"\",
            \"eqseq\": 0,
            \"weapon\": {
              \"factionid\": \"HBR\",
              \"killteamid\": \"DAEM24\",
              \"fireteamid\": \"EQ\",
              \"opid\": \"EQ\",
              \"wepid\": \"RD\",
              \"wepseq\": 0,
              \"wepname\": \"Ritual Dagger\",
              \"weptype\": \"M\",
              \"isdefault\": 0,
              \"profiles\": [
                {
                  \"factionid\": \"HBR\",
                  \"killteamid\": \"DAEM24\",
                  \"fireteamid\": \"EQ\",
                  \"opid\": \"EQ\",
                  \"wepid\": \"RD\",
                  \"profileid\": \"0\",
                  \"name\": \"\",
                  \"A\": \"3\",
                  \"BS\": \"4+\",
                  \"D\": \"3/4\",
                  \"SR\": \"Balanced\"
                }
              ]
            }
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
        \"killteamcomp\": \"A CHAOS DAEMON KillTeam is composed of:\\r <ul>\\r \\t<li>\\r 1 CHAOS DAEMON operative selected from the following list:\\r <ul><li>KHORNE BLOODREAPER</li><li>TZEENTCH IRIDESCENT</li><li>SLAANESH ALLURESS</li><li>NURGLE PLAGUERIDDEN</li></ul>\\r \\t</li>\\r \\t<li>\\r 9 CHAOS DAEMON operatives selected from the following list:\\r <ul><li>KHORNE BLOODLETTER</li><li>TZEENTCH PINK HORROR</li><li>SLAANESH DAEMONETTE</li><li>NURGLE PLAGUEBEARER</li></ul>\\r \\t</li>\\r </ul>Other than FIGHTER operatives, your kill team can only include each operative on this list once.\",
        \"fireteams\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"DAEM24\",
            \"fireteamid\": \"DAEM24\",
            \"seq\": 0,
            \"fireteamname\": \"Chaos Daemons\",
            \"archetype\": \"Seek And Destroy\",
            \"description\": \"\",
            \"killteammax\": 0,
            \"operatives\": [
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"BR\",
                \"opseq\": 0,
                \"opname\": \"Bloodreaper\",
                \"description\": \"Bloodreapers marshal Khorne''s frenzied hordes in battle. They are among the deadliest warriors of their kind, each having offered up countless skulls to their lord. They are not blinded by rage, and despatch their lessers with martial precision to ensure no foe escapes.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"10\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, KHORNE, LEADER, BLOODLETTER, BLOODREAPER\",
                \"basesize\": 32,
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"wepid\": \"HB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Hellblade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"DAEM24\",
                        \"opid\": \"BR\",
                        \"wepid\": \"HB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"4/6\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Champion of Khorne\",
                    \"description\": \"During this operative''s activation, it may perform a free Fight action and it is allowed to perform two Fight actions.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. KHORNE), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Khorne</h2><strong>Flaming Strike</strong><br/>\\nUse this POWER OF CHAOS when a friendly KHORNE DAEMON operative is fighting, the first time you strike with a critical success during that sequence. Until the end of that sequence, that operative’s melee weapon has the Shock weapon rule.<br/><br/><strong>Berzerker Rage</strong><br/>\\nUse this POWER OF CHAOS during a friendly KHORNE DAEMON operative’s activation, after it’s performed the Charge action and incapacitated an enemy operative during the Fight action, and is no longer within control range of\\nenemy operatives. That friendly operative can immediately perform a free Charge action using any remaining move distance it had from that first Charge action. That operative can perform two Charge actions during its activation to do so. The operative cannot have performed any other actions\\nduring this activation (but can do so after resolving this POWER OF CHAOS).\\n<br/><br/><strong>Killing Blow</strong><br/>\\nUse this POWER OF CHAOS when a friendly KHORNE DAEMON operative is fighting or retaliating and you strike with a normal or critical success. Inflict d3 additional damage with that strike.<br/><br/><strong>Call to Slaughter</strong><br/>Use this POWER OF CHAOS during a friendly KHORNE DAEMON operative’s activation, when it incapacitates an enemy operative within its control range. Select one other ready friendly CHAOS DAEMON operative that’s visible to and within 3\\\" of the incapacitated enemy operative. When that first friendly operative is expended, you can activate that other friendly operative before your opponent activates. When that other operative is expended, your opponent then activates as normal.<br/><br/><strong>Whirling Death</strong><br/>Use this POWER OF CHAOS when a friendly KHORNE DAEMON operative is incapacitated, roll 1D3. Inflict damage equal to the result on one enemy operative visible to and within 2\\\" of that friendly operative.\"
                  }
                ],
                \"edition\": \"kt24\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"IR\",
                \"opseq\": 0,
                \"opname\": \"Pink Horror Iridescent\",
                \"description\": \"Iridescent Horrors are imbued with a sliver of Tzeentch''s immortal knowledge. They revel in leading their capering daemons in enacting Tzeentch''s schemes.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"9\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, TZEENTCH, LEADER, PINK HORROR, IRIDESCENT\",
                \"basesize\": 32,
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"IR\",
                    \"wepid\": \"CF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Coruscating Flames\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PH\",
                        \"opid\": \"IR\",
                        \"wepid\": \"CF\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/4\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"IR\",
                    \"wepid\": \"F\",
                    \"wepseq\": 0,
                    \"wepname\": \"Fists\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PH\",
                        \"opid\": \"IR\",
                        \"wepid\": \"F\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"3\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"IR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Champion of Tzeench\",
                    \"description\": \"During this operative''s activation, it may perform a free Shoot action and it is allowed to perform two Shoot actions.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. TZEENTCH), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Tzeentch</h2><strong>Creeping Flame</strong><br/>\\nUse this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames.\\nUntil the end of that action, that weapon has the Torrent 2\\\" weapon rule, but you cannot select more than one secondary target.\\n<br/><br/><strong>Essence of Change</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is activated. Until the end of that operative’s activation, add 1 to its APL stat.<br/><br/><strong>Glistening Barrage</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames. Until the end of that action, that weapon has the Lethal 5+ weapon rule.<br/><br/><strong>Flickering Fates</strong><br/>Use this POWER OF CHAOS when an operative is shooting a friendly TZEENTCH DAEMON operative, in the Roll Defence Dice step, if you retain any critical successes, you can retain one of your fails as a normal success instead of discarding it.<br/><br/><strong>Daemonic Split</strong><br/>Use this POWER OF CHAOS when a friendly PINK HORROR or BLUE HORROR operative is incapacitated.\\n<ul>\\n<li>Before that PINK HORROR operative is removed from the killzone, set up two BLUE HORROR operatives as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n<li>Before that BLUE HORROR operative is removed from the killzone, set up one BRIMSTONE HORROR operative as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n</ul>\\nIn either case, set up those operatives with the same order as the previous operative (including if it was ready or activated).\"
                  }
                ],
                \"edition\": \"kt21\",
                \"fireteammax\": 0,
                \"specialisms\": \"Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"AL\",
                \"opseq\": 1,
                \"opname\": \"Alluress\",
                \"description\": \"Most beauteous and yet more repulsive than most Daemonettes, Alluresses orchestrate their kin''s slaughter with trilling songs of praise to Slaanesh. Their hypnotic glamour causes foes to falter in their presence, helpless as barbed claws and needle-like teeth close in.\",
                \"M\": \"7\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"9\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, SLAANESH, LEADER, DAEMONETTE, ALLURESS\",
                \"basesize\": 32,
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DETTE\",
                    \"opid\": \"AL\",
                    \"wepid\": \"CLS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Claws\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"DETTE\",
                        \"opid\": \"AL\",
                        \"wepid\": \"CLS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"4/5\",
                        \"SR\": \"Balanced\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DETTE\",
                    \"opid\": \"AL\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Champion of Slaanesh\",
                    \"description\": \"During this operative''s activation, it may perform a free Charge action.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. SLAANESH), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Slaanesh</h2><strong>Swift Retreat</strong><br/>\\nUse this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is fighting, after you strike with a critical success. End that sequence (any remaining attack dice are discarded) and immediately perform a free Dash or Fall\\nBack action up to 3\\\" with that operative (then the Fight action ends). That operative can do so even if it’s performed an action that prevents it from performing the Dash or Fall Back action.<br/><br/><strong>Unnatural Agility</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is fighting or retaliating, worsen the Hit stat of the enemy operative''s melee weapons by 1.<br/><br/><strong>Flurry of Blows</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is performing the Fight action and you select a Claws weapon. Until the end of that action, that weapon has the Relentless weapon rule.<br/><br/><strong>Weaving Dance</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative performs an action in which it moves. Until the end of the action, that operative:\\n<ul>\\n<li>Can ignore all vertical distances whenever it drops and climbs.</li>\\n<li>Can move through enemy operatives, move within control range of them, and during the Charge action can leave their control range (it must still end the move following all requirements for that move).</li>\\n<li>Cannot move more than its Move stat if it’s the Charge action.</li></ul><strong>Tormenting Strike</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is performing the Fight action and you select a Claws weapon. Until the end of that action, that weapon has the Piercing Crits 1 weapon rule.\"
                  }
                ],
                \"edition\": \"kt21\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Scout\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"PR\",
                \"opseq\": 0,
                \"opname\": \"Plagueridden\",
                \"description\": \"Despite their death''s head rictus grin, Plageridden are devoted to the serious business of spreading Nurgle''s bounteous plagues across reality. They often bear signs fo Nurgle''s favour - such as more elaborate horns - and direct other Plaguebearers in his grand plans.\",
                \"M\": \"5\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"9\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, NURGLE, LEADER, PLAGUEBEARER, PLAGUERIDDEN\",
                \"basesize\": 32,
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"PR\",
                    \"wepid\": \"PS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Plaguesword\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PB\",
                        \"opid\": \"PR\",
                        \"wepid\": \"PS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"4/6\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"PR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"BR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Champion of Nurgle\",
                    \"description\": \"During this operative''s activation, it may perform a Pick-up or Mission action.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"PR\",
                    \"abilityid\": \"DR\",
                    \"title\": \"Disgustingly Resilient\",
                    \"description\": \"Whenever an attack dice inflicts damage of 3 or more on a friendly NURGLE DAEMON operative, roll one D6: on a 4+, subtract 1 from that inflicted damage.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. NURGLE), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Nurgle</h2><strong>Noxious Cloud</strong><br/>Use this POWER OF CHAOS during a friendly NURGLE DAEMON operative’s activation. Until the end of the turn, whenever an operative is shooting a friendly CHAOS DAEMON operative that is more than 3\\\" from it, if that friendly operative is wholly within 3\\\" of this operative, that friendly operative is obscured.<br/><br/><strong>Curse of Rot</strong><br/>Use this POWER OF CHAOS during a friendly NURGLE DAEMON operative’s activation. Select one enemy operative within 8\\\" and visible to this operative. Subtract 2\\\" from the Move stat of that enemy operative and worsen the Hit stat of its weapons by 1 (this is not cumulative with being injured) until the end of the turning point.<br/><br/><strong>Rancid Vomit</strong><br/>Use this POWER OF CHAOS when a friendly NURGLE DAEMON operative is performing the Shoot action. Until the end of that action, that operative can use the following ranged weapon:\\n<table width=\\\"100%\\\" class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th>\\n        <th>A</th>\\n        <th>BS</th>\\n        <th>D</th>\\n</tr>\\n    <tr>\\n<td>Rancid Vomit</td>\\n        <td>5</td>\\n        <td>2+</td>\\n        <td>2/3</td>\\n</tr>\\n    <tr><th colspan=\\\"4\\\">Special Rules</th></tr>\\n    <tr><td colspan=\\\"4\\\">Rng 6\\\", Tor 1\\\", Saturate</td></tr>\\n</table><br/><br/><strong>Shambling Wretch</strong><br/>Use this POWER OF CHAOS at the start of a friendly NURGLE DAEMON operative''s activation. You can ignore any changes to the stats of that operative from being injured (including their weapons'' stats) until the end of that activation.<br/><br/><strong>Revolting Resiliency</strong><br/>Use this POWER OF CHAOS when an attack dice inflicts damage on a friendly NURGLE DAEMON operative. Until the end of the activation/counteraction, for the purposes of the Disgustingly Resilient rule for that operative, always subtract 1 from the damage inflicted (to a minimum of 2) – you do not need to roll.\"
                  }
                ],
                \"edition\": \"kt21\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"BFTR\",
                \"opseq\": 0,
                \"opname\": \"Bloodletter Fighter\",
                \"description\": \"Bloodletters are Khorne''s most numerous warriors, the foot soldiers of the Blood Legions. Their skin is the colour of spilt gore, and their muscles bulge in response to their rage. They carry jagged Hellblades in their taloned hands that glow with the energies of the Warp.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"9\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, KHORNE, BLOODLETTER, FIGHTER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"FTR\",
                    \"wepid\": \"HB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Hellblade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"DAEM24\",
                        \"opid\": \"FTR\",
                        \"wepid\": \"HB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
                        \"D\": \"4/6\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DAEM24\",
                    \"opid\": \"FTR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. KHORNE), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Khorne</h2><strong>Flaming Strike</strong><br/>\\nUse this POWER OF CHAOS when a friendly KHORNE DAEMON operative is fighting, the first time you strike with a critical success during that sequence. Until the end of that sequence, that operative’s melee weapon has the Shock weapon rule.<br/><br/><strong>Berzerker Rage</strong><br/>\\nUse this POWER OF CHAOS during a friendly KHORNE DAEMON operative’s activation, after it’s performed the Charge action and incapacitated an enemy operative during the Fight action, and is no longer within control range of\\nenemy operatives. That friendly operative can immediately perform a free Charge action using any remaining move distance it had from that first Charge action. That operative can perform two Charge actions during its activation to do so. The operative cannot have performed any other actions\\nduring this activation (but can do so after resolving this POWER OF CHAOS).\\n<br/><br/><strong>Killing Blow</strong><br/>\\nUse this POWER OF CHAOS when a friendly KHORNE DAEMON operative is fighting or retaliating and you strike with a normal or critical success. Inflict d3 additional damage with that strike.<br/><br/><strong>Call to Slaughter</strong><br/>Use this POWER OF CHAOS during a friendly KHORNE DAEMON operative’s activation, when it incapacitates an enemy operative within its control range. Select one other ready friendly CHAOS DAEMON operative that’s visible to and within 3\\\" of the incapacitated enemy operative. When that first friendly operative is expended, you can activate that other friendly operative before your opponent activates. When that other operative is expended, your opponent then activates as normal.<br/><br/><strong>Whirling Death</strong><br/>Use this POWER OF CHAOS when a friendly KHORNE DAEMON operative is incapacitated, roll 1D3. Inflict damage equal to the result on one enemy operative visible to and within 2\\\" of that friendly operative.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"ZFTR\",
                \"opseq\": 0,
                \"opname\": \"Pink Horror Fighter\",
                \"description\": \"Pink Horrors are magic made manifest. They caper and whirl, cackling as bolts of raw sorcery leap from their clawed fingertips. These coruscating streams of multicoloured flame do not merely burn, they turn their victims into hedeous or nonsensical forms.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"8\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, TZEENTCH, PINK HORROR, FIGHTER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"FTR\",
                    \"wepid\": \"CF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Coruscating Flames\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PH\",
                        \"opid\": \"FTR\",
                        \"wepid\": \"CF\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
                        \"D\": \"3/4\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"FTR\",
                    \"wepid\": \"F\",
                    \"wepseq\": 0,
                    \"wepname\": \"Fists\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PH\",
                        \"opid\": \"FTR\",
                        \"wepid\": \"F\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"3\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PH\",
                    \"opid\": \"FTR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. TZEENTCH), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Tzeentch</h2><strong>Creeping Flame</strong><br/>\\nUse this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames.\\nUntil the end of that action, that weapon has the Torrent 2\\\" weapon rule, but you cannot select more than one secondary target.\\n<br/><br/><strong>Essence of Change</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is activated. Until the end of that operative’s activation, add 1 to its APL stat.<br/><br/><strong>Glistening Barrage</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames. Until the end of that action, that weapon has the Lethal 5+ weapon rule.<br/><br/><strong>Flickering Fates</strong><br/>Use this POWER OF CHAOS when an operative is shooting a friendly TZEENTCH DAEMON operative, in the Roll Defence Dice step, if you retain any critical successes, you can retain one of your fails as a normal success instead of discarding it.<br/><br/><strong>Daemonic Split</strong><br/>Use this POWER OF CHAOS when a friendly PINK HORROR or BLUE HORROR operative is incapacitated.\\n<ul>\\n<li>Before that PINK HORROR operative is removed from the killzone, set up two BLUE HORROR operatives as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n<li>Before that BLUE HORROR operative is removed from the killzone, set up one BRIMSTONE HORROR operative as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n</ul>\\nIn either case, set up those operatives with the same order as the previous operative (including if it was ready or activated).\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"BLUE\",
                \"opseq\": 0,
                \"opname\": \"Blue Horror\",
                \"description\": \"Should a Pink Horror be cut down, it may split, with the two halves reforming as smaller daemons. These Blue Horrors are morose and spiteful creatures, aggressively calling on their Warp-spawned powers to destroy those who dared to lay their original form low.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"2\",
                \"DF\": \"3\",
                \"SV\": \"6+\",
                \"W\": \"6\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, TZEENTCH,  BLUE HORROR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"BH\",
                    \"opid\": \"BLUE\",
                    \"wepid\": \"FF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Fizzing Flames\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"BH\",
                        \"opid\": \"BLUE\",
                        \"wepid\": \"FF\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Rng 6\\\"\"
                      }
                    ],
                    \"isselected\": true
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"BH\",
                    \"opid\": \"BLUE\",
                    \"wepid\": \"F\",
                    \"wepseq\": 0,
                    \"wepname\": \"Fists\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"BH\",
                        \"opid\": \"BLUE\",
                        \"wepid\": \"F\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"3\",
                        \"BS\": \"5+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"BH\",
                    \"opid\": \"BLUE\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"TYR\",
                    \"killteamid\": \"BBRO24\",
                    \"fireteamid\": \"BBRO24\",
                    \"opid\": \"FAM\",
                    \"abilityid\": \"GA\",
                    \"title\": \"Group Activation\",
                    \"description\": \"Whenever this operative is expended, you must then activate any other ready friendly CHAOS DAEMON BLUE HORROR operative (if able) before your opponent activates.\\nWhen that other operative is expended, your opponent then activates as normal.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. TZEENTCH), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Tzeentch</h2><strong>Creeping Flame</strong><br/>\\nUse this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames.\\nUntil the end of that action, that weapon has the Torrent 2\\\" weapon rule, but you cannot select more than one secondary target.\\n<br/><br/><strong>Essence of Change</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is activated. Until the end of that operative’s activation, add 1 to its APL stat.<br/><br/><strong>Glistening Barrage</strong><br/>Use this POWER OF CHAOS when a friendly TZEENTCH DAEMON operative is performing the Shoot action and you select a Coruscating Flames or Fizzing Flames. Until the end of that action, that weapon has the Lethal 5+ weapon rule.<br/><br/><strong>Flickering Fates</strong><br/>Use this POWER OF CHAOS when an operative is shooting a friendly TZEENTCH DAEMON operative, in the Roll Defence Dice step, if you retain any critical successes, you can retain one of your fails as a normal success instead of discarding it.<br/><br/><strong>Daemonic Split</strong><br/>Use this POWER OF CHAOS when a friendly PINK HORROR or BLUE HORROR operative is incapacitated.\\n<ul>\\n<li>Before that PINK HORROR operative is removed from the killzone, set up two BLUE HORROR operatives as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n<li>Before that BLUE HORROR operative is removed from the killzone, set up one BRIMSTONE HORROR operative as close as possible to that operative and not within Engagement Range of enemy operatives.</li>\\n</ul>\\nIn either case, set up those operatives with the same order as the previous operative (including if it was ready or activated).\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Scout,Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"BRIM\",
                \"opseq\": 0,
                \"opname\": \"Brimstone Horror\",
                \"description\": \"Blue Horrors that are destroyed may vanish in a cloud of smoke, from which emrge two stunted Brimstone Horrors. These diminutive daemons are manifestations of pure bitterness, seeking to incinerate their enemies with burning talons and fangs.\",
                \"M\": \"5\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"2\",
                \"SV\": \"6+\",
                \"W\": \"5\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, TZEENTCH,  BRIMSTONE HORROR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"BH\",
                    \"opid\": \"BRIM\",
                    \"wepid\": \"F\",
                    \"wepseq\": 0,
                    \"wepname\": \"Fists\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"BH\",
                        \"opid\": \"BRIM\",
                        \"wepid\": \"F\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"2\",
                        \"BS\": \"5+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"BH\",
                    \"opid\": \"BRIM\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"TYR\",
                    \"killteamid\": \"BBRO24\",
                    \"fireteamid\": \"BBRO24\",
                    \"opid\": \"FAM\",
                    \"abilityid\": \"GA\",
                    \"title\": \"Group Activation\",
                    \"description\": \"Whenever this operative is expended, you must then activate any other ready friendly CHAOS DAEMON BRIMSTONE HORROR operative (if able) before your opponent activates.\\nWhen that other operative is expended, your opponent then activates as normal.\"
                  },
                  {
                    \"factionid\": \"TYR\",
                    \"killteamid\": \"BBRO24\",
                    \"fireteamid\": \"BBRO24\",
                    \"opid\": \"FAM\",
                    \"abilityid\": \"smol\",
                    \"title\": \"Small\",
                    \"description\": \"This operative cannot use any weapons that are not on its datacard, cannot use POWERS OF CHAOS, or perform unique actions.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"N/A\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"DFTR\",
                \"opseq\": 4,
                \"opname\": \"Daemonette Fighter\",
                \"description\": \"Daemonettes are seductive harbingers of torment. They advance in a swift surge, dancing with impossible agility to pounce upon their victims with keening screams of horrific desire. They indulge in inflicting wounds with their razor-sharp claws.\",
                \"M\": \"7\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"8\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, SLAANESH, DAEMONETTE, FIGHTER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DETTE\",
                    \"opid\": \"FTR\",
                    \"wepid\": \"CLS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Claws\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"DETTE\",
                        \"opid\": \"FTR\",
                        \"wepid\": \"CLS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
                        \"D\": \"4/5\",
                        \"SR\": \"Balanced\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"DETTE\",
                    \"opid\": \"FTR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. SLAANESH), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Slaanesh</h2><strong>Swift Retreat</strong><br/>\\nUse this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is fighting, after you strike with a critical success. End that sequence (any remaining attack dice are discarded) and immediately perform a free Dash or Fall\\nBack action up to 3\\\" with that operative (then the Fight action ends). That operative can do so even if it’s performed an action that prevents it from performing the Dash or Fall Back action.<br/><br/><strong>Unnatural Agility</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is fighting or retaliating, worsen the Hit stat of the enemy operative''s melee weapons by 1.<br/><br/><strong>Flurry of Blows</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is performing the Fight action and you select a Claws weapon. Until the end of that action, that weapon has the Relentless weapon rule.<br/><br/><strong>Weaving Dance</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative performs an action in which it moves. Until the end of the action, that operative:\\n<ul>\\n<li>Can ignore all vertical distances whenever it drops and climbs.</li>\\n<li>Can move through enemy operatives, move within control range of them, and during the Charge action can leave their control range (it must still end the move following all requirements for that move).</li>\\n<li>Cannot move more than its Move stat if it’s the Charge action.</li></ul><strong>Tormenting Strike</strong><br/>Use this POWER OF CHAOS when a friendly SLAANESH DAEMON operative is performing the Fight action and you select a Claws weapon. Until the end of that action, that weapon has the Piercing Crits 1 weapon rule.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Scout\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"DAEM24\",
                \"fireteamid\": \"DAEM24\",
                \"opid\": \"PFTR\",
                \"opseq\": 0,
                \"opname\": \"Plaguebearer Fighter\",
                \"description\": \"A Plaguebearer''s body is swollen and bursting with contagion. They shamble purposefully forward with dour inevitability, bringing the promise of corruption with them. Despite their appearance, they swing their disease-laden plagueswords with great strength.\",
                \"M\": \"5\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"5+\",
                \"W\": \"8\",
                \"keywords\": \"CHAOS DAEMON, CHAOS, DAEMON, NURGLE, PLAGUEBEARER, FIGHTER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"FTR\",
                    \"wepid\": \"PS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Plaguesword\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"DAEM24\",
                        \"fireteamid\": \"PB\",
                        \"opid\": \"FTR\",
                        \"wepid\": \"PS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
                        \"D\": \"4/6\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"FTR\",
                    \"abilityid\": \"DAEM24\",
                    \"title\": \"Daemon\",
                    \"description\": \"This operative ignores the Piercing weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DAEM24\",
                    \"fireteamid\": \"PB\",
                    \"opid\": \"FTR\",
                    \"abilityid\": \"DR\",
                    \"title\": \"Disgustingly Resilient\",
                    \"description\": \"Whenever an attack dice inflicts damage of 3 or more on a friendly NURGLE DAEMON operative, roll one D6: on a 4+, subtract 1 from that inflicted damage.\"
                  },
                  {
                    \"factionid\": \"AEL\",
                    \"killteamid\": \"BOK24\",
                    \"fireteamid\": \"BOK24\",
                    \"opid\": \"DAX\",
                    \"abilityid\": \"GOC\",
                    \"title\": \"Powers of Chaos\",
                    \"description\": \"<ul>\\n<li>You cannot use more than one POWER OF CHAOS per activation or counteraction.</li>\\n<li>You cannot use each POWER OF CHAOS more than once per turning point.</li>\\n<li>If every friendly CHAOS DAEMONS operative selected for deployment has the same Chaos God keyword (e.g. NURGLE), you cannot use each POWER OF CHAOS more than twice per turning point (instead of once).</li>\\n</ul>\\n<h2>Powers of Nurgle</h2><strong>Noxious Cloud</strong><br/>Use this POWER OF CHAOS during a friendly NURGLE DAEMON operative’s activation. Until the end of the turn, whenever an operative is shooting a friendly CHAOS DAEMON operative that is more than 3\\\" from it, if that friendly operative is wholly within 3\\\" of this operative, that friendly operative is obscured.<br/><br/><strong>Curse of Rot</strong><br/>Use this POWER OF CHAOS during a friendly NURGLE DAEMON operative’s activation. Select one enemy operative within 8\\\" and visible to this operative. Subtract 2\\\" from the Move stat of that enemy operative and worsen the Hit stat of its weapons by 1 (this is not cumulative with being injured) until the end of the turning point.<br/><br/><strong>Rancid Vomit</strong><br/>Use this POWER OF CHAOS when a friendly NURGLE DAEMON operative is performing the Shoot action. Until the end of that action, that operative can use the following ranged weapon:\\n<table width=\\\"100%\\\" class=\\\"eqtable\\\">\\n<tr>\\n<th>Name</th>\\n        <th>A</th>\\n        <th>BS</th>\\n        <th>D</th>\\n</tr>\\n    <tr>\\n<td>Rancid Vomit</td>\\n        <td>5</td>\\n        <td>2+</td>\\n        <td>2/3</td>\\n</tr>\\n    <tr><th colspan=\\\"4\\\">Special Rules</th></tr>\\n    <tr><td colspan=\\\"4\\\">Rng 6\\\", Tor 1\\\", Saturate</td></tr>\\n</table><br/><br/><strong>Shambling Wretch</strong><br/>Use this POWER OF CHAOS at the start of a friendly NURGLE DAEMON operative''s activation. You can ignore any changes to the stats of that operative from being injured (including their weapons'' stats) until the end of that activation.<br/><br/><strong>Revolting Resiliency</strong><br/>Use this POWER OF CHAOS when an attack dice inflicts damage on a friendly NURGLE DAEMON operative. Until the end of the activation/counteraction, for the purposes of the Disgustingly Resilient rule for that operative, always subtract 1 from the damage inflicted (to a minimum of 2) – you do not need to roll.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch\"
              }
            ],
            \"fireteamcomp\": \"A BLOOTLETTER fire team includes six BLOODLETTER operatives selected from the following list:\\n<ul>\\n<li>BLOODLETTER FIGHTER</li>\\n<li>BLOODLETTER ICON BEARER</li>\\n<li>BLOODLETTER HORN BEARER</li>\\n</ul>\\nOther than BLOODLETTER FIGHTER operatives, your kill team can only include each operative above once.\\n<br/>\\nIf your kill team does not include any other LEADER operatives, instead of selecting one BLOODLETTER FIGHTER operative for one BLOODLETTER fire team, you can select one BLOODREAPER operative.\"
          }
        ],
        \"tacops\": [
          {
            \"tacopid\": \"ZZZ-INF-01\",
            \"archetype\": \"Infiltration\",
            \"tacopseq\": 1,
            \"title\": \"Implant\",
            \"description\": \"<em>TACOP</em><br/>\\r <strong>Reveal: </strong> When you first score VP from this op.<br/><br/>\\r <strong>Additional Rules:</strong><br/>\\r Whenever a friendly operative is fighting, when you would resolve an attack dice, you can implant the enemy operative instead of striking or blocking (then discard that dice).<br/>\\r Whenever a friendly operative is shooting an enemy operative within 6\\\" of it, when you would resolve an attack dice, you can instead implant the enemy operative instead of inflicting damage with that dice.<br/>\\r Each operative can only be implanted once, and cannot be implanted during the first turning point.<br/><br/>\\r <strong>Victory Points:</strong><br/>\\r Once per turning point after the first, if you implant an enemy operative, you score 1VP.<br/>\\r At the end of each turning point after the first, if any implanted enemy operatives are in the killzone, you score 1 VP.\",
            \"edition\": \"kt24\"
          },
          {
            \"tacopid\": \"ZZZ-INF-02\",
            \"archetype\": \"Infiltration\",
            \"tacopseq\": 2,
            \"title\": \"Surveillance\",
            \"description\": \"<em>TACOP</em><br/>\\r <strong>Reveal: </strong> The first time a friendly operative performs the Surveillance Action.<br/><br/>\\r <strong>Mission Action: Surveillance (1 AP)</strong><br/>\\r The active operative has gathered surveillance.\\r <ul>\\r <li>An operative cannot perform this action while it has an Engage order. It must be wholly within your opponent''s territory to perform this action, and there must be an enemy operative that is a valid target for it.</li>\\r <li>An operative cannot perform this action during the first turning point, or while within control range of an enemy operative.</li>\\r </ul><br/>\\r <strong>Victory Points:</strong><br/>\\r Once per turning point after the first, if a friendly operative performs the Surveillance action, you score 1 VP.<br/>\\r At the end of each turning point after the first, if a friendly operative has performed the Surveillance action during that turning point is in the killzone and has a conceal order, you score 1 VP\",
            \"edition\": \"kt24\"
          },
          {
            \"tacopid\": \"ZZZ-INF-03\",
            \"archetype\": \"Infiltration\",
            \"tacopseq\": 3,
            \"title\": \"Wiretap\",
            \"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal: </strong> The first time a friendly operative performs the Wiretap Action.<br/><br/>\\n<strong>Mission Action: Wiretap (1 AP)</strong><br/>\\nPlace one of your Wiretap mission markers within the active operative''s control range.\\nIn the ready step of the next Strategy phase, remove that marker.<br/>\\nAn operative cannot perform this action during the first turning point, while within control range of an enemy operative, during an activation in which it was set up, or if a friendly operative has already performed this\\naction during the turning point.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per tuning point after the first, whenever an enemy operative starts or ends an action within 2\\\" of your Wiretap mission marker, you score 1 VP.<br/>\\nAt the end of each turning point after the first, if any enemy operatives with an Engage order are within 2\\\" of your Wiretap mission marker, you score 1 VP.\",
            \"edition\": \"kt24\"
          },
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
        echo "#Importing team " . $killteam->killteamname . "\r\n\r\n";
        echo "INSERT INTO Killteam VALUES ('HBR', '$killteam->killteamid', 'kt24', '$killteam->killteamname', '$killteam->description', '$killteam->killteamcomp', '$killteam->customkeyword');\r\n\r\n";

        // Import the fireteams
        for ($ftidx = 0; $ftidx < count($killteam->fireteams); $ftidx++) {
          $fireteam = $killteam->fireteams[$ftidx];
          echo "INSERT INTO Fireteam VALUES ('$fireteam->factionid', '$fireteam->killteamid', '$fireteam->fireteamid', 0, '$fireteam->description', 0, '$fireteam->fireteamname', '$fireteam->archetype', '$fireteam->fireteamcomp');\r\n\r\n";

          // Import the operatives
          for ($opidx = 0; $opidx < count($fireteam->operatives); $opidx++) {
            $op =  $fireteam->operatives[$opidx];
            echo "INSERT INTO Operative VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opseq', '$op->opid', '$op->opname', '$op->description', 'kt24', '$op->M', '$op->APL', '$op->GA', '$op->DF', '$op->SV', '$op->W', '$op->keywords', 0, '$op->fireteammax', '$op->specialisms');\r\n\r\n";

            // Import the weapons
            for ($wepidx = 0; $wepidx < count($op->weapons); $wepidx++) {
              $wep = $op->weapons[$wepidx];

              echo "INSERT INTO Weapon VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$wep->wepid', '$wep->wepseq', '$wep->wepname', '$wep->weptype', $wep->isdefault);\r\n\r\n";

              for ($wpidx = 0; $wpidx < count($wep->profiles); $wpidx++) {
                $wp = $wep->profiles[$wpidx];
                echo "INSERT INTO WeaponProfile VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$wp->wepid', '$wp->profileid', '$wp->name', '$wp->A', '$wp->BS', '$wp->D', '$wp->SR');\r\n\r\n";
              }
            }

            // Import the abilities
            for ($abidx = 0; $abidx < count($op->abilities); $abidx++) {
              $ab = $op->abilities[$abidx];
              echo "INSERT INTO Ability VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ab->abilityid', '$ab->title', '$ab->description');\r\n\r\n";
            }

            // Import the UniqueActions
            for ($uaidx = 0; $uaidx < count($op->uniqueactions); $uaidx++) {
              $ua = $op->uniqueactions[$uaidx];
              echo "INSERT INTO UniqueAction VALUES ('HBR', '$killteam->killteamid', '$fireteam->fireteamid', '$op->opid', '$ua->uniqueactionid', '$ua->title', '$ua->AP', '$ua->description');\r\n\r\n";
            }
          }
        }

        // Import the Ploys
        $sploys = $killteam->ploys->strat;
        $tploys = $killteam->ploys->tac;

        for ($pidx = 0; $pidx < count($sploys); $pidx++) {
          $ploy = $sploys[$pidx];
          echo "INSERT INTO Ploy VALUES ('HBR', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');\r\n\r\n";
        }
        
        for ($pidx = 0; $pidx < count($tploys); $pidx++) {
          $ploy = $tploys[$pidx];
          echo "INSERT INTO Ploy VALUES ('HBR', '$killteam->killteamid', '$ploy->ploytype', '$ploy->ployid', '$ploy->ployname', '$ploy->CP', '$ploy->description');\r\n\r\n";
        }

        // Import the Equipments
        for ($eqidx = 0; $eqidx < count($killteam->equipments); $eqidx++) {
          $eq = $killteam->equipments[$eqidx];
          if ($eq->killteamid != 'ALL') {
            echo "INSERT INTO Equipment VALUES ('HBR', '$killteam->killteamid', '$eq->fireteamid', '$eq->opdi', '$eq->eqid', '$eq->eqseq', '$eq->eqpts', '$eq->eqname', '$eq->eqdescription', '$eq->eqtype', '$eq->eqvar1', '$eq->eqvar2', '$eq->eqvar3', '$eq->eqvar4', '$eq->eqcategory');\r\n\r\n";
          }
        }

      ?>
	</body>
</html>


	