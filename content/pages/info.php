<p>This is a custom CMS made by Samuel Reid.</p>
<p>Here are some of the PHP objects I'm using, and the methods and properties they have:</p>
<p>
<h2 style='text-align:center'>$CMS</h2>
<table border="1" cellpadding="7">
	<tr>
		<th colspan="2">General Methods and Properties</th>
	</tr>
	<tr>
		<td>route</td>
		<td>Shows the current path in the address bar. The route for this page is "<!-- <?="<? echo \$CMS->route; ?>";?> --><?=$CMS->route;?>"</td>
	</tr>
	<tr>
		<td>routepath</td>
		<td>Utility for getting the entire path from the document root.</td>
	</tr>
	<tr>
		<td>routefile</td>
		<td>The name of the file the route points to, including the ".php" extension.</td>
	</tr>
	<tr>
		<td>page</td>
		<td>The contents of the current page are stored in this variable. Echoing this will display the current page.</td>
	</tr>
	<tr>
		<td>database</td>
		<td>A database object that can be easily used to store and retrieve persistent data (uses JSON).</td>
	</tr>
	<tr>
		<td>config</td>
		<td>An object with all the configurations and settings for the overall site. This includes:
			<table border="1" cellpadding="5">
				<tr>
					<td>title</td>
					<td>The title of the site.</td>
				</tr>
				<tr>
					<td>template</td>
					<td>The name of the template being used.</td>
				</tr>
			</table>
			These are stored in an JSON file for easy editing.
		</td>
	</tr>
	<tr>
		<th colspan="2">Module Methods and Properties</th>
	</tr>
	<tr>
		<td>mod(string $mod)</td>
		<td>A function that displays the module with the name given. e.g. mod('footer')</td>
	</tr>
	<tr>
		<td>modlist()</td>
		<td>Returns a list of all existing modules.</td>
	</tr>
	<tr>
		<td>location(string $location)</td>
		<td>Displays all modules that should be displayed on the current page at the location given.</td>
	</tr>
	<tr>
		<td>createModule(string $name,string $contents)</td>
		<td>Creates a new module with the given name and contents, and saves it to disk.</td>
	</tr>
	<tr>
		<td>deleteModule(string $name)</td>
		<td>Deletes all files associated with the given module from disk.</td>
	</tr>
</table>
</p>
<p>
<h2 style='text-align:center'>$Module</h2>
<table border="1" cellpadding="7">
	<tr>
		<td>name</td>
		<td>The name of the module.</td>
	</tr>
	<tr>
		<td>settings</td>
		<td>An object containing the settings for the module (gotten from mod.json in the module's folder), including:
			<table border="1" cellpadding="5">
				<tr>
					<td>mode</td>
					<td>Can either be "whitelist" or "blacklist", depending on if you want the
					following list of pages to be the ones to show this module on (whitelist), 
					or the ones to not show this module on (blacklist).</td>
				</tr>
				<tr>
					<td>pages</td>
					<td>A list of the pages to either include or exculde, depending on the mode.</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>filename</td>
		<td>The name, with the ".php" extension, of the file storing the content for the module.</td>
	</tr>
	<tr>
		<td>filepath</td>
		<td>The complete path to where the module file can be found, as well as the "mod.json" settings file.</td>
	</tr>
	<tr>
		<td>content</td>
		<td>The content of the module.</td>
	</tr>
	<tr>
		<td>isVisible()</td>
		<td>Returns true if the module is supposed to be displayed on this page, false if it's not.</td>
	</tr>
	<tr>
		<td>display()</td>
		<td>Display the contents of the module. Basically, "echo content;"</td>
	</tr>
	<tr>
		<td>saveSettings()</td>
		<td>Saves the settings in the current module object to the corresponding JSON file.</td>
	</tr>
	<tr>
		<td>saveContent()</td>
		<td>Saves the content in the current module object to the corresponding .PHP file.</td>
	</tr>
	<tr>
		<td>save()</td>
		<td>Calls saveSettings() and saveContent().</td>
	</tr>
	<tr>
		<td>delete()</td>
		<td>Deletes all files associated with this module; erases it from disk.</td>
	</tr>
</table>
</p>
<p>Here's an example diagram of the relevant file structure this site is using:
<pre style='border:1px solid gray;padding:15px'>
-config
  config.json
-content
  -modules
    -footer
      footer.php
      mod.json
    -nav
      nav.php
      mod.json
  -pages
    404.php
    contact.php
    index.php
    info.php
-templates
  -default
    index.php
</pre>
</p>
<h2 style='text-align:center;'>Database</h2>
<p>The $CMS->database object is used for persistent data-storage, just like MySQL. It's currently nowhere near as advanced or powerful as
MySQL, but in this framework it's much easier to use and uses a similar thought process.</p>
<hr>
This is the code used on the part of the admin/users page that lists existing users:
<blockquote>
<pre>
$users = $CMS->database->get("users")->all();
foreach ($users as $user) {
	echo "&lt;li&gt;username: ".$user->username." | password: ".$user->password."&lt;/li&gt;";
}
</pre>
</blockquote>
Inserting a user in the database, using the form on that page, uses the following code:
<blockquote>
<pre>
$user = new DatabaseEntry();

$user->username = $_POST['name'];
$user->password = $_POST['password'];
$user->exclusive("username");

$CMS->database->insert($user)->into("users");
</pre>
</blockquote>
It's pretty straightforward. The <blockquote><pre>$user->exclusive("username")</pre></blockquote> part automatically keeps the database from inserting an entry that has
the same "username" field as another entry.
<p>If you look at the source for this website, you'll see HTML comments that show the PHP code used to generate each part.</p>
<p>Modules and pages are all in PHP.</p>