<div class="hamburger" id="menu-controller">
	<span></span>
	<span></span>
	<span></span>
</div>
<div class="menu-wrapper" id="menu">
	<ul class="content-page-menu">
		<li {if $_GET.view == 'blog'} class="current-page"{/if}><a href="/?view=blog">Blog</a></li>
		<li {if $_GET.view == 'portfolio'} class="current-page"{/if}><a href="/?view=portfolio">Portfolio</a></li>
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
		{/if}
	</ul>
</div>
