<p><i>Admin functions are currently disabled until authentication is implemented.</i></p>
Create new module:
<form action="/action/modules/create_new_module" method="post">
	<label for="name">Name</label>
	<input type="text" name="name" autocomplete="off"><br><br>
	<label for="content">Content</label><br>
	<textarea name="content" rows="10" cols="30"></textarea>
	<br>
	<input type="submit" value="Create">
</form>
<br>
Delete module:
<table border="1" cellpadding="5">
<?
	$mods = $CMS->modlist();
	foreach ($mods as $mod) {
		echo "<tr><td>".$mod."</td><td><a href='/action/modules/delete_module?name=".$mod."'>delete</a></td></tr>";
	}
?>
</table>