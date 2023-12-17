# API

The KTDash API allows developers to build custom front-ends leveraging the KTDash back-end and database.

# Objects

## Faction

Endpoint `/api/faction.php`

A Faction represents a game faction, and each faction contains its associated killteams.

Fields:
- `factionid`

## KillTeam

`/api/killteam.php`

A KillTeam represents a unique KillTeam belonging to a faction, and each KillTeam contains its associated fireteams.

## FireTeam

`/api/fireteam.php`

A FireTeam represents a unique FireTeam belonging to a KillTeam, and each FireTeam contains its associated Operatives.

## Operative

`/api/operative.php`

An Operative represents a unique operative belonging to a FireTeam.

# Authentication

Authentication is handled with a cookie tied to the `ktdash.app` domain.

## Log In

`POST /api/session.php`

Creates a new session for the specified user.

**Input:**
- `login` - The user's username
- `password` - The user's password

**Output:**
- User object
  - `userid` - The user's unique user ID
  - `username` - The user's username (also unique)
  - `rosters` - An array of rosters associated with the user record (empty in this response)
  - `createddate` - DateTime of user creation/signup

**Response Cookie:**
The response of this API method includes a cookie holding the logged-in user's session. This cookie should be included in all subsequent API requests to ensure the user has the necessary access and permissions for each API method.

## Log Out

`DELETE /api/session.php`

Logs the user out by deleting their session.

**Input:**
- No input other than the current user's session cookie (See Log In above)

**Output:**
- String `OK`