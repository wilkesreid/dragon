<?
require_once("include.php");
class Database
{
	public $datapath;
	public function Database() {
		$this->datapath = _ROOT_."/content/data/";
	}
	public function insert($entry) {
		return new DatabaseInsertion($entry);
	}
	public function get($collection) {
		return new DatabaseCollection($collection);
	}
}

class DatabaseInsertion
{
	public $entry;
	public function DatabaseInsertion($entry) {
		$this->entry = $entry;
	}
	public function into($collection) {
		global $CMS;
		// check exclusives
		if (sizeof($this->entry->listExclusive()) > 0) {
			$c = new DatabaseCollection($collection);
			$data = $c->all();
			foreach ($this->entry->listExclusive() as $key) {
				foreach ($data as $entry) {
					if ($entry->{$key} == $this->entry->{$key}) {
						return;
					}
				}
			}
		}
		do {
			$id = rand(100000000,999999999);
		} while (file_exists($CMS->database->datapath.$collection."/".$id.".json"));
		file_put_contents($CMS->database->datapath.$collection."/".$id.".json",json_encode($this->entry));
	}
}
class DatabaseCollection
{
	public $path;
	public $dir;
	public $data;
	public function DatabaseCollection($name) {
		global $CMS;
		$this->name = $name;
		$this->path = $CMS->database->datapath.$name."/";
		$this->dir = array_splice(scandir($this->path),2);
		// data
		$data = array();
		foreach ($this->dir as $file) {
			array_push($data,json_decode(file_get_contents($this->path.$file)));
		}
		$this->data = $data;
	}
	public function all() {
		return $this->data;
	}
	public function where($key) {
		return new DatabaseQuery($this->data,$key);
	}
}
class DatabaseEntry
{
	private $exclusive = array();
	public function exclusive($key) {
		array_push($this->exclusive,$key);
	}
	public function listExclusive() {
		return $this->exclusive;
	}
}
class DatabaseQuery
{
	public $key;
	public $data;
	public function DatabaseQuery($data,$key) {
		$this->key = $key;
		$this->data = $data;
	}
	public function equals($value) {
		$result = array();
		foreach ($this->data as $entry) {
			if ($entry->{$this->key} == $value) {
				array_push($result,$entry);
			}
		}
		return $result;
	}
}