<!DOCTYPE html>
{block name="html"}
<html>
{block name="header"}
	<head>
		<title>{block nocache name="pagetitle"}{$page.title}{/block}</title>
		{block name="header_javascript"}{/block}
		{block name="header_css"}
		<link href="{$theme_path}css/style.css" media="screen" rel="stylesheet" type="text/css" />
		{/block}
	</head>
{/block}
{block name="body"}	
<body>
	<div class="highlight">
		{block name="body_header"}
		<div class="post-header">
			<div class="inner"><h1><a href="/">{{$smarty.const.BLOG_AUTHOR}}</a></h1>
			{pageMenu}
			{if $loggedin === true}<p class="welcome">Welcome, {$user.firstname}</p>{/if}
				
			</div>
		</div>
		{/block}
		<div class="page-body">
		{block name="page_body"}
			
				{block name="page_body_content"}
				<div class="blog-column-wrapper">
					<div class="blog-column">
					<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=blog">Blog</a></h2>
					{$modules.Blog}
					</div>
				</div>
				<div class="portfolio-column-wrapper">
					<div class="portfolio-column">
					<h2 class="module-header"><a href="{$SERVERINFO.PHP_SELF}?view=portfolio">Portfolio</a>
					{if isset($_GET.portfoliocategory)}
					<div class="filters"><span>Filtered by: {$_GET.portfoliocategory}</span> <a href="{$_SERVERINFO.PHP_SELF}" class="button">Remove filter</a></div>
					{/if}
					</h2>
					{$modules.Portfolio}
					</div>
				</div>
				{/block}
			
		{/block}
		</div>
		{block name="footer"}
		<footer>      
            <div class="contact">
            	{include file="contact.tpl"}
            </div>
    	</footer>
		{/block}
	</div>
</body>
{/block}
</html>
{/block}