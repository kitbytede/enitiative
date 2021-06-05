<?php
$config = [];

/* ===== DB ===== */
if($_SERVER['HTTP_HOST'] == 'enitiative.local'){ // local
	$config['db']['host'] = 'localhost';
	$config['db']['port'] = 3306;
	$config['db']['user'] = 'root';
	$config['db']['pass'] = '';
	$config['db']['dbname'] = 'enitiative';

	$config['home'] = 'https://enitiative.local/';
}
else{ // DEV
	$config['db']['host'] = 'intern.enitiative.de';
	$config['db']['port'] = 3306;
	$config['db']['user'] = 'd036a43a';
	$config['db']['pass'] = 'w3yPyR2LwRDt29an';
	$config['db']['dbname'] = 'd036a43a';

	$config['home'] = 'https://intern.enitiative.de/wladimirkitkin/';
}

/* ===== admin-access ===== */
$config['admin']['user'] = 'admin';
$config['admin']['pass'] = '#3n1t14t1v3';
?>