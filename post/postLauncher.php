<?php

/** Define ABSPATH as this file's directory */
define( 'ABSPATH', dirname(__FILE__) . '/' );
define( 'MODEL_PATH', ABSPATH . 'model/' );
define( 'VIEW_PATH', ABSPATH . 'view/' );
define( 'CONTROLLER_PATH', ABSPATH . 'controller/' );
define( 'SMARTY_DIR', ABSPATH . 'view/Smarty-3.0rc1/libs/' );

/** include paths */
$includePaths = array();
$includePaths[]=ABSPATH . 'controller';
$includePaths[]=ABSPATH . 'model';
$includePaths[]=ABSPATH . 'view';
set_include_path(get_include_path() . join($includePaths,PATH_SEPARATOR));

/** Configuration */
require_once(CONFIG_PATH);

define( 'THEME_PATH', $_SERVER['DOCUMENT_ROOT'].THEME_LOCATION );

/** Filtering */

require_once(ABSPATH.'controller/postFilter.php');

// TODO Abstract security functions and make an include as well.

/** Smarty */
require_once(SMARTY_DIR . 'Smarty.class.php');
$smarty = new Smarty();
$templates = array();
$templates[] = THEME_PATH . 'templates/';
$templates[] = THEME_PATH . 'templates/includes/';
$templates[] = VIEW_PATH . 'admin/templates/';
$templates[] = VIEW_PATH . 'admin/templates/includes';
$smarty->template_dir = $templates;
if (!is_dir(SMARTY_CACHE)) {
	mkdir(SMARTY_CACHE);
}
$smarty->compile_dir  = SMARTY_CACHE. 'templates_c/';
if (!is_dir($smarty->compile_dir)) {
	mkdir($smarty->compile_dir);
}
$smarty->cache_dir    = SMARTY_CACHE. 'cache/';
if (!is_dir($smarty->cache_dir)) {
	mkdir($smarty->cache_dir);
}
$smarty->config_dir   = SMARTY_DIR . 'configs/';
$smarty->plugins_dir[] = ABSPATH . 'plugins';
                       
$smarty->assign('_SERVERINFO',$_SERVER);
$smarty->assign('_GET',$_GET);
$smarty->assign('_POST',$_POST);
$smarty->assign('theme_path',THEME_LOCATION);
$smarty->assign('app_path',APP_LOCATION);

// start the session - on every page load
session_start();

// if the user is logged in, put their user information into Smarty, so we can render it where we want to.
if (isset($_SESSION['username'])) {
		$smarty->assign('loggedin',true);
		$user = array();
		$user['id'] = $_SESSION['id'];
		$user['firstname'] = $_SESSION['firstname'];
		$user['lastname'] = $_SESSION['lastname'];
		$user['username'] = $_SESSION['username'];
		$user['class'] = $_SESSION['class'];
		$smarty->assign('user',$user);
	} else {
		$smarty->assign('loggedin',false);
	}

require_once(MODEL_PATH.'PostDatabase.php');
require_once(CONTROLLER_PATH.'PostController.php');

$page = array();
$page['title'] = BLOG_TITLE.". A blog by ".BLOG_AUTHOR;
$smarty->assign('blogTitle',BLOG_TITLE);

/* This section controls the basic output of application.
 * The way this works right now is that display logic is
 * primarily in the Smarty plugins. So, a given 'view'
 * corresponds to a template, which in turn determines what
 * modules to load, and what data to display.
 * This is because, at this time, there is no page manager,
 * which would allow us to create arbitray pages from the
 * application interface, and place modules on each page.
 * 
 * There are three basic entry points into the application:
 * 1. Post. This is the standard Web viewer, or visitor to the site.
 * 2. Admin. This is the author's view.
 * 3. Account. This is the view of the person who has an account with the site.
 */

$smarty->assign('_CONTROLLER',CONTROLLER);
if (CONTROLLER === 'Post') {
	require_once(CONTROLLER_PATH.'PostController.php');
	if (isset($_GET['view'])) {	
		switch ($_GET['view']) {
			case 'blog':
				$modules = "Blog";
				$postObj = new PostController($modules,"blog.tpl");
				$postObj->execute();
				break;
			 case 'portfolio':
               $modules = "Portfolio";
				$postObj = new PostController($modules,"portfolio.tpl");
				$postObj->execute();
				break;
			case 'page':
				$modules = "Page";
				$postObj = new PostController($modules,"page.tpl");
				$postObj->execute();
				break;
			default :
				$modules = "Blog,Portfolio";
				$postObj = new PostController($modules,"layout.tpl");
				$postObj->execute();
				break;
		}
	}
	else {
		$modules = "Blog,Portfolio";
		$postObj = new PostController($modules,"home.tpl");
		$postObj->execute();
	}
} elseif (CONTROLLER === 'Admin') {
		$smarty->display('admin.tpl');
}
elseif (CONTROLLER === 'Account') {
		$smarty->display('account.tpl');
}
else {
	$modules = "Blog,Portfolio";
	$postObj = new PostController($modules,"layout.tpl");
	$postObj->execute();
}