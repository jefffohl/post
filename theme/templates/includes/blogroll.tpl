{foreach from=$posts key="k" item="post"}
	<div class="post">
		<h3><a href="{paramURL name="postid" value=$post.id}&view=blog">{$post.title}</a></h3>
		<p class="date-posted">Posted: {$post.date_posted|date_format}</p>
		<div class="post-body">{$post.body|strip_tags:false|truncate:300}</div>
	</div>
{/foreach}
{if $blog_pages > 1}
	<ul class="pager">
		{section name=pager loop=$blog_pages}
	  		<li{if $blog_currentpage == $smarty.section.pager.iteration} class="selected"{/if}><a href="{paramURL name="blog_page" value=$smarty.section.pager.iteration}">{$smarty.section.pager.iteration}</a></li>
		{/section}
	</ul>
{/if}