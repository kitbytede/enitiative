<?php
if(!empty($_POST['user']) && !empty($_POST['pass']){ // login
	$user = htmlspecialchars($_POST['user'], ENT_QUOTES, 'UTF-8');
	$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES, 'UTF-8');

	if($user = $config['admin']['user'] && $pass == $config['admin']['pass']){
		$_SESSION['admin'] = true;
	}
	else{
		$error = 'Zugriff verweigert';
	}
}
if(isset($_GET['logout'])){ // logout
	session_destroy();
}
?>