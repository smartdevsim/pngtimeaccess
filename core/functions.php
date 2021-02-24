<?php
if(!defined('DARQ')) die();

use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function getConfig(){return require(ROOT . '/core/configs/config.php');}

function sb_mail($to, $subject, $message){
	global $config;

	$headers = "From: ".$config['email_name']." <noreply@".$config['domain'].">\r\n";
	$headers .= "Reply-To: noreply@".$config['domain']."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=UTF-8\r\n";

	mail($to, $subject, $message, $headers);
}




function is_admin(){
	global $ug;
	return (isset($_SESSION['group_id']) ? ((isset($ug[$_SESSION['group_id']]['role']) AND $ug[$_SESSION['group_id']]['role'] == 'admin') ? true : false) : false);
}
function is_customer($group_id = 0){
	if(!isset($_SESSION['group_id'])) return false;
	global $ug;if(!$group_id) $group_id = $_SESSION['group_id'];return ((isset($ug[$group_id]['role']) AND $ug[$group_id]['role'] == 'customer') ? true : false);
}
function is_user($group_id = 0){
	if(!isset($_SESSION['group_id'])) return false;
	global $ug;if(!$group_id) $group_id = $_SESSION['group_id'];return ((isset($ug[$group_id]['role']) AND $ug[$group_id]['role'] == 'user') ? true : false);
}

function validateEmail($email){
	if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    	return true;
	} else {
		return false;
	}
}

function getPageSizes(){
	return array(5, 10, 20, 50, 100);
}

function addJs($name){
	global $js_files;
	$js_files[] = $name;
}

function initRequest(){
	global $size, $page, $sort, $search_text, $sizes, $ug, $search_text, $search_fields, $view_role, $main_route, $section, $js_files;
	$sizes = getPageSizes();
	$ug = getUserGroups();

	$js_files = array();
	$section = isset($_GET['section'])?trim(strip_tags($_GET['section'])) : '';

	$main_route = '';

	$view_role = isset($_GET['view_role'])?trim(strip_tags($_GET['view_role'])) : '';
	if($view_role){
		$view_role_active = false;
		foreach ($ug as $key => $value) {
			if($view_role == $value['alt_name']){
				$view_role_active = true;
			}
		}
		if(!$view_role_active) $view_role = '';
	}


	$size = isset($_SESSION['size']) ? $_SESSION['size'] : $sizes[1];
	$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
	if(!$page) $page = 1;

	$sort = isset($_GET['sort']) ? trim(strip_tags($_GET['sort'])) : '';

	$search_text = isset($_GET['search_text']) ? trim(strip_tags(rawurldecode($_GET['search_text']))) : '';
	$search_text = preg_replace('#\s+#', ' ', $search_text);
	$search_text = str_replace(array('<','>','"',"'"), '', $search_text);

	$search_fields = array();
	$req_search_fields = isset($_GET['search_fields']) ? $_GET['search_fields'] : array();
	if(is_string($req_search_fields) AND $req_search_fields!=''){
		$req_search_fields = json_decode($req_search_fields, true);
	}
	if(is_array($req_search_fields) AND count($req_search_fields)>0){
		foreach ($req_search_fields as $key => $value){
			if(in_array($key, array('first_name', 'last_name', 'company_name', 'email', 'status', 'last_modified', 'account_status', 'employee_number', 'position_reference', 'position_title'))){
				$st_value = trim(strip_tags(rawurldecode($value)));
				$st_value = preg_replace('#\s+#', ' ', $st_value);
				$st_value = str_replace(array('<','>','"',"'"), '', $st_value);
				if($st_value){
					$search_fields[$key] = $st_value;
				}
			} elseif(in_array($key, array('author_id'))){
				$st_value = intval($value);
				if($st_value){
					$search_fields[$key] = $st_value;
				}
			}
		}
	}

}

function getUserGroups(){
	$path = ROOT . '/core/cache/user_groups.php';

	$cnt = @file_get_contents($path);

	if($cnt){
		return json_decode($cnt, true);
	}

	global $db;

	$arr = [];

	$db->query("SELECT * FROM user_groups");
	while($row = $db->get_row()){
		$arr[$row['id']] = $row;
	}
	$db->free();

	file_put_contents($path, json_encode($arr));

	return $arr;
}

function printTableContentJS(){
	global $content_result, $page, $search_text, $search_fields;

	$js = 'var content_section = "'.$content_result['section'].'",';
	if($content_result['section'] == 'users'){

		$js .= '
		content_view_role = "'.$content_result['view_role'].'",
		content_page = '.$page.',
		content_sort = "'.$content_result['sort'].'",
		content_search_text = "'.$search_text.'",
		content_search_fields = '.(count($search_fields)>0?json_encode($search_fields):'{}').';';

	}

	return '<script type="text/javascript">'.$js.'</script>';
}
function getETV(){
	return array(
		'status' => array(
			'passed' => 'Passed', 
			'failed' => 'Failed', 
			'not-attempted' => 'Not Attempted'
		),
		'account_status' => array(
			'active' => 'Active', 
			'suspended' => 'Suspended', 
		),
	);
}
//qqq
function printTableContent($html_wrap = false){
	global $content_result, $ug;

	$etv = getETV();

	$order_type = explode('-', $content_result['sort']);
	$order_k = isset($order_type[1]) ? $order_type[0] : '';
	$order_v = isset($order_type[1]) ? $order_type[1] : '';

	$tpl = '<table class="default-table"><thead>';

	$visible_columns = (isset($content_result['visible_columns']) AND is_array($content_result['visible_columns'])) ? $content_result['visible_columns'] : array();

	/*
	USERS LIST
	*/
	if($content_result['section'] == 'users'){
		$fn_v = (isset($content_result['search_fields']['first_name']) AND $content_result['search_fields']['first_name']) ? 'value="'.htmlspecialchars($content_result['search_fields']['first_name'], ENT_QUOTES).'"' : '';
		$ln_v = (isset($content_result['search_fields']['last_name']) AND $content_result['search_fields']['last_name']) ? 'value="'.htmlspecialchars($content_result['search_fields']['last_name'], ENT_QUOTES).'"' : '';
		$cp_v = (isset($content_result['search_fields']['company_name']) AND $content_result['search_fields']['company_name']) ? 'value="'.htmlspecialchars($content_result['search_fields']['company_name'], ENT_QUOTES).'"' : '';		
		$employee_number_v = (isset($content_result['search_fields']['employee_number']) AND $content_result['search_fields']['employee_number']) ? 'value="'.htmlspecialchars($content_result['search_fields']['employee_number'], ENT_QUOTES).'"' : '';

		$position_number_v = (isset($content_result['search_fields']['position_number']) AND $content_result['search_fields']['position_number']) ? 'value="'.htmlspecialchars($content_result['search_fields']['position_number'], ENT_QUOTES).'"' : '';
		$position_reference_v = (isset($content_result['search_fields']['position_reference']) AND $content_result['search_fields']['position_reference']) ? 'value="'.htmlspecialchars($content_result['search_fields']['position_reference'], ENT_QUOTES).'"' : '';
		$position_title_v = (isset($content_result['search_fields']['position_title']) AND $content_result['search_fields']['position_title']) ? 'value="'.htmlspecialchars($content_result['search_fields']['position_title'], ENT_QUOTES).'"' : '';
		$em_v = (isset($content_result['search_fields']['email']) AND $content_result['search_fields']['email']) ? 'value="'.htmlspecialchars($content_result['search_fields']['email'], ENT_QUOTES).'"' : '';
		$ss_v = (isset($content_result['search_fields']['status']) AND $content_result['search_fields']['status'] AND isset($etv['status'][$content_result['search_fields']['status']])) ? 'value="'.htmlspecialchars($etv['status'][$content_result['search_fields']['status']], ENT_QUOTES).'"' : '';

		$lm_v = (isset($content_result['search_fields']['last_modified']) AND $content_result['search_fields']['last_modified']) ? $content_result['search_fields']['last_modified'] : '';
		if($lm_v) {
			$lm_v = str_replace('/', '.', $lm_v);
			$lm_v = 'value="'.date('d/m/Y', strtotime($lm_v)).'"';
		}

		$sas_v = (isset($content_result['search_fields']['account_status']) AND $content_result['search_fields']['account_status'] AND isset($etv['account_status'][$content_result['search_fields']['account_status']])) ? 'value="'.htmlspecialchars($etv['account_status'][$content_result['search_fields']['account_status']], ENT_QUOTES).'"' : '';

		$vr = (isset($content_result['view_role']) AND $content_result['view_role']) ? $content_result['view_role'] : '';

/*		$tpl .= '<th>First Name<div class="th-search" data-id="first_name"><input type="text" placeholder="Search" '.$fn_v.'/></div></th>
		<th>Last Name<div class="th-search" data-id="last_name"><input type="text" placeholder="Search" '.$ln_v.'/></div></th>';*/
		

		$tpl .= (in_array('company_name', $visible_columns) ? '<th>Company<div class="th-search" data-id="company_name"><input type="text" placeholder="Search" '.$cp_v.'/></div></th>' : '');

		$tpl .= (in_array('employee_number', $visible_columns) ? '<th>Employee number<div class="th-search" data-id="employee_number"><input type="text" placeholder="Search" '.$employee_number_v.'/></div></th>' : '');
		$tpl .= '<th>Surname<div class="th-search" data-id="last_name"><input type="text" placeholder="Search" '.$ln_v.'/></div></th>
		<th>Given Name<div class="th-search" data-id="first_name"><input type="text" placeholder="Search" '.$fn_v.'/></div></th>';
		$tpl .= (in_array('position_number', $visible_columns) ? '<th>Position number<div class="th-search" data-id="position_number"><input type="text" placeholder="Search" '.$position_number_v.'/></div></th>' : '');
		$tpl .= (in_array('position_reference', $visible_columns) ? '<th>Position reference<div class="th-search" data-id="position_reference"><input type="text" placeholder="Search" '.$position_reference_v.'/></div></th>' : '');
		$tpl .= (in_array('position_title', $visible_columns) ? '<th>Position title<div class="th-search" data-id="position_title"><input type="text" placeholder="Search" '.$position_title_v.'/></div></th>' : '');


		$tpl .= '<th class="email-column sortable sortable-search'.($order_k=='email'?' sorted-'.$order_v:'').'" data-id="email" data-order="'.($order_k=='email'?$order_v:'').'">E-mail<div class="th-search" data-id="email"><input type="text" placeholder="Search" '.$em_v.'/></div></th>';
		

		$tpl .= '<th class="accountstatus-column">Account Status<div class="th-search th-select" data-id="account_status"><input type="text" placeholder="Search" '.$sas_v.' readonly/><ul class="th-select-ul">';

			foreach($etv['account_status'] as $key=>$value){
				$tpl .= '<li data-id="'.$key.'">'.$value.'</li>';
			}

			$tpl .= '</ul></div></th>';
		

		$tpl .= '<th class="sortable'.($order_k=='postdate'?' sorted-'.$order_v:'').'" data-id="postdate" data-order="'.($order_k=='postdate'?$order_v:'').'">Created Date</th>';


		

		$tpl .= '<th>Action</th>';


	} elseif($content_result['section'] == 'user-attendance'){
		$tpl .= '<th>Work day</th>';
		$tpl .= '<th>Clock In</th>';
		$tpl .= '<th>Clock Out</th>';
		$tpl .= '<th>Work hours</th>';
	}
	


	$tpl .= '
	</thead><tbody id="table-body">'.$content_result['result'].'</tbody></table>'.($content_result['result']?'':$content_result['no_result']);

	$tpl = ($html_wrap ? '<div id="table-content">':'').$tpl.($html_wrap ? '</div>':'');

	return $tpl;
}

function getSearchResultsQuery(){
	global $db, $search_text, $search_fields;

	$title_sql = $search_text ? " AND (users.first_name LIKE '%".$db->safesql($search_text)."%' OR users.last_name LIKE '%".$db->safesql($search_text)."%' OR users.email LIKE '%".$db->safesql($search_text)."%')" : '';

	$ef_case = '';
	$ef_cc = '';
	$ef_where = '';
	$sf_sql = '';
	if(count($search_fields)>0){
		foreach ($search_fields as $key => $value) {
			if(in_array($key, array('first_name', 'last_name', 'email', 'employee_number', 'position_reference', 'position_title'))){
				$sf_sql .= ' AND users.'.$db->safesql($key).' LIKE "%'.$db->safesql($value).'%"';
			} elseif(in_array($key, array('author_id'))){
				$sf_sql .= ' AND users.'.$db->safesql($key).' = '.intval($value);
			} else {
				if($key == 'company_name'){
					$sf_sql .= ' AND users.company_name LIKE "%'.$db->safesql($value).'%"';
				}
				if($key == 'last_modified'){
					$value = str_replace('/', '.', $value);
					$value = strtotime($value);
					$sf_sql .= ' AND users.editdate BETWEEN UNIX_TIMESTAMP(\''.date('Y-m-d', $value).'\') AND UNIX_TIMESTAMP(\''.date('Y-m-d', $value).' 23:59:59\')';
				}
				if($key == 'account_status'){
					$sf_sql .= ' AND users.is_blocked = '.($value == 'suspended' ? 1 : 0);
				}
			}
		}
	}

	return array(
		'title_sql' => $title_sql,
		'ef_case' => $ef_case,
		'ef_cc' => $ef_cc,
		'ef_where' => $ef_where,
		'sf_sql' => $sf_sql
	);

}

function getTableResultJS(){
	global $content_result, $page, $content_link;

	$res = $content_result;
	$res['page'] = $page;
	$res['link'] = isset($content_result['link']) ? $content_result['link'].$content_link : '/';
	if(isset($content_result['search_fields'])){
		$res['search_fields'] = (count($content_result['search_fields'])>0?$content_result['search_fields']:new stdClass());
	}
	$res['after_params'] = printTableAfterParams();

	return $res;
}

function printTablePreParams(){
	global $content_result, $sort, $search_text, $size, $sizes;

	$is_filters = ((isset($content_result['search_fields']) AND count($content_result['search_fields'])>0) OR (isset($content_result['search_text']) AND $content_result['search_text']) OR $content_result['sort']) ? true : false;
	
	$tpl = '';

	if(isset($content_result['search_fields']['author_id']) AND $content_result['search_fields']['author_id']){
		global $db;
		$author_row = $db->super_query("SELECT * FROM users WHERE id = ".$content_result['search_fields']['author_id']);
		if(isset($author_row['id']) AND $author_row['id']){
			$tpl .= '<div style="margin-bottom: 30px;font-size: 18px;">Showing users of '.($author_row['company_name'] ? '&laquo;'.htmlspecialchars($author_row['company_name'], ENT_QUOTES).'&raquo;' : $author_row['first_name'].' '.$author_row['last_name']).'</div>';
		}
	}

	$tpl .= '<div class="table-pre-params">
	<div class="table-size">Show <select id="table-size">';

	foreach($sizes as $key => $value){
		$tpl .= '<option value="'.$value.'"'.($size == $value ? ' selected="selected"':'').'>'.$value.'</option>';
	}

	$tpl .= '</select> entries
	</div>';
		$tpl .= '<div class="table-search">';
		$tpl .= '<a id="clear-params"'.($is_filters?'':' style="display: none;"').'>Clear all</a>';
	
	$tpl .= '<span>Search:</span> <input type="text" id="table-search" value="'.htmlspecialchars($search_text, ENT_QUOTES).'" />';
	
	$tpl .= '</div>';
	$tpl .= (( (isset($content_result['view_role']) AND ($content_result['view_role']=='users' OR $content_result['view_role'] == '') AND is_customer()) OR (isset($content_result['view_role']) AND $content_result['view_role']=='users' AND is_admin()) OR ($content_result['section']=='certificates' AND is_user()) ) ? '<div class="table-right-side">
		</div>' : '').'
	</div>';

	return $tpl;
}
function printTableAfterParams($html_wrap = false){
	global $content_result, $page, $size;

	if(!isset($content_result['count'])) $content_result['count'] = 0;

	$end_num = $page * $size;
	if($end_num>$content_result['count']) $end_num = $content_result['count'];
	$start_num = $end_num - $size;
	if($start_num<0) $start_num = 0;
	if($start_num<=0 AND $content_result['count']>0) $start_num = 1;

	return ($html_wrap?'<div id="table-after-params">':'').'
	<div class="table-entries">Showing '.$start_num.' to '.$end_num.' of '.$content_result['count'].' entries</div>
	<div class="table-pagination">
	'.pagination().'
	</div>'.($html_wrap?'</div>':'');
}




function getUser(){
	global $config, $db, $id, $ug;
	if(!$id) return null;

	$row = $db->super_query("SELECT * FROM users WHERE alt_name = '".$db->safesql($id)."'");
	if($row['id']){
		$row['title'] = htmlspecialchars($row['first_name'].' '.$row['last_name'], ENT_QUOTES);
		$row['user_type'] = $ug[$row['group_id']]['role'];
		return $row;
	} else {
		return null;
	}
}


function validatePageUrl($page_url){
	if($_SERVER['REQUEST_URI'] != $page_url){
		header('Location: '.$page_url);
		exit;
	}
}





function scsv($s){
	$s = convert_cp1252_to_utf8($s);
	$s = str_replace(array('“', '”'), '"', $s);
	return $s;
}
function convert_cp1252_to_utf8($input, $default = '', $replace = array()) {
    if ($input === null || $input == '') {
        return $default;
    }

    // https://en.wikipedia.org/wiki/UTF-8
    // https://en.wikipedia.org/wiki/ISO/IEC_8859-1
    // https://en.wikipedia.org/wiki/Windows-1252
    // http://www.unicode.org/Public/MAPPINGS/VENDORS/MICSFT/WINDOWS/CP1252.TXT
    $encoding = mb_detect_encoding($input, array('Windows-1252', 'ISO-8859-1'), true);
    if ($encoding == 'ISO-8859-1' || $encoding == 'Windows-1252') {
        /*
         * Use the search/replace arrays if a character needs to be replaced with
         * something other than its Unicode equivalent.
         */ 

        /*$replace = array(
            128 => "&#x20AC;",      // http://www.fileformat.info/info/unicode/char/20AC/index.htm EURO SIGN
            129 => "",              // UNDEFINED
            130 => "&#x201A;",      // http://www.fileformat.info/info/unicode/char/201A/index.htm SINGLE LOW-9 QUOTATION MARK
            131 => "&#x0192;",      // http://www.fileformat.info/info/unicode/char/0192/index.htm LATIN SMALL LETTER F WITH HOOK
            132 => "&#x201E;",      // http://www.fileformat.info/info/unicode/char/201e/index.htm DOUBLE LOW-9 QUOTATION MARK
            133 => "&#x2026;",      // http://www.fileformat.info/info/unicode/char/2026/index.htm HORIZONTAL ELLIPSIS
            134 => "&#x2020;",      // http://www.fileformat.info/info/unicode/char/2020/index.htm DAGGER
            135 => "&#x2021;",      // http://www.fileformat.info/info/unicode/char/2021/index.htm DOUBLE DAGGER
            136 => "&#x02C6;",      // http://www.fileformat.info/info/unicode/char/02c6/index.htm MODIFIER LETTER CIRCUMFLEX ACCENT
            137 => "&#x2030;",      // http://www.fileformat.info/info/unicode/char/2030/index.htm PER MILLE SIGN
            138 => "&#x0160;",      // http://www.fileformat.info/info/unicode/char/0160/index.htm LATIN CAPITAL LETTER S WITH CARON
            139 => "&#x2039;",      // http://www.fileformat.info/info/unicode/char/2039/index.htm SINGLE LEFT-POINTING ANGLE QUOTATION MARK
            140 => "&#x0152;",      // http://www.fileformat.info/info/unicode/char/0152/index.htm LATIN CAPITAL LIGATURE OE
            141 => "",              // UNDEFINED
            142 => "&#x017D;",      // http://www.fileformat.info/info/unicode/char/017d/index.htm LATIN CAPITAL LETTER Z WITH CARON 
            143 => "",              // UNDEFINED
            144 => "",              // UNDEFINED
            145 => "&#x2018;",      // http://www.fileformat.info/info/unicode/char/2018/index.htm LEFT SINGLE QUOTATION MARK 
            146 => "&#x2019;",      // http://www.fileformat.info/info/unicode/char/2019/index.htm RIGHT SINGLE QUOTATION MARK
            147 => "&#x201C;",      // http://www.fileformat.info/info/unicode/char/201c/index.htm LEFT DOUBLE QUOTATION MARK
            148 => "&#x201D;",      // http://www.fileformat.info/info/unicode/char/201d/index.htm RIGHT DOUBLE QUOTATION MARK
            149 => "&#x2022;",      // http://www.fileformat.info/info/unicode/char/2022/index.htm BULLET
            150 => "&#x2013;",      // http://www.fileformat.info/info/unicode/char/2013/index.htm EN DASH
            151 => "&#x2014;",      // http://www.fileformat.info/info/unicode/char/2014/index.htm EM DASH
            152 => "&#x02DC;",      // http://www.fileformat.info/info/unicode/char/02DC/index.htm SMALL TILDE
            153 => "&#x2122;",      // http://www.fileformat.info/info/unicode/char/2122/index.htm TRADE MARK SIGN
            154 => "&#x0161;",      // http://www.fileformat.info/info/unicode/char/0161/index.htm LATIN SMALL LETTER S WITH CARON
            155 => "&#x203A;",      // http://www.fileformat.info/info/unicode/char/203A/index.htm SINGLE RIGHT-POINTING ANGLE QUOTATION MARK
            156 => "&#x0153;",      // http://www.fileformat.info/info/unicode/char/0153/index.htm LATIN SMALL LIGATURE OE
            157 => "",              // UNDEFINED
            158 => "&#x017e;",      // http://www.fileformat.info/info/unicode/char/017E/index.htm LATIN SMALL LETTER Z WITH CARON
            159 => "&#x0178;",      // http://www.fileformat.info/info/unicode/char/0178/index.htm LATIN CAPITAL LETTER Y WITH DIAERESIS
        );*/

        if (count($replace) != 0) {
            $find = array();
            foreach (array_keys($replace) as $key) {
                $find[] = chr($key);
            }
            $input = str_replace($find, array_values($replace), $input);
        }
        /*
         * Because ISO-8859-1 and CP1252 are identical except for 0x80 through 0x9F
         * and control characters, always convert from Windows-1252 to UTF-8.
         */
        $input = iconv('Windows-1252', 'UTF-8//IGNORE', $input);
        if (count($replace) != 0) {
            $input = html_entity_decode($input);
        }
    }
    return $input;
}
function csvstring_to_array($string, $separatorChar = ',', $enclosureChar = '"', $newlineChar = "\n") {
    // $string[$i]; {} Array and string offset access syntax with curly braces is deprecated
    $array = array();
    $size = strlen($string);
    $columnIndex = 0;
    $rowIndex = 0;
    $fieldValue="";
    $isEnclosured = false;
    for($i=0; $i<$size;$i++) {

        $char = $string[$i];
        $addChar = "";

        if($isEnclosured) {
            if($char==$enclosureChar) {

                if($i+1<$size && $string[$i+1]==$enclosureChar){
                    // escaped char
                    $addChar=$char;
                    $i++; // dont check next char
                }else{
                    $isEnclosured = false;
                }
            }else {
                $addChar=$char;
            }
        }else {
            if($char==$enclosureChar) {
                $isEnclosured = true;
            }else {

                if($char==$separatorChar) {

                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";

                    $columnIndex++;
                }elseif($char==$newlineChar) {
                    #echo $char;
                    $array[$rowIndex][$columnIndex] = $fieldValue;
                    $fieldValue="";
                    $columnIndex=0;
                    $rowIndex++;
                }else {
                    $addChar=$char;
                }
            }
        }
        if($addChar!=""){
            $fieldValue.=$addChar;

        }
    }

    if($fieldValue) { // save last field
        $array[$rowIndex][$columnIndex] = $fieldValue;
    }
    return $array;
}

function createQR($id, $qr_salt){
	include_once(ROOT . '/core/classes/phpqrcode/qrlib.php');
	$qr = $id.'@@'.$qr_salt;
	$dirname = date('Ymd');
	$path = ROOT . '/st/qrcodes/'.$dirname;
	if(!is_dir($path)){
	    mkdir($path, 0777, true);
	}
	$filename = hash('sha256', $qr.uniqid());
	QRcode::png($qr, $path.'/'.$filename.'.png', QR_ECLEVEL_L, 200);
	return array('dirname' => $dirname, 'filename' => $filename);
}
function getWorkedTime_old($time){
	if($time < 60){
		return $time.' sec.';
	} elseif($time >= 60 AND $time < 3600){
		$_t = $time/60;
		if($_t != intval($_t)){
			$_t = number_format($_t, 2, '.', '');
		}
		return $_t.' min.';
	} elseif($time >= 3600 AND $time < 86400){
		$_t = $time/3600;
		if($_t != intval($_t)){
			$_t = number_format($_t, 2, '.', '');
		}
		return $_t.' hours';
	} elseif($time >= 86400){
		$_t = $time/86400;
		if($_t != intval($_t)){
			$_t = number_format($_t, 2, '.', '');
		}
		return $_t.' days';
	}
}
function getWorkedTime($time){
	$hours = floor($time / 3600);
	$minutes = floor(($time / 60) % 60);
	$seconds = $time % 60;

	return ($hours<10?'0'.$hours:$hours).':'.($minutes<10?'0'.$minutes:$minutes).':'.($seconds<10?'0'.$seconds:$seconds);
}
function getAttendance($id, $alt_name){
	global $db, $config, $page, $size, $view_role;

	$res_sort = 'new';
	$sorts = array('new' => 'id DESC');

	$size = 100;

	$parsed_search_results = getSearchResultsQuery();
	$where_sql = $parsed_search_results['sf_sql'];

	$visible_columns = array();

	$count = $db->super_query("SELECT count(*) as count FROM user_pass WHERE user_id = ".$id.$where_sql);
	$count = $count['count'];

	$pages_num = intval(($count - 1) / $size) + 1;
	if(!$pages_num) $pages_num = 1;

	if($page > $pages_num) $page = $pages_num; 
	$start_row = $page * $size - $size; 

	$rows = '';

	if($count>0){
		$arr = array();
		$db->query("SELECT * FROM user_pass WHERE user_id = ".$id.$where_sql." ORDER BY id DESC");
		while ($row = $db->get_row()) {
			$day = explode(' ', $row['postdate_datetime']);
			$arr[$day[0]][$row['type_pass']] = $row;
		}

		foreach ($arr as $key => $value) {
			$dif = (isset($arr[$key]['checkin']) AND isset($arr[$key]['checkout'])) ? $arr[$key]['checkout']['postdate'] - $arr[$key]['checkin']['postdate'] : '';
			$rows .= '<tr>
			<td>'.date('d/m/Y - l', strtotime($key)).'</td>
			<td>'.(isset($arr[$key]['checkin']) ? date('H:i:s', strtotime($arr[$key]['checkin']['postdate_datetime'])) : '&mdash;').'</td>
			<td>'.(isset($arr[$key]['checkout']) ? date('H:i:s', strtotime($arr[$key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>
			<td>'.($dif ? getWorkedTime($dif) : '&mdash;').'</td>
			</tr>';
		}
	}

	$link = '/id/'.$alt_name.'/';

	global $link_arr, $content_link;
	$link_arr = array();

	$link .= count($link_arr)>0?'?'.implode('&', $link_arr):'';

	if($page>1) $link_arr[] = 'page='.$page;
	if($res_sort) $link_arr[] = 'sort='.$res_sort;

	$content_link = count($link_arr)>0?'?'.implode('&', $link_arr):'';

	global $content_result;
	$content_result = array(
		'section' => 'user-attendance',
		'status' => ($rows?'ok':'bad'), 
		'link' => $link, 
		'title' => 'User Attendance',
		'result' => $rows, 
		'view_role' => $view_role,
		'no_result' => '<div class="table-no-results">No results</div>',
		'pages_num' => $pages_num, 
		'count' => $count, 
		'sort' => $res_sort,
		'sorts' => $sorts,
		'visible_columns' => $visible_columns
	);

	$res = '<div id="user-attendance" class="content-inner-fragment">
	<div class="content-top-nav">
		<h1>Attendance</h1>
	</div>
<div class="content-inner-wrapper">
'.printTableContent(true).'
'.printTableContentJS().'
'.printTableAfterParams(true).'
</div>
	';


	$res .= '
</div>';

	return $res;
}

//'position_reference', 'position_title', 'business_unit', 'employee_number'
function printUser($new = false){
	global $content_result, $db, $title, $config, $add_user_role;
	if($new){
		$user_type = $add_user_role;
	} else {
		$user_type = $content_result['user_type'];
	}

	if($user_type == 'user'){
		$arr = array(
		array('name' => 'Employee number', 'field' => 'employee_number', 'type' => 'text', 'required' => false),
		array('name' => 'Surname', 'field' => 'last_name', 'type' => 'text', 'required' => true),
		array('name' => 'Given Name', 'field' => 'first_name', 'type' => 'text', 'required' => true),
		array('name' => 'Position number', 'field' => 'position_number', 'type' => 'text', 'required' => false),
		array('name' => 'Position reference', 'field' => 'position_reference', 'type' => 'text', 'required' => false),
		array('name' => 'Position title', 'field' => 'position_title', 'type' => 'text', 'required' => false),
		array('name' => 'Business unit', 'field' => 'business_unit', 'type' => 'text', 'required' => false),
		array('name' => 'Award', 'field' => 'award', 'type' => 'text', 'required' => false),
		array('name' => 'Class', 'field' => 'class_data', 'type' => 'text', 'required' => false),
		array('name' => 'Gender', 'field' => 'gen', 'type' => 'text', 'required' => false),
		array('name' => 'Birth date', 'field' => 'birthdate', 'type' => 'text', 'required' => false),
		array('name' => 'First Commerce', 'field' => 'first_commerce', 'type' => 'text', 'required' => false),
		array('name' => 'Step', 'field' => 'step', 'type' => 'text', 'required' => false),
		array('name' => 'HDA Occ Name', 'field' => 'hda_occ_name', 'type' => 'text', 'required' => false),
		array('name' => 'E-mail', 'field' => 'email', 'type' => 'text', 'required' => false),
		array('name' => 'Password', 'field' => 'password', 'type' => 'password', 'required' => false),
		array('name' => 'Company', 'field' => 'company_name', 'type' => 'text', 'required' => false),
		array('name' => 'Clevel', 'field' => 'clevel', 'type' => 'text', 'required' => false),
		array('name' => 'Frz', 'field' => 'frz', 'type' => 'text', 'required' => false),
		array('name' => 'Funding', 'field' => 'funding', 'type' => 'text', 'required' => false),
		array('name' => 'Account', 'field' => 'account_data', 'type' => 'text', 'required' => false),
		#array('name' => 'Sub Occ', 'field' => 'sub_occ', 'type' => 'text', 'required' => false),
		#array('name' => 'Sub Occ Name', 'field' => 'sub_occ_name', 'type' => 'text', 'required' => false),
		array('name' => 'Con Occ', 'field' => 'con_occ', 'type' => 'text', 'required' => false),
		array('name' => 'Con Occ Name', 'field' => 'con_occ_name', 'type' => 'text', 'required' => false),
		array('name' => 'HDA Occ', 'field' => 'hda_occ', 'type' => 'text', 'required' => false),
		);
	} else {
		$arr = array(
		array('name' => 'Surname', 'field' => 'last_name', 'type' => 'text', 'required' => true),
		array('name' => 'Given Name', 'field' => 'first_name', 'type' => 'text', 'required' => true),
		array('name' => 'E-mail', 'field' => 'email', 'type' => 'text', 'required' => false),
		array('name' => 'Password', 'field' => 'password', 'type' => 'password', 'required' => false),
		array('name' => 'Company', 'field' => 'company_name', 'type' => 'text', 'required' => false),
		array('name' => 'Birth date', 'field' => 'birthdate', 'type' => 'text', 'required' => false),
		array('name' => 'Position number', 'field' => 'position_number', 'type' => 'text', 'required' => false),
		array('name' => 'Position reference', 'field' => 'position_reference', 'type' => 'text', 'required' => false),
		array('name' => 'Position title', 'field' => 'position_title', 'type' => 'text', 'required' => false),
		array('name' => 'Business unit', 'field' => 'business_unit', 'type' => 'text', 'required' => false),
		array('name' => 'Employee number', 'field' => 'employee_number', 'type' => 'text', 'required' => false),
		array('name' => 'Clevel', 'field' => 'clevel', 'type' => 'text', 'required' => false),
		array('name' => 'Frz', 'field' => 'frz', 'type' => 'text', 'required' => false),
		array('name' => 'Funding', 'field' => 'funding', 'type' => 'text', 'required' => false),
		array('name' => 'Account', 'field' => 'account_data', 'type' => 'text', 'required' => false),
		array('name' => 'Award', 'field' => 'award', 'type' => 'text', 'required' => false),
		array('name' => 'Class', 'field' => 'class_data', 'type' => 'text', 'required' => false),
		#array('name' => 'Sub Occ', 'field' => 'sub_occ', 'type' => 'text', 'required' => false),
		#array('name' => 'Sub Occ Name', 'field' => 'sub_occ_name', 'type' => 'text', 'required' => false),
		array('name' => 'Gender', 'field' => 'gen', 'type' => 'text', 'required' => false),
		array('name' => 'First Commerce', 'field' => 'first_commerce', 'type' => 'text', 'required' => false),
		array('name' => 'Step', 'field' => 'step', 'type' => 'text', 'required' => false),
		array('name' => 'Con Occ', 'field' => 'con_occ', 'type' => 'text', 'required' => false),
		array('name' => 'Con Occ Name', 'field' => 'con_occ_name', 'type' => 'text', 'required' => false),
		array('name' => 'HDA Occ', 'field' => 'hda_occ', 'type' => 'text', 'required' => false),
		array('name' => 'HDA Occ Name', 'field' => 'hda_occ_name', 'type' => 'text', 'required' => false),
		);
	}

	if($new){
		$content_result = array();
		$content_result['id'] = 0;
		foreach ($arr as $key => $value) {
			$content_result[$value['field']] = '';
		}
		$content_result['credits_num'] = 0;
		$user_type = $add_user_role;

		if(($add_user_role == 'admin' OR $add_user_role == 'customer' ) AND !is_admin()){
			return 'noaccess';
		}
		$title = 'Add ';

	} else {
		$user_type = $content_result['user_type'];
		if($content_result['id'] != $_SESSION['user_id']){
			if(
				($content_result['group_id'] == 1 OR $content_result['group_id'] == 2) AND !is_admin()
			){
				return 'noaccess';
			}
		}
		$title = '';
	}

	$title .= ucfirst($user_type).' - '.$config['title'];

	$pin = (isset($content_result['pin']) AND $content_result['pin']) ? $content_result['pin'] : '';


	$tpl = '<form id="content-form" method="post" action="" autocomplete="off"><input type="hidden" name="user_type" value="'.$user_type.'" />'.($new ? '' : '<input type="hidden" name="user_id" value="'.$content_result['id'].'" />');

	if(!$new AND $user_type == 'user'){
		#$tpl .= '<div class="newton">';

		if(isset($content_result['author_id']) AND $content_result['author_id']){
			$linked_to = $db->super_query("SELECT id, alt_name, first_name, last_name, company_name FROM users WHERE id = ".$content_result['author_id']);
			if(isset($linked_to['id']) AND $linked_to['id']){
				$tpl .= '<div class="data-row data-row-linked">Linked to <a href="/id/'.$linked_to['alt_name'].'/">'.htmlspecialchars(($linked_to['company_name'] ? $linked_to['company_name'] : $linked_to['first_name'].' '.$linked_to['last_name']), ENT_QUOTES).'</a></div>';
			}
		}
	}

	foreach ($arr as $key => $value) {
		$readonly = isset($value['readonly']) ? ' readonly' : '';
		if($user_type == 'user' AND $value['field'] == 'password'){

		} else {
		$tpl .= '<div class="data-row">
		<div class="label">'.$value['name'].($value['required']?'*':'').' :</div>
		<div class="value">	
			<div class="bi'.(( ( $value['field']!='password' AND $content_result[$value['field']]!='') OR $content_result[$value['field']]>0)?' active':'').'">
				<div class="input-label">'.$value['name'].'</div>
				<div class="bi-field">
					<input type="'.$value['type'].'" name="'.$value['field'].'" autocomplete="off"'.($value['required']?' data-required="true"':'').(($value['field']!='password') ? ' data-value="'.htmlspecialchars($content_result[$value['field']], ENT_QUOTES).'" value="'.htmlspecialchars((($value['field']=='email' AND $content_result[$value['field']]=='') ? ' ':$content_result[$value['field']]), ENT_QUOTES).'"'.$readonly:'').' /></div>
				
			</div>
		</div>
	</div>';
		}
	}
	if(!$new AND is_admin() AND ($user_type == 'customer' OR $user_type == 'user')){
	//'.($content_result['is_blocked'] ? '' : ' style="display: none;"').'
		//value="'.htmlspecialchars($content_result['reason_suspension'], ENT_QUOTES).'"
		$tpl .= '<div class="data-row data-bi-switcher">
		<div class="label">Account Status :</div>
		<div class="value">	
			<div class="ns bi-switcher red-bi-switcher'.($content_result['is_blocked']==1?'':' active').' suspension-depend-reason" data-val="'.$content_result['is_blocked'].'" data-on="ACTIVE" data-off="SUSPENDED"><input name="is_active" type="text" autocomplete="off" value="'.($content_result['is_blocked']==1?'false':'true').'" />
					<div class="sw"></div><div class="sw-val">'.($content_result['is_blocked']==1?'SUSPENDED':'ACTIVE').'</div></div>
			<div id="suspension-reason" class="bi'.($content_result['reason_suspension']?' active':'').' bi-switcher-toggle" style="display: none;">
				<div class="input-label">Reason for Suspension</div>
				<div class="bi-field"><input type="text" autocomplete="off" name="reason_suspension" /></div>
			</div>
		</div>
	</div>';
	}
	if(!$new AND is_admin() AND $user_type == 'user'){
		$qr = '/st/qrcodes/'.$content_result['qr_dirname'].'/'.$content_result['qr_filename'].'.png';
		$tpl .= '<div class="data-row data-bi-switcher">
		<div class="label">QR Code :</div>
		<div class="value">	
			<div class="bi">
			QR Code data: <b>'.$content_result['id'].'@@'.$content_result['qr_salt'].'</b>
			<a href="'.$qr.'" target="_blank" style="display: block;"><img src="'.$qr.'" style="width: 40px;height: 40px;display: inline-block;vertical-align: middle;margin-right: 8px;" / >Open QR Code</a></div>
		</div>
	</div>';
	}

	$is_my_profile = (is_customer() AND $_SESSION['user_id'] == $content_result['id']);


	//<div id="appear-cnt-btn" class="btnsave blue" onclick="sendUserEmail(this);" style="display: none;">Send</div>
	$res_btn = '';
	if(!$is_my_profile){
		if($new){
			$res_btn = '<div class="btnsave blue" onclick="postUser(this,true);">Create</div>';
		} else {
			$res_btn = '<div class="btnsave green" onclick="postUser(this);">Save</div>';
		}
	}


	$back_btn = '<div class="btnsave gray" onclick="window.history.go(-1);">Back</div>';
	if(is_admin() AND $_SESSION['user_id'] != $content_result['id']) $back_btn .= '<div class="btnsave delred" onclick="deleteUser(this, '.$content_result['id'].');">Delete</div>';


	$tpl .= '<div class="btn-wrap">'.$res_btn.$back_btn.'</div>';
	

/*	if(!($new AND $user_type == 'user') AND $user_type == 'user'){
		$tpl .= '<div class="btn-wrap">'.$back_btn.'</div>';
	}*/

	$tpl .= '</form>';

	return $tpl;
}






function ordinal($number) {
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if ((($number % 100) >= 11) && (($number%100) <= 13))
        return $number. 'th';
    else {
    	$abbreviation = ($number)? $number. $ends[$number % 10] : $number;
        return $abbreviation;
    }
}









/*
	Users List
*/

function getCustomers(){
	global $config, $db, $page, $size, $search_text, $search_fields, $sort, $ug, $logged, $view_role;

	$sorts = array(
		'new' => 'users.id DESC',
		'email-asc' => 'email ASC',
		'email-desc' => 'email DESC',
		'postdate-asc' => 'postdate ASC',
		'postdate-desc' => 'postdate DESC'
	);

	$res_sort = '';

	if(!isset($sorts[$sort])){
		if($sort AND (isset($sorts[$sort.'-asc']) OR isset($sorts[$sort.'-desc']))){
			$res_sort = $sort.'-desc';
		}
		$sort = 'new';
	} else {
		$res_sort = $sort;
	}
			
	$is_admin = is_admin();
	$is_customer = is_customer();


	$visible_columns = array();

	$t_section = '';
	$current_view_role = '';

	$role_sql = '';
	if($view_role == 'admins'){

		$role_sql = ' AND users.group_id = 1';
		$visible_columns = array('postdate');
		$t_section = 'Admins';
		$current_view_role = 'admins';

	} elseif($view_role == 'customers' OR (!$view_role AND $is_admin)){

		$role_sql = ' AND users.group_id = 2';
		$visible_columns = array('company_name', 'credits_num', 'postdate');
		$t_section = 'Customers';
		$current_view_role = 'customers';

		if(is_admin()){

			$visible_columns[] = 'account_status';

		}

	} elseif($view_role == 'users' OR (!$view_role AND $is_customer)){

		$role_sql = ' AND users.group_id = 3';
		$visible_columns = array('status', 'editdate', 'position_reference', 'position_title', 'business_unit', 'employee_number', 'first_name', 'last_name');

		$t_section = 'Users';
		$current_view_role = 'users';

		if($is_customer){

			$role_sql .= ' AND users.author_id = '.$_SESSION['user_id'];

		}

		if(is_admin()){

			$visible_columns[] = 'account_status';

		}

	}


	$sort_sql = ' ORDER BY '. $sorts[$sort];

	$parsed_search_results = getSearchResultsQuery();
	$where_sql = $parsed_search_results['sf_sql'];


	$where_sql .= $role_sql;


	$c_sql = "SELECT count(*) as count FROM users WHERE 1".$where_sql." LIMIT 1";
	#die($c_sql);
	$count = $db->super_query($c_sql);
	$count = $count['count'];

	//for list
	$_where_sql = $where_sql;
	$where_sql .= $sort_sql;

	$pages_num = intval(($count - 1) / $size) + 1;
	if(!$pages_num) $pages_num = 1;

	if($page > $pages_num) $page = $pages_num; 
	$start_row = $page * $size - $size; 


	$res = '';

	if($count>0){

		$data_arr = array();

		$q_sql = "SELECT * FROM users WHERE 1".$where_sql." LIMIT ".$start_row.",".$size;

		$db->query($q_sql);
		while($row = $db->get_row()){
			$data_arr[] = $row;
		}
		$db->free();


		foreach ($data_arr as $key => $row) {

			$yes = '<span style="color: #46b450">Yes</span>';
			$no = '<span style="color: #aa2c2c">No</span>';

			$uba_who = '';
			if($row['is_blocked'] AND (isset($row['uba']) AND $row['uba'])){
				$ubauba = explode('#', $row['uba']);
				$uba_who =' by '.htmlspecialchars($ubauba[0].' '.$ubauba[1], ENT_QUOTES).' on '.($row['block_postdate']?date('d/m/Y', $row['block_postdate']):'');
			}
			//ordinal(intval(date('j', $row['editdate']))).' '.date('M Y, g:i a', $row['editdate'])
			/*
							'.(in_array('position_reference', $visible_columns) ? '<td>'.htmlspecialchars($row['position_reference'], ENT_QUOTES).'</td>' : '').'
				'.(in_array('position_title', $visible_columns) ? '<td>'.htmlspecialchars($row['position_title'], ENT_QUOTES).'</td>' : '').'
				'.(in_array('business_unit', $visible_columns) ? '<td>'.htmlspecialchars($row['business_unit'], ENT_QUOTES).'</td>' : '').'
				*/
			$res .= '<tr id="tr-'.$row['id'].'">';
				

				if($current_view_role == 'users'){
					if(in_array('employee_number', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['employee_number'], ENT_QUOTES).'</td>';
					if(in_array('last_name', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['last_name'], ENT_QUOTES).'</td>';
					if(in_array('first_name', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['first_name'], ENT_QUOTES).'</td>';
					if(in_array('position_number', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['position_number'], ENT_QUOTES).'</td>';
					if(in_array('position_reference', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['position_reference'], ENT_QUOTES).'</td>';
					if(in_array('position_title', $visible_columns)) $res .= '<td>'.htmlspecialchars($row['position_title'], ENT_QUOTES).'</td>';
				} else {
					$res .= '<td>'.htmlspecialchars($row['first_name'], ENT_QUOTES, 'utf-8').'</td>
					<td>'.htmlspecialchars($row['last_name'], ENT_QUOTES, 'utf-8').'</td>

					'.(in_array('company_name', $visible_columns) ? '<td><a href="/users/?search_fields[author_id]='.$row['id'].'">'.htmlspecialchars($row['company_name'], ENT_QUOTES).'</a></td>' : '');
				}

			$res .= '

				<td class="email-column">'.($row['email'] ? '<div class="email-address"><span>'.$row['email'].'</span></div>' : '').'</td>
				<td>'.($row['is_blocked']==1?'<span style="color: #aa2c2c">Suspended</span>'.$uba_who:'<span style="color: #46b450">Active</span>').'</td>

				<td>'.date('F j, Y g:i a', $row['postdate']).'</td>

				<td class="actions-td"><a href="/id/'.$row['alt_name'].'/">View</a>'
				.(($is_admin AND $row['group_id'] != 3) ? '<a onclick="loginByAltId(this, \''.$row['id'].'\');">Login as user</a>' : '')
				.'</td>
			</tr>';
		}

	}


	//create link
	#var_dump($view_role);exit;
	$link = '/'.($view_role ? $view_role.'/' : '');

	global $link_arr, $content_link;
	$link_arr = array();

	$link .= count($link_arr)>0?'?'.implode('&', $link_arr):'';

	if($page>1) $link_arr[] = 'page='.$page;
	if($res_sort) $link_arr[] = 'sort='.$res_sort;
	if(count($search_fields)>0) $link_arr[] = buildUrlArray($search_fields);
	if($search_text) $link_arr[] = 'search_text='.$search_text;

	$content_link = count($link_arr)>0?'?'.implode('&', $link_arr):'';

	//create title
	$title = $t_section.' '.($page>1?'- Page '.$page.' ':'');

	return array(
		'section' => 'users',
		'status' => ($res?'ok':'bad'), 
		'link' => $link, 
		'title' => $title,
		'result' => $res, 
		'view_role' => $view_role,
		'no_result' => '<div class="table-no-results">No results</div>',
		'pages_num' => $pages_num, 
		'count' => $count, 
		'search_fields' => $search_fields, 
		'search_text' => $search_text,
		'sort' => $res_sort,
		'sorts' => $sorts,
		'visible_columns' => $visible_columns
	);

}
function noAccess(){
	return '<div class="content-wrapper"><div class="content-top-nav" style="font-size: 18px;">Sorry, you don\'t have access.</div></div>';
}

/*

	Print User Lists

*/
function getUserListContent(){
	global $view_role;

	if(
		($view_role == 'admins' AND !is_admin()) OR 
		($view_role == 'customers' AND !is_admin())
	){
		return noAccess();
	}

	$tpl = '
<div class="content-wrapper">

<div class="content-top-nav">';

	if($view_role == 'admins')
		$tpl .= '<a href="/add-admin/" class="graybtn">Add Admin</a>';

	if($view_role == 'customers' OR (is_admin() AND !$view_role))
		$tpl .= '<a href="/add-customer/" class="graybtn">Add New Customer</a><div class="graybtn" style="margin-left: 20px;padding: 0;"><div id="add-users-spreadsheet-button-data-res" style="padding: 0 15px;" onclick="addUsersSpreadsheet();" data-name="Add Customers from Spreadsheet">Add Customers from Spreadsheet</div><input type="file" id="spreadsheet-users-file" data-role="customers" style="display: none;position: relative;overflow: hidden;width: 1px;height: 1px;opacity: 0;" /></div>';

	if($view_role == 'users' OR (is_customer() AND !$view_role))
		$tpl .= '<a href="/add-user/" class="graybtn">Add User</a><div class="graybtn" style="margin-left: 20px;padding: 0;"><div id="add-users-spreadsheet-button-data-res" style="padding: 0 15px;" onclick="addUsersSpreadsheet();" data-name="Add Users from Spreadsheet">Add Users from Spreadsheet</div><input type="file" id="spreadsheet-users-file" data-role="users" style="display: none;position: relative;overflow: hidden;width: 1px;height: 1px;opacity: 0;" /></div>';

$tpl .= '
</div>

<div class="content-inner-wrapper">
'.printTablePreParams().'
'.printTableContent(true).'
'.printTableContentJS().'
'.printTableAfterParams(true).'
</div>

</div>
';
	return $tpl;
}

function checkUserPerm($user_id){

	global $db;

	$allow = false;
	$skip_check = false;

	if(is_admin()){

		$skip_check = true;
		$allow = true;

	}

	if(!$skip_check){
		$u = $db->super_query("SELECT author_id FROM users WHERE id = ".$user_id);
		if($u['author_id'] == $_SESSION['user_id']){
			$allow = true;
		}
	}

	return $allow;

}

function generatePassword( $length = 12, $special_chars = true, $extra_special_chars = false ) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    if ( $special_chars ) {
        $chars .= '!@#$%^&*()';
    }
    if ( $extra_special_chars ) {
        $chars .= '-_ []{}<>~`+=,.;:/?|';
    }
 
    $password = '';
    for ( $i = 0; $i < $length; $i++ ) {
        $password .= substr( $chars, mt_rand( 0, strlen( $chars ) - 1 ), 1 );
    }

    return $password;
}

function setUserLoginData($row, $email = '', $pass = ''){
	global $config, $db, $ug;

	if(!empty($email)) $email = $row['email'];
	if(!empty($pass)) $pass = $row['password'];

	$token = hash('sha256', sha1(uniqid().$config['domain'].$email.$pass.time()));

	$db->query("UPDATE users SET token = '".$token."', lastdate = '".time()."' WHERE id = ".$row['id']);

	sb_setcookie('sb_id', $row['alt_name']);
	sb_setcookie('sb_token', $token);

	@session_start();

	setUserData($row);
}

function printHeaderMenu(){
	global $logged;

	$new_cert_orders = 0;
	if(is_admin()){
		$nco_file = @file_get_contents(ROOT . '/core/cache/new_cert_orders.php');
		if($nco_file!=''){
			$new_cert_orders = $nco_file;
		}
	}

	$hm = '';
	if($logged){
		$hm = (is_admin()?'<li><a class="users-icon" href="/admins/">Admins</a></li>':'')
		.(is_admin()?'<li><a class="users-icon" href="/customers/">Customers</a></li>':'')
		.((is_customer() OR is_admin())?'<li><a class="users-icon" href="/users/">Users</a></li>':'')
		.((is_customer() OR is_admin())?'<li><a class="reports-icon" href="/reports/">Reports</a></li>':'')
		;
	}

	return $hm;
}

function printHeader(){
	global $logged;


	$res = '<header id="header">
	<div id="logo">
		<a href="/"><img src="/static/images/logo.png" /></a>
	</div>
	<div id="hm">
		<div id="menu"></div>
		<ul id="header-menu" class="hm">
			'.printHeaderMenu().'
		</ul>
	</div>
	'.($logged ? '<div id="user-menu">
		<div id="user-inline-name" class="inline-name">
			<img src="/static/images/ui/user-drop.png" />
			<span>'.$_SESSION['first_name'].' '.($_SESSION['last_name'] ? substr($_SESSION['last_name'], 0, 1).'.':'').'</span>
		</div>
		<ul id="user-menu-list">
			<li class="profile-link"><a href="/id/'.$_SESSION['alt_name'].'/">My profile</a></li>
			'.(isset($_SESSION['was_admin_id'])?'<li class="logout-link"><a onclick="logout(true);">Log out</a></li>' : '').'
			<li class="logout-link"><a onclick="logout();">Log out'.(isset($_SESSION['was_admin_id'])?' all' : '').'</a></li>
		</ul>
	</div>' : '').'
</header>';
	return $res;
}


function printDocHead(){
	global $title;
	return '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="/static/html5.js"></script><![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=1">
	<title>'.$title.'</title>
	<link rel="stylesheet" href="/static/styles.css.php?v='.time().'" type="text/css" />
	<link rel="icon" href="/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
</head>';
}

function getRestoreScreen(){

	if(isset($_GET['act']) AND $_GET['act'] == 'restore'){

		global $config, $db, $title;

		$title = 'Restore Password';

		$error = '';
		$success = false;

		$alt_name = isset($_GET['id']) ? trim(strip_tags($_GET['id'])) : '';
		$token = isset($_GET['token']) ? trim(strip_tags($_GET['token'])) : '';

		if(!$alt_name) $error = 'Wrong Request';
		if(!$token) $error = 'Wrong Request';

		$row = $db->super_query("SELECT id, email, restore_token FROM users WHERE alt_name = '".$db->safesql($alt_name)."'");
		if(!$row['id']){
			$error = 'Wrong Request';
		}

		$restore_link_token = hash('sha256', $row['restore_token'].sha1($config['domain'].date('dmY')));
		if($restore_link_token != $token){
			$error = 'Wrong Request';
		}

		if(isset($_POST['newpassword'])){
			$password = isset($_POST['newpassword']) ? $_POST['newpassword'] : '';

			if(strlen($password)<6) die();
			
			$pass = hash('sha512', sha1($password));
			$token = hash('sha256', sha1(uniqid().$config['domain'].$row['email'].$pass.time()));


			$db->query("UPDATE users SET restore_token = '', password = '".$pass."', token = '".$token."' WHERE id = ".$row['id']);

			$success = true;

		}

die(printDocHead().'
<body class="center-page">
'.printHeader().'
<div class="wrapper">
	<main id="content">
		<div class="content-wrapper">
			<div class="content-inner-fragment">
				<div id="content-msg">'.($error?'<div class="error">'.$error.'</div>':'').($success ? '<div class="success">Your password has been changed!</div>' : '').'</div>
				'.((!$error AND !$success) ? '
				<div class="content-top-nav">
					<h1>Restore Password</h1>
				</div>
				<form id="restore-form" method="post" action="">

					<div class="data-row">
						<div class="label">New Password* :</div>
						<div class="value">	
							<div class="bi">
								<div class="input-label">Enter New Password</div>
								<div class="bi-field"><input id="reg-password" type="password" name="newpassword" autocomplete="new-password" /></div>
							</div>
						</div>
					</div>

					<div class="data-row">
						<div class="label">Confirm New Password* :</div>
						<div class="value">	
							<div class="bi">
								<div class="input-label">Re-enter Password</div>
								<div class="bi-field"><input id="reg-password2" type="password" name="password" autocomplete="new-password" /></div>
							</div>
						</div>
					</div>

					<div class="btn-wrap"><div onclick="changePassword(this);" class="btnsave blue">Update</div></div>':'')
				.($success ? '
					<div class="content-top-nav">
						<h1>Password changed!</h1>
					</div>
					<div class="btn-wrap"><a href="/" class="btnsave blue">Continue</a></div>':'').'

				</form>
			</div>
		</div>
	</main>
</div>
'.print_system_layout().'
</body>
</html>');

	}

}

function getLoginScreen(){
	global $db;

	$tpl = '<!DOCTYPE html><html><head><title>PNG Time Access Login</title><meta charset="utf-8" /><!--[if lt IE 9]><script src="/static/html5.js"></script><![endif]--><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="keywords" content="" /><meta name="description" content="" /><link rel="stylesheet" href="/static/login.css.php?v='.time().'" type="text/css" /><link rel="icon" href="/favicon.ico" type="image/x-icon" /><link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" /></head><body>';

	$tpl .= '
<div id="login">

<div class="form">
	<div class="logo"><a href="/"><img src="/static/images/logo.png" /></a></div>
	<div id="auth-login" class="login-psb" style="opacity: 1;left: 0;">
		<form id="login-f1" method="post" action="" autocomplete="off" onsubmit="return sendLoginForm(this, \'login-by-email\');">
			<div class="head">Sign In</div>
			<div class="bi">
				<div class="input-label">E-mail or Username</div>
				<div class="bi-field"><input type="text" name="email" autocomplete="off" /></div>
			</div>
			<div class="bi">
				<div class="input-label">Password</div>
				<div class="bi-field"><input type="password" name="password" autocomplete="off" /></div>
			</div>
			<div class="mid-text"><a onclick="showRestoreForm();">Reset Password</a></div>
			<div class="send-form">
				<div id="send-login" class="btn">Sign In</div>
			</div>
		</form>
	</div>
	<div id="auth-restore" class="login-psb" style="display: none;">
		<form id="login-restore" method="post" action="" autocomplete="off" onsubmit="return sendRestoreForm(this);">
			<div class="head">Reset Password</div>
			<div class="rm"></div>
			<div class="bi">
				<div class="input-label">E-mail or Username</div>
				<div class="bi-field"><input type="text" name="email" autocomplete="off" /></div>
			</div>
			<div class="mid-text"><a onclick="showLoginForm();">Go back to login form</a></div>
			<div class="send-form">
				<div id="send-restore" class="btn">Reset</div>
			</div>
		</form>
	</div>
</div>

</div>

<script type="text/javascript">
document.getElementById("login").className += "visible";
</script>
<script type="text/javascript" src="/static/jquery.js"></script>
<script type="text/javascript">
function btnLoader($el){
	$el.html(\'<div class="btn-loader"><img src="/static/images/btn_loader.gif" /></div>\');
}
function showLoginForm(){
	$("#login-restore .rm").html("");
	$("#auth-login").show().animate({left: 0, opacity: 1}, 200);
	$("#auth-restore").animate({left: "100px", opacity: 0}, 200).hide();
}
function showRestoreForm(){
	$("#auth-restore").show().animate({left: 0, opacity: 1}, 200);
	$("#auth-login").animate({left: "100px", opacity: 0}, 200).hide();
}
function sendRestoreForm(form){
	var f = $(form).serialize();
	var $btn = $(form).find(".send-form .btn");
	btnLoader($btn);
	$.post("/ajax.php?action=restore-password", f, function(data){
		$btn.html("Reset");
		if(data == "ok"){
			$(form).find(".rm").html(\'<div class="success">We have just sent you a link to reset your password</div>\');
			var $inp = $(form).find("input[name=\'email\']");
			$inp.val("");
			$inp.parent().parent().removeClass("active");
		} else {
			$(form).find(".rm").html(\'<div class="error">\'+data+\'</div>\');
		}
	});
	return false;
}
function sendLoginForm(form, login_by){
	var f = $(form).serialize();
	var $btn = $(form).find(".send-form .btn");
	btnLoader($btn);
	$.post("/ajax.php?action="+login_by, f, function(data){
		$btn.html("Sign In");
		if(data.status == "ok"){
			$(form).find(".error").remove();
			window.localStorage.clear();
			if(data.local_storage != ""){
				var ls = JSON.parse(data.local_storage);
				for(var i in ls){
					localStorage.setItem(i, ls[i]);
				}
			}
			window.location.href = "/";
		} else {
			if($(form).find(".error").length){
				$(form).find(".error").text(data.error);
			} else {
				$(form).find(".head").after(\'<div class="error">\'+data.error+\'</div>\');
			}
		}
	}, "json");
	return false;
}
$(document).ready(function(){
	$("#send-login").on("click", function(){
		$("#login-f1").submit();
	});		
	$("#send-restore").on("click", function(){
		$("#login-restore").submit();
	});	
	$("#send-login2").on("click", function(){
		$("#login-f2").submit();
	});
	$(".bi").on("click input change", function(){
		if($(this).hasClass("active")) return;

		$(this).find("input").focus();
		$(this).addClass("active");
	});
	$(".bi input").on("blur", function(){
		if($(this).val()==""){
			$(this).parent().parent().removeClass("active");
		}
	});
});
</script>
';
$tpl .= '</body></html>';
	die($tpl);
}

function setUserData($row){
	$_SESSION['logged'] = true;
	$_SESSION['user_id'] = $row['id'];
	$_SESSION['alt_name'] = $row['alt_name'];
	$_SESSION['group_id'] = $row['group_id'];
	$_SESSION['first_name'] = $row['first_name'];
	$_SESSION['last_name'] = $row['last_name'];
	$_SESSION['email'] = $row['email'];
}


function print_system_layout(){
	global $create_account_link, $logged, $js_files;
	$tpl = '<div id="overlay"></div>
<script type="text/javascript" src="/static/jquery.js"></script>';
if(isset($js_files) AND count($js_files)>0){
	foreach ($js_files as $key => $value) {
		$tpl .= '<script type="text/javascript" src="/static/'.$value.'.js"></script>';
	}
}
$tpl .= '
<script type="text/javascript" src="/static/core.js.php?v='.time().'"></script>
';
	return $tpl;
}

function uploadImage($item_id = 0, $item_type = '', $name = '', $type = '', $tmp_path = '', $size = 0){
	global $config;

	if(!$item_id) die(json_encode(array('status' => 'bad', 'error' => 'Bad item id')));

	// SECTION TYPE
	if(!$item_type) die(json_encode(array('status' => 'bad', 'error' => 'Bad item type')));
	$images_item_types = getImageItemTypes();
	if(!isset($images_item_types[$item_type])) die(json_encode(array('status' => 'bad', 'error' => 'Bad image item type')));

	$item_type_id = $images_item_types[$item_type];

	$width = 0;
	$height = 0;

	$white_extensions = array('jpg', 'jpeg', 'png');

	if(!$name) die(json_encode(array('status' => 'bad', 'error' => 'Bad file')));

	$ext = explode('.', $name);
	$ext = end($ext);

	$name = translit(substr($name, 0, (strrpos($name, '.'))));
	if(!$name) $name = substr(md5(uniqid()), 0, 8);

	$name = substr($name, 0, 250);
	$file_name = substr(substr(md5(uniqid().time()), 0, 8).'-'.$name, 0, 250);

		$prod_img_path = ROOT . '/images/'.$item_type.'/';

	    $dir_name = date('Ymd');
	    $dir = $prod_img_path.$dir_name;
	    if(!is_dir($dir)){
	    	mkdir($dir, 0777, true);
	    }

	    $full_file_name = $file_name . '.' . $ext;
	    $file_path = $dir . '/' . $full_file_name;

	    $file_url = '/images/'.$item_type.'/'.$dir_name.'/'.$full_file_name;

		$imagesize = getimagesize($tmp_path);
	    if($imagesize !== false){

	    	$width = intval($imagesize[0]);
	    	$height = ($imagesize[1]);
	    	$mime = trim(strip_tags($imagesize['mime']));
	    	
	    } else {

	    	$mime = trim(strip_tags($type));

	    }

	    if($size > $config['admin_max_file_size']*1000){
	    	die(json_encode(array('status' => 'bad', 'error' => 'You exceeded maximum size')));
	    }


	    if(move_uploaded_file($tmp_path, $file_path)){

			global $db;

			image_resize($file_path, $dir.'/'.$file_name.'_medium.'.$ext, 550, 367, 100);
			image_resize($file_path, $dir.'/'.$file_name.'_small.'.$ext, 250, 167, 100);
			image_resize($file_path, $dir.'/'.$file_name.'_tiny.'.$ext, 80, 50, 100);

	    	$is_primary = 1;
			if($item_type_id != 3){
				$check_primary = $db->super_query("SELECT id FROM images WHERE is_primary = 1 AND item_id = ".$item_id." AND item_type_id = ".$item_type_id);
			    if($check_primary['id']){
			    	$is_primary = 0;
			    }
			}
	    	$insert_sql = "INSERT INTO images
	    	(item_id, item_type_id, name, ext, dir_name, file_name, width, height, mime, is_primary)
	    	VALUES
	    	('".$item_id."', '".$item_type_id."', '".$db->safesql($name)."', '".$db->safesql($ext)."', '".$db->safesql($dir_name)."', '".$db->safesql($file_name)."', '".$width."', '".$height."', '".$db->safesql($mime)."', '".$is_primary."')
	    		";
			if($item_type_id == 3){

			    $check_img = $db->super_query("SELECT * FROM images WHERE item_id = ".$item_id." AND item_type_id = ".$item_type_id);
			    if($check_img['id']){

			    		$old_path = ROOT . '/images/'.$item_type.'/'.$check_img['dir_name'].'/'.$check_img['file_name'];
						@unlink($old_path.'.'.$check_img['ext']);
						@unlink($old_path.'_medium.'.$check_img['ext']);
						@unlink($old_path.'_small.'.$check_img['ext']);
						@unlink($old_path.'_tiny.'.$check_img['ext']);

			    		//update
			    		$db->query("UPDATE images
				    	SET name='".$db->safesql($name)."', ext='".$db->safesql($ext)."', dir_name='".$db->safesql($dir_name)."', file_name='".$db->safesql($file_name)."', width='".$width."', height='".$height."', mime='".$db->safesql($mime)."' 
				    	WHERE item_id = ".$item_id." AND item_type_id = ".$item_type_id);
				    	$new_id = $check_img['id'];
				    	
			    } else {
			    		//insert
						$db->query($insert_sql);
				    	$new_id = $db->insert_id();
			    }

			    clearCategoriesCache();

		    } else {

		    	$db->query($insert_sql);
		    	$new_id = $db->insert_id();

		    }

	    	return array(
	    		'error' => false, 
	    		'id' => $new_id, 
	    		'left_file_url' => '/images/'.$item_type.'/'.$dir_name.'/'.$file_name, 
	    		'ext' => $ext
	    	);

	    } else {

	    	return array(
	    		'error' => true
	    	);

	    }
}


function cat_breadcrumbs($cats, $pid, $list = array()){
	if(!$pid) return $list;
	$cc = $cats[$pid];
	$list[] = ['id' => $cc['id'], 'alt_name' => $cc['alt_name'], 'name' => $cc['title']];
	foreach($cats as $cat){
		if($cat['id'] == $pid){
			if($cat['parent_id']){
				return cat_breadcrumbs($cats, $cat['parent_id'], $list);
			} else {
				return array_reverse($list);
			}
		}
	}
}


function getCatLinks($cats, $cat){
	global $cats_by_pid;
		$cat_links = '';
		#print_r($cat);exit;
		foreach($cats as $link_cat){
			if($link_cat['parent_id'] == $cat['id']){
				$arr = cat_breadcrumbs($cats, $link_cat['id']);
				$link = '';
				foreach($arr as $k=>$v){
					$link = $link.'/'.$v['alt_name'];
				}
				$cat_links .= '<li'.($cat['id'] == $link_cat['id'] ? ' class="active"' : '').'><a href="'.$link.'" onclick="return z.go(this);">'.$link_cat['title'].'</a></li>';
			}
		}
		if(!$cat_links){	
			foreach($cats as $link_cat){
				if($link_cat['id'] == $cat['parent_id']){
					foreach($cats as $lc){
						if($link_cat['id'] == $lc['parent_id']){
							$arr = cat_breadcrumbs($cats, $lc['id']);
							$link = '';
							foreach($arr as $k=>$v){
								$link = $link.'/'.$v['alt_name'];
							}
							$cat_links .= '<li'.($cat['id'] == $lc['id'] ? ' class="active"' : '').'><a href="'.$link.'" onclick="return z.go(this);">'.$lc['title'].'</a></li>';
						}
					}
				}
			}
		}


		return $cat_links;
	}

//get only children cat links
function getChildrenCatLinks($cats, $cat){

	$cat_links = '';
	foreach($cats as $link_cat){
		if($link_cat['parent_id'] == $cat['id']){
			$arr = cat_breadcrumbs($cats, $link_cat['id']);
			$link = '';
			foreach($arr as $k=>$v){
				$link = $link.'/'.$v['alt_name'];
			}
			$cat_links .= '<li'.($cat['id'] == $link_cat['id'] ? ' class="active"' : '').'><a href="'.$link.'" onclick="return z.go(this);">'.$link_cat['title'].'</a></li>';
		}
	}

	if(!$cat_links){	
		foreach($cats as $link_cat){
			if($link_cat['id'] == $cat['parent_id']){
				foreach($cats as $lc){
					if($link_cat['id'] == $lc['parent_id']){
						$arr = cat_breadcrumbs($cats, $lc);
						$link = '';
						foreach($arr as $k=>$v){
							$link = $link.'/'.$v['alt_name'];
						}
						$cat_links .= '<li'.($id == $lc['id'] ? ' class="active"' : '').'><a href="'.$link.'" onclick="return z.go(this);">'.$lc['title'].'</a></li>';
					}
				}
			}
		}
	}

	return $cat_links;
}

function image_resize($source_path, $destination_path, $newwidth, $newheight = FALSE, $quality = FALSE) {
        ini_set("gd.jpeg_ignore_warning", 1);
                       
        list($oldwidth, $oldheight, $type) = getimagesize($source_path);
                       
        switch ($type) {
            case IMAGETYPE_JPEG: $typestr = 'jpeg'; break;
            case IMAGETYPE_GIF: $typestr = 'gif' ;break;
            case IMAGETYPE_PNG: $typestr = 'png'; break;
        }

        $function = "imagecreatefrom$typestr";
        $src_resource = $function($source_path);
                       
        if(!$newheight){ $newheight = round($newwidth * $oldheight/$oldwidth); }
        elseif(!$newwidth){ $newwidth = round($newheight * $oldwidth/$oldheight); }
        $destination_resource = imagecreatetruecolor($newwidth,$newheight);

/*        $exif_data = exif_read_data($source_path);
        if(!empty($exif_data['Orientation'])){
            switch($exif_data['Orientation']){
                case 8: 
                    $src_resource = imagerotate($src_resource, 90, 0);
                    break;
                case 3: 
                    $src_resource = imagerotate($src_resource, 180, 0);
                    break;
                case 6: 
                    $src_resource = imagerotate($src_resource, -90, 0);
                    break;
            }
        }*/
                       
        if ($type == 2){
            # jpeg
            imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $newwidth, $newheight, $oldwidth, $oldheight);
            imageinterlace($destination_resource, 1);
            if($quality) 
                imagejpeg($destination_resource, $destination_path, $quality);
            else
                imagejpeg($destination_resource, $destination_path);
        } else {
            # png
/*            $t_index = imagecolortransparent($src_resource);
            $t_color = array(
                'red' => 255, 
                'green' => 255, 
                'blue' => 255
            );
            if ($t_index >= 0) {
                $t_color = imagecolorsforindex($src_resource, $t_index);
            }
            $t_index = imagecolorallocate(
                $destination_resource, 
                $t_color['red'], 
                $t_color['green'], 
                $t_color['blue']
            );
            imagefill($destination_resource, 0, 0, $t_index);
            imagecolortransparent($destination_resource, $t_index);*/

            imagecopyresampled($destination_resource, $src_resource, 0, 0, 0, 0, $newwidth, $newheight, $oldwidth, $oldheight);
            $function = "image$typestr";
            $function($destination_resource, $destination_path);
        }
                       
        imagedestroy($destination_resource);
        imagedestroy($src_resource);
    }


function formatPrice($price){
	return number_format($price, 0, '', ' ');
}


function getUrlContent($url){
  $curl = curl_init();

  $header[0] = "Accept: text/xml,application/xml,application/xhtml+xml,";
  $header[0] .= "text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";
  $header[] = "Cache-Control: max-age=0";
  $header[] = "Connection: keep-alive";
  $header[] = "Keep-Alive: 300";
  $header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
  $header[] = "Accept-Language: en-us,en;q=0.5";
  $header[] = "Pragma: ";

  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:7.0.1) Gecko/20100101 Firefox/7.0.12011-10-16 20:23:00");
  curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
  curl_setopt($curl, CURLOPT_REFERER, "https://sarzhevsky.com");
  curl_setopt($curl, CURLOPT_ENCODING, "gzip,deflate");
  curl_setopt($curl, CURLOPT_AUTOREFERER, true);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_TIMEOUT, 30);
  #curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);

  $html = curl_exec($curl);
  curl_close($curl);

  return $html;
}

function getChildrenCats($cats, $cid, $arr = array()){
	foreach($cats as $z=>$c){
		if($z == $cid){
			if(isset($cats[$z])){
				foreach($cats[$z] as $d=>$v){
					if(!in_array($v['id'], $arr)){
						$arr[] = $v['id'];
					}
					if(isset($cats[$v['id']])){
						$new = getChildrenCats($cats, $v['id'], $arr);
						foreach($new as $a=>$g){
							if(!in_array($g, $arr)){
								$arr[] = $g;
							}
						}
					}
				}
			}
		}
	}
	return $arr;
}

/*
$link, $page, $pages_num, $sort_url = '', $ext_res = false
*/
function buildUrlArray($arr){
	$n = array();
	foreach ($arr as $key => $value) {
		$n[] = 'search_fields['.$key.']='.rawurlencode($value);
	}
	return implode('&', $n);
}
function pagination(){
	global $page, $content_result, $content_link;

	$link = isset($content_result['link']) ? $content_result['link'] : '/';

	$pages_num = isset($content_result['pages_num']) ? $content_result['pages_num'] : 0;

	$sort_url = (isset($content_result['sort']) AND $content_result['sort']) ? 'sort='.$content_result['sort'] : '';
	if(isset($content_result['search_fields'])) $sort_url .= $content_result['search_fields'] ? ($sort_url ? '&' : '').buildUrlArray($content_result['search_fields']) : '';
	$sort_url .= (isset($content_result['search_text']) AND $content_result['search_text']) ? ($sort_url ? '&' : '').'search_text='.$content_result['search_text'] : '';
	#$sort_url = '';
	$sort1 = $sort_url?'?'.$sort_url:'';
	$sort2 = $sort_url?'&'.$sort_url:'';

	$html = '';

	if ($page != 1) $html .= '<a href="'.$link.($page-1==1 ? $sort1 : '?page='. ($page - 1).$sort2) .'" class="p left" data-id="'. ($page - 1) .'">Previous</a>'; 

	if(($page + 2 > $pages_num) AND $page - 4 > 0) $html .= '<a href="'.$link.($page-4==1 ? $sort1 : '?page='. ($page - 4).$sort2) .'" data-id="'. ($page - 4) .'">'. ($page - 4) .'</a>'; 
	if(($page + 1 > $pages_num) AND $page - 3 > 0) $html .= '<a href="'.$link.($page-3==1 ? $sort1 : '?page='. ($page - 3).$sort2) .'" data-id="'. ($page - 3) .'">'. ($page - 3) .'</a>'; 
	if($page - 2 > 0) $html .= '<a href="'.$link.($page-2==1 ? $sort1 : '?page='. ($page - 2).$sort2) .'" data-id="'. ($page - 2) .'">'. ($page - 2) .'</a>'; 
	if($page - 1 > 0) $html .= '<a href="'.$link.($page-1==1 ? $sort1 : '?page='. ($page - 1).$sort2) .'" data-id="'. ($page - 1) .'">'. ($page - 1) .'</a>'; 

	$html .= '<div class="e active">'.$page.'</div>';

	if($page + 1 <= $pages_num) $html .= '<a href="'.$link.'?page='. ($page + 1).$sort2 .'" data-id="'. ($page + 1) .'">'. ($page + 1) .'</a>';
	if($page + 2 <= $pages_num) $html .= '<a href="'.$link.'?page='. ($page + 2).$sort2 .'" data-id="'. ($page + 2) .'">'. ($page + 2) .'</a>'; 
	if(($page + 3 <= $pages_num) AND $page < 3) $html .= '<a href="'.$link.'?page='. ($page + 3).$sort2 .'" data-id="'. ($page + 3) .'">'. ($page + 3) .'</a>'; 
	if(($page + 4 <= $pages_num) AND $page == 1) $html .= '<a href="'.$link.'?page='. ($page + 4).$sort2 .'" data-id="'. ($page + 4) .'">'. ($page + 4) .'</a>'; 


	if ($page != $pages_num) $html .= '<a href="'.$link.'?page='. ($page + 1).$sort2 .'" class="p right" data-id="'. ($page + 1) .'">Next</a>'; 

	if($content_link){
	#	$html = str_replace('?page', '&page', $html);
	}

	return '<div class="pagi ajax_pagi">'.$html.'</div>'; 

}

function getBreadcrumbs($links){
	global $config;
	$r = '<div class="breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><ul><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><meta itemprop="position" content="1"><a href="/" itemprop="item">'.$config['breadcrumbs_home'].'</a></li>';
	if(count($links)>0){
		$__xi = 1;
		foreach ($links as $key => $value) {
			++$__xi;
			$r .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><meta itemprop="position" content="'.$__xi.'">'.($value['link']?'<a href="'.$value['link'].'" itemprop="item">'.$value['name'].'</a>':'<span class="last">'.$value['name'].'</span>').'</li>';
		}
	}
	$r .= '</ul></div>';
	return $r;
}
function getIP(){
    foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (array_map('trim', explode(',', $_SERVER[$key])) as $ip){
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                    return $ip;
                }
            }
        }
    }
    return 'unknown';
}





function sb_phone($phone){
	return preg_replace('#[^0-9-()]+#', '', $phone);
}

function sb_setcookie($name, $value){
	global $config;
	setcookie($name, $value, time()+365*60*60, "/", '.'.$config['domain']);
}

function sb_delcookie($name){
	global $config;
	setcookie($name, '', time()-365*60*60, "/", $config['domain']);
}

function translit($var) {
	$langtranslit = array(
	'а' => 'a', 'б' => 'b', 'в' => 'v',
	'г' => 'g', 'д' => 'd', 'е' => 'e',
	'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
	'и' => 'i', 'й' => 'y', 'к' => 'k',
	'л' => 'l', 'м' => 'm', 'н' => 'n',
	'о' => 'o', 'п' => 'p', 'р' => 'r',
	'с' => 's', 'т' => 't', 'у' => 'u',
	'ф' => 'f', 'х' => 'h', 'ц' => 'c',
	'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
	'ь' => '', 'ы' => 'y', 'ъ' => '',
	'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
	"ї" => "yi", "є" => "ye",

	'А' => 'A', 'Б' => 'B', 'В' => 'V',
	'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
	'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
	'И' => 'I', 'Й' => 'Y', 'К' => 'K',
	'Л' => 'L', 'М' => 'M', 'Н' => 'N',
	'О' => 'O', 'П' => 'P', 'Р' => 'R',
	'С' => 'S', 'Т' => 'T', 'У' => 'U',
	'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
	'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
	'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
	'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
	"Ї" => "yi", "Є" => "ye", 
	"À"=>"A", "à"=>"a", "Á"=>"A", "á"=>"a", 
	"Â"=>"A", "â"=>"a", "Ä"=>"A", "ä"=>"a", 
	"Ã"=>"A", "ã"=>"a", "Å"=>"A", "å"=>"a", 
	"Æ"=>"AE", "æ"=>"ae", "Ç"=>"C", "ç"=>"c", 
	"Ð"=>"D", "È"=>"E", "è"=>"e", "É"=>"E", 
	"é"=>"e", "Ê"=>"E", "ê"=>"e", "Ì"=>"I", 
	"ì"=>"i", "Í"=>"I", "í"=>"i", "Î"=>"I", 
	"î"=>"i", "Ï"=>"I", "ï"=>"i", "Ñ"=>"N", 
	"ñ"=>"n", "Ò"=>"O", "ò"=>"o", "Ó"=>"O", 
	"ó"=>"o", "Ô"=>"O", "ô"=>"o", "Ö"=>"O", 
	"ö"=>"o", "Õ"=>"O", "õ"=>"o", "Ø"=>"O", 
	"ø"=>"o", "Œ"=>"OE", "œ"=>"oe", "Š"=>"S", 
	"š"=>"s", "Ù"=>"U", "ù"=>"u", "Û"=>"U", 
	"û"=>"u", "Ú"=>"U", "ú"=>"u", "Ü"=>"U", 
	"ü"=>"u", "Ý"=>"Y", "ý"=>"y", "Ÿ"=>"Y", 
	"ÿ"=>"y", "Ž"=>"Z", "ž"=>"z", "Þ"=>"B", 
	"þ"=>"b", "ß"=>"ss", "£"=>"pf", "¥"=>"ien", 
	"ð"=>"eth", "ѓ"=>"r"
	);
	
	if ( is_array($var) ) return "";

	$var = str_replace(chr(0), '', $var);
	
	$var = trim( strip_tags( $var ) );
	$var = preg_replace( "/\s+/u", "-", $var );
	$var = str_replace( "/", "-", $var );
	
	$var = strtr($var, $langtranslit);

	$var = preg_replace( "/[^a-z0-9\_\-]+/mi", "", $var );

	$var = preg_replace( '#[\-]+#i', '-', $var );
	$var = preg_replace( '#[.]+#i', '.', $var );

	$var = strtolower( $var );

	$var = str_ireplace( ".php", "", $var );
	$var = str_ireplace( ".php", ".ppp", $var );

	if( strlen( $var ) > 200 ) {
		
		$var = substr( $var, 0, 200 );
		
		if( ($temp_max = strrpos( $var, '-' )) ) $var = substr( $var, 0, $temp_max );
	
	}
	
	return $var;
}




?>