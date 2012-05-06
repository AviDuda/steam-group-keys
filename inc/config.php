<?php
$api_key = ''; // visit http://steamcommunity.com/dev to obtain your Steam Web API key
$group_url = ''; // http://steamcommunity.com/groups/GroupName or http://steamcommunity.com/gid/GroupID

$bundle_keys = 'inc/keys.json';
$claimed_keys_file = 'inc/claimed_keys.json';
$memberlist_file = 'inc/memberlist.json';
$memberlist_update_time = 3600; // in seconds
$admins_file = "inc/admins.json";

// don't forget to change error reporting to off on your production server
ini_set('display_errors', 1);
error_reporting(E_ALL|E_STRICT);

include 'functions.php';
include 'openid.php';
include 'SafeStream.php';
include 'smarty/Smarty.class.php';
include 'SteamAPI.php';

SafeStream::register();
$smarty = new Smarty();
$api = new SteamAPI($api_key);