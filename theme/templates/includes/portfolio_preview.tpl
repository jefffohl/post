{assign var="categories" value=","|explode:$portfolio.categories}
<div class="portfolio-preview">
	<a href="{$_SERVERINFO.PHP_SELF}?portfolioid={$portfolio.id}&view=portfolio&portfoliotemplate=portfolio_display"><img class="thumb" src="{$portfolio.thumbnail}" alt="{$portfolio.title} thumbnail" /></a>
	<h3><a href="{$_SERVERINFO.PHP_SELF}?portfolioid={$portfolio.id}&view=portfolio&portfoliotemplate=portfolio_display">{$portfolio.title}</a></h3>
	<p class="categories">{foreach name="categories" from=$categories key="key" item="category"}<a href="{$SERVERINFO.PHP_SELF}?portfoliocategory={$category}{if (isset($_GET.view))}&view={$_GET.view}{/if}">{$category}</a>{if !$smarty.foreach.categories.last}, {/if}{/foreach}</p>
</div>