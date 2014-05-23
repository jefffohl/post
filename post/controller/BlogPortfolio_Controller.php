<?php

require_once(MODEL_PATH.'Blog_Model.php');
require_once(MODEL_PATH.'Comment_Model.php');
require_once(MODEL_PATH.'Portfolio_Model.php');

class BlogPortfolio_Controller {
	
	public function __construct() {
		$this->blogObj = new Blog_Model();
		$this->commentObj = new Comment_Model();
		$this->portfolioObj = new Portfolio_Model();
	}
	
	public function execute() {
			return $this->viewStuff();
	}
	
	public function viewStuff() {
		global $smarty;
		$posts = $this->blogObj->getPosts(1,999);
		$portfolios = $this->portfolioObj->getPortfolios(1,999);
		$stuff = array();
		foreach ($posts as $postKey=>$postValue) {
			$postValue['class'] = "blog";
			$stuff[$postValue['date_posted']] = $postValue;
		}
		foreach ($portfolios as $portfolioKey=>$portfolioValue) {
			$portfolioValue['class'] = "portfolio";
			$stuff[$portfolioValue['date_posted']] = $portfolioValue;
		}
		krsort($stuff);
		$smarty->assign('stuff',$stuff);
		return $smarty->fetch('portfolio_blog_roll.tpl');
	}
}