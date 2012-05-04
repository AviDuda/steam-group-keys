{extends "site.tpl"}
{block content}
<h2>Admin - claimed keys</h2>

{if isset($messageFlushed)}
<p>Claimed keys were successfully flushed and backup file was created.</p>
{/if}

<p><a href="./?page=admin&action=claimedkeysflush">Delete all claimed keys</a></p>

{if isset($keys)}
<table>
	<tr>
		<th>Key</th>
		<th>User</th>
		<th>Actions</th>
	</tr>
	{foreach $keys as $key}
	<tr>
		<td>{$key[0]}</td>
		<td><a href="{$key[1]['profileurl']}"><img src="{$key[1]['avatar']}">{$key[1]['personaname']}</a></td>
		<td><a href="./?page=admin&action=claimedkeydelete&key={$key[0]}">delete</a></td>
	</tr>
	{/foreach}
</table>
{else}
<p>No claimed keys found.</p>
{/if}
{/block}