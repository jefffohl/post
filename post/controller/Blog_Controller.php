<?php

require_once(MODEL_PATH.'Blog_Model.php');
require_once(MODEL_PATH.'Comment_Model.php');

class Blog_Controller {
	
	public function __construct() {
		$this->blogObj = new Blog_Model();
		$this->commentObj = new Comment_Model();
		$this->title = null;
	}
	
	public function execute() {
		if (isset($_GET['postid'])) {
			return $this->viewPost();
		}
		/* get a list of posts */
		else {
			return $this->viewPosts();
		}
	}
	
	public function viewPosts() {
		global $smarty;
		$page = isset($_GET['blog_page']) ? (int) $_GET['blog_page']: 1;
			$posts = $this->blogObj->getPosts($page,5);
			$pages = $this->blogObj->pages;
			$this->title = "Blog - page $page of $pages";
			$smarty->assign('blog_pages',$pages);
			$smarty->assign('blog_currentpage',$page);
			$smarty->assign('posts',$posts);	
			return $smarty->fetch('blogroll.tpl');
	}
	
	public function viewPost() {
		global $smarty;
		// check for comment post
		if (isset($_POST['comment'])) {
			$comment = nl2br(strip_tags($_POST['comment']));
			$userid = (int) $_SESSION['id'];
			$postid = (int) $_GET['postid'];
			$URLparams = "";
			$counter = 0;
			$delimiter = "";
			foreach ($_GET as $key=>$value) {
				if ($counter >0) {
					$delimiter = "&";
				}
				$URLparams .= "$delimiter$key=$value";
				$counter++;
			}
			$this->commentObj->newComment($comment,$userid,$postid);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?$URLparams");
		}
		// show post
		$post = $this->blogObj->getPost();
		$comments = $this->commentObj->getComments();
		$this->title = $post['title'];
		// $smarty->assign('page',$page);
		$smarty->assign('post',$post);
		$smarty->assign('comments',$comments);
		return $smarty->fetch('blogpost.tpl');
	}

}



