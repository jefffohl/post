<ul class="content-page-menu">
{foreach from=$contentpages key="key" item="page"}
<li{if $_GET.contentpageid == $page.id} class="current-page"{/if}><a href="/?view=page&contentpageid={$page.id}">{$page.title}</a></li>
{/foreach}
{if $loggedin === true}
						{if $_CONTROLLER == "Account"}
						<li>	<a href="/">Back to site &raquo;</a></li>
						<li>	<a href="/account/?action=logout">Log Out &raquo;</a></li>
						{else}
							{if $user.class === "Administrator"}
						<li>		<a href="/admin/">Admin &raquo;</a></li>
							{else}
						<li>		<a href="/account/">My Account &raquo;</a></li>
							{/if}
						{/if}
					{else}
						{if $_CONTROLLER == "Account"}
						<li>	<a href="/">Back to site &raquo;</a></li>
						{else}
						<li>	<a href="/account/">Log In &raquo;</a></li>
						{/if}
					{/if}
</ul>
