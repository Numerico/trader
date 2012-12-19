<?php
ob_start();
/*
* Holds the Torrent Download
* @package WP-Trader
*/
//include wp-config or wp-load.php
	$root = dirname(dirname(dirname(dirname(__FILE__))));
	if (file_exists($root.'/wp-load.php')) {
		// WP 2.6
		require_once($root.'/wp-load.php');
	} else {
		// Before 2.6
		require_once($root.'/wp-config.php');
	}
	include_once( 'includes/function-main.php' );
	global $wpdb;
	//check permissions
	if (wp_trader_options('members_only_yes') && !is_user_logged_in()){
		?>
			<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
		<?php
		$errorheader = "Error";
		$errormessage = "Sorry you must be a member to view this page!";
		wptrader_update($errorheader, $errormessage);
		die();
	}
	
	if (wp_trader_options('members_only_yes') && get_user_meta($current_user->ID, 'download_banned', true) == 1){
		?>
			<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/wp-trader.css'; ?>">
		<?php
		$errorheader = "Error";
		$errormessage = "Sorry have been banned from downloading. Please contact staff if you think this is incorrect.";
		wptrader_update($errorheader, $errormessage);
		die();
	}
	$id = (int)$_GET["id"];

	if (!$id){
		$errorheader = "ID not found";
		$errormessage = "You can't download, if you don't tell me what you want!";
		wptrader_update($errorheader, $errormessage);
		die();
	}

	$res = mysql_query("SELECT post_id, filename, banned, announce FROM " . TRADER_TORRENTS . " WHERE id =".intval($id));
	$row = mysql_fetch_array($res);
	$trackerurl = $row['announce'];
	
	$torrent_post_id = $row["post_id"];
	$fn = get_post_meta($torrent_post_id, "torrent_location", true);
	if (!$row){
		$errorheader = "File not found";
		$errormessage = "No file has been found with that ID!";
		wptrader_update($errorheader, $errormessage);
		die();
	}
	if ($row["banned"] == "yes"){
		$errorheader = "ERROR";
		$errormessage = "Torrent is banned.";
		wptrader_update($errorheader, $errormessage);
		die();
	}
	if (!is_file($fn)){
		$errorheader = "File not found";
		$errormessage = "The ID has been found on the Database, but the torrent has gone!<BR><BR>Check Server Paths and CHMODs Are Correct!".$fn;
		wptrader_update($errorheader, $errormessage);
		die();
	}
	if (!is_readable($fn)){
		$errorheader = "File not found";
		$errormessage = "The ID and torrent were found, but the torrent is NOT readable!";
		wptrader_update($errorheader, $errormessage);
		die();
	}

	$name = $row['filename'];
	$friendlyurl = str_replace("http://","",site_url());
	$friendlyname = str_replace(".torrent","",$name);
	$friendlyext = ".torrent";
	$name = $friendlyname ."[". $friendlyurl ."]". $friendlyext;
	
	$torrent_hits = get_post_meta($torrent_post_id, "hits", true);
	$torrent_hits_add = $torrent_times_completed + 1;
	update_post_meta($row['post_id'], "hits", $torrent_hits_add);

	require_once( 'includes/BEncode.php' );
	require_once( 'includes/BDecode.php' );

	//if user dont have a passkey generate one, only if tracker is set to members only
	$trader_secret = get_user_meta($current_user->ID, 'trader_secret', true);
	if (wp_trader_options('members_only_yes') && wp_trader_options('passkey_tracking_yes')){
		if (!get_user_meta($current_user->ID, 'trader_passkey', true) || strlen(get_user_meta($current_user->ID, 'trader_passkey', true)) != 32) {
			$rand = array_sum(explode(" ", microtime()));
			$trader_passkey = md5($current_user->user_login.$rand.$trader_secret.($rand*mt_rand()));
			add_user_meta( $current_user->ID, 'trader_passkey', $trader_passkey );
		}
	}

	$torrent_external = ( get_post_meta($torrent_post_id, "external", true) == 1 ) ? true : false;
	if (!$torrent_external && wp_trader_options('members_only_yes') && wp_trader_options('passkey_tracking_yes')){// local torrent so add passkey
		$dict = BDecode(file_get_contents($fn));
		$dict['announce'] = sprintf(get_option('passkey_url'), get_user_meta($current_user->ID, 'trader_passkey', true));
		unset($dict['announce-list']);
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Type: application/x-bittorrent");
		print(BEncode($dict)); 
	}else{// external torrent so no passkey needed
		header("Cache-Control: no-cache");
		header("Pragma: no-cache");
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Type: application/x-bittorrent");
		readfile($fn);
	}

mysql_close();
ob_end_flush();
?>