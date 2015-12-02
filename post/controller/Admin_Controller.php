<?php

require_once(MODEL_PATH.'Blog_Model.php');
require_once(MODEL_PATH.'Comment_Model.php');
require_once(MODEL_PATH.'Portfolio_Model.php');
require_once(MODEL_PATH.'PortfolioImage_Model.php');
require_once(MODEL_PATH.'User_Model.php');
require_once(MODEL_PATH.'Page_Model.php');
require_once(CONTROLLER_PATH.'fileUpload.php');

class Admin_Controller {
	
	public function __construct() {
		$this->blogObj = new Blog_Model();
		$this->commentObj = new Comment_Model();
		$this->userObj = new User_Model();
		$this->portfolioObj = new Portfolio_Model();
		$this->portfolioimageObj = new PortfolioImage_Model();
		$this->contentPageObj = new Page_Model();
		$this->fileUpload = new fileUpload();
	}
	
	public function execute() {
		
		/* authentication */
		
		if (!$this->isLoggedIn()) {
			return $this->logIn();
		}
		
		/* if this checks out, do the view handling */
		
		if(isset($_GET['view'])) {
			switch ($_GET['view']) {
				case "viewposts":
					return $this->viewPosts();
				case "createpost":
					return $this->createPost();
				case "editpost":
					return $this->editPost();
				case "viewpages":
					return $this->viewContentPages();
				case "createpage":
					return $this->createContentPage();
				case "editpage":
					return $this->editContentPage();
				case "viewcomments":
					return $this->viewComments();
				case "viewusers":
					return $this->viewUsers();
				case "edituser":
					return $this->editUser();
				case "saved":
					return $this->saved();
				case "viewportfolios":
					return $this->viewPortfolios();
				case "createportfolio":
					return $this->createPortfolio();
				case "editportfolio":
					return $this->editPortfolio();
				default :
					return $this->viewPosts();
			}
		}
		elseif (isset($_GET['action'])) {
			switch ($_GET['action']) {
				case "delete" :
					return $this->checkDelete();
				case "logout" :
					return $this->logOut();
			}
		}
		elseif (isset($_POST['action']) && $_POST['action'] == 'delete') {
			return $this->doDelete();
		}
		else {
			return $this->viewPosts();
		}
	}
	
	public function isLoggedIn() {
		if (isset($_SESSION['username']) && $_SESSION['class'] === "Administrator") {
			return true;
		} else {
			return false;
		}
	}
	
	
	public function logIn() {
		global $smarty;
		// If no previous session, has the user submitted the form?
		if (isset($_POST['username'])) {
			$username = $_POST['username'];
			$password = $_POST['password'];
			if($this->userObj->login($username,$password)) {
				header("Location: ".$_SERVER['PHP_SELF']);
			}
			else {
				$message = "Sorry. Please try again.";
				$smarty->assign('message',$message);
				$smarty->assign('messagetitle','Log In Failed');
				return $smarty->fetch('message.tpl');
			}
		}
		else {
			return $smarty->fetch('login.tpl');
		}
	}
	
	public function logOut() {
		session_start();
    	session_destroy();
		header("Location: ".$_SERVER['PHP_SELF']);
	}
	
	public function checkDelete() {
		global $smarty;
		if (empty($_GET['module']) || empty($_GET['id'])) {
			$smarty->assign('messagetitle','Error');
			$smarty->assign('message','Deletion unsuccessful. There was a missing parameter.');
			return $smarty->fetch('message.tpl');
		}
		$module = $_GET['module'];
		$recordid = $_GET['id'];
		$recordtitle = $_GET['title'];
		$smarty->assign('recordtitle',$_GET['title']);
		$smarty->assign('_module',$module);
		$smarty->assign('_recordid',$recordid);
		return $smarty->fetch('delete.tpl');
	}
	
	public function doDelete() {
		global $smarty;
		$module = $_POST['module'].'Obj';
		$recordid = $_POST['id'];
		$this->$module->delete($recordid);
		$message = "Record titled, {$_POST['title']}, has been deleted.";
		$smarty->assign('message',$message);
		$smarty->assign('messagetitle','Deleted');
		return $smarty->fetch('message.tpl');
	}
	
	public function viewPosts() {
		global $smarty;
		$postCount = $this->blogObj->getPostCount();
		$smarty->assign('totalposts',$postCount);	
		$page = isset($_GET['page']) ? (int) $_GET['page']: 1;
		$posts = $this->blogObj->getPosts($page);
		$pages = $this->blogObj->pages;
		$smarty->assign('pages',$pages);
		$smarty->assign('currentpage',$page);
		$smarty->assign('posts',$posts);	
		return $smarty->fetch('view_posts.tpl');
	}
	
	public function viewComments() {
		global $smarty;
		$page = isset($_GET['page']) ? (int) $_GET['page']: 1;
		$comments = $this->commentObj->getCommentList($page);
		foreach ($comments as $key=>&$comment) {
			$comment['username'] = $this->userObj->getUserName($comment['userid']);
			$comment['posttitle'] = $this->blogObj->getPostTitle($comment['postid']);
		}
		$pages = $this->commentObj->pages;
		$smarty->assign('pages',$pages);
		$smarty->assign('currentpage',$page);
		$smarty->assign('comments',$comments);
		return $smarty->fetch('view_comments.tpl');
	}
	
	public function editPost() {
		global $smarty;
		if (isset($_POST['saveid'])) {	
			$this->blogObj->editPost($_POST['title'],$_POST['author'],$_POST['body'],$_POST['saveid']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
		}
		
		// if not, we show the requested post
		elseif (isset($_GET['postid'])) {
			$post = $this->blogObj->getPost();
			$smarty->assign('post',$post);
			return $smarty->fetch('edit_post.tpl');
		}
		
		else {
			return "Some sort of problem occured. It seems that you are trying to edit a post, but no Post ID was provided in the URL.";
		}
	}
	
	public function createPost() {
		global $smarty;
		if (isset($_POST['title'])) {
			$this->blogObj->createPost();
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
			
		// if not, we display the form for saving the data
		}
		else {
			return $smarty->fetch('create_post.tpl');
		}
	}
	
	public function viewUsers() {
		global $smarty;
		$page = isset($_GET['page']) ? (int) $_GET['page']: 1;
		$users = $this->userObj->getusers($page);
		$pages = $this->userObj->pages;
		$smarty->assign('pages',$pages);
		$smarty->assign('currentpage',$page);
		$smarty->assign('users',$users);	
		return $smarty->fetch('view_users.tpl');
	}
	
	public function editUser() {
		global $smarty;
		if (isset($_POST['saveid'])) {	
			$this->userObj->updateUser($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['password'],$_POST['commentsNotification'],$_POST['saveid'],$_POST['class']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
		}
		// if not, we show the requested user
		elseif (isset($_GET['userid'])) {
			$user = $this->userObj->getUserAccount($_GET['userid']);
			$smarty->assign('user',$user);
			return $smarty->fetch('edit_user.tpl');
		}
		else {
			return "Some sort of problem occured. It seems that you are trying to edit a user, but no user ID was provided in the URL.";
		}
	}
	
	public function saved() {
		global $smarty;
		$smarty->assign('messagetitle','Saved');
		$smarty->assign('message','The record has been saved sucessfully.');
		return $smarty->fetch('message.tpl');
	}
	
	public function createPortfolio() {
		global $smarty;
		if (isset($_POST['title'])) {
			$this->portfolioObj->createPortfolio($_POST['title'],$_POST['thumbnail'],$_POST['body'],$_POST['categories'],$_POST['images']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
			
		// if not, we display the form for saving the data
		}
		else {
			return $smarty->fetch('create_portfolio.tpl');
		}
	}
	
	public function viewPortfolios() {
		global $smarty;
		// if we are updating the priority of our records:
		if (isset($_POST['saveids'])) {	
			$this->portfolioObj->updatePriority('portfolio',$_POST['saveids'],$_POST['priorities']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=viewportfolios");
		}
		// or perhaps we are deleting a record?
		elseif (isset($_GET['deleteportfolioid'])) {
			$deleteid = (int) $_GET['deleteportfolioid'];
			$this->portfolioObj->deletePost($deleteid);
			// cleanse the $_POST array by sending a new header:
			header("Location: ".$_SERVER['PHP_SELF']."?view=viewportfolios");
		}
		
		// else we continue and get a list of portfolios
		else {
			$page = isset($_GET['page']) ? (int) $_GET['page']: 1;
			$portfolios = $this->portfolioObj->getPagedPortfolios($page);
			$totalRecords = $this->portfolioObj->getPortfolioCount();
			$pages = $this->portfolioObj->pages;
			$smarty->assign('pages',$pages);
			$smarty->assign('totalRecords',$totalRecords);
			$smarty->assign('currentpage',$page);
			$smarty->assign('portfolios',$portfolios);	
			return$smarty->fetch('view_portfolios.tpl');
		}
	}
	
	public function editPortfolio() {
		global $smarty;
		if (isset($_POST['saveid']) && !empty($_POST['title'])) {
			// strip out all whitespace
			$portfolioName = preg_replace('/\s*/', '', $_POST['title']);
			// convert the string to all lowercase
			$portfolioName = strtolower($portfolioName);
			
			// roll up the existing images
			$existing_images = array();
			foreach($_POST['existing_images'] as $key=>$value) {
				$existing_images[$key] = array("id" => $key, "imageurl" => $value, "thumbnail" => $_POST['existing_thumbnails'][$key], "description" => $_POST['existing_descriptions'][$key]);
			}
			// check for new imageurls:
			$updated_images = $this->fileUpload->upload($portfolioName, $_FILES['existing_images']);
			$updated_thumbnails = $this->fileUpload->upload($portfolioName, $_FILES['existing_thumbnails']);
			foreach($updated_images as $key=>$value) {
				$existing_images[$key]["imageurl"] = $value;
			}
			foreach($updated_thumbnails as $key=>$value) {
				$existing_images[$key]["thumbnail"] = $value;
			}

			// roll up the new images
			$new_images = array();
			$new_mainimages = $this->fileUpload->upload($portfolioName, $_FILES['new_images']);
			$new_thumbnails = $this->fileUpload->upload($portfolioName, $_FILES['new_thumbnails']);

			foreach($new_mainimages as $key=>$value) {
				$new_images[$key] = array("imageurl" => $value, "thumbnail" => $new_thumbnails[$key], "description" => $_POST["new_descriptions"][$key]);
			}

			$this->portfolioObj->editPortfolio($_POST['title'],$_POST['thumbnail'],$_POST['body'],$_POST['categories'],$existing_images,$new_images,$_POST['saveid']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
		}
		// if not, we show the requested post
		elseif (isset($_GET['portfolioid'])) {
			$portfolio = $this->portfolioObj->getPortfolio($_GET['portfolioid']);
			$portfolio['images'] = $this->portfolioObj->getPortfolioImages($_GET['portfolioid']);
			$smarty->assign('portfolio',$portfolio);
			return $smarty->fetch('edit_portfolio.tpl');
		}
		else {
			return "Some sort of problem occured. It seems that you are trying to edit a portfolio, but no portfolio ID was provided in the URL.";
		}
	}
	
	public function viewContentPages() {
		global $smarty;
		$contentPageCount = $this->contentPageObj->getContentPageCount();
		$smarty->assign('totalcontentpages',$contentPageCount);	
		$page = isset($_GET['page']) ? (int) $_GET['page']: 1;
		$contentPages = $this->contentPageObj->getContentPages($page);
		$pages = $this->contentPageObj->pages;
		$smarty->assign('pages',$pages);
		$smarty->assign('currentpage',$page);
		$smarty->assign('contentpages',$contentPages);	
		return $smarty->fetch('view_pages.tpl');
	}
	
	public function editContentPage() {
		global $smarty;
		if (isset($_POST['saveid'])) {	
			$this->contentPageObj->editContentPage($_POST['title'],$_POST['body'],$_POST['saveid']);
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
		}
		
		// if not, we show the requested post
		elseif (isset($_GET['contentpageid'])) {
			$contentPage = $this->contentPageObj->getContentPage($_GET['contentpageid']);
			$smarty->assign('contentPage',$contentPage);
			return $smarty->fetch('edit_page.tpl');
		}
		
		else {
			return "Some sort of problem occured. It seems that you are trying to edit a page, but no page ID was provided in the URL.";
		}
	}
	
	public function createContentPage() {
		global $smarty;
		if (isset($_POST['title'])) {
			$this->contentPageObj->createContentPage();
			/* cleanse the $_POST array */
			header("Location: ".$_SERVER['PHP_SELF']."?view=saved");
			
		// if not, we display the form for saving the data
		}
		else {
			return $smarty->fetch('create_page.tpl');
		}
	}
}