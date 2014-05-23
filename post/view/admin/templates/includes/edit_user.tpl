
		<h2>Edit User</h2>
			<div class="new_post">
			<form method="post" action=".?view=edituser">
			<table class="admin">
					<tr>
						<th>First Name:</th><td><input type="text" id="firstname" name="firstname" value="{$user.firstname}" /></td>
					</tr>
					<tr>
						<th>Last Name:</th><td><input type="text" id="lastname" name="lastname" value="{$user.lastname}" /></td>
					</tr>
					<tr>
						<th>Username:</th><td>{$user.username}</td>
					</tr>
					<tr>
						<th>Email:</th><td><input type="text" id="email" name="email" value="{$user.email}" /></td>
					</tr>
					<tr>
						<th>Password:</th><td><input type="text" id="password" name="password" value="{$user.password}" /></td>
					</tr>
					<tr>
						<th>Notify when someone adds a comment to a post user has also commented on:</th><td><input type="radio" name="commentsNotification" value="1" {if $user.commentsNotification == 1}checked{/if} /> Yes<br /><input type="radio" name="commentsNotification" value="0" {if $user.commentsNotification == 0}checked{/if} /> No</td>
					</tr>
					<tr>
						<th>Class:</th><td>
							<select id="class" name="class">
								<option {if $user.class == 'User'}selected {/if}value="User">User</option>
								<option {if $user.class == 'Administrator'}selected {/if}value="Administrator">Administrator</option>
							</select>
						</td>
					</tr>
			</table>
			<input type="hidden" name="saveid" id="saveid" value="{$user.id}" />
		<input type="submit" value="Update" />
		<input type="button" value="Cancel" onclick="history.go(-1);"/>
		</form>
			</div>