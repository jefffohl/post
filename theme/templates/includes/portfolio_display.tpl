<script type="text/javascript" src="/post/view/admin/js/jquery.min.js"></script>
<script type="text/javascript" src="/theme/js/PostShadowbox.js"></script>

{assign var="categories" value=","|explode:$portfolio.categories}
<div class="portfolio">
	<div id="description-wrapper" class="description-wrapper">
		<div class="description">
			<h3>{$portfolio.title}</h3>
			<p class="categories">Categories: {foreach name="categories" from=$categories key="key" item="category"}<a href="{$SERVERINFO.PHP_SELF}?portfoliocategory={$category}{if (isset($_GET.view))}&view={$_GET.view}{/if}">{$category}</a>{if !$smarty.foreach.categories.last}, {/if}{/foreach}</p>
			{$portfolio.body}
		</div>
		{if count($portfolio.images) > 1}
		<div class="thumbnails">
			{foreach from=$portfolio.images item="image"}
				{if !empty($image.thumbnail)}
				<div class="thumbnail">
				<img id="thumbnail_{$image.id}" src="{$image.thumbnail}" />
				</div>
				{/if}
			{/foreach}
		</div>
		{/if}
		<div id="current-image-description">
			{if isset($portfolio.images[0].description)}{$portfolio.images[0].description}{/if}
		</div>
	</div>
	<div id="images-wrapper" class="images-wrapper">
	<div class="inner-wrapper">
		<div class="image">
			<div id="spinner">Loading...</div>
			<div id="scrim"></div>
			<img id="main-image" src="{$portfolio.images[0].imageurl}" onload="clearScrim();"/>
		</div>
	</div>
	</div>
</div>
<script type="text/javascript">
	portfolioImages = {ldelim}
	{foreach from=$portfolio.images name="images" key="key" item="image"}{strip}
	{$image.id}:{ldelim}imageurl:'{$image.imageurl|escape:'javascript'}',thumbnail:'{$image.thumbnail|escape:'javascript'}',description:'{$image.description|escape:'javascript'}'{rdelim}{if !$smarty.foreach.images.last},{/if}
	
	{/strip}{/foreach}
	{rdelim}
	portfolioImageHandler(portfolioImages);
</script>