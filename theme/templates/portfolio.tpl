{extends file="layout.tpl"}
{block name="page_body"}
<div class="portfolio-column">
<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=portfolio">Portfolio</a>
{if isset($_GET.portfoliocategory)}
<div class="filters"><span>Filtered by: {$_GET.portfoliocategory}</span> <a href="{$_SERVERINFO.PHP_SELF}?view=portfolio" class="button">X</a></div>
{/if}
</h2>
{block name="page_body_content"}
{$modules.Portfolio}
{/block}
</div>
{/block}