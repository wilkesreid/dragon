<?

if (_ADMIN_) {
	
	if ($_POST['title'] == "") {
		return;
	}
	
	$CMS->config->title = $_POST['title'];
	
	$CMS->saveConfig();
}