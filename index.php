<?php
// config laden
require_once('config.inc.php');

// DB
require_once('inc/db.class.php');
$db = new DB();

$page = $db->get_page_data(1);
var_dump($page);
?>