<?php


class Comment_Model extends PostDatabase {
	
	public function newComment($comment = null,$userid = null,$postid = null) {
		if ($comment == null || $userid == null || $postid == null) {
			return;
		}
		$params = array();
		$params['comment'] = $comment;
		$params['userid'] = $userid;
		$params['postid'] = $postid;
		
		$query = "INSERT INTO comments (body, date_posted, userid, postid) VALUES (:comment,NOW(),:userid,:postid)";
		$statement = $this->dbHandle->prepare($query);
		$statement->execute($params);
		$this->mailer($params['postid']);
		/* check to see if anyone who has commented on this post has opted to get notifications */
		$users = $this->getNotifiableUsers($params['postid']);
		foreach ($users as $user) {
			if($user['userid'] !== $params['userid']) {
			$this->commentsNotifier($user['username'],$user['email'],$params['postid']);
			}
		}
		
	}

	public function getNotifiableUsers($postid) {
		$params['postid'] = $postid;
		$query = "select u.username, u.email, c.userid FROM comments c JOIN users u ON c.userid = u.id WHERE u.commentsNotification=1 AND c.postid=:postid";
		$statement = $this->dbHandle->prepare($query);
		$users = array();
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($user = $statement->fetch())
	        {
	            $users[] = $user;
	        }
		return $users;
	}
	
	public function getComments($postid = null) {
		if (isset($postid)) {
			$params['postid'] = (int) $postid;
		} elseif (isset ($_GET['postid'])) {
			$params['postid'] = (int) $_GET['postid'];
		} else {
			return;
		}
		$query = "select c.id, c.body, c.date_posted, u.username FROM comments c JOIN users u ON c.userid = u.id WHERE c.postid=:postid ORDER BY c.date_posted ASC";
		$statement = $this->dbHandle->prepare($query);
		$comments = array();
		$statement->execute($params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		while ($comment = $statement->fetch())
	        {
	            $comments[] = $comment;
	        }
		return $comments;
	}
	
	public function getCommentList($page) {
		return $this->pagedQuery($page,10,'comments','date_posted','desc');
	}
	
	private function mailer($postid) {
		// mail the admin a notice 
		$message = "Someone posted a comment on Post. You can see it here: http://{$_SERVER['SERVER_NAME']}/?postid={$postid}";

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70);
		
		// Send
		mail(ADMIN_EMAIL, 'New Comment on Post', $message);
	}
	
	private function commentsNotifier($userName,$userEmail,$postid) {
		// mail a notice 
		$message = "Hello $userName -\n\nOn ".BLOG_TITLE.", someone commented on a post that you also commented on.\n\nThe post can be seen here: http://{$_SERVER['SERVER_NAME']}/?postid={$postid}\n\nCheers,\n\nThe ".BLOG_TITLE." Team.";

		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		// $message = wordwrap($message, 70);
		
		// Send
		mail($userEmail, 'Comment notification from '.BLOG_TITLE, $message);
	}
	
	public function delete($id) {
			$params = array();
			$params['id'] = (int)$id;
			$statement = $this->dbHandle->prepare("DELETE FROM comments WHERE id=:id");
			$statement->execute($params);
		}
	
}
?>