<?php

function smarty_function_portfolio() {
	require_once(MODEL_PATH.'Portfolio.php');
	$portfolioObj = new Portfolio();
	$portfolios = $portfolioObj->getPortfolioImages(1);
	echo "<pre>";
	echo var_dump($portfolios);
	echo "</pre>";
}
