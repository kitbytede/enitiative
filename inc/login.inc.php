<?php
if(strpos($_SERVER["REQUEST_URI"], 'logout')){ // logout
	session_destroy();

	global $config;

	header('Location: ' . $config['home'] . 'admin/');
	exit();
}

if(!empty($_POST['user']) && !empty($_POST['pass'])){ // login
	$user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
	$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

	if($user = $config['admin']['user'] && $pass == $config['admin']['pass']){
		$_SESSION['admin'] = true;
	}
	else{
		$error = 'Zugriff verweigert';
	}
}
?>