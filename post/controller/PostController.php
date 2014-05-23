<?php


class PostController {
	
	public function __construct($modules = null,$template = 'layout.tpl') {
		if ($modules == null) {
			return;
		}
		$this->modules = $modules;
		$this->template = $template;
		$this->output = array();
		$this->page = array();
		$this->page['title'] = "";
	}
	
	public function execute() {
		global $smarty;
		$this->generateModules();
		$this->page['title'] .= "- ".BLOG_AUTHOR;
		$smarty->assign('modules',$this->output);
		$smarty->assign('page',$this->page);
		$smarty->display($this->template);
	}
	
	private function generateModules() {
		$modulesArray = explode(",",$this->modules);
		foreach ($modulesArray as $key=>$module) {
			$moduleName = ucfirst(strtolower($module));
			require_once(CONTROLLER_PATH.$moduleName.'_Controller.php');
			$moduleClassName = $moduleName.'_Controller';
			$moduleObj = new $moduleClassName();
			$this->output[$moduleName] = $moduleObj->execute();
			$this->page['title'] .= $moduleObj->title." ";
		}
	}
}
?>