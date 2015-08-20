<p><i>Admin functions are currently disabled until authentication is implemented.</i></p>
Change site name:
<form action="/action/config/update_site_title" method="post">
	<label for="title">Title</label>
	<input type="text" name="title" autocapitalize="on" autocomplete="off" value="<?=htmlspecialchars($CMS->config->title);?>">
	<br>
	<input type="submit" value="Save">
</form>
<br>