<?php
/**
 * Small utility for creating keys for testing. 
 */

include 'inc/config.php';

$generate_keys = 50;
$key_length = 15; // without separators
$separator_after_chars = 5; // e.g. 5 => ABCDE-FGHIJ if $separator == '-'
$separator = '-';

$keys = array();
$characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

for ($i = 0; $i < $generate_keys; $i++)
{
	$key = '';
	for ($char = 0; $char < $key_length + ($key_length / $separator_after_chars) - 1; $char++)
	{
		if (($char + 1) % ($separator_after_chars + 1) == 0)
		{
			$key .= $separator;
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