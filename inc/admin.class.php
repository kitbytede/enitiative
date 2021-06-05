<?php
class Admin{
	private $page_data;

	public function __construct(){
		if(isset($_SESSION['admin'])){
			$this->page_data['btn_logout'] = '
				<a 	class="btn btn-dark px-3"
					href="[HOME]admin/?logout"
					role="button"><i class="bi bi-box-arrow-right"></i> Logout</a>';
		}
		else{
			$this->page_data['btn_logout'] = '';
		}
	}

	public function get_page_data(){
		return $this->page_data;
	}
}
?>