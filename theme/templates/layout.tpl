<!DOCTYPE html>
{block name="html"}
<html lang="en">
{block name="header"}
	<head>
		<title>{block nocache name="pagetitle"}{$page.title}{/block}</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		{block name="header_javascript"}
		<script type="text/javascript" src="/post/view/admin/js/jquery.min.js"></script>
		<script type="text/javascript" src="{$theme_path}js/menuControl.js"></script>
		{/block}
		{block name="header_css"}
		<link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>
		<link href="{$theme_path}css/style.css" media="screen" rel="stylesheet" type="text/css">
		{/block}
	</head>
{/block}
{block name="body"}	
<body>
	<div class="highlight">
		{block name="body_header"}
		<div class="post-header">
			<div class="inner">
				<h1><a href="/">{$smarty.const.BLOG_AUTHOR}</a></h1>
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
							<div class="filters"><span>Filtered by: {$_GET.portfoliocategory}</span> <a href="{$_SERVERINFO.PHP_SELF}" class="button">X</a></div>
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