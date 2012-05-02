Basic info
=============

steam-group-keys is a website in PHP which allows Steam groups to easily make giveaways for its members.
These groups can be public or private.

This project isn't completed and can be unstable. Use at your own risk.

How does this project work
=============

1. User visits your giveaway website.
2. User sign-ins using Steam OpenID which uses the same credentials as their Steam login.
3. Website gets only user's steamID64 from this login information.
4. Website fetches (or gets it from cache if not old) group memberlist and checks if the user is in the specified group.
If this user is in group, it will give him the last key from available keys and moves it to the list of used keys with his steamID64. This user can't redeem another key.

Requirements
=============

You need a [Steam Web API key](http://steamcommunity.com/dev) which you can paste to file inc/config.php.
You **DON'T** need cURL enabled.

Useful tools
=============

You can use keys_generator.php to test your website with random keys.

Future features
=============

- Better design. No time right now.
- Multi-user admin panel with easy options to generate keys, flush claimed keys etc.
- Do not allow some users in group to claim keys. I hate cheaters, so I will maybe automatically ban VAC banned users.