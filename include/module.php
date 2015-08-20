<?
require_once("include.php");
class Module
{
	public $name;
	public $settings;
	public $filepath;
	public $filename;
	public $content;
	public function Module($name) {
		$this->name = $name;
		$this->filepath = _ROOT_."/content/modules/".$this->name."/";
		$this->filename = $this->name.".php";
		
		// if module doesn't exist, set settings to false
		if (file_exists($this->filepath."mod.json") && file_exists($this->filepath.$this->filename)) {
			try {
				$this->settings = json_decode(file_get_contents($this->filepath."mod.json"));
					ob_start();
					$CMS = $this;
					require_once($this->filepath.$this->filename);
				$this->content = ob_get_contents();
					ob_end_clean();
			} catch (Exception $e) {
				$this->settings = false;
				$this->content = "";
			}
		} else {
			$this->settings = false;
			$this->content = "";
		}
	}
	
	// Check if visible on current page
	public function isVisible() {
		global $CMS;
		
		// if module doesn't exist, exit
		if ($this->settings == false) {
			return false;
		}
		
		$pages = $this->settings->pages;
		$folders = $this->settings->folders;
		if ($this->settings->mode == "whitelist"):
			
			$result = false;
			
			foreach ($pages as $page) {
				if ($page->name == $CMS->route) {
					$result = true;
				}
			}
			foreach ($folders as $dir) {
				if (startsWith($CMS->route,trim($dir->name))) {
					$result = true;
				}
			}
			
		
			return $result;
		else:
			$result = true;
			
			foreach ($pages as $page) {
				if ($page->name == $CMS->route) {
					$result = false;
				}
			}
			foreach ($folders as $dir) {
				if (startsWith($CMS->route,trim($dir->name))) {
					$result = false;
				}
			}
			
			return $result;
		endif;
	}
	
	// Display contents
	public function display() {
		echo $this->content;
	}
	
	// Save settings
	public function saveSettings() {
		file_put_contents($this->filepath."mod.json",json_encode($this->settings));
	}
	
	// Save content
	public function saveContent() {
		file_put_contents($this->filepath.$this->filename,$this->content);
	}
	
	// Save entire module
	public function save() {
		$this->saveSettings();
		$this->saveContent();
	}
	
	// Delete module
	public function delete() {
		unlink($this->filepath.$this->filename);
		unlink($this->filepath."mod.json");
		rmdir($this->filepath);
	}
}