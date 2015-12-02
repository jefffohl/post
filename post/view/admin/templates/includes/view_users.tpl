
		<h2>View Users</h2>
		<form method="post" name="users" action="."> 
		<table class="edit-posts">
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Class</th>
				<th></th>
			</tr>
			{foreach from=$users key="k" item="user"}
			<tr class="{cycle values="rowA,rowB"}"">
				<td>{$user.firstname}</td>
				<td>{$user.lastname}</td>
				<td><a href=".?view=edituser&userid={$user.id}">{$user.username}</a></td>
				<td>{$user.email}</td>
				<td>{$user.class}</td>
				<td><a class="button" href=".?action=delete&module=user&title={$user.firstname}&id={$user.id}">Delete</a></td>
			</tr>
			{/foreach}
		</table>
		</form>
		{if $pages > 1}
		<ul class="pager">
		{section name=pager loop=$pages}
  				<li{if $currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href=".?view=users&page={counter name='href'}">{counter name='printed'}</a></li>
		{/section}
		</ul>
		{/if}