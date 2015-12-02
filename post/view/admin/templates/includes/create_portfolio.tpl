<!--<script type="text/javascript">
function addImage() {
	var newItem = 	"<div>" +
						"<table>" +
							"<tr>" +
								"<th>" +
									"<label>Image URL: </label>" +
								"</th>" +
								"<td>" +
									"<input type='file' name='new_images[]' />" +
								"</td>" +
							"</tr>" +
							"<tr>" +
								"<th>" +
									"<label>Thumbnail URL: </label>" +
								"</th>" +
								"<td>" +
									"<input type='file' name='new_thumbnails[]'>" +
								"</td>" +
							"</tr>" +
							"<tr>" +
								"<th>" +
									"<label>Description: </label>" +
								"</th>" +
								"<td>" +
									"<textarea rows='4' cols='76' name='new_descriptions[]'></textarea>" +
								"</td>" +
							"</tr>" +
						"</table>" +
					"</div>";
	$('#portfolio_images').append(newItem);
}
</script>-->
		<h2>Create a New Portfolio</h2>
		<div class="new_post">
		<form method="post" action=".?view=createportfolio" enctype="multipart/form-data"> 
			  <div><label for="title">Title: </label><input type="text" id="title" name="title" value="{$portfolio.title}" /></div>
			  <div><label for="thumbnail">Thumbnail: </label><input type='file' name='portfolio_thumbnail[]' /></div>
			  <div><label for="categories">Categories: </label><input type="text" id="categories" name="categories" value="{$portfolio.categories}" /></div>
			  <div><label for="body">Body: </label><textarea id="body" name="body">{$portfolio.body}</textarea></div>
			  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
			  <!--<h3>Images</h3>
			  <div id="portfolio_images"></div>
			  <a class="button" onclick="addImage(); return false;">Add Image</a>-->
			  <div class="submit"><input type="submit" value="Submit" name="submit" /></div>
			</form>
		</div>