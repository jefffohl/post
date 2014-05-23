<?php

function smarty_function_pageMenu($params) {
	global $smarty;
	require_once(MODEL_PATH.'Page_Model.php');
	$pageObj = new Page_Model($params);
	$pages = $pageObj->getContentPages(1,999);
	$smarty->assign("contentpages",$pages);
	$output = $smarty->fetch('pageMenu.tpl');
	echo $output;
}