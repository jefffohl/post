<?php

/* TODO: there sould be no $_POST or $_GET references in this class
 * 
 */

require_once(MODEL_PATH.'Comment_Model.php');

class Blog_Model extends PostDatabase {
	
	/* METHODS */
	 
	/* create new post */
	
	public function createPost() {
		// filter the data
		$params = array();
		$params['title'] = $_POST['title'];
		$params['author'] = $_SESSION['username'];
		$params['body'] = $_POST['body'];
		$statement = $this->dbHandle->prepare("INSERT INTO posts (title, author, body, date_posted) VALUES (:title,:author,:body,NOW())");
		$statement->execute($params);
	}
	
	/* delete post */
	
	public function delete($postID) {
		$params = array();
		$params['postid'] = (int)$postID;
		// check for any comments attached to post. delete these first.
		$commentObj = new Comment_Model();
		// get comments that are attached to this post
		$postComments = $commentObj->getComments($params['postid']);
		// run a delete on each of these comments
		if (!empty($postComments)) {
			foreach ($postComments as $key=>$comment) {
				$commentObj->delete($comment['id']);
			}
		}
		$statement = $this->dbHandle->prepare("DELETE FROM posts WHERE id=:postid");
		$statement->execute($params);
	}
	
	/* edit post */
	
	public function editPost($title,$author,$body,$saveid) {
		$params = array();
		$params['title'] = $title;
		$params['author'] = $author;
		$params['body'] = $body;
		$params['saveid'] = (integer)$saveid;
		$statement = $this->dbHandle->prepare("UPDATE posts SET title=:title, author=:author, body=:body WHERE id=:saveid");
		$statement->execute($params);
	}
	
	public function getPosts($page,$count = 10) {
		return $this->pagedQuery($page,$count,'posts','date_posted','desc');
	}
	
	public function getPost() {
		$params = array();
		$params['postid'] = (int) $_GET['postid'];
		$statement = $this->dbHandle->prepare("SELECT * FROM posts WHERE id=:postid");
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);  
		$row = $statement->fetch();
		return $row;
	}
	
	public function getPostTitle($id = null) {
		if ($id == null) {
			return;
		}
		$params = array();
		$params['id'] = (int) $id;
		$query = "SELECT title FROM posts WHERE id=:id";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		$result = $statement->fetch();
		if (1 !== $statement->rowCount()) {
				return false;
			}
		return $result['title'];
	}
	
	public function getPostCount() {
		return $this->getTotalRecords('posts');
	}
}
?>