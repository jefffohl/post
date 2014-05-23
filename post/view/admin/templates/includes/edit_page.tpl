
		<h2>Edit Page</h2>
			<div class="new_post">
			<form method="post" action=".?view=editpage"> 
			  <div><label for="title">Title: </label><input type="text" id="title" name="title" value="{$contentPage.title}" /></div>
			   <div><label for="body">Body: </label><textarea id="body" name="body">{$contentPage.body}</textarea></div>
			  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
			  <input type="hidden" id="saveid" name="saveid" value="{$contentPage.id}" />
			  <div class="submit"><input type="submit" value="Save" name="submit" /></div>
			</form>
			</div>
