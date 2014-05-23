<h2>Delete Record Check</h2>
<p>Are you sure you want to delete {$recordtitle}?</p>
<form class="delete" method="post" action="{$_SERVERINFO.PHP_SELF}">
<input type="hidden" name="module" value="{$_module}" />
<input type="hidden" name="id" value="{$_recordid}" />
<input type="hidden" name="title" value="{$recordtitle}" />
<input type="hidden" name="action" value="delete" />
<input type="submit" value="OK" />
</form>
