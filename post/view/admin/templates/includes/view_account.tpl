
<div class="my-account">
	<h2>Welcome, {$user.firstname}</h2>
		<table class="admin">
				<tr>
					<th>First Name:</th><td>{$user.firstname}</td>
				</tr>
				<tr>
					<th>Last Name:</th><td>{$user.lastname}</td>
				</tr>
				<tr>
					<th>Username:</th><td>{$user.username}</td>
				</tr>
				<tr>
					<th>Email:</th><td>{$user.email}</td>
				</tr>
				<tr>
					<th>Notify me when 
					someone adds a comment 
					to a post I have also 
					commented on:</th><td>{if $user.commentsNotification == 1}Yes{elseif $user.commentsNotification == 0}No{/if}</td>
				</tr>
				<tr>
					<th>Password:</th><td>{$user.password}</td>
				</tr>
			</table>
			<div class="buttons"><a class="button" href=".?view=editaccount">Edit</a></div>
</div>
