<script type="text/javascript">
function addImage() {
	var newItem = "<div><table><input type='hidden' name='imageIDs[]' value=''><tr><th><label>Image URL: </label></th><td><input type='text' size='100' name='images[]' value=''></td></tr><tr><th><label>Thumbnail URL: </label></th><td><input type='text' size='100' name='image_thumbnails[]' value=''></td></tr><tr><th><label>Description: </label></th><td><textarea rows='4' cols='76' name='image_descriptions[]'></textarea></td></tr></table></div>";
	$('#portfolio_images').append(newItem);
}
</script>

		<h2>Edit Portfolio</h2>
			<div class="new_post">
			<form method="post" action=".?view=editportfolio"> 
			  <div><label for="title">Title: </label><input type="text" id="title" name="title" value="{$portfolio.title}" /></div>
			  <div><label for="thumbnail">Thumbnail: </label><input type="text" id="thumbnail" name="thumbnail" value="{$portfolio.thumbnail}" /></div>
			  <div><label for="categories">Categories: </label><input type="text" id="categories" name="categories" value="{$portfolio.categories}" /></div>
			  <div><label for="body">Body: </label><textarea id="body" name="body">{$portfolio.body}</textarea></div>
			  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
			  <h3>Images</h3>
			  <div id="portfolio_images">
			  {foreach from=$portfolio.images key="key" item="item"}
			  <div>
				  <table>
					  <input type="hidden" name="imageIDs[]" value="{$item.id}" />
					  <tr><th><label for="image_{$item.id}">Image URL: </label></th><td><input type="text" id="image_{$item.id}" name="images[]" value="{$item.imageurl}" /></td></tr>
					  <tr><th><label for="thumbnail_{$item.id}">Thumbnail URL: </label></th><td><input type="text" id="thumbnail_{$item.id}" name="image_thumbnails[]" value="{$item.thumbnail}" /></td></tr>
					  <tr><th><label for="description_{$item.id}">Description: </label></th><td><textarea rows="4" id="description_{$item.id}" name="image_descriptions[]">{$item.description}</textarea></td></tr>
				  </table>
				  <a class="delete button" href=".?action=delete&module=portfolioimage&title={$item.imageurl}&id={$item.id}">Delete</a>
			  </div>
			  {/foreach}
			  </div>
			  <a class="button" onclick="addImage();return false;">Add Image</a>
			  <input type="hidden" id="saveid" name="saveid" value="{$portfolio.id}" />
			  <div class="submit"><input type="submit" value="Submit" name="submit" /></div>
			</form>
			</div>