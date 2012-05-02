<?php
include 'inc/config.php';

$generate_keys = 50;

$keys = array();
$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

for ($i = 0; $i < $generate_keys; $i++)
{
	$key = '';
	for ($char = 0; $char < 17; $char++)
	{
		// generated key example: 4Y0UQ-3UREO-V2QFE
		if ($char == 5 || $char == 11)
		{
			$key .= '-';
		}
		else
		{
			$add = $characters[rand(0, strlen($characters) - 1)];
			$key .= $add;
		}
	}
	if (in_array($key, $keys))
	{
		$i -= 1;
	}
	else
	{
		$keys[] = $key;
	}
}
$keys = json_encode($keys);
if (file_put_contents($bundle_keys, $keys))
{
	print 'Keys generated.';
}
else print 'Error';

print '<br><a href="./">Home</a>';