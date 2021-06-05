<?php
class Admin{
	private $page_data;

	public function __construct(){
		if(isset($_SESSION['admin'])){
			$this->page_data['btn_logout'] = '
				<a 	class="btn btn-dark px-3"
					href="[HOME]admin/?logout"
					role="button"><i class="bi bi-box-arrow-right"></i> Logout</a>';
			$admin_inner = new Tpl('admin_inner.part');

			$page_list = $this->get_page_list();

			$data_inner = [
				'page_list' => $page_list
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
			$ret .= '<li' . ($_GET['id'] == $page['id'] ? ' class="active"' : '') . '><a class="btn btn-outline-secondary btn-sm" href="[HOME]admin/' . $page['id'] . '">' .
					$page['id'] .
					' - ' .  $page['title'] . '</a></li>';
		}
		return '<ul>' . $ret . '</ul>';
	}
}
?>