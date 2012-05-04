{extends "site.tpl"}
{block content}
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