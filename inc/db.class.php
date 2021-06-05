<?php
class DB{
	private $pdo;
	function __construct(){
		global $config;

		$dbstring  = 'mysql:host=' . $config['db']['host'];
		$dbstring .= ';dbname=' . $config['db']['dbname'];
		$dbstring .= ';charset=UTF8';

		$this->pdo = new PDO($dbstring, $config['db']['user'], $config['db']['pass']);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	}

	public function get_page_data($page_id){
		$stmt = $this->pdo->prepare("
			SELECT id, title, content
			FROM pages
			WHERE id = ?
			LIMIT 0,1");
		$stmt->execute([$page_id]); 
		$page = $stmt->fetch();
		return $page;
	}
}
?>