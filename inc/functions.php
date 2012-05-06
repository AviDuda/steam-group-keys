<?php
function memberlist_save($group_url, $memberlist_file, $api)
{
	libxml_use_internal_errors(true);
	$attempts_for_one_file = 5;
	$attempts = $attempts_for_one_file;
	$memberlist = array();
	$totalPages = 1;
	$currentPage = 1;
	
	while ($attempts > 0)
	{
		try
		{
			while ($currentPage < $totalPages + 1)
			{
				$memberlist_xml;
				if (($memberlist_xml = @$api->getProfile($group_url, 'group', $currentPage)) != false)
				{
					$memberlist_xml = new SimpleXMLElement($memberlist_xml);
					$members = $memberlist_xml->xpath('/memberList/members/steamID64');
					if (!is_array($members) || !$members || count($members) == 0)
					{
						throw new Exception;
					}
					foreach ($members as $member)
					{
						$memberlist[] = (string) $member;
					}

					$totalPages = (int) $memberlist_xml->totalPages;
					$currentPage = (int) $memberlist_xml->currentPage + 1;
					$attempts = $attempts_for_one_file;
				}
				else
				{
					throw new Exception;
				}
			}
		}
		catch (Exception $e)
		{
			if ($attempts == 1)
			{
				die('Unable to fetch the group memberlist. Steam servers may be overloaded, wait a minute and reload the page.');
			}
			$attempts -= 1;
		}
		
		file_put_contents($memberlist_file, json_encode($memberlist));
		return $memberlist;
	}
}