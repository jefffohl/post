
		<h2>Edit Post</h2>
			<div class="new_post">
			<form method="post" action=".?view=editpost"> 
			  <div><label for="title">Title: </label><input type="text" id="title" name="title" value="{$post.title}" /></div>
			  <div><label for="author">Author: </label><input type="text" id="author" name="author" value="{$post.author}" /></div>
			  <div><label for="body">Body: </label><textarea id="body" name="body">{$post.body}</textarea></div>
			  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
			  <input type="hidden" id="saveid" name="saveid" value="{$post.id}" />
			  <div class="submit"><input type="submit" value="Post" name="submit" /></div>
			</form>
			</div>
