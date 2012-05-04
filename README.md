Basic info
=============

```steam-group-keys``` is a website in PHP which allows [Steam](http://store.steampowered.com/) groups to easily make giveaways for its members.
These groups can be public or private.

This project was originally developed for [Subsoap](http://subsoap.com/), an indie game developer mainly known for [Faerie Solitaire](http://subsoap.com/games/faerie-solitaire-classic/).
Source code was used for gifting [Infinity Bundle promotion](http://infinitybundle.com/) keys to their [beta testing Steam group](http://steamcommunity.com/groups/SubsoapBeta) members.

This project isn't completed and can be unstable. Use at your own risk.

Project license: [Do What The Fuck You Want To Public License (WTFPL)](https://github.com/TomasDuda/steam-group-keys/blob/master/LICENSE) - [more info](http://sam.zoy.org/wtfpl/)

How does this project work
=============

1. User visits your giveaway website.
2. User sign-ins using Steam OpenID which uses the same credentials as their Steam login.
3. Website gets only user's steamID64 from this login information.
4. Website fetches the group member list from web or cache and checks if the user is in the specified group.
  If this user is in group, it will give him the last key from available keys and moves it to the list of used keys with his steamID64. This user can't redeem another key.

Features
=============

- CD key giveaways for Steam group members
- No registration for users - they need just a Steam account to sign in with [OpenID](http://openid.net/)
- Multi-user admin panel
	- List and delete claimed keys
	- List and delete admins
- Half-Life 3 easter egg

Future features
=============

- Better design. If you could help me with that, I would be very happy.
- Admin panel with more options like uploading new available keys, option for banning new group users from giveaways etc.

Post your suggestions to [Issues](https://github.com/TomasDuda/steam-group-keys/issues).

Useful tools
=============

- Keys generator ```util/keys_generator.php``` is useful for testing your website with randomly generated keys before launching it.
- Steam API class ```inc/SteamAPI.php``` is a set of useful functions to make work with Steam Web API easier.

Requirements and installation
=============

Instructions are in the file [INSTALL.md](https://github.com/TomasDuda/steam-group-keys/blob/master/INSTALL.md).

Questions?
=============

You can reach me on [Steam](http://steamcommunity.com/id/TimmyCZ), [Google+](https://plus.google.com/115475439151280722618/posts), and [Twitter](https://twitter.com/tomasduda).