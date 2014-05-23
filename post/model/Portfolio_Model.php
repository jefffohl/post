<?php

class Portfolio_Model extends PostDatabase {

	/* METHODS */
	 
	/* create new portfolio */
	
	public function createPortfolio($title=null,$thumbnail=null,$body=null,$categories=null,$images=null) {
		// filter the data
		$params = array();
		$params['title'] = $title;
		$params['thumbnail'] = $thumbnail;
		$params['body'] = $body;
		$params['categories'] = $categories;
		$statement = $this->dbHandle->prepare("INSERT INTO portfolio (title, thumbnail, body, categories, date_posted) VALUES (:title,:thumbnail,:body,:categories,NOW())");
		$statement->execute($params);
		// save images
		$portfolioid = $this->dbHandle->lastInsertId();
		$this->savePortfolioImages($portfolioid,$images);	
	}
	
	/* delete portfolio */
	
	public function delete($portfolioID) {
		$params = array();
		$params['portfolioid'] = (int)$portfolioID;
		$statement = $this->dbHandle->prepare("DELETE FROM portfolio WHERE id=:portfolioid");
		$statement->execute($params);
		// delete portfolio images associatd with this portfoli
		$statement = $this->dbHandle->prepare("DELETE FROM portfolioimage WHERE portfolioid=:portfolioid");
		$statement->execute($params);
	}
	
	/* edit portfolio */
	
	public function editPortfolio($title=null,$thumbnail=null,$body=null,$categories=null,$images=null,$image_thumbnails=null,$image_descriptions=null,$imageIDs=null,$saveid) {
		
		$params = array();
		$params['title'] = $title;
		$params['thumbnail'] = $thumbnail;
		$params['body'] = $body;
		$params['categories'] = $categories;
		// $params['images'] = $images;
		$params['saveid'] = (integer)$saveid;
		$statement = $this->dbHandle->prepare("UPDATE portfolio SET title=:title, thumbnail=:thumbnail, body=:body, categories=:categories WHERE id=:saveid");
		$statement->execute($params);
		// merge the imageIDs and images into one array
		if ($images != null) {
			$portfolioImages = array();
			for($i=0;$i<count($images);$i++) {
				$portfolioImages[] = array(
				'id' => $imageIDs[$i],
				'imageurl' => $images[$i],
				'thumbnail' => $image_thumbnails[$i],
				'description' => $image_descriptions[$i]
				);
			}
			foreach ($portfolioImages as $key=>$value) {
				// if this is a new image, it will have no ID
				if (empty($value['id'])) {
					$newImage = array();
					$newImage['imageurl'] = $value['imageurl'];
					$newImage['thumbnail'] = $value['thumbnail'];
					$newImage['description'] = $value['description'];
					$this->savePortfolioImage($saveid,$newImage);
				// else, we update data on existing images:
				} else {
					$imageStatement = $this->dbHandle->prepare("UPDATE portfolioimage SET imageurl=:imageurl, thumbnail=:thumbnail, description=:description WHERE id=:id");
					$imageStatement->execute($value);
				}
			}
		}
	}
	
	public function getPagedPortfolios($page = null,$number = 10) {
		return $this->pagedQuery($page,$number,'portfolio','priority','asc');
	}
	
	public function getPortfolios($size = 1000, $sort = 'priority', $order = 'asc') {
		$params = array();
		$params['size'] = $size;
		$params['sort'] = $sort;
		$params['order'] = $order;
		$statement = $this->dbHandle->prepare("SELECT * FROM portfolio ORDER BY {$params['sort']} {$params['order']} LIMIT {$params['size']}");
		$statement->execute();
		$portfolios = array();
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($item = $statement->fetch())
	        {
	            $portfolios[] = $item;
	        }
	    return $portfolios;
	}
	
	public function getPortfolio($portfolioid = null) {
		$params = array();
		$params['portfolioid'] = (int) $portfolioid;
		$statement = $this->dbHandle->prepare("SELECT * FROM portfolio WHERE id=:portfolioid");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);  
		$row = $statement->fetch();
		$row['images'] = $this->getPortfolioImages($portfolioid);
		//$row['categories'] = explode(',',$row['categories']);
		return $row;
	}
	
	public function getPortfolioCount() {
		return $this->getTotalRecords('portfolio');
	}
	
	public function getPortfolioImages($portfolioid = null) {
		$params = array();
		$params['portfolioid'] = (int) $portfolioid;
		$statement = $this->dbHandle->prepare("SELECT * FROM portfolioimage WHERE portfolioid=:portfolioid");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($item = $statement->fetch())
	        {
	            $items[] = $item;
	        }
		return $items;
	}
	
	public function savePortfolioImages($portfolioid = null,$images) {
		if ($portfolioid === null) {
			return;
		}
		foreach ($images as $key=>$image) {
			$this->savePortfolioImage($portfolioid,$image);
		}
		return;
	}
	
	public function savePortfolioImage($portfolioid = null, $image) {
		if ($portfolioid === null) {
			return;
		}
		if (!empty($image)){
			$params = array();
			$params['portfolioid'] = (int) $portfolioid;
			$params['imageurl'] = $image['imageurl'];
			$params['thumbnail'] = $image['thumbnail'];
			$params['description'] = $image['description'];
			$statement = $this->dbHandle->prepare("INSERT INTO portfolioimage (imageurl,thumbnail,description,portfolioid,date_posted) VALUES (:imageurl,:thumbnail,:description,:portfolioid,NOW())");
			$statement->execute($params);
		}
		return;
	}
	
	public function getPortfolioIds() {
		$params = array();
		$statement = $this->dbHandle->prepare("SELECT id FROM portfolio");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($item = $statement->fetch())
	        {
	            $items[] = $item;
	        }
		return $items;
	}
	
	public function getPortfoliosByCategory($category) {
		$params = array();
		$category = '%'.$category.'%';
		$params['category'] = $category;
		$statement = $this->dbHandle->prepare("SELECT * FROM portfolio WHERE categories LIKE :category");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($item = $statement->fetch())
	        {
	        	// $item['categories'] = explode(',',$item['categories']);
	        	$item['images'] = $this->getPortfolioImages($item['id']);
	            $items[] = $item;
	        }
		return $items;
	}
}
?>