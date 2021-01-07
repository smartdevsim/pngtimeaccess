<?php
if(!defined('DARQ')) die();

if($view_role == '' AND is_user()){

	#$content_result = getUserCoursesResult();

	#$content = getUserCourseListContent();
	$content = noAccess();

} else {

	if(($view_role == 'users' OR $view_role == 'customers') AND is_user()){
		$content = noAccess();
	} else {

		$content_result = getCustomers();

		$content = getUserListContent();
	}

}

?>