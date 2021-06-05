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
			SELECT id, title, content, main_page
			FROM pages
			WHERE id = ?
			LIMIT 0,1");
		$stmt->execute([$page_id]); 
		$page = $stmt->fetch(PDO::FETCH_ASSOC);
		return $page;
	}

	public function update_page_data($page_id, $title, $content, $main_page = 0){
		$params['id'] = $page_id;

		$setStr = "`title` = :title,";
		$params['title'] = $title;

		$setStr .= "`content` = :content,";
		$params['content'] = $content;

		$setStr .= "`main_page` = :main_page";
		$params['main_page'] = $main_page;

		$stmt = $this->pdo->prepare("
			UPDATE pages
			SET $setStr
			WHERE id = :id");
		$stmt->execute($params);
	}

	public function create_page_data($title, $content, $main_page = 0){
		$params[] = $title;
		$params[] = $content;
		$params[] = $main_page;

		$stmt = $this->pdo->prepare("
			INSERT INTO pages (title, content, main_page)
			VALUES (?,?,?)");
		$stmt->execute($params);
		return $this->pdo->lastInsertId();
	}

	public function get_page_list(){
		$stmt = $this->pdo->prepare("
			SELECT id, title, main_page
			FROM pages
			ORDER BY id");
		$stmt->execute(); 
		$page_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $page_list;
	}

	public function delete_page($id){
		$stmt = $this->pdo->prepare("DELETE FROM pages WHERE id = ?");
		$stmt->execute([$id]);
	}

	public function get_main_page_id(){
		$stmt = $this->pdo->prepare("
			SELECT id
			FROM pages
			WHERE main_page = true
			LIMIT 0,1");
		$stmt->execute(); 
		$page = $stmt->fetch(PDO::FETCH_ASSOC);
		if($page){
			return $page['id'];
		}
		return false;
	}
}
?>