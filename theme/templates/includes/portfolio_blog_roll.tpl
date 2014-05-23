{foreach from=$stuff key="k" item="post"}
{if $post.class == "blog"}
<div class="portfolio-preview">
	<h3><a href="{paramURL name="postid" value=$post.id}&view=blog">{$post.title}</a></h3>
	<p class="author">By: {$post.author}</p>
	<div class="post-body">{$post.body|strip_tags:false|truncate:300}</div>
	{*<p class="date-posted">Date Posted: {$post.date_posted|date_format}</p>*}
</div>
{elseif $post.class == "portfolio"}
{assign var="categories" value=","|explode:$post.categories}
<div class="portfolio-preview">
	<a href="{$_SERVERINFO.PHP_SELF}?portfolioid={$post.id}&view=portfolio&portfoliotemplate=portfolio_display"><img class="thumb" src="{$post.thumbnail}" alt="{$post.title} thumbnail" /></a>
	<h3><a href="{$_SERVERINFO.PHP_SELF}?portfolioid={$post.id}&view=portfolio&portfoliotemplate=portfolio_display">{$post.title}</a></h3>
	<p class="categories">{foreach name="categories" from=$categories key="key" item="category"}<a href="{$SERVERINFO.PHP_SELF}?portfoliocategory={$category}&view=portfolio">{$category}</a>{if !$smarty.foreach.categories.last}, {/if}{/foreach}</p>
</div>
{/if}
{/foreach}