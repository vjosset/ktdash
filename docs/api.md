# API

The KTDash API allows developers to build custom front-ends leveraging the KTDash back-end and database.

# Faction

A Faction represents a game faction, and each faction contains its associated killteams.

## Endpoint

`/api/faction.php`

## Access

Anonymous

## Fields

- `factionid` - Unique identifier for this faction
- `factionname` - Name of this faction
- `description` - HTML-formatted paragraph describing this faction
- `killteams` - Array of `KillTeam` objects belonging to this faction

## API Methods

`GET /api/faction.php`

Returns an array of all factions

### Parameters

- `edition` - Filter to return only KillTeams that match the edition. Returns both editions if not set. Returns Factions with empty KillTeams if they don't have any KillTeams for the requested edition.
  - Values: `kt21` or `kt24`
- `loadkts` - Set to `1` to include KillTeams for each Faction. Defaults to `0`.
- `loadops` - Set to `1` to include Operatives in each KillTeam. Defaults to `0`.
- `fa` - FactionID of the faction to return. Returns all Factions if not set.

### Examples

`GET /api/faction.php?fa=IMP&loadkts=1&edition=kt24`

Returns all KT2024 KillTeams for the "Imperium" faction

# KillTeam

A KillTeam represents a unique KillTeam belonging to a faction, and each KillTeam contains its associated fireteams.

## Endpoint

`/api/killteam.php`

## Access

Anonymous

## Fields

- `factionid` - ID of the faction this KillTeam belongs to
- `killteamid` - Unique identifier for this KillTeam
- `edition` - The Killteam edition for this KillTeam (`kt21` or `kt24`)
- `killteamname` - Name of this KillTeam
- `description` - HTML-formatted paragraph describing this KillTeam
- `customkeyword` - Used in Roster building to override special KillTeam keywords (e.g. `<CHAPTER>` for Space Marines)
- `ploys` - Container object/wrapper for this KillTeam's ploys
  - `strat` - Array of strategic `Ploy` objects
  - `tac` - Array of tactical `Ploy` objects
- `equipments` - Array of Equipment objects for this KillTeam
- `killteamcomp` - HTML-formatted paragraph describing this KillTeam's composition
- `fireteams` - Array of `FireTeam` objects belonging to this KillTeam
- `tacops` - Array of `TacOp` objects belonging to this KillTeam
- `rosters` - Array of `Roster` objects for all spotlighted rosters for this KillTeam

## API Methods

`GET /api/killteam.php`

Returns an array of all KillTeams

### Parameters

- `edition` - Filter to return only KillTeams that match the edition. Returns both editions if not set. Returns Factions with empty KillTeams if they don't have any KillTeams for the requested edition.
  - Values: `kt21` or `kt24`
- `fa` - FactionID of the faction to return. Returns all Factions if not set.
- `kt` - KillteamID of the killteam to return. Returns all killteams if not set.

### Examples

`GET /api/faction.php?fa=IMP&edition=kt24`

Returns all KT2024 KillTeams for the "Imperium" faction

`GET /api/killteam.php?fa=IMP&kt=AOD`

Returns the requested "Angels Of Death" KillTeam

# FireTeam

A FireTeam represents a unique FireTeam belonging to a KillTeam, and each FireTeam contains its associated Operatives.

## Endpoint

[No endpoint]

## Access

Anonymous

## Fields

- `factionid` - ID of the faction this FireTeam belongs to
- `killteamid` - ID of the KillTeam this FireTeam belongs to
- `fireteamid` - Unique identifier for this FireTeam
- `seq` - Ordering sequence
- `fireteamname` - Name of this FireTeam
- `archetype` - Slash-separated list of Archtetypes assigned to this FireTeam
- `description` - HTML-formatted paragraph describing this FireTeam
- `killteammax` - (unused)
- `operatives` - Array of `Operative` objects belonging to this FireTeam
- `fireteamcomp` - HTML-formatted paragraph describing this FireTeam's composition. Note that if a KillTeam only has one FireTeam, this content will be empty and can be ignored.

# Operative

An Operative represents a unique operative belonging to a FireTeam.

## Endpoint

[No endpoint]

## Fields

- `factionid` - ID of the faction this FireTeam belongs to
- `killteamid` - ID of the KillTeam this FireTeam belongs to
- `fireteamid` - ID of the FireTeam this FireTeam belongs to
- `opid` - Unique ID for this operative
- `opseq` - Ordering sequence
- `opname` - Name of this operative
- `description` - HTML-formatted paragraph describing this operative
- `M`, `APL`, `GA`, `DF`, `SV`, `W` - Operative characteristics/stats
- `keywords` - Comma-separated list of keywords assigned to this Operative
- `weapons` - Array of `Weapon` objects that can be selected for this Operative
- `uniqueactions` - Array of `UniqueAction` objects that this Operative can perform
- `abilities` - Array of `Ability` objects assigned to this Operative
- `abilities` - Array of `Ability` objects assigned to this Operative
- `edition` - The Killteam edition for this KillTeam (`kt21` or `kt24`)
- `fireteammax` - (unused)
- `specialisms` - Comma-separated list of specialisms assigned to this Operative (e.g. "Staunch, Combat, Marksman, Scout")

# Weapon

A Weapon represents a weapon that can be equipped by an Operative.

## Endpoint

[No endpoint]

## Fields

- `factionid` - ID of the faction this Weapon belongs to
- `killteamid` - ID of the KillTeam this Weapon belongs to
- `fireteamid` - ID of the FireTeam this Weapon belongs to
- `opid` - ID of the operative that can equip this Weapon
- `wepid` - Unique identifier for this Weapon
- `wepseq` - Ordering sequence
- `wepname` - Name of this weapon
- `weptype` - Type of weapon -`M` for Melee, `R` for Ranged
- `isdefault` - 1 or 0 indicating whether this Weapon should be equipped by default for its assigned Operative
- `profiles` - Array of `WeaponProfile` objects belonging to this Weapon
- `isselected` - Used for creating new Operatives or editing existing Operatives

# WeaponProfile

A WeaponProfile represents a unique profile for a given Weapon.

## Endpoint

[No endpoint]

## Fields

- `factionid` - ID of the faction this WeaponProfile belongs to
- `killteamid` - ID of the KillTeam this WeaponProfile belongs to
- `fireteamid` - ID of the FireTeam this WeaponProfile belongs to
- `opid` - ID of the operative that can equip this Weapon
- `wepid` - ID of the weapon this WeaponProfile belongs to
- `profileid` - ID of this WeaponProfile
- `name` - Name of this WeaponProfile
- `A`, `BS`, `D` - Characteristics/stats for this weapon profile. Note that the field is labeled `BS` for all Weapon Types (instead of `WS` for Melee weapons)
- `SR` - Comma-separated list of special and critical hit rules for this WeaponProfile
- `wepseq` - Ordering sequence
- `wepname` - Name of this weapon
- `weptype` - Type of weapon -`M` for Melee, `R` for Ranged
- `isdefault` - 1 or 0 indicating whether this Weapon should be equipped by default for its assigned Operative
- `profiles` - Array of `WeaponProfile` objects belonging to this Weapon
- `isselected` - Used for creating new Operatives or editing existing Operatives

# UniqueAction

A UniqueAction represents a unique action that an Operative can perform.

## Endpoint

[No endpoint]

## Fields

- `factionid` - ID of the faction this UniqueAction belongs to
- `killteamid` - ID of the KillTeam this UniqueAction belongs to
- `fireteamid` - ID of the FireTeam this UniqueAction belongs to
- `opid` - ID of the operative that can perform this UniqueAction
- `uniqueactionid` - Identifier for this UniqueAction
- `title` - Title of this UniqueAction
- `description` - HTML-formatted paragraph describing this UniqueAction
- `AP` - Cost in Action Points to perform this UniqueAction

# Ability

An Ability represents a special ability assigned to an Operative.

## Endpoint

[No endpoint]

## Fields

- `factionid` - ID of the faction this Ability belongs to
- `killteamid` - ID of the KillTeam this Ability belongs to
- `fireteamid` - ID of the FireTeam this Ability belongs to
- `opid` - ID of the operative that has this Ability
- `abilityid` - Identifier for this Ability
- `title` - Title of this Ability
- `description` - HTML-formatted paragraph describing this UniqueAction

# User

A User represents a unique user of the application and contains their user name and rosters. All user rosters are public.  
This endpoint is used to get user information, sign up a new user, and update existing user records (with proper authentication).

## Endpoint

`/api/user.php`

## Access

Anonymous/authenticated

## Fields

- `userid` - ID of the user
- `username` - Name of the user
- `rosters` - Array of Roster objects belonging to this user
- `createddate` - Date and time (GMT-4) when this user signed up/was created

## API Methods

`GET /api/user.php?username=[username]`

### Parameters

- `username` - The name of the user whose information to return

### Examples

`GET /api/user.php?username=jodawznev`

# Session

A Session represents a logged-in user's session.  
This endpoint is used for user session validation, log in, and log out.

## Endpoint

`/api/session.php`

## Access

Access: Anonymous/authenticated

## Fields

- `userid` - ID of the current session's user
- `username` - Name of the current session's user
- `rosters` - Array of Roster objects belonging to this current session's user
- `createddate` - Date and time (GMT-4) when this current session's user signed up/was created

## API Methods

### Get current session

`GET /api/session.php`

Returns the current user if they are signed in (based on the session cookie).
Returns `HTTP 401` if not signed in.

### Log in

`POST /api/session.php?`

Signs the user in

#### Input

- `username` - The name of the user signing in
- `password` - The password of the user signing in

#### Output

The signed-in user's User object

# Roster

A Roster represents one roster built by a given user and contains that roster's operatives.

## Endpoint

`/api/roster.php`

## Access

Access: Anonymous/authenticated

## Fields

- `rosterid` - ID of the roster
- `userid` - ID of the roster's owner/user
- `seq` - Sequencing number of this roster
- `rostername` - Name of this roster
- `factionid` - ID of the faction this roster belongs to
- `killteamid` - ID of the killteam this roster belongs to
- `edition` - Edition of the killteam for this roster (`kt21` or `kt24`)
- `ployids` - Comma-separated list of PloyIDs currently in effect for this roster
- `tacopids` - Comma-separated list of TacOpIDs currently in effect for this roster
- `notes` - Free text paragraph describing this roster
- `portraitcopyok` - `1` indicates that roster and operative portraits will be copied when this roster is imported by another user. `0` indicates that portraits will not be copied when imported by another user.
- `keyword` - For killteams that have a keyword placeholder (e.g. `<CHAPTER>` for Space Marines), indicates the value to use
- `operatives` - Array of RosterOperative objects representing the members of this roster
- `tacops` - Array of TacOp objects currently in effect for this roster
- `username` - Name of the user this roster belongs to
- `hascustomportrait` - `1` indicates this roster has a custom portrait. `0` indicates it does not.
- `TP` - Current Turning Point for this roster
- `CP` - Current Command Points for this roster
- `VP` - Current Victory Points for this roster
- `RP` - Current Resource Points (e.g. Faith Points for Novitiates) for this roster
- `spotlight` - `1` indicates this roster was selected for the spotlight
- `factionname` - Name of the faction this roster belongs to
- `killteamname` - Name of the killteam this roster belongs to
- `killteamcustomkeyword` - Placeholder in operatives' keywords to replace with this roster's `keyword`
- `killteamdescription` - Description of this roster's killteam
- `oplist` - Comma-separated list of distinct operative types in this roster
- `viewcount` - Number of times this roster was viewed by a user other than its owner/user
- `importcount` - Number of times this roster was imported by a user other than its owner/user
- `reqpts` - Requisition points (narrative play) for this roster
- `stratnotes` - Strategy notes for this roster
- `eqnotes` - Equipment notes for this roster
- `specopnotes` - SpecOps notes for this roster

## API Methods

### Get current user's rosters

`GET /api/roster.php`

Returns all rosters for the currently signed-in user.
Returns `HTTP 401` if not signed in.

### Get a roster/Get a user's rosters

`GET /api/roster.php?rid=[rosterid]&uid=[userid]&loadrosterdetail=[loadrosterdetail]`

#### Input

- `rid` - The RosterID of the roster whose information to return. Returns all the specified user's rosters if not set.
- `uid` - The UserID of the user whose rosters to return. Returns the currently signed-in user's rosters if not set.
- `loadrosterdetail` - `1` returns operative details in the `operatives` field. Defaults to `0`.

# RosterOperative

A RosterOperative represents a single Operative assigned to a Roster, tying that Roster to the matching Operative object.

## Endpoint

`/api/rosteroperative.php`

## Access

Anonymous/authenticated

## Fields

- [TBD]

# Authentication

Authentication is handled with a cookie tied to the `ktdash.app` domain.

## Get User Session

`GET /api/session.php`

Validates a user's session (check if they are logged in)

## Log In

`POST /api/session.php`

Creates a new session for the specified user.

### Input

- `login` - The user's username
- `password` - The user's password

### Output

- `userid` - The user's unique user ID
- `username` - The user's username (also unique)
- `rosters` - An array of rosters associated with the user record (empty in this response)
- `createddate` - DateTime of user creation/signup

### Response Cookie

The response of this API method includes a cookie holding the logged-in user's session. This cookie should be included in all subsequent API requests to ensure the user has the necessary access and permissions for each API method.

## Log Out

`DELETE /api/session.php`

Logs the user out by deleting their session.

### Input

No input other than the current user's session cookie (See Log In above)

### Output

String `OK`
