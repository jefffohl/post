{if $content_pages > 0}
		<ul class="pager">
		{section name=pager loop=$contentpage_pages}
		{counter assign="pagenumber"}
  				<li{if $contentpage_currentpage == $smarty.section.pager.index+1} class="selected"{/if}><a href="{paramURL name="contentpage_page" value=$pagenumber}">{counter name='printed'}</a></li>
		{/section}
		</ul>
		{/if}
{foreach from=$contentpage_pages key="k" item="contentpage_page"}
			<div class="post">
				<h3><a href="{paramURL name="contentpage_page" value=$contentpage_page.id}&view=contentpage">{$post.title}</a></h3>
				<p class="date-posted">Posted: {$post.date_posted|date_format}</p>
				<div class="post-body">{$post.body|strip_tags:false|truncate:300}</div>
			</div>
		{/foreach}