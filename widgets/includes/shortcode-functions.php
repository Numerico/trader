<?php
/*


  * Holds the WP-Trader shortcode functions


  * @package WP-Trader


  * @subpackage Template


  */
function most_active(){
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
		$errorheader = "Error";
		$errormessage = "Sorry you must be a member to view this page!";
		wptrader_update($errorheader, $errormessage);
	}else{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
	<?php
		$res = mysql_query("SELECT COUNT(*) FROM " . TRADER_TORRENTS . "") or die(mysql_error());

		$row = mysql_fetch_array($res);
		$count = $row[0];
			
		$count_no_seeders = count_torrent_no_seeders();
		$count_no_leechers = count_torrent_no_leechers();
			
		if (($count && $count != $count_no_seeders) || ($count && $count != $count_no_leechers)) {
			$columns = "".get_option('most_active_torrenttable')."";
			$char = get_option('most_active_name_shortner');
			$limit = get_option('most_active_limit');
			$order = "ORDER BY id ASC";
			$type = "most_active_list";
			$torrent_table = torrent_table_template($columns, $char, $limit, $order, $type, $external);
		}elseif(!$count){
			$torrent_table = "<CENTER>No torrents have been uploaded yet.</CENTER>";
		}elseif(($count && $count == $count_no_seeders) || ($count && $count == $count_no_leechers)){
			$torrent_table = "<CENTER>No active torrents!</CENTER>";
		}
		return $torrent_table;	
	}
}

function latest_uploaded_torrents(){
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
		$errorheader = "Error";
		$errormessage = "Sorry you must be a member to view this page!";
		wptrader_update($errorheader, $errormessage);
	}else{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
	<?php
		$res = mysql_query("SELECT COUNT(*) FROM " . TRADER_TORRENTS . "") or die(mysql_error());

		$row = mysql_fetch_array($res);
		$count = $row[0];
			
		if ($count) {
			$columns = "".get_option('latest_uploaded_torrenttable')."";
			$char = get_option('latest_uploaded_name_shortner');
			$limit = get_option('latest_uploaded_limit');
			$order = "ORDER BY id ASC";
			$type = "latest_uploaded_torrents_list";
			$torrent_table = torrent_table_template($columns, $char, $limit, $order, $type, $latest_uploaded_external);
		}else{
			$torrent_table = "<CENTER>No torrents have been uploaded yet.</CENTER>";
		}
		return $torrent_table;
	}
}
function seed_wanted_torrents(){
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
		$errorheader = "Error";
		$errormessage = "Sorry you must be a member to view this page!";
		wptrader_update($errorheader, $errormessage);
	}else{
	?>
		<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
	<?php
		$res = mysql_query("SELECT COUNT(*) FROM " . TRADER_TORRENTS . "") or die(mysql_error());

		$row = mysql_fetch_array($res);
		$count = $row[0];
			
		$count_no_seeders = count_torrent_no_seeders();
		$count_no_leechers = count_torrent_no_leechers();
			
		if (($count && $count == $count_no_seeders && $count != $count_no_leechers)) {
			$columns = "".get_option('seed_wanted_torrenttable')."";
			$char = get_option('seed_wanted_name_shortner');
			$limit = get_option('seed_wanted_limit');
			$order = "ORDER BY id ASC";
			$type = "seed_wanted_torrents_list";
			$torrent_table = torrent_table_template($columns, $char, $limit, $order, $type, $external);
		}elseif(!$count){
			$torrent_table = "<CENTER>No torrents have been uploaded yet.</CENTER>";
		}elseif(($count && $count == $count_no_seeders && $count == $count_no_leechers)){
			$torrent_table = "<CENTER>No torrents need a seed! All torrents are being seeded!</CENTER>";
		}
		return $torrent_table;
	}
}
function wptrader_user_stats(){	
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );	
	global $user_ID, $user_identity;
	if ( is_user_logged_in() ) {
		$user_uploaded = "" . mksize(get_user_meta($user_ID, "trader_upload", true)) . "";
		$user_downloaded = "" . mksize(get_user_meta($user_ID, "trader_download", true)) . "";
		if (get_user_meta($user_ID, "trader_upload", true) > 0 && get_user_meta($user_ID, "trader_download", true) == 0){
			$user_ratio .= "Inf.";
		}elseif (get_user_meta($user_ID, "trader_download", true) > 0){
			$user_ratio .= number_format(get_user_meta($user_ID, "trader_upload", true) / get_user_meta($user_ID, "trader_download", true), 2);
		}else{
			$user_ratio .= "---";
		}
		$user_stats .= "<strong>Donwloaded: </strong>" . $user_downloaded . "<br />";
		$user_stats .= "<strong>Uploaded: </strong>" . $user_uploaded . "<br />";
		$user_stats .= "<strong>Ratio: </strong>" . $user_ratio . "<br />";
		
		return $user_stats;
	}
}
function wptrader_login_templates(){
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	global $user_ID, $user_identity;
	if ( is_user_logged_in() ){
		$user_login_template .= "<table border='0' cellpadding='0' width='100%'><tbody>";
		$user_login_template .= "<tr><td style='float: left; margin-top: 0px; margin-bottom: 0px; margin-left: 0px; margin-right: 0px;'>" . get_avatar( $user_ID, $size = '65' ) . "</td><td>&nbsp;</td>";
		$user_login_template .= "<td><p><strong>Logged In As: </strong><a href='" . site_url() . "/wp-admin/profile.php'>" . $user_identity . "</a><br />";
		$user_login_template .= "<strong>Class: </strong>" . get_current_user_role() . "<br />";
		$user_login_template .= wptrader_user_stats() . "<br />";
		if( current_user_can('level_10') ){
			$user_login_template .= "<a href='" . site_url() . "/wp-admin/'>Dashboard</a>";
			$user_login_template .= "&nbsp;|&nbsp;";
		}
		$user_login_template .= "<a href='" . site_url() . "/wp-login.php?action=logout&amp;redirect_to=" . urlencode($_SERVER['REQUEST_URI']) . "'>Logout</a><br />";
		$user_login_template .= "</td></tr></tbody></table>";
	}else{
		$user_login_template .= "<form action='" . site_url() . "/wp-login.php' method='post'>";
		$user_login_template .= "<p>";
		$user_login_template .= "<label for='log'><input type='text' name='log' id='log' value='" . wp_specialchars(stripslashes($user_login), 1) . "' size='22' /> Username</label><br />";
		$user_login_template .= "<label for='pwd'><input type='password' name='pwd' id='pwd' size='22' /> Password</label><br />";
		$user_login_template .= "<input type='submit' name='submit' value='Send' class='button' /><br /><br />";
		$user_login_template .= "<label for='rememberme'><input name='rememberme' id='rememberme' type='checkbox' checked='checked' value='forever' /> Remember me</label><br />";
		$user_login_template .= "</p>";
		$user_login_template .= "<input type='hidden' name='redirect_to' value='" . $_SERVER['REQUEST_URI'] . "'/>";
		$user_login_template .= "</form>";
		$user_login_template .= "<a href='" . site_url() . "/wp-register.php'>Register</a>";
		$user_login_template .= "&nbsp;|&nbsp;";
		$user_login_template .= "<a href='" . site_url() . "/wp-login.php?action=lostpassword'>Recover Password</a>";
		}
	return $user_login_template;
}
?>