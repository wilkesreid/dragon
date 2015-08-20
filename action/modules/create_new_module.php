<?

if (_ADMIN_) {
	
	if ($_POST['name'] == "") {
		return;
	}
	$CMS->createModule($_POST['name'],$_POST['content']);
	
}