<?php
// config laden
require_once('config.inc.php');

// DB
require_once('inc/db.class.php');
$db = new DB();

// $new_page = $db->create_page_data('test', 'bla');
// $edited_page = $db->update_page_data(2, 'edited', 'bla edited');

$page = $db->get_page_data(1);
var_dump($page);
?>