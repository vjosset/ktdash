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
        \"killteamid\": \"ECC24\",
        \"edition\": \"kt24\",
        \"killteamname\": \"Ecclesiarchy\",
        \"description\": \"The Adepta Sororitas, colloquially called the \\\"Sisterhood,\\\" whose military arm is also known as the Sisters of Battle and formerly as the Daughters of the Emperor, are an all-female division of the Imperium of Man''s state church known as the Ecclesiarchy or, more formally, as the Adeptus Ministorum.\\n<br/><br/>\\n   The Sisterhood''s Orders Militant serve as the Ecclesiarchy''s armed forces, mercilessly rooting out spiritual corruption and heresy within Humanity and every organisation of the Adeptus Terra.\",
        \"customkeyword\": \"\",
        \"ploys\": {
          \"strat\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"DS\",
              \"ployname\": \"Divine Shield\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, each time a shooting attack is made against a friendly ECCLESIARCHY operative, in the Roll Defence Dice step of that shooting attack, if you retain any critical saves, you can re-roll one of your failed saves.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"EG\",
              \"ployname\": \"Emperor''s Guidance\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, each time a friendly ECCLESIARCHY operative fights in combat or makes a shooting attack, in the Roll Attack Dice step of that combat or shooting attack, if you retain any critical hits, you can re-roll one of your attack dice.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"ETW\",
              \"ployname\": \"Extremis Trigger Word\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point: <ul><li>Each time a friendly ECCLESIARCHY operative performs a Dash or Charge action, it can move an additional 1\\\" for that action.</li><li>Melee weapons that friendly ECCLESIARCHY operatives are equipped with gain the Lethal 5+ special rule.</li></ul>You can only use this Strategic Ploy once per game.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"EG\",
              \"ployname\": \"Vengeance of the Martyred\",
              \"ploytype\": \"S\",
              \"CP\": \"1\",
              \"description\": \"Until the end of the Turning Point, each time a friendly ECCLESIARCHY operative is granted a Martyr Point, one enemy operative within 6\\\" suffers 1 damage.\"
            }
          ],
          \"tac\": [
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"DI\",
              \"ployname\": \"Divine Intervention\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy in the Resolve Successful Hits step of a combat or shooting attack, when an attack die would inflict damage on a friendly ECCLESIARCHY operative. Ignore the damage inflicted from that attack die.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"PTD\",
              \"ployname\": \"Rightous Fury\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \" Use this Firefight Ploy when a friendly ECCLESIARCHY operative is activated. Until the end of that operative’s activation, it can perform two Shoot actions during that activation if a boltgun, bolt pistol, or storm bolter weapon is selected for each of those shooting attacks. If it does not perform any Shoot actions, it can instead perform two Fight actions.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"PTD\",
              \"ployname\": \"Penance Through Death\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy when a friendly ECCLESIARCHY operative is incapacitated in combat by an enemy operative. Before that friendly operative is removed from the killzone, you can strike with one of your remaining attack dice before it’s removed from the killzone.\"
            },
            {
              \"factionid\": \"HBR\",
              \"killteamid\": \"ECC24\",
              \"ployid\": \"SOR\",
              \"ployname\": \"Storm Of Retribution\",
              \"ploytype\": \"T\",
              \"CP\": \"1\",
              \"description\": \"Use this Firefight Ploy when a friendly ECCLESIARCHY operative is activated. Until the end of that operative''s activation, ranged weapons it is equipped with lose the Heavy special rule and gain the Saturate special rule.\"
            }
          ]
        },
        \"equipments\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"ECC24\",
            \"eqid\": \"POR\",
            \"eqname\": \"Phial Of Restoration\",
            \"eqdescription\": \"Once per battle, whenever a friendly ECCLESIARCHY operative, it can use this ability. If it does so, it regains 2D3 lost wounds.\",
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
            \"killteamid\": \"ECC24\",
            \"eqid\": \"PS\",
            \"eqname\": \"Purity Seals\",
            \"eqdescription\": \"Once per turning point, when a friendly ECCLESIARCHY operative is shooting, fighting or retaliating, if you roll two or more fails, you can discard one of them to retain another as a normal success instead.\",
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
            \"killteamid\": \"ECC24\",
            \"eqid\": \"RS\",
            \"eqname\": \"Sanctified Bolts\",
            \"eqdescription\": \"Once per turning point, whenever a friendly ECCLESIARCHY operative is performing the shoot action and you select a boltgun or bolt pistol, you can use this rule. Until the end of that action, add 1 to both its damage stats.\",
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
            \"killteamid\": \"ECC24\",
            \"eqid\": \"SB\",
            \"eqname\": \"Servo-Cherub\",
            \"eqdescription\": \"Once per turning point, whenever a friendly ECCLESIARCHY operative is performing the Pick Up or Put Down Marker or Open Hatch action, you can perform the action for 1 less AP (to a minimum of 0 AP).\",
            \"eqpts\": \"2\",
            \"eqtype\": \"Ability\",
            \"eqvar1\": \"\",
            \"eqvar2\": \"\",
            \"eqvar3\": \"\",
            \"eqvar4\": \"\",
            \"eqcategory\": \"Equipment\",
            \"fireteamid\": \"ECC24\",
            \"opid\": \"REP\",
            \"eqseq\": 0
          }
        ],
        \"killteamcomp\": \"An ECCLESIARCHY kill team consists of 10 operatives selected from the following list:\\n  <ul>\\n <li>BATTLE SISTER SUPERIOR operative equipped with one option from each of the following:\\n  <ul>\\n  <li>Chainsword, Gun Butt, Power Maul, or Power Weapon</li>\\n  <li>Bolt Pistol, Boltgun, Combi-Melta, Combi-Plasma, Condemnor Boltgun, Inferno Pistol, Ministorum Combi-Flamer, Ministorum Hand Flamer, or Plasma Pistol</li>\\n  </ul></li><li>REPENTIA SUPERIOR</li> \\n  \\n  <li>\\n  BATTLE SISTER GUNNER each separately equipped with Gun Butt and one of the following options:\\n  <ul>\\n  <li>Meltagun, Ministorum Flamer, or Storm Bolter</li>\\n  </ul>\\n  </li>\\n  <li>\\n  BATTLE SISTER HEAVY GUNNER each separately equipped with Gun Butt and one of the following options:\\n  <ul>\\n  <li>Heavy Bolter or Ministorum Heavy Flamer</li>\\n  </ul>\\n  </li><li>BATTLE SISTER ICON BEARER</li><li>BATTLE SISTER WARRIOR</li> <li>SISTER REPENTIA</li> </ul>Your kill team can include up to two BATTLE SISTER GUNNER operatives. Your kill team can only include up to one BATTLE SISTER HEAVY GUNNER operative. Your kill team can only include up to one BATTLE SISTER ICON BEARER. Your kill team must include one or both of a REPENTIA SUPERIOR or BATTLE SISTER SUPERIOR.<br/>\",
        \"fireteams\": [
          {
            \"factionid\": \"HBR\",
            \"killteamid\": \"ECC24\",
            \"fireteamid\": \"ECC24\",
            \"seq\": 0,
            \"fireteamname\": \"Battle Sisters\",
            \"archetype\": \"Security\",
            \"description\": null,
            \"killteammax\": 0,
            \"operatives\": [
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"SUP\",
                \"opseq\": 1,
                \"opname\": \"Battle Sister Superior\",
                \"description\": \"The Sisters Superior form the crux of each squad of Battle Sisters. They speak with an authority derived from years of combat and supreme faith in the God-Emperor.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"9\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, BATTLE SISTER, LEADER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"BP\",
                    \"wepseq\": 0,
                    \"wepname\": \"Bolt Pistol\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"BP\",
                        \"profileid\": \"0\",
                        \"name\": \"Bolt Pistol\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/4\",
                        \"SR\": \"Rng 6\\\"\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"BG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"BG\",
                        \"profileid\": \"0\",
                        \"name\": \"Boltgun\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"CM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Combi-Melta\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"CM\",
                        \"profileid\": \"0\",
                        \"name\": \"Melta\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"6/3\",
                        \"SR\": \"Combi-Boltgun, Rng 6\\\", Prc2, Lim, Dev4\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"CP\",
                    \"wepseq\": 0,
                    \"wepname\": \"Combi-Plasma\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"CP\",
                        \"profileid\": \"0\",
                        \"name\": \"Plasma Standard\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"5/6\",
                        \"SR\": \"Combi-Boltgun, Prc1, Lim\"
                      },
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"CP\",
                        \"profileid\": \"1\",
                        \"name\": \"Plasma Overcharge\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"5/6\",
                        \"SR\": \"Combi-Boltgun, Prc1, Lethal 5+, Hot, Lim\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"CB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Condemnor Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"CB\",
                        \"profileid\": \"0\",
                        \"name\": \"Condemnor\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"3/3\",
                        \"SR\": \"Combi-Boltgun, Sil, Lim, Dev1, PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"IP\",
                    \"wepseq\": 0,
                    \"wepname\": \"Inferno Pistol\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"IP\",
                        \"profileid\": \"0\",
                        \"name\": \"Inferno Pistol\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"5/3\",
                        \"SR\": \"Rng 3\\\", Prc2, Dev3\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"MCF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Ministorum Combi-Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"MCF\",
                        \"profileid\": \"0\",
                        \"name\": \"Ministorum Flamer\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Combi-Boltgun, Rng 6\\\", Tor 2\\\", Lim\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"MHF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Ministorum Hand Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"MHF\",
                        \"profileid\": \"0\",
                        \"name\": \"Ministorum Hand Flamer\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Rng 6\\\", Tor 1\\\", Sat\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"PP\",
                    \"wepseq\": 0,
                    \"wepname\": \"Plasma Pistol\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"PP\",
                        \"profileid\": \"0\",
                        \"name\": \"Standard\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"5/6\",
                        \"SR\": \"Rng 6\\\", Prc1\"
                      },
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"PP\",
                        \"profileid\": \"1\",
                        \"name\": \"Supercharge\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"5/6\",
                        \"SR\": \"Rng 6\\\", Prc1, Lethal 5+, Hot\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"CS\",
                    \"wepseq\": 0,
                    \"wepname\": \"Chainsword\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"CS\",
                        \"profileid\": \"0\",
                        \"name\": \"Chainsword\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"Gun Butt\",
                        \"A\": \"3\",
                        \"BS\": \"3+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"PM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Power Maul\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"PM\",
                        \"profileid\": \"0\",
                        \"name\": \"Power Maul\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
                        \"D\": \"4/5\",
                        \"SR\": \"Shock\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"PW\",
                    \"wepseq\": 0,
                    \"wepname\": \"Power Weapon\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"PW\",
                        \"profileid\": \"0\",
                        \"name\": \"Power Weapon\",
                        \"A\": \"4\",
                        \"BS\": \"2+\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"DP\",
                    \"title\": \"Divine Prayer\",
                    \"description\": \"At the start of each Turning Point, gain one Martyr point.\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman,Combat\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"RSUP\",
                \"opseq\": 0,
                \"opname\": \"Repentia Superior\",
                \"description\": \"The solemn task of guiding wayward Sisters in their atonement falls to Repentia Superior. These veterans are stern taskmasters who drive their charges forward with bellowed prayers and lashes from their neural whips, watching vigilantly for any remnant signs of sinfulness.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"9\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, REPENTIA, SUPERIOR, LEADER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"NWR\",
                    \"wepseq\": 0,
                    \"wepname\": \"Neural Whips\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"NWR\",
                        \"profileid\": \"0\",
                        \"name\": \"Neural Whips\",
                        \"A\": \"5\",
                        \"BS\": \"3+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Lethal 5+, Rng 3\\\", Stun\"
                      }
                    ],
                    \"isselected\": true
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"wepid\": \"NWM\",
                    \"wepseq\": 0,
                    \"wepname\": \"Neural Whips\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"SUP\",
                        \"wepid\": \"NWM\",
                        \"profileid\": \"0\",
                        \"name\": \"Neural Whips\",
                        \"A\": \"5\",
                        \"BS\": \"3+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Lethal 5+, Stun\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"SUP\",
                    \"uniqueactionid\": \"WIF\",
                    \"title\": \"Whip Into Fury\",
                    \"description\": \"Select one friendly SISTER REPENTIA operative within 3\\\" of and Visible to this operative. Add 1 to that friendly operative''s APL and, until the end of that operative''s next activation, add 2\\\" to that friendly operative''s Movement characteristic.\",
                    \"AP\": 1
                  }
                ],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Combat\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"IB\",
                \"opseq\": 2,
                \"opname\": \"Battle Sister Icon Bearer\",
                \"description\": \"These Sisters are thrice blessed to bear the holy icons known as Simulacrum Imperialis. Each artefact is an object of fervent devotion - representations of martyred warriors, recreations of objects and deeds associated with them or repositories of their mortal remains.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, BATTLE SISTER, ICON BEARER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"IB\",
                    \"wepid\": \"BG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"IB\",
                        \"wepid\": \"BG\",
                        \"profileid\": \"0\",
                        \"name\": \"Boltgun\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"IB\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"IB\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"Gun Butt\",
                        \"A\": \"3\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
                        \"SR\": \"\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"IB\",
                    \"uniqueactionid\": \"IOP\",
                    \"title\": \"Icon Of Purity\",
                    \"description\": \"Until the end of the Turning Point, while this operative is Visible to and within 3\\\" of a friendly ADEPTA SORORITAS operative, that friendly operative is inspired by purity. While an operative is inspired by purity, each time it fights in combat or makes a shooting attack, in the Roll Attack Dice step of that combat or shooting attack, you can retain one of your attack dice results of 5+ that is a successful hit as a critical hit.\",
                    \"AP\": 1
                  }
                ],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"IB\",
                    \"abilityid\": \"IB\",
                    \"title\": \"Icon Bearer\",
                    \"description\": \"When determining control of an objective marker, treat this operative''s APL as being 1 higher. Note that this is not a modifier. In narrative play, this is cumulative with the Focused Battloe Honour (see Core Rule Book).\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"GNR\",
                \"opseq\": 3,
                \"opname\": \"Battle Sister Gunner\",
                \"description\": \"Some Sisters are blessed to receive training in the use of special-issue, close-assault weapons. These sisters ritually maintain their Storm Bolters, Flamers, and Meltaguns, which they use in battle to unleash a blistering repudiation of heresy.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, BATTLE SISTER, GUNNER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"GNR\",
                    \"wepid\": \"MG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Meltagun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"GNR\",
                    \"wepid\": \"MF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Ministorum Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"GNR\",
                        \"wepid\": \"MF\",
                        \"profileid\": \"0\",
                        \"name\": \"Ministorum Flamer\",
                        \"A\": \"5\",
                        \"BS\": \"2+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Rng 6\\\", Tor 2\\\"\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"GNR\",
                    \"wepid\": \"SB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Storm Bolter\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"GNR\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"GNR\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"GNR\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"Gun Butt\",
                        \"A\": \"3\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"HGNR\",
                \"opseq\": 4,
                \"opname\": \"Battle Sister Heavy Gunner\",
                \"description\": \"Among the highly trained Adepta Sororitas, those Sisters granted the honour to bear the most potent armaments enable their team to engage heavily armoured opposition. Their expert eye for target prioritisation and enemy weak points makes them powerful assets.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, BATTLE SISTER, GUNNER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"HGNR\",
                    \"wepid\": \"HB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Heavy Bolter\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"HGNR\",
                        \"wepid\": \"HB\",
                        \"profileid\": \"0\",
                        \"name\": \"Heavy Bolter\",
                        \"A\": \"5\",
                        \"BS\": \"3+\",
                        \"D\": \"4/5\",
                        \"SR\": \"Hvy, PrcCrit1\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"HGNR\",
                    \"wepid\": \"MHF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Ministorum Heavy Flamer\",
                    \"weptype\": \"R\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"HGNR\",
                        \"wepid\": \"MHF\",
                        \"profileid\": \"0\",
                        \"name\": \"Ministorum Heavy Flamer\",
                        \"A\": \"6\",
                        \"BS\": \"2+\",
                        \"D\": \"2/3\",
                        \"SR\": \"Hvy, Rng 6\\\", Tor 2\\\"\"
                      }
                    ],
                    \"isselected\": false
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"HGNR\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 0,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"HGNR\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"Gun Butt\",
                        \"A\": \"3\",
                        \"BS\": \"4+\",
                        \"D\": \"2/3\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"WAR\",
                \"opseq\": 5,
                \"opname\": \"Battle Sister Warrior\",
                \"description\": \"Battle Sisters are the foot soldiers of the God-Emperor. Before their thundering boltguns, countless aliens, traitors, heretics, and mutants have met their doom. With voices raised high in prayer, their faith forms a shield around their souls.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"3+\",
                \"W\": \"8\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, BATTLE SISTER, WARRIOR\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"BG\",
                    \"wepseq\": 0,
                    \"wepname\": \"Boltgun\",
                    \"weptype\": \"R\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"BG\",
                        \"profileid\": \"0\",
                        \"name\": \"Boltgun\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"WAR\",
                    \"wepid\": \"GB\",
                    \"wepseq\": 0,
                    \"wepname\": \"Gun Butt\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"WAR\",
                        \"wepid\": \"GB\",
                        \"profileid\": \"0\",
                        \"name\": \"Gun Butt\",
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
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Staunch,Marksman\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"REP\",
                \"opseq\": 7,
                \"opname\": \"Sister Repentia\",
                \"description\": \"It is rare but not unknown for a Sister to fail in her duty, suffering disgrace as a result. Those who do are offered a change of redemption. Stripped of armour, they are sent to wreak penintent slaughter upon the enemy with cleaving blows from brutal eviscerators.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"6+\",
                \"W\": \"7\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ADEPTA SORORITAS, REPENTIA, SISTER\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"REP\",
                    \"wepid\": \"PE\",
                    \"wepseq\": 0,
                    \"wepname\": \"Penintent Eviscerator\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"ECC24\",
                        \"opid\": \"REP\",
                        \"wepid\": \"PE\",
                        \"profileid\": \"0\",
                        \"name\": \"Penintent Eviscerator\",
                        \"A\": \"4\",
                        \"BS\": \"4+\",
                        \"D\": \"5/6\",
                        \"SR\": \"Brutal, Lethal 5+\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"REP\",
                    \"abilityid\": \"SIA\",
                    \"title\": \"Solace In Anguish\",
                    \"description\": \"Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Scout,Combat\"
              },
              {
                \"factionid\": \"HBR\",
                \"killteamid\": \"ECC24\",
                \"fireteamid\": \"ECC24\",
                \"opid\": \"AF\",
                \"opseq\": 8,
                \"opname\": \"Arco-Flagellant\",
                \"description\": \"The Ecclesiarchy punishes those guilty of heresy in a number of ways. Those subjected to arco-flagellation are painfully remade - fitted with cybernetic weapons and sensory suppressors - then driven into a frenzy and unleashed as near-mindless killing machines.\",
                \"M\": \"6\\\"\",
                \"APL\": \"2\",
                \"GA\": \"1\",
                \"DF\": \"3\",
                \"SV\": \"6+\",
                \"W\": \"10\",
                \"keywords\": \"ECCLESIARCHY, IMPERIUM, ADEPTUS MINISTORUM, ARCO-FLAGELLANT\",
                \"weapons\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"AF\",
                    \"opid\": \"AF\",
                    \"wepid\": \"AF\",
                    \"wepseq\": 0,
                    \"wepname\": \"Arco-Flails\",
                    \"weptype\": \"M\",
                    \"isdefault\": 1,
                    \"profiles\": [
                      {
                        \"factionid\": \"HBR\",
                        \"killteamid\": \"ECC24\",
                        \"fireteamid\": \"AF\",
                        \"opid\": \"AF\",
                        \"wepid\": \"AF\",
                        \"profileid\": \"0\",
                        \"name\": \"Arco-Flails\",
                        \"A\": \"5\",
                        \"BS\": \"3+\",
                        \"D\": \"3/4\",
                        \"SR\": \"Ceaseless\"
                      }
                    ],
                    \"isselected\": true
                  }
                ],
                \"uniqueactions\": [],
                \"abilities\": [
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"AF\",
                    \"opid\": \"AF\",
                    \"abilityid\": \"BKM\",
                    \"title\": \"Berserk Killing Machine\",
                    \"description\": \"Whenever an attack dice inflicts damage of 3 or more on this operative, roll one D6: on a 5+, subtract 1 from that inflicted damage. This operative cannot perform mission actions or Pick Up actions. Unless otherwise specified, this operative cannot be equipped with equipment.\"
                  },
                  {
                    \"factionid\": \"HBR\",
                    \"killteamid\": \"ECC24\",
                    \"fireteamid\": \"ECC24\",
                    \"opid\": \"EXA\",
                    \"abilityid\": \"HM\",
                    \"title\": \"Holy Martyrs\",
                    \"description\": \"The first time each Turning Point a friendly ECCLESIARCHY operative becomes wounded or is incapacitated (whichever comes first), you gain a Martyr point. At the start of a friendly ECCLESIARCHY activation, you can spend a Martyrdom point to use one ACT OF REDEMPTION.<br/>\\nYou cannot use more than one ACT OF REDEMPTION per activation, and their effects are as follows:<br/>\\n<ul>\\n<li><strong>Emperor''s Light</strong><br/>Until the end of this operative''s activation, add 1 to its APL stat.</li>\\n<li><strong>Blessed Rejuvenation</strong><br/> This operative regains 1d3+1 lost wounds.</li>\\n<li><strong>Righteous Smite</strong><br/>This operative''s weapons have the Accurate 1 rule. This is not cumulative with Vantage.</li>\\n</ul>\"
                  }
                ],
                \"edition\": \"hidden\",
                \"fireteammax\": 0,
                \"specialisms\": \"Scout,Combat\"
              }
            ],
            \"fireteamcomp\": \"A BATTLE SISTER fire team includes five BATTLE SISTER operatives selected from the following list:\\n  <ul>\\n  <li>BATTLE SISTER WARRIOR</li>\\n  <li>BATTLE SISTER ICON BEARER</li>\\n  <li>\\n  BATTLE SISTER GUNNER each separately equipped with Gun Butt and one of the following options:\\n  <ul>\\n  <li>Meltagun, Ministorum Flamer, or Storm Bolter</li>\\n  </ul>\\n  </li>\\n  <li>\\n  BATTLE SISTER HEAVY GUNNER each separately equipped with Gun Butt and one of the following options:\\n  <ul>\\n  <li>Heavy Bolter or Ministorum Heavy Flamer</li>\\n  </ul>\\n  </li>\\n  </ul>\\n  \\n  Each BATTLE SISTER fire team can only include up to one BATTLE SISTER GUNNER operative.<br/>\\n  Your kill team can only include up to one BATTLE SISTER HEAVY GUNNER operative, and it can only do so if your kill team includes two BATTLE SISTER fire teams.</br>\\n  Your kill team can only include up to one BATTLE SISTER ICON BEARER.\\n  <br/>\\n  If your kill team does not include any other LEADER operatives, instead of selecting one BATTLE SISTER WARRIOR operative for one BATTLE SISTER fire team, you can select one BATTLE SISTER SUPERIOR operative equipped with one option from each of the following:\\n  <ul>\\n  <li>Chainsword, Gun Butt, Power Maul, or Power Weapon</li>\\n  <li>Bolt Pistol, Boltgun, Combi-Melta, Combi-Plasma, Condemnor Boltgun, Inferno Pistol, Ministorum Combi-Flamer, Ministorum Hand Flamer, or Plasma Pistol</li>\\n  </ul>\"
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


	