<!DOCTYPE html>
<html>
	<head>
		<title>{block name="pagetitle"}{$page.title}{/block}</title>
		<script type="text/javascript" src="/post/view/admin/js/jquery.min.js"></script>
		<script type="text/javascript" src="/theme/js/PostShadowbox.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,400italic,700' rel='stylesheet' type='text/css'>
		<link href="{$theme_path}css/style.css" media="screen" rel="stylesheet" type="text/css" />
	</head>
	<body><div class="highlight">
		<div class="post-header">
			<div class="inner"><h1><a href="/">{$blogTitle}</a></h1>
			{if $loggedin === true}<p class="welcome">Welcome, {$user.firstname}</p>{/if}
				<div class="admin-buttons">
					{if $loggedin === true}
						{if $_CONTROLLER == "Account"}
							<a href="/" class="button">Back to site &raquo;</a>
							<a class="button" href="/account/?action=logout">Log Out &raquo;</a>
						{else}
							{if $user.class === "Administrator"}
								<a class="button" href="/admin/">Admin &raquo;</a>
							{else}
								<a class="button" href="/account/">My Account &raquo;</a>
							{/if}
						{/if}
					{else}
						{if $_CONTROLLER == "Account"}
							<a class="button" href="/">Back to site &raquo;</a>
						{else}
							<a class="button" href="/account/">My Account &raquo;</a>
						{/if}
					{/if}
				</div>
			</div>
		</div>
		<div class="page-body">
			