<?php
session_start();
include 'inc/config.php';

if (!isset($_GET['logout']) && isset($_SESSION['steamid']))
{
	$steamid = $_SESSION['steamid'];
	
	// fancy info so user knows he's logged in
	if (!isset($_SESSION['user_info']))
	{	
		$user_info_url = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?format=json&key=' . $api_key . '&steamids=' . $steamid;
		$user_info = json_decode(file_get_contents($user_info_url), true);
		$_SESSION['user_info'] = $user_info['response']['players'][0];
	}
	$smarty->assign('user_info', $_SESSION['user_info']);
	
	// get group memberlist from cache or web
	if (file_exists($memberlist_file) && filemtime($memberlist_file) > time() - $memberlist_update_time)
	{
		// load from cache if file exists and file modification time is less than an hour
		$memberlist = simplexml_load_file($memberlist_file);
	}
	else
	{
		// get memberlist from web and save it to cache
		$group_url .= ($group_url[strlen($group_url) - 1] != '/') ? '/' : ''; // add trailing slash
		$memberlist = file_get_contents($group_url . 'memberslistxml/?xml=1');
		file_put_contents('safe://' . $memberlist_file, $memberlist);
		$memberlist = new SimpleXMLElement($memberlist);
	}
	
	$found = in_array($steamid, $memberlist->xpath('/memberList/members/steamID64'));
	
	if ($found)
	{
		$claimed_keys_array = json_decode(file_get_contents($claimed_keys_file), true);
		foreach ($claimed_keys_array as $arr)
		{
			foreach($arr as $k => $id)
			{
				if ($id === $steamid) // yay, big numbers
					$key = $k;
			}
		}
		if (!isset($key))
		{
			// user doesn't have a key, give it to him
			// safe operations with files (no keys duplicity) provided by inc/SafeStream.php - see http://doc.nette.org/en/atomicity
			
			$keys = file_get_contents('safe://' . $bundle_keys);
			$keys = json_decode($keys);
			$key = array_pop($keys);
			$claimed_keys_array[] = array($key => $steamid);
			file_put_contents('safe://' . $claimed_keys_file, json_encode($claimed_keys_array));
			file_put_contents('safe://' . $bundle_keys, json_encode($keys));
		}
		
		$smarty->assign('key', $key);
	}
	
	$keys = file_get_contents($bundle_keys);
	$smarty->assign('remaining_keys', count(json_decode($keys)));
	
	$smarty->display('loggedin.tpl');
}
else
{
	try {
		$openid = new LightOpenID($_SERVER['HTTP_HOST']);
		if(!$openid->mode)
		{
			if(isset($_GET['login']))
			{
				$openid->identity = 'http://steamcommunity.com/openid';
				header('Location: ' . $openid->authUrl());
			}
			elseif (isset($_GET['logout']))
			{
				session_destroy();
				$openid->mode = 'cancel';
				header('Location: ./');
			}
			else
			{
				$smarty->display('login.tpl');
			}
		}
		else
		{
			if ($openid->validate())
			{
				$steamid = substr($openid->identity, strrpos($openid->identity, '/') + 1);
				$_SESSION['steamid'] = $steamid;
				header('Location: ./');
			}
		}
	}
	catch(ErrorException $e)
	{
		print $e->getMessage();
	}
}