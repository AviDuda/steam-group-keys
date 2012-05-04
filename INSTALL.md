Requirements
=============

You need a free [Steam Web API key](http://steamcommunity.com/dev).

You **DON'T** need cURL enabled.

```chmod 777``` may be required on some hosting services for these files (if you don't change the source code):

- ```inc/admins.json```
- ```inc/claimed_keys.json```
- ```inc/groupmembers.xml```
- ```inc/keys.json```

Installation
=============

- Put your API key and the Steam Community group URL to ```inc/config.php```.
- Insert your SteamID64 as an admin to ```inc/admins.json```. You can find your SteamID64 number on http://steamidconverter.com (second field).
- Put keys in the JSON array format to ```inc/keys.json``` as seen in the default keys.
- **Don't forget to change error reporting to off on your production server in ```inc/config.php```.**