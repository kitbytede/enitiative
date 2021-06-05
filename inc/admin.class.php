<?php
class Admin{
	private $page_data;

	public function __construct(){
		global $db;

		if(isset($_SESSION['admin'])){
			$this->page_data['btn_logout'] = '
				<a 	class="btn btn-dark px-3"
					href="[HOME]admin/?logout"
					role="button"><i class="bi bi-box-arrow-right"></i> Logout</a>';
			$admin_inner = new Tpl('admin_inner.part');

			$page_list = $this->get_page_list();
			if(!empty($_GET['id'])){
				$page_data = $db->get_page_data($_GET['id']);
			}

			$page_content = '';
			$page_content .= '<h1>ID: ' . $page_data['id'] . '</h1>';
			$page_content .= '
				<form action="[HOME]admin/' . $page_data['id']. '" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="title" id="title" placeholder="Titel" value="' . $page_data['title'] . '">
					</div>
					<div class="form-group">
						<textarea class="form-control" id="content" rows="20">' . $page_data['content'] . '</textarea>
					</div>
					<div class="form-group row">
						<div class="col">
							<button type="submit" class="btn btn-primary">Speichern</button>
						</div>
						<div class="col">
							<a href="[HOME]admin/' . $page_data['id']. '?delete" class="btn btn-danger">Löschen</a>
						</div>
					</div>
					<input type="hidden" name="action" value="update" />
				</form>
			';

			$data_inner = [
				'page_list' => $page_list,
				'page_content' => $page_content
			];

			$admin_inner->set($data_inner);

			$this->page_data['content'] = (string)$admin_inner;
		}
		else{
			$this->page_data['btn_logout'] = '';
			$loginform = new Tpl('loginform.part');
			$this->page_data['content'] = (string)$loginform;
		}
	}

	public function get_page_data(){
		return $this->page_data;
	}

	private function get_page_list(){
		global $db;
		$page_list = $db->get_page_list();

		$ret = '';
		foreach($page_list as $page){
			$ret .= '<li' . ($_GET['id'] == $page['id'] ? ' class="active"' : '') . '>
						<a class="btn btn-outline-secondary btn-sm" href="[HOME]admin/' . $page['id'] . '">' .
					$page['id'] .
					' - ' .  $page['title'] . '</a>
					</li>';
		}
		return '<ul>' . $ret . '</ul>';
	}
}
?>