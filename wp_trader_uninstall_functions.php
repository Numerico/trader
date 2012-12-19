<?php
 /**
 * Holds the Uninstall Functions
 * @package WP-Trader
 */
function wp_trader_uninstall_db() {
	global $wpdb;
	mysql_query('DROP TABLE IF EXISTS `' . TRADER_ANNOUNCE . '`');
	mysql_query('DROP TABLE IF EXISTS `' . TRADER_COMPLETED . '`');
	mysql_query('DROP TABLE IF EXISTS `' . TRADER_PEERS . '`');
	mysql_query('DROP TABLE IF EXISTS `' . TRADER_TORRENTS . '`');
	mysql_query('DROP TABLE IF EXISTS `' . TRADER_TORRENT_LANGUAGES . '`');
}
function wp_trader_uninstall_options() {
	global $wpdb;
	if (get_option('announce_list')){
		delete_option('announce_list');
	}
	if (get_option('scrape_list')){
		delete_option('scrape_list');
	}
	if (get_option('members_only')){
		delete_option('members_only');
	}
	if (get_option('members_only_wait')){
		delete_option('members_only_wait');
	}
	if (get_option('allow_external')){
		delete_option('allow_external');
	}
	if (get_option('allow_nfo_upload')){
		delete_option('allow_nfo_upload');
	}
	if (get_option('nfo_display_type')){
		delete_option('nfo_display_type');
	}
	if (get_option('show_peer_list')){
		delete_option('show_peer_list');
	}
	if (get_option('show_file_list')){
		delete_option('show_file_list');
	}
	if (get_option('uploaders_only')){
		delete_option('uploaders_only');
	}
	if (get_option('torrent_role')){
		delete_option('torrent_role');
	}
	if (get_option('anonymous_upload')){
		delete_option('anonymous_upload');
	}
	if (get_option('passkey_url')){
		delete_option('passkey_url');
	}
	if (get_option('scrape_upload')){
		delete_option('scrape_upload');
	}
	if (get_option('scrape_upload_force')){
		delete_option('scrape_upload_force');
	}
	if (get_option('torrent_directory')){
		delete_option('torrent_directory');
	}
	if (get_option('image_directory')){
		delete_option('image_directory');
	}
	if (get_option('nfo_directory')){
		delete_option('nfo_directory');
	}
	if (get_option('upload_rules')){
		delete_option('upload_rules');
	}
	if (get_option('minimum_gigsa')){
		delete_option('minimum_gigsa');
	}
	if (get_option('minimum_gigsa')){
		delete_option('minimum_ratioa');
	}
	if (get_option('minimum_gigsa')){
		delete_option('minimum_waita');
	}
	if (get_option('minimum_gigsb')){
		delete_option('minimum_gigsb');
	}
	if (get_option('minimum_ratiob')){
		delete_option('minimum_ratiob');
	}
	if (get_option('minimum_waitb')){
		delete_option('minimum_waitb');
	}
	if (get_option('minimum_gigsc')){
		delete_option('minimum_gigsc');
	}
	if (get_option('minimum_ratioc')){
		delete_option('minimum_ratioc');
	}
	if (get_option('minimum_waitc')){
		delete_option('minimum_waitc');
	}
	if (get_option('minimum_gigsd')){
		delete_option('minimum_gigsd');
	}
	if (get_option('minimum_ratiod')){
		delete_option('minimum_ratiod');
	}
	if (get_option('minimum_waitd')){
		delete_option('minimum_waitd');
	}
	if (get_option('announce_peerlimit')){
		delete_option('announce_peerlimit');
	}
	if (get_option('cleanup_autoclean_interval')){
		delete_option('cleanup_autoclean_interval');
	}
	if (get_option('cleanup_log_clean')){
		delete_option('cleanup_log_clean');
	}
	if (get_option('announce_interval')){
		delete_option('announce_interval');
	}
	if (get_option('max_dead_torrent_time')){
		delete_option('max_dead_torrent_time');
	}
	if (get_option('ratiowarn_enable')){
		delete_option('ratiowarn_enable');
	}
	if (get_option('ratiowarn_minratio')){
		delete_option('ratiowarn_minratio');
	}
	if (get_option('ratiowarn_mingigs')){
		delete_option('ratiowarn_mingigs');
	}
	if (get_option('ratiowarn_daystowarn')){
		delete_option('ratiowarn_daystowarn');
	}
	if (get_option('image_size')){
		delete_option('image_size');
	}
	if (get_option('image_types')){
		delete_option('image_types');
	}
	if (get_option('nfo_size')){
		delete_option('nfo_size');
	}
	if (get_option('free_leech')){
		delete_option('free_leech');
	}
	if (get_option('torrent_upload_wordpress_editor')){
		delete_option('torrent_upload_wordpress_editor');
	}
	if (get_option('ip_passkey_tracking')){
		delete_option('ip_passkey_tracking');
	}
	if (get_option('user_generate_passkey')){
		delete_option('user_generate_passkey');
	}
	if (get_option('wptrader_seed_bonus')){
		delete_option('wptrader_seed_bonus');
	}
	if (get_option('torrent_browse_page')){
		delete_option('torrent_browse_page');
	}
	if (get_option('torrent_header_footer')){
		delete_option('torrent_header_footer');
	}
	if (get_option('torrent_table_limit')){
		delete_option('torrent_table_limit');
	}
	if (get_option('torrent_table_name_shortner')){
		delete_option('torrent_table_name_shortner');
	}
	if (get_option('torrenttable_columns')){
		delete_option('torrenttable_columns');
	}
	if (get_option('torrenttable_expand')){
		delete_option('torrenttable_expand');
	}
	if (get_option('torrent_peers_list')){
		delete_option('torrent_peers_list');
	}
	if (get_option('torrent_peers_list_admin_limit')){
		delete_option('torrent_peers_list_admin_limit');
	}
	if (get_option('torrent_peers_list_admin')){
		delete_option('torrent_peers_list_admin');
	}
	if (get_option('torrent_free_leech_admin_limit')){
		delete_option('torrent_free_leech_admin_limit');
	}
	if (get_option('torrent_free_leech_admin')){
		delete_option('torrent_free_leech_admin');
	}
	if (get_option('most_active_limit')){
		delete_option('most_active_limit');
	}
	if (get_option('most_active_external')){
		delete_option('most_active_external');
	}
	if (get_option('most_active_name_shortner')){
		delete_option('most_active_name_shortner');
	}
	if (get_option('most_active_torrenttable')){
		delete_option('most_active_torrenttable');
	}
	if (get_option('latest_uploaded_limit')){
		delete_option('latest_uploaded_limit');
	}
	if (get_option('latest_uploaded_external')){
		delete_option('latest_uploaded_external');
	}
	if (get_option('latest_uploaded_name_shortner')){
		delete_option('latest_uploaded_name_shortner');
	}
	if (get_option('seed_wanted_limit')){
		delete_option('seed_wanted_limit');
	}
	if (get_option('seed_wanted_external')){
		delete_option('seed_wanted_external');
	}
	if (get_option('seed_wanted_name_shortner')){
		delete_option('seed_wanted_name_shortner');
	}
	if (get_option('wp_trader_db_version')){
		delete_option('wp_trader_db_version');
	}		if (get_option('agent_bans')){				delete_option('agent_bans');			}
}
function wp_trader_uninstall_pages() {
	global $wpdb;
	$page = get_page_by_title( 'Torrent Upload' );
	$pageid = $page->ID;
	wp_delete_post($pageid, true);
	$announce = get_page_by_title( 'Announce' );
	$announceid = $announce->ID;
	wp_delete_post($announceid, true);
	$scrape = get_page_by_title( 'Scrape' );
	$scrapeid = $scrape->ID;
	wp_delete_post($scrapeid, true);
	$browse = get_page_by_title( 'Torrent Browse' );
	$browseid = $browse->ID;
	wp_delete_post($browseid, true);
	$source = get_stylesheet_directory() . '/announce.php';
	if (file_exists($source)) {
		unlink($source);
	}
	$scrape_source = get_stylesheet_directory() . '/scrape.php';
	if (file_exists($scrape_source)) {
		unlink($scrape_source);
	}
}
function wp_trader_uninstall_user_meta() {
	global $wpdb;
	$sort= 'user_registered';
	$all_users_id = $wpdb->get_col( $wpdb->prepare('SELECT $wpdb->users.ID FROM $wpdb->users ORDER BY %s ASC', $sort ));
	//we got all the IDs, now loop through them to get individual IDs
	foreach ( $all_users_id as $i_users_id ) :
		// get user info by calling get_userdata() on each id
		$user = get_userdata( $i_users_id );
		$user_id = $user->ID;
		if (get_user_meta($user_id, 'trader_secret')){
			delete_user_meta( $user_id, 'trader_secret' );
		}
		if (get_user_meta($user_id, 'trader_passkey')){
			delete_user_meta( $user_id, 'trader_passkey' );
		}
		if (get_user_meta($user_id, 'trader_upload')){
			delete_user_meta( $user_id, 'trader_upload' );
		}
		if (get_user_meta($user_id, 'trader_download')){
			delete_user_meta( $user_id, 'trader_download' );
		}
		if (get_user_meta($user_id, 'download_banned')){
			delete_user_meta( $user_id, 'download_banned' );
		}
		if (get_user_meta($user_id, 'seed_bonus')){
			delete_user_meta( $user_id, 'seed_bonus' );
		}
	endforeach; // end the users loop.
}
function wp_trader_uninstall_system_user() {
	global $wpdb;
	$delete_id = get_user_by('login', 'System');
	wp_delete_user( $delete_id->ID );
}
?>