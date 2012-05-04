<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Steam group key giveaway</title>
	</head>
	<body>
		<h1><a href="./">Steam group key giveaway</a></h1>
		
		{if isset($user_info)}
		<p>User: <a href="{$user_info['profileurl']}"><img src="{$user_info['avatar']}" style="padding-right: 10px;">{$user_info['personaname']}</a>
		{if $is_admin}<a href="./?page=admin" style="padding: 0 10px 0 42px;">Admin</a>{/if}
		<a href="?page=logout">Logout</a></p>
		{/if}
		
		{block content}{/block}
		
	</body>
</html>