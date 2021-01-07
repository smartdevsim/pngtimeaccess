<?php
if(!defined('DARQ')) die();

$content_result = getUser();

$new = $content_result == null ? true : false;

$add_user_role_name = isset($add_user_role) ? ucfirst($add_user_role) : '';

$heading = $new ? 'Add '.$add_user_role_name : ucfirst($content_result['user_type']).' information';

$user_content = printUser($new);

if($user_content == 'noaccess'){
	$content = noAccess();
} else {

$credit_history_html = '';


$content = '
<div class="content-wrapper">

<div id="user-profile" class="content-inner-fragment">

<div id="content-msg"></div>

<div class="content-top-nav">
	<h1>'.$heading.'</h1>
</div>

'.$user_content.'

</div>

';

if(!$new AND isset($content_result['user_type']) AND $content_result['user_type'] == 'user'){
	$content .= getAttendance($content_result['id'], $content_result['alt_name']);
}

$content .= '


</div>
';

}

?>