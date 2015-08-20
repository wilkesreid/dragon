<?
if (_ADMIN_)
	return;

if ($_POST['name'] == "" || $_POST['password'] == "") {
	return;
}

$user = new DatabaseEntry();

$user->username = $_POST['name'];
$user->password = $_POST['password'];
$user->exclusive("username");

$CMS->database->insert($user)->into("users");