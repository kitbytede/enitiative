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
	global $db;

	$methode = $_SERVER['REQUEST_METHOD'];


	$req = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
	$id = (isset($req[1]) && !empty($req[1]) ? $req[1] : NULL);

	// wird zu testzwecken mit fake-Daten weiter unten überschrieben
	$json_data = file_get_contents('php://input');

	switch ($methode) {
		case 'GET':
			if($id == NULL){ // Seitenübersicht ausgeben
				$page_list = $db->get_page_list();

				http_response_code(200); // OK
				echo json_encode($page_list);

				exit;
			}
			else{ // bestimmte Seite ausgeben
				$page = $db->get_page_data($id);

				http_response_code(200); // OK
				echo json_encode($page);
			}
			break;
		case 'POST': // neue Seite anlegen

			// fake json_data
			$json_data = '{"title":"Screendesign & SEO","content":"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. ","main_page":null}';

			// should be validated! ...
			$new_page_data = json_decode($json_data, true);

			$db->create_page_data(
				$new_page_data['title'],
				$new_page_data['content'],
				$new_page_data['main_page']
			);

			http_response_code(201);  // erstellt

			break;
		case 'PUT': // Seite updaten
			// fake json_data
			$json_data = '{"id":1,"title":"Screendesign & SEO","content":"Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. \r\n\r\nUt wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait nulla facilisi. \r\n\r\nNam liber tempor cum soluta nobis eleifend option congue nihil imperdiet doming id quod mazim placerat facer possim assum. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. \r\n\r\nDuis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis. ","main_page":null}';

			// should be validated! ...
			$new_page_data = json_decode($json_data, true);

			$db->update_page_data(
				$new_page_data['id'],
				$new_page_data['title'],
				$new_page_data['content'],
				$new_page_data['main_page']
			);

			http_response_code(204); // keine Textrückgabe

			break;

		case 'DELETE': // Seite löschen
			$db->delete_page($id);

			http_response_code(204); // keine Textrückgabe

			break;
	}
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