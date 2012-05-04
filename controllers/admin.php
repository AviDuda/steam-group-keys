<?php
if (!$is_admin)
{
	die('You are not an admin. That means another 2 months to the Half-Life 3 release date.');
}

if (isset($_GET['action']))
{
	if ($_GET['action'] == 'claimedkeys')
	{
		$keys = json_decode(file_get_contents($claimed_keys_file), true);
		if (count($keys) > 0)
		{
			$keys_o = array();
			$users = array();
			foreach ($keys as $key)
			{
				foreach ($key as $v)
				{
					$users[] = $v;
				}
			}
			$keys_users = $api->playerInfo($users);
			foreach($keys_users['response']['players'] as $user)
			{
				$position = array_search($user['steamid'], $users);
				$keyval = key($keys[$position]);
				$val = array_values($keys[$position]);
				$keys_final[] = array($keyval, $user);
			}
			$smarty->assign('keys', $keys_final);
		}
		
		if (isset($_GET['message']) && $_GET['message'] == 'flush')
		{
			$smarty->assign('messageFlushed', true);
		}
		
		$smarty->display('admin_claimedkeys.tpl');
	}
	elseif ($_GET['action'] == 'claimedkeysflush')
	{
		file_put_contents($claimed_keys_file . '.bak', file_get_contents($claimed_keys_file));
		file_put_contents('safe://' . $claimed_keys_file, json_encode(array()));
		header('Location: ./?page=admin&action=claimedkeys&message=flush');
	}
	elseif ($_GET['action'] == 'claimedkeydelete')
	{
		if (isset($_GET['key']))
		{
			$keys = json_decode(file_get_contents($claimed_keys_file), true);
			 for ($i = 0; $i < count($keys); $i++)
			{
				if (key($keys[$i]) == $_GET['key'])
				{
					unset($keys[$i]);
				}
			}
			$keys = array_merge($keys);
			file_put_contents('safe://' . $claimed_keys_file, json_encode($keys));
			header('Location: ./?page=admin&action=claimedkeys');
		}
		
	}
	elseif ($_GET['action'] == 'admindelete')
	{
		if (!isset($_GET['id']))
		{
			header('Location: ./?page=admin');
		}
		if ($_GET['id'] == $steamid)
		{
			die('You can\'t delete yourself from the list of admins.');
		}
		if ((in_array($_GET['id'], $admins)))
		{
			unset($admins[array_search($_GET['id'], $admins)]);
			$admins = array_values($admins);
			file_put_contents('safe://' . $admins_file, json_encode($admins));
			header('Location: ./?page=admin');
		}
		else
		{
			die('It isn\'t an admin.');
		}
	}
	elseif ($_GET['action'] == 'updatememberlist')
	{
		file_put_contents('safe://' . $memberlist_file, $api->getProfile($group_url, 'group'));
		header('Location: ./?page=admin');
	}
}
else
{
	$admins_info = $api->playerInfo($admins);
	
	$smarty->assign("admins", $admins_info['response']['players']);
	$smarty->assign('memberlist_update', $memberlist_update_time - (time() - filemtime($memberlist_file)));
	
	$smarty->display('admin.tpl');
}