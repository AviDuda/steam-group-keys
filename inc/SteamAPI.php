<?php
/**
 * SteamAPI
 * 
 * Class providing easier access to the Steam Web API.
 * 
 * @author Tomáš Duda <tomasduda@tomasduda.cz>
 */

class SteamAPI
{
	protected $apiKey;
	
	/**
	 * SteamAPI class constructor
	 * @param string $apiKey Steam Web API key obtainable on http://steamcommunity.com/dev
	 */
	function __construct($apiKey)
	{
		$this->apiKey = $apiKey;
	}
	
	/**
	 * Basic profile information for a list of 64-bit Steam IDs or for a single SteamID.
	 * @param mixed $steamID64s Single SteamID64 as a string or multiple IDs as an array.
	 * @param string $format Format of the output ('array', 'json'). Default 'array'.
	 * @return mixed JSON string or an array with the profile information
	 */
	function playerInfo($steamID64s, $format = 'array')
	{
		$steamids = '';
		if (is_array($steamID64s))
		{
			foreach ($steamID64s as $id)
			{
				$steamids .= $id . ',';
			}
			$steamids[strlen($steamids) - 1] = '';
		}
		else
		{
			$steamids = $steamID64s;
		}
		$player_info = file_get_contents('http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?format=' . $format . '&key=' . $this->apiKey . '&steamids=' . urlencode($steamids));
		
		return json_decode($player_info, (($format != 'array') ? false : true));
	}
	
	/**
	 * Fetch extended info of a user profile or a Steam group.
	 * @param mixed $id SteamID64, custom name or absolute URL of the Steam Community profile.
	 * @param string $type Type of the profile ('user', 'group'). Default 'user'.
	 * @param int $groupMembersPage Number of the page if the group has more members than 1000. ($type = 'group' only)
	 * @return string XML with the info. 
	 */
	function getProfile($id, $type = 'user', $groupMembersPage = 1)
	{
		$url = $id;
		$suffix = '';
		
		if (strpos($id, '://steamcommunity.com/') == false)
		{
			$url = $this->getURL($id, $type);
		}
		
		switch ($type)
		{
			case 'user':
				$suffix = '?xml=1';
				break;
			case 'group':
				$suffix = '/memberslistxml/?xml=1&p=' . $groupMembersPage;
				break;
		}
		
		return file_get_contents($url . $suffix);
	}
	
	/**
	 * @param mixed $id SteamID64 or custom name
	 * @param string $type Type of the profile ('user', 'group'). Default 'user'.
	 * @return string URL of the profile.
	 */
	function getURL($id, $type = 'user')
	{
		$url = $id;
		
		if (strpos($id, '://steamcommunity.com/') == false)
		{
			switch ($type)
			{
				case 'user':
					if (is_numeric($id))
					{
						$url = 'http://steamcommunity.com/profiles/' . $id;
					}
					else $url = 'http://steamcommunity.com/id/' . $id;
					break;
				case 'group':
					if (is_numeric($id))
					{
						$url = 'http://steamcommunity.com/gid/' . $id;
					}
					else $url = 'http://steamcommunity.com/groups/' . $id;
					break;
			}
		}
		
		return $url;
	}
}