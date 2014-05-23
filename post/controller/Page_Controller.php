<?php

require_once(MODEL_PATH.'Page_Model.php');

class Page_Controller {
	
	public function __construct() {
		$this->contentPageObj = new Page_Model();
		$this->title = null;
	}
	
	public function execute() {
		if (isset($_GET['contentpageid'])) {
			return $this->viewContentPage();
		}
		/* get a list of pages */
		else {
			return $this->viewContentPages();
		}
	}
	
	public function viewContentPages() {
		global $smarty;
		$page = isset($_GET['contentpage_page']) ? (int) $_GET['contentpage_page']: 1;
			$contentPages = $this->contentPageObj->getContentPages($page,5);
			$pages = $this->contentPageObj->pages;
			$smarty->assign('contentpage_pages',$pages);
			$smarty->assign('contentpage_currentpage',$page);
			$smarty->assign('contentpages',$contentPages);	
			return $smarty->fetch('contentpageroll.tpl');
	}
	
	public function viewContentPage() {
		global $smarty;
		$contentPage = $this->contentPageObj->getContentPage();
		$this->title = $contentPage['title'];
		$smarty->assign('contentpage',$contentPage);
		$smarty->assign('ContentPageObject',$this);
		return $smarty->fetch('contentpage.tpl');
	}
}



