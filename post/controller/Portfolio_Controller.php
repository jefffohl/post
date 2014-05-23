<?php

require_once(MODEL_PATH.'Portfolio_Model.php');

class Portfolio_Controller {
	
	public function __construct() {
		$this->portfolioObj = new Portfolio_Model();
		$this->title = null;
		if (isset($_GET['portfoliotemplate'])) {
			$this->template = $_GET['portfoliotemplate'].".tpl";
		} else {
			$this->template = 'portfolio_preview.tpl';
		}
		if (isset($_GET['portfolioid'])) {
			$portfolioIds = explode(',',$_GET['portfolioid']);
			$this->portfolios = array();
			foreach ($portfolioIds as $key=>$item) {
				$this->portfolios[] = array('id' => $item);
			}
		}
		else {
			$this->portfolios = $this->portfolioObj->getPortfolioIds();
		}
	}
	
	public function execute() {
		if (isset($_GET['portfoliocategory'])) {
			return $this->showPortfoliosByCategory($_GET['portfoliocategory']);
		}
		elseif (isset($_GET['portfolioid'])) {
			return $this->showPortfolio($_GET['portfolioid']);
		}
		else {
			return $this->showPortfolios();
		}
	}
	
	public function showPortfolios() {
		global $smarty;
		$output = "";
		$records = $this->portfolioObj->getPortfolios();
		foreach ($records as $key=>$portfolio) {
			// $portfolio = $this->portfolioObj->getPortfolio($portfolio['id']);
			$smarty->assign('portfolio',$portfolio);
			$output .= $smarty->fetch('portfolio_preview.tpl');
		}
		$smarty->assign("portfolios",$output);
		$this->title = 'Portfolio';
		return $output;
	}
	
	public function showPortfolio($id) {
		global $smarty;
		$portfolio = $this->portfolioObj->getPortfolio($id);
		$smarty->assign('portfolio',$portfolio);
		$this->title = $portfolio['title'];
		return $smarty->fetch('portfolio_display.tpl');
	}
	
	public function showPortfoliosByCategory($category) {
		global $smarty;
		$portfolios = $this->portfolioObj->getPortfoliosByCategory($category);
		$output = "";
		foreach ($portfolios as $key=>$portfolio) {
			$smarty->assign('portfolio',$portfolio);
			$output .= $smarty->fetch($this->template);
		}
		$smarty->assign("portfolios",$output);
		$this->title = 'Portfolio filtered by '.$category;
		return $output;
	}
}