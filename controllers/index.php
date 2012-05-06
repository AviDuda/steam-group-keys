<?php
$found = in_array($steamid, $memberlist, true);

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

$smarty->display('index.tpl');