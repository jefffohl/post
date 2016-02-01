<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Post Admin</title>
	</head>
	<meta charset="utf-8">
	<link href="{$app_path}view/admin/css/admin-style.css" media="screen" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="{$app_path}view/admin/js/ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="{$app_path}view/admin/js/jquery.min.js"></script>
	<body>
		<div class="post-header">
			<div class="inner">
			<h1>Post Admin</h1>
			<div class="admin-buttons">
				<a href="/" class="front-end-link button">View Published Blog</a>
				{if $loggedin === true}<a href=".?action=logout" class="front-end-link button">Log Out</a>{/if}
			</div>
			{if $loggedin === true}<p class="welcome">Welcome, {$user.firstname}.</p>{/if}
			</div>
		</div>
		<div class="page-body">
			{if $loggedin === true && $user.class === "Administrator"}{include file="includes/admin-nav.tpl"}{/if}