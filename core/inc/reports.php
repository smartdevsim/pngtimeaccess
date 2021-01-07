<?php
if(!defined('DARQ')) die();

#$content_result = getUser();

//----
$date = isset($_GET['date']) ? trim(strip_tags($_GET['date'])) : '';
$date_s = '';
if($date){
	$_date = explode('/', $date);
	if(count($_date) == 3){
		$date_s = $_date[1].'/'.$_date[0].'/'.$_date[2];
	}
}
$str_date = ($date_s?strtotime($date_s):time());
//----

//----
$monday_time = strtotime('monday this week');
$prev_monday_time = strtotime('previous monday');
$sunday_time = strtotime('sunday this week');
$prev_sunday_time = strtotime('previous sunday');
$monday = date('d/m/Y', $monday_time);
$sunday = date('d/m/Y', $sunday_time);	
$prev_monday = date('d/m/Y', $prev_monday_time);
$prev_sunday = date('d/m/Y', $prev_sunday_time);
//----

//----
$monday_2wa_time = strtotime('this Monday -7 day');
$sunday_2wa_time = strtotime('this Sunday');
$prev_monday_2wa_time = strtotime('this Monday -21 day');
$prev_sunday_2wa_time = strtotime('this Sunday -14 day');
$monday_2wa = date('d/m/Y', $monday_2wa_time);
$sunday_2wa = date('d/m/Y', $sunday_2wa_time);	
$prev_monday_2wa = date('d/m/Y', $prev_monday_2wa_time);
$prev_sunday_2wa = date('d/m/Y', $prev_sunday_2wa_time);
//----


$picker = '';
$pw_val = '';
$pw_val_id = '';
if($sub_route == 'daily'){
	$picker = '<input type="text" id="daily-report-date" class="report-date-input" value="'.date('d/m/Y', $str_date).'" />';
} elseif($sub_route == 'weekly'){
	$cur_week_name = 'Current week ('.$monday.' - '.$sunday.')';
	$prev_week_name = 'Previous week ('.$prev_monday.' - '.$prev_sunday.')';
	$wp = isset($_GET['wp']) ? trim(strip_tags($_GET['wp'])) : '';
	if(!$wp OR $wp == 'current'){
		$pw_val = $cur_week_name;
		$pw_val_id = 'current';
	} elseif($wp == 'previous'){
		$pw_val = $prev_week_name;
		$pw_val_id = 'previous';
	}
	$picker = ' <div class="date-custom-picker" data-id="weekly"><div class="pw-value">'.$pw_val.'</div><div class="list"><div class="pw" data-wp="current">'.$cur_week_name.'</div><div class="pw" data-wp="previous">'.$prev_week_name.'</div></div></div>';
} elseif($sub_route == 'fortnightly'){
	$cur_fortnight_name = 'Current fortnight ('.$monday_2wa.' - '.$sunday_2wa.')';
	$prev_fortnight_name = 'Previous fortnight ('.$prev_monday_2wa.' - '.$prev_sunday_2wa.')';
	$wp = isset($_GET['wp']) ? trim(strip_tags($_GET['wp'])) : '';
	if(!$wp OR $wp == 'current'){
		$pw_val = $cur_fortnight_name;
		$pw_val_id = 'current';
	} elseif($wp == 'previous'){
		$pw_val = $prev_fortnight_name;
		$pw_val_id = 'previous';
	}
	$picker = ' <div class="date-custom-picker" data-id="fortnightly"><div class="pw-value">'.$pw_val.'</div><div class="list"><div class="pw" data-wp="current">'.$cur_fortnight_name.'</div><div class="pw" data-wp="previous">'.$prev_fortnight_name.'</div></div></div>';
} elseif($sub_route == 'monthly'){
	$wp = isset($_GET['wp']) ? trim(strip_tags($_GET['wp'])) : '';
	if(!$wp OR $wp == 'current'){
		$pw_val = date('m');
		$pw_val_id = 'current';
	} else {
		$pw_val = intval($wp);
		$pw_val = $pw_val<10?'0'.$pw_val:$pw_val;
	}
	$picker = ' <div class="date-custom-picker" data-id="monthly"><div class="pw-value">'.date('F', strtotime(date('Y-').$pw_val.'-01')).'</div><div class="list" style="width: auto">';
	$dateTime = new DateTime();
	$picker .= '<div class="pw" data-wp="'.$dateTime->format('m').'">'.$dateTime->format('F').'</div>';
	$dateTime->modify('-1 month');
	while($dateTime->format('m') != 12){
	    $picker .= '<div class="pw" data-wp="'.$dateTime->format('m').'">'.$dateTime->format('F').'</div>';
	    $dateTime->modify('-1 month');
	}
	$picker .= '</div></div>';
}

$content = '
<div class="content-wrapper">

<div id="reports" class="">

<div id="content-msg"></div>

<div class="content-top-nav">
	<h1>'.($sub_route == '' ? 'Reports' : ucfirst($sub_route).' Attendance Report 
		<span style="margin-left: 15px;">&mdash;</span>'.$picker).'</h1>
</div>

';
if($sub_route == ''){
	$content .= '<div class="content-inner-fragment"><div class="neo-list">
	<ul>
		<li><a href="/reports/daily/">Daily Attendance Report</a></li>
		<li><a href="/reports/weekly/">Weekly Attendance Report</a></li>
		<li><a href="/reports/fortnightly/">Fortnightly Attendance Report</a></li>
		<li><a href="/reports/monthly/">Monthly Attendance Report</a></li>
	</ul>
</div></div>';
} else {

	$base_th = '<th class="th-numid">No.</th><th>Position number</th><th>Position title</th><th>Business Unit</th><th>Employee Number</th><th>Surname</th><th>Given Name</th>';

	if($sub_route == 'daily'){

		$arr = array();
		$user_data = array();

		$db->query("
			SELECT *, user_pass.postdate as pass_postdate
			FROM user_pass 
			LEFT JOIN users ON users.id = user_pass.user_id 
			WHERE 1 
				AND postdate_datetime >= '".date('Y-m-d', $str_date)." 00:00:00' AND postdate_datetime <= '".date('Y-m-d', $str_date)." 23:59:59'
			 ".(is_admin() ? '' : " AND users.author_id = ".$_SESSION['user_id'])
		);
		while($row = $db->get_row()){
			$arr[$row['user_id']][$row['type_pass']] = $row;
			$user_data[$row['user_id']] = $row;
		}

		#echo '<pre>';print_r($arr);exit;

		$content .= '<table class="default-table">
		<thead><tr>'.$base_th.'<th>Clock-in</th><th>Clock-out</th><th>Total Hours</th></tr></thead>
		<tbody id="table-body">';

		$i = 0;
		foreach ($arr as $key => $value) {
			++$i;
			$dif = (isset($arr[$key]['checkin']) AND isset($arr[$key]['checkout'])) ? $arr[$key]['checkout']['pass_postdate'] - $arr[$key]['checkin']['pass_postdate'] : '';
			$content .= '<tr>
			<td>'.$i.'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_title'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['business_unit'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['employee_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['last_name'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['first_name'], ENT_QUOTES).'</td>
			<td>'.(isset($arr[$key]['checkin']) ? date('H:i:s', strtotime($arr[$key]['checkin']['postdate_datetime'])) : '&mdash;').'</td>
			<td>'.(isset($arr[$key]['checkout']) ? date('H:i:s', strtotime($arr[$key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>
			<td>'.($dif ? getWorkedTime($dif) : '&mdash;').'</td>
			</tr>';
		}

		$content .= '
		</tbody></table>';

	} elseif($sub_route == 'weekly'){

		$arr = array();
		$user_data = array();

		$th_time_str = ($pw_val_id == 'previous' ? $prev_monday_time : $monday_time);
		$th_time_str2 = ($pw_val_id == 'previous' ? $prev_sunday_time : $sunday_time);

		$db->query("
			SELECT *, user_pass.postdate as pass_postdate
			FROM user_pass 
			LEFT JOIN users ON users.id = user_pass.user_id 
			WHERE 1 
				AND postdate_datetime >= '".date('Y-m-d', $th_time_str)." 00:00:00' AND postdate_datetime <= '".date('Y-m-d', $th_time_str2)." 23:59:59'
			 ".(is_admin() ? '' : " AND users.author_id = ".$_SESSION['user_id'])
		);
		while($row = $db->get_row()){
			$day = explode(' ', $row['postdate_datetime']);
			$arr[$row['user_id']][$day[0]][$row['type_pass']] = $row;
			$user_data[$row['user_id']] = $row;
		}

		#echo '<pre>';print_r($arr);exit;
		$content .= '<table class="default-table">
		<thead><tr>'.$base_th.'
		<th class="th-wt"><span>Mon '.date('d/m', $th_time_str).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Tue '.date('d/m', $th_time_str+86400*1).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Wed '.date('d/m', $th_time_str+86400*2).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Thu '.date('d/m', $th_time_str+86400*3).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Fri '.date('d/m', $th_time_str+86400*4).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sat '.date('d/m', $th_time_str+86400*5).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sun '.date('d/m', $th_time_str+86400*6).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th>Total Hours</th></tr></thead>
		<tbody id="table-body">';

		$i = 0;
		foreach ($arr as $key => $value) {

			++$i;
			$total = 0;
			$content .= '<tr>
			<td>'.$i.'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_title'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['business_unit'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['employee_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['last_name'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['first_name'], ENT_QUOTES).'</td>';
				for($z=0;$z<=6;++$z){
					$day_key = date('Y-m-d', $th_time_str+86400*$z);

					$dif = (isset($arr[$key][$day_key]['checkin']) AND isset($arr[$key][$day_key]['checkout'])) ? $arr[$key][$day_key]['checkout']['pass_postdate'] - $arr[$key][$day_key]['checkin']['pass_postdate'] : 0;
					$total += $dif;
					$content .= '<td>'.(isset($arr[$key][$day_key]['checkin']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkin']['postdate_datetime'])) : '&mdash;').' &mdash; '.(isset($arr[$key][$day_key]['checkout']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>';

			}
			$content .= '
			<td>'.($total ? getWorkedTime($total) : '&mdash;').'</td>
			</tr>';
		}

		$content .= '
		</tbody></table>';

	} elseif($sub_route == 'fortnightly'){

		$arr = array();
		$user_data = array();

		$th_time_str = ($pw_val_id == 'previous' ? $prev_monday_2wa_time : $monday_2wa_time);
		$th_time_str2 = ($pw_val_id == 'previous' ? $prev_sunday_2wa_time : $sunday_2wa_time);

		$db->query("
			SELECT *, user_pass.postdate as pass_postdate
			FROM user_pass 
			LEFT JOIN users ON users.id = user_pass.user_id 
			WHERE 1 
				AND postdate_datetime >= '".date('Y-m-d', $th_time_str)." 00:00:00' AND postdate_datetime <= '".date('Y-m-d', $th_time_str2)." 23:59:59'
			 ".(is_admin() ? '' : " AND users.author_id = ".$_SESSION['user_id'])
		);
		while($row = $db->get_row()){
			$day = explode(' ', $row['postdate_datetime']);
			$arr[$row['user_id']][$day[0]][$row['type_pass']] = $row;
			$user_data[$row['user_id']] = $row;
		}

		#echo '<pre>';print_r($arr);exit;
		$content .= '<table class="default-table">
		<thead><tr>'.$base_th.'
		<th class="th-wt"><span>Mon '.date('d/m', $th_time_str).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Tue '.date('d/m', $th_time_str+86400*1).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Wed '.date('d/m', $th_time_str+86400*2).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Thu '.date('d/m', $th_time_str+86400*3).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Fri '.date('d/m', $th_time_str+86400*4).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sat '.date('d/m', $th_time_str+86400*5).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sun '.date('d/m', $th_time_str+86400*6).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Mon '.date('d/m', $th_time_str+86400*7).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Tue '.date('d/m', $th_time_str+86400*8).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Wed '.date('d/m', $th_time_str+86400*9).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Thu '.date('d/m', $th_time_str+86400*10).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Fri '.date('d/m', $th_time_str+86400*11).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sat '.date('d/m', $th_time_str+86400*12).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th class="th-wt"><span>Sun '.date('d/m', $th_time_str+86400*13).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>
		<th>Total Hours</th></tr></thead>
		<tbody id="table-body">';

		$i = 0;
		foreach ($arr as $key => $value) {

			++$i;
			$total = 0;
			$content .= '<tr>
			<td>'.$i.'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_title'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['business_unit'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['employee_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['last_name'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['first_name'], ENT_QUOTES).'</td>';
			
			for($z=0;$z<=13;++$z){
					$day_key = date('Y-m-d', $th_time_str+86400*$z);

					$dif = (isset($arr[$key][$day_key]['checkin']) AND isset($arr[$key][$day_key]['checkout'])) ? $arr[$key][$day_key]['checkout']['pass_postdate'] - $arr[$key][$day_key]['checkin']['pass_postdate'] : 0;
					$total += $dif;
					$content .= '<td>'.(isset($arr[$key][$day_key]['checkin']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkin']['postdate_datetime'])) : '&mdash;').' &mdash; '.(isset($arr[$key][$day_key]['checkout']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>';
			}

			$content .= '
			<td>'.($total ? getWorkedTime($total) : '&mdash;').'</td>
			</tr>';
		}

		$content .= '
		</tbody></table>';
	} elseif($sub_route == 'monthly'){

		$arr = array();
		$user_data = array();
		$selected_ts = strtotime(date('Y').'-'.$pw_val.'-01');
		$selected_ts2 = strtotime(date('Y').'-'.$pw_val.'-'.date('t', $selected_ts));

		$db->query("
			SELECT *, user_pass.postdate as pass_postdate
			FROM user_pass 
			LEFT JOIN users ON users.id = user_pass.user_id 
			WHERE 1 
				and postdate_datetime between '".date('Y-m-d', $selected_ts)."' and '".date('Y-m-d', strtotime('+1 month', $selected_ts))."'
			 ".(is_admin() ? '' : " AND users.author_id = ".$_SESSION['user_id'])
		);
		while($row = $db->get_row()){
			$day = explode(' ', $row['postdate_datetime']);
			$arr[$row['user_id']][$day[0]][$row['type_pass']] = $row;
			$user_data[$row['user_id']] = $row;
		}

		#echo '<pre>';print_r(date('D d/m', $selected_ts2));exit;
		$content .= '<table class="default-table">
		<thead><tr>'.$base_th;
		for($i=1;$i<=date('t', $selected_ts);$i++){
			$sts = strtotime(date('Y').'-'.$pw_val.'-'.($i<10?'0'.$i:$i));
			$content .= '<th class="th-wt"><span>'.date('D d/m', $sts).'</span><div>Clock-in &nbsp; &middot; &nbsp; Clock-out</div></th>';
	    }
		
		$content .= '
		<th>Total Hours</th></tr></thead>
		<tbody id="table-body">';

		$xx = 0;
		foreach ($arr as $key => $value) {

			++$xx;
			$total = 0;
			$content .= '<tr>
			<td>'.$xx.'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['position_title'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['business_unit'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['employee_number'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['last_name'], ENT_QUOTES).'</td>
			<td>'.htmlspecialchars($user_data[$key]['first_name'], ENT_QUOTES).'</td>';
			for($i=1;$i<=date('t', $selected_ts);$i++){
				$sts = strtotime(date('Y').'-'.$pw_val.'-'.($i<10?'0'.$i:$i));
				$day_key = date('Y-m-d', $sts);
				$dif = (isset($arr[$key][$day_key]['checkin']) AND isset($arr[$key][$day_key]['checkout'])) ? $arr[$key][$day_key]['checkout']['pass_postdate'] - $arr[$key][$day_key]['checkin']['pass_postdate'] : 0;
				$total += $dif;
				$content .= '<td>'.(isset($arr[$key][$day_key]['checkin']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkin']['postdate_datetime'])) : '&mdash;').' &mdash; '.(isset($arr[$key][$day_key]['checkout']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>';
		    }
/*

			for($z=0;$z<=13;++$z){
					$day_key = date('Y-m-d', $th_time_str+86400*$z);

					$dif = (isset($arr[$key][$day_key]['checkin']) AND isset($arr[$key][$day_key]['checkout'])) ? $arr[$key][$day_key]['checkout']['pass_postdate'] - $arr[$key][$day_key]['checkin']['pass_postdate'] : 0;
					$total += $dif;
					$content .= '<td>'.(isset($arr[$key][$day_key]['checkin']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkin']['postdate_datetime'])) : '&mdash;').' &mdash; '.(isset($arr[$key][$day_key]['checkout']) ? date('H:i:s', strtotime($arr[$key][$day_key]['checkout']['postdate_datetime'])) : '&mdash;').'</td>';
			}*/

			$content .= '
			<td>'.($total ? getWorkedTime($total) : '&mdash;').'</td>
			</tr>';
		}

		$content .= '
		</tbody></table>';
	}

}

$content .= '
</div>

';



$content .= '


</div>
';



?>