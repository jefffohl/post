<?php

function smarty_function_loadModule($params) {
	$moduleClassName = $params['name'].'_Controller';
	require_once(CONTROLLER_PATH.$moduleClassName.'.php');
	$module = new $moduleClassName($params);
	return $module->execute();
}