Requirements
=============

You need a free [Steam Web API key](http://steamcommunity.com/dev).

You **DON'T** need cURL enabled.

```chmod 777``` may be required on some hosting services for these files (if you don't change the source code):

- ```inc/admins.json```
- ```inc/claimed_keys.json```
- ```inc/keys.json```
- ```inc/memberlist.json```
- folder ```templates_c```

Installation
=============

- Put your API key and the Steam Community group URL to ```inc/config.php```.
- Insert your SteamID64 as an admin to ```inc/admins.json```. You can find your SteamID64 number on http://steamidconverter.com (second field).
- Put keys in the JSON array format to ```inc/keys.json``` as seen in the default keys.
- Remove ```util/keys_generator.php``` after you have a real set of keys, otherwise users who know about this project could rewrite your ```inc/keys.json```.
- **Don't forget to change error reporting to off on your production server in ```inc/config.php```.**