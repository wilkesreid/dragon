<?

if (_ADMIN_) {
	
	if ($_GET['name'] == "") {
		return;
	}
	$CMS->deleteModule($_GET['name']);
	
}