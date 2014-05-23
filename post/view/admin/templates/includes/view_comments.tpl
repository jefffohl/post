		<h2>View Comments</h2>
		<form method="post" name="posts" action="."> 
		<table class="edit-posts">
			<tr>
				<th>User</th>
				<th>Date Posted</th>
				<th>Post ID</th>
				<th>Comment</th>
				<th></th>
			</tr>
			{foreach from=$comments key="k" item="comment"}
			<tr class="{cycle values="rowA,rowB"}"">
				<td><a href="{$_SERVERINFO.PHP_SELF}?view=edituser&userid={$comment.userid}">{$comment.username}</a></td>
				<td>{$comment.date_posted|date_format}</td>
				<td><a href="{$_SERVERINFO.PHP_SELF}?view=editpost&postid={$comment.postid}">{$comment.posttitle}</a></td>
				<td>{$comment.body}</td>
				<td><a class="button" href=".?action=delete&module=comment&id={$comment.id}">Delete</a></td>
			</tr>
			{/foreach}
		</table>
		</form>
		{if $pages > 1}
		<ul class="pager">
		{section name=pager loop=$pages}
  				<li{if $currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href=".?view=comments&page={counter name='href'}">{counter name='printed'}</a></li>
		{/section}
		</ul>
		{/if}