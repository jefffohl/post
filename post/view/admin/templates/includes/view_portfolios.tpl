		<span class="total-records">Total records: {$totalRecords}</span>
		<h2>View Portfolios</h2>
		<form method="post" action=".?view=viewportfolios">
			<table class="edit-posts">
				<tr>
					<th>Title</th>
					<th>Thumbnail</th>
					<th>Categories</th>
					<th>Date Posted</th>
					<th>Priority</th>
					<th></th>
				</tr>
				{foreach from=$portfolios key="k" item="portfolio"}
				<tr class="{cycle values="rowA,rowB"}"">
					<td><a href=".?view=editportfolio&portfolioid={$portfolio.id}">{$portfolio.title}</a></td>
					<td><a href=".?view=editportfolio&portfolioid={$portfolio.id}"><img width="50" src="{$portfolio.thumbnail}" alt="Portfolio thumbnail"></a></td>
					<td>{$portfolio.categories}</td>
					<td>{$portfolio.date_posted|date_format}</td>
					<td><input type="hidden" id="saveid_{$portfolio.id}" name="saveids[]" value="{$portfolio.id}" /><input name="priorities[]" type="text" size="1" value="{$portfolio.priority}" /></td>
					<td><a class="button" href=".?action=delete&module=portfolio&title={$portfolio.title}&id={$portfolio.id}">Delete</a></td>
				</tr>
				{/foreach}
			</table>
			<div class="submit"><input type="submit" value="Update Order" name="submit" /></div>
			</form>
			{if $pages > 1}
			<ul class="pager">
			{section name=pager loop=$pages}
	  				<li{if $currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href=".?view=viewportfolios&page={counter name='href'}">{counter name='printed'}</a></li>
			{/section}
			</ul>
			{/if}
		<div class="buttons">
		<a class="button" href=".?view=createportfolio">New Portfolio</a>
		</div>
