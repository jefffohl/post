{extends file="layout.tpl"}
{block name="page_body"}
{block name="page_body_content"}
{$modules.Page}
{/block}
{/block}
{block name="footer"}
	<footer>      
            <div class="contact narrow">
            	{include file="contact.tpl"}
            </div>
    </footer>
{/block}