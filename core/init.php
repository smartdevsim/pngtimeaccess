<?php
if(!defined('DARQ')) die();

require ROOT . '/core/autoload.php';

/*
	Show Login Screen
*/

if(!$logged){

	getRestoreScreen();
	getLoginScreen();

}


global $title;
$title = '';
$keywords = $config['keywords'];
$description = $config['description'];
$content = '';
$body_class = '';

$req = isset($_GET['req']) ? trim(strip_tags($_GET['req'])) : '';

initRequest();


/*
	Parse all requests
*/

if($req){
	$req = str_replace(' ', '', $req);

	$req_s = explode('?', $req);

	//substr the first and last slashes
	if(substr($req, 0, 1) == '/'){
		$req = substr($req, 1);
	}
	if(substr($req, -1, 1) == '/'){
		$req = substr($req, 0, -1);
	}

	$req_list = explode('/', $req);

	$req_items_num = count($req_list);

	$prev_last_req_item = isset($req_list[$req_items_num-2]) ? $req_list[$req_items_num-2] : '';
	$last_req_item = $req_list[$req_items_num-1];


	$main_route = $req_list[0];

	if($main_route == 'reports'){

		$sub_route = isset($req_list[1]) ? trim(strip_tags($req_list[1])) : '';
		require ROOT . '/core/inc/reports.php';

	} elseif($main_route == 'add-customer'){


		$add_user_role = 'customer';
		require ROOT . '/core/inc/user.php';


	} elseif($main_route == 'add-user'){


		$add_user_role = 'user';
		require ROOT . '/core/inc/user.php';


	} elseif($main_route == 'add-admin'){


		$add_user_role = 'admin';
		require ROOT . '/core/inc/user.php';


	} elseif($main_route == 'admins'){


		$view_role = 'admins';
		require ROOT . '/core/inc/table_content.php';


	} elseif($main_route == 'customers'){


		$view_role = 'customers';
		require ROOT . '/core/inc/table_content.php';


	} elseif($main_route == 'users'){


		$view_role = 'users';
		require ROOT . '/core/inc/table_content.php';


	} elseif($main_route == 'id'){


		//view user

		$req_error = false;

		if(isset($req_list[1])){

			$id = trim(strip_tags($req_list[1]));

			if(strlen($id) == 40){

				require ROOT . '/core/inc/user.php';

			} else {

				$req_error = true;
				
			}

		} else {

			$req_error = true;

		}

		if($req_error){

			require ROOT . '/core/inc/error.php';

		}



	} else {


		#require ROOT . '/core/inc/main.php';
		#require ROOT . '/core/inc/table_content.php';
		require ROOT . '/core/inc/error.php';


	}


	if(isset($content_result['title']) AND $content_result['title'] AND !$title){
		$title = $content_result['title'] . ' - ' . $config['title'];
	} elseif(isset($content_result['name']) AND $content_result['name'] AND !$title){
		$title = $content_result['name'] . ' - ' . $config['title'];
	}
	


} else {

	#require ROOT . '/core/inc/main.php';
	require ROOT . '/core/inc/table_content.php';

}

if(!$title){
	$title = $config['title'];
}

$body_class .= ' sb-mini';


?>