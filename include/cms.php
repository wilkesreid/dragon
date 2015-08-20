<?
require_once("include.php");
class CMS
{
	public $route;
	public $routepath;
	public $routefile;
	public $page;
	public $config;
	public $locations;
	public $database;
	
	public function CMS() {
		global $CMS;
		// routing
		$this->route = ($_GET['route'] != "" ? $_GET['route'] : "index");
		$this->routepath = _ROOT_."/content/pages/";
		$this->routefile = $this->route.".php";
		
		// config
		$this->config = json_decode(file_get_contents(_ROOT_."/config/config.json"));
		
		// template locations
		$this->locations = json_decode(file_get_contents(_ROOT_."/templates/".$this->config->template."/locations.json"));
		
		// database
		$this->database = new Database();
		
		// curent page contents
			ob_start();
			$CMS = $this;
			$this->displayCurrentPage();
		$this->page = ob_get_contents();
			ob_end_clean();
	}
	// Routing
	
	// get and display template index
	public function Route() {
		global $CMS;
		require_once(_ROOT_."/templates/".$this->config->template."/index.php");
	}
	
	// Config
	public function saveConfig() {
		file_put_contents(_ROOT_."/config/config.json",json_encode($this->config));
	}
	
	// Pages
	private function displayCurrentPage() {
		global $CMS;
		if (file_exists($this->routepath.$this->routefile)) {
			require_once($this->routepath.$this->routefile);
		} else {
			require_once(_ROOT_."/content/pages/404.php");
		}
		echo "\n";
	}
	
	// Modules
	
	// display mod if set to display on this page
	public function mod($name) {
		$module = new Module($name);
		if ($module->isVisible()) {
			$module->display();
			echo "\n";
		}
	}
	
	// get list of mods as array
	private function modlist() {
		$mods = array();
		$dir = scandir(_ROOT_."/content/modules");
		foreach ($dir as $mod) {
			if ($mod == "." || $mod == ".." || $mod == "mod_template.json") {
				continue;
			}
			array_push($mods,$mod);
		}
		return $mods;
	}
	
	// Template Locations
	
	// display all mods at location
	public function location($name) {
		$locations = $this->locations;
		foreach ($locations as $location) {
			if ($location->name == $name) {
				$mods = $location->mods;
				foreach ($mods as $mod) {
					$this->mod($mod->name);
				}
			}
		}
	}
	
	public function createModule($name,$content) {
		$module = new Module($name);
		if (!is_dir($module->filepath)) {
			mkdir($module->filepath);
		}
		$settings = json_decode(file_get_contents(_ROOT_."/content/modules/mod_template.json"));
		$module->settings = $settings;
		$module->content = "";
		$module->save();
	}
	
	public function deleteModule($name) {
		$module = new Module($name);
		$module->delete();
	}
}

$CMS = new CMS();