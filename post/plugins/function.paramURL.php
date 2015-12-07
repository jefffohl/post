<?php

function smarty_function_paramURL($params) {
	
	if (!isset($params['name']) || !isset($params['value'])) {
		return;
	}
	$paramString = '?';
	foreach ($_GET as $key=>$value) {
		$paramString .= $key."=".$value."&";
	}
	$paramString .= $params['name'] . "=" . $params['value'];
	echo $_SERVER['PHP_SELF'].$paramString;
}
