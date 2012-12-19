<?php
/*
  * Holds the Main functions
  * @package WP-Trader
  * @subpackage Template
  */
//End get some required files for the plugin to function correctly
global $wpdb, $current_user;
if ( is_user_logged_in() ) {
	get_currentuserinfo();
	$ip = $_SERVER["REMOTE_ADDR"];
	update_user_meta($current_user->ID, 'wptrader_ip', $ip);
}
function get_date_time($timestamp = 0){
	if ($timestamp)
		return date("Y-m-d H:i:s", $timestamp);
	else
		return gmdate("Y-m-d H:i:s");
}
function sql_timestamp_to_unix_timestamp($s){
	return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}
function gmtime() {
	return sql_timestamp_to_unix_timestamp(get_date_time());
}
//Add users ip to user meta for ip tracking on announce
function wptrader_update($errorheader, $errormessage){
	$return_update = new WP_Error('broke', __("<strong>".$errorheader."</strong>: ".$errormessage.""));
	echo "<div id='message' class='updated'><center>".$return_update->get_error_message()."</center></div>";
}
function get_current_user_role(){
	global $wp_roles;
	$current_user = wp_get_current_user();
	$roles = $current_user->roles;
	$role = array_shift($roles);
	return isset($wp_roles->role_names[$role]) ? translate_user_role($wp_roles->role_names[$role] ) : false;
}
function get_user_role(){
	global $current_user;

	$user_roles = $current_user->roles;
	$user_role = array_shift($user_roles);

	return $user_role;
}
function CutName($vTxt, $Car){
	if (strlen($vTxt) > $Car) {
		return substr($vTxt, 0, $Car) . "...";
	}
	return $vTxt;
}
function mksize($s, $precision = 2){
	$suf = array("B", "kB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB");

	for ($i = 1, $x = 0; $i <= count($suf); $i++, $x++) {
		if ($s < pow(1024, $i) || $i == count($suf)) // Change 1024 to 1000 if you want 0.98GB instead of 1,0000MB
			return number_format($s/pow(1024, $x), $precision)." ".$suf[$x];
	}
}
function health($leechers, $seeders){
	$ratio = @($seeders / $leechers * 100);
	switch (TRUE) {
		case ($leechers == 0 && $seeders == 0):return 0;
		case ($seeders > $leechers):return 10;
		case ($ratio > 0 && $ratio < 15):return 1;
		case ($ratio >= 15 && $ratio < 25):return 2;
		case ($ratio >= 25 && $ratio < 35):return 3;
		case ($ratio >= 35 && $ratio < 45):return 4;
		case ($ratio >= 45 && $ratio < 55):return 5;
		case ($ratio >= 55 && $ratio < 65):return 6;
		case ($ratio >= 65 && $ratio < 75):return 7;
		case ($ratio >= 75 && $ratio < 85):return 8;
		case ($ratio >= 85 && $ratio < 95):return 9;
		default:return 10;
	}
}
function count_torrent_no_seeders(){
	$seeders = count(query_posts('meta_key=seeders&meta_value=0'));
	return $seeders;
}
function count_torrent_no_leechers(){
	$leechers = count(query_posts('meta_key=leechers&meta_value=0'));
	return $leechers;
}
function escape_url($url) {
	$ret = '';
	for($i = 0; $i < strlen($url); $i+=2)
	$ret .= '%'.$url[$i].$url[$i + 1];
	return $ret;
}
function torrent_table_template($columns, $char, $limit, $order, $type) {
	global $current_user, $wpdb, $wp_rewrite;
		
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$(".showExpandplus").click(function(){
				var id = $(this).attr("id");
				$("#itemDetail" + id).show();
				$("#showPlus" + id).hide();
				$("#showMinus" + id).show();
			});
			$(".showExpandminus").click(function(){
				var id = $(this).attr("id");
				$("#itemDetail" + id).hide();
				$("#showMinus" + id).hide();
				$("#showPlus" + id).show();
			});
		});
	</script>
	<?php
	$torrent_table = "id, post_id, announce, category, nfo, name, size, numfiles, filename, owner";
		
	$current = (intval(get_query_var('paged'))) ? intval(get_query_var('paged')) : 1;
		
	$pag = $wpdb->get_results("SELECT " . $torrent_table ." FROM " . TRADER_TORRENTS . " $order");
		
	$pagination_args = array(
		'base' => @add_query_arg('paged','%#%'),
		'format' => '',
		'total' => ceil(sizeof($pag)/$limit),
		'current' => $current,
		'show_all' => false,
		'type' => 'plain',
	);

	if( $wp_rewrite->using_permalinks() )
		$pagination_args['base'] = user_trailingslashit( trailingslashit( remove_query_arg('s',get_pagenum_link(1) ) ) . 'page/%#%/', 'paged');
 
	if( !empty($wp_query->query_vars['s']) )
		$pagination_args['add_args'] = array('s'=>get_query_var('s'));
		
	if (wp_trader_options("members_only_wait_yes") && wp_trader_options("members_only_yes") && in_array(get_user_role(), explode("|",get_option('torrent_roles')))) {
		$gigs = get_user_meta($current_user->ID, 'trader_upload', true) / (1024*1024*1024);
		$ratio = ((get_user_meta($current_user->ID, 'trader_download', true) > 0) ? (get_user_meta($current_user->ID, 'trader_upload', true) / get_user_meta($current_user->ID, 'trader_download', true)) : 0);
		if ($ratio < 0 || $gigs < 0) $wait = get_option('minimum_waita');
		elseif ($ratio < get_option('minimum_ratioa') || $gigs < get_option('minimum_gigsa')) $wait = get_option('minimum_waita');
		elseif ($ratio < get_option('minimum_ratiob') || $gigs < get_option('minimum_gigsb')) $wait = get_option('minimum_waitb');
		elseif ($ratio < get_option('minimum_ratioc') || $gigs < get_option('minimum_gigsc')) $wait = get_option('minimum_waitc');
		elseif ($ratio < get_option('minimum_ratiod') || $gigs < get_option('minimum_gigsd')) $wait = get_option('minimum_waitd');
		else $wait = 0;
	}

	// Columns
	$cols = explode(",", $columns);
	$cols = array_map("strtolower", $cols);
	$cols = array_map("trim", $cols);
	$colspan = count($cols);
	// End
	
	// Expanding Area
	$expandrows = array();
	//if (!empty(get_option('torrenttable_expand')) {
		$expandrows = explode(",", get_option('torrenttable_expand'));
		$expandrows = array_map("strtolower", $expandrows);
		$expandrows = array_map("trim", $expandrows);
	//}
	// End
		
	$torrent_table_template .= "<center>" . paginate_links($pagination_args) . "</center><br />";
		
	$start = ($current - 1) * $limit;
	$end = $start + $limit;
	$end = (sizeof($pag) < $end) ? sizeof($pag) : $end;

	$torrent_table_template .= "<table align='center' cellpadding='0' cellspacing='0' class='ttable_headinner' width='99%'>";
	if(get_option('torrent_header_footer') == 1 || get_option('torrent_header_footer') == 2){
		$torrent_table_template .= '<thead><tr>';

		foreach ($cols as $col) {
			switch ($col) {
				case 'category':
					$torrent_table_template .= "<th class='ttable_head'>Type</th>";
				break;
				case 'name':
					$torrent_table_template .= "<th class='ttable_head'>Name</th>";
				break;
				case 'dl':
					$torrent_table_template .= "<th class='ttable_head'>DL</th>";
				break;
				case 'uploader':
					$torrent_table_template .= "<th class='ttable_head'>Uploader</th>";
				break;
				case 'comments':
					$torrent_table_template .= "<th class='ttable_head'>Comm</th>";
				break;
				case 'nfo':
					$torrent_table_template .= "<th class='ttable_head'>NFO</th>";
				break;
				case 'size':
					$torrent_table_template .= "<th class='ttable_head'>Size</th>";
				break;
				case 'completed':
					$torrent_table_template .= "<th class='ttable_head'>C</th>";
				break;
				case 'seeders':
					$torrent_table_template .= "<th class='ttable_head'>S</th>";
				break;
				case 'leechers':
					$torrent_table_template .= "<th class='ttable_head'>L</th>";
				break;
				case 'health':
					$torrent_table_template .= "<th class='ttable_head'>Health</th>";
				break;
				case 'external':
					if (wp_trader_options("allow_external_yes"))
						$torrent_table_template .= "<th class='ttable_head'>L/E</th>";
				break;
				case 'added':
					$torrent_table_template .= "<th class='ttable_head'>Added</th>";
				break;
				case 'speed':
					$torrent_table_template .= "<th class='ttable_head'>Speed</th>";
				break;
				case 'wait':
					if ($wait)
						$torrent_table_template .= "<th class='ttable_head'>".T_("WAIT")."</th>";
				break;
			}
		}
		if ($wait && !in_array("wait", $cols))
			$torrent_table_template .= "<th class='ttable_head'>Wait</th>";
	
			$torrent_table_template .= "</tr></thead>";
	}
	if(get_option('torrent_header_footer') == 0 || get_option('torrent_header_footer') == 2){
		$torrent_table_template .= '<tfoot><tr>';

		foreach ($cols as $col) {
			switch ($col) {
				case 'category':
					$torrent_table_template .= "<th class='ttable_head'>Type</th>";
				break;
				case 'name':
					$torrent_table_template .= "<th class='ttable_head'>Name</th>";
				break;
				case 'dl':
					$torrent_table_template .= "<th class='ttable_head'>DL</th>";
				break;
				case 'uploader':
					$torrent_table_template .= "<th class='ttable_head'>Uploader</th>";
				break;
				case 'comments':
					$torrent_table_template .= "<th class='ttable_head'>Comm</th>";
				break;
				case 'nfo':
					$torrent_table_template .= "<th class='ttable_head'>NFO</th>";
				break;
				case 'size':
					$torrent_table_template .= "<th class='ttable_head'>Size</th>";
				break;
				case 'completed':
					$torrent_table_template .= "<th class='ttable_head'>C</th>";
				break;
				case 'seeders':
					$torrent_table_template .= "<th class='ttable_head'>S</th>";
				break;
				case 'leechers':
					$torrent_table_template .= "<th class='ttable_head'>L</th>";
				break;
				case 'health':
					$torrent_table_template .= "<th class='ttable_head'>Health</th>";
				break;
				case 'external':
					if (wp_trader_options("allow_external_yes"))
						$torrent_table_template .= "<th class='ttable_head'>L/E</th>";
				break;
				case 'added':
					$torrent_table_template .= "<th class='ttable_head'>Added</th>";
				break;
				case 'speed':
					$torrent_table_template .= "<th class='ttable_head'>Speed</th>";
				break;
				case 'wait':
					if ($wait)
						$torrent_table_template .= "<th class='ttable_head'>".T_("WAIT")."</th>";
				break;
			}
		}
		if ($wait && !in_array("wait", $cols))
			$torrent_table_template .= "<th class='ttable_head'>Wait</th>";
	
		$torrent_table_template .= "</tr></tfoot><tbody>";
	}
	for ($i=$start;$i < $end ;++$i ) {
		$row = $pag[$i];
		$id = $row->id;
		$post_ids = $row->post_id;
		$torrent_table_template .= "<tr>";

		$x = 1;
		$torrent_leechers = get_post_meta($post_ids, "leechers", true);
		$torrent_seeders = get_post_meta($post_ids, "seeders", true);
		$torrent_external = get_post_meta($post_ids, "external", true);
			
		if($type == "seed_wanted_torrents_list"){
			$torrent_seeders_swtll = ($torrent_seeders == 0);
			$torrent_leechers_swtl = ($torrent_leechers != 0);
		}elseif($type == "most_active_list"){
			$torrent_seeders_mall = ($torrent_seeders != 0);
			$torrent_leechers_mal = ($torrent_leechers != 0);
		}elseif($type == "latest_uploaded_torrents_list" || $type == "torrent_list"){
			$torrent_seederss = ($torrent_seeders != 0 || $torrent_leechers == "" || $torrent_seeders == 0);
			$torrent_leechers = ($torrent_leechers != 0 || $torrent_seeders == "" || $torrent_leechers == 0);
		}
			
		if(($torrent_seederss || $torrent_leechers) || ($torrent_seeders_mall || $torrent_leechers_mal && (get_option('most_active_external') == $torrent_external)) || ($torrent_seeders_swtll && $torrent_leechers_swtl && (get_option('seed_wanted_external') == $torrent_external)))
			foreach ($cols as $col) {
			$post_id = get_post($post_ids);
			$post_author = $post_id->post_author;
			$post_added = $post_id->post_date;
			$post_comment = $post_id->comment_count;
			$post_url = $post_id->guid;
		
			$user_info = get_userdata($post_author);
			$username = $user_info->user_nicename;
			$user_id = $user_info->ID;
		
			$torrent_external_yes = get_post_meta($post_ids, "external", true) == 1;
			$torrent_external_no = get_post_meta($post_ids, "external", true) == 0;
			$freeleech_yes = get_post_meta($post_ids, "freeleech", true) == 1;
			$freeleech_no = get_post_meta($post_ids, "freeleech", true) == 0;
			$anon_yes = get_post_meta($post_ids, "anon", true) == 1;
			$anon_no = get_post_meta($post_ids, "anon", true) == 0;
		
			switch ($col) {
				case 'category':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>";
					if (!empty($row->cat_name)) {
						$torrent_table_template .= "<a href='" . WP_TRADER_PLUGIN_URL . "templates/torrents.php?cat=" . $row->category . "'>";
					if (!empty($row->cat_pic) && $row->cat_pic != "")
						$torrent_table_template .= "<img border='0' src='" . WP_TRADER_PLUGIN_URL . "/css/image/" . $row->cat_pic . "' alt='" . $row->cat_name . "' />";
					else
						$torrent_table_template .= $row->cat_parent.": ".$row->cat_name;
						$torrent_table_template .= "</a>";
					} else
					$torrent_table_template .= "-";
					$torrent_table_template .= "</td>";
				break;
				case 'name':
					$char1 = $char; //cut name length 
					$smallname = htmlspecialchars(CutName($row->name, $char1));
					$dispname = "<b>".$smallname."</b>";
					//$last_access = $CURUSER["last_browse"];
					//$time_now = gmtime();
					//if ($last_access > $time_now || !is_numeric($last_access))
						//$last_access = $time_now;
					//if (sql_timestamp_to_unix_timestamp($row["added"]) >= $last_access)
						//$dispname .= "<b><font color=red> - (".T_("NEW")."!)</font></b>";

					if ($freeleech_yes)
						$dispname .= " <img src='" . WP_TRADER_PLUGIN_URL . "css/images/free.gif' border='0'>";
						$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>".(count($expandrows)?"<div align='left' id='".$type.$row->id."' class='showExpandplus'><img border='0' src='" . WP_TRADER_PLUGIN_URL . "css/images/plus.png' id='showPlus".$type.$row->id."' alt='Show' class='showPlus'></div><div align='left' id='".$type.$row->id."' class='showExpandminus'><img border='0' src='" . WP_TRADER_PLUGIN_URL . "css/images/minus.png' id='showMinus".$type.$row->id."' alt='Hide' class='showMinus' style='display: none;'></div>":"")."&nbsp;<a title='".$row->name."' href='" . $post_url . "'>$dispname</a>";
				break;
				case 'dl':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><a href='" . WP_TRADER_PLUGIN_URL . "download.php?id=$id&name=" . rawurlencode($row->filename) . "'><img src='" . WP_TRADER_PLUGIN_URL . "css/images/icon_download.gif' border='0' alt='Download .torrent'></a></td>";
				break;
				case 'uploader':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>";
					if ($anon_yes) //try to implement later || $row["privacy"] == "strong") && $CURUSER["id"] != $row["owner"] && $CURUSER["edit_torrents"] != "yes"
						$torrent_table_template .= "Anonymous";
					elseif ($username)
						$torrent_table_template .= "<a href='" . get_bloginfo( siteurl ) . "/wp-admin/profile.php?user_id=$user_id'>$username</a>";
					else
						$torrent_table_template .= "Unknown";
					$torrent_table_template .= "</td>";
				break;
				case 'comments':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><font size='1' face='Verdana'><a href='" . $post_url . "#comments'>" . $post_comment . "</a></td>";
				break;
				case 'nfo':
					if ($row->nfo == "yes")
						$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><a href='" . WP_TRADER_PLUGIN_URL . "templates/nfo-view.php?id=$row[id]'><img src='" . WP_TRADER_PLUGIN_URL . "css/images/icon_nfo.gif' border='0' alt='View NFO'></a></td>";
					else
						$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>-</td>";
				break;
				case 'size':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>".mksize($row->size)."</td>";
				break;
				case 'completed':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><font color='orange'><b>".number_format($row->times_completed)."</B></font></td>";
				break;
				case 'seeders':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><b><font color='green'><b>".number_format(get_post_meta($post_ids, "seeders", true))."</b></font></td>";
				break;
				case 'leechers':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><font color='red'><b>" . number_format(get_post_meta($post_ids, "leechers", true)) . "</b></font></td>";
				break;
				case 'health':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><img src='" . WP_TRADER_PLUGIN_URL . "css/images/health_".health(get_post_meta($post_ids, "leechers", true), get_post_meta($post_ids, "seeders", true)).".gif'></td>";
				break;
				case 'external':					
					if (wp_trader_options("allow_external_yes")){
						if ($torrent_external_yes)
							$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>E</td>";
						else
							$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>L</td>";
					}
				break;
				case 'added':
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>".$post_added."</td>";
				break;
				case 'speed':
					if ($torrent_external_no && $row->leechers >= 1){
						$speedQ = mysql_query("SELECT (SUM(downloaded)) / (UNIX_TIMESTAMP('".get_date_time()."') - UNIX_TIMESTAMP(started)) AS totalspeed FROM peers WHERE seeder = 'no' AND torrent = '$id'ORDER BY started ASC") or die(mysql_error());
						$a = mysql_fetch_assoc($speedQ);
						$totalspeed = mksize($a->totalspeed) . "/s";
					} else
						$totalspeed = "--";
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>$totalspeed</td>";
				break;
				case 'wait':
					if ($wait){
						$elapsed = floor((gmtime() - strtotime($row->added)) / 3600);
						if ($elapsed < $wait && $torrent_external_no) {
							$color = dechex(floor(127*($wait - $elapsed)/48 + 128)*65536);
							$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><a href='" . WP_TRADER_PLUGIN_URL . "templates/faq.php'><font color='$color'>" . number_format($wait - $elapsed) . " h</font></a></td>";
						} else
							$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>--</td>";
					}
				break;
			}
			if ($x == 2)
				$x--;
			else
				$x++;
		}

	
			//Wait Time Check
			if ($wait && !in_array("wait", $cols)) {
				$elapsed = floor((gmtime() - strtotime($row->added)) / 3600);
				if ($elapsed < $wait && $torrent_external_no) {
					$color = dechex(floor(127*($wait - $elapsed)/48 + 128)*65536);
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'><a href='" . WP_TRADER_PLUGIN_URL . "templates/faq.php'><font color='$color'>" . number_format($wait - $elapsed) . " h</font></a></td>";
				} else
					$torrent_table_template .= "<td class='ttable_col$x' align='center' valign='middle'>--</td>";
				$colspan++;
				if ($x == 2)
					$x--;
				else
					$x++;
			}
			$torrent_table_template .= "</tr>";
			//Expanding area
			if (count($expandrows)) {
					$col_span = $colspan / 1;
				$torrent_table_template .= "<tr id='itemDetail".$type.$row->id."' style='margin-left: 2px; display: none;'><td colspan='".$col_span."' align='center'>";
				foreach ($expandrows as $expandrow) {
					switch ($expandrow) {
						case 'size':
							$torrent_table_template .= "<b>Size</b>: ".mksize($row->size)."<br />";
						break;
						case 'speed':
							if ($torrent_external_no && $row->leechers >= 1){
								$speedQ = mysql_query("SELECT (SUM(downloaded)) / (UNIX_TIMESTAMP('".get_date_time()."') - UNIX_TIMESTAMP(started)) AS totalspeed FROM peers WHERE seeder = 'no' AND torrent = '$id'ORDER BY started ASC") or die(mysql_error());
								$a = mysql_fetch_assoc($speedQ);
								$totalspeed = mksize($a->totalspeed) . "/s";
								$torrent_table_template .= "<b>Speed:</b> $totalspeed<br />";
							}
						break;
						case 'added':
							$torrent_table_template .= "<b>Added:</b> ".date_i18n(get_option('date_format') , strtotime($row->added))."<br />";
						break;
						case 'tracker':
							if ($torrent_external_yes)
								$torrent_table_template .="<b>Tracker:</b> ".htmlspecialchars($row->announce)."<br />";
						break;
						case 'completed':
							$torrent_table_template .= "<b>Completed</b>: ".$row->times_completed."<br />";
						break;
					}
				}
					$torrent_table_template .= "</td></tr>";
			}
			//End Expanding Area
	}

	$torrent_table_template .= "</tbody></table><BR>";
	$torrent_table_template .= "<br /><center>" . paginate_links($pagination_args) . "</center>";
	return $torrent_table_template;
}
	
function smilies(){
	global $smilies;
	$smilies = array(
		":)" => "smile1.gif", ";)" => "wink.gif", ":D" => "grin.gif", ":P" => "tongue.gif", ":(" => "sad.gif", ":\'(" => "cry.gif", ":|" => "noexpression.gif", ":-/" => "confused.gif", ":-O" => "ohmy.gif", "8)" => "cool1.gif", ":dumbells:" => "dumbells.gif",
		"O:-" => "angel.gif", "-_-" => "sleep.gif", ":grrr:" => "angry.gif", ":smile:" => "smile2.gif", ":lol:" => "laugh.gif", ":cool:" => "cool2.gif", ":fun:" => "fun.gif", ":thumbsup:" => "thumbsup.gif", ":thumbsdown:" => "thumbsdown.gif",
		":blush:" => "blush.gif", ":weep:" => "weep.gif", ":unsure:" => "unsure.gif", ":closedeyes:" => "closedeyes.gif", ":yes:" => "yes.gif", ":no:" => "no.gif", ":love:" => "love.gif", ":?:" => "question.gif", ":!:" => "excl.gif", ":clover:" => "clover.gif",
		":idea:" => "idea.gif", ":arrow:" => "arrow.gif", ":hmm:" => "hmm.gif", ":huh:" => "huh.gif", ":w00t:" => "w00t.gif", ":geek:" => "geek.gif", ":look:" => "look.gif", ":rolleyes:" => "rolleyes.gif", ":kiss:" => "kiss.gif", ":shifty:" => "shifty.gif",
		":blink:" => "blink.gif", ":smartass:" => "smartass.gif", ":sick:" => "sick.gif", ":crazy:" => "crazy.gif", ":wacko:" => "wacko.gif", ":alien:" => "alien.gif", ":wizard:" => "wizard.gif", ":wave:" => "wave.gif", ":wavecry:" => "wavecry.gif", ":baby:" => "baby.gif",
		":ras:" => "ras.gif", ":sly:" => "sly.gif", ":devil:" => "devil.gif", ":evil:" => "evil.gif", ":evilmad:" => "evilmad.gif", ":yucky:" => "yucky.gif", ":nugget:" => "nugget.gif", ":sneaky:" => "sneaky.gif", ":smart:" => "smart.gif", ":shutup:" => "shutup.gif",
		":shutup2:" => "shutup2.gif", ":yikes:" => "yikes.gif", ":flowers:" => "flowers.gif", ":wub:" => "wub.gif", ":osama:" => "osama.gif", ":saddam:" => "saddam.gif", ":santa:" => "santa.gif", ":indian:" => "indian.gif", ":guns:" => "guns.gif", ":crockett:" => "crockett.gif",
		":zorro:" => "zorro.gif", ":snap:" => "snap.gif", ":beer:" => "beer.gif", ":drunk:" => "drunk.gif", ":sleeping:" => "sleeping.gif", ":mama:" => "mama.gif", ":pepsi:" => "pepsi.gif", ":medieval:" => "medieval.gif", ":rambo:" => "rambo.gif", ":ninja:" => "ninja.gif",
		":hannibal:" => "hannibal.gif", ":party:" => "party.gif", ":snorkle:" => "snorkle.gif", ":evo:" => "evo.gif", ":king:" => "king.gif", ":chef:" => "chef.gif", ":mario:" => "mario.gif", ":pope:" => "pope.gif", ":fez:" => "fez.gif", ":cap:" => "cap.gif",
		":cowboy:" => "cowboy.gif", ":pirate:" => "pirate.gif", ":rock:" => "rock.gif", ":cigar:" => "cigar.gif", ":icecream:" => "icecream.gif", ":oldtimer:" => "oldtimer.gif", ":wolverine:" => "wolverine.gif", ":strongbench:" => "strongbench.gif", ":weakbench:" => "weakbench.gif",
		":bike:" => "bike.gif", ":music:" => "music.gif", ":book:" => "book.gif", ":fish:" => "fish.gif", ":whistle:" => "whistle.gif", ":stupid:" => "stupid.gif", ":dots:" => "dots.gif", ":axe:" => "axe.gif", ":hooray:" => "hooray.gif", ":yay:" => "yay.gif", ":shit:" => "shit.gif",
		":cake:" => "cake.gif", ":hbd:" => "hbd.gif", ":hi:" => "hi.gif", ":offtopic:" => "offtopic.gif", ":band:" => "band.gif", ":hump:" => "hump.gif", ":punk:" => "punk.gif", ":bounce:" => "bounce.gif", ":group:" => "group.gif", ":console:" => "console.gif", ":smurf:" => "smurf.gif", ":soldiers:" => "soldiers.gif",
		":spidey:" => "spidey.gif", ":smurf:" => "smurf.gif", ":rant:" => "rant.gif", ":pimp:" => "pimp.gif", ":nuke:" => "nuke.gif", ":judge:" => "judge.gif", ":jacko:" => "jacko.gif", ":ike:" => "ike.gif", ":greedy:" => "greedy.gif"
	);
	return $smilies;
}
function format_urls($s){
	return preg_replace(
		"/(\A|[^=\]'\"a-zA-Z0-9])((http|ftp|https|ftps|irc):\/\/[^<>\s]+)/i",
		"\\1<a href=http://anonym.to/?\\2 target=_blank>\\2</a>", $s);
}
function bbcode_to_html($text){
	$newtext = $text;
	$newtext = htmlspecialchars($newtext);
	$newtext = format_urls($newtext);
	$r = substr(md5($text), 0, 4);
		$bbcode = array("/\[\*\]/", 
			"/\[img\](http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.bmp|\.jpeg))\[\/img\]/i",
			"/\[img=(http:\/\/[^\s'\"<>]+(\.gif|\.jpg|\.png|\.bmp|\.jpeg))\]/i",
			"/\[b\]((\s|.)+?)\[\/b\]/", 
			"/\[u\]((\s|.)+?)\[\/u\]/",
			"/\[u\]((\s|.)+?)\[\/u\]/i",
			"/\[i\]((\s|.)+?)\[\/i\]/",
			"/\[center\]((\s|.)+?)\[\/center\]/",
			"/\[left\]((\s|.)+?)\[\/left\]/",
			"/\[right\]((\s|.)+?)\[\/right\]/",
			"/\[justify\]((\s|.)+?)\[\/justify\]/",
			"/\[hr\]/i",
			"/\[hr=((#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])|([a-zA-z]+))\]/i",
			"/\[swf\]((www.|http:\/\/|https:\/\/)[^\s]+(\.swf))\[\/swf\]/i",
			"/\[spoiler\]\s*((\s|.)+?)\s*\[\/spoiler\]\s*/i",
			"/\[color=([a-zA-Z]+)\]((\s|.)+?)\[\/color\]/i",
			"/\[color=(#[a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9][a-f0-9])\]((\s|.)+?)\[\/color\]/i",
			"/\[size=([1-7])\]((\s|.)+?)\[\/size\]/i",
			"/\[url=((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\]((\s|.)+?)\[\/url\]/i",
			"/\[url\]((http|ftp|https|ftps|irc):\/\/[^<>\s]+?)\[\/url\]/i",
			"/\[quote\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i",
			"/\[code\]((\s|.)+?)\[\/code\]/",
			"/\[quote=(.+?)\]\s*((\s|.)+?)\s*\[\/quote\]\s*/i");
		$htmlcode = array("<li>", 
			"<img border=0 src=\"\\1\">",
			"<img border=0 src=\"\\1\">",
			"<b>\\1</b>", 
			"<u>\\1</u>", 
			"<u>\\1</u>",
			"<i>\\1</i>",
			"<div style='text-align:center'>\\1</div>",
			"<div style='text-align:left'>\\1</div>",
			"<div style='text-align:right'>\\1</div>",
			"<div style='text-align:justify'>\\1</div>",
			"<hr>",
			"<hr color=\"\\1\"/>",
			"<param name=movie value=\\1/><embed width=470 height=310 src=\\1></embed>",
			"<span id='spoilertt' style='background: #000; color: #000;' onMouseOver='document.getElementById(\"spoilertt\").style.backgroundColor=\"inherit\"' onMouseOut='document.getElementById(\"spoilertt\").style.backgroundColor=\"#000\"'>\\1</span>&nbsp;",
			"<font color=\\1>\\2</font>",
			"<font color=\\1>\\2</font>",
			"<font size=\\1>\\2</font>",
			"<a href=http://anonym.to/?\\1 target=_blank>\\3</a>",
			"<a href=http://anonym.to/?\\1 target=_blank>\\1</a>",
			"<p class=sub><b>Quote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\1</td></tr></table><br />",
			"<code>\\1</code>",
			"<p class=sub><b>\\1 wrote:</b></p><table class=main border=1 cellspacing=0 cellpadding=10><tr><td style='border: 1px black dotted'>\\2</td></tr></table><br />");
	$newtext = preg_replace($bbcode, $htmlcode, $text);
	$newtext = nl2br($newtext);//second pass
	// Maintain spacing
	$newtext = str_replace("  ", " &nbsp;", $newtext);
	smilies();
	global $smilies;
	reset($smilies);
	while (list($code, $url) = each($smilies))
		$newtext = str_replace($code, "<img border=0 src=http://www.wp-trader.tsocialmedia.com/wp-content/plugins/wp-trader/css/images/smilies/$url />", $newtext);
	return $newtext;
}
function wp_trader_options($option){
	switch ($option){
		case members_only_yes:
			return get_option('members_only') == 1;
		break;
		case members_only_no:
			return get_option('members_only') == 0;
		break;
		case members_only_wait_yes:
			return get_option('members_only_wait') == 1;
		break;
		case members_only_wait_no:
			return get_option('members_only_wait') == 0;
		break;
		case anonymous_upload_yes:
			return get_option('anonymous_upload') == 1;
		break;
		case anonymous_upload_no:
			return get_option('anonymous_upload') == 0;
		break;
		case announce_list:
			return get_option("announce_list");
		break;
		case allow_external_yes:
			return get_option("allow_external") == 1;
		break;
		case allow_external_no:
			return get_option("allow_external") == 0;
		break;
		case allow_nfo_upload_yes:
			return get_option("allow_nfo_upload") == 1;
		break;
		case allow_nfo_upload_no:
			return get_option("allow_nfo_upload") == 0;
		break;
		case nfo_display_type_yes:
			return get_option("nfo_display_type") == 1;
		break;
		case nfo_display_type_no:
			return get_option("nfo_display_type") == 0;
		break;
		case show_peer_list_yes:
			return get_option("show_peer_list") == 1;
		break;
		case show_peer_list_no:
			return get_option("show_peer_list") == 0;
		break;
		case show_file_list_yes:
			return get_option("show_file_list") == 1;
		break;
		case show_file_list_no:
			return get_option("show_file_list") == 0;
		break;
		case uploaders_only_yes:
			return get_option("uploaders_only") == 1;
		break;
		case uploaders_only_no:
			return get_option("uploaders_only") == 0;
		break;
		case scrape_upload_yes:
			return get_option("scrape_upload") == 1;
		break;
		case scrape_upload_no:
			return get_option("scrape_upload") == 0;
		break;
		case scrape_upload_force_yes:
			return get_option("scrape_upload_force") == 1;
		break;
		case scrape_upload_force_no:
			return get_option("scrape_upload_force") == 0;
		break;
		case free_leech_yes:
			return get_option("free_leech") == 1;
		break;
		case free_leech_no:
			return get_option("free_leech") == 0;
		break;
		case ratiowarn_enable_yes:
			return get_option("ratiowarn_enable") == 1;
		break;
		case ratiowarn_enable_no:
			return get_option("ratiowarn_enable") == 0;
		break;
		case passkey_tracking_yes:
			return get_option("ip_passkey_tracking") == 1;
		break;
		case ip_tracking_yes:
			return get_option("ip_passkey_tracking") == 0;
		break;
		case torrent_browse_page_yes:
			return get_option("torrent_browse_page") == 1;
		break;
		case torrent_browse_page_no:
			return get_option("torrent_browse_page") == 0;
		break;
		case torrent_upload_wordpress_editor_yes:
			return get_option("torrent_upload_wordpress_editor") == 1;
		break;
		case torrent_upload_wordpress_editor_no:
			return get_option("torrent_upload_wordpress_editor") == 0;
		break;
		case nfo_size:
			return get_option("nfo_size");
		break;
		case torrent_directory:
			return get_option("torrent_directory");
		break;
		case nfo_directory:
			return get_option("nfo_directory");
		break;
		case image_directory:
			return get_option("image_directory");
		break;
		case image_size:
			return get_option("image_size");
		break;
		case image_types:
			return get_option("image_types");
		break;
		case upload_rules:
			return get_option("upload_rules");
		break;
		default:
			return "Please select an option";
	} 
}
function multi_implode($array, $glue) {
    $ret = '';

    foreach ($array as $item) {
        if (is_array($item)) {
            $ret .= multi_implode($item, $glue) . $glue;
        } else {
            $ret .= $item . $glue;
        }
    }

    $ret = substr($ret, 0, 0-strlen($glue));

    return $ret;
}
/** * Scrape torrent and return stats 
* * @param $scrape 
*   string: Scrape URL 
* @param $hash 
*   string: SHA1 hash (info_hash) of torrent 
* @return 
*   array: 
*     All -1 if failed 
*     - seeds: integer - number of seeders 
*     - leechers: integer - number of leechers 
*     - downloaded: integer - number of complete downloads * */
function torrent_scrape_url($scrape, $hash) {	
	if (function_exists("curl_exec")) {		
		$ch = curl_init();
		$timeout = 5;
		curl_setopt ($ch, CURLOPT_URL, $scrape.'?info_hash='.escape_url($hash));
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$fp = curl_exec($ch);
		curl_close($ch);
	} else {
		ini_set('default_socket_timeout',10);
		$fp = @file_get_contents($scrape.'?info_hash='.escape_url($hash));	
	}
	$ret = array();	
	if ($fp) {
		require_once(WP_TRADER_ABSPATH . '/includes/BDecode.php');
		$stats = BDecode($fp);
		$binhash = pack("H*", $hash);
		$seeds = $stats['files'][$binhash]['complete'];
		$peers = $stats['files'][$binhash]['incomplete'];
		$downloaded = $stats['files'][$binhash]['downloaded'];
		$ret['seeds'] = $seeds;
		$ret['peers'] = $peers;
		$ret['downloaded'] = $downloaded;
	}
	if ($ret['seeds'] === null) {
		$ret['seeds'] = -1;
		$ret['peers'] = -1;
		$ret['downloaded'] = -1;
	}	
	return $ret;
}
?>