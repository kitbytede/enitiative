<?php
session_start();

// config laden
require_once('config.inc.php');

// DB
require_once('inc/db.class.php');
$db = new DB();

// Template
require_once('inc/tpl.class.php');

// $new_page = $db->create_page_data('test', 'bla');
// $edited_page = $db->update_page_data(2, 'edited', 'bla edited');

if(!isset($_GET['id'])){ // default page
	$_GET['id'] = $db->get_main_page_id();
}

if(isset($_GET['data'])){ // REST request
}
else{ // Browser request
	if(!isset($_GET['admin'])){ // prepare template
		$tpl_name = 'default';
	}
	else{
		$tpl_name = 'admin';
		require_once('inc/login.inc.php');
		require_once('inc/admin.class.php');
		$admin = new Admin();
		$page_data = $admin->get_page_data();
	}

	$tpl = new Tpl($tpl_name);

	if(empty($page_data)){ // not already set by admin area, get from DB
		$page_data = $db->get_page_data($_GET['id']);
	}

	if(empty($page_data)){
		$page_data['title'] = 'damn!';
		$page_data['content'] = '
			<div class="error">
				<img src="https://blog.hubspot.com/hubfs/404-error-page-examples.jpeg" alt="oops..." />
			</div>
			<h1>Seite wurde nicht gefunden. *ba dum tss*</h1>';
		http_response_code(404);
	}

	// build navigation
	$page_list = $db->get_page_list();

	$nav = '<ul>';
	foreach($page_list as $page){
		$nav .= '<li' . ($_GET['id'] == $page['id'] ? ' class="active"' : '') . '>
					<a href="[HOME]page/' . $page['id'] . '">' .
						$page['title'] .
					'</a>
				</li>';
	}
	$nav .= '</ul>';
	$page_data['nav'] = $nav;

	// merge content into template
	if(!isset($_GET['admin'])){
		$page_data['content'] = str_replace("\r\n", '<br />', $page_data['content']);
	}
	$tpl->set($page_data);

	// output
	echo $tpl;
}
?>