
	<div class="blog">
		<div class="single-post">
			<h3>{$post.title}</h3>
			<p class="date-posted">{$post.date_posted|date_format:"%B %e, %Y @ %l:%M %p"}</p>
			<div class="post-body">{$post.body}</div>
		</div>	
		<div class="comments">
					<h4>Comments</h4>
					{if $loggedin !== true}
						<p>Please <a href="/account/">login</a> or <a href="/account/?view=register">register</a> to make a comment.</p>
					{/if}
					{if $comments|count > 0}
					{foreach from=$comments key="k" item="comment"}
						<div class="comment">
							<div class="comment-body">{$comment.body}</div>
							<div class="by">
								<div class="comment-author">{$comment.username}</div>
								<div class="comment-timestamp">Posted on: {$comment.date_posted|date_format:"%B %e, %Y @ %l:%M %p"}</div>
							</div>
						</div>
					{/foreach}
					{/if}
		</div>
		{if $loggedin === true}
		<div class="commentform-container">
					<h4>Make a comment:</h4>
					<form name="commentform" id="commentform" method="post" action="{paramURL name="postid" value=$_GET.postid}">
						<textarea name="comment" id="comment"></textarea>
						<div class="submit-button"><input type="submit" value="Submit"></div>
					</form>
		</div>
		{/if}
	</div>