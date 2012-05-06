<?php
session_start();

include 'inc/config.php';

// get group member list from cache or web
if (file_exists($memberlist_file) && ($memberlist_update_time - (time() - filemtime($memberlist_file))) > 0)
{
	if (!($memberlist = json_decode(file_get_contents($memberlist_file))) || empty($memberlist) || !is_array($memberlist) || !is_numeric($memberlist[0]))
	{
		$memberlist = memberlist_save($group_url, $memberlist_file, $api);
	}
}
else
{
	$memberlist = memberlist_save($group_url, $memberlist_file, $api);
}

if (!isset($_GET['page']))
{
	$_GET['page'] = 'index';
}

if (!in_array($_GET['page'], array('login', 'logout')) && isset($_SESSION['steamid']))
{
	// user is logged in
	
	$steamid = $_SESSION['steamid'];
	
	// fancy info so user knows he's logged in
	if (!isset($_SESSION['user_info']))
	{	
		$user_info = $api->playerInfo($steamid);
		$_SESSION['user_info'] = $user_info['response']['players'][0];
	}
	$smarty->assign('user_info', $_SESSION['user_info']);
	
	$is_admin = false;
	$admins = json_decode(file_get_contents($admins_file));
	if (in_array($steamid, $admins, true))
	{
		$is_admin = true;
	}
	$smarty->assign('is_admin', $is_admin);
	
	if ($_GET['page'] != 'index' && file_exists('./controllers/' . $_GET['page'] . '.php'))
	{
		include './controllers/' . $_GET['page'] . '.php';
	}
	else
	{
		include './controllers/index.php';
	}
}
else
{
	try {
		$openid = new LightOpenID($_SERVER['HTTP_HOST']);
		if(!$openid->mode)
		{
			if($_GET['page'] == 'login')
			{
				$openid->identity = 'http://steamcommunity.com/openid';
				header('Location: ' . $openid->authUrl());
			}
			elseif ($_GET['page'] == 'logout')
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
		print 'Error. Contact group admins, please.';
	}
}