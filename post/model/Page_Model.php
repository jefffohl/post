<?php


class Page_Model extends PostDatabase {
	
	/* METHODS */
	 
	/* create new page */
	
	public function createContentPage() {
		// filter the data
		$params = array();
		$params['title'] = $_POST['title'];
		$params['body'] = $_POST['body'];
		$statement = $this->dbHandle->prepare("INSERT INTO pages (title, body, date_posted) VALUES (:title,:body,NOW())");
		$statement->execute($params);
	}
	
	/* delete page */
	
	public function delete($pageID) {
		$params = array();
		$params['pageid'] = (int)$pageID;
		$statement = $this->dbHandle->prepare("DELETE FROM pages WHERE id=:pageid");
		$statement->execute($params);
	}
	
	/* edit page */
	
	public function editContentPage($title,$body,$saveid) {
		$params = array();
		$params['title'] = $title;
		$params['body'] = $body;
		$params['saveid'] = (integer)$saveid;
		$statement = $this->dbHandle->prepare("UPDATE pages SET title=:title, body=:body WHERE id=:saveid");
		$statement->execute($params);
	}
	
	public function getContentPages($page = 1,$count = 10) {
		return $this->pagedQuery($page,$count,'pages','date_posted','desc');
	}
	
	public function getContentPage() {
		$params = array();
		$params['pageid'] = (int) $_GET['contentpageid'];
		$statement = $this->dbHandle->prepare("SELECT * FROM pages WHERE id=:pageid");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);  
		$row = $statement->fetch();
		return $row;
	}
	
	public function getContentPageTitle($id = null) {
		if ($id == null) {
			return;
		}
		$params = array();
		$params['id'] = (int) $id;
		$query = "SELECT title FROM pages WHERE id=:id";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if (1 !== $statement->rowCount()) {
				return false;
			}
		return $result['title'];
	}
	
	public function getContentPageCount() {
		return $this->getTotalRecords('pages');
	}
}
?>