<?php

function smarty_function_paramURL($params,&$smarty) {
	
	if (!isset($params['name']) || !isset($params['value'])) {
		return;
	}
	$paramString = '?';
	$_GET[$params['name']] = $params['value'];
	$counter = 0;
	$delimiter = "";
	foreach ($_GET as $key=>$value) {
		if ($counter >0) {
			$delimiter = "&";
		}
		$paramString .= $delimiter.$key."=".$value;
		$counter++;
	}
	echo $_SERVER['PHP_SELF'].$paramString;
}
