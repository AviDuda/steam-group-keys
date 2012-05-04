{extends "site.tpl"}
{block content}
<h2>Admin</h2>

<h3>Keys</h3>

<ul>
	<li>
		<a href="./?page=admin&action=claimedkeys">Claimed keys</a>
	</li>
</ul>

<h3>Admins</h3>
<table>
	<tr>
		<th>User</th>
		<th>Action</th>
	</tr>
	{foreach $admins as $admin}
	<tr>
		<td><a href="{$admin['profileurl']}"><img src="{$admin['avatar']}">{$admin['personaname']}</a></td>
		<td><a href="./?page=admin&action=admindelete&id={$admin['steamid']}">delete</td>
		
	</tr>
	{/foreach}
</table>

<h3>Member list</h3>

<p>{$memberlist_update} seconds to automatically update member list. <a href="./?page=admin&action=updatememberlist">Update now</a></p>
{/block}