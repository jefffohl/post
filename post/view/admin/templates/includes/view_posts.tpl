<h2>View Posts</h2>
		<form method="post" name="posts" action="."> 
		<table class="edit-posts">
			<tr>
				<th>Title</th>
				<th>Author</th>
				<th>Date Posted</th>
				<th></th>
			</tr>
			{foreach from=$posts key="k" item="post"}
			<tr class="{cycle values="rowA,rowB"}"">
				<td><a href=".?view=editpost&postid={$post.id}">{$post.title}</a></td>
				<td>{$post.author}</td>
				<td>{$post.date_posted|date_format}</td>
				<td><a class="button" href=".?action=delete&module=blog&title={$post.title}&id={$post.id}">Delete</a></td>
			</tr>
			{/foreach}
		</table>
		</form>
		{if $pages > 1}
		<ul class="pager">
		{section name=pager loop=$pages}
  				<li{if $currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href=".?view=viewposts&page={counter name='href'}">{counter name='printed'}</a></li>
		{/section}
		</ul>
		{/if}
		<div class="buttons">
		<a class="button" href=".?view=createpost">New Post</a>
		</div>