<script type="text/javascript">
function addImage() {
	var newItem = "<div>" +
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
</script>

		<h2>Edit Portfolio</h2>
			<div class="new_post">
			<form method="post" action=".?view=editportfolio" enctype="multipart/form-data"> 
			  <div><label for="title">Title: </label><input type="text" id="title" name="title" value="{$portfolio.title}" /></div>
			  <div><label for="thumbnail">Thumbnail: </label><img src="{$portfolio.thumbnail}" width="100" /><input type="hidden" name="thumbnail" value="{$portfolio.thumbnail}" /><input type='file' name='portfolio_thumbnail[]' /></div>
			  <div><label for="categories">Categories: </label><input type="text" id="categories" name="categories" value="{$portfolio.categories}" /></div>
			  <div><label for="body">Body: </label><textarea id="body" name="body">{$portfolio.body}</textarea></div>
			  <script type="text/javascript">CKEDITOR.replace( 'body' );</script>
			  <div id="portfolio_images">
			  {foreach from=$portfolio.images key="key" item="item"}
			  <div>
			  		<h2>Image {$key + 1}</h2>
				  	<table class="portfolio_images">
					  <tr>
					  	<th>
					  		<label for="image_{$item.id}">Image: </label>
					  	</th>
					  	<td>
					  		{if !empty($item.thumbnail)}<img src="{$item.imageurl}" width="100">{/if}
					  	</td>
					  	<td>
					  		<input type='file' name='existing_images[{$item.id}]' />
					  		<input type='hidden' name='existing_images[{$item.id}]' value="{$item.imageurl}" />
					  	</td>
					  </tr>
					  <tr>
					  	<th>
					  		<label for="thumbnail_{$item.id}">Thumbnail: </label>
					  	</th>
					  	<td>
					  		{if !empty($item.thumbnail)}<img src="{$item.thumbnail}" width="100">{/if}
					  	</td>
					  	<td>
					  		<input type='file' name='existing_thumbnails[{$item.id}]' />
					  		<input type='hidden' name='existing_thumbnails[{$item.id}]' value="{$item.thumbnail}" />
					  	</td>
					  </tr>
					  <tr>
					  	<th>
					  		<label for="description_{$item.id}">Description: </label>
					  	</th>
					  	<td colspan="2">
					  		<textarea rows="4" id="description_{$item.id}" name="existing_descriptions[{$item.id}]">{$item.description}</textarea>
					  	</td>
					  </tr>
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