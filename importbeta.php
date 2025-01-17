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
        \"killteamid\": \"TOE24\",
        \"edition\": \"kt24\",
        \"killteamname\": \"Talons of the Emperor\",
        \"description\": \"The Adeptus Custodes, known as the Legio Custodes during the Great Crusade and Horus Heresy eras, is the Imperial adepta responsible for protecting the Imperial Palace and the physical body of the Emperor of Mankind, as well as serving as His most important emissaries, His companions, and the keepers of His many secrets. \\n<br/><br/>\\nThe Sisters of Silence are an all-female order of Imperial Witch Hunters tasked with hunting down rogue psykers and other psychic threats across the galaxy. They also help to enforce the Imperium''s rigid laws on the use of psychic powers. \",
        \"customkeyword\": \"\",
        \"ploys\": {
          \"strat\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"AOTE\",
              \"ployname\": \"Aegis Of The Emperor\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, each time Critical\\nDamage would be inflicted upon a friendly TALONS OF THE\\nEMPEROR operative from an attack die, you can choose for\\nthat attack die to inflict Normal Damage instead.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"CD\",
              \"ployname\": \"Creeping Dread\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, while an enemy operative\\nis within 3\\\" of a friendly ANATHEMA PSYKANA operative,\\nworsen the Ballistic Skill and Weapon Skill characteristics of\\nranged and melee weapons respectively that enemy operative\\nis equipped with as if it were injured.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"VE\",
              \"ployname\": \"Vigilance Eternal\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, whenever determining control of a marker, treat ADEPTUS CUSTODES operative’s APL stat as 1 higher.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"ATSKNF\",
              \"ployname\": \"Unwavering Sentinels\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"You can ignore any changes to the stats of friendly TALONS OF THE EMPEROR operatives from being injured (including their weapons'' stats).\"
            }
          ],
          \"tac\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"AGA\",
              \"ployname\": \"Arcane Genetic Alchemy\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this firefight ploy when an operative is shooting a friendly TALONS OF THE EMPEROR operative, in the Roll Defence Dice step.\\nYou can retain one of your normal successes as a critical success instead.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"BODG\",
              \"ployname\": \"Brotherhood Of Demigods\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this firefight ploy when a friendly TALONS OF THE EMPEROR operative is counteracting. It can perform an additional 1AP action for free during that counteraction, but both actions must be different.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"T\",
              \"ployname\": \"Talons Interlocked\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy when a ready friendly TALONS OF THE\\nEMPEROR operative is activated:\\n<ul>\\n<li>If that operative is an ANATHEMA PSYKANA operative,\\nselect one ready friendly ADEPTUS CUSTODES operative\\nVisible to and within 3\\\" of it.</li>\\n<li>If that operative is an ADEPTUS CUSTODES operative,\\nselect one ready friendly ANATHEMA PSYKANA operative\\nVisible to and within 3\\\" of it</li>\\n</ul>\\nBoth operatives are activated at the same time and you can\\nperform their actions in any order.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"TOE24\",
              \"ployid\": \"T\",
              \"ployname\": \"Avenge the Fallen\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this firefight ploy when a friendly TALONS OF THE EMPEROR operative is incapacitated by an enemy operative. Until the end of the battle, whenever another friendly TALONS OF THE EMPEROR operative is shooting against, fighting against or retaliating against that enemy operative, that other friendly operative’s weapons have the Balanced weapon rule. You cannot use this ploy again during the battle until that enemy operative is incapacitated.\"
            }
          ]
        },
        \"equipments\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"TOE24\",
            \"eqid\": \"MC\",
            \"eqname\": \"Misericordias\",
            \"eqdescription\": \"Each time after a friendly ADEPTUS CUSTODES operative fights in\\ncombat, you can use this ability. If you do so, roll one D6: on a\\n3+, the enemy operative that fought it in that combat suffers\\n2 mortal wounds.\",
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
            \"killteamid\": \"TOE24\",
            \"eqid\": \"OP\",
            \"eqname\": \"Oath Parchments\",
            \"eqdescription\": \"Once per turning point, when a friendly TALONS OF THE EMPEROR operative is shooting, fighting or retaliating, if you roll two or more fails, you can discard one of them to retain another as a normal success instead.\",
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
            \"killteamid\": \"TOE24\",
            \"eqid\": \"TFG\",
            \"eqname\": \"Tanglefoot Grenades\",
            \"eqdescription\": \"Twice per battle in the firefight phase, an TALONS OF THE EMPEROR operative can\\nperform the following action:<br/>\\n<strong>Tanglefoot Grenade (1 AP):</strong> Select one enemy operative\\nVisible to this operative. Subtract 2\\\" from its Movement characteristic until the end of the turning point. This operative can \\ncan not perform this action while within Engagement Range of\\nenemy operatives.\",
            \"eqpts\": \"3\",
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
            \"killteamid\": \"TOE24\",
            \"eqid\": \"VFP\",
            \"eqname\": \"Vratine Faceplates\",
            \"eqdescription\": \"Once per turning point, when an operative is shooting a friendly ANATHEMA PSYKANA operative, in the roll defence dice step, you can retain one of your normal successes as a critical success instead.\",
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
        \"killteamcomp\": \"A TALONS OF THE EMPEROR kill team consists of 10 operatives selected from the following list:\\n<ul>\\n <li>CUSTODIAN GUARD LEADER (counts as two selections) operative equipped with one of the following options:\\n<ul>\\n<li>Guardian spear</li>\\n<li>Sentinel blade; storm shield</li></ul><li>CUSTODIAN GUARD WARRIOR (counts as two selections) operatives each separately equipped with one of the following options:\\n<ul>\\n<li>Guardian spear</li>\\n<li>Sentinel blade; storm shield</li>\\n</ul></li> <li>SISTER OF SILENCE SUPERIOR operative\\nequipped with one of the following options:\\n<ul>\\n<li>Boltgun; gun butt</li>\\n<li>Flamer; gun butt</li>\\n<li>Executioner greatblade</li></ul> <li>SISTER OF SILENCE PROSECUTOR</li>\\n<li>SISTER OF SILENCE WITCHSEEKER</li>\\n<li>SISTER OF SILENCE VIGILATOR</li>\\n</ul>\\nYour kill team can only include up to one CUSTODIAN GUARD LEADER and up to one SISTER OF SILENCE SUPERIOR.\",
        \"fireteams\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"TOE24\",
            \"fireteamid\": \"TOE24\",
            \"seq\": 0,
            \"fireteamname\": \"Custodian Guard\",
            \"archetype\": \"Seek And Destroy/Security\",
            \"description\": \"\",
            \"killteammax\": 0,
            \"operatives\": [
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"LDR\",
                \"opseq\": 0,
                \"opname\": \"Custodian Guard Leader\",
                \"description\": \"Some Custodians inevitably rise to prominence, exemplifying their companions'' traits of supreme martial prowess, keen intellect, and scrutinizing minds. They carry artificer-crafted, powered blades that are capable of cleaving traitor Space Marines in two.\",
                \"M\": \"6\\\"\",
                \"APL\": \"3\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"2+\",
                \"W\": \"16\",
                \"keywords\": \"TALONS OF THE EMPEROR, IMPERIUM, ADEPTUS CUSTODES, CUSTODIAN GUARD, LEADER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"LDR\",
                    \"wepid\": \"GS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Guardian Spear\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"LDR\",
                        \"wepid\": \"GS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/5\",
                        \"SR\": \"PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"LDR\",
                    \"wepid\": \"SB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Sentinel Blade\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"LDR\",
                        \"wepid\": \"SB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/4\",
                        \"SR\": \"Rng 6\\\", PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"LDR\",
                    \"wepid\": \"GSM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Guardian Spear\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"LDR\",
                        \"wepid\": \"GSM\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"5/7\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"LDR\",
                    \"wepid\": \"SBM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Sentinel Blade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"LDR\",
                        \"wepid\": \"SBM\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"4/6\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"LDR\",
                    \"wepid\": \"SS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Storm Shield\",
                    \"weptype\": \"E\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"LDR\",
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
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"PHO24\",
                    \"fireteamid\": \"PHO24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"AS\",
                    \"title\": \"The Emperor''s Chosen\",
                    \"description\": \"During each friendly ADEPTUS CUSTODES operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it is two Shoot actions, a bolt weapon must be selected for at least one of them.\\nA bolt weapon is any ranged weapon that includes ''bolt'' in its name, e.g. marksman bolt carbine, special issue bolt pistol, etc.<br/>\\nEach friendly ADEPTUS CUSTODES operative can counteract regardless of its order.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"PHO24\",
                    \"fireteamid\": \"PHO24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"AS\",
                    \"title\": \"Shield of Honor\",
                    \"description\": \"Once per turning point when a friendly TALONS OF THE EMPEROR operative is selected as the valid target of a Shoot action or to be fought against during the Fight action you may use this ability. If that operative is visible to and within 3\\\" of this operative, this operative becomes the valid target or to be fought against (as appropriate) instead even if it normally\\nwould not be valid for this.\\nIf it is the Fight action, treat this operative as being within the fighting operative''s control range for the duration of that action.<br/>\\nThis ploy has no effect if it is the Shoot action and the ranged weapon has the Blast or Torrent weapon rule.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SGT\",
                    \"abilityid\": \"SS\",
                    \"title\": \"*Storm Shield\",
                    \"description\": \"If this operative is equipped with a Storm Shield, it ignores the Piercing weapon rule. Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent''s successful hits are discarded (instead of one).\"
                  }
                ],
                \"edition\": \"kt24\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Staunch,Marksman,Scout\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"WAR\",
                \"opseq\": 0,
                \"opname\": \"Custodian Guard Warrior\",
                \"description\": \"Custodian Guard are steadfast in defence and unstoppable on the attack, working ceaselessly to defend the Emperor''s realm. Created through arcane gene-tech, each of them have a fragment of the Emperor''s might flowing through their veins.\",
                \"M\": \"6\\\"\",
                \"APL\": \"3\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"2+\",
                \"W\": \"15\",
                \"keywords\": \"TALONS OF THE EMPEROR, IMPERIUM, ADEPTUS CUSTODES, CUSTODIAN GUARD, WARRIOR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"GS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Guardian Spear\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"GS\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/5\",
                        \"SR\": \"PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"SB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Sentinel Blade\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"SB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/4\",
                        \"SR\": \"Rng 6\\\", PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"GSM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Guardian Spear\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"GSM\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"5/7\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"SBM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Sentinel Blade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"SBM\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"4/6\",
                        \"SR\": \"Lethal 5+\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"SS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Storm Shield\",
                    \"weptype\": \"E\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WAR\",
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
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"PHO24\",
                    \"fireteamid\": \"PHO24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"AS\",
                    \"title\": \"The Emperor''s Chosen\",
                    \"description\": \"During each friendly ADEPTUS CUSTODES operative''s activation, it can perform either two Shoot actions or two Fight actions.\\nIf it is two Shoot actions, a bolt weapon must be selected for at least one of them.\\nA bolt weapon is any ranged weapon that includes ''bolt'' in its name, e.g. marksman bolt carbine, special issue bolt pistol, etc.<br/>\\nEach friendly ADEPTUS CUSTODES operative can counteract regardless of its order.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SGT\",
                    \"abilityid\": \"SS\",
                    \"title\": \"*Storm Shield\",
                    \"description\": \"If this operative is equipped with a Storm Shield, it ignores the Piercing weapon rule. Each time it fights in combat, in the Resolve Successful Hits step of that combat, each time it parries, two of your opponent''s successful hits are discarded (instead of one).\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Staunch,Marksman,Scout\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"SUP\",
                \"opseq\": 0,
                \"opname\": \"Sister Of Silence Superior\",
                \"description\": \"Once fully trained, a Sister of Silence takes the Oath of Tranquility, vowing never to utter a word, and communicates instead via  a secretive sign language. Sisters Superior are experts in their Battlemark form, coordinating their team''s assault in unnerving silence.\",
                \"M\": \"6\\\"\",
                \"APL\": \"3\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"9\",
                \"keywords\": \"TALONS OFTHE EMPEROR, IMPERIUM, ANATHEMA PSYKANA, LEADER, SISTER OF SILENCE, SUPERIOR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"BG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"BG\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/4\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"FL\",
                    \"wepseq\": 0,
                    \"wepname\": \"Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"FL\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
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
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"EGB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Executioner Greatblade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"EGB\",
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
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": false
                  }
                ],
                \"uniqueactions\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"uniqueactionid\": \"GID\",
                    \"title\": \"Adaptive Training\",
                    \"description\": \"<strong>SUPPORT</strong> Select one other friendly ANATHEMA PSYKANA operative visible to and within 6\\\" of this operative.\\nUntil the end of that operative''s next activation add 1 to its APL stat.<br/>\\nThis operative cannot perform this action while within control range of an enemy operative.\",
                    \"AP\": 1
                  }
                ],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"SUP\",
                    \"abilityid\": \"PA\",
                    \"title\": \"Psychic Abomination\",
                    \"description\": \"Psychic Abomination: While an operative is within 6\\\" of an\\nANATHEMA PSYKANA operative, it cannot perform psychic\\nactions. SISTER OF SILENCE operatives cannot be targeted or\\naffected by psychic actions.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Staunch\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"PRO\",
                \"opseq\": 0,
                \"opname\": \"Sister Of Silence Prosecutor\",
                \"description\": \"Among the psychic nulls who make up the Sisters of Silence, Prosecutors form the core of their sinister cadres. Lethal in both attack and defence, Prosecutors cut down congregations of mutant sorcerers and rogue psykers with salvoes from their Umbra-pattern boltguns.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"TALONS OF THE EMPEROR, IMPERIUM, ANATHEMA PSYKANA, SISTER OF SILENCE, PROSECUTOR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"PRO\",
                    \"wepid\": \"BG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"PRO\",
                        \"wepid\": \"BG\",
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
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"PRO\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"PRO\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
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
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"PRO\",
                    \"abilityid\": \"PA\",
                    \"title\": \"Psychic Abomination\",
                    \"description\": \"Psychic Abomination: While an operative is within 6\\\" of an\\nANATHEMA PSYKANA operative, it cannot perform psychic\\nactions. SISTER OF SILENCE operatives cannot be targeted or\\naffected by psychic actions.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman,Scout\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"VIG\",
                \"opseq\": 0,
                \"opname\": \"Sister Of Silence Vigilator\",
                \"description\": \"Vigilators capitalise on their innate gifts, assaulting their prey when the effects of their soulless aura are at their most potent. They train tirelessly with enormous Greatblades in an ancient form of combat, laying open their victims'' guard before landing a decapitating blow.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"TALONS OF THE EMPEROR, IMPERIUM, ANATHEMA PSYKANA, SISTER OF SILENCE, VIGILATOR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"VIG\",
                    \"wepid\": \"EGB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Executioner Greatblade\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"VIG\",
                        \"wepid\": \"EGB\",
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
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"VIG\",
                    \"abilityid\": \"PA\",
                    \"title\": \"Psychic Abomination\",
                    \"description\": \"Psychic Abomination: While an operative is within 6\\\" of an\\nANATHEMA PSYKANA operative, it cannot perform psychic\\nactions. SISTER OF SILENCE operatives cannot be targeted or\\naffected by psychic actions.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Combat,Staunch\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"TOE24\",
                \"fireteamid\": \"TOE24\",
                \"opid\": \"WSK\",
                \"opseq\": 0,
                \"opname\": \"Sister Of Silence Witchseeker\",
                \"description\": \"Like all of their kind, Witchseekers bear the rare Pariah gene. They have no presence in the Warp and exude an intense aura that causes psykers pain and horror. Once Witchseekers corner their psychic quarry, they purify their taint with blazing infernos of fire.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"TALONS OF THE EMPEROR, IMPERIUM, ANATHEMA PSYKANA, SISTER OF SILENCE, WITCHSEEKER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WSK\",
                    \"wepid\": \"FL\",
                    \"wepseq\": 0,
                    \"wepname\": \"Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WSK\",
                        \"wepid\": \"FL\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"2/2\",
                        \"SR\": \"Rng 6\\\", Tor 2\\\", Sat\"
                      }
                    ],
                    \"isselected\": true
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WSK\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"TOE24\",
                        \"fireteamid\": \"TOE24\",
                        \"opid\": \"WSK\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"\",
                        \"A\": \"4\",
                        \"BS\": \"3+\",
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
                    \"killteamid\": \"DW24\",
                    \"fireteamid\": \"DW24\",
                    \"opid\": \"WM\",
                    \"abilityid\": \"MT\",
                    \"title\": \"Martial Ka’Tah\",
                    \"description\": \"As a STRATEGIC GAMBIT in each turning point, choose a Martial Ka’Tah from those presented below. All friendly TALONS OF THE EMPEROR operatives gain the selected benefit.<br/>\\n<ul>\\n<li><strong>Dacatarai Stance:</strong> After fighting or retaliating, if a friendly operative is no longer within control range of an enemy operative they can perform a free charge up to 3\\\".</li>\\n<li><strong>Kaptaris Stance:</strong> Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. </li>\\n<li><strong>Rendax Stance:</strong> Until the end of the turning point all melee weapons gain the Severe special Rule.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"TOE24\",
                    \"fireteamid\": \"TOE24\",
                    \"opid\": \"WSK\",
                    \"abilityid\": \"PA\",
                    \"title\": \"Psychic Abomination\",
                    \"description\": \"Psychic Abomination: While an operative is within 6\\\" of an\\nANATHEMA PSYKANA operative, it cannot perform psychic\\nactions. SISTER OF SILENCE operatives cannot be targeted or\\naffected by psychic actions.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Marksman,Scout\"
              }
            ],
            \"fireteamcomp\": \"A CUSTODIAN GUARD fire team includes two CUSTODIAN GUARD WARRIOR operatives each separately equipped with one of the following options:\\n<ul>\\n<li>Guardian spear</li>\\n<li>Sentinel blade; storm shield</li>\\n</ul>\\n<br/>\\nIf your kill team does not include any other LEADER operatives, instead of selecting one CUSTODIAN GUARD WARRIOR operative for one CUSTODIAN GUARD fire team, you can select one CUSTODIAN GUARD LEADER operative equipped with one of the following options:\\n<ul>\\n<li>Guardian spear</li>\\n<li>Sentinel blade; storm shield</li>\\n</ul>\"
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
          },
          {
            \"tacopid\": \"ZZZ-REC-01\",
            \"archetype\": \"Recon\",
            \"tacopseq\": 1,
            \"title\": \"Confirm Kill\",
            \"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal: </strong>The first time an enemy operative is incapacitated.<br/><br/>\\n<strong>Additional Rules:</strong><br/>\\nWhenever an enemy operative is incapacitated, before it is removed from the killzone, place one of your Confirm Kill mission markers within its control range.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of each turning point after the first, if a friendly operative controls one of your Confirm Kill mission markers, that marker is not contested by enemy operatives and no enemy operatives are that are\\nwithin that friendly operative''s control range, you can remove that marker to score 1VP, or 2VP if it was placed for an enemy operative with a wounds stat of 12 or more.<br/>\\nYou can score a maximum of 2 VP from this op per turning point.\",
            \"edition\": \"kt24\"
          },
          {
            \"tacopid\": \"ZZZ-REC-02\",
            \"archetype\": \"Recon\",
            \"tacopseq\": 2,
            \"title\": \"Recover Items\",
            \"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal: </strong>At the start of the Set Up operatives step, before equipment is set up.<br/><br/>\\n<strong>Additional Rules:</strong><br/>\\nWhen revealed, your opponent places one of your Item mission markers on the centreline and one within 2\\\" of your territory.\\nYou then place one more than 6\\\" from your territory. In all cases, your Item mission markers must be 2\\\" from other markers (including other item mission markers).\\nYour operatives can perform the Pick Up Marker action on your Item mission markers after the first turning point.<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nAt the end of the fourth turning point, for each of your Item mission markers that both the Pick Up Marker action has been performed\\nupon and friendly operatives control, you score 2VP. Note that it is not a requirement to be carrying those markers, but each of them\\nmust have been carried by friendly operatives at some point during the battle.\",
            \"edition\": \"kt24\"
          },
          {
            \"tacopid\": \"ZZZ-REC-03\",
            \"archetype\": \"Recon\",
            \"tacopseq\": 3,
            \"title\": \"Plant Beacon\",
            \"description\": \"<em>TACOP</em><br/>\\n<strong>Reveal: </strong>The first time a friendly operative performs the Plant Beacon action.<br/><br/>\\n<strong>Mission Action: Plant Beacon (1 AP)</strong><br/>\\nPlace one of your Beacon mission markers:\\n<ul>\\n<li>Within the active operative''s control range</li>\\n<li>More than 4\\\" from your drop zone</li>\\n<li>More than 6\\\" from your other Beacon mission markers</li>\\n<li>With no part of it underneath Vantage terrain.</li>\\n</ul>\\nAn operative cannot perform this action during the first turning point, or while within control range of an enemy operative, or during an activation in which it was set up.\\n<br/><br/>\\n<strong>Victory Points:</strong><br/>\\nOnce per turning point after the first, whenever one of your Beacon mission markers is placed wholly within your territory, you score 1VP.<br/>\\nOnce per turning point after the first, whenever one of your Beacon mission markers is placed wholly within your opponent''s territory, you score 1VP.\",
            \"edition\": \"kt24\"
          },
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


	