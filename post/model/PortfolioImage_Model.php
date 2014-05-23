<?php

class PortfolioImage_Model extends PostDatabase {

	/* METHODS */
	
	/* delete portfolio image */
	
	public function delete($imageId) {
			$params = array();
			$params['id'] = (int)$imageId;
			$statement = $this->dbHandle->prepare("DELETE FROM portfolioimage WHERE id=:id");
			$statement->execute($params);
		}
}
?>