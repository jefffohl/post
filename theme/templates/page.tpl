{extends file="layout.tpl"}
{block name="page_body"}
<div class="blog-column-solo">
{block name="page_body_content"}
{$modules.Page}
{/block}
</div>
{/block}
{block name="footer"}
	<footer>      
            <div class="contact narrow">
            	{include file="contact.tpl"}
            </div>
    </footer>
{/block}