<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once $root . '/include.php';
global $dbcon;

header('Content-Type: text/plain');
switch ($_SERVER['REQUEST_METHOD']) {
	case "GET":
		//Get the requested thing
		echo GetName();
		break;
	default:
		//Invalid verb
		header('HTTP/1.0 400 Invalid verb "' . $_SERVER['REQUEST_METHOD'] . '"');
		die();
}

function GetName()
{
	$nametype = getIfSet($_REQUEST["nametype"]);

	// Validate Input
	if (strlen($nametype) > 40) {
		header("HTTP/1.0 400 Invalid Input");
		die();
	}

	switch ($nametype) {
		case "AELDARI-M":
			return GetAeldariMaleName() . " " . GetAeldariMaleName();
		case "AELDARI-F":
			return GetAeldariFemaleName() . " " . GetAeldariFemaleName();
		case "BEASTMEN":
			return GetBeastmenName();
		case "DARKAELDARI-M":
			return GetDarkAeldariMaleName() . " " . GetDarkAeldariMaleName();
		case "DARKAELDARI-F":
			return GetDarkAeldariFemaleName() . " " . GetDarkAeldariFemaleName();
		case "HEARTHKYN":
			return GetHearthkynName();
		case "HUMAN-M":
			return GetHumanMaleName();
		case "HUMAN-F":
			return GetHumanFemaleName();
		case "TYRANID":
			return GetTyranidName();
		case "SISTERSOFBATTLE":
			return GetSistersOfBattleName();
		case "SPACEMARINES":
			return GetSpaceMarineName();
		case "KROOT":
			return GetKrootName();
		case "TAU":
			return GetTauName();
		case "TAU-FIRE":
			return GetTauFireName();
		case "KASRKIN":
			return GetKasrkinName();
		case "HIEROTEK":
			return GetHierotekName();
		case "NECRON":
			return GetNecronName();
		case "ORK":
			return GetOrkName();
		case "ADMECH":
			return GetAdMechName();
		case "CHAOSMARINES":
			return GetChaosMarineName();
		case "DAEMONETTE":
			return GetDaemonetteName();
		case "DAEMON":
			return GetDaemonName();
	}

	// Return a name for the requested faction/killteam/fireteam/operative
	$faid = getIfSet($_REQUEST["factionid"]);
	$ktid = getIfSet($_REQUEST["killteamid"]);
	$ftid = getIfSet($_REQUEST["fireteamid"]);
	$opid = getIfSet($_REQUEST["opid"]);

	// Validate Input
	if (strlen($faid) > 10 || strlen($ktid) > 10 || strlen($ftid) > 10 || strlen($opid) > 10) {
		header("HTTP/1.0 400 Invalid Input");
		die();
	}

	$key = $faid . "|" . $ktid . "|" . $ftid . "|" . $opid;

	switch ($key) {
		// Blade of Khaine
		case "AEL|BOK|BOK|DAX": //Dark Avenger Exarch
		case "AEL|BOK|BOK|DAW": //Dark Avenger Warrior
		case "AEL|BOK|BOK|SSX": //Striking Scorpion Exarch
		case "AEL|BOK|BOK|SSW": //Striking Scorpion Warrior
		case "AEL|BOK|BOK|HBX": //Howling Banshee Exarch
		case "AEL|BOK|BOK|HBW": //Howling Banshee Warrior
			return GetAeldariName();

		// Commorites
		case "AEL|COM|KBL|GNR": //Kabalite Gunner
		case "AEL|COM|KBL|HGNR": //Kabalite Heavy Gunner
		case "AEL|COM|KBL|SYB": //Sybarite
		case "AEL|COM|KBL|WAR": //Kabalite Warrior
			return GetAeldariName();
		case "AEL|COM|WYCH|FTR": //Wych Fighter
		case "AEL|COM|WYCH|HEK": //Hekatrix
		case "AEL|COM|WYCH|WAR": //Wych Warrior
			return GetAeldariFemaleName() . " " . GetAeldariFemaleName();

		// Corsair Voidscarred
		case "AEL|COR|COR|FA": //Voidscarred Felarch
		case "AEL|COR|COR|FD": //Voidscarred Fate Dealer
		case "AEL|COR|COR|GNR": //Voidscarred Gunner
		case "AEL|COR|COR|HGNR": //Voidscarred Heavy Gunner
		case "AEL|COR|COR|KH": //Voidscarred Kurnite Hunter
		case "AEL|COR|COR|KU": //Voidscarred Kurnathi
		case "AEL|COR|COR|SR": //Voidscarred Shade Runner
		case "AEL|COR|COR|SSD": //Voidscarred Starstorm Duellist
		case "AEL|COR|COR|SW": //Voidscarred Soul Weaver
		case "AEL|COR|COR|WAR": //Voidscarred Warrior
		case "AEL|COR|COR|WS": //Voidscarred Way Seeker
			return GetAeldariName();

		// Craftworld
		case "AEL|CW|DA|EXA": //Dire Avenger Exarch
		case "AEL|CW|DA|WAR": //Dire Avenger Warrior
		case "AEL|CW|GD|HGNR": //Guardian Defender Heavy Gunner
		case "AEL|CW|GD|LDR": //Guardian Defender Leader
		case "AEL|CW|GD|WAR": //Guardian Defender Warrior
		case "AEL|CW|GD|WPLT": //Guardian Defender Heavy Weapon Platform
		case "AEL|CW|RNGR|LDR": //Ranger Leader
		case "AEL|CW|RNGR|WAR": //Ranger Warrior
		case "AEL|CW|SG|GNR": //Storm Guardian Gunner
		case "AEL|CW|SG|LDR": //Storm Guardian Leader
		case "AEL|CW|SG|WAR": //Storm Guardian Warrior
			return GetAeldariName();

		// Void-Dancer Troupe/Troupe
		case "AEL|TRP|TRP|GNR": //Player Gunner
		case "AEL|TRP|TRP|LDR": //Player Leader
		case "AEL|TRP|TRP|WAR": //Player Warrior
		case "AEL|VDT|VDT|LPL": //Lead Player
		case "AEL|VDT|VDT|PLAY": //Player
		case "AEL|VDT|VDT|DJS": //Death Jester
		case "AEL|VDT|VDT|SDS": //Shadowseer
			return GetAeldariName();

		// Hand of the Archon
		case "AEL|HOTA|HOTA|KAG":
		case "AEL|HOTA|HOTA|KAS":
		case "AEL|HOTA|HOTA|KCD":
		case "AEL|HOTA|HOTA|KDOY":
		case "AEL|HOTA|HOTA|KELX":
		case "AEL|HOTA|HOTA|KFLAY":
		case "AEL|HOTA|HOTA|KGNR":
		case "AEL|HOTA|HOTA|KHGNR":
		case "AEL|HOTA|HOTA|KSA":
			return GetAeldariName();

		// Aeldari Mandrakes
		case "AEL|MND|MND|AB": //Mandrake Abyssal
		case "AEL|MND|MND|COTF": //Mandrake Chooser Of The Flesh
		case "AEL|MND|MND|DM": //Mandrake Dirgemaw
		case "AEL|MND|MND|NF": //Mandrake Nightfiend
		case "AEL|MND|MND|SW": //Mandrake Shadeweaver
		case "AEL|MND|MND|WAR": //Mandrake Warrior
		case "AEL|MND24|MND24|ABS": //Mandrake Abyssal
		case "AEL|MND24|MND24|COTF": //Mandrake Chooser Of The Flesh
		case "AEL|MND24|MND24|DM": //Mandrake Dirgemaw
		case "AEL|MND24|MND24|NF": //Mandrake Nightfiend
		case "AEL|MND24|MND24|SW": //Mandrake Shadeweaver
		case "AEL|MND24|MND24|WAR": //Mandrake Warrior
			return GetDarkAeldariName();

		// Chaos Cult
		case "CHAOS|CULT|CULT|BLBL": //Blessed Blade
		case "CHAOS|CULT|CULT|DEMA": //Cult Demagogue
		case "CHAOS|CULT|CULT|DEV": //Chaos Devotee
		case "CHAOS|CULT|CULT|ICON": //Iconarch
		case "CHAOS|CULT|CULT|MUT": //Chaos Mutant
		case "CHAOS|CULT|CULT|MW": //Mindwitch
		case "CHAOS|CULT|CULT|TOR": //Chaos Torment
			return GetChaosCultistName();
		case "CHAOS|CSM|CC|CHA": //Chaos Cultist Champion
		case "CHAOS|CSM|CC|FTR": //Chaos Cultist Fighter
		case "CHAOS|CSM|CC|GNR": //Chaos Cultist Gunner
			return GetHumanName();

		// Chaos Space Marines
		case "CHAOS|CSM|CSM|AC": //Chaos Space Marine Aspiring Champion
		case "CHAOS|CSM|CSM|GNR": //Chaos Space Marine Gunner
		case "CHAOS|CSM|CSM|HGNR": //Chaos Space Marine Heavy Gunner
		case "CHAOS|CSM|CSM|IB": //Chaos Space Marine Icon Bearer
		case "CHAOS|CSM|CSM|WAR": //Chaos Space Marine Warrior
			return GetChaosMarineName();
		case "CHAOS|DAEM|BH|BLUE": //Blue Horror
			return "Blue Horror";
		case "CHAOS|DAEM|BH|BRIM": //Brimstone Horror
			return "Brimstone Horror";
		case "CHAOS|DAEM|BL|BR": //Bloodreaper
		case "CHAOS|DAEM|BL|FTR": //Bloodletter Fighter
		case "CHAOS|DAEM|BL|HB": //Bloodletter Horn Bearer
		case "CHAOS|DAEM|BL|IB": //Bloodletter Icon Bearer
			return GetDaemonName();

		// Gellerpox Infected
		case "CHAOS|GPI|GPI|BS": // Bloatspawn
		case "CHAOS|GPI|GPI|FS": // Fleshscreamer
		case "CHAOS|GPI|GPI|GL": // Glitchling
		case "CHAOS|GPI|GPI|GM": // Gellerpox Mutant
		case "CHAOS|GPI|GPI|LG": // Lumberghast
		case "CHAOS|GPI|GPI|VTC": // Vulgrar Thrice-Cursed
		case "CHAOS|GPI|MV|CM": // Cursemite
		case "CHAOS|GPI|MV|ESS": // Eyestinger Swarm
		case "CHAOS|GPI|MV|SG": // Sludge-Grub
			return GetDaemonName();

		// Chaos Daemonettes
		case "CHAOS|DAEM|DETTE|AL": //Alluress
		case "CHAOS|DAEM|DETTE|FTR": //Daemonette Fighter
		case "CHAOS|DAEM|DETTE|HB": //Daemonette Horn Bearer
		case "CHAOS|DAEM|DETTE|IB": //Daemonette Icon Bearer
			return GetDaemonetteName();

		// Chaos Plaguebearers
		case "CHAOS|DAEM|PB|FTR": //Plaguebearer Fighter
		case "CHAOS|DAEM|PB|HB": //Plaguebearer Horn Bearer
		case "CHAOS|DAEM|PB|IB": //Plaguebearer Icon Bearer
		case "CHAOS|DAEM|PB|PR": //Plagueridden
			return GetDaemonName();
		case "CHAOS|DAEM|PH|FTR": //Pink Horror Fighter
		case "CHAOS|DAEM|PH|HB": //Pink Horror Horn Bearer
		case "CHAOS|DAEM|PH|IB": //Pink Horror Icon Bearer
		case "CHAOS|DAEM|PH|IR": //Pink Horror Iridescent
			return "Pink Horror";

		// Deathguard
		case "CHAOS|DG|PM|CHA": //Plague Marine Champion
		case "CHAOS|DG|PM|FTR": //Plague Marine Fighter
		case "CHAOS|DG|PM|GNR": //Plague Marine Gunner
		case "CHAOS|DG|PM|HGNR": //Plague Marine Heavy Gunner
		case "CHAOS|DG|PM|IB": //Plague Marine Icon Bearer
		case "CHAOS|DG|PM|WAR": //Plague Marine Warrior
			return GetChaosMarineName();
		case "CHAOS|DG|PW|PW": //Poxwalker
			return "Poxwalker";

		// Fellgor Ravagers
		case "CHAOS|FELL|FELL|IH": //Fellgor Ironhorn
		case "CHAOS|FELL|FELL|DK": //Fellgor Deathknell
		case "CHAOS|FELL|FELL|FB": //Fellgor Fluxbray
		case "CHAOS|FELL|FELL|GS": //Fellgor Gnarlscar
		case "CHAOS|FELL|FELL|GH": //Fellgor Gorehorn
		case "CHAOS|FELL|FELL|HG": //Fellgor Herd-Goad
		case "CHAOS|FELL|FELL|MNG": //Fellgor Mangler
		case "CHAOS|FELL|FELL|VND": //Fellgor Vandal
		case "CHAOS|FELL|FELL|TOX": //Fellgorn Toxhorn
		case "CHAOS|FELL|FELL|SHA": //Fellgor Shaman
		case "CHAOS|FELL|FELL|WAR": //Fellgor Warrior
			return GetBeastmenName();

		// Chaos Legionaries
		case "CHAOS|LEG|LEG|AC": //Legionary Aspiring Champion
		case "CHAOS|LEG|LEG|ANO": //Legionary Anointed
		case "CHAOS|LEG|LEG|BA": //Legionary Balefire Acolyte
		case "CHAOS|LEG|LEG|BUT": //Legionary Butcher
		case "CHAOS|LEG|LEG|CHO": //Legionary Chosen
		case "CHAOS|LEG|LEG|GNR": //Legionary Gunner
		case "CHAOS|LEG|LEG|HGNR": //Legionary Heavy Gunner
		case "CHAOS|LEG|LEG|IB": //Legionary Icon Bearer
		case "CHAOS|LEG|LEG|STL": //Legionary ShriveTalon
		case "CHAOS|LEG|LEG|WAR": //Legionary Warrior
			return GetChaosMarineName();

		// Nemesis Claw
		case "CHAOS|NC|NC|FRM": //Night Lord Fearmonger
		case "CHAOS|NC|NC|GNR": //Night Lord Gunner
		case "CHAOS|NC|NC|HGNR": //Night Lord Heavy Gunner
		case "CHAOS|NC|NC|SCR": //Night Lord Screecher
		case "CHAOS|NC|NC|SKT": //Night Lord Skinthief
		case "CHAOS|NC|NC|VEN": //Night Lord Ventrilokar
		case "CHAOS|NC|NC|VIS": //Night Lord Visionary
		case "CHAOS|NC|NC|WAR": //Night Lord Warrior
			return GetChaosMarineName();

		// Thousand Sons
		case "CHAOS|TS|RUB|GNR": //Rubric Marine Gunner
		case "CHAOS|TS|RUB|IB": //Rubric Marine Icon Bearer
		case "CHAOS|TS|RUB|SOR": //Aspiring Sorcerer
		case "CHAOS|TS|RUB|WAR": //Rubric Marine Warrior
			return GetChaosMarineName();
		case "CHAOS|TS|TZA|FTR": //Tzaangor Fighter
		case "CHAOS|TS|TZA|HB": //Tzaangor Horn Bearer
		case "CHAOS|TS|TZA|IB": //Tzaangor Icon Bearer
		case "CHAOS|TS|TZA|TB": //Twistbray
			return GetDaemonName();

		// Warp Coven
		case "CHAOS|WC|WC|GNR": //Rubric Marine Gunner
		case "CHAOS|WC|WC|IB": //Rubric Marine Icon Bearer
		case "CHAOS|WC|WC|SOR": //Sorcerer
		case "CHAOS|WC|WC|WAR": //Rubric Marine Warrior
			return GetChaosMarineName();
		case "CHAOS|WC|WC|TZC": //Tzaangor Champion
		case "CHAOS|WC|WC|TZFTR": //Tzaangor Fighter
		case "CHAOS|WC|WC|TZHB": //Tzaangor Horn Bearer
		case "CHAOS|WC|WC|TZIB": //Tzaangor Icon Bearer
			return GetDaemonName();

		// Space Hulk Veterans
		case "HBR|SHV|SHV|FTR":
		case "HBR|SHV|SHV|GNR":
		case "HBR|SHV|SHV|SGT":
		case "HBR|SHV|SHV|WAR":
			return GetSpaceMarineName();

		// Ecclesiarchy
		case "IMP|ECC|AF|AF": //Arco-Flagellant
			return "Servitor";
		case "IMP|ECC|BS|GNR": //Battle Sister Gunner
		case "IMP|ECC|BS|HGNR": //Battle Sister Heavy Gunner
		case "IMP|ECC|BS|IB": //Battle Sister Icon Bearer
		case "IMP|ECC|BS|SUP": //Battle Sister Superior
		case "IMP|ECC|BS|WAR": //Battle Sister Warrior
		case "IMP|ECC|REP|REP": //Sister Repentia
		case "IMP|ECC|REP|SUP": //Repentia Superior
			return GetSistersOfBattleName();

		// Elucidian Starstriders
		case "IMP|ESS|ESS|CAN": // Canid
			return "Aximillion";
		case "IMP|ESS|ESS|DCE": // Death Cult Executioner
			return "Knosso Prond";
		case "IMP|ESS|ESS|EV": // Elucia Vhane
			return "Elucia Vhane";
		case "IMP|ESS|ESS|LM": // Lectro-Maester
			return "Larsen van der Gauss";
		case "IMP|ESS|ESS|PSA": // Privateer Support Assets
			return "Privateer Support Assets";
		case "IMP|ESS|ESS|REJAD": // Rejuvenat Adept
			return "Sanistasia Minst";
		case "IMP|ESS|ESS|VM": // Voidsman
			return "Stromian Grell";
		case "IMP|ESS|ESS|VMST": // Voidmaster
			return "Voidmaster Nitsch";

		// Forge World
		case "IMP|FW|SIC|INF": //Sicarian Infiltrator Trooper
		case "IMP|FW|SIC|INFPRI": //Sicarian Infiltrator Princeps
		case "IMP|FW|SIC|PRI": //Sicarian Ruststalker Princeps
		case "IMP|FW|SIC|TRP": //Sicarian Ruststalker Trooper
		case "IMP|FW|SKR|ALP": //Skitarii Ranger Alpha
		case "IMP|FW|SKR|GNR": //Skitarii Ranger Gunner
		case "IMP|FW|SKR|TRP": //Skitarii Ranger Trooper
		case "IMP|FW|SKV|ALP": //Skitarii Vanguard Alpha
		case "IMP|FW|SKV|GNR": //Skitarii Vanguard Gunner
		case "IMP|FW|SKV|TRP": //Skitarii Vanguard Trooper
			return GetAdMechName();

		// Grey Knights
		case "IMP|GK|GK|GNR": //Grey Knight Gunner
		case "IMP|GK|GK|JST": //Grey Knight Justicar
		case "IMP|GK|GK|WAR": //Grey Knight Warrior
			return GetSpaceMarineName();

		// Hunter Clade
		case "IMP|HC|HC|SIIP": //Sicarian Infiltrator Princeps
		case "IMP|HC|HC|SIIT": //Sicarian Infiltrator Tracker
		case "IMP|HC|HC|SIRA": //Sicarian Ruststalker Assassin
		case "IMP|HC|HC|SIRP": //Sicarian Ruststalker Princeps
		case "IMP|HC|HC|SKRA": //Skitarii Ranger Alpha
		case "IMP|HC|HC|SKRD": //Skitarii Ranger Diktat
		case "IMP|HC|HC|SKRG": //Skitarii Ranger Gunner
		case "IMP|HC|HC|SKRM": //Skitarii Ranger Marksman
		case "IMP|HC|HC|SKRS": //Skitarii Ranger Surveyor
		case "IMP|HC|HC|SKVA": //Skitarii Vanguard Alpha
		case "IMP|HC|HC|SKVD": //Skitarii Vanguard Diktat
		case "IMP|HC|HC|SKVG": //Skitarii Vanguard Gunner
		case "IMP|HC|HC|SKVS": //Skitarii Vanguard Surveyor
		case "IMP|HC|HC|SKVST": //Skitarii Vanguard Shocktrooper
			return GetAdMechName();

		// Imperial Guard
		case "IMP|IG|GM|COMMS": //Guardsman Comms
		case "IMP|IG|GM|GNR": //Guardsman Gunner
		case "IMP|IG|GM|SGT": //Guardsman Sergeant
		case "IMP|IG|GM|TRP": //Guardsman Trooper
			return GetHumanName();
		case "IMP|IG|TS|COMMS": //Tempestus Scion Comms
		case "IMP|IG|TS|GNR": //Tempestus Scion Gunner
		case "IMP|IG|TS|SGT": //Tempestor
		case "IMP|IG|TS|TRP": //Tempestus Scion Trooper
			return GetHumanName();

		// Inquisitorial Agents
		case "IMP|INQ|INQ|AS": //Autosavant
		case "IMP|INQ|INQ|ENL": //Enlightener
		case "IMP|INQ|INQ|GUNS": //Gun Servitor
		case "IMP|INQ|INQ|HEX": //Hexorcist
		case "IMP|INQ|INQ|INT": //Interrogator
		case "IMP|INQ|INQ|MYS": //Mystic
		case "IMP|INQ|INQ|PEN": //Penal Legionnaire
		case "IMP|INQ|INQ|PST": //Pistolier
		case "IMP|INQ|INQ|QK": //Questkeeper
		case "IMP|INQ|INQ|TS": //Tome-Skull
		case "IMP|INQ|INQ|VET": //Deathworld Veteran
			return GetInqName();

		// Intercessors
		case "IMP|INTS|INTS|AISGT": //Intercession Squad Assault Intercessor Sergeant
		case "IMP|INTS|INTS|ISGT": //Intercession Squad Intercessor Sergeant
		case "IMP|INTS|INTS|AIWAR": //Intercession Squad Assault Intercessor Warrior
		case "IMP|INTS|INTS|AIGRN": //Intercession Squad Assault Intercessor Grenadier
		case "IMP|INTS|INTS|IWAR": //Intercession Squad Intercessor Warrior
		case "IMP|INTS|INTS|IGNR": //Intercession Squad Intercessor Gunner
			return GetSpaceMarineName();

		// Kasrkin
		case "IMP|KAS|KAS|SGT":
		case "IMP|KAS|KAS|MED":
		case "IMP|KAS|KAS|DEMO":
		case "IMP|KAS|KAS|GNR":
		case "IMP|KAS|KAS|REC":
		case "IMP|KAS|KAS|SS":
		case "IMP|KAS|KAS|TRP":
		case "IMP|KAS|KAS|VOX":
			return GetKasrkinName();

		// Novitiates
		case "IMP|NOV|NOV|CON": //Novitiate Condemnor
		case "IMP|NOV|NOV|DIA": //Novitiate Dialogus
		case "IMP|NOV|NOV|DUE": //Novitiate Duellist
		case "IMP|NOV|NOV|EXA": //Novitiate Exactor
		case "IMP|NOV|NOV|HOS": //Novitiate Hospitaller
		case "IMP|NOV|NOV|MIL": //Novitiate Militant
		case "IMP|NOV|NOV|PEN": //Novitiate Penitent
		case "IMP|NOV|NOV|PRE": //Novitiate Preceptor
		case "IMP|NOV|NOV|PRO": //Novitiate Pronatus
		case "IMP|NOV|NOV|PUR": //Novitiate Purgatus
		case "IMP|NOV|NOV|REL": //Novitiate Reliquarius
		case "IMP|NOV|NOV|SUP": //Novitiate Superior
			return GetSistersOfBattleName();

		// Phobos
		case "IMP|PHO|PHO|INCML":  //Phobos Strike Team Incursor Minelayer
		case "IMP|PHO|PHO|INCMRK": //Phobos Strike Team Incursor Marksman
		case "IMP|PHO|PHO|INCSGT": //Phobos Strike Team Incursor Sergeant
		case "IMP|PHO|PHO|INCWAR": //Phobos Strike Team Incursor Warrior
		case "IMP|PHO|PHO|INFCOM": //Phobos Strike Team Infiltrator Commsman
		case "IMP|PHO|PHO|INFHEL": //Phobos Strike Team Infiltrator Helix Adept
		case "IMP|PHO|PHO|INFSAB": //Phobos Strike Team Infiltrator Saboteur
		case "IMP|PHO|PHO|INFSGT": //Phobos Strike Team Infiltrator Sergeant
		case "IMP|PHO|PHO|INFVET": //Phobos Strike Team Infiltrator Veteran
		case "IMP|PHO|PHO|INFVOX": //Phobos Strike Team Infiltrator Voxbreaker
		case "IMP|PHO|PHO|INFWAR": //Phobos Strike Team Infiltrator Warrior
		case "IMP|PHO|PHO|RVRSGT": //Phobos Strike Team Reiver Sergeant
		case "IMP|PHO|PHO|RVRWAR": //Phobos Strike Team Reiver Warrior
			return GetSpaceMarineName();

		// Strike Force Justian
		case "IMP|SFJ|SFJ|CAP":
			return "Captain Justian";
		case "IMP|SFJ|SFJ|SGT":
			return "Sergeant Marius";
		case "IMP|SFJ|SFJ|ACU":
			return "Brother Acules";
		case "IMP|SFJ|SFJ|DEC":
			return "Brother Decian";
		case "IMP|SFJ|SFJ|FLA":
			return "Brother Flavian";
		case "IMP|SFJ|SFJ|THY":
			return "Brother Thysor";
		case "IMP|SFJ|SFJ|VIG":
			return "Brother Vignius";

		//Scouts
		case "IMP|SCT|SCT|SGT": //Scout Sergeant
		case "IMP|SCT|SCT|HGNR": //Scout Heavy Gunner
		case "IMP|SCT|SCT|HNTR": //Scout Hunter
		case "IMP|SCT|SCT|SNP": //Scout Sniper
		case "IMP|SCT|SCT|TRK": //Scout Tracker
		case "IMP|SCT|SCT|WAR": //Scout Warrior
		case "IMP|SCT24|SCT24|SGT": //Scout Sergeant
		case "IMP|SCT24|SCT24|HGNR": //Scout Heavy Gunner
		case "IMP|SCT24|SCT24|HNT": //Scout Hunter
		case "IMP|SCT24|SCT24|SNP": //Scout Sniper
		case "IMP|SCT24|SCT24|TRK": //Scout Tracker
		case "IMP|SCT24|SCT24|WAR": //Scout Warrior
			return GetSpaceMarineName();

		// Space Marines
		case "IMP|SM|AINT|SGT": //Assault Intercessor Sergeant
		case "IMP|SM|AINT|WAR": //Assault Intercessor Warrior
		case "IMP|SM|DW|FTR": //DeathWatch Fighter
		case "IMP|SM|DW|GNR": //DeathWatch Gunner
		case "IMP|SM|DW|HGNR": //DeathWatch Heavy Gunner
		case "IMP|SM|DW|SGT": //DeathWatch Sergeant
		case "IMP|SM|DW|WAR": //DeathWatch Warrior
		case "IMP|SM|HINT|HGNR": //Heavy Intercessor Heavy Gunner
		case "IMP|SM|HINT|SGT": //Heavy Intercessor Sergeant
		case "IMP|SM|HINT|WAR": //Heavy Intercessor Warrior
		case "IMP|SM|INC|SGT": //Incursor Sergeant
		case "IMP|SM|INC|WAR": //Incursor Warrior
		case "IMP|SM|INF|SGT": //Infiltrator Sergeant
		case "IMP|SM|INF|WAR": //Infiltrator Warrior
		case "IMP|SM|INT|SGT": //Intercessor Sergeant
		case "IMP|SM|INT|WAR": //Intercessor Warrior
		case "IMP|SM|RVR|SGT": //Reiver Sergeant
		case "IMP|SM|RVR|WAR": //Reiver Warrior
		case "IMP|SM|SCT|HGNR": //Scout Heavy Gunner
		case "IMP|SM|SCT|SGT": //Scout Sergeant
		case "IMP|SM|SCT|SNP": //Scout Sniper
		case "IMP|SM|SCT|SNPSGT": //Scout Sniper Sergeant
		case "IMP|SM|SCT|WAR": //Scout Warrior
		case "IMP|SM|TAC|GNR": //Tactical Marine Gunner
		case "IMP|SM|TAC|HGNR": //Tactical Marine Heavy Gunner
		case "IMP|SM|TAC|SGT": //Tactical Marine Sergeant
		case "IMP|SM|TAC|WAR": //Tactical Marine Warrior
			return GetSpaceMarineName();
		
		case "IMP|TEMPAQ|TEMPAQ|GF": //Aquilon Gunfighter
		case "IMP|TEMPAQ|TEMPAQ|GNR": //Aquilon Gunner
		case "IMP|TEMPAQ|TEMPAQ|GRN": //Aquilon Grenadier
		case "IMP|TEMPAQ|TEMPAQ|MRK": //Aquilon Marksman
		case "IMP|TEMPAQ|TEMPAQ|PRE": //Aquilon Precursor
		case "IMP|TEMPAQ|TEMPAQ|TEMP": //Aquilon Tempestor
		case "IMP|TEMPAQ|TEMPAQ|TRP": //Aquilon Trooper
			return GetHumanName();
		case "IMP|TEMPAQ|TEMPAQ|SS": //Aquilon Servo-Sentry
			return "Sentry";

		// Talons of the Emperor
		case "IMP|TOE|CG|LDR": //Custodian Guard Leader
		case "IMP|TOE|CG|WAR": //Custodian Guard Warrior
			return GetSpaceMarineName();
		case "IMP|TOE|SOS|PRO": //Sister Of Silence Prosecutor
		case "IMP|TOE|SOS|SUP": //Sister Of Silence Superior
		case "IMP|TOE|SOS|VIG": //Sister Of Silence Vigilator
		case "IMP|TOE|SOS|WSK": //Sister Of Silence Witchseeker
			return GetSistersOfBattleName();

		// Veteran Guardsmen
		case "IMP|VG|VG|BRS": //Bruiser Veteran
		case "IMP|VG|VG|CNF": //Confidant Veteran
		case "IMP|VG|VG|COMMS": //Comms Veteran
		case "IMP|VG|VG|DEMO": //Demolition Veteran
		case "IMP|VG|VG|GNR": //Gunner Veteran
		case "IMP|VG|VG|HARD": //Hardened Veteran
		case "IMP|VG|VG|MDC": //Medic Veteran
		case "IMP|VG|VG|SGT": //Sergeant Veteran
		case "IMP|VG|VG|SNP": //Sniper Veteran
		case "IMP|VG|VG|SPOT": //Spotter Veteran
		case "IMP|VG|VG|TRP": //Trooper Veteran
		case "IMP|VG|VG|ZLT": //Zealot Veteran
			return GetHumanName();

		// Necron Tombworld
		case "NEC|TW|DM|LDR": //Deathmark Leader
		case "NEC|TW|DM|WAR": //Deathmark Warrior
		case "NEC|TW|FLO|LDR": //Flayed One Leader
		case "NEC|TW|FLO|WAR": //Flayed One Warrior
		case "NEC|TW|IMM|LDR": //Immortal Leader
		case "NEC|TW|IMM|WAR": //Immortal Warrior
		case "NEC|TW|NC|NEC": //Necron Warrior
			return GetNecronName();

		// Necron Hierotek
		case "NEC|HIER|HIER|CHRON": // Chronomancer
		case "NEC|HIER|HIER|PSYCH": // Psychomancer
		case "NEC|HIER|HIER|TECH": // Technomancer
		case "NEC|HIER|HIER|APP": // Apprentek
		case "NEC|HIER|HIER|DM": // Deathmark
		case "NEC|HIER|HIER|ID": // Immortal Despotek
		case "NEC|HIER|HIER|IG": // Immortal Guardian
			return GetHierotekName();
		case "NEC|HIER|HIER|PA": // Plasmacyte Accelerator
			return "Plasmacyte Accelerator";
		case "NEC|HIER|HIER|PR": // Plasmacyte Reanimator
			return "Plasmacyte Reanimator";

		// Ork Greenskins
		case "ORK|GSK|BOY|BN": //Boss Nob
		case "ORK|GSK|BOY|FTR": //Boy Fighter
		case "ORK|GSK|BOY|GNR": //Boy Gunner
		case "ORK|GSK|BOY|GRE": //Gretchin
		case "ORK|GSK|CK|FTR": //Clan Kommando Fighter
		case "ORK|GSK|CK|NOB": //Clan Kommando Nob
		case "ORK|GSK|SPE|BUR": //Burna Boy
		case "ORK|GSK|SPE|LOO": //Loota
		case "ORK|GSK|SPE|SPN": //Spanner

		// Ork Kommandoz
		case "ORK|KOM|KOM|BOY": //Kommando Boy
		case "ORK|KOM|KOM|BRE": //Kommando Breacha Boy
		case "ORK|KOM|KOM|BUR": //Kommando Burna Boy
		case "ORK|KOM|KOM|COM": //Kommando Comms Boy
		case "ORK|KOM|KOM|DAK": //Kommando Dakka Boy
		case "ORK|KOM|KOM|GRT": //Kommando Grot
		case "ORK|KOM|KOM|NOB": //Kommando Nob
		case "ORK|KOM|KOM|RKT": //Kommando Rokkit Boy
		case "ORK|KOM|KOM|SLA": //Kommando Slasha Boy
		case "ORK|KOM|KOM|SNP": //Kommando Snipa Boy
			return GetOrkName();
		case "ORK|KOM|KOM|BOM": //Bomb Squig
			return "Skwiglz";

		// Tau - Cadre Mercenaries
		case "TAU|CM|CM|HND": //Kroot Hound
		case "TAU|CM|CM|KTX": //Krootox
		case "TAU|CM|CM|LDR": //Kroot Carnivore Leader
		case "TAU|CM|CM|WAR": //Kroot Carnivore Warrior
			return GetKrootName();

		// Farstalker Kinband
		case "TAU|FSKB|FSKB|BH": // FSKB - Kroot Bow-Hunter
		case "TAU|FSKB|FSKB|CB": // FSKB - Kroot Cold-Blood
		case "TAU|FSKB|FSKB|CS": // FSKB - Kroot Cut-Skin
		case "TAU|FSKB|FSKB|HGNR": // FSKB - Kroot Heavy Gunner
		case "TAU|FSKB|FSKB|HND": // FSKB - Kroot Hound
		case "TAU|FSKB|FSKB|KB": // FSKB - Kroot Kill-Broker
		case "TAU|FSKB|FSKB|LS": // FSKB - Kroot Long-Sight
		case "TAU|FSKB|FSKB|PST": // FSKB - Kroot Pistolier
		case "TAU|FSKB|FSKB|STK": // FSKB - Kroot Stalker
		case "TAU|FSKB|FSKB|TRK": // FSKB - Kroot Tracker
		case "TAU|FSKB|FSKB|WAR": // FSKB - Kroot Warrior
			return GetKrootName();

		// Tau - Hunter Cadre
		case "TAU|HC|DRN|DS8": //DS8 Tactical Support Turret
		case "TAU|HC|DRN|MB3": //MB3 Recon Drone
		case "TAU|HC|DRN|MV1": //MV1 Gun Drone
		case "TAU|HC|DRN|MV31": //MV31 Pulse Accelerator Drone
		case "TAU|HC|DRN|MV33": //MV33 Grav-Inhibitor Drone
		case "TAU|HC|DRN|MV36": //MV36 Guardian Drone
		case "TAU|HC|DRN|MV4": //MV4 Shield Drone
		case "TAU|HC|DRN|MV7": //MV7 Marker Drone

		// Tau - Pathfinders
		case "TAU|PF|PF|MB3": //MB3 Recon Drone
		case "TAU|PF|PF|MV1": //MV1 Gun Drone
		case "TAU|PF|PF|MV31": //MV31 Pulse Accelerator Drone
		case "TAU|PF|PF|MV33": //MV33 Grav-Inhibitor Drone
		case "TAU|PF|PF|MV4": //MV4 Shield Drone
		case "TAU|PF|PF|MV7": //MV7 Marker Drone
			return $opid;
		case "TAU|HC|FW|SL": //Fire Warrior Shas'La
		case "TAU|HC|FW|SU": //Fire Warrior Shas'Ui
		case "TAU|HC|PF|HGNR": //Pathfinder Heavy Gunner
		case "TAU|HC|PF|SL": //Pathfinder Shas'La
		case "TAU|HC|PF|SU": //Pathfinder Shas'Ui
		case "TAU|HC|SBS|SU": //Stealth Battlesuit Shas'Ui
		case "TAU|HC|SBS|SV": //Stealth Battlesuit Shas'Vre
		case "TAU|PF|PF|AG": //Assault Grenadier Pathfinder
		case "TAU|PF|PF|BL": //Blooded Pathfinder
		case "TAU|PF|PF|COMMS": //Communications Specialist Pathfinder
		case "TAU|PF|PF|DC": //Drone Controller Pathfinder
		case "TAU|PF|PF|MARKS": //Marksman Pathfinder
		case "TAU|PF|PF|MDC": //Medical Technician Pathfinder
		case "TAU|PF|PF|SL": //Shas'La Pathfinder
		case "TAU|PF|PF|SU": //Shas'Ui Pathfinder
		case "TAU|PF|PF|TSI": //Transpectral Interference Pathfinder
		case "TAU|PF|PF|WE": //Weapons Expert Pathfinder
			return GetTauFireName();
		
		case "TAU|VESP|VESP|OSD": //Oversight Drone
			return "Drone";
		case "TAU|VESP|VESP|VLS": //Vespid Longsting
		case "TAU|VESP|VESP|VSB": //Vespid Skyblast
		case "TAU|VESP|VESP|VSG": //Vespid Swarmguard
		case "TAU|VESP|VESP|VSL": //Vespid Strain Leader
		case "TAU|VESP|VESP|VSS": //Vespid Shadestrain
		case "TAU|VESP|VESP|WAR": //Vespid Warrior
			return GetTyranidName();

		// Tyranids - Brood Coven
		case "TYR|BC|AH|FTR": //Acolyte Hybrid Fighter
		case "TYR|BC|AH|GNR": //Acolyte Hybrid Gunner
		case "TYR|BC|AH|IB": //Acolyte Hybrid Icon Bearer
		case "TYR|BC|AH|LDR": //Acolyte Hybrid Leader
		case "TYR|BC|AH|TRP": //Acolyte Hybrid Trooper
		case "TYR|BC|HM|FTR": //Hybrid Metamorph Fighter
		case "TYR|BC|HM|GNR": //Hybrid Metamorph Gunner
		case "TYR|BC|HM|IB": //Hybrid Metamorph Icon Bearer
		case "TYR|BC|HM|LDR": //Hybrid Metamorph Leader
		case "TYR|BC|NH|GNR": //Neophyte Hybrid Gunner
		case "TYR|BC|NH|HGNR": //Neophyte Hybrid Heavy Gunner
		case "TYR|BC|NH|IB": //Neophyte Hybrid Icon Bearer
		case "TYR|BC|NH|LDR": //Neophyte Hybrid Leader
		case "TYR|BC|NH|TRP": //Neophyte Hybrid Trooper
		// Tyranids - Hive Fleet
		case "TYR|HF|GS|FTR": //Genestealer Fighter
		case "TYR|HF|GS|LDR": //Genestealer Leader
		case "TYR|HF|TS|HRM": //Hormagaunt
		case "TYR|HF|TS|TRM": //Termagant
		case "TYR|HF|TW|FTR": //Tyranid Warrior Fighter
		case "TYR|HF|TW|HGNR": //Tyranid Warrior Heavy Gunner
		case "TYR|HF|TW|LDR": //Tyranid Warrior Leader
			return GetTyranidName();
		case "TYR|BBRO|BBRO|CMDR": //Brood Brother Commander
		case "TYR|BBRO|BBRO|AGIT": //Brood Brother Agitator
		case "TYR|BBRO|BBRO|GNR": //Brood Brother Gunner
		case "TYR|BBRO|BBRO|ICNW": //Brood Brother Iconward
		case "TYR|BBRO|BBRO|KF": //Brood Brother Knife Fighter
		case "TYR|BBRO|BBRO|MDC": //Brood Brother Medic
		case "TYR|BBRO|BBRO|SAP": //Brood Brother Sapper
		case "TYR|BBRO|BBRO|SNP": //Brood Brother Sniper
		case "TYR|BBRO|BBRO|TRP": //Brood Brother Trooper
		case "TYR|BBRO|BBRO|VET": //Brood Brother Veteran
		case "TYR|BBRO|BBRO|VOX": //Brood Brother Vox Operator
		case "TYR|BBRO|BBRO|PF": //Psychic Familiar
			return GetTyranidName();
		case "TYR|BBRO|BBRO|MAG": //Magus
			return GetTyranidName();
		case "TYR|BBRO|BBRO|PRIM": //Primus
			return GetTyranidName();
		case "TYR|BBRO|BBRO|PAT": //Patriarch
			return GetTyranidName();
		case "TYR|BBRO|BBRO|TAC": //Tactical Assets
			return "Tactical Assets";

		// Hearthkyn Salvagers
		case "VOT|HKS|HKS|TH": //Hearthkyn Theyn
		case "VOT|HKS|HKS|DO": //Hearthkyn Dozr
		case "VOT|HKS|HKS|MDC": //Hearthkyn Field Medic
		case "VOT|HKS|HKS|GRN": //Hearthkyn Grenadier
		case "VOT|HKS|HKS|GNR": //Hearthkyn Gunner
		case "VOT|HKS|HKS|JMP": //Hearthkyn Jump Pack Warrior
		case "VOT|HKS|HKS|KL": //Hearthkyn Kinlynk
		case "VOT|HKS|HKS|KOG": //Hearthkyn Kognitaar
		case "VOT|HKS|HKS|LOK": //Hearthkyn Lokatr
		case "VOT|HKS|HKS|LUG": //Hearthkyn Lugger
		case "VOT|HKS|HKS|WAR": //Hearthkyn Warrior
			return GetHearthkynName();
		// Hernkyn Yaegir
		case "VOT|HKY|HKY|THEYN": //Yeagir Theyn
		case "VOT|HKY|HKY|BLD": //Yaegir Bladekyn
		case "VOT|HKY|HKY|BOMB": //Yaegir Bombast
		case "VOT|HKY|HKY|GNR": //Yaegir Gunner
		case "VOT|HKY|HKY|IRN": //Yaegir Ironbraek
		case "VOT|HKY|HKY|RFL": //Yaegir Riflekyn
		case "VOT|HKY|HKY|TRK": //Yaegir Tracker
		case "VOT|HKY|HKY|WAR": //Yaegir Warrior
			return GetHearthkynName();
	}

	// If we haven't returned yet, return a generic name
	return GetGenericName();
}

function GetGenericName()
{
	return GetHumanName();
}

function GetKasrkinName()
{
	$names = ["Jens", "Kasrk", "Otwin", "Hekler", "Reeve", "Pavlo", "Hektor", "Ogan", "Thenmann", "Kyser", "Erlen", "Raphe", "Creed", "Ackerman", "Mattias", "Mortens", "Dansk", "Feodor", "Tomas", "Kolson", "Vance", "Pask", "Niems", "Gryf", "Willem", "Sonnen", "Echter", "Farestein", "Dekker", "Graf", "Arvans", "Viers", "Kolm", "Bask", "Vesker", "Henker"];

	return $names[array_rand($names)];
}

function GetKrootName()
{
	$name0 = ["Kra", "Gohk", "Ahkra", "Dohra", "Cho", "Byakh", "Grahm", "Khor", "Ohrak", "Tehk", "Chok", "Khrek", "Tobok", "Obak", "Grark", "Byahm", "Doryc", "Te", "Khrob", "Jiynko", "Ahoc", "Obyn", "Anghor", "Avhra", "Yuka", "Doakh", "Byek", "Gho", "Lucu", "Tohra", "Dra", "Ahahk", "Gerba", "Alhar", "Bakor", "Tebek"];
	$name1 = ["'to", " Cha", "'ka", "'yo", " Grok", "'ah", "'ohk", " Ek", "'tcha", "", "'ya", " Ahk", " Ba", "'tcho", "'ke", " Ot", " Ak", "'hrakh", " Che", "'yc", " Khe", "", "'grahk", "'ab", "'cha", " Ohk", " Ye", "'grekh", " Da", "'gr", " Ekh", " Yo", "'eht", "", " Rek", "'tche"];
	$name2 = ["Gota", "Krrah", "Ch'choh", "Tohrrok", "Ga'ah", "Kyrek", "Ghorka", "Drr'rr", "Yo'toh", "Rhekk", "Prok", "Teleb", "Talar", "Pre'lek", "Yrr'dk", "Goba", "Ta'bak", "Ga'toh", "Yabek", "Cho'yar", "Rhehor", "Kaa'he", "Rrok", "Kyr'am", "Mebekh", "Batam", "Dyr'yn", "Gabt", "Krarh", "Yr'be", "Drekh", "Orak", "Caroch", "Akchan", "Trosk", "Belet"];

	return $name0[array_rand($name0)] . $name1[array_rand($name1)] . " " . $name2[array_rand($name2)];
}

function GetInqName()
{
	$name0 = ["Oarba", "Lucius", "Janus", "Hermes", "Elsine", "Delphan", "Lorphreen", "Logan", "Mirella", "Josef", "Hestia", "Konstantin", "Ketz", "Skordan", "Korvanna", "Damien", "Skyll", "Promeus", "Severina", "Markus", "Moriana", "Orten", "Shen Vey", "Voraddin", "Sevora", "Methuselah", "Ulena", "Jorgo", "Mhoraeth", "Mechsimus", "Yvesta", "Cornelius", "Edda", "Barreth", "Katja", "Gwillan"];
	$name1 = ["Barbaretta", "de Wolfe", "", "Kommodus", "The Devout", "Threlk", "The Unseen", "Gath", "Agnazy", "Octavium", "Monska", "Devlan", "Pelt", "Cadavore", "of Cell 23b", "Gruss", "The Merc Of Garrantos", "Jeddeck", "Grydd", "Malican", "du Pre", "Nosia", "Savanum", "Stontel", "Spinst", "Storm", "Dalstom", "Quovandis", "Kreel", "Khoriv", "Eskander", "Fank", "Lynden", "Skydekkerix", "Vespazha", "Oilrelius"];

	return $name0[array_rand($name0)] . " " . $name1[array_rand($name1)];
}

function GetChaosCultistName()
{
	$name0 = ["Borther", "Nhasc", "Dahlton", "Rafn", "Geffried", "Sahben", "Coyl", "Sister", "Morigan", "Kensha", "Ionys", "Zeytha", "Blessed", "Vorya", "Yacobe", "Neesh", "Korv", "Fuella", "Mikon", "Yuneth", "Nithani", "Sorena", "Corvinus", "Godsmarked", "Philo", "Oena", "Madrach", "Herjar", "Azimundas", "Nethfrid", "Norran", "Waldemar", "Scorl", "Yennick", "Xendenarius", "Deveen"];
	$name1 = ["Selver", "", "Gemmerhal", "Iskrit", "Kanter", "Krorne", "Zuphren", "Stannas", "Farnos", "Wurn", "Cadmas", "Drillix", "Nethix", "Sanlar", "Thrikk", "Crenbek", "Reyga", "Morswain", "The Coreclaw", "Nunaveil", "The Putrescent", "Negrani", "of the Scaled Eye", "Hrancik", "Slickstone", "Brenner", "Lors'el", "Voorsk", "Carlinus", "Dherka", "Sylinus", "Kobden", "Daevos", "Dhomass", "Kalark"];

	return $name0[array_rand($name0)] . " " . $name1[array_rand($name1)];
}

function GetAdMechName()
{
	$name0 = ["", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
	$name1 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name2 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name3 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name4 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name5 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name6 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
	$name7 = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
	$name8 = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
	$name9 = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
	$name10 = ["Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa", "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon", "Phi", "Chi", "Psi", "Omega"];
	$name11 = ["Alpha", "Beta", "Gamma", "Delta", "Epsilon", "Zeta", "Eta", "Theta", "Iota", "Kappa", "Lambda", "Mu", "Nu", "Xi", "Omicron", "Pi", "Rho", "Sigma", "Tau", "Upsilon", "Phi", "Chi", "Psi", "Omega"];

	// 1 Syllable
	$name12 = ["B", "C", "D", "G", "Gr", "Gw", "H", "J", "Jzz", "K", "Kr", "L", "M", "N", "Ph", "Pl", "Qv", "R", "Rh", "S", "T", "Th", "V", "X", "Y", "Z"];
	$name13 = ["ahr", "al", "an", "and", "ane", "arc", "arv", "aulk", "auss", "awl", "aym", "ea", "eard", "ei", "elt", "erg", "ess", "eth", "ex", "i", "ik", "ingh", "iv", "o", "ol", "oll", "or", "orght", "osch", "osk", "oth", "u", "ul", "und", "ure", "uss", "ux", "yrrc"];

	// 2 Syllables
	$name14 = ["Ad", "Adv", "Alsm", "Ar", "Arg", "Arkh", "Auk", "Aurgr", "Bess", "Caldr", "Call", "Cambr", "Carn", "Cass", "Char", "Cord", "Cum", "Cur", "Cyk", "Dal", "Damm", "Delph", "Dentr", "Drush", "Dur", "Eb", "Eg", "Eld", "Er", "Et", "Fried", "Gai", "Gall", "Gamm", "Garb", "Gast", "Gav", "Gredd", "Haph", "Herr", "Hy", "Ism", "Kelb", "Klayd", "Kol", "Kor", "Kot", "Kub", "Lak", "Lars", "Lav", "Lex", "Loc", "Lyrz", "Marl", "Modw", "Ner", "Nes", "Nex", "Nir", "Oct", "Ohmn", "Omn", "Os", "Osm", "Oud", "Ov", "Pan", "Pass", "Phaet", "Rask", "Rest", "Reyl", "Rhod", "Rol", "Ronr", "Sap", "Sas", "Sem", "Shur", "Son", "Tall", "Tayb", "Tel", "Tezl", "Them", "Threns", "Tilv", "Trag", "Trant", "Uix", "Vai", "Vak", "Varn", "Veltr", "Vett", "Vherr", "Vianc", "Volt", "Weyldr", "Xix", "Zab", "Zagr", "Zard", "Zhok", "Zyg"];
	$name15 = ["a", "ak", "al", "an", "and", "ane", "ank", "anx", "aph", "ard", "as", "ax", "eb", "eg", "ek", "ell", "en", "ene", "ent", "er", "eum", "eus", "ex", "ia", "ian", "ias", "id", "iel", "ien", "ik", "ike", "il", "in", "iom", "ion", "is", "isch", "ium", "ius", "ix", "o", "ode", "ok", "ol", "olph", "on", "ook", "or", "os", "ot", "ov", "owe", "u", "ul", "um", "us", "uul", "uv", "yon"];

	// 3 Syllables
	$name16 = ["Abb", "Aex", "Ald", "Alm", "Alph", "Balph", "Bell", "Ben", "Bet", "Borg", "Cerv", "Cort", "Cyc", "Cyth", "Danz", "Dec", "Deg", "Del", "Delt", "Diad", "Drac", "Drayk", "Eps", "Er", "Faust", "Fel", "Gel", "Ger", "Gerg", "Hed", "Held", "Herm", "Herst", "Hol", "Hyp", "Iap", "Ill", "Inf", "Ipl", "Khob", "Kor", "Krypt", "Laur", "Malth", "Mank", "Mass", "Max", "Mitr", "Moh", "Moj", "Om", "Orl", "Os", "Pal", "Prod", "Reg", "Rom", "Saph", "Sat", "Ser", "Sig", "Sol", "Tell", "Thass", "Ther", "Torqu", "Trim", "Urqu", "Val", "Vard", "Ver", "Veth", "Vidr", "Vitr", "Zod", "Zuh"];
	$name17 = ["ad", "aestr", "ag", "ak", "al", "all", "am", "an", "and", "andr", "ant", "ar", "asm", "at", "athr", "av", "ebr", "ed", "ej", "ekr", "ent", "er", "err", "esw", "et", "euk", "iat", "iatr", "ic", "id", "il", "ill", "im", "in", "ing", "ir", "is", "off", "om", "on", "or", "ot", "ovd", "ow", "ul", "ur", "urm", "ut", "uv"];
	$name18 = ["a", "ac", "ael", "ain", "al", "an", "ar", "ax", "ei", "el", "en", "er", "ex", "i", "ia", "iad", "ian", "iaz", "ict", "icz", "id", "ien", "in", "ine", "io", "ion", "is", "ius", "ix", "o", "on", "or", "os", "oth", "ov", "um", "us", "ust"];

	// 4 Syllables
	$name19 = ["Ak", "Ant", "Arc", "Bart", "Bel", "Daed", "Eyr", "Fed", "Ger", "Gif", "Hext", "Hier", "Iv", "Katr", "Ol", "Ozm"];
	$name20 = ["al", "asn", "eg", "ell", "erh", "err", "ig", "is", "og", "ol", "on", "or", "oth", "um"];
	$name21 = ["ad", "am", "ar", "in", "iv", "ol", "om", "on", "oph", "os", "ost", "ov", "ym"];
	$name22 = ["a", "ax", "ere", "ich", "il", "ion", "is", "ius", "o", "on", "or", "us"];

	$name31 = [" ", " ", " ", " ", " ", "-", " van ", " van der "];

	switch (rand(0, 19)) {
		case 0: //echo "0";
			return $name7[array_rand($name7)] . $name8[array_rand($name8)] . "-" . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 1: //echo "1";
			return $name10[array_rand($name10)] . " " . $name7[array_rand($name7)] . "-" . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 2: //echo "2";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . " " . $name7[array_rand($name7)] . $name8[array_rand($name8)] . "/" . $name9[array_rand($name9)] . " " . $name14[array_rand($name14)] . $name15[array_rand($name15)];
		case 3: //echo "3";
			return $name10[array_rand($name10)] . "-" . $name11[array_rand($name11)] . " " . $name7[array_rand($name7)] . $name8[array_rand($name8)];
		case 4: //echo "4";
			return $name1[array_rand($name1)] . "-" . $name2[array_rand($name2)] . " " . $name3[array_rand($name3)] . $name7[array_rand($name7)] . $name4[array_rand($name4)] . "/" . $name5[array_rand($name5)] . $name8[array_rand($name8)] . $name6[array_rand($name6)];
		case 5: //echo "5";
			return $name1[array_rand($name1)] . $name2[array_rand($name2)] . "-" . $name7[array_rand($name7)] . $name8[array_rand($name8)] . $name9[array_rand($name9)];
		case 6: //echo "6";
			return $name1[array_rand($name1)] . "-" . $name7[array_rand($name7)] . $name8[array_rand($name8)] . $name9[array_rand($name9)];
		case 7: //echo "7";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . "-" . $name10[array_rand($name10)] . "-" . $name7[array_rand($name7)];
		case 8: //echo "8";
			return $name12[array_rand($name12)] . $name13[array_rand($name13)] . $name31[array_rand($name31)] . $name14[array_rand($name14)] . $name15[array_rand($name15)];
		case 9: //echo "9";
			return $name12[array_rand($name12)] . $name13[array_rand($name13)] . " " . $name16[array_rand($name16)] . $name17[array_rand($name17)] . $name18[array_rand($name18)];
		case 10: //echo "10";
			return $name12[array_rand($name12)] . $name13[array_rand($name13)] . " " . $name19[array_rand($name19)] . $name20[array_rand($name20)] . $name21[array_rand($name21)] . $name22[array_rand($name22)];
		case 11: //echo "11";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . $name31[array_rand($name31)] . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 12: //echo "12";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . " " . $name16[array_rand($name16)] . $name17[array_rand($name17)] . $name18[array_rand($name18)];
		case 13: //echo "13";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . " " . $name19[array_rand($name19)] . $name20[array_rand($name20)] . $name21[array_rand($name21)] . $name22[array_rand($name22)];
		case 14: //echo "14";
			return $name16[array_rand($name16)] . $name17[array_rand($name17)] . $name18[array_rand($name18)] . $name31[array_rand($name31)] . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 15: //echo "15";
			return $name16[array_rand($name16)] . $name17[array_rand($name17)] . $name18[array_rand($name18)] . $name31[array_rand($name31)] . $name14[array_rand($name14)] . $name15[array_rand($name15)];
		case 16: //echo "16";
			return $name19[array_rand($name19)] . $name20[array_rand($name20)] . $name21[array_rand($name21)] . $name22[array_rand($name22)] . $name31[array_rand($name31)] . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 17: //echo "17";
			return $name19[array_rand($name19)] . $name20[array_rand($name20)] . $name21[array_rand($name21)] . $name22[array_rand($name22)] . $name31[array_rand($name31)] . $name14[array_rand($name14)] . $name15[array_rand($name15)];
		case 18: //echo "18";
			return $name14[array_rand($name14)] . $name15[array_rand($name15)] . " " . $name12[array_rand($name12)] . $name13[array_rand($name13)] . "-" . $name12[array_rand($name12)] . $name13[array_rand($name13)];
		case 19: //echo "19";
			return $name16[array_rand($name16)] . $name17[array_rand($name17)] . $name18[array_rand($name18)] . " " . $name12[array_rand($name12)] . $name13[array_rand($name13)] . "-" . $name12[array_rand($name12)] . $name13[array_rand($name13)];
	}
}

function GetBeastmenName()
{
	// Get a Space Marine name
	// From https://www.fantasynamegenerators.com/scripts/warhammerBeastmen.js
	// Gibberish first
	$gib1 = ["b", "d", "g", "gh", "k", "kn", "kh", "m", "n", "t", "th", "v", "z", "zh"];
	$gib2 = ["a", "o", "u", "a", "o", "u", "a", "o", "u", "a", "o", "u", "a", "o", "u", "e", "i", "e", "i", "au", "ao", "aa", "oo"];
	$gib3 = ["cr", "cn", "cc", "cv", "cth", "g", "gh", "gth", "gd", "gdh", "k", "kh", "kz", "kk", "kr", "kt", "kth", "l", "lg", "lgh", "lgr", "ltr", "lc", "n", "ng", "nk", "nc", "r", "rr", "rz", "rg", "rk", "rkr", "rgh", "rth", "zr", "zg", "zc", "zk", "zz"];
	$gib4 = ["c", "g", "k", "r", "x", "z"];

	// Descriptive second
	$desc1 = ["amber", "ashen", "battle", "bitter", "black", "blazing", "bleeding", "blood", "bright", "bristle", "broad", "brown", "chaos", "cinder", "dark", "dawn", "dead", "death", "ember", "fallen", "fiery", "fire", "flame", "frozen", "giant", "gloom", "gore", "grand", "gray", "great", "grim", "grizzly", "heavy", "hell", "iron", "keen", "lightning", "lone", "metal", "molten", "moon", "morning", "moss", "mountain", "nether", "night", "onyx", "plain", "proud", "pyre", "rage", "rapid", "rough", "rumble", "serpent", "shadow", "sharp", "shatter", "silent", "silver", "slug", "solid", "spring", "star", "steel", "stern", "stone", "storm", "strong", "swift", "thunder", "wild"];
	$desc2 = ["arm", "bane", "belly", "belt", "braid", "breath", "brow", "chest", "chin", "claw", "coat", "crest", "eye", "eyes", "fang", "fangs", "feet", "finger", "fingers", "fist", "foot", "gaze", "grip", "gut", "hair", "hand", "hands", "head", "heart", "hide", "jaw", "mane", "manes", "mantle", "maw", "mouth", "paw", "pelt", "ridge", "scar", "shoulder", "shoulders", "snout", "spine", "tail", "teeth", "toe", "toes", "tongue", "tooth", "wound"];

	// Now pick a "language" and build the name
	$language = rand(1, 2);

	switch ($language) {
		case 1:
			// Use a gibberish name
			return ucwords($gib1[array_rand($gib1)] . $gib2[array_rand($gib2)] . $gib3[array_rand($gib3)] . $gib2[array_rand($gib2)] . $gib4[array_rand($gib4)]);
		case 2:
			// Use a descriptive name
			return ucwords($desc1[array_rand($desc1)] . $desc2[array_rand($desc2)]);
	}
}
function GetName_Old_20220203()
{
	// Return a name for the requested faction
	$faid = $_REQUEST["factionid"];
	$ktid = $_REQUEST["killteamid"];
	$ftid = $_REQUEST["fireteamid"];
	$opid = $_REQUEST["opid"];

	$num = $_REQUEST["num"];

	if ($num == null || $num < 1 || $num > 100) {
		$num = 1;
	}

	switch ($faid) {
		case "AEL":
			switch ($ktid) {
				case "COM":
					switch ($ftid) {
						case "WYCH":
							return GetAeldariFemaleName();
						case "KBL":
							return GetAeldariMaleName();
					}
					break;
				case "CW":
					if (rand(0, 1) == 0) {
						return GetAeldariFemaleName();
					} else {
						return GetAeldariMaleName();
					}
			}
			break;
		case "IMP":
			switch ($ktid) {
				case "SM":
					return GetSpaceMarineName();
				case "ECC":
					switch ($ftid) {
						case "BS":
						case "REP":
							return GetSistersOfBattleName();
					}
					break;
				case "TOE":
					switch ($ftid) {
						case "CG":
							return GetSpaceMarineName();
						case "SOS":
							return GetSistersOfBattleName();
					}
			}
			break;
		case "CHAOS":
			switch ($ktid) {
				case "DG":
				case "CSM":
				case "TS":
					return GetChaosMarineName();
				case "DAEM":
					switch ($ftid) {
						case "DETTE":
							return GetDaemonetteName();
						case "BL":
						case "PB":
							return GetDaemonName();
					}
			}
			break;
		case "NEC":
			return GetNecronName();
		case "ORK":
			return GetOrkName();
		case "TAU":
			switch ($ktid) {
				case "SBS":
					return GetTauFireName();
			}
		case "TYR":
			return GetTyranidName();
	}

	// No matches found
	return "";
}

function GetDarkAeldariName()
{
	if (rand(0, 1) == 0) {
		return GetDarkAeldariFemaleName() . " " . GetDarkAeldariFemaleName();
	} else {
		return GetDarkAeldariMaleName() . " " . GetDarkAeldariMaleName();
	}
}

function GetDarkAeldariMaleName()
{
	$names3 = ["Aes", "Aezo", "Ahl", "Al'o", "Ar'us", "Ara", "Arqi", "Arze", "Ashru", "Baeh", "Baes", "Bahre", "Belze", "Besnu", "Bezha", "Bhi", "Bhra", "Bira", "Caren", "Cher", "Crehn", "Cri'ora", "Dehza", "Der", "Dera", "Drehz", "Ehz", "El'or", "Eraza", "Ezir", "Fehsa", "Fera", "Fha", "Fihr", "Frae", "Gae'en", "Gahnu", "Garia", "Gri", "Grihza", "Gura", "Iaze", "Ide'a", "Ire", "Iyes", "Izera", "Kaera", "Kahna", "Kehna", "Khel", "Kihre", "Lae'o", "Laerh", "Laeza", "Lanu", "Lohza", "Maero", "Meha", "Mera", "Meri", "Mero'a", "Mesra", "Mihza", "Ohza", "Ora", "Ora'i", "Ori", "Oriqa", "Taza", "Teha", "Tera", "Trezh", "Yna", "Yr'a", "Yzi"];
	$names4 = ["baehra", "brique", "bris", "brynn", "daque", "dera", "deza", "dhae", "dove", "dreos", "gahne", "geza", "gohne", "grynn", "gwyss", "heque", "hia", "hira", "keo", "keri", "kryss", "kysse", "maque", "mare", "mea", "mehra", "mirenne", "mohre", "myss", "naehr", "nahra", "neque", "neza", "nyrr", "qinn", "qore", "rae", "raesh", "reah", "reaq", "renar", "renn", "resse", "rihque", "rith", "riza", "rizora", "runae", "saer", "sarihs", "seos", "seqe", "seth", "sher", "shi", "sira", "syrr", "taena", "taez", "tarin", "teque", "thara", "thera", "tihr", "tyhs", "vaesh", "velle", "vero", "vynn", "zae", "zaehn", "zhael", "zhenne", "zoh", "zysh"];

	return $names3[array_rand($names3)] . $names4[array_rand($names4)];
}

function GetDarkAeldariFemaleName()
{
	$names1 = ["Aes", "Ar'o", "Ar'ug", "Arh", "Arma", "Arqa", "Arzo", "Arzur", "Asdru", "Bahr", "Bahru", "Baze", "Bazha", "Bernu", "Bhu", "Bra", "Braes", "Bura", "Caen", "Char", "Cra'oza", "Crahl", "Daza", "Dra", "Draz", "Duhr", "El'ur", "Erza", "Ez", "Ezar", "Fahar", "Fahr", "Fhars", "Frae", "Fure", "Ga'on", "Gahu", "Gara", "Gra", "Griza", "Gura", "Id'ar", "Iru", "Iys", "Izen", "Izra", "Kae", "Kahar", "Kahr", "Khan", "Kyra", "Laerh", "Lahza", "Laku", "Laza", "Le'u", "Maru", "Masra", "Mazro", "Meza", "Mo'u", "Much", "Muri", "Or'i", "Ori", "Orqa", "Oura", "Ozu", "Taga", "Tah", "Teza", "Trazh", "Yl'a", "Yra", "Yzu"];
	$names2 = ["baehr", "bran", "braq", "bros", "bryn", "dazar", "dhar", "diaq", "dovur", "dros", "durin", "gahn", "gard", "gran", "grath", "hiron", "his", "hyque", "kei", "kos", "kras", "kyth", "mahr", "maq", "mar", "mass", "mien", "moque", "mor", "naer", "nahr", "nazar", "neque", "nyr", "qar", "qir", "ra", "rad", "raes", "ras", "rath", "raz", "riaq", "rihz", "rior", "rizar", "ruin", "ryq", "sar", "sarith", "saros", "sath", "shar", "sque", "stra", "syr", "tahr", "taz", "teque", "thara", "tharn", "tiron", "tyhr", "tzar", "vall", "van", "vhar", "vor", "vyn", "zaen", "zaq", "zhan", "zhar", "zon", "zyth"];

	return $names1[array_rand($names1)] . $names2[array_rand($names2)];
}

function GetAeldariName()
{
	if (rand(0, 1) == 0) {
		return GetAeldariFemaleName() . " " . GetAeldariFemaleName();
	} else {
		return GetAeldariMaleName() . " " . GetAeldariMaleName();
	}
}

function GetAeldariMaleName()
{
	$names3 = ["Al", "Am", "Amo", "Amon", "Ar", "Arag", "Arg", "Arro", "Asur", "Bahar", "Bale", "Bar", "Bara", "Baran", "Bel", "Bele", "Bene", "Bore", "Caen", "Caer", "Caera", "Cal", "Dal", "Dara", "Don", "Dun", "El", "Elam", "Elra", "Esar", "Faen", "Fan", "Far", "For", "Fue", "Gala", "Galan", "Gil", "Gilfa", "Gon", "Gul", "Idra", "Idran", "Iril", "Ise", "Isen", "Kae", "Kal", "Karan", "Kay", "Kel", "Lae", "Lan", "Lau", "Len", "Lo", "Mach", "Mau", "Men", "Mene", "Mener", "Mor", "Morro", "Ola", "On", "Ora", "Oro", "Osu", "Tae", "Tal", "Tan", "Ten", "Yl", "Yra", "Ysu"];
	$names4 = ["baer", "ban", "bas", "bryn", "byn", "davar", "deer", "dor", "drad", "dras", "duin", "gan", "gard", "gen", "groth", "hidon", "hith", "hyn", "kas", "kin", "kon", "kyn", "las", "lath", "leath", "leth", "lim", "lion", "lon", "lyth", "maer", "mar", "mas", "men", "mes", "mon", "more", "naer", "nar", "nedor", "nel", "nyl", "rad", "ran", "ranel", "rendil", "rian", "riel", "rion", "rith", "ros", "roth", "ruin", "rys", "saar", "san", "seith", "sen", "seth", "shin", "shor", "sys", "tar", "tari", "telar", "thanil", "tharal", "thorn", "tien", "tyr", "van", "var", "vel", "vor", "vyn"];

	return $names3[array_rand($names3)] . $names4[array_rand($names4)];
}

function GetAeldariFemaleName()
{
	$names1 = ["Al", "Aem", "Ami", "Aeme", "Ali", "Ara", "Aris", "Arre", "Ashe", "Baha", "Bela", "Baer", "Baera", "Balan", "Bel", "Baele", "Behne", "Bore", "Caen", "Cela", "Caella", "Cel", "Dil", "Dera", "Den", "Daen", "El", "Ela", "Elra", "Elsar", "Faen", "Fen", "Fir", "Fo", "Fae", "Gela", "Gellan", "Gil", "Gilsa", "Gen", "Gil", "Ilra", "Ilro", "Irli", "Ise", "Isen", "Kae", "Khel", "Kaera", "Kay", "Kel", "Lae", "Lana", "Lae", "Len", "Li", "Mes", "Mae", "Mena", "Mene", "Menel", "Meh", "Mello", "Ola", "One", "Ore", "Osi", "Oasa", "Tae", "Tel", "Taphe", "Ten", "Yl", "Yna", "Yse"];
	$names2 = ["bala", "benne", "bera", "brae", "bryn", "daen", "daer", "dole", "dona", "dra", "dynn", "gil", "gith", "gren", "gwen", "hina", "hish", "hynn", "kae", "keza", "kia", "kra", "laeth", "lara", "leth", "lira", "lith", "lone", "lya", "lyth", "mae", "mela", "mena", "mere", "mia", "myn", "myna", "nae", "nel", "nelle", "nera", "nys", "rana", "raniel", "rena", "ria", "riel", "rio", "ris", "rith", "rosa", "rye", "ryna", "rys", "sa", "sae", "sela", "shae", "sho", "sis", "sya", "sys", "tara", "tela", "tera", "thala", "thanis", "tiren", "tyra", "tys", "vae", "vara", "vela", "vena", "vyss"];

	return $names1[array_rand($names1)] . $names2[array_rand($names2)];
}

function GetDaemonetteName()
{
	$names3 = ["Aes", "Aezo", "Ahl", "Al'o", "Ar'us", "Ara", "Arqi", "Arze", "Ashru", "Baeh", "Baes", "Bahre", "Belze", "Besnu", "Bezha", "Bhi", "Bhra", "Bira", "Caren", "Cher", "Crehn", "Cri'ora", "Dehza", "Der", "Dera", "Drehz", "Ehz", "El'or", "Eraza", "Ezir", "Fehsa", "Fera", "Fha", "Fihr", "Frae", "Gae'en", "Gahnu", "Garia", "Gri", "Grihza", "Gura", "Iaze", "Ide'a", "Ire", "Iyes", "Izera", "Kaera", "Kahna", "Kehna", "Khel", "Kihre", "Lae'o", "Laerh", "Laeza", "Lanu", "Lohza", "Maero", "Meha", "Mera", "Meri", "Mero'a", "Mesra", "Mihza", "Ohza", "Ora", "Ora'i", "Ori", "Oriqa", "Taza", "Teha", "Tera", "Trezh", "Yna", "Yr'a", "Yzi"];
	$names4 = ["baehra", "brique", "bris", "brynn", "daque", "dera", "deza", "dhae", "dove", "dreos", "gahne", "geza", "gohne", "grynn", "gwyss", "heque", "hia", "hira", "keo", "keri", "kryss", "kysse", "maque", "mare", "mea", "mehra", "mirenne", "mohre", "myss", "naehr", "nahra", "neque", "neza", "nyrr", "qinn", "qore", "rae", "raesh", "reah", "reaq", "renar", "renn", "resse", "rihque", "rith", "riza", "rizora", "runae", "saer", "sarihs", "seos", "seqe", "seth", "sher", "shi", "sira", "syrr", "taena", "taez", "tarin", "teque", "thara", "thera", "tihr", "tyhs", "vaesh", "velle", "vero", "vynn", "zae", "zaehn", "zhael", "zhenne", "zoh", "zysh"];

	return $names3[array_rand($names3)] . $names4[array_rand($names4)];
}

function GetDaemonName()
{
	$names1 = ["Aes", "Ar'o", "Ar'ug", "Arh", "Arma", "Arqa", "Arzo", "Arzur", "Asdru", "Bahr", "Bahru", "Baze", "Bazha", "Bernu", "Bhu", "Bra", "Braes", "Bura", "Caen", "Char", "Cra'oza", "Crahl", "Daza", "Dra", "Draz", "Duhr", "El'ur", "Erza", "Ez", "Ezar", "Fahar", "Fahr", "Fhars", "Frae", "Fure", "Ga'on", "Gahu", "Gara", "Gra", "Griza", "Gura", "Id'ar", "Iru", "Iys", "Izen", "Izra", "Kae", "Kahar", "Kahr", "Khan", "Kyra", "Laerh", "Lahza", "Laku", "Laza", "Le'u", "Maru", "Masra", "Mazro", "Meza", "Mo'u", "Much", "Muri", "Or'i", "Ori", "Orqa", "Oura", "Ozu", "Taga", "Tah", "Teza", "Trazh", "Yl'a", "Yra", "Yzu"];
	$names2 = ["baehr", "bran", "braq", "bros", "bryn", "dazar", "dhar", "diaq", "dovur", "dros", "durin", "gahn", "gard", "gran", "grath", "hiron", "his", "hyque", "kei", "kos", "kras", "kyth", "mahr", "maq", "mar", "mass", "mien", "moque", "mor", "naer", "nahr", "nazar", "neque", "nyr", "qar", "qir", "ra", "rad", "raes", "ras", "rath", "raz", "riaq", "rihz", "rior", "rizar", "ruin", "ryq", "sar", "sarith", "saros", "sath", "shar", "sque", "stra", "syr", "tahr", "taz", "teque", "thara", "tharn", "tiron", "tyhr", "tzar", "vall", "van", "vhar", "vor", "vyn", "zaen", "zaq", "zhan", "zhar", "zon", "zyth"];

	return $names1[array_rand($names1)] . $names2[array_rand($names2)];
}

function GetHearthkynName()
{
	//Last names first
	$ln1 = ["amber", "autumn", "battle", "bear", "bitter", "black", "blunt", "boulder", "brane", "bright", "brittle", "broad", "broken", "bronze", "brown", "cask", "cinder", "cliff", "coal", "cold", "common", "copper", "crag", "deep", "distant", "ember", "far", "fiery", "fire", "flame", "flat", "flint", "forge", "full", "fuse", "gold", "golden", "grand", "granite", "gray", "great", "grim", "grudge", "grumble", "hammer", "hill", "ingot", "iron", "keen", "keg", "krag", "lead", "light", "magma", "merry", "metal", "mild", "mirth", "mithril", "mountain", "noble", "onyx", "plain", "proud", "regal", "rich", "rock", "rough", "rumble", "shatter", "silver", "slender", "solid", "steel", "stone", "storm", "stout", "strong", "thunder", "true"];
	$ln2 = ["arm", "armor", "armour", "axe", "back", "basher", "beam", "beard", "bearer", "belly", "belt", "bender", "bluff", "bone", "bough", "brace", "branch", "brand", "breaker", "brew", "brewer", "bringer", "brow", "buckle", "buster", "chaser", "chest", "chin", "cloak", "crag", "crest", "digger", "dreamer", "feet", "finger", "fire", "fist", "fists", "flame", "foot", "force", "forge", "forged", "fury", "grip", "grog", "guard", "gut", "hammer", "hand", "hank", "head", "heart", "helm", "keeper", "maker", "mantle", "mark", "master", "might", "more", "punch", "rage", "seeker", "shaper", "shield", "shoulder", "shout", "strength", "strider", "striker", "surge", "sworn", "thane", "walker", "ward"];

	// First names second
	$fn1 = ["", "", "", "br", "d", "dr", "g", "gr", "kh", "kr", "m", "n", "r", "s", "sr", "str", "th", "tr", "thr", "v", "z", "b", "bh", "c", "d", "dr", "g", "gh", "h", "m", "n", "s", "sk", "sc", "t", "th", "v", "z", "zh"];
	$fn2 = ["a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "au", "ai", "oa", "ao", "e", "i", "u", "e", "i", "u", "e", "i", "u", "e", "i", "u", "a", "a", "o", "o"];
	$fn3 = ["d", "g", "k", "l", "r", "th", "d", "g", "k", "l", "r", "th", "br", "d", "dh", "dr", "g", "gr", "gh", "gn", "gm", "gz", "gd", "k", "kr", "l", "lb", "ld", "lg", "lgr", "ldr", "nd", "ng", "nr", "ndr", "ngr", "r", "rd", "rdr", "rg", "rt", "rbr", "rb", "rgr", "th", "tr", "thr", "br", "dr", "dg", "dw", "dd", "ff", "fr", "gr", "gw", "gn", "gm", "gf", "gv", "kk", "kh", "kr", "kv", "lg", "lgr", "lv", "ng", "ngr", "ngw", "nd", "ndw", "ndr", "rg", "rgr", "rgw", "rw", "rz", "sg", "sgr", "sv", "th", "tr", "tv", "thr", "vr"];
	$fn4 = ["c", "d", "g", "gg", "k", "m", "mm", "n", "r", "rd", "t", "", "", "", "", "", "d", "h", "m", "n", "t"];

	return ucwords($fn1[array_rand($fn1)] . $fn2[array_rand($fn2)] . $fn3[array_rand($fn3)] . $fn2[array_rand($fn2)] . $fn4[array_rand($fn4)] . " " . $ln1[array_rand($ln1)] . $ln2[array_rand($ln2)]);
}

function GetHumanName()
{
	if (rand(0, 3) == 0) {
		return GetHumanFemaleName();
	} else {
		return GetHumanMaleName();
	}
}

function GetHumanFemaleName()
{
	$FN = [
		"Ada",
		"Addie",
		"Adeline",
		"Agnes",
		"Alberta",
		"Alice",
		"Allie",
		"Alma",
		"Alta",
		"Amanda",
		"Amelia",
		"Amy",
		"Anita",
		"Ann",
		"Anna",
		"Anne",
		"Annie",
		"Antoinette",
		"Arlene",
		"Audrey",
		"Barbara",
		"Beatrice",
		"Bernice",
		"Bertha",
		"Bessie",
		"Bette",
		"Bettie",
		"Betty",
		"Beulah",
		"Beverly",
		"Billie",
		"Blanche",
		"Bonnie",
		"Carol",
		"Caroline",
		"Carolyn",
		"Carrie",
		"Catherine",
		"Cecelia",
		"Celia",
		"Charlotte",
		"Christine",
		"Claire",
		"Clara",
		"Cleo",
		"Constance",
		"Cora",
		"Daisy",
		"Della",
		"Delores",
		"Dolores",
		"Donna",
		"Dora",
		"Doris",
		"Dorothea",
		"Dorothy",
		"Edith",
		"Edna",
		"Effie",
		"Eileen",
		"Elaine",
		"Eleanor",
		"Eliza",
		"Elizabeth",
		"Ella",
		"Ellen",
		"Eloise",
		"Elsie",
		"Elva",
		"Emily",
		"Emma",
		"Erma",
		"Essie",
		"Estella",
		"Estelle",
		"Esther",
		"Ethel",
		"Etta",
		"Eula",
		"Eunice",
		"Eva",
		"Evelyn",
		"Fannie",
		"Faye",
		"Fern",
		"Flora",
		"Florence",
		"Flossie",
		"Frances",
		"Freda",
		"Frieda",
		"Geneva",
		"Genevieve",
		"Georgia",
		"Geraldine",
		"Gertrude",
		"Gladys",
		"Gloria",
		"Goldie",
		"Grace",
		"Hannah",
		"Harriet",
		"Hattie",
		"Hazel",
		"Helen",
		"Henrietta",
		"Hilda",
		"Ida",
		"Imogene",
		"Ina",
		"Inez",
		"Irene",
		"Irma",
		"Isabel",
		"Isabelle",
		"Iva",
		"Jacqueline",
		"Jane",
		"Janet",
		"Janice",
		"Janie",
		"Jean",
		"Jeanette",
		"Jeanne",
		"Jeannette",
		"Jennie",
		"Jessie",
		"Joan",
		"Johnnie",
		"Josephine",
		"Joyce",
		"Juanita",
		"Julia",
		"June",
		"Katherine",
		"Kathleen",
		"Kathryn",
		"Katie",
		"Laura",
		"Laverne",
		"Lela",
		"Lena",
		"Leola",
		"Leona",
		"Lila",
		"Lillian",
		"Lillie",
		"Lizzie",
		"Lois",
		"Lola",
		"Lorene",
		"Loretta",
		"Lorraine",
		"Lottie",
		"Louise",
		"Lucile",
		"Lucille",
		"Lucy",
		"Luella",
		"Lula",
		"Lydia",
		"Mabel",
		"Mable",
		"Madeline",
		"Mae",
		"Maggie",
		"Mamie",
		"Marcella",
		"Margaret",
		"Margie",
		"Marguerite",
		"Maria",
		"Marian",
		"Marie",
		"Marilyn",
		"Marion",
		"Marjorie",
		"Martha",
		"Mary",
		"Matilda",
		"Mattie",
		"Maude",
		"Maxine",
		"May",
		"Mildred",
		"Minnie",
		"Miriam",
		"Mollie",
		"Muriel",
		"Myrtle",
		"Nancy",
		"Nannie",
		"Naomi",
		"Nell",
		"Nellie",
		"Nettie",
		"Nina",
		"Nora",
		"Norma",
		"Ola",
		"Olga",
		"Olive",
		"Ollie",
		"Opal",
		"Ora",
		"Patricia",
		"Pauline",
		"Pearl",
		"Peggy",
		"Phyllis",
		"Rachel",
		"Rebecca",
		"Regina",
		"Rita",
		"Roberta",
		"Rosa",
		"Rosalie",
		"Rose",
		"Rosemary",
		"Rosie",
		"Ruby",
		"Ruth",
		"Sadie",
		"Sallie",
		"Sally",
		"Sara",
		"Sarah",
		"Shirley",
		"Sophia",
		"Sophie",
		"Stella",
		"Susan",
		"Susie",
		"Sylvia",
		"Thelma",
		"Theresa",
		"Velma",
		"Vera",
		"Verna",
		"Veronica",
		"Victoria",
		"Viola",
		"Violet",
		"Virgie",
		"Virginia",
		"Vivian",
		"Wanda",
		"Willie",
		"Wilma",
		"Winifred",
		"Agnes",
		"Alberta",
		"Alice",
		"Alma",
		"Andrea",
		"Angela",
		"Anita",
		"Ann",
		"Anna",
		"Anne",
		"Annette",
		"Annie",
		"Arlene",
		"Audrey",
		"Barbara",
		"Beatrice",
		"Bernice",
		"Bertha",
		"Bessie",
		"Betty",
		"Beverly",
		"Billie",
		"Bobbie",
		"Bonnie",
		"Brenda",
		"Carol",
		"Carole",
		"Caroline",
		"Carolyn",
		"Carrie",
		"Catherine",
		"Cathy",
		"Charlene",
		"Charlotte",
		"Cheryl",
		"Christine",
		"Claire",
		"Clara",
		"Claudia",
		"Connie",
		"Constance",
		"Cora",
		"Cynthia",
		"Daisy",
		"Darlene",
		"Deanna",
		"Deborah",
		"Delores",
		"Diana",
		"Diane",
		"Dianne",
		"Dolores",
		"Donna",
		"Dora",
		"Doris",
		"Dorothy",
		"Edith",
		"Edna",
		"Eileen",
		"Elaine",
		"Eleanor",
		"Elizabeth",
		"Ella",
		"Ellen",
		"Elsie",
		"Emily",
		"Emma",
		"Erma",
		"Esther",
		"Ethel",
		"Eunice",
		"Eva",
		"Evelyn",
		"Fannie",
		"Faye",
		"Florence",
		"Frances",
		"Gail",
		"Gayle",
		"Geneva",
		"Genevieve",
		"Georgia",
		"Geraldine",
		"Gertrude",
		"Gladys",
		"Glenda",
		"Gloria",
		"Grace",
		"Gwendolyn",
		"Harriet",
		"Hattie",
		"Hazel",
		"Helen",
		"Hilda",
		"Ida",
		"Irene",
		"Jackie",
		"Jacqueline",
		"Jane",
		"Janet",
		"Janice",
		"Janie",
		"Janis",
		"Jean",
		"Jeanette",
		"Jeanne",
		"Jeannette",
		"Jennie",
		"Jessie",
		"Jill",
		"Jo",
		"Joan",
		"Joann",
		"Joanne",
		"Johnnie",
		"Josephine",
		"Joy",
		"Joyce",
		"Juanita",
		"Judith",
		"Judy",
		"Julia",
		"Julie",
		"June",
		"Karen",
		"Katherine",
		"Kathleen",
		"Kathryn",
		"Kathy",
		"Kay",
		"Laura",
		"Lena",
		"Leona",
		"Leslie",
		"Lillian",
		"Lillie",
		"Linda",
		"Lois",
		"Lola",
		"Loretta",
		"Lorraine",
		"Louise",
		"Lucille",
		"Lucy",
		"Lula",
		"Lynda",
		"Lynn",
		"Lynne",
		"Mae",
		"Marcia",
		"Margaret",
		"Margie",
		"Marguerite",
		"Maria",
		"Marian",
		"Marianne",
		"Marie",
		"Marilyn",
		"Marion",
		"Marjorie",
		"Marlene",
		"Marsha",
		"Martha",
		"Mary",
		"Maryann",
		"Mattie",
		"Maureen",
		"Maxine",
		"Michele",
		"Mildred",
		"Minnie",
		"Myrna",
		"Myrtle",
		"Nancy",
		"Naomi",
		"Nellie",
		"Nina",
		"Norma",
		"Pamela",
		"Pat",
		"Patricia",
		"Patsy",
		"Patty",
		"Paula",
		"Paulette",
		"Pauline",
		"Pearl",
		"Peggy",
		"Penny",
		"Phyllis",
		"Priscilla",
		"Rachel",
		"Ramona",
		"Rebecca",
		"Regina",
		"Rita",
		"Roberta",
		"Rosa",
		"Rosalie",
		"Rose",
		"Rosemarie",
		"Rosemary",
		"Rosie",
		"Ruby",
		"Ruth",
		"Sally",
		"Sandra",
		"Sara",
		"Sarah",
		"Sharon",
		"Sheila",
		"Sherry",
		"Shirley",
		"Stella",
		"Stephanie",
		"Sue",
		"Susan",
		"Suzanne",
		"Sylvia",
		"Teresa",
		"Terry",
		"Thelma",
		"Theresa",
		"Valerie",
		"Velma",
		"Vera",
		"Verna",
		"Veronica",
		"Vicki",
		"Victoria",
		"Viola",
		"Violet",
		"Virginia",
		"Vivian",
		"Wanda",
		"Willie",
		"Wilma",
		"Yvonne",
		"Alice",
		"Alicia",
		"Amanda",
		"Amy",
		"Andrea",
		"Angela",
		"Anita",
		"Ann",
		"Anna",
		"Anne",
		"Annette",
		"Annie",
		"April",
		"Arlene",
		"Audrey",
		"Barbara",
		"Becky",
		"Belinda",
		"Beth",
		"Betty",
		"Beverly",
		"Bonnie",
		"Brenda",
		"Carla",
		"Carmen",
		"Carol",
		"Carole",
		"Carolyn",
		"Carrie",
		"Catherine",
		"Cathy",
		"Charlene",
		"Charlotte",
		"Cheryl",
		"Christina",
		"Christine",
		"Cindy",
		"Claudia",
		"Colleen",
		"Connie",
		"Constance",
		"Crystal",
		"Cynthia",
		"Dana",
		"Darlene",
		"Dawn",
		"Deanna",
		"Debbie",
		"Deborah",
		"Debra",
		"Delores",
		"Denise",
		"Diana",
		"Diane",
		"Dianne",
		"Dolores",
		"Donna",
		"Doreen",
		"Doris",
		"Dorothy",
		"Eileen",
		"Elaine",
		"Elizabeth",
		"Ellen",
		"Eva",
		"Evelyn",
		"Felicia",
		"Frances",
		"Gail",
		"Gayle",
		"Geraldine",
		"Gina",
		"Glenda",
		"Gloria",
		"Grace",
		"Gwendolyn",
		"Heather",
		"Heidi",
		"Helen",
		"Holly",
		"Irene",
		"Jackie",
		"Jacqueline",
		"Jamie",
		"Jan",
		"Jane",
		"Janet",
		"Janice",
		"Janis",
		"Jean",
		"Jeanette",
		"Jeanne",
		"Jennifer",
		"Jill",
		"Jo",
		"Joan",
		"Joann",
		"Joanne",
		"Jodi",
		"Jody",
		"Josephine",
		"Joy",
		"Joyce",
		"Juanita",
		"Judith",
		"Judy",
		"Julia",
		"Julie",
		"June",
		"Karen",
		"Karla",
		"Katherine",
		"Kathleen",
		"Kathryn",
		"Kathy",
		"Kay",
		"Kelly",
		"Kim",
		"Kimberly",
		"Kristen",
		"Kristin",
		"Kristine",
		"Laura",
		"Laurie",
		"Leslie",
		"Lillian",
		"Linda",
		"Lisa",
		"Lois",
		"Loretta",
		"Lori",
		"Lorraine",
		"Louise",
		"Lynda",
		"Lynn",
		"Lynne",
		"Marcia",
		"Margaret",
		"Maria",
		"Marianne",
		"Marie",
		"Marilyn",
		"Marjorie",
		"Marlene",
		"Marsha",
		"Martha",
		"Mary",
		"Maureen",
		"Melanie",
		"Melinda",
		"Melissa",
		"Melody",
		"Michele",
		"Michelle",
		"Mildred",
		"Monica",
		"Nancy",
		"Natalie",
		"Nicole",
		"Norma",
		"Pam",
		"Pamela",
		"Patricia",
		"Patsy",
		"Patti",
		"Patty",
		"Paula",
		"Peggy",
		"Penny",
		"Phyllis",
		"Rachel",
		"Rebecca",
		"Regina",
		"Renee",
		"Rhonda",
		"Rita",
		"Roberta",
		"Robin",
		"Rosa",
		"Rose",
		"Rosemary",
		"Roxanne",
		"Ruby",
		"Ruth",
		"Sally",
		"Sandra",
		"Sandy",
		"Sara",
		"Sarah",
		"Shannon",
		"Shari",
		"Sharon",
		"Sheila",
		"Shelia",
		"Shelley",
		"Shelly",
		"Sheri",
		"Sherri",
		"Sherry",
		"Sheryl",
		"Shirley",
		"Sonya",
		"Stacey",
		"Stacy",
		"Stephanie",
		"Sue",
		"Susan",
		"Suzanne",
		"Sylvia",
		"Tamara",
		"Tami",
		"Tammie",
		"Tammy",
		"Tanya",
		"Teresa",
		"Terri",
		"Terry",
		"Theresa",
		"Tina",
		"Toni",
		"Tonya",
		"Tracey",
		"Traci",
		"Tracy",
		"Valerie",
		"Vanessa",
		"Veronica",
		"Vicki",
		"Vickie",
		"Vicky",
		"Victoria",
		"Virginia",
		"Vivian",
		"Wanda",
		"Wendy",
		"Yolanda",
		"Yvette",
		"Yvonne",
		"Abigail",
		"Adrienne",
		"Aimee",
		"Alexandra",
		"Alexis",
		"Alicia",
		"Alisha",
		"Alison",
		"Allison",
		"Alyssa",
		"Amanda",
		"Amber",
		"Amy",
		"Ana",
		"Andrea",
		"Angel",
		"Angela",
		"Angelica",
		"Angie",
		"Anita",
		"Ann",
		"Anna",
		"Anne",
		"Annette",
		"April",
		"Ashlee",
		"Ashley",
		"Audrey",
		"Autumn",
		"Barbara",
		"Becky",
		"Beth",
		"Bethany",
		"Bonnie",
		"Brandi",
		"Brandy",
		"Brenda",
		"Brianna",
		"Bridget",
		"Brittany",
		"Brittney",
		"Brooke",
		"Caitlin",
		"Candace",
		"Candice",
		"Carla",
		"Carmen",
		"Carol",
		"Caroline",
		"Carolyn",
		"Carrie",
		"Casey",
		"Cassandra",
		"Cassie",
		"Catherine",
		"Cathy",
		"Chelsea",
		"Cheryl",
		"Christie",
		"Christina",
		"Christine",
		"Christy",
		"Cindy",
		"Claudia",
		"Colleen",
		"Connie",
		"Courtney",
		"Cristina",
		"Crystal",
		"Cynthia",
		"Dana",
		"Danielle",
		"Dawn",
		"Deanna",
		"Deborah",
		"Debra",
		"Denise",
		"Desiree",
		"Diana",
		"Diane",
		"Dominique",
		"Donna",
		"Ebony",
		"Elizabeth",
		"Emily",
		"Erica",
		"Erika",
		"Erin",
		"Felicia",
		"Gina",
		"Gloria",
		"Hannah",
		"Heather",
		"Heidi",
		"Holly",
		"Jaclyn",
		"Jacqueline",
		"Jaime",
		"Jamie",
		"Janet",
		"Janice",
		"Jasmine",
		"Jeanette",
		"Jenna",
		"Jennifer",
		"Jenny",
		"Jessica",
		"Jill",
		"Jillian",
		"Joanna",
		"Jodi",
		"Jody",
		"Jordan",
		"Joy",
		"Julia",
		"Julie",
		"Kara",
		"Karen",
		"Kari",
		"Katelyn",
		"Katherine",
		"Kathleen",
		"Kathryn",
		"Kathy",
		"Katie",
		"Katrina",
		"Kayla",
		"Kelli",
		"Kellie",
		"Kelly",
		"Kelsey",
		"Kendra",
		"Kerri",
		"Kerry",
		"Kim",
		"Kimberly",
		"Krista",
		"Kristen",
		"Kristi",
		"Kristie",
		"Kristin",
		"Kristina",
		"Kristine",
		"Kristy",
		"Krystal",
		"Lacey",
		"Latasha",
		"Latoya",
		"Laura",
		"Lauren",
		"Laurie",
		"Leah",
		"Leslie",
		"Linda",
		"Lindsay",
		"Lindsey",
		"Lisa",
		"Lori",
		"Lynn",
		"Mallory",
		"Mandy",
		"Margaret",
		"Maria",
		"Marie",
		"Marissa",
		"Martha",
		"Mary",
		"Meagan",
		"Megan",
		"Meghan",
		"Melanie",
		"Melinda",
		"Melissa",
		"Meredith",
		"Michele",
		"Michelle",
		"Mindy",
		"Miranda",
		"Misty",
		"Molly",
		"Monica",
		"Monique",
		"Morgan",
		"Nancy",
		"Natalie",
		"Natasha",
		"Nichole",
		"Nicole",
		"Nina",
		"Olivia",
		"Pamela",
		"Patricia",
		"Paula",
		"Priscilla",
		"Rachael",
		"Rachel",
		"Rebecca",
		"Rebekah",
		"Regina",
		"Renee",
		"Rhonda",
		"Robin",
		"Robyn",
		"Ruth",
		"Sabrina",
		"Samantha",
		"Sandra",
		"Sara",
		"Sarah",
		"Shannon",
		"Sharon",
		"Shawna",
		"Sheena",
		"Sheila",
		"Shelley",
		"Shelly",
		"Sheri",
		"Sherri",
		"Sherry",
		"Sonia",
		"Sonya",
		"Stacey",
		"Stacie",
		"Stacy",
		"Stefanie",
		"Stephanie",
		"Susan",
		"Suzanne",
		"Tabitha",
		"Tamara",
		"Tammy",
		"Tanya",
		"Tara",
		"Tasha",
		"Taylor",
		"Teresa",
		"Terri",
		"Theresa",
		"Tiffany",
		"Tina",
		"Toni",
		"Tonya",
		"Tracey",
		"Traci",
		"Tracie",
		"Tracy",
		"Tricia",
		"Valerie",
		"Vanessa",
		"Veronica",
		"Victoria",
		"Virginia",
		"Wanda",
		"Wendy",
		"Whitney",
		"Yolanda",
		"Yvonne",
		"Aaliyah",
		"Abby",
		"Abigail",
		"Addison",
		"Adriana",
		"Adrianna",
		"Alana",
		"Alejandra",
		"Alexa",
		"Alexandra",
		"Alexandria",
		"Alexia",
		"Alexis",
		"Alicia",
		"Alison",
		"Allison",
		"Alondra",
		"Alyssa",
		"Amanda",
		"Amber",
		"Amelia",
		"Amy",
		"Ana",
		"Andrea",
		"Angel",
		"Angela",
		"Angelica",
		"Angelina",
		"Anna",
		"April",
		"Ariana",
		"Arianna",
		"Ariel",
		"Ashlee",
		"Ashley",
		"Ashlyn",
		"Aubrey",
		"Audrey",
		"Autumn",
		"Ava",
		"Avery",
		"Bailey",
		"Bethany",
		"Bianca",
		"Brandi",
		"Brandy",
		"Breanna",
		"Brenda",
		"Briana",
		"Brianna",
		"Brittany",
		"Brittney",
		"Brooke",
		"Brooklyn",
		"Caitlin",
		"Caitlyn",
		"Camila",
		"Carly",
		"Caroline",
		"Casey",
		"Cassandra",
		"Cassidy",
		"Catherine",
		"Charlotte",
		"Chelsea",
		"Chelsey",
		"Cheyenne",
		"Chloe",
		"Christina",
		"Christine",
		"Cindy",
		"Claire",
		"Claudia",
		"Courtney",
		"Crystal",
		"Cynthia",
		"Daisy",
		"Dana",
		"Daniela",
		"Danielle",
		"Deanna",
		"Delaney",
		"Desiree",
		"Destiny",
		"Diamond",
		"Diana",
		"Dominique",
		"Elizabeth",
		"Ella",
		"Ellie",
		"Emily",
		"Emma",
		"Erica",
		"Erika",
		"Erin",
		"Eva",
		"Evelyn",
		"Faith",
		"Felicia",
		"Gabriela",
		"Gabriella",
		"Gabrielle",
		"Genesis",
		"Gianna",
		"Gina",
		"Giselle",
		"Grace",
		"Gracie",
		"Hailey",
		"Haley",
		"Hannah",
		"Hayley",
		"Heather",
		"Holly",
		"Hope",
		"Isabel",
		"Isabella",
		"Isabelle",
		"Jacqueline",
		"Jada",
		"Jade",
		"Jamie",
		"Jasmin",
		"Jasmine",
		"Jayla",
		"Jazmin",
		"Jenna",
		"Jennifer",
		"Jessica",
		"Jillian",
		"Joanna",
		"Jocelyn",
		"Jordan",
		"Jordyn",
		"Julia",
		"Juliana",
		"Julie",
		"Kaitlin",
		"Kaitlyn",
		"Kara",
		"Karen",
		"Karina",
		"Kate",
		"Katelyn",
		"Katherine",
		"Kathleen",
		"Kathryn",
		"Katie",
		"Katrina",
		"Kayla",
		"Kaylee",
		"Kelly",
		"Kelsey",
		"Kendall",
		"Kendra",
		"Kennedy",
		"Kiara",
		"Kimberly",
		"Kirsten",
		"Krista",
		"Kristen",
		"Kristin",
		"Kristina",
		"Krystal",
		"Kylee",
		"Kylie",
		"Laura",
		"Lauren",
		"Layla",
		"Leah",
		"Leslie",
		"Liliana",
		"Lillian",
		"Lilly",
		"Lily",
		"Lindsay",
		"Lindsey",
		"Lisa",
		"Lucy",
		"Lydia",
		"Mackenzie",
		"Madeline",
		"Madelyn",
		"Madison",
		"Makayla",
		"Makenzie",
		"Mallory",
		"Margaret",
		"Maria",
		"Mariah",
		"Marisa",
		"Marissa",
		"Mary",
		"Maya",
		"Mckenzie",
		"Meagan",
		"Megan",
		"Meghan",
		"Melanie",
		"Melissa",
		"Mercedes",
		"Mia",
		"Michaela",
		"Michelle",
		"Mikayla",
		"Miranda",
		"Molly",
		"Monica",
		"Monique",
		"Morgan",
		"Mya",
		"Nancy",
		"Naomi",
		"Natalia",
		"Natalie",
		"Natasha",
		"Nevaeh",
		"Nicole",
		"Olivia",
		"Paige",
		"Patricia",
		"Payton",
		"Peyton",
		"Rachael",
		"Rachel",
		"Raven",
		"Reagan",
		"Rebecca",
		"Rebekah",
		"Riley",
		"Ruby",
		"Rylee",
		"Sabrina",
		"Sadie",
		"Samantha",
		"Sandra",
		"Sara",
		"Sarah",
		"Savannah",
		"Selena",
		"Serenity",
		"Shannon",
		"Shelby",
		"Sierra",
		"Skylar",
		"Sofia",
		"Sophia",
		"Sophie",
		"Stephanie",
		"Summer",
		"Sydney",
		"Tara",
		"Taylor",
		"Tiffany",
		"Trinity",
		"Valeria",
		"Valerie",
		"Vanessa",
		"Veronica",
		"Victoria",
		"Whitney",
		"Yesenia",
		"Zoe",
		"Zoey"
	];

	$LN = ["Abbott", "Adams", "Adkins", "Aguirre", "Albert", "Alexander", "Alford", "Allen", "Allison", "Alston", "Anderson", "Andrews", "Anthony", "Armstrong", "Arnold", "Ashley", "Atkins", "Atkinson", "Austin", "Avery", "Bailey", "Baird", "Baker", "Baldwin", "Ball", "Ballard", "Banks", "Barber", "Barker", "Barlow", "Barnes", "Barnett", "Barr", "Barrera", "Barrett", "Barron", "Barry", "Bartlett", "Barton", "Bass", "Bates", "Battle", "Bauer", "Baxter", "Beach", "Bean", "Beard", "Beasley", "Beck", "Becker", "Bell", "Bender", "Benjamin", "Bennett", "Benson", "Bentley", "Benton", "Berg", "Berger", "Bernard", "Berry", "Best", "Bird", "Bishop", "Black", "Blackburn", "Blackwell", "Blair", "Blake", "Blanchard", "Blankenship", "Blevins", "Bolton", "Bond", "Bonner", "Booker", "Boone", "Booth", "Bowen", "Bowers", "Bowman", "Boyd", "Boyer", "Boyle", "Bradford", "Bradley", "Bradshaw", "Brady", "Branch", "Bray", "Brennan", "Brewer", "Bridges", "Briggs", "Bright", "Britt", "Brock", "Brooks", "Brown", "Browning", "Bruce", "Bryan", "Bryant", "Buck", "Buckley", "Buckner", "Bullock", "Burch", "Burgess", "Burke", "Burks", "Burnett", "Burns", "Burris", "Burt", "Burton", "Bush", "Butler", "Byers", "Byrd", "Cain", "Calderon", "Caldwell", "Callahan", "Cameron", "Campbell", "Cannon", "Carey", "Carlson", "Carney", "Carpenter", "Carr", "Carson", "Carter", "Carver", "Case", "Casey", "Cash", "Chambers", "Chandler", "Chaney", "Chapman", "Charles", "Chase", "Cherry", "Christensen", "Christian", "Church", "Clark", "Clarke", "Clay", "Clayton", "Clements", "Clemons", "Cleveland", "Cline", "Cobb", "Coffey", "Cohen", "Cole", "Coleman", "Collier", "Collins", "Colon", "Combs", "Compton", "Conley", "Conner", "Conrad", "Conway", "Cook", "Cooke", "Cooley", "Cooper", "Copeland", "Cotton", "Cox", "Craft", "Craig", "Crane", "Crawford", "Crosby", "Cross", "Cummings", "Cunningham", "Curry", "Curtis", "Dale", "Dalton", "Daniel", "Daniels", "Daugherty", "Davenport", "David", "Davidson", "Davis", "Dawson", "Day", "Dean", "Decker", "Dickerson", "Dickson", "Dillard", "Dillon", "Dixon", "Donaldson", "Donovan", "Dorsey", "Dotson", "Douglas", "Downs", "Doyle", "Drake", "Dudley", "Duffy", "Duke", "Duncan", "Dunn", "Duran", "Durham", "Dyer", "Eaton", "Edwards", "Elliott", "Ellis", "Ellison", "Emerson", "England", "English", "Erickson", "Evans", "Everett", "Ewing", "Farley", "Farmer", "Farrell", "Faulkner", "Ferguson", "Ferrell", "Fields", "Finch", "Finley", "Fischer", "Fisher", "Fleming", "Fletcher", "Flores", "Flowers", "Floyd", "Flynn", "Foley", "Forbes", "Ford", "Foreman", "Foster", "Fowler", "Fox", "Francis", "Franco", "Frank", "Franklin", "Franks", "Frazier", "Frederick", "Freeman", "French", "Frost", "Fry", "Frye", "Fuller", "Fulton", "Gaines", "Gallagher", "Gallegos", "Galloway", "Gamble", "Gardner", "Garner", "Garrett", "Garrison", "Gates", "Gay", "Gentry", "George", "Gibbs", "Gibson", "Gilbert", "Giles", "Gill", "Gilliam", "Gilmore", "Glass", "Glenn", "Glover", "Goff", "Golden", "Good", "Goodman", "Goodwin", "Gordon", "Graham", "Grant", "Graves", "Gray", "Green", "Greene", "Greer", "Gregory", "Griffin", "Griffith", "Grimes", "Gross", "Guy", "Hale", "Haley", "Hall", "Hamilton", "Hammond", "Hampton", "Hancock", "Haney", "Hansen", "Hanson", "Hardin", "Harding", "Hardy", "Harmon", "Harper", "Harrell", "Harrington", "Harris", "Harrison", "Hart", "Hartman", "Harvey", "Hatfield", "Hawkins", "Hayden", "Hayes", "Haynes", "Hays", "Head", "Heath", "Hebert", "Henderson", "Hendricks", "Hendrix", "Henry", "Hensley", "Henson", "Herman", "Herring", "Hess", "Hester", "Hewitt", "Hickman", "Hicks", "Higgins", "Hill", "Hines", "Hinton", "Hobbs", "Hodge", "Hodges", "Hoffman", "Hogan", "Holcomb", "Holden", "Holder", "Holland", "Holloway", "Holman", "Holmes", "Holt", "Hood", "Hooper", "Hoover", "Hopkins", "Hopper", "Horn", "Horne", "Horton", "House", "Houston", "Howard", "Howe", "Howell", "Hubbard", "Huber", "Hudson", "Huff", "Huffman", "Hughes", "Hull", "Humphrey", "Hunt", "Hunter", "Hurley", "Hurst", "Hutchinson", "Hyde", "Irwin", "Jackson", "Jacobs", "Jacobson", "James", "Jarvis", "Jefferson", "Jenkins", "Jennings", "Jensen", "Johns", "Johnson", "Johnston", "Jones", "Jordan", "Joseph", "Joyce", "Justice", "Kane", "Keith", "Keller", "Kelley", "Kelly", "Kennedy", "Kent", "Key", "Kidd", "King", "Kirby", "Kirk", "Kirkland", "Knight", "Knowles", "Knox", "Koch", "Kramer", "Lamb", "Lambert", "Lancaster", "Landry", "Lane", "Lang", "Langley", "Lara", "Larsen", "Larson", "Lawrence", "Lawson", "Leon", "Leonard", "Lester", "Levine", "Levy", "Lewis", "Lindsay", "Lindsey", "Little", "Livingston", "Lloyd", "Logan", "Long", "Lopez", "Lott", "Love", "Lowe", "Lowery", "Lucas", "Luna", "Lynch", "Lynn", "Lyons", "Macdonald", "Mack", "Madden", "Maddox", "Maldonado", "Malone", "Mann", "Manning", "Marks", "Marsh", "Marshall", "Martin", "Mason", "Massey", "Mathews", "Mathis", "Matthews", "Maxwell", "May", "Mayer", "Maynard", "Mays", "McBride", "McCall", "McCarthy", "McCarty", "McClain", "McClure", "McConnell", "McCormick", "McCoy", "McCray", "McCullough", "McDaniel", "McDonald", "McDowell", "McFadden", "McFarland", "McGee", "McGowan", "McGuire", "McIntosh", "McIntyre", "McKay", "McKee", "McKenzie", "McKinney", "McKnight", "McLaughlin", "McLean", "McLeod", "McMahon", "McMillan", "McNeil", "McPherson", "Meadows", "Medina", "Melton", "Mercer", "Merrill", "Merritt", "Meyer", "Meyers", "Michael", "Middleton", "Miles", "Miller", "Mills", "Miranda", "Mitchell", "Monroe", "Montgomery", "Moody", "Moon", "Mooney", "Moore", "Moran", "Morgan", "Morin", "Morris", "Morrison", "Morrow", "Morse", "Morton", "Moses", "Mosley", "Moss", "Mueller", "Mullen", "Mullins", "Murphy", "Murray", "Myers", "Nash", "Navarro", "Neal", "Nelson", "Newman", "Newton", "Nichols", "Nicholson", "Nielsen", "Nixon", "Noble", "Noel", "Nolan", "Norman", "Norris", "Norton", "O'Brien", "O'Connor", "O'Donnell", "O'Neal", "O'Neil", "O'Neill", "Oliver", "Olsen", "Olson", "Ortega", "Ortiz", "Osborn", "Osborne", "Owen", "Owens", "Pace", "Page", "Palmer", "Park", "Parker", "Parks", "Parrish", "Parsons", "Patrick", "Patterson", "Patton", "Paul", "Payne", "Pearson", "Peck", "Pena", "Pennington", "Perkins", "Perry", "Peters", "Petersen", "Peterson", "Phelps", "Phillips", "Pickett", "Pierce", "Pittman", "Pitts", "Pollard", "Poole", "Pope", "Porter", "Potter", "Potts", "Powell", "Powers", "Pratt", "Preston", "Price", "Prince", "Puckett", "Quinn", "Ramsey", "Randall", "Randolph", "Ray", "Raymond", "Reed", "Reese", "Reeves", "Reid", "Reilly", "Reyes", "Reynolds", "Rhodes", "Rich", "Richard", "Richards", "Richardson", "Richmond", "Riddle", "Riggs", "Riley", "Rivera", "Rivers", "Roach", "Robbins", "Roberson", "Roberts", "Robertson", "Robinson", "Robles", "Rodgers", "Rogers", "Rollins", "Rose", "Ross", "Roth", "Rowe", "Rowland", "Roy", "Rush", "Russell", "Ryan", "Sampson", "Sanders", "Sanford", "Sargent", "Saunders", "Savage", "Sawyer", "Scott", "Sears", "Sellers", "Serrano", "Sexton", "Shaffer", "Shannon", "Sharp", "Sharpe", "Shaw", "Shelton", "Shepard", "Shepherd", "Sheppard", "Sherman", "Shields", "Short", "Simmons", "Simon", "Simpson", "Sims", "Singleton", "Skinner", "Slater", "Sloan", "Small", "Smith", "Snider", "Snow", "Snyder", "Sparks", "Spears", "Spence", "Spencer", "Stafford", "Stanley", "Stanton", "Stark", "Steele", "Stein", "Stephens", "Stephenson", "Stevens", "Stevenson", "Stewart", "Stokes", "Stone", "Stout", "Strickland", "Strong", "Stuart", "Sullivan", "Summers", "Sutton", "Swanson", "Sweeney", "Sweet", "Sykes", "Talley", "Tanner", "Tate", "Taylor", "Terrell", "Terry", "Thomas", "Thompson", "Thornton", "Tillman", "Todd", "Townsend", "Travis", "Tucker", "Turner", "Tyler", "Tyson", "Underwood", "Vaughan", "Vaughn", "Vincent", "Vinson", "Wade", "Wagner", "Walker", "Wall", "Wallace", "Waller", "Walls", "Walsh", "Walter", "Walters", "Walton", "Ward", "Ware", "Warner", "Warren", "Washington", "Waters", "Watkins", "Watson", "Watts", "Weaver", "Webb", "Weber", "Webster", "Weeks", "Wells", "West", "Wheeler", "Whitaker", "White", "Whitehead", "Whitfield", "Whitley", "Whitney", "Wiggins", "Wilcox", "Wilder", "Wiley", "Wilkerson", "Wilkins", "Wilkinson", "William", "Williams", "Williamson", "Willis", "Wilson", "Winters", "Wise", "Witt", "Wolf", "Wolfe", "Wood", "Woodard", "Woods", "Woodward", "Workman", "Wright", "Wyatt", "Yates", "York", "Young"];

	return $FN[array_rand($FN)] . " " . $LN[array_rand($LN)];
}

function GetHumanMaleName()
{
	$FN = [
		"Aaron",
		"Abraham",
		"Adam",
		"Adolph",
		"Alan",
		"Albert",
		"Alex",
		"Alexander",
		"Alfred",
		"Allan",
		"Allen",
		"Alton",
		"Alvin",
		"Amos",
		"Andrew",
		"Angelo",
		"Anthony",
		"Antonio",
		"Archie",
		"Arnold",
		"Arthur",
		"August",
		"Ben",
		"Benjamin",
		"Bennie",
		"Bernard",
		"Bert",
		"Bill",
		"Billie",
		"Billy",
		"Bob",
		"Bobby",
		"Bruce",
		"Calvin",
		"Carl",
		"Cecil",
		"Charles",
		"Charley",
		"Charlie",
		"Chester",
		"Clarence",
		"Claude",
		"Clayton",
		"Clifford",
		"Clifton",
		"Clinton",
		"Clyde",
		"Cornelius",
		"Curtis",
		"Dale",
		"Dan",
		"Daniel",
		"Dave",
		"David",
		"Dean",
		"Delbert",
		"Dennis",
		"Dewey",
		"Don",
		"Donald",
		"Douglas",
		"Duane",
		"Earl",
		"Earnest",
		"Ed",
		"Eddie",
		"Edgar",
		"Edmund",
		"Edward",
		"Edwin",
		"Elbert",
		"Ellis",
		"Elmer",
		"Emil",
		"Emmett",
		"Ernest",
		"Ervin",
		"Eugene",
		"Everett",
		"Felix",
		"Floyd",
		"Forrest",
		"Francis",
		"Frank",
		"Franklin",
		"Fred",
		"Frederick",
		"Gene",
		"George",
		"Gerald",
		"Gilbert",
		"Glen",
		"Glenn",
		"Gordon",
		"Guy",
		"Harold",
		"Harry",
		"Harvey",
		"Henry",
		"Herbert",
		"Herman",
		"Homer",
		"Horace",
		"Howard",
		"Hubert",
		"Hugh",
		"Ira",
		"Irvin",
		"Irving",
		"Isaac",
		"Ivan",
		"Jack",
		"Jacob",
		"Jake",
		"James",
		"Jay",
		"Jerome",
		"Jerry",
		"Jesse",
		"Jessie",
		"Jim",
		"Jimmie",
		"Jimmy",
		"Joe",
		"John",
		"Johnie",
		"Johnnie",
		"Johnny",
		"Jose",
		"Joseph",
		"Juan",
		"Julian",
		"Julius",
		"Junior",
		"Karl",
		"Keith",
		"Kenneth",
		"Larry",
		"Lawrence",
		"Lee",
		"Leland",
		"Leo",
		"Leon",
		"Leonard",
		"Leroy",
		"Leslie",
		"Lester",
		"Lewis",
		"Lloyd",
		"Lonnie",
		"Louis",
		"Lowell",
		"Luther",
		"Lyle",
		"Mack",
		"Manuel",
		"Marion",
		"Mark",
		"Marshall",
		"Martin",
		"Marvin",
		"Matthew",
		"Maurice",
		"Max",
		"Melvin",
		"Merle",
		"Michael",
		"Mike",
		"Milton",
		"Morris",
		"Nathan",
		"Nathaniel",
		"Nelson",
		"Nicholas",
		"Nick",
		"Norman",
		"Oliver",
		"Ollie",
		"Orville",
		"Oscar",
		"Otis",
		"Otto",
		"Patrick",
		"Paul",
		"Percy",
		"Perry",
		"Pete",
		"Peter",
		"Philip",
		"Phillip",
		"Ralph",
		"Ray",
		"Raymond",
		"Richard",
		"Robert",
		"Roger",
		"Roland",
		"Ronald",
		"Roosevelt",
		"Roscoe",
		"Roy",
		"Rudolph",
		"Rufus",
		"Russell",
		"Salvatore",
		"Sam",
		"Samuel",
		"Sidney",
		"Stanley",
		"Stephen",
		"Steve",
		"Sylvester",
		"Ted",
		"Theodore",
		"Thomas",
		"Tom",
		"Tony",
		"Vernon",
		"Victor",
		"Vincent",
		"Virgil",
		"Wallace",
		"Walter",
		"Warren",
		"Wayne",
		"Wesley",
		"Wilbert",
		"Wilbur",
		"Wilfred",
		"Will",
		"Willard",
		"William",
		"Willie",
		"Willis",
		"Wilson",
		"Woodrow",
		"Alan",
		"Albert",
		"Alex",
		"Alfred",
		"Allan",
		"Allen",
		"Alton",
		"Alvin",
		"Andrew",
		"Anthony",
		"Archie",
		"Arnold",
		"Arthur",
		"Barry",
		"Ben",
		"Benjamin",
		"Bennie",
		"Benny",
		"Bernard",
		"Bill",
		"Billie",
		"Billy",
		"Bob",
		"Bobby",
		"Brian",
		"Bruce",
		"Calvin",
		"Carl",
		"Carroll",
		"Cecil",
		"Charles",
		"Charlie",
		"Chester",
		"Christopher",
		"Clarence",
		"Claude",
		"Clayton",
		"Clifford",
		"Clifton",
		"Clinton",
		"Clyde",
		"Craig",
		"Curtis",
		"Dale",
		"Dan",
		"Daniel",
		"Danny",
		"Darrell",
		"Dave",
		"David",
		"Dean",
		"Delbert",
		"Dennis",
		"Dick",
		"Don",
		"Donald",
		"Donnie",
		"Douglas",
		"Duane",
		"Dwight",
		"Earl",
		"Earnest",
		"Eddie",
		"Edgar",
		"Edward",
		"Edwin",
		"Elmer",
		"Eric",
		"Ernest",
		"Eugene",
		"Everett",
		"Floyd",
		"Francis",
		"Frank",
		"Franklin",
		"Fred",
		"Freddie",
		"Frederick",
		"Fredrick",
		"Garry",
		"Gary",
		"Gene",
		"George",
		"Gerald",
		"Gilbert",
		"Glen",
		"Glenn",
		"Gordon",
		"Gregory",
		"Guy",
		"Harold",
		"Harry",
		"Harvey",
		"Henry",
		"Herbert",
		"Herman",
		"Homer",
		"Horace",
		"Howard",
		"Hubert",
		"Hugh",
		"Jack",
		"Jackie",
		"James",
		"Jay",
		"Jeffrey",
		"Jerome",
		"Jerry",
		"Jesse",
		"Jessie",
		"Jim",
		"Jimmie",
		"Jimmy",
		"Joe",
		"Joel",
		"John",
		"Johnnie",
		"Johnny",
		"Jon",
		"Jonathan",
		"Jose",
		"Joseph",
		"Juan",
		"Junior",
		"Karl",
		"Keith",
		"Kenneth",
		"Kent",
		"Kevin",
		"Larry",
		"Lawrence",
		"Lee",
		"Leo",
		"Leon",
		"Leonard",
		"Leroy",
		"Leslie",
		"Lester",
		"Lewis",
		"Lloyd",
		"Lonnie",
		"Louis",
		"Lowell",
		"Luther",
		"Lyle",
		"Lynn",
		"Manuel",
		"Marion",
		"Mark",
		"Marshall",
		"Martin",
		"Marvin",
		"Matthew",
		"Maurice",
		"Max",
		"Melvin",
		"Michael",
		"Micheal",
		"Mike",
		"Milton",
		"Morris",
		"Nathaniel",
		"Neil",
		"Nelson",
		"Nicholas",
		"Norman",
		"Oliver",
		"Oscar",
		"Otis",
		"Patrick",
		"Paul",
		"Peter",
		"Philip",
		"Phillip",
		"Ralph",
		"Randall",
		"Randy",
		"Ray",
		"Raymond",
		"Richard",
		"Robert",
		"Rodney",
		"Roger",
		"Roland",
		"Ronald",
		"Ronnie",
		"Roosevelt",
		"Roy",
		"Rudolph",
		"Russell",
		"Salvatore",
		"Sam",
		"Sammy",
		"Samuel",
		"Scott",
		"Sidney",
		"Stanley",
		"Stephen",
		"Steve",
		"Steven",
		"Stuart",
		"Ted",
		"Terry",
		"Theodore",
		"Thomas",
		"Timothy",
		"Tom",
		"Tommy",
		"Tony",
		"Vernon",
		"Victor",
		"Vincent",
		"Virgil",
		"Wallace",
		"Walter",
		"Warren",
		"Wayne",
		"Wendell",
		"Wesley",
		"Wilbur",
		"Willard",
		"William",
		"Willie",
		"Willis",
		"Aaron",
		"Adam",
		"Alan",
		"Albert",
		"Alexander",
		"Alfred",
		"Allan",
		"Allen",
		"Alvin",
		"Andre",
		"Andrew",
		"Anthony",
		"Antonio",
		"Arnold",
		"Arthur",
		"Barry",
		"Benjamin",
		"Bernard",
		"Bill",
		"Billy",
		"Bob",
		"Bobby",
		"Brad",
		"Bradley",
		"Brent",
		"Brett",
		"Brian",
		"Bruce",
		"Bryan",
		"Calvin",
		"Carl",
		"Carlos",
		"Chad",
		"Charles",
		"Charlie",
		"Chris",
		"Christopher",
		"Clarence",
		"Clifford",
		"Clyde",
		"Craig",
		"Curtis",
		"Dale",
		"Dan",
		"Dana",
		"Daniel",
		"Danny",
		"Darin",
		"Darrell",
		"Darren",
		"Darryl",
		"Daryl",
		"Dave",
		"David",
		"Dean",
		"Dennis",
		"Derek",
		"Derrick",
		"Don",
		"Donald",
		"Donnie",
		"Douglas",
		"Duane",
		"Dwayne",
		"Dwight",
		"Earl",
		"Eddie",
		"Edward",
		"Edwin",
		"Eric",
		"Erik",
		"Ernest",
		"Eugene",
		"Floyd",
		"Francis",
		"Frank",
		"Franklin",
		"Fred",
		"Freddie",
		"Frederick",
		"Garry",
		"Gary",
		"Gene",
		"George",
		"Gerald",
		"Gerard",
		"Gilbert",
		"Glen",
		"Glenn",
		"Gordon",
		"Greg",
		"Gregg",
		"Gregory",
		"Guy",
		"Harold",
		"Harry",
		"Harvey",
		"Henry",
		"Herbert",
		"Herman",
		"Howard",
		"Jack",
		"Jackie",
		"James",
		"Jason",
		"Jay",
		"Jeff",
		"Jeffery",
		"Jeffrey",
		"Jerome",
		"Jerry",
		"Jesse",
		"Jim",
		"Jimmie",
		"Jimmy",
		"Joe",
		"Joel",
		"John",
		"Johnnie",
		"Johnny",
		"Jon",
		"Jonathan",
		"Jose",
		"Joseph",
		"Juan",
		"Karl",
		"Keith",
		"Kelly",
		"Kenneth",
		"Kent",
		"Kerry",
		"Kevin",
		"Kim",
		"Kirk",
		"Kurt",
		"Kyle",
		"Lance",
		"Larry",
		"Lawrence",
		"Lee",
		"Leo",
		"Leon",
		"Leonard",
		"Leroy",
		"Leslie",
		"Lester",
		"Lewis",
		"Lloyd",
		"Lonnie",
		"Louis",
		"Luis",
		"Lynn",
		"Manuel",
		"Marc",
		"Marcus",
		"Mark",
		"Martin",
		"Marvin",
		"Matthew",
		"Maurice",
		"Melvin",
		"Michael",
		"Micheal",
		"Mike",
		"Milton",
		"Mitchell",
		"Nathan",
		"Neil",
		"Nicholas",
		"Norman",
		"Patrick",
		"Paul",
		"Perry",
		"Peter",
		"Philip",
		"Phillip",
		"Ralph",
		"Randall",
		"Randolph",
		"Randy",
		"Ray",
		"Raymond",
		"Reginald",
		"Rex",
		"Richard",
		"Rick",
		"Rickey",
		"Ricky",
		"Robert",
		"Robin",
		"Rodney",
		"Roger",
		"Ronald",
		"Ronnie",
		"Roy",
		"Russell",
		"Samuel",
		"Scott",
		"Sean",
		"Shane",
		"Shawn",
		"Stanley",
		"Stephen",
		"Steve",
		"Steven",
		"Stuart",
		"Ted",
		"Terry",
		"Theodore",
		"Thomas",
		"Tim",
		"Timothy",
		"Todd",
		"Tom",
		"Tommy",
		"Tony",
		"Tracy",
		"Troy",
		"Tyrone",
		"Vernon",
		"Victor",
		"Vincent",
		"Walter",
		"Warren",
		"Wayne",
		"Wesley",
		"William",
		"Willie",
		"Aaron",
		"Adam",
		"Adrian",
		"Alan",
		"Albert",
		"Alejandro",
		"Alex",
		"Alexander",
		"Allen",
		"Andre",
		"Andrew",
		"Angel",
		"Anthony",
		"Antonio",
		"Arthur",
		"Austin",
		"Barry",
		"Benjamin",
		"Billy",
		"Blake",
		"Bobby",
		"Brad",
		"Bradley",
		"Brandon",
		"Brendan",
		"Brent",
		"Brett",
		"Brian",
		"Bruce",
		"Bryan",
		"Caleb",
		"Calvin",
		"Cameron",
		"Carl",
		"Carlos",
		"Casey",
		"Chad",
		"Charles",
		"Chase",
		"Chris",
		"Christian",
		"Christopher",
		"Clayton",
		"Clifford",
		"Clinton",
		"Cody",
		"Colin",
		"Corey",
		"Cory",
		"Craig",
		"Curtis",
		"Dale",
		"Damon",
		"Daniel",
		"Danny",
		"Darrell",
		"Darren",
		"David",
		"Dean",
		"Dennis",
		"Derek",
		"Derrick",
		"Devin",
		"Donald",
		"Douglas",
		"Drew",
		"Duane",
		"Dustin",
		"Dwayne",
		"Dylan",
		"Eddie",
		"Edward",
		"Edwin",
		"Eric",
		"Erik",
		"Ernest",
		"Eugene",
		"Evan",
		"Fernando",
		"Francisco",
		"Frank",
		"Frederick",
		"Gabriel",
		"Garrett",
		"Gary",
		"Geoffrey",
		"George",
		"Gerald",
		"Glenn",
		"Grant",
		"Gregory",
		"Harold",
		"Harry",
		"Hector",
		"Henry",
		"Howard",
		"Ian",
		"Isaac",
		"Jack",
		"Jacob",
		"Jaime",
		"James",
		"Jamie",
		"Jared",
		"Jason",
		"Javier",
		"Jay",
		"Jeff",
		"Jeffery",
		"Jeffrey",
		"Jeremiah",
		"Jeremy",
		"Jermaine",
		"Jerome",
		"Jerry",
		"Jesse",
		"Jesus",
		"Jimmy",
		"Joe",
		"Joel",
		"John",
		"Johnathan",
		"Johnny",
		"Jon",
		"Jonathan",
		"Jonathon",
		"Jordan",
		"Jorge",
		"Jose",
		"Joseph",
		"Joshua",
		"Juan",
		"Julian",
		"Justin",
		"Keith",
		"Kelly",
		"Kenneth",
		"Kevin",
		"Kristopher",
		"Kurt",
		"Kyle",
		"Lance",
		"Larry",
		"Lawrence",
		"Lee",
		"Leonard",
		"Logan",
		"Louis",
		"Lucas",
		"Luis",
		"Luke",
		"Manuel",
		"Marc",
		"Marcus",
		"Mario",
		"Mark",
		"Martin",
		"Marvin",
		"Mathew",
		"Matthew",
		"Maurice",
		"Melvin",
		"Michael",
		"Micheal",
		"Miguel",
		"Mitchell",
		"Nathan",
		"Nathaniel",
		"Neil",
		"Nicholas",
		"Omar",
		"Oscar",
		"Patrick",
		"Paul",
		"Peter",
		"Philip",
		"Phillip",
		"Ralph",
		"Randall",
		"Randy",
		"Raymond",
		"Reginald",
		"Ricardo",
		"Richard",
		"Ricky",
		"Robert",
		"Roberto",
		"Rodney",
		"Roger",
		"Ronald",
		"Ronnie",
		"Ross",
		"Roy",
		"Ruben",
		"Russell",
		"Ryan",
		"Samuel",
		"Scott",
		"Sean",
		"Sergio",
		"Seth",
		"Shane",
		"Shannon",
		"Shaun",
		"Shawn",
		"Spencer",
		"Stanley",
		"Stephen",
		"Steve",
		"Steven",
		"Taylor",
		"Terrance",
		"Terrence",
		"Terry",
		"Theodore",
		"Thomas",
		"Timothy",
		"Todd",
		"Tommy",
		"Tony",
		"Tracy",
		"Travis",
		"Trevor",
		"Troy",
		"Tyler",
		"Tyrone",
		"Victor",
		"Vincent",
		"Walter",
		"Wayne",
		"Wesley",
		"William",
		"Willie",
		"Zachary",
		"Aaron",
		"Abraham",
		"Adam",
		"Adrian",
		"Aidan",
		"Aiden",
		"Alan",
		"Alec",
		"Alejandro",
		"Alex",
		"Alexander",
		"Alexis",
		"Allen",
		"Andre",
		"Andres",
		"Andrew",
		"Angel",
		"Anthony",
		"Antonio",
		"Ashton",
		"Austin",
		"Ayden",
		"Benjamin",
		"Blake",
		"Braden",
		"Bradley",
		"Brady",
		"Brandon",
		"Brayden",
		"Brendan",
		"Brent",
		"Brett",
		"Brian",
		"Brody",
		"Bryan",
		"Bryce",
		"Bryson",
		"Caden",
		"Caleb",
		"Calvin",
		"Cameron",
		"Carlos",
		"Carson",
		"Carter",
		"Casey",
		"Cesar",
		"Chad",
		"Charles",
		"Chase",
		"Christian",
		"Christopher",
		"Clayton",
		"Cody",
		"Colby",
		"Cole",
		"Colin",
		"Collin",
		"Colton",
		"Conner",
		"Connor",
		"Cooper",
		"Corey",
		"Cory",
		"Craig",
		"Cristian",
		"Curtis",
		"Dakota",
		"Dalton",
		"Damian",
		"Daniel",
		"Darius",
		"David",
		"Dennis",
		"Derek",
		"Derrick",
		"Devin",
		"Devon",
		"Diego",
		"Dillon",
		"Dominic",
		"Donald",
		"Donovan",
		"Douglas",
		"Drew",
		"Dustin",
		"Dylan",
		"Edgar",
		"Eduardo",
		"Edward",
		"Edwin",
		"Eli",
		"Elias",
		"Elijah",
		"Emmanuel",
		"Eric",
		"Erick",
		"Erik",
		"Ethan",
		"Evan",
		"Fernando",
		"Francisco",
		"Frank",
		"Gabriel",
		"Gage",
		"Garrett",
		"Gary",
		"Gavin",
		"George",
		"Giovanni",
		"Grant",
		"Gregory",
		"Hayden",
		"Hector",
		"Henry",
		"Hunter",
		"Ian",
		"Isaac",
		"Isaiah",
		"Ivan",
		"Jack",
		"Jackson",
		"Jacob",
		"Jaden",
		"Jake",
		"Jalen",
		"James",
		"Jared",
		"Jason",
		"Javier",
		"Jayden",
		"Jeffrey",
		"Jeremiah",
		"Jeremy",
		"Jerry",
		"Jesse",
		"Jesus",
		"Joel",
		"John",
		"Johnathan",
		"Johnny",
		"Jonah",
		"Jonathan",
		"Jonathon",
		"Jordan",
		"Jorge",
		"Jose",
		"Joseph",
		"Joshua",
		"Josiah",
		"Juan",
		"Julian",
		"Justin",
		"Kaden",
		"Kaleb",
		"Keith",
		"Kenneth",
		"Kevin",
		"Kyle",
		"Landon",
		"Larry",
		"Leonardo",
		"Levi",
		"Liam",
		"Logan",
		"Lucas",
		"Luis",
		"Luke",
		"Malachi",
		"Malik",
		"Manuel",
		"Marco",
		"Marcus",
		"Mario",
		"Mark",
		"Martin",
		"Mason",
		"Mathew",
		"Matthew",
		"Max",
		"Maxwell",
		"Micah",
		"Michael",
		"Miguel",
		"Mitchell",
		"Nathan",
		"Nathaniel",
		"Nicholas",
		"Nicolas",
		"Noah",
		"Nolan",
		"Oliver",
		"Omar",
		"Oscar",
		"Owen",
		"Parker",
		"Patrick",
		"Paul",
		"Pedro",
		"Peter",
		"Peyton",
		"Philip",
		"Phillip",
		"Preston",
		"Randy",
		"Raymond",
		"Ricardo",
		"Richard",
		"Riley",
		"Robert",
		"Roberto",
		"Ronald",
		"Ruben",
		"Ryan",
		"Samuel",
		"Scott",
		"Sean",
		"Sebastian",
		"Sergio",
		"Seth",
		"Shane",
		"Shawn",
		"Spencer",
		"Stephen",
		"Steven",
		"Tanner",
		"Taylor",
		"Thomas",
		"Timothy",
		"Tony",
		"Travis",
		"Trenton",
		"Trevor",
		"Tristan",
		"Troy",
		"Tyler",
		"Victor",
		"Vincent",
		"Wesley",
		"William",
		"Wyatt",
		"Xavier",
		"Zachary"
	];

	$LN = ["Abbott", "Adams", "Adkins", "Aguirre", "Albert", "Alexander", "Alford", "Allen", "Allison", "Alston", "Anderson", "Andrews", "Anthony", "Armstrong", "Arnold", "Ashley", "Atkins", "Atkinson", "Austin", "Avery", "Bailey", "Baird", "Baker", "Baldwin", "Ball", "Ballard", "Banks", "Barber", "Barker", "Barlow", "Barnes", "Barnett", "Barr", "Barrera", "Barrett", "Barron", "Barry", "Bartlett", "Barton", "Bass", "Bates", "Battle", "Bauer", "Baxter", "Beach", "Bean", "Beard", "Beasley", "Beck", "Becker", "Bell", "Bender", "Benjamin", "Bennett", "Benson", "Bentley", "Benton", "Berg", "Berger", "Bernard", "Berry", "Best", "Bird", "Bishop", "Black", "Blackburn", "Blackwell", "Blair", "Blake", "Blanchard", "Blankenship", "Blevins", "Bolton", "Bond", "Bonner", "Booker", "Boone", "Booth", "Bowen", "Bowers", "Bowman", "Boyd", "Boyer", "Boyle", "Bradford", "Bradley", "Bradshaw", "Brady", "Branch", "Bray", "Brennan", "Brewer", "Bridges", "Briggs", "Bright", "Britt", "Brock", "Brooks", "Brown", "Browning", "Bruce", "Bryan", "Bryant", "Buck", "Buckley", "Buckner", "Bullock", "Burch", "Burgess", "Burke", "Burks", "Burnett", "Burns", "Burris", "Burt", "Burton", "Bush", "Butler", "Byers", "Byrd", "Cain", "Calderon", "Caldwell", "Callahan", "Cameron", "Campbell", "Cannon", "Carey", "Carlson", "Carney", "Carpenter", "Carr", "Carson", "Carter", "Carver", "Case", "Casey", "Cash", "Chambers", "Chandler", "Chaney", "Chapman", "Charles", "Chase", "Cherry", "Christensen", "Christian", "Church", "Clark", "Clarke", "Clay", "Clayton", "Clements", "Clemons", "Cleveland", "Cline", "Cobb", "Coffey", "Cohen", "Cole", "Coleman", "Collier", "Collins", "Colon", "Combs", "Compton", "Conley", "Conner", "Conrad", "Conway", "Cook", "Cooke", "Cooley", "Cooper", "Copeland", "Cotton", "Cox", "Craft", "Craig", "Crane", "Crawford", "Crosby", "Cross", "Cummings", "Cunningham", "Curry", "Curtis", "Dale", "Dalton", "Daniel", "Daniels", "Daugherty", "Davenport", "David", "Davidson", "Davis", "Dawson", "Day", "Dean", "Decker", "Dickerson", "Dickson", "Dillard", "Dillon", "Dixon", "Donaldson", "Donovan", "Dorsey", "Dotson", "Douglas", "Downs", "Doyle", "Drake", "Dudley", "Duffy", "Duke", "Duncan", "Dunn", "Duran", "Durham", "Dyer", "Eaton", "Edwards", "Elliott", "Ellis", "Ellison", "Emerson", "England", "English", "Erickson", "Evans", "Everett", "Ewing", "Farley", "Farmer", "Farrell", "Faulkner", "Ferguson", "Ferrell", "Fields", "Finch", "Finley", "Fischer", "Fisher", "Fleming", "Fletcher", "Flores", "Flowers", "Floyd", "Flynn", "Foley", "Forbes", "Ford", "Foreman", "Foster", "Fowler", "Fox", "Francis", "Franco", "Frank", "Franklin", "Franks", "Frazier", "Frederick", "Freeman", "French", "Frost", "Fry", "Frye", "Fuller", "Fulton", "Gaines", "Gallagher", "Gallegos", "Galloway", "Gamble", "Gardner", "Garner", "Garrett", "Garrison", "Gates", "Gay", "Gentry", "George", "Gibbs", "Gibson", "Gilbert", "Giles", "Gill", "Gilliam", "Gilmore", "Glass", "Glenn", "Glover", "Goff", "Golden", "Good", "Goodman", "Goodwin", "Gordon", "Graham", "Grant", "Graves", "Gray", "Green", "Greene", "Greer", "Gregory", "Griffin", "Griffith", "Grimes", "Gross", "Guy", "Hale", "Haley", "Hall", "Hamilton", "Hammond", "Hampton", "Hancock", "Haney", "Hansen", "Hanson", "Hardin", "Harding", "Hardy", "Harmon", "Harper", "Harrell", "Harrington", "Harris", "Harrison", "Hart", "Hartman", "Harvey", "Hatfield", "Hawkins", "Hayden", "Hayes", "Haynes", "Hays", "Head", "Heath", "Hebert", "Henderson", "Hendricks", "Hendrix", "Henry", "Hensley", "Henson", "Herman", "Herring", "Hess", "Hester", "Hewitt", "Hickman", "Hicks", "Higgins", "Hill", "Hines", "Hinton", "Hobbs", "Hodge", "Hodges", "Hoffman", "Hogan", "Holcomb", "Holden", "Holder", "Holland", "Holloway", "Holman", "Holmes", "Holt", "Hood", "Hooper", "Hoover", "Hopkins", "Hopper", "Horn", "Horne", "Horton", "House", "Houston", "Howard", "Howe", "Howell", "Hubbard", "Huber", "Hudson", "Huff", "Huffman", "Hughes", "Hull", "Humphrey", "Hunt", "Hunter", "Hurley", "Hurst", "Hutchinson", "Hyde", "Irwin", "Jackson", "Jacobs", "Jacobson", "James", "Jarvis", "Jefferson", "Jenkins", "Jennings", "Jensen", "Johns", "Johnson", "Johnston", "Jones", "Jordan", "Joseph", "Joyce", "Justice", "Kane", "Keith", "Keller", "Kelley", "Kelly", "Kennedy", "Kent", "Key", "Kidd", "King", "Kirby", "Kirk", "Kirkland", "Knight", "Knowles", "Knox", "Koch", "Kramer", "Lamb", "Lambert", "Lancaster", "Landry", "Lane", "Lang", "Langley", "Lara", "Larsen", "Larson", "Lawrence", "Lawson", "Leon", "Leonard", "Lester", "Levine", "Levy", "Lewis", "Lindsay", "Lindsey", "Little", "Livingston", "Lloyd", "Logan", "Long", "Lopez", "Lott", "Love", "Lowe", "Lowery", "Lucas", "Luna", "Lynch", "Lynn", "Lyons", "Macdonald", "Mack", "Madden", "Maddox", "Maldonado", "Malone", "Mann", "Manning", "Marks", "Marsh", "Marshall", "Martin", "Mason", "Massey", "Mathews", "Mathis", "Matthews", "Maxwell", "May", "Mayer", "Maynard", "Mays", "McBride", "McCall", "McCarthy", "McCarty", "McClain", "McClure", "McConnell", "McCormick", "McCoy", "McCray", "McCullough", "McDaniel", "McDonald", "McDowell", "McFadden", "McFarland", "McGee", "McGowan", "McGuire", "McIntosh", "McIntyre", "McKay", "McKee", "McKenzie", "McKinney", "McKnight", "McLaughlin", "McLean", "McLeod", "McMahon", "McMillan", "McNeil", "McPherson", "Meadows", "Medina", "Melton", "Mercer", "Merrill", "Merritt", "Meyer", "Meyers", "Michael", "Middleton", "Miles", "Miller", "Mills", "Miranda", "Mitchell", "Monroe", "Montgomery", "Moody", "Moon", "Mooney", "Moore", "Moran", "Morgan", "Morin", "Morris", "Morrison", "Morrow", "Morse", "Morton", "Moses", "Mosley", "Moss", "Mueller", "Mullen", "Mullins", "Murphy", "Murray", "Myers", "Nash", "Navarro", "Neal", "Nelson", "Newman", "Newton", "Nichols", "Nicholson", "Nielsen", "Nixon", "Noble", "Noel", "Nolan", "Norman", "Norris", "Norton", "O'Brien", "O'Connor", "O'Donnell", "O'Neal", "O'Neil", "O'Neill", "Oliver", "Olsen", "Olson", "Ortega", "Ortiz", "Osborn", "Osborne", "Owen", "Owens", "Pace", "Page", "Palmer", "Park", "Parker", "Parks", "Parrish", "Parsons", "Patrick", "Patterson", "Patton", "Paul", "Payne", "Pearson", "Peck", "Pena", "Pennington", "Perkins", "Perry", "Peters", "Petersen", "Peterson", "Phelps", "Phillips", "Pickett", "Pierce", "Pittman", "Pitts", "Pollard", "Poole", "Pope", "Porter", "Potter", "Potts", "Powell", "Powers", "Pratt", "Preston", "Price", "Prince", "Puckett", "Quinn", "Ramsey", "Randall", "Randolph", "Ray", "Raymond", "Reed", "Reese", "Reeves", "Reid", "Reilly", "Reyes", "Reynolds", "Rhodes", "Rich", "Richard", "Richards", "Richardson", "Richmond", "Riddle", "Riggs", "Riley", "Rivera", "Rivers", "Roach", "Robbins", "Roberson", "Roberts", "Robertson", "Robinson", "Robles", "Rodgers", "Rogers", "Rollins", "Rose", "Ross", "Roth", "Rowe", "Rowland", "Roy", "Rush", "Russell", "Ryan", "Sampson", "Sanders", "Sanford", "Sargent", "Saunders", "Savage", "Sawyer", "Scott", "Sears", "Sellers", "Serrano", "Sexton", "Shaffer", "Shannon", "Sharp", "Sharpe", "Shaw", "Shelton", "Shepard", "Shepherd", "Sheppard", "Sherman", "Shields", "Short", "Simmons", "Simon", "Simpson", "Sims", "Singleton", "Skinner", "Slater", "Sloan", "Small", "Smith", "Snider", "Snow", "Snyder", "Sparks", "Spears", "Spence", "Spencer", "Stafford", "Stanley", "Stanton", "Stark", "Steele", "Stein", "Stephens", "Stephenson", "Stevens", "Stevenson", "Stewart", "Stokes", "Stone", "Stout", "Strickland", "Strong", "Stuart", "Sullivan", "Summers", "Sutton", "Swanson", "Sweeney", "Sweet", "Sykes", "Talley", "Tanner", "Tate", "Taylor", "Terrell", "Terry", "Thomas", "Thompson", "Thornton", "Tillman", "Todd", "Townsend", "Travis", "Tucker", "Turner", "Tyler", "Tyson", "Underwood", "Vaughan", "Vaughn", "Vincent", "Vinson", "Wade", "Wagner", "Walker", "Wall", "Wallace", "Waller", "Walls", "Walsh", "Walter", "Walters", "Walton", "Ward", "Ware", "Warner", "Warren", "Washington", "Waters", "Watkins", "Watson", "Watts", "Weaver", "Webb", "Weber", "Webster", "Weeks", "Wells", "West", "Wheeler", "Whitaker", "White", "Whitehead", "Whitfield", "Whitley", "Whitney", "Wiggins", "Wilcox", "Wilder", "Wiley", "Wilkerson", "Wilkins", "Wilkinson", "William", "Williams", "Williamson", "Willis", "Wilson", "Winters", "Wise", "Witt", "Wolf", "Wolfe", "Wood", "Woodard", "Woods", "Woodward", "Workman", "Wright", "Wyatt", "Yates", "York", "Young"];

	return $FN[array_rand($FN)] . " " . $LN[array_rand($LN)];
}

function GetSpaceMarineName()
{
	// Get a Space Marine name
	// From https://www.fantasynamegenerators.com/scripts/spaceMarineNames.js
	// Standalone ancient first names
	$anFN = ["Abdaziel", "Abdiel", "Abrariel", "Adnachiel", "Adonael", "Adriel", "Afriel", "Akhazriel", "Akriel", "Ambriel", "Amitiel", "Amriel", "Anael", "Anaiel", "Anaphiel", "Anapiel", "Anauel", "Anpiel", "Ansiel", "Aphael", "Aradiel", "Arael", "Araqiel", "Araquiel", "Arariel", "Azrael", "Azriel", "Barachiel", "Baradiel", "Barakiel", "Baraqiel", "Barattiel", "Barbiel", "Barchiel", "Bariel", "Barquiel", "Barrattiel", "Baruchiel", "Bethuel", "Boamiel", "Cadriel", "Camael", "Camiel", "Caphriel", "Cassiel", "Castiel", "Cerviel", "Chamuel", "Chayliel", "Dabriel", "Dagiel", "Dalquiel", "Daniel", "Dardariel", "Diniel", "Domiel", "Dubbiel", "Emmanuel", "Eremiel", "Ezekiel", "Ezequiel", "Gabriel", "Gadiel", "Gadreel", "Gadriel", "Gagiel", "Galgaliel", "Gazardiel", "Geburatiel", "Germael", "Habriel", "Hadariel", "Hadramiel", "Hadraniel", "Hadriel", "Hakael", "Hamael", "Hamaliel", "Hasdiel", "Hayliel", "Hermesiel", "Hochmael", "Hofniel", "Humatiel", "Humiel", "Incarael", "Ishmael", "Israfel", "Israfiel", "Israfil", "Ithuriel", "Jehudiel", "Jeremiel", "Kabshiel", "Kadmiel", "Kafziel", "Kalaziel", "Karael", "Kasbiel", "Kemuel", "Kerubiel", "Khamael", "Labbiel", "Lahabiel", "Machidiel", "Malchediel", "Mazrael", "Michael", "Mihael", "Morael", "Mordigael", "Mydaiel", "Naaririel", "Nahaliel", "Nanael", "Narcariel", "Nasargiel", "Nathanael", "Nathaniel", "Nelchael", "Omael", "Omniel", "Onafiel", "Ophaniel", "Ophiel", "Orphamiel", "Osmadiel", "Pathiel", "Peliel", "Peniel", "Perpetiel", "Phanuel", "Pyriel", "Qaphsiel", "Qaspiel", "Quabriel", "Rachmiel", "Radfael", "Radueriel", "Raduriel", "Rahatiel", "Rahmiel", "Ramiel", "Raphael", "Rasiel", "Rathanael", "Razael", "Raziel", "Rehael", "Remiel", "Remliel", "Rhamiel", "Rikbiel", "Rogziel", "Rufeal", "Ruhiel", "Sabathiel", "Sabrael", "Sachael", "Sachiel", "Salathiel", "Samael", "Samandiriel", "Samandriel", "Samkiel", "Sammael", "Saniel", "Sarandiel", "Sariel", "Satqiel", "Sealtiel", "Seraphiel", "Shamsiel", "Simiel", "Stadiel", "Suriel", "Tadhiel", "Tamiel", "Tatrasiel", "Theliel", "Turiel", "Turmiel", "Uriel", "Usiel", "Uzziel", "Vretiel", "Yerachmiel", "Yeshamiel", "Zacharael", "Zachariel", "Zachriel", "Zadkiel", "Zahariel", "Zaphiel", "Zazriel", "Zophiel", "Zuriel"];

	// Two-part ancient last names
	$anLN1 = ["Abra", "Ale", "Alge", "Alle", "Alva", "Ama", "Apo", "Arca", "Archa", "Are", "Arge", "Arte", "Ata", "Atana", "Athi", "Augu", "Auto", "Avi", "Avu", "Axa", "Ba", "Be", "Belle", "Bo", "Borea", "Ca", "Cae", "Caele", "Caldi", "Cassia", "Cassio", "Cassiu", "Ce", "Centu", "Cleu", "Co", "Consta", "Consu", "Corio", "Corne", "Corvu", "Cra", "Cy", "Cyru", "Da", "Dae", "Damo", "Dariu", "Deme", "Desti", "Dio", "Do", "Domi", "Ela", "Ely", "Eno", "Epheu", "Epi", "Era", "Eume", "Fa", "Fabiu", "Fennia", "Fenniu", "Ferru", "Fi", "Firlu", "Go", "Gordia", "Gothcha", "Grae", "Gre", "Gri", "Grima", "Ha", "Hadrio", "Hea", "Heli", "Helve", "Ho", "Holo", "Hono", "Hy", "Hype", "Ica", "Igna", "Ikti", "Invi", "Ja", "Janu", "Ju", "Juliu", "Kae", "Ko", "Lae", "Lame", "Laza", "Leo", "Leode", "Leona", "Liciu", "Lu", "Luctu", "Ludo", "Ly", "Lysi", "Ma", "Mandu", "Maneu", "Mariu", "Marte", "Maxi", "Me", "Mephi", "Mero", "Mettiu", "Mi", "Mike", "Milu", "Mora", "Myki", "Ne", "Nele", "No", "Ome", "Ore", "Oria", "Pa", "Palla", "Pe", "Pella", "Pera", "Petiu", "Pra", "Prae", "Qui", "Ra", "Rammiu", "Re", "Remu", "Rena", "Rheto", "Rui", "Sa", "Sangui", "Se", "Sera", "Seve", "Sica", "Soli", "Tae", "Tha", "Theo", "Tho", "Thra", "Tire", "Titu", "Tole", "Toria", "Try", "Tybe", "Va", "Valle", "Vite"];
	$anLN2 = ["beros", "bius", "canus", "carius", "ccimius", "ceus", "cius", "ctus", "ddeus", "des", "deus", "dia", "dis", "dius", "dosios", "drios", "garius", "goras", "gris", "gus", "kelus", "kilus", "lanus", "lcus", "ldimus", "ldus", "lestis", "leus", "licanus", "linus", "lis", "lius", "lixus", "llas", "llenus", "llian", "llios", "llius", "llo", "llus", "lochus", "los", "ltus", "lus", "machus", "maldus", "medes", "menes", "metheus", "mion", "mis", "mmius", "mos", "mus", "natos", "natus", "ndus", "ndus", "nes", "neus", "nicus", "nius", "nnias", "nnius", "nnus", "ntinus", "ntis", "ntius", "ntos", "nus", "pheus", "phicus", "phis", "ptus", "ras", "ratos", "rbus", "rdian", "reas", "rex", "rias", "rion", "rius", "rlus", "rnon", "ron", "ros", "rpheus", "rpus", "rrus", "rtes", "rthus", "rus", "rvus", "scios", "sias", "sios", "sius", "ssian", "ssios", "ssius", "ssos", "ssus", "stin", "stis", "ston", "sus", "theus", "thios", "thos", "ticus", "tin", "tinos", "tio", "tios", "tius", "tor", "trios", "trius", "ttius", "tus", "tutus", "verus", "vius", "vus", "ximus", "xis", "xus", "zarus"];

	// Two-part latin first names
	$latFN1 = ["Abra", "Ale", "Alge", "Alle", "Alva", "Ama", "Apo", "Arca", "Archa", "Are", "Arge", "Arte", "Ata", "Atana", "Athi", "Augu", "Auto", "Avi", "Avu", "Axa", "Ba", "Be", "Belle", "Bo", "Borea", "Ca", "Cae", "Caele", "Caldi", "Cassia", "Cassio", "Cassiu", "Ce", "Centu", "Cleu", "Co", "Consta", "Consu", "Corio", "Corne", "Corvu", "Cra", "Cy", "Cyru", "Da", "Dae", "Damo", "Dariu", "Deme", "Desti", "Dio", "Do", "Domi", "Ela", "Ely", "Eno", "Epheu", "Epi", "Era", "Eume", "Fa", "Fabiu", "Fennia", "Fenniu", "Ferru", "Fi", "Firlu", "Go", "Gordia", "Gothcha", "Grae", "Gre", "Gri", "Grima", "Ha", "Hadrio", "Hea", "Heli", "Helve", "Ho", "Holo", "Hono", "Hy", "Hype", "Ica", "Igna", "Ikti", "Invi", "Ja", "Janu", "Ju", "Juliu", "Kae", "Ko", "Lae", "Lame", "Laza", "Leo", "Leode", "Leona", "Liciu", "Lu", "Luctu", "Ludo", "Ly", "Lysi", "Ma", "Mandu", "Maneu", "Mariu", "Marte", "Maxi", "Me", "Mephi", "Mero", "Mettiu", "Mi", "Mike", "Milu", "Mora", "Myki", "Ne", "Nele", "No", "Ome", "Ore", "Oria", "Pa", "Palla", "Pe", "Pella", "Pera", "Petiu", "Pra", "Prae", "Qui", "Ra", "Rammiu", "Re", "Remu", "Rena", "Rheto", "Rui", "Sa", "Sangui", "Se", "Sera", "Seve", "Sica", "Soli", "Tae", "Tha", "Theo", "Tho", "Thra", "Tire", "Titu", "Tole", "Toria", "Try", "Tybe", "Va", "Valle", "Vite"];
	$latFN2 = ["beros", "bius", "canus", "carius", "ccimius", "ceus", "cius", "ctus", "ddeus", "des", "deus", "dia", "dis", "dius", "dosios", "drios", "garius", "goras", "gris", "gus", "kelus", "kilus", "lanus", "lcus", "ldimus", "ldus", "lestis", "leus", "licanus", "linus", "lis", "lius", "lixus", "llas", "llenus", "llian", "llios", "llius", "llo", "llus", "lochus", "los", "ltus", "lus", "machus", "maldus", "medes", "menes", "metheus", "mion", "mis", "mmius", "mos", "mus", "natos", "natus", "nduls", "ndus", "nes", "neus", "nicus", "nius", "nnias", "nnius", "nnus", "ntinus", "ntis", "ntius", "ntos", "nus", "pheus", "phicus", "phis", "ptus", "ras", "ratos", "rbus", "rdian", "reas", "rex", "rias", "rion", "rius", "rlus", "rnon", "ron", "ros", "rpheus", "rpus", "rrus", "rtes", "rthus", "rus", "rvus", "scios", "sias", "sios", "sius", "ssian", "ssios", "ssius", "ssos", "ssus", "stin", "stis", "ston", "sus", "theus", "thios", "thos", "ticus", "tin", "tinos", "tio", "tios", "tius", "tor", "trios", "trius", "ttius", "tus", "tutus", "verus", "vius", "vus", "ximus", "xis", "xus", "zarus"];

	// Two-part latin last names
	$latLN1 = ["Akio", "Andro", "Aqui", "Avi", "Be", "Beru", "Ca", "Cassiu", "Ce", "Co", "Cora", "Corda", "Cy", "Cybu", "Dio", "Dra", "Fa", "Fabri", "Gie", "Invi", "Isso", "Ky", "Kyra", "Ma", "Manu", "Me", "Mede", "Mo", "Morre", "Nu", "Octa", "Orio", "Orty", "Pho", "Po", "Polu", "Sca", "Si", "Sica", "So", "Sola", "Stro", "Ta", "Tari", "Te", "Telio", "Ti", "Tibe", "Tigu", "Titu", "Tra", "Tri", "Trisme", "Ty", "Venta", "Vi", "Vibiu"];
	$latLN2 = ["bius", "bus", "cles", "cos", "ctus", "cus", "des", "dexus", "don", "gistus", "gus", "kios", "kus", "la", "laris", "lion", "lis", "llis", "lux", "medes", "meon", "ncus", "nos", "ntanus", "nus", "ras", "rax", "rdatus", "rian", "ricus", "rikus", "rion", "ris", "rius", "ro", "ros", "rus", "s", "sius", "ssius", "stus", "tanus", "tus", "tys", "vius", "xus", "yus"];

	// Two-part composite first names
	$compFN1 = ["Aar", "Act", "Aeg", "Aeth", "Al", "Alar", "Aldr", "Aldw", "Aleh", "Aler", "Alr", "And", "Andr", "Ansg", "Anv", "Ard", "Arg", "Arj", "Ark", "Arm", "Armar", "Arv", "Ash", "Aud", "Bael", "Bald", "Balt", "Bann", "Belph", "Ben", "Bened", "Beth", "Bheh", "Bj", "Bol", "Bolin", "Br", "Brayd", "Bulv", "Cad", "Cadm", "Can", "Car", "Carn", "Cast", "Daarm", "Daem", "Darn", "Dav", "Drum", "Drust", "Dur", "Eadw", "Ech", "Eck", "Ed", "Efr", "Eg", "El", "Eng", "Er", "Esdr", "Feirr", "Felg", "Fr", "Fug", "Gal", "Gann", "Garr", "Gerh", "Gervh", "Gess", "Gnaer", "Gnyr", "Graev", "Grivn", "Grol", "Gunn", "Gym", "Haak", "Hagr", "Halbr", "Haldr", "Har", "Harv", "Has", "Hect", "Heinm", "Helbr", "Helg", "Hengh", "Herv", "Hoen", "Hold", "Horn", "Horthg", "Hr", "Hwyg", "Indr", "Ingv", "Jerr", "Jog", "Jogh", "Jon", "Jor", "Jub", "Jul", "Jurg", "KRist", "Kaer", "Kald", "Kalg", "Kard", "Karl", "Karr", "Keil", "Ker", "Kj", "Kl", "Kordh", "Kr", "Kreg", "Kv", "Lefv", "Lem", "Lod", "Log", "Lorg", "Luk", "Magn", "Makl", "Neod", "Ner", "Nid", "Ol", "Olb", "Or", "Orl", "Ort", "Ow", "Ragn", "Rakm", "Rald", "Ran", "Reg", "Rem", "Rog", "Ryn", "Sab", "Seg", "Segl", "Sel", "Sevr", "Seyd", "Sief", "Sig", "Sigv", "Skv", "Sv", "Talb", "Tark", "Tarn", "Tob", "Torbj", "Torf", "Torgh", "Torv", "Traj", "Ulr", "Var", "Varr", "Vayl", "Vos", "Vulk"];
	$compFN2 = ["aar", "ab", "abro", "ac", "ach", "aen", "af", "ah", "aidin", "ak", "al", "ald", "an", "and", "ann", "ant", "ar", "ard", "aric", "arl", "aros", "arr", "art", "as", "ast", "atan", "aten", "ath", "ayden", "eas", "echt", "ed", "edict", "egor", "ehan", "ehart", "eifvar", "ek", "el", "elan", "em", "en", "eon", "er", "erin", "esk", "eyr", "iak", "ian", "ias", "ic", "ick", "ict", "ied", "ig", "ik", "il", "in", "indal", "ine", "invar", "ion", "ios", "ir", "is", "ismund", "ist", "oan", "oc", "och", "od", "oec", "off", "ok", "old", "om", "on", "or", "orn", "oron", "os", "ot", "oth", "ovar", "ul", "ulf", "ulon", "un", "und", "ur", "us", "yn", "yrll"];

	// Two-part composite last names
	$compLN1 = ["Ash", "Battle", "Bear", "Black", "Blood", "Blue", "Boulder", "Cog", "Crimson", "Dagger", "Dark", "Dead", "Death", "Doom", "Dragon", "Fell", "Fire", "Frost", "Fury", "Ghost", "Gore", "Grey", "Grim", "Hammer", "Hell", "Howl", "Ice", "Iron", "Kraken", "Light", "Oak", "One", "Rage", "Red", "Rock", "Silver", "Skull", "Stark", "Steel", "Stone", "Storm", "Strong", "Three", "Thunder", "Tree", "Twice", "Two", "Umber", "War", "White", "Wolf"];
	$compLN2 = ["arm", "bane", "blade", "bleed", "blood", "born", "breaker", "bringer", "brow", "call", "caller", "claw", "cleaver", "crusher", "dagger", "dust", "eye", "eyes", "fall", "fang", "fist", "fisted", "flayer", "foot", "fury", "gaze", "hammer", "hand", "handed", "hide", "horn", "howl", "mace", "mane", "mantle", "maul", "maw", "moon", "rage", "scream", "seeker", "shield", "sides", "slain", "sword", "sworn", "teeth", "tooth", "tree", "walk", "walker", "wolf"];

	// Two-part other first names
	$othFN1 = ["Aga", "Agapi", "Aha", "Ai", "Ale", "Ama", "Ange", "Anta", "Asmo", "Aste", "Asto", "Au", "Avi", "Aza", "Azkae", "Be", "Belia", "Bhar'", "Bo", "Boka", "Bray'", "Car", "Carna", "Carnae", "Cema", "Chi", "Chry", "Corbu", "Cu", "Cy", "Da", "Dak'", "Darrio", "Dasei", "Dra", "Dri", "Enp", "Eoni", "Fu", "Gaui", "Gero", "Glo", "Gri", "Gui", "Heka", "Iga", "Isa", "Issa", "Ja", "Jagha", "Je", "Jemu", "K'", "Kardo", "Key", "Kha", "Khoi", "Khy", "Kori", "Korvy", "Kyu", "Lavi", "Laze", "Ly", "Lycao", "Ma", "Mae", "Mala", "Malu", "Marqo", "Maxi", "Mercae", "Mo", "Molo", "Morda", "Na", "Naa", "Nassi", "Nava", "Ne", "Necto", "Neme", "No", "Numi", "Nyko", "Pa", "Pae", "Paele", "Pho", "Pto", "Rha", "Rohi", "Romo", "Sa", "Sappho", "Sarpe", "Sca", "Scama", "Sci", "Senti", "Sepha", "Seve", "Shai", "Shen'", "Ska", "Skala", "Skata", "Ske", "Sola", "Subo", "Szo", "Tae", "Talu", "Tar'", "Targu", "Tela", "Tho", "Thu", "Toha", "Tsu'", "Tu'", "Urga", "Vai'", "Vara", "Vashi", "Vee", "Vel'", "Vena", "Verma", "Verro", "Volo", "Xe", "Xeri", "Xero", "Yafri", "Yaro", "Zarta", "Zhe", "Zhru", "Zu", "Zuru"];
	$othFN2 = ["ban", "bdek", "be", "blai", "bor", "bulum", "caon", "char", "chia", "chite", "co", "cole", "cona", "ctor", "dae", "dai", "don", "dor", "drakk", "driik", "fen", "frir", "gan", "go", "gol", "grim", "gum", "gutai", "hiam", "hr", "jz", "kal", "kar", "kari", "katon", "kha", "kim", "kir", "kona", "lach", "lakim", "lan", "laro", "lavech", "lemy", "ler", "lgaar", "lial", "lian", "lkca", "llig", "llion", "llon", "los", "lsa", "lus", "mah", "makar", "man", "mech", "mine", "mmon", "nder", "ndian", "nea", "nian", "nid", "nitan", "noch", "nos", "pico", "pito", "pphon", "ra", "rah", "ram", "rast", "rath", "rbul", "rbulo", "rcyra", "rdaci", "rdan", "rdova", "ren", "resh", "rh", "riah", "riam", "rian", "rica", "rkov", "rleo", "rnous", "ro", "ron", "ros", "rpico", "rqol", "rrion", "rrox", "rtath", "rtes", "rus", "rvon", "ryon", "san", "sarro", "sein", "shan", "slan", "ssir", "stion", "tai", "tan", "taron", "tek", "ter", "thak", "thar", "ther", "thigg", "tikan", "tor", "trok", "trus", "vaan", "var", "vech", "veren", "viton", "von", "vydae", "xx", "zlo", "zra"];

	// Two-part other last names
	$othLN1 = ["Ab", "Ad", "Ak", "Alb", "Alv", "Am", "Andr", "Aq", "Ber", "Bl", "Blant", "Blay", "C", "Calg", "Ch", "Chr", "Cort", "Cyb", "Dar", "Dars", "Dom", "Elg", "Eng", "F", "Ferr", "Fur", "G", "Gr", "Grenz", "Guill", "H", "Hest", "Inv", "Iss", "K", "Kan", "Kant", "Karr", "Kyr", "M", "Med", "Mend", "Mor", "Morv", "N", "Neot", "Ort", "P", "Ph", "Phor", "R", "Rub", "S", "Sh", "Sharr", "Shr", "Sol", "T", "Tar", "Th", "Tham", "Tib", "Tig", "Tr", "Trism", "Ush", "V", "Vib", "Vid", "W", "Wyrd"];
	$othLN2 = ["addas", "ai", "ake", "an", "ane", "antar", "antor", "ar", "are", "aris", "as", "asi", "atica", "auth", "ay", "edth", "ef", "ein", "elis", "entre", "era", "erec", "erro", "erus", "es", "ev", "exus", "ez", "iam", "iar", "ica", "idya", "iel", "ikus", "im", "io", "ios", "ist", "istus", "it", "ius", "ixx", "on", "onus", "or", "orak", "os", "oss", "ova", "ox", "oza", "uebus", "uil", "uila", "urus", "us", "yras", "ys"];

	// Now pick a "language" and build the name
	$language = rand(1, 4);

	switch ($language) {
		case 1:
			// Use an ancient name
			$firstname = $anFN[array_rand($anFN)];
			$lastname = $anLN1[array_rand($anLN1)] . $anLN2[array_rand($anLN2)];
			return $firstname . " " . $lastname;
		case 2:
			// Use a latin name
			$firstname = $latFN1[array_rand($latFN1)] . $latFN2[array_rand($latFN2)];
			$lastname = $latLN1[array_rand($latLN1)] . $latLN2[array_rand($latLN2)];
			return $firstname . " " . $lastname;
		case 3:
			// Use a composite name
			$firstname = $compFN1[array_rand($compFN1)] . $compFN2[array_rand($compFN2)];
			$lastname = $compLN1[array_rand($compLN1)] . $compLN2[array_rand($compLN2)];
			return $firstname . " " . $lastname;
		case 4:
			// Use an other name
			$firstname = $othFN1[array_rand($othFN1)] . $othFN2[array_rand($othFN2)];
			$lastname = $othLN1[array_rand($othLN1)] . $othLN2[array_rand($othLN2)];
			return $firstname . " " . $lastname;
	}
}

function GetChaosMarineName()
{
	// Get a Chaos Marine name
	// From view-source:https://www.fantasynamegenerators.com/scripts/chaosNames.js
	$FN1 = ["Aba", "Abru", "Ahru", "An", "Anta", "Anu", "Ar", "Ara", "As", "Azu", "Ba", "Balta", "Barba", "Bero", "Bru", "Bulda", "Burro", "Caorpu", "Chen", "Cru", "Dav", "Dema", "Dev", "Drach", "Dy", "Eku", "Ela", "Ely", "En", "Ere", "Esto", "Ez", "Far", "Fester", "Fu", "Fur", "Furi", "Gal", "Gara", "Goul", "Graza", "Gu", "Gura", "Hala", "He", "Hez", "Hon", "Hou", "Ingu", "Ji", "Juru", "Ka", "Kal", "Kasso", "Kaz", "Kha", "Khro", "Kraa", "Kre", "Ku", "Kur", "Kurna", "Ky", "Lo", "Lu", "Ma", "Mal", "Mephi", "Mo", "Morde", "Morte", "Nazu", "Neme", "Omphu", "Onai", "Parge", "Pho", "Pu", "Puri", "Rha", "Rhy", "Ro", "Ru", "Sathu", "Sava", "Sek", "Si", "Sky", "Svo", "Ta", "Talo", "Tita", "Tu", "Urka", "Urkra", "Urla", "Var", "Vu", "Yga", "Za", "Zho", "Zhu", "Zy"];
	$FN2 = ["'gaz", "'gom", "'khar", "'loth", "'lumin", "'palos", "'ryon", "'sax", "'tiro", "'tzor", "ban", "bar", "bas", "bhor", "bire", "bus", "cius", "daran", "das", "dax", "dekai", "del", "diaz", "dire", "don", "dred", "duk", "far", "gan", "gar", "garr", "gax", "ghast", "gon", "gor", "gore", "gral", "grim", "harr", "kai", "khar", "kos", "las", "lash", "lax", "laz", "lek", "lock", "mek", "min", "mon", "mor", "mort", "mus", "nacus", "naer", "nath", "nax", "neus", "nogar", "nok", "non", "nux", "phoz", "phus", "pulax", "rah", "rak", "ram", "rand", "rass", "rath", "rax", "raz", "rhaz", "rion", "ritus", "rolath", "ron", "roq", "ross", "roth", "routh", "roz", "rulak", "ruman", "rus", "salax", "sour", "stix", "stur", "thac", "thal", "thor", "thral", "toth", "trax", "trius", "vax", "vile", "xus", "zar"];

	$LN1 = ["Abi", "Abre", "Aer", "Ahnu", "An", "Ana", "Ara", "Arhi", "As", "Azu", "Ba", "Bala", "Beldi", "Belo", "Berba", "Berro", "Bri", "Cari", "Ches", "Cry", "Dema", "Dev", "Div", "Dresh", "Dy", "Eki", "Ela", "Ely", "En", "Ene", "Esta", "Ez", "Fer", "Ferri", "Fes", "Fihr", "Fy", "Gal", "Gaya", "Gi", "Gira", "Gol", "Grisa", "He", "Hela", "Hen", "Hez", "Hoa", "Inge", "Ji", "Jura", "Ka", "Kaha", "Kashu", "Ke", "Kel", "Kez", "Khaa", "Khry", "Kir", "Korna", "Kre", "Ky", "Li", "Lo", "Ma", "Mel", "Mephi", "Mo", "Morde", "More", "Nasu", "Neme", "Oni", "Ophu", "Perge", "Pho", "Pi", "Puri", "Rhia", "Rhy", "Ro", "Ry", "Sehk", "Sephu", "Shi", "Sio", "Siva", "Ski", "Telo", "Tha", "Tiya", "Tu", "Una", "Ura", "Urli", "Ver", "Vu", "Ya", "Za", "Zho", "Zoe", "Zy"];
	$LN2 = ["'gah", "'ginn", "'khas", "'lith", "'lumix", "'phis", "'rya", "'sax", "'tira", "'yah", "bara", "bess", "bhox", "bine", "bis", "bise", "cian", "darah", "dash", "dea", "dehk", "dell", "dex", "diaz", "dine", "dresh", "dynn", "faer", "gaer", "gash", "genn", "gihr", "gone", "goye", "grell", "grine", "grinn", "gwer", "hirr", "kei", "kha", "kiz", "lashe", "leck", "lek", "less", "lix", "liz", "mex", "mine", "mona", "mora", "morta", "muse", "naere", "neon", "nesh", "neth", "neuth", "nihx", "nix", "nosa", "nu", "phis", "pho", "prix", "rane", "raz", "reah", "renne", "reon", "resh", "ress", "rhazi", "rilith", "rique", "riss", "rith", "riyes", "riz", "rothe", "roush", "roze", "rumine", "ruse", "ruxa", "ryn", "silix", "sou", "sty", "styxe", "thall", "thess", "thia", "this", "tosh", "triesh", "trix", "vie", "vix", "xis", "zara"];

	$firstname = $FN1[array_rand($FN1)] . $FN2[array_rand($FN2)];
	$lastname = $LN1[array_rand($LN1)] . $LN2[array_rand($LN2)];

	return $firstname . " " . $lastname;
}

function GetHierotekName()
{
	$names0 = ["Ankhep", "Tamonhak", "Eknotath", "Khotek", "Thanatar", "Amhut", "Karok", "Zan-Tep", "Unakh", "Khophec", "Tzantath", "Tahar", "Imonekh", "Trazat", "Xeoptar", "Hamanet", "Oberek", "Banatur", "Ahmnok", "Kophesh", "Teznet", "Odakhar", "Kythok", "Eknothet", "Anubitar", "Anokh", "Thotep", "Anhutek", "Ikhatar", "Thotmek", "Ramatek", "Homanat", "Taknophet", "Makhret", "", "Zanatek"];
	$names1 = ["the Unliving", "the Gilded", "the Great", "the Exalted", "the Loyal", "the Cruel", "the Storm's Eye", "the Bloodied", "the Mighty", "the Relentless", "the Unforgiving", "the Merciless", "the Glorious", "the Devoted", "the Victorious", "the Destroyer", "the Shrouded", "the Flenser", "the Unstoppable", "the Beheader", "the Impaler", "the Magnificent", "the Illuminated", "the Executioner", "the Phaeron's Hand", "of the Eternal Gaze", "the Gatekeeper", "the All-Seeing", "the All-Knowing", "the Starwalker", "the Starkiller", "the Lifetaker", "the Godbreaker", "the Torchbearer", "the Stormbringer", "the Colossus"];

	return $names0[array_rand($names0)] . ' ' . $names1[array_rand($names1)];
}

function GetNecronName()
{
	// Get a Necron name

	switch (rand(0, 1)) {
		case 0:
			// From view-source:https://www.fantasynamegenerators.com/scripts/necronNames.js
			$FN1 = ["Aaho", "Adda", "Aga", "Aha", "Ahho", "Ah", "Akhe", "Ama", "Amene", "Amenho", "Anho", "Ankhese", "Anla", "Ara", "Asha", "Baqe", "Bebi", "Beke", "Bere", "Cleo", "Dakha", "Dedu", "Deme", "Dja", "Djede", "Dje", "Djo", "Duae", "Eury", "Gany", "Geme", "Gilu", "Hako", "Harkhe", "Harsio", "Hedje", "Hekenu", "Hema", "Henu", "Heqa", "Hete", "Hewe", "Hore", "Hote", "Ibi", "Ibia", "Imho", "Ina", "Ine", "Inetka", "Inte", "Ise", "Isetno", "Iuwe", "Kage", "Kape", "Karo", "Kawa", "Kha", "Khae", "Khame", "Khamu", "Khede", "Khe", "Khu", "Maga", "Mane", "Meke", "Menkau", "Menkhe", "Mentu", "Mere", "Meri", "Merne", "Mery", "Minmo", "Mutne", "Nakhto", "Nasa", "Nebu", "Nebe", "Nebne", "Necta", "Nefe", "Nehe", "Nephe", "Nimae", "Nubkhe", "Pane", "Pare", "Pawu", "Pene", "Petu", "Preho", "Psuse", "Ptahmo", "Ptole", "Qare", "Raho", "Rahe", "Rame", "Ramo", "Sahu", "Sehe", "Sekhe", "Seme", "Sense", "Senu", "Seshe", "Simu", "Tadu", "Takha", "Thutmo", "Tuta", "Udje", "Yanha"];
			$FN2 = ["bash", "basken", "bi", "biankh", "bkay", "clea", "clid", "cris", "des", "djem", "dkare", "fer", "fret", "hyt", "kare", "kauhor", "khaf", "khat", "khet", "khmet", "khmire", "khnet", "khotep", "kht", "kor", "maka", "mehyt", "menes", "menre", "mes", "mhat", "mka", "mkah", "mnisu", "mopet", "mose", "mqen", "msaf", "mun", "munzu", "nakht", "namen", "namun", "naten", "nath", "ndes", "nebti", "nebu", "nhor", "nhotekh", "nhotep", "nmut", "nna", "nru", "nu", "nut", "nza", "phren", "pses", "ptah", "qar", "qed", "ra", "ramen", "reh", "rekh", "renef", "ros", "rqa", "rtari", "ru", "rus", "s", "sankh", "sehti", "seneb", "set", "shen", "shenq", "shet", "skaf", "skhet", "snet", "sret", "t", "tamen", "tamun", "tanath", "tankh", "tari", "taruk", "taten", "tef", "tekh", "tep", "thap", "thes", "this", "thor", "tka", "wa"];

			$firstname = $FN1[array_rand($FN1)] . $FN2[array_rand($FN2)];
			$lastname = $FN1[array_rand($FN1)] . $FN2[array_rand($FN2)];

			return $firstname . " " . $lastname;
		case 1:
			// Generic robot name
			$FN1 = ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
			$FN2 = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];

			$name = "";
			for ($i = 0; $i < 2; $i++) {
				$name .= $FN1[array_rand($FN1)];
			}
			$name .= "-";
			for ($i = 0; $i < 5; $i++) {
				$name .= $FN2[array_rand($FN2)];
			}

			return $name;
	}
}

function GetOrkName()
{
	// Get an Ork name
	// From view-source:https://www.fantasynamegenerators.com/scripts/warhammerOrkNames.js
	$names1 = ["b", "br", "ch", "d", "dh", "dr", "g", "gh", "gr", "hr", "k", "kh", "kr", "m", "n", "r", "sk", "sm", "sn", "t", "tr", "v", "vr", "w", "wr", "z", "zh", "zr", "", "", "", "", ""];
	$names2 = ["a", "i", "o", "u", "a", "u"];
	$names3 = ["b", "d", "dbr", "dr", "g", "gb", "gd", "gg", "gh", "gn", "gt", "gz", "hrbl", "k", "kg", "kk", "kt", "lgr", "nz", "r", "rb", "rg", "rgn", "rgr", "rk", "rkr", "rl", "rz", "sk", "skr", "t", "tgr", "tzm", "tzn", "zdr", "zg", "zgr"];
	$names4 = ["a", "o", "u"];
	$names5 = ["d", "g", "gar", "gas", "gg", "gus", "k", "kh", "kk", "m", "nak", "r", "rd", "rk", "x", "z", "zak", "zz",];
	$names6 = ["Barb", "Battle", "Big", "Blood", "Blud", "Bone", "Brain", "Crook", "Crown", "Dark", "Dome", "Doom", "Dream", "Ead", "Ed", "Face", "Fire", "Fist", "Gloom", "Glum", "God", "Gore", "Grave", "Grim", "Gut", "Gutz", "Hed", "Hell", "Ice", "Iron", "Jaw", "Jowl", "Kill", "Klaw", "Krook", "Mad", "Mighty", "Mug", "Muzzle", "Rabid", "Rage", "Rekk", "Rock", "Scalp", "Skar", "Skull", "Slay", "Strong", "War", "Wild"];
	$names7 = ["acka", "ackah", "basha", "bashah", "boila", "boilah", "braka", "brakah", "brakka", "brakkah", "breaka", "breakah", "busta", "choppa", "choppah", "cleava", "cleavah", "clompa", "clompah", "cooka", "cookah", "cracka", "crackah", "crasha", "crashah", "crumpa", "crumpah", "crusha", "crushah", "cutta", "cuttah", "dagga", "daggah", "fang", "fist", "gasha", "gashah", "gutta", "guttah", "hacka", "hackah", "kleava", "kleavah", "krak", "kraka", "krakah", "krumpa", "krumpah", "krusha", "krushah", "rippa", "rippah", "shredda", "shreddah", "skar", "skorcha", "skorchah", "slasha", "slashah", "smasha", "smashah", "snagga", "snaggah", "snappa", "snappah", "spitta", "spittah", "splitta", "splittah", "stampa", "stampah", "stompa", "stompah", "trasha", "trashah", "wakka", "wakkah", "whacka", "whackah"];

	// Two modes: 1+2+3+4+5 or 6+7
	$firstname = $names1[array_rand($names1)] . $names2[array_rand($names2)] . $names3[array_rand($names3)] . $names4[array_rand($names4)] . $names5[array_rand($names5)];
	$lastname = $names6[array_rand($names6)] . $names7[array_rand($names7)];

	return ucfirst($firstname) . " " . $lastname;
}

function GetSistersOfBattleName()
{
	// Get a Sister of Battle name
	// From view-source:https://www.fantasynamegenerators.com/scripts/sistersOfBattleNames.js
	$FN1 = ["Agn", "Al", "Alic", "Am", "An", "Ar", "Arab", "Asp", "Bell", "Bren", "Brig", "Bris", "Cel", "Celest", "Chr", "Chris", "Chrism", "Dec", "Diss", "Dor", "Dyl", "Ell", "Ephr", "Ess", "Est", "Gal", "Gell", "Gin", "Gwyn", "Hann", "Hel", "Hen", "Hild", "Imm", "Immac", "Ion", "Ish", "Jen", "Jess", "Josm", "Jul", "Kat", "Kath", "Kess", "Kyl", "Let", "Leth", "Luc", "Lyn", "Mesh", "Min", "Mir", "Mor", "Og", "Ol", "Oliv", "Osh", "Pal", "Palm", "Phan", "Prax", "Res", "Rhian", "Rhiann", "Rienn", "Sab", "Sabr", "Sar", "Sel", "Seph", "Silv", "Syl", "Venn", "Ver", "Viss", "Vyl"];
	$FN2 = ["a", "ael", "ais", "ana", "ane", "anon", "ata", "atea", "arya", "ahla", "e", "ea", "edes", "ella", "ena", "enta", "erina", "erine", "es", "enya", "i", "ia", "iael", "iah", "icia", "ien", "ima", "ina", "ine", "ira", "iro", "isma", "itta", "ity", "iya", "on", "one", "osha", "oya", "olis", "oia", "onya", "olla", "o", "oris", "ora", "ulata", "uya", "une", "uah", "una"];

	$firstname = $FN1[array_rand($FN1)] . $FN2[array_rand($FN2)];
	$lastname = $FN1[array_rand($FN1)] . $FN2[array_rand($FN2)];
	return $firstname . " " . $lastname;
}

function GetTauName()
{
	$names1 = ["Aun'El", "Aun'La", "Aun'O", "Aun'Ui", "Aun'Vre", "Fio'El", "Fio'La", "Fio'O", "Fio'Ui", "Fio'Vre", "Kor'El", "Kor'La", "Kor'O", "Kor'Ui", "Kor'Vre", "Por'El", "Por'La", "Por'O", "Por'Ui", "Por'Vre", "Shas'El", "Shas'La", "Shas'O", "Shas'Saal", "Shas'Ui", "Shas'Vre"];
	$names2 = ["Au'taal", "Bor'kan", "Bork'an", "D'yanoi", "Dal'yth", "Elsy'eir", "Es'Tau", "Fal'shia", "Fi'rios", "Ho'sarn", "Ka'mais", "Ke'lshan", "Ksi'm'yen", "Me'lek", "Mu'gulath", "N'dras", "Pech", "Sa'cea", "Sha'draig", "T'au", "T'olku", "T'ros", "Tash'var", "Tau'n", "Vash'ya", "Velk'Han", "Vespid", "Vior'la"];
	$names3 = ["Al", "Ar", "Ash", "Bant", "Bra", "Bun", "Dia", "Dor", "Dra", "Fio", "Fir", "Fral", "Gir", "Gra", "Gras", "Har", "Hia", "Hova", "Inio", "Ir", "Irah", "Jax", "Jila", "Jol", "Kes", "Ko", "Krin", "Man", "Mira", "Mon", "Nar", "Nase", "Nori", "Ora", "Orna", "Oxa", "Pax", "Pira", "Prin", "Resh", "Ria", "Ril", "Shase", "Shi", "Sio", "Tor", "Tsu", "Tsua", "Var", "Vra", "Vura", "Wran", "Wua", "Wura", "Xira", "Xo", "Xral"];
	$names4 = ["'are", "'ath", "'ax", "'bash", "'bin", "'bur", "'dax", "'dis", "'dras", "'elo", "'en", "'erk", "'fa", "'fel", "'fin", "'ga", "'gos", "'gri", "'ha", "'hin", "'hos", "'jash", "'jin", "'jor", "'kir", "'ko", "'kran", "'la", "'las", "'len", "'me", "'min", "'mor", "'na", "'nera", "'nesh", "'or", "'os", "'osh", "'par", "'pin", "'pras", "'ra", "'rak", "'rax", "'sha", "'shash", "'som", "'taga", "'ter", "'tin", "'un", "'ur", "'us", "'vash", "'vax", "'vren", "'wer", "'werd", "'wra", "'xan", "'xil", "'xo", "'yr", "ah", "al", "aln", "an", "ara", "arn", "ash", "ax", "eh", "el", "en", "er", "erra", "es", "esh", "eth", "ina", "ir", "ira", "irn", "irr", "ish", "ith", "ix", "o", "oh", "ol", "om", "on", "or", "ot", "oth", "u", "ug", "un", "ur", "urn", "us", "uth", "ux"];

	return $names1[array_rand($names1)] . " " . $names2[array_rand($names2)] . " " . $names3[array_rand($names3)] . $names4[array_rand($names4)];
}

function GetTauFireName()
{
	$names1 = ["Shas'El", "Shas'La", "Shas'O", "Shas'Saal", "Shas'Ui", "Shas'Vre"];
	$names2 = ["Au'taal", "Bor'kan", "Bork'an", "D'yanoi", "Dal'yth", "Elsy'eir", "Es'Tau", "Fal'shia", "Fi'rios", "Ho'sarn", "Ka'mais", "Ke'lshan", "Ksi'm'yen", "Me'lek", "Mu'gulath", "N'dras", "Pech", "Sa'cea", "Sha'draig", "T'au", "T'olku", "T'ros", "Tash'var", "Tau'n", "Vash'ya", "Velk'Han", "Vespid", "Vior'la"];
	$names3 = ["Al", "Ar", "Ash", "Bant", "Bra", "Bun", "Dia", "Dor", "Dra", "Fio", "Fir", "Fral", "Gir", "Gra", "Gras", "Har", "Hia", "Hova", "Inio", "Ir", "Irah", "Jax", "Jila", "Jol", "Kes", "Ko", "Krin", "Man", "Mira", "Mon", "Nar", "Nase", "Nori", "Ora", "Orna", "Oxa", "Pax", "Pira", "Prin", "Resh", "Ria", "Ril", "Shase", "Shi", "Sio", "Tor", "Tsu", "Tsua", "Var", "Vra", "Vura", "Wran", "Wua", "Wura", "Xira", "Xo", "Xral"];
	$names4 = ["'are", "'ath", "'ax", "'bash", "'bin", "'bur", "'dax", "'dis", "'dras", "'elo", "'en", "'erk", "'fa", "'fel", "'fin", "'ga", "'gos", "'gri", "'ha", "'hin", "'hos", "'jash", "'jin", "'jor", "'kir", "'ko", "'kran", "'la", "'las", "'len", "'me", "'min", "'mor", "'na", "'nera", "'nesh", "'or", "'os", "'osh", "'par", "'pin", "'pras", "'ra", "'rak", "'rax", "'sha", "'shash", "'som", "'taga", "'ter", "'tin", "'un", "'ur", "'us", "'vash", "'vax", "'vren", "'wer", "'werd", "'wra", "'xan", "'xil", "'xo", "'yr", "ah", "al", "aln", "an", "ara", "arn", "ash", "ax", "eh", "el", "en", "er", "erra", "es", "esh", "eth", "ina", "ir", "ira", "irn", "irr", "ish", "ith", "ix", "o", "oh", "ol", "om", "on", "or", "ot", "oth", "u", "ug", "un", "ur", "urn", "us", "uth", "ux"];

	return $names1[array_rand($names1)] . " " . $names2[array_rand($names2)] . " " . $names3[array_rand($names3)] . $names4[array_rand($names4)];
}

function GetTyranidName()
{
	// Get a Tyranid name
	$an1 = ["br", "c", "cr", "dr", "g", "gh", "gr", "k", "kh", "kr", "n", "q", "qh", "sc", "scr", "str", "st", "t", "tr", "thr", "v", "vr", "x", "z", "", "", "", "", ""];
	$an2 = ["ae", "aa", "ai", "au", "uu", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u"];
	$an3 = ["c", "k", "n", "q", "t", "v", "x", "z", "c", "cc", "cr", "cz", "dr", "gr", "gn", "gm", "gv", "gz", "k", "kk", "kn", "kr", "kt", "kv", "kz", "lg", "lk", "lq", "lx", "lz", "nc", "ndr", "nkr", "ngr", "nk", "nq", "nqr", "nz", "q", "qr", "qn", "rc", "rg", "rk", "rkr", "rq", "rqr", "sc", "sq", "str", "t", "v", "vr", "x", "z", "q'", "k'", "rr", "r'", "t'", "tt", "vv", "v'", "x'", "z'", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", ""];
	$an4 = ["", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "oi", "ie", "ai", "ei", "eo", "ui"];
	$an5 = ["d", "ds", "k", "ks", "l", "ls", "n", "ns", "ts", "x"];

	$bn1 = ["b", "bh", "ch", "d", "dh", "f", "h", "l", "m", "n", "ph", "r", "s", "sh", "th", "v", "y", "z", "", "", "", "", "", "", "", "", ""];
	$bn2 = ["ae", "ai", "ee", "ei", "ie", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u"];
	$bn3 = ["c", "d", "g", "h", "l", "m", "n", "r", "s", "v", "z", "c", "ch", "d", "dd", "dh", "g", "gn", "h", "hl", "hm", "hn", "hr", "l", "ld", "ldr", "lg", "lgr", "lk", "ll", "lm", "ln", "lph", "lt", "lv", "lz", "m", "mm", "mn", "mh", "mph", "n", "nd", "nn", "ng", "nk", "nph", "nz", "ph", "phr", "r", "rn", "rl", "rz", "s", "ss", "sl", "sn", "st", "v", "z", "s'", "l'", "n'", "m'", "f'", "h'"];
	$bn4 = ["a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "oi", "ie", "ai", "ea", "ae"];
	$bn5 = ["", "", "", "", "d", "ds", "h", "l", "ll", "n", "ns", "r", "rs", "s", "t", "th"];

	$cn1 = ["b", "bh", "br", "c", "ch", "cr", "d", "dh", "dr", "f", "g", "gh", "gr", "h", "k", "kh", "kr", "l", "m", "n", "q", "qh", "ph", "r", "s", "sc", "scr", "sh", "st", "str", "t", "th", "thr", "tr", "v", "vr", "y", "x", "z", "", "", "", "", "", "", ""];
	$cn2 = ["ae", "aa", "ai", "au", "ee", "ei", "ie", "uu", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u"];
	$cn3 = ["c", "d", "g", "h", "k", "l", "m", "n", "q", "r", "s", "t", "v", "z", "c", "d", "g", "h", "k", "l", "m", "n", "q", "r", "s", "t", "v", "z", "c", "cc", "ch", "cr", "cz", "d", "dd", "dh", "dr", "g", "gm", "gn", "gr", "gv", "gz", "h", "hl", "hm", "hn", "hr", "k", "k'", "kk", "kn", "kr", "kt", "kv", "kz", "l", "ld", "ldr", "lg", "lgr", "lk", "ll", "lm", "ln", "lph", "lq", "lt", "lv", "lx", "lz", "m", "mh", "mm", "mn", "mph", "n", "nc", "nd", "ndr", "ng", "ngr", "nk", "nkr", "nn", "nph", "nq", "nqr", "nz", "ph", "phr", "q", "q'", "qn", "qr", "r", "r'", "rc", "rg", "rk", "rkr", "rl", "rn", "rq", "rqr", "rr", "rz", "s", "sc", "sl", "sn", "sq", "ss", "st", "str", "t", "t'", "tt", "v", "v'", "vr", "vv", "x", "x'", "z", "z'", "", "", "", "", "", "", "", "", "", "", ""];
	$cn4 = ["", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "a", "e", "i", "o", "u", "oi", "ie", "ai", "ea", "ae"];
	$cn5 = ["d", "ds", "k", "ks", "l", "ll", "ls", "n", "ns", "r", "rs", "s", "t", "ts", "th", "x", "", "", "", ""];

	$name = "";

	for ($i = 0; $i < 2; $i++) {
		if ($i > 0) {
			$name .= " ";
		}

		$style = rand(1, 3);
		switch ($style) {
			case 1:
				$name .= ucwords($an1[array_rand($an1)] . $an2[array_rand($an2)] . $an3[array_rand($an3)] . $an4[array_rand($an4)] . $an5[array_rand($an5)]);
				break;
			case 2:
				$name .= ucwords($bn1[array_rand($bn1)] . $bn2[array_rand($bn2)] . $bn3[array_rand($bn3)] . $bn4[array_rand($bn4)] . $bn5[array_rand($bn5)]);
				break;
			case 3:
				$name .= ucwords($cn1[array_rand($cn1)] . $cn2[array_rand($cn2)] . $cn3[array_rand($cn3)] . $cn4[array_rand($cn4)] . $cn5[array_rand($cn5)]);
				break;
		}
	}

	// Done
	return $name;
}
