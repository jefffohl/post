
<div class="my-account">
		{if $message<>''}<h4>{$message}</h4>{/if}
			<h2>Forgotten Password</h2>
			<p>Please enter your username and we will send your password to the email address we have on file.</p>
		<form method="post" action=".?view=forgotpassword">
			<label for="username">Username:</label><input type="text" name="username" /><br />
			<input type="submit" value="Submit" />
		</form>
		<p>Not registered?<br>
		<a href=".?view=register">Register here &raquo;</a></p>
		<p><a href=".?view=login">Return to log in screen &raquo;</a>
		</p>
</div>
