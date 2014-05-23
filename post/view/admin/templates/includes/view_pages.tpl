<h2>View Pages</h2>
		<form method="post" name="pages" action="."> 
		<table class="edit-posts">
			<tr>
				<th>Title</th>
				<th>Date Posted</th>
				<th></th>
			</tr>
			{foreach from=$contentpages key="k" item="contentpage"}
			<tr class="{cycle values="rowA,rowB"}"">
				<td><a href=".?view=editpage&contentpageid={$contentpage.id}">{$contentpage.title}</a></td>
				<td>{$contentpage.date_posted|date_format}</td>
				<td><a class="button" href=".?action=delete&module=contentPage&title={$contentpage.title}&id={$contentpage.id}">Delete</a></td>
			</tr>
			{/foreach}
		</table>
		</form>
		{if $pages > 1}
		<ul class="pager">
		{section name=pager loop=$pages}
  				<li{if $currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href=".?view=viewpages&page={counter name='href'}">{counter name='printed'}</a></li>
		{/section}
		</ul>
		{/if}
		<div class="buttons">
		<a class="button" href=".?view=createpage">New Page</a>
		</div>