
		<div class="my-account">
			<h2>Edit My Account</h2>
		<form method="post" action=".?view=editaccount">
		<table class="admin">
				<tr>
					<th>First Name:</th><td><input type="text" name="firstname" value="{$user.firstname}" /></td>
				</tr>
				<tr>
					<th>Last Name:</th><td><input type="text" name="lastname" value="{$user.lastname}" /></td>
				</tr>
				<tr>
					<th>Username:</th><td><input type="hidden" name="username" value="{$user.username}" />{$user.username}</td>
				</tr>
				<tr>
					<th>Email:</th><td><input type="text" name="email" value="{$user.email}" /></td>
				</tr>
				<tr>
					<th>Password:</th><td><input type="text" name="password" value="{$user.password}" /></td>
				</tr>
				<tr>
					<th>Notify me when someone adds a comment to a post I have also commented on:</th><td><input type="radio" name="commentsNotification" value="1" {if $user.commentsNotification == 1}checked{/if} /> Yes<br /><input type="radio" name="commentsNotification" value="0" {if $user.commentsNotification == 0}checked{/if} /> No</td>
				</tr>
			</table><div class="buttons">
			<input type="hidden" name="id" value="{$user.id}" />
		<input type="submit" value="Update" />
		<input type="button" value="Cancel" onclick="history.go(-1);"/>
		</div>
		</form>
		</div>
