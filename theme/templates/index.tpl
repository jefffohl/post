
{include file="header.tpl"}
<div class="blog-column-wrapper">
<div class="blog-column">
<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=blog">Blog</a></h2>
{loadModule name="Blog"}
</div>
</div>
<div class="portfolio-column-wrapper">
<div class="portfolio-column">
<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=portfolio">Portfolio</a>
{if isset($_GET.portfoliocategory)}
<div class="filters"><span>Filtered by: {$_GET.portfoliocategory}</span> <a href="{$_SERVERINFO.PHP_SELF}" class="button">X</a></div>
{/if}
</h2>
{loadModule name="Portfolio"}
</div>
</div>
{include file="footer.tpl"}
{*
{include file="header.tpl"}
{loadModule name="BlogPortfolio"}
{include file="footer.tpl"}
*}