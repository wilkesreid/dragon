Create user:
<form action="/action/auth/create_user" method="post">
	<label for="name">Username</label><br>
	<input type="text" name="name"><br>
	<label for="password">Password</label><br>
	<input type="text" name="password"><br>
	<input type="submit" value="Create">
</form>
This form submits to a script that uses the following code:
<blockquote>
<pre>
$user = new DatabaseEntry();

$user->username = $_POST['name'];
$user->password = $_POST['password'];
$user->exclusive("username");

$CMS->database->insert($user)->into("users");
</pre>
</blockquote>
<br>
Users:<br>
<ul>
	<?
		
		$users = $CMS->database->get("users")->all();
		foreach ($users as $user) {
			echo "<li>username: ".$user->username." | password: ".$user->password."</li>";
		}
	?>
</ul>
The users are being listed using the following PHP:
<blockquote>
<pre>
$users = $CMS->database->get("users")->all();
foreach ($users as $user) {
	echo "&lt;li&gt;username: ".$user->username." | password: ".$user->password."&lt;/li&gt;";
}
</pre>
</blockquote>