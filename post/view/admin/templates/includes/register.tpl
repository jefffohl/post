<div class="my-account">
<h2>Register</h2>
<p>All fields are required</p>
{if $message<>''}<h4 class="message">{$message}</h4>{/if}
	<form method="post" action=".?view=register">
		<table class="admin">
			<tr><th><label for="username">First Name</label></th><td><input type="text" name="firstname" value="{$_POST.firstname}"/></td></tr>
			<tr><th><label for="password">Last Name</label></th><td><input type="text" name="lastname" value="{$_POST.lastname}" /></td></tr>
			<tr><th><label for="username">Username</label></th><td><input type="text" name="username" value="{$_POST.username}" /></td></tr>
			<tr><th><label for="email">Email</label></td><th><input type="text" name="email" value="{$_POST.email}" /></td></tr>
			<tr><th><label for="password">Password</label></th><td><input type="text" name="password" value="{$_POST.password}" /></td></tr>
			<tr><th><label for="commentsNotification">Notify me when someone comments<br>on a post I have also commented on.</label></th>
			<td><input type="radio" name="commentsNotification" value="1" /> Yes<br />
			<input type="radio" name="commentsNotification" checked value="0" /> No</td></tr>
			<tr><td colspan="2"><input type="submit" value="Register" /></td></tr>
		</table>
	</form>
	<p><a href=".?view=login">Return to log in screen &raquo;</a></p>
</div>
