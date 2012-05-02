{include "site.tpl"}
{block content}
User: <a href="{$user_info['profileurl']}"><img src="{$user_info['avatar']}" style="padding-right: 10px;">{$user_info['personaname']}</a>
<a href="?logout" style="padding-left: 42px;">Logout</a>

{if isset($key)}
<div style="text-align: center">
	Your key is
	<br><span style="font-size: 20px;">{$key}</span>
</div>
{else}
<p>You aren't in our group. Sorry.</p>
{/if}
<p>{$remaining_keys} keys remaining.</p>
{/block}