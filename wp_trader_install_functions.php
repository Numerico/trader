<?php
 /**
 * Holds the Install Functions
 * @package WP-Trader
 */
function wp_trader_install_db() {
	global $wpdb;
	global $wp_trader_db_version;
	$sql[] = "CREATE TABLE IF NOT EXISTS `" . TRADER_ANNOUNCE . "` 
		(
			`id` INT( 20 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`url` VARCHAR( 255 ) NOT NULL ,
			`torrent` INT( 10 ) UNSIGNED NOT NULL ,
			`seeders` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
			`leechers` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
			`times_completed` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0',
			`online` ENUM( 'yes', 'no' ) NOT NULL DEFAULT 'yes',
			INDEX ( `torrent` )
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";
      
	$sql[] = "CREATE TABLE IF NOT EXISTS `" . TRADER_COMPLETED . "` 
		(
			`id` int(10) unsigned NOT NULL auto_increment,
			`userid` int(10) NOT NULL default '0',
			`torrentid` int(10) NOT NULL default '0',
			`date` datetime NOT NULL default '0000-00-00 00:00:00',
			PRIMARY KEY  (`id`),
			UNIQUE `userid_torrentid` (`userid`, `torrentid`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
                
	$sql[] = "CREATE TABLE IF NOT EXISTS `" . TRADER_PEERS . "` 
		(
			`id` int(10) unsigned NOT NULL auto_increment,
			`torrent` int(10) unsigned NOT NULL default '0',
			`peer_id` varchar(40) NOT NULL default '',
			`ip` varchar(64) NOT NULL default '',
			`port` smallint(5) unsigned NOT NULL default '0',
			`uploaded` bigint(20) unsigned NOT NULL default '0',
			`downloaded` bigint(20) unsigned NOT NULL default '0',
			`to_go` bigint(20) unsigned NOT NULL default '0',
			`seeder` enum('yes','no') NOT NULL default 'no',
			`started` datetime NOT NULL default '0000-00-00 00:00:00',
			`last_action` datetime NOT NULL default '0000-00-00 00:00:00',
			`connectable` enum('yes','no') NOT NULL default 'yes',
			`client` varchar(60) NOT NULL default '',
			`userid` varchar(32) NOT NULL default '',
			`passkey` varchar(32) NOT NULL default '',
			PRIMARY KEY  (`id`),
			UNIQUE KEY `torrent_peer_id` (`torrent`,`peer_id`),
			KEY `torrent` (`torrent`),
			KEY `torrent_seeder` (`torrent`,`seeder`),
			KEY `last_action` (`last_action`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT = 1;";
				
	$sql[] = "CREATE TABLE IF NOT EXISTS `" . TRADER_TORRENTS . "` 
		(
			`id` int(10) unsigned NOT NULL auto_increment,
			`post_id` bigint(20) unsigned NOT NULL default '0',
			`attachment_id` bigint(20) unsigned NOT NULL default '0',
			`info_hash` varchar(40) default NULL,
			`name` varchar(255) NOT NULL default '',
			`filename` varchar(255) NOT NULL default '',
			`save_as` varchar(255) NOT NULL default '',
			`category` int(10) unsigned NOT NULL default '0',
			`size` bigint(20) unsigned NOT NULL default '0',
			`type` enum('single','multi') NOT NULL default 'single',
			`numfiles` int(10) unsigned NOT NULL default '0',
			`banned` enum('yes','no') NOT NULL default 'no',
			`owner` int(10) unsigned NOT NULL default '0',
			`nfo` enum('yes','no') NOT NULL default 'no',
			`announce` varchar(255) NOT NULL default '',
			`torrentlang` int(10) unsigned NOT NULL default '1',
			PRIMARY KEY  (`id`),
			UNIQUE KEY `info_hash` (`info_hash`(20)),
			KEY `owner` (`owner`),
			FULLTEXT KEY `name` (`name`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;";
	$sql[] = "CREATE TABLE IF NOT EXISTS `" . TRADER_TORRENT_LANGUAGES . "` 
		(
			`id` int(10) unsigned NOT NULL auto_increment,
			`name` varchar(30) NOT NULL default '',
			`image` varchar(255) NOT NULL default '',
			`sort_index` int(10) unsigned NOT NULL default '0',
			PRIMARY KEY  (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=8;";
				
	$sql[] = "INSERT IGNORE INTO `" . TRADER_TORRENT_LANGUAGES . "` (`id`, `name`, `image`, `sort_index`) VALUES 
		(1, 'English', 'english.gif', 1),
		(2, 'French', '', 1),
		(3, 'German', '', 1),
		(4, 'Italian', '', 1),
		(5, 'Japan', '', 1),
		(6, 'Spanish', '', 1),
		(7, 'Russian', '', 1);";
				
	foreach ($sql as $query){
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		//dbDelta($sql);
		dbDelta($query);
	}
}
function wp_trader_install_db_values() {
	$sql = "INSERT IGNORE INTO `" . TRADER_TORRENT_LANGUAGES . "` (`id`, `name`, `image`, `sort_index`) VALUES 
		(1, 'English', 'english.gif', 1),
		(2, 'French', 'france.gif', 1),
		(3, 'German', 'german.gif', 1),
		(4, 'Italian', 'italian.gif', 1),
		(5, 'Japan', 'japanese.gif', 1),
		(6, 'Spanish', 'spanish.gif', 1),
		(7, 'Russian', 'russian.gif', 1);";
	
	 mysql_query($sql) or die (mysql_error());
}
function wp_trader_install_options() {
	global $wpdb;
	global $wp_trader_db_version;
	if (!get_option('wp_trader_db_version')){
		add_option('wp_trader_db_version', $wp_trader_db_version);
	}
	if (!get_option('wp_trader_keep_settings')){
		add_option('wp_trader_keep_settings', '1', 'yes');
	}
	if (!get_option('wp_trader_keep_databank_tables')){
		add_option('wp_trader_keep_databank_tables', '1', 'yes');
	}
	if (!get_option('wp_trader_keep_all_pages')){
		add_option('wp_trader_keep_all_pages', '1', 'yes');
	}
	if (!get_option('wp_trader_keep_all_user_info')){
		add_option('wp_trader_keep_all_user_info', '1', 'yes');
	}
	if (!get_option('wp_trader_keep_system_user')){
		add_option('wp_trader_keep_system_user', '1', 'yes');
	}
	if (!get_option('wp_trader_keep_posts')){
		add_option('wp_trader_keep_posts', '1', 'yes');
	}
	if (!get_option('members_only')){
		add_option('members_only', '0', 'yes');
	}
	$default_members_only_page_exclude = 'wp-login.php|wp-register.php|wp-cron.php|wp-trackback.php|xmlrpc.php';
	if (!get_option('members_only_page_exclude')){
		add_option('members_only_page_exclude', $default_members_only_page_exclude, 'yes');
	}
	if (!get_option('members_only_wait')){
		add_option('members_only_wait', '1', 'yes');
	}
	if (!get_option('allow_external')){
		add_option('allow_external', '1', 'yes');
	}
	if (!get_option('allow_nfo_upload')){
		add_option('allow_nfo_upload', '1', 'yes');	
	}
	if (!get_option('nfo_display_type')){
		if(!extension_loaded('gd')){
			add_option('nfo_display_type', '0', 'yes');
		}else{
			add_option('nfo_display_type', '1', 'yes');
		}
	}
	if (!get_option('show_peer_list')){
		add_option('show_peer_list', '1', 'yes');
	}
	if (!get_option('show_file_list')){	
		add_option('show_file_list', '1', 'yes');
	}
	if (!get_option('uploaders_only')){
		add_option('uploaders_only', '0', 'yes');
	}
	$default_torrent_role = 'Administrator|Editor|Author';
	if (!get_option('torrent_role')){
		add_option('torrent_role', $default_torrent_role, 'yes');
	}
	if (!get_option('anonymous_upload')){
		add_option('anonymous_upload', '0', 'yes');
	}
	if (!get_option('scrape_upload')){
		add_option('scrape_upload', '0', 'yes');
	}
	if (!get_option('scrape_upload_force')){
		add_option('scrape_upload_force', '0', 'yes');
	}
	if (!get_option('torrent_directory')){
		add_option('torrent_directory', 'torrents', 'yes');
	}
	if (!get_option('image_directory')){
		add_option('image_directory', 'images', 'yes');
	}
	if (!get_option('nfo_directory')){
		add_option('nfo_directory', 'nfo', 'yes');
	}
	if (!get_option('upload_rules')){
		add_option('upload_rules', 'You should also include a .nfo file wherever possible<BR>Try to make sure your torrents are well-seeded for at least 24 hours<BR>Do not re-release material that is still active', 'yes');
	}
	if (!get_option('torrent_roles')){
		add_option('torrent_roles', 'Subscriber', 'yes');
	}
	if (!get_option('minimum_gigsa')){
		add_option('minimum_gigsa', '1', 'yes');
	}
	if (!get_option('minimum_ratioa')){
		add_option('minimum_ratioa', '0.50', 'yes');
	}
	if (!get_option('minimum_waita')){
		add_option('minimum_waita', '24', 'yes');
	}
	if (!get_option('minimum_gigsb')){
		add_option('minimum_gigsb', '3', 'yes');
	}
	if (!get_option('minimum_ratiob')){
		add_option('minimum_ratiob', '0.650', 'yes');
	}
	if (!get_option('minimum_waitb')){
		add_option('minimum_waitb', '12', 'yes');
	}
	if (!get_option('minimum_gigsc')){
		add_option('minimum_gigsc', '5', 'yes');
	}
	if (!get_option('minimum_ratioc')){
		add_option('minimum_ratioc', '0.80', 'yes');
	}
	if (!get_option('minimum_waitc')){
		add_option('minimum_waitc', '6', 'yes');
	}
	if (!get_option('minimum_gigsd')){
		add_option('minimum_gigsd', '7', 'yes');
	}
	if (!get_option('minimum_ratiod')){
		add_option('minimum_ratiod', '0.95', 'yes');
	}
	if (!get_option('minimum_waitd')){
		add_option('minimum_waitd', '2', 'yes');
	}
	if (!get_option('announce_peerlimit')){
		add_option('announce_peerlimit', '50', 'yes');
	}
	if (!get_option('cleanup_autoclean_interval')){
		add_option('cleanup_autoclean_interval', 'hourly', 'yes');
	}
	if (!get_option('cleanup_log_clean')){
		add_option('cleanup_log_clean', '28 * 86400', 'yes');
	}
	if (!get_option('announce_interval')){
		add_option('announce_interval', '1800', 'yes');
	}
	if (!get_option('max_dead_torrent_time')){
		add_option('max_dead_torrent_time', '21600', 'yes');
	}
	if (!get_option('ratiowarn_enable')){
		add_option('ratiowarn_enable', '1', 'yes');
	}
	if (!get_option('ratiowarn_minratio')){
		add_option('ratiowarn_minratio', '0.4', 'yes');
	}
	if (!get_option('ratiowarn_mingigs')){
		add_option('ratiowarn_mingigs', '4', 'yes');
	}
	if (!get_option('ratiowarn_daystowarn')){
		add_option('ratiowarn_daystowarn', '14', 'yes');
	}
	if (!get_option('image_size')){
		add_option('image_size', '512000', 'yes');
	}
	$default_image_types = 'image/gif,image/pjpeg,image/jpeg,image/jpg,image/png';
	if (!get_option('image_types')){
		add_option('image_types', $default_image_types, 'yes');
	}
	if (!get_option('nfo_size')){
		add_option('nfo_size', '76800', 'yes');
	}
	if (!get_option('free_leech')){
		add_option('free_leech', '0', 'yes');
	}
	global $wp_version;
	if ($wp_version >= '3.3'){
		if (!get_option('torrent_upload_wordpress_editor')){
			add_option('torrent_upload_wordpress_editor', '1', 'yes');
		}
	}
	if (!get_option('ip_passkey_tracking')){
		add_option('ip_passkey_tracking', '1', 'yes');
	}
	if (!get_option('user_generate_passkey')){
		add_option('user_generate_passkey', '1', 'yes');
	}
	if (!get_option('wptrader_seed_bonus')){
		add_option('wptrader_seed_bonus', '1', 'yes');
	}
	if (!get_option('torrent_browse_page')){
		add_option('torrent_browse_page', '1', 'yes');
	}
	$default_most_active_limit = '10';
	if (!get_option('most_active_limit')){
		add_option('most_active_limit', $default_most_active_limit, 'yes');
	}
	if (!get_option('most_active_external')){
		add_option('most_active_external', '0', 'yes');
	}
	$default_most_active_name_shortner = '10';
	if (!get_option('most_active_name_shortner')){
		add_option('most_active_name_shortner', $default_most_active_name_shortner, 'yes');
	}
	$default_most_active_torrenttable = 'name,seeders,leechers';
	if (!get_option('most_active_torrenttable')){
		add_option('most_active_torrenttable', $default_most_active_torrenttable, 'yes');
	}
	$default_latest_uploaded_limit = '5';
	if (!get_option('latest_uploaded_limit')){
		add_option('latest_uploaded_limit', $default_latest_uploaded_limit, 'yes');
	}
	if (!get_option('latest_uploaded_external')){
		add_option('latest_uploaded_external', '0', 'yes');
	}
	$default_latest_uploaded_name_shortner = '18';
	if (!get_option('latest_uploaded_name_shortner')){
		add_option('latest_uploaded_name_shortner', $default_latest_uploaded_name_shortner, 'yes');
	}
	$default_latest_uploaded_torrenttable = 'name,seeders,leechers';
	if (!get_option('latest_uploaded_torrenttable')){
		add_option('latest_uploaded_torrenttable', $default_latest_uploaded_torrenttable, 'yes');
	}
	$default_seed_wanted_limit = '5';
	if (!get_option('seed_wanted_limit')){
		add_option('seed_wanted_limit', $default_seed_wanted_limit, 'yes');
	}
	if (!get_option('seed_wanted_external')){
		add_option('seed_wanted_external', '0', 'yes');
	}
	$default_seed_wanted_name_shortner = '18';
	if (!get_option('seed_wanted_name_shortner')){
		add_option('seed_wanted_name_shortner', $default_seed_wanted_name_shortner, 'yes');
	}
	$default_seed_wanted_torrenttable = 'name,seeders,leechers';
	if (!get_option('seed_wanted_torrenttable')){
		add_option('seed_wanted_torrenttable', $default_seed_wanted_torrenttable, 'yes');
	}
	if (!get_option('torrent_header_footer')){
		add_option('torrent_header_footer', '2', 'yes');
	}
	$default_torrent_table_limit = '20';
	if (!get_option('torrent_table_limit')){
		add_option('torrent_table_limit', $default_torrent_table_limit, 'yes');
	}
	$default_torrent_table_name_shortner = '18';
	if (!get_option('torrent_table_name_shortner')){
		add_option('torrent_table_name_shortner', $default_torrent_table_name_shortner, 'yes');
	}
	$default_torrenttable_columns = 'category,name,dl,uploader,comments,size,seeders,leechers,health,external';
	if (!get_option('torrenttable_columns')){
		add_option('torrenttable_columns', $default_torrenttable_columns, 'yes');
	}
	$default_torrenttable_expand = 'size,speed,added';
	if (!get_option('torrenttable_expand')){
		add_option('torrenttable_expand', $default_torrenttable_expand, 'yes');
	}
	$default_torrent_peers_list = 'port,uploaded,downloaded,ratio,left,ready,seed,connected,client,nick';
	if (!get_option('torrent_peers_list')){
		add_option('torrent_peers_list', $default_torrent_peers_list, 'yes');
	}
	$default_torrent_peers_list_admin_limit = '20';
	if (!get_option('torrent_peers_list_admin_limit')){
		add_option('torrent_peers_list_admin_limit', $default_torrent_peers_list_admin_limit, 'yes');
	}
	$default_torrent_peers_list_admin = 'user,torrent,ip,port,uploaded,downloaded,peer-id,connected,seeding,started,last-action';
	if (!get_option('torrent_peers_list_admin')){
		add_option('torrent_peers_list_admin', $default_torrent_peers_list_admin, 'yes');
	}
	$default_torrent_free_leech_admin_limit = '20';
	if (!get_option('torrent_free_leech_admin_limit')){
		add_option('torrent_free_leech_admin_limit', $default_torrent_free_leech_admin_limit, 'yes');
	}
	$default_torrent_free_leech_admin = 'name,category,size,numfiles,banned,owner,nfo,torrentlang';
	if (!get_option('torrent_free_leech_admin')){
		add_option('torrent_free_leech_admin', $default_torrent_free_leech_admin, 'yes');
	}
	$default_agent_bans = '-AZ21,-BC,LIME';
	if (!get_option('agent_bans')){
		add_option('agent_bans', $default_agent_bans, 'yes');
	}
}
function wp_trader_install_categories() {
	global $wpdb;
	$movies_cat = array('cat_name' => 'Movies', 'category_description' => 'A category for movies', 'category_nicename' => 'movies', 'category_parent' => '');
	$tv_cat = array( 'cat_name' => 'TV', 'category_description' => 'A category for TV', 'category_nicename' => 'tv', 'category_parent' => '');
	$documentaries_cat = array( 'cat_name' => 'Documentaries', 'category_description' => 'A category for documentaries', 'category_nicename' => 'documentaries', 'category_parent' => '');
	$games_cat = array( 'cat_name' => 'Games', 'category_description' => 'A category for games', 'category_nicename' => 'games', 'category_parent' => '');
	$apps_cat = array( 'cat_name' => 'Apps', 'category_description' => 'A category for apps', 'category_nicename' => 'apps', 'category_parent' => '');
	$music_cat = array( 'cat_name' => 'Music', 'category_description' => 'A category for music', 'category_nicename' => 'music', 'category_parent' => '');
	$anime_cat = array( 'cat_name' => 'Anime', 'category_description' => 'A category for anime', 'category_nicename' => 'anime', 'category_parent' => '');
	$other_cat = array( 'cat_name' => 'Other', 'category_description' => 'A category for other', 'category_nicename' => 'other', 'category_parent' => '');
		
	if(!is_category( $movies_cat->cat_name )){
		wp_insert_category($movies_cat);
	}
	if(!is_category( $tv_cat->cat_name )){
		wp_insert_category($tv_cat);
	}
	if(!is_category( $documentaries_cat->cat_name )){
		wp_insert_category($documentaries_cat);
	}
	if(!is_category( $games_cat->cat_name )){
		wp_insert_category($games_cat);
	}
	if(!is_category( $apps_cat->cat_name )){
		wp_insert_category($apps_cat);
	}
	if(!is_category( $music_cat->cat_name )){
		wp_insert_category($music_cat);
	}
	if(!is_category( $anime_cat->cat_name )){
		wp_insert_category($anime_cat);
	}
	if(!is_category( $other_cat->cat_name )){
		wp_insert_category($other_cat);
	}
}
function wp_trader_install_pages() {
	global $wpdb;
	if (is_writable(get_stylesheet_directory())) {
		$source = WP_TRADER_ABSPATH . '/templates/announce.php';
		$destination = get_stylesheet_directory() . '/announce.php';
		if (!file_exists($destination) && file_exists($source)) {
			$data = file_get_contents($source);
			$handle = fopen($destination, 'w');
			fwrite($handle, $data);
			fclose($handle);
		}
	}
		
	$page_announce = get_page_by_title( 'Announce' );
	if(!$page_announce){
		$announce_page_title = 'Announce';
		$announce_page_content = '[torrent_announce announce="announce_template"] [/torrent_announce]';
		$announce_page_template = 'announce.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
		$announce_page = array(
			'post_type' => 'page',
			'post_title' => $announce_page_title,
			'post_content' => $announce_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'menu_order' => '4',
			'post_author' => 1,
		);
		$announce_page_id = wp_insert_post($announce_page);
		if(!empty($announce_page_template)){
			update_post_meta($announce_page_id, '_wp_page_template', $announce_page_template);
		}
	}
	
	$announces = get_page_by_title( 'Announce' );
	$announceids = get_page_link($announces->ID);	
	if (!get_option('announce_list')){
		add_option('announce_list', $announceids , 'yes');
	}	
	if (!get_option('passkey_url')){
		add_option('passkey_url', $announceids . '?passkey=%s', 'yes');
	}
	if (is_writable(get_stylesheet_directory())) {
		$source = WP_TRADER_ABSPATH . '/templates/scrape.php';
		$destination = get_stylesheet_directory() . '/scrape.php';
		if (!file_exists($destination) && file_exists($source)) {
			$data = file_get_contents($source);
			$handle = fopen($destination, 'w');
			fwrite($handle, $data);
			fclose($handle);
		}
	}

	$page_scrape = get_page_by_title( 'Scrape' );
	if(!$page_scrape){
		$scrape_page_title = 'Scrape';
		$scrape_page_content = '[torrent_scrape scrape="scrape_template"] [/torrent_scrape]';
		$scrape_page_template = 'scrape.php'; //ex. template-custom.php. Leave blank if you don't want a custom page template.
		$scrape_page = array(
			'post_type' => 'page',
			'post_title' => $scrape_page_title,
			'post_content' => $scrape_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'menu_order' => '5',
			'post_author' => 1,
		);
		$scrape_page_id = wp_insert_post($scrape_page);
		if(!empty($scrape_page_template)){
			update_post_meta($scrape_page_id, '_wp_page_template', $scrape_page_template);
		}
	}
	
	$scrapes = get_page_by_title( 'Scrape' );
	$scrapeids = get_page_link($scrapes->ID);	
	if (!get_option('scrape_list')){
		add_option('scrape_list', $scrapeids , 'yes');
	}	
	if (!get_option('passkey_url')){
		add_option('passkey_url', $scrapeids . '?passkey=%s', 'yes');
	}
	
	$page_upload = get_page_by_title( 'Torrent Upload' );
	if(!$page_upload){
		$new_page_title = 'Torrent Upload';
		$new_page_content = '[torrentupload torrent_up="upload"] [/torrentupload]';
		$new_page = array(
			'post_type' => 'page',
			'post_title' => $new_page_title,
			'post_content' => $new_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'menu_order' => '3',
			'post_author' => 1,
		);
		wp_insert_post($new_page);
	}
		
	$page_browse = get_page_by_title( 'Torrent Browse' );
	if(!$page_browse){
		$torrentbrowse_page_title = 'Torrent Browse';
		$torrentbrowse_page_content = '[torrentbrowse torrent="torrent_browse"] [/torrentbrowse]';
		$torrentbrowse_page = array(
			'post_type' => 'page',
			'post_title' => $torrentbrowse_page_title,
			'post_content' => $torrentbrowse_page_content,
			'post_status' => 'publish',
			'comment_status' => 'closed',
			'ping_status' => 'closed',
			'menu_order' => '2',
			'post_author' => 1,
		);
		wp_insert_post($torrentbrowse_page);
	}
}
function wp_trader_install_system_user() {

	global $wpdb;

	$user_name .= 'System';

	$user_exists .= username_exists( $user_name );

	if ( !$user_exists ) {
		
		$random_password = wp_generate_password( 12, false );

		$user_exists = wp_create_user( $user_name, $random_password );
		
		$created_id = get_user_by('login', $user_name);

		$created_role = 'author';

		wp_update_user( array ('ID' => $created_id->ID, 'role' => $created_role) ) ;
	}

}
?>