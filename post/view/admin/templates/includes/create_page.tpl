
		<h2>Create a New Page</h2>
		<div class="new_post">
		<form method="post" action=".?view=createpage"> 
		  <div><label for="title">Title: </label><input type="text" class="title" id="title" name="title" /></div> 
		  <div><label for="body">Body: </label><textarea id="body" name="body"></textarea></div>
		  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
		  <div class="submit"><input type="submit" value="Save" name="submit" /></div>
		</form>
		</div>