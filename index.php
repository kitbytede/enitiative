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

if(empty($_GET['id'])){ // default page
	$_GET['id'] = 1;
}

if(isset($_GET['data'])){ // REST request
}
else{ // Browser request
	if(empty($_GET['admin'])){ // prepare template
		$tpl_name = 'default';
	}
	else{
		$tpl_name = 'admin';
		require_once('inc/login.inc.php');
	}
	$tpl = new Tpl($tpl_name);

	$page_data = $db->get_page_data($_GET['id']);

	// merge content into template
	$tpl->set($page_data);

	// output
	echo $tpl;
}
?>