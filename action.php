<?

require_once("include/include.php");

// if the action is unknown, go back
if (!isset($_GET['action'])) {
	header('Location: '._REFERER_);
	exit();
}

require_once(_ROOT_."/action/".$_GET['action'].".php");

header('Location: '._REFERER_);
exit();