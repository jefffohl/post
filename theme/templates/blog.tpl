{extends file="layout.tpl"}
{block name="page_body"}
<div class="blog-column-solo">
<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=blog">Blog</a></h2>
{block name="page_body_content"}
{$modules.Blog}
{/block}
</div>
{/block}