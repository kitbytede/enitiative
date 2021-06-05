<?php
class Admin{
	private $page_data;

	public function __construct(){
		global $db;

		if(isset($_SESSION['admin'])){ // admin logged in

			if(!empty($_GET['id']) && strpos($_SERVER["REQUEST_URI"], 'delete')){ // delete page

				$db->delete_page($_GET['id']);

				header('Location: ./');
				exit();
			}
			else if(!empty($_POST['action']) && $_POST['action'] == 'new'){
				$new_page = $db->create_page_data($_POST['title'], $_POST['content']);
				header('Location: ./' . $new_page);
				exit;
			}
			else if(!empty($_POST['action']) && $_POST['action'] == 'update'){
				$new_page = $db->update_page_data($_GET['id'], $_POST['title'], $_POST['content']);
				header('Location: ./' . $_GET['id']);
				exit;
			}

			// top nav buttons

			$this->page_data['btn_logout'] = '
				<a 	class="btn btn-dark px-3"
					href="[HOME]admin/?logout"
					role="button"><i class="bi bi-box-arrow-right"></i> Logout</a>';
			$this->page_data['btn_new_page'] = '
				<a 	class="btn btn-dark px-3"
					href="[HOME]admin/0"
					role="button"><i class="bi bi-file-earmark-plus"></i> Neue Seite</a>';

			// get inner template
			$admin_inner = new Tpl('admin_inner.part');

			$page_list = $this->get_page_list();
			if(!empty($_GET['id']) && $_GET['id'] > 0){ // not overview and not new page
				$page_data = $db->get_page_data($_GET['id']);
			}

			// new page
			if($_GET['id'] == 0){
				$page_content = '';
				$page_content .= '<h1>ID: neu</h1>';
				$page_content .= '
					<form action="[HOME]admin/0" method="post">
						<div class="form-group">
							<input type="text" class="form-control" name="title" id="title" placeholder="Titel">
						</div>
						<div class="form-group">
							<textarea class="form-control" name="content" id="content" rows="20"></textarea>
						</div>
						<div class="form-group row">
							<div class="col">
								<button type="submit" class="btn btn-primary">Speichern</button>
							</div>
							<div class="col"></div>
						</div>
						<input type="hidden" name="action" value="new" />
					</form>
				';
			}

			if(!empty($page_data)){ // got page data
				$page_content = '';
				$page_content .= '<h1>ID: ' . $page_data['id'] . '</h1>';
				$page_content .= '
					<form action="[HOME]admin/' . $page_data['id']. '" method="post">
						<div class="form-group">
							<input type="text" class="form-control" name="title" id="title" placeholder="Titel" value="' . $page_data['title'] . '">
						</div>
						<div class="form-group">
							<textarea class="form-control" name="content" id="content" rows="20">' . $page_data['content'] . '</textarea>
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
			}
			else if($_GET['id'] != 0){ // page not exists
				$page_content = '';
			}
			$data_inner = [
				'page_list' => $page_list,
				'page_content' => $page_content
			];

			$admin_inner->set($data_inner);

			$this->page_data['content'] = (string)$admin_inner;
		}
		else{ // admin not legged in
			$this->page_data['btn_logout'] = '';
			$this->page_data['btn_new_page'] = '';
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