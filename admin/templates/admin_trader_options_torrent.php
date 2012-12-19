<?php
/** 
* WP-Trader Torrent Options Administration Screen. 
* @package WP-Trader 
* @subpackage Administration 
**/
include_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

if (isset($_POST["change_options_torrent"]) == "yes") {
		check_admin_referer('wptrader-options-torrent');
		if(isset($_POST['torrent_directory'])){
			update_option('torrent_directory', $_POST['torrent_directory']);
		}
		if(isset($_POST['image_directory'])){
			update_option('image_directory', $_POST['image_directory']);
		}
		if(isset($_POST['nfo_directory'])){
			update_option('nfo_directory', $_POST['nfo_directory']);
		}
		if(isset($_POST['ip_passkey_tracking'])){
			update_option('ip_passkey_tracking', $_POST['ip_passkey_tracking']);
		}
		if(isset($_POST['user_generate_passkey'])){
			update_option('user_generate_passkey', $_POST['user_generate_passkey']);
		}
		if(isset($_POST['wptrader_seed_bonus'])){
			update_option('wptrader_seed_bonus', $_POST['wptrader_seed_bonus']);
		}
		if(isset($_POST['torrent_browse_page'])){
			update_option('torrent_browse_page', $_POST['torrent_browse_page']);
		}
		if(isset($_POST['torrent_upload_wordpress_editor'])){
			update_option('torrent_upload_wordpress_editor', $_POST['torrent_upload_wordpress_editor']);
		}
		if(isset($_POST['torrent_upload_wordpress_editor_css'])){
			update_option('torrent_upload_wordpress_editor_css', $_POST['torrent_upload_wordpress_editor_css']);
		}
		if(isset($_POST['announce_list'])){
			update_option('announce_list', $_POST['announce_list']);
		}
		if(isset($_POST['allow_external'])){
			update_option('allow_external', $_POST['allow_external']);
		}
		if(isset($_POST['allow_nfo_upload'])){
			update_option('allow_nfo_upload', $_POST['allow_nfo_upload']);
		}
		if(isset($_POST['nfo_display_type'])){
			update_option('nfo_display_type', $_POST['nfo_display_type']);
		}
		if(isset($_POST['show_peer_list'])){
			update_option('show_peer_list', $_POST['show_peer_list']);
		}
		if(isset($_POST['show_file_list'])){
			update_option('show_file_list', $_POST['show_file_list']);
		}
		if(isset($_POST['uploaders_only'])){
			update_option('uploaders_only', $_POST['uploaders_only']);
		}
		if(isset($_POST['torrent_role_uploader']) != ''){
			update_option('torrent_roles_uploader', implode('|', $_POST['torrent_role_uploader']));
		}else{
			update_option('torrent_roles_uploader', $_POST['torrent_role_uploader']);
		}
		if(isset($_POST['anonymous_upload'])){
			update_option('anonymous_upload', $_POST['anonymous_upload']);
		}
		if(isset($_POST['passkey_url'])){
			update_option('passkey_url', $_POST['passkey_url']);
		}
		if(isset($_POST['scrape_upload'])){
			update_option('scrape_upload', $_POST['scrape_upload']);
		}
		if(isset($_POST['scrape_upload_force'])){
			update_option('scrape_upload_force', $_POST['scrape_upload_force']);
		}
		if(isset($_POST['upload_rules'])){
			update_option('upload_rules', $_POST['upload_rules']);
		}
		if(isset($_POST['torrent_role']) != ''){
			update_option('torrent_roles', implode('|', $_POST['torrent_role']));
		}else{
			update_option('torrent_roles', $_POST['torrent_role']);
		}
		if(isset($_POST['torrent_header_footer'])){
			update_option('torrent_header_footer', $_POST['torrent_header_footer']);
		}
		if(isset($_POST['torrent_table_limit'])){
			update_option('torrent_table_limit', $_POST['torrent_table_limit']);
		}
		if(isset($_POST['torrent_table_name_shortner'])){
			update_option('torrent_table_name_shortner', $_POST['torrent_table_name_shortner']);
		}
		if(isset($_POST['tc_ex']) != ''){
			update_option('torrenttable_columns', $_POST['tc_ex']);
		}
		if(isset($_POST['te_ex']) != ''){
			update_option('torrenttable_expand', $_POST['te_ex']);
		}
		if(isset($_POST['tp_ex']) != ''){
			update_option('torrent_peers_list', $_POST['tp_ex']);
		}
		if(isset($_POST['torrent_peers_list_admin_limit'])){
			update_option('torrent_peers_list_admin_limit', $_POST['torrent_peers_list_admin_limit']);
		}
		if(isset($_POST['tpa_ex']) != ''){
			update_option('torrent_peers_list_admin', $_POST['tpa_ex']);
		}
		if(isset($_POST['torrent_free_leech_admin_limit'])){
			update_option('torrent_free_leech_admin_limit', $_POST['torrent_free_leech_admin_limit']);
		}
		if(isset($_POST['tfla_ex']) != ''){
			update_option('torrent_free_leech_admin', $_POST['tfla_ex']);
		}
		if(isset($_POST['minimum_gigsa'])){
			update_option('minimum_gigsa', $_POST['minimum_gigsa']);
		}
		if(isset($_POST['minimum_ratioa'])){
			update_option('minimum_ratioa', $_POST['minimum_ratioa']);
		}
		if(isset($_POST['minimum_waita'])){
			update_option('minimum_waita', $_POST['minimum_waita']);
		}
		if(isset($_POST['minimum_gigsb'])){
			update_option('minimum_gigsb', $_POST['minimum_gigsb']);
		}
		if(isset($_POST['minimum_ratiob'])){
			update_option('minimum_ratiob', $_POST['minimum_ratiob']);
		}
		if(isset($_POST['minimum_waitb'])){
			update_option('minimum_waitb', $_POST['minimum_waitb']);
		}
		if(isset($_POST['minimum_gigsc'])){
			update_option('minimum_gigsc', $_POST['minimum_gigsc']);
		}
		if(isset($_POST['minimum_ratioc'])){
			update_option('minimum_ratioc', $_POST['minimum_ratioc']);
		}
		if(isset($_POST['minimum_waitc'])){
			update_option('minimum_waitc', $_POST['minimum_waitc']);
		}
		if(isset($_POST['minimum_gigsd'])){
			update_option('minimum_gigsd', $_POST['minimum_gigsd']);
		}
		if(isset($_POST['minimum_ratiod'])){
			update_option('minimum_ratiod', $_POST['minimum_ratiod']);
		}
		if(isset($_POST['minimum_waitd'])){
			update_option('minimum_waitd', $_POST['minimum_waitd']);
		}
		if(isset($_POST['image_size'])){
			update_option('image_size', $_POST['image_size']);
		}
		if($_POST['ait_ex'] != ''){
			update_option('image_types', implode(',', $_POST['ait_ex']));
		}
		if(isset($_POST['nfo_size'])){
			update_option('nfo_size', $_POST['nfo_size']);
		}
		if(isset($_POST['free_leech'])){
			update_option('free_leech', $_POST['free_leech']);
		}
		if(isset($_POST['agent_bans'])){
			update_option('agent_bans', $_POST['agent_bans']);
		}
		
		$browse = get_page_by_title( 'Torrent Browse' );
		$browseid = $browse->ID;
		if ($_POST['torrent_browse_page'] != 1){
			wp_delete_post($browseid, true);
		}else if (!$browse && $_POST['torrent_browse_page'] != 0){
			$torrentbrowse_page_title = 'Torrent Browse';
			$torrentbrowse_page_content = '[torrentbrowse torrent="torrent_browse"] [/torrentbrowse]';
			$torrentbrowse_page = array(
				'post_type' => 'page',
				'post_title' => $torrentbrowse_page_title,
				'post_content' => $torrentbrowse_page_content,
				'post_status' => 'publish',
				'menu_order' => '2',
				'post_author' => 1,
			);
			wp_insert_post($torrentbrowse_page);
		}
		
		$errorheader = "Updated";
		$errormessage = "WP-Trader options has been updated.";
		wptrader_update($errorheader, $errormessage);
}else if (isset($_POST['move_announce'])){
		check_admin_referer('wptrader-missing-announce');
		$source = WP_TRADER_ABSPATH . '/templates/announce.php';
		$destination = get_stylesheet_directory() . '/announce.php';
		if (!file_exists($destination) && file_exists($source)) {
			$data = file_get_contents($source);
			$handle = fopen($destination, "w");
			fwrite($handle, $data);
			fclose($handle);
			$errorheader = "Updated";
			$errormessage = "The announce has been moved.";
			wptrader_update($errorheader, $errormessage);
		}
}else if (isset($_POST['move_scrape'])){
	check_admin_referer('wptrader-missing-scrape');
	$scrape_source = WP_TRADER_ABSPATH . '/templates/scrape.php';
	$destination_scrape = get_stylesheet_directory() . '/scrape.php';
	if (!file_exists($destination_scrape) && file_exists($scrape_source)) {
		$data_scrape = file_get_contents($scrape_source);
		$handle_scrape = fopen($destination_scrape, "w");
		fwrite($handle_scrape, $data_scrape);
		fclose($handle_scrape);
		$errorheader = "Updated";
		$errormessage = "The scrape has been moved.";
		wptrader_update($errorheader, $errormessage);
	}
}
	$ip_passkey_tracking_yes = (get_option('ip_passkey_tracking') == 1) ? 'selected="selected"' : '';
	$ip_passkey_tracking_no = (get_option('ip_passkey_tracking') == 0) ? 'selected="selected"' : '';
	$user_generate_passkey_yes = (get_option('user_generate_passkey') == 1) ? 'selected="selected"' : '';
	$user_generate_passkey_no = (get_option('user_generate_passkey') == 0) ? 'selected="selected"' : '';
	$wptrader_seed_bonus_yes = (get_option('user_generate_passkey') == 1) ? 'selected="selected"' : '';
	$wptrader_seed_bonus_no = (get_option('user_generate_passkey') == 0) ? 'selected="selected"' : '';
	$members_only_yes = (get_option('members_only') == 1);
	$members_only_no = (get_option('members_only') == 0);
	$torrent_upload_wordpress_editor_yes = (get_option('torrent_upload_wordpress_editor') == 1) ? 'selected="selected"' : '';
	$torrent_upload_wordpress_editor_no = (get_option('torrent_upload_wordpress_editor') == 0) ? 'selected="selected"' : '';
	$torrent_browse_page_yes = (get_option('torrent_browse_page') == 1) ? 'selected="selected"' : '';
	$torrent_browse_page_no = (get_option('torrent_browse_page') == 0) ? 'selected="selected"' : '';
	$torrent_header_yes = (get_option('torrent_header_footer') == 1) ? 'checked="checked"' : '';
	$torrent_footer_yes = (get_option('torrent_header_footer') == 0) ? 'checked="checked"' : '';
	$torrent_both_yes = (get_option('torrent_header_footer') == 2) ? 'checked="checked"' : '';
	$allow_external_yes = (get_option('allow_external') == 1) ? 'selected="selected"' : '';
	$allow_external_no = (get_option('allow_external') == 0) ? 'selected="selected"' : '';
	$allow_nfo_upload_yes = (get_option('allow_nfo_upload') == 1) ? 'selected="selected"' : '';
	$allow_nfo_upload_no = (get_option('allow_nfo_upload') == 0) ? 'selected="selected"' : '';
	$nfo_display_type_yes = (get_option('nfo_display_type') == 1) ? 'selected="selected"' : '';
	$nfo_display_type_no = (get_option('nfo_display_type') == 0) ? 'selected="selected"' : '';
	$show_peer_list_yes = (get_option('show_peer_list') == 1) ? 'selected="selected"' : '';
	$show_peer_list_no = (get_option('show_peer_list') == 0) ? 'selected="selected"' : '';
	$show_file_list_yes = (get_option('show_file_list') == 1) ? 'selected="selected"' : '';
	$show_file_list_no = (get_option('show_file_list') == 0) ? 'selected="selected"' : '';
	$uploaders_only_yes = (get_option('uploaders_only') == 1) ? 'selected="selected"' : '';
	$uploaders_only_no = (get_option('uploaders_only') == 0) ? 'selected="selected"' : '';
	$anonymous_upload_yes = (get_option('anonymous_upload') == 1) ? 'selected="selected"' : '';
	$anonymous_upload_no = (get_option('anonymous_upload') == 0) ? 'selected="selected"' : '';
	$scrape_upload_yes = (get_option('scrape_upload') == 1) ? 'selected="selected"' : '';
	$scrape_upload_no = (get_option('scrape_upload') == 0) ? 'selected="selected"' : '';
	$scrape_upload_force_yes = (get_option('scrape_upload_force') == 1) ? 'selected="selected"' : '';
	$scrape_upload_force_no = (get_option('scrape_upload_force') == 0) ? 'selected="selected"' : '';
	$free_leech_yes = (get_option('free_leech') == 1) ? 'selected="selected"' : '';
	$free_leech_no = (get_option('free_leech') == 0) ? 'selected="selected"' : '';
?>
	<div data-role="page" data-theme="d" class="form-table">
	<?php wptrader_header(); ?>
	<div data-role="content">
	<?php
	donate_header();
	wptrader_missing_announce();
	wptrader_missing_scrape();
	?>
	<form action="admin.php?page=wptrader-options-torrent" method="post" data-ajax="false">
		<input type="hidden" name="change_options_torrent" value="yes" />
		<?php wp_nonce_field('wptrader-options-torrent') ?>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Torrent Directory</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_directory_upload" class="wp_trader_settings"><?php echo wptrader_help_file('std', 'stdu'); ?></div>
					<label for="torrent_directory"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_directory_upload" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Upload Directory</b></div></label>
						<input type="text" name="torrent_directory" id="torrent_directory" value="<?php echo esc_attr( get_option('torrent_directory') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_directory_image" class="wp_trader_settings"><?php echo wptrader_help_file('std', 'stdi'); ?></div>
					<label for="image_directory"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_directory_image" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Image Upload Directory</b></div></label>
						<input type="text" name="image_directory" id="image_directory" value="<?php echo esc_attr( get_option('image_directory') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_directory_nfo" class="wp_trader_settings"><?php echo wptrader_help_file('std', 'stdn'); ?></div>
					<label for="nfo_directory"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_directory_nfo" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>NFO Upload Directory</b></div></label>
						<input type="text" name="nfo_directory" id="nfo_directory" value="<?php echo esc_attr( get_option('nfo_directory') ); ?>" />
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<?php
				global $wp_version;
				if ($wp_version >= '3.3'){
				?>
					<h3>Torrent Upload Description Editor</h3>
					<div data-role="fieldcontain">
						<div id="simpleraw_settings_torrent_editor_use" class="wp_trader_settings"><?php echo wptrader_help_file('ste', 'steu'); ?></div>
						<label for="torrent_upload_wordpress_editor"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_editor_use" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Use Wordpress Editor</b></div></label>
							<select name="torrent_upload_wordpress_editor" id="torrent_upload_wordpress_editor" data-role="slider" data-theme="a">
								<option value="0" <?php echo $torrent_upload_wordpress_editor_no; ?> >No</option>
								<option value="1" <?php echo $torrent_upload_wordpress_editor_yes; ?> >Yes</option>
							</select> 
					</div>
					<div data-role="fieldcontain">
						<div id="simpleraw_settings_torrent_editor_css" class="wp_trader_settings"><?php echo wptrader_help_file('ste', 'stec'); ?></div>
						<label for="torrent_upload_wordpress_editor_css"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_editor_css" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Css For Wordpress Editor</b></div></label>
							<textarea name="torrent_upload_wordpress_editor_css" id="torrent_upload_wordpress_editor_css" rows="2" cols="75"><?php echo esc_attr( get_option('torrent_upload_wordpress_editor_css') ); ?></textarea>
					</div>
				<?php
				}
				?>
			</div>
            <div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Main Torrent Settings</h3>
				<?php if($members_only_yes) { ?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_ippasskey" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stip'); ?></div>
					<label for="ip_passkey_tracking"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_ippasskey" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>IP/Passkey Tracking</b></div></label>
						<select name="ip_passkey_tracking" id="ip_passkey_tracking" data-role="slider" data-theme="a">
							<option value="0" <?php echo $ip_passkey_tracking_no; ?> >IP</option>
							<option value="1" <?php echo $ip_passkey_tracking_yes; ?> >Passkey</option>
						</select>
				</div>
				<?php if($ip_passkey_tracking_yes) { ?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_user_generate_passkey" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stugp'); ?></div>
					<label for="user_generate_passkey"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_user_generate_passkey" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>User Generate Passkey</b></div></label>
						<select name="user_generate_passkey" id="user_generate_passkey" data-role="slider" data-theme="a">
							<option value="0" <?php echo $user_generate_passkey_no; ?> >No</option>
							<option value="1" <?php echo $user_generate_passkey_yes; ?> >Yes</option>
						</select>
				</div>
				<?php } ?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_user_wptrader_seed_bonus" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stwsb'); ?></div>
					<label for="wptrader_seed_bonus"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_wptrader_seed_bonus" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Enable Seed Bonus</b></div></label>
						<select name="wptrader_seed_bonus" id="wptrader_seed_bonus" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wptrader_seed_bonus_no; ?> >No</option>
							<option value="1" <?php echo $wptrader_seed_bonus_yes; ?> >Yes</option>
						</select>
				</div>
				<?php } ?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_browse" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stb'); ?></div>
					<label for="torrent_browse_page"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_browse" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Browse Page</b></div></label>
						<select name="torrent_browse_page" id="torrent_browse_page" data-role="slider" data-theme="a">
							<option value="0" <?php echo $torrent_browse_page_no; ?> >No</option>
							<option value="1" <?php echo $torrent_browse_page_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_external" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'ste'); ?></div>
					<label for="allow_external"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_external" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Allow External</b></div></label>
						<select name="allow_external" id="allow_external" data-role="slider" data-theme="a">
							<option value="0" <?php echo $allow_external_no; ?> >No</option>
							<option value="1" <?php echo $allow_external_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_allow_nfo" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stun'); ?></div>
					<label for="allow_nfo_upload"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_allow_nfo" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Allow NFO Upload</b></div></label>
						<select name="allow_nfo_upload" id="allow_nfo_upload" data-role="slider" data-theme="a">
							<option value="0" <?php echo $allow_nfo_upload_no; ?> >No</option>
							<option value="1" <?php echo $allow_nfo_upload_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
				<?php
					if (extension_loaded('gd')){
				?>
						<div id="simpleraw_settings_torrent_display_nfo" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stdn'); ?></div>
						<label for="nfo_display_type"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_display_nfo" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>NFO Display PNG</b></div></label>
							<select name="nfo_display_type" id="nfo_display_type" data-role="slider" data-theme="a">
								<option value="0" <?php echo $nfo_display_type_no; ?> >No</option>
								<option value="1" <?php echo $nfo_display_type_yes; ?> >Yes</option>
							</select>
				<?php
					}
				?>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_peers_list" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stpl'); ?></div>
					<label for="show_peer_list"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_peers_list" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Show Peer List</b></div></label>
						<select name="show_peer_list" id="show_peer_list" data-role="slider" data-theme="a">
								<option value="0" <?php echo $show_peer_list_no; ?> >No</option>
								<option value="1" <?php echo $show_peer_list_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_files_list" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stfl'); ?></div>
					<label for="show_file_list"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_files_list" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Show File List</b></div></label>
						<select name="show_file_list" id="show_file_list" data-role="slider" data-theme="a">
								<option value="0" <?php echo $show_file_list_no; ?> >No</option>
								<option value="1" <?php echo $show_file_list_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_uploaders_only" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stuo'); ?></div>
					<label for="uploaders_only"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_uploaders_only" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Uploaders Only</b></div></label>
						<select name="uploaders_only" id="uploaders_only" data-role="slider" data-theme="a">
								<option value="0" <?php echo $uploaders_only_no; ?> >No</option>
								<option value="1" <?php echo $uploaders_only_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
				<?php
					if ($uploaders_only_yes){
				?>
					<fieldset data-role="controlgroup">
						<div id="simpleraw_settings_torrent_uploaders_only_classes" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stuoc'); ?></div>
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_uploaders_only_classes" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Uploader Only Classes</b></div></legend>
						<?php
							global $wp_roles;
							$uoc = '';
							$all_roles_uploader = $wp_roles->roles;
							foreach ( $all_roles_uploader as $role_uploader => $details_uploader ) {
								$torrent_role_uploader = translate_user_role( $details_uploader['name'] );
								$torrent_roles_uploader = array_map('trim', explode('|', get_option('torrent_roles_uploader')));
								if (in_array($torrent_role_uploader, $torrent_roles_uploader)){
									$torrent_roles_uploader = "checked='checked'";
								}
								?>
									<input type='checkbox' name='torrent_role_uploader[]' class='custom' <?php echo $torrent_roles_uploader; ?> value='<?php echo $torrent_role_uploader; ?>' id='<?php echo $torrent_role_uploader; ?>' />
										<label for='<?php echo $torrent_role_uploader; ?>'><?php echo esc_attr($torrent_role_uploader); ?></label>
								<?php
							}
				?>
					</fieldset>
				<?php
					}
				?>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_anonymous" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stau'); ?></div>
					<label for="anonymous_upload"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_anonymous" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Anonymous Upload</b></div></label>
						<select name="anonymous_upload" id="anonymous_upload" data-role="slider" data-theme="a">
								<option value="0" <?php echo $anonymous_upload_no; ?> >No</option>
								<option value="1" <?php echo $anonymous_upload_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_passkey_url" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stpu'); ?></div>
					<label for="passkey_url"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_passkey_url" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Passkey Url</b></div></label>
						<textarea name="passkey_url" id="passkey_url" rows="2" cols="75"><?php echo esc_attr( get_option('passkey_url') ); ?></textarea>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_scrape" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'sts'); ?></div>
					<label for="scrape_upload"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_scrape" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Upload Scrape</b></div></label>
						<select name="scrape_upload" id="scrape_upload" data-role="slider" data-theme="a">
								<option value="0" <?php echo $scrape_upload_no; ?> >No</option>
								<option value="1" <?php echo $scrape_upload_yes; ?> >Yes</option>
						</select>
				</div>
				<?php
				if($scrape_upload_yes){
				?>
					<div data-role="fieldcontain">
						<div id="simpleraw_settings_torrent_scrape_upload_force" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stsf'); ?></div>
						<label for="scrape_upload_force"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_scrape_upload_force" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Force Upload Scrape</b></div></label>
							<select name="scrape_upload_force" id="scrape_upload_force" data-role="slider" data-theme="a">
									<option value="0" <?php echo $scrape_upload_force_no; ?> >No</option>
									<option value="1" <?php echo $scrape_upload_force_yes; ?> >Yes</option>
							</select>
					</div>
				<?php
				}
				?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_upload_rules" class="wp_trader_settings"><?php echo wptrader_help_file('st', 'stur'); ?></div>
					<label for="upload_rules"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_upload_rules" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Upload Rules</b></div></label>
						<textarea name="upload_rules" id="upload_rules"><?php echo esc_attr( get_option('upload_rules') ); ?></textarea>
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Announce Settings</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_announce_list" class="wp_trader_settings"><?php echo wptrader_help_file('sa', 'sal'); ?></div>
					<label for="announce_list"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_announce_list" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Announce List</b></div></label>
						<textarea name="announce_list" id="announce_list"><?php echo esc_attr( get_option('announce_list') ); ?></textarea>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_announce_agent_bans" class="wp_trader_settings"><?php echo wptrader_help_file('sa', 'sab'); ?></div>
					<label for="agent_bans"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_announce_agent_bans" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Agent Bans</b></div></label>
						<textarea type="text" name="agent_bans" id="agent_bans"><?php echo esc_attr( get_option('agent_bans') ); ?></textarea>
				</div>
			</div>
            <div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Torrent Table</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_header_footer" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'stthf'); ?></div>
					<fieldset data-role="controlgroup" data-type="horizontal">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_header_footer" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Table Header/Footer</b></div></legend>
							<label for="torrent_header_footer_1">Header</label>
								<input type="radio" name="torrent_header_footer" id="torrent_header_footer_1" value="1" <?php echo $torrent_header_yes; ?> />
							<label for="torrent_header_footer_0">Footer</label>
								<input type="radio" name="torrent_header_footer" id="torrent_header_footer_0" value="0" <?php echo $torrent_footer_yes; ?> />
							<label for="torrent_header_footer_2">Both</label>
								<input type="radio" name="torrent_header_footer" id="torrent_header_footer_2" value="2" <?php echo $torrent_both_yes; ?> />
					</fieldset>
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_table_limit" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttl'); ?></div>
					<label for="torrent_table_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Table Limit</b></div></label>
						<input type="text" name="torrent_table_limit" id="torrent_table_limit" value="<?php echo esc_attr( get_option('torrent_table_limit') ); ?>" />
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_table_shortner" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'stts'); ?></div>
					<label for="torrent_table_name_shortner"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_shortner" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Name Shortner</b></div></label></th>
						<input type="text" name="torrent_table_name_shortner" id="torrent_table_name_shortner" value="<?php echo esc_attr( get_option('torrent_table_name_shortner') ); ?>" />
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_table_columns" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttc'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_columns" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Table Columns</b></div></legend>
						<?php
						$tc_args = array('category', 'name', 'dl', 'uploader', 'comments', 'completed', 'size', 'seeders', 'leechers', 'health', 'external', 'wait', 'rating', 'added', 'nfo');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_torrenttable" class="connectedSortable_torrenttable">
												<?php
													foreach ( $tc_args as $tc_ex ){
														$torrenttable_columns = array_map('trim', explode(',', get_option('torrenttable_columns')));
														if (!in_array($tc_ex, $torrenttable_columns)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tc_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tc_ex); ?>&nbsp;&nbsp;</h3>
															</div>
														<?php
														}
							
													}
												?>
												</div>
											</div>
											<br class="clear">
									</div>
									<br class="clear">
							</div>
						</div>
						<div data-role="controlgroup">
							<div class='ui-block-b'>
								<div class="wptrader_sortable_head"><h3>Enabled</h3></div>
									<div id="wptrader_sortable_column_holder">
										<div class="description">
											These are the default columns. Drag them up and down to sort them to show how you want.
										</div>
										<div id="wptrader_sortable_column_list">
											<div id="sortable2_torrenttable" name="todb_tcex" class="connectedSortable_torrenttable">
												<?php
												$torrenttable_columns = array_map('trim', explode(',', get_option('torrenttable_columns')));
												foreach ( $torrenttable_columns as $tc_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tc_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tc_exss); ?>&nbsp;&nbsp;</h3>
													</div>
						
												<?php
												}
												?>
											</div>
										</div>
										<br class="clear">
									</div>
									<br class="clear">
							</div>
							<input type="hidden" name="tc_ex" id="todb_tcex" value="<?php echo esc_attr(get_option('torrenttable_columns')); ?>">
						</div>
					</fieldset>
				</div>
				<hr>
				<div data-role="fieldcontain" class="ui-grid-a">
					<div id="simpleraw_settings_torrent_table_expand" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'stte'); ?></div>
					<fieldset data-role="controlgroup">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_expand" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Table Expand</b></div></legend>
						<?php
						$te_args = array('size', 'speed', 'added', 'tracker', 'completed');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_tableexpand" class="connectedSortable_tableexpand">
												<?php
													foreach ( $te_args as $te_ex ){
														$torrenttable_expand = array_map('trim', explode(',', get_option('torrenttable_expand')));
														if (!in_array($te_ex, $torrenttable_expand)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($te_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($te_ex); ?>&nbsp;&nbsp;</h3>
															</div>
														<?php
														}
							
													}
												?>
												</div>
											</div>
											<br class="clear">
									</div>
									<br class="clear">
							</div>
						</div>
						<div data-role="controlgroup">
							<div class='ui-block-b'>
								<div class="wptrader_sortable_head"><h3>Enabled</h3></div>
									<div id="wptrader_sortable_column_holder">
										<div class="description">
											These are the default columns. Drag them up and down to sort them to show how you want.
										</div>
										<div id="wptrader_sortable_column_list">
											<div id="sortable2_tableexpand" name="todb_teex" class="connectedSortable_tableexpand">
												<?php
												$torrenttable_expand = array_map('trim', explode(',', get_option('torrenttable_expand')));
												foreach ( $torrenttable_expand as $te_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($te_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($te_exss); ?>&nbsp;&nbsp;</h3>
													</div>
						
												<?php
												}
												?>
											</div>
										</div>
										<br class="clear">
									</div>
									<br class="clear">
							</div>
							<input type="hidden" name="te_ex" id="todb_teex" value="<?php echo esc_attr(get_option('torrenttable_expand')); ?>">
						</div>
					</fieldset>
				</div>
				<hr>
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<div id="simpleraw_settings_torrent_table_peers" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttp'); ?></div>
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_peers" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Peers List</b></div></legend>
						<?php
						$tp_args = array('port', 'uploaded', 'downloaded', 'ratio', 'left', 'ready', 'seed', 'connected', 'client', 'nick');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_peerslist" class="connectedSortable_peerslist">
												<?php
													foreach ( $tp_args as $tp_ex ){
														$torrent_peers_list = array_map('trim', explode(',', get_option('torrent_peers_list')));
														if (!in_array($tp_ex, $torrent_peers_list)){
														?>
																<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tp_ex); ?>">
																	<h3>&nbsp;&nbsp;<?php echo esc_attr($tp_ex); ?>&nbsp;&nbsp;</h3>
																</div>
														<?php
														}
							
													}
												?>
												</div>
											</div>
											<br class="clear">
									</div>
									<br class="clear">
							</div>
						</div>
						<div data-role="controlgroup">
							<div class='ui-block-b'>
								<div class="wptrader_sortable_head"><h3>Enabled</h3></div>
									<div id="wptrader_sortable_column_holder">
										<div class="description">
											These are the default columns. Drag them up and down to sort them to show how you want.
										</div>
										<div id="wptrader_sortable_column_list">
											<div id="sortable2_peerslist" name="todb_tpex" class="connectedSortable_peerslist">
												<?php
												$torrent_peers_list = array_map('trim', explode(',', get_option('torrent_peers_list')));
												foreach ( $torrent_peers_list as $tp_exss ){
												?>
													<div class="ui-state-highlight">
														<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tp_exss); ?>">
															<h3>&nbsp;&nbsp;<?php echo esc_attr($tp_exss); ?>&nbsp;&nbsp;</h3>
														</div>
													</div>
						
												<?php
												}
												?>
											</div>
										</div>
										<br class="clear">
									</div>
									<br class="clear">
							</div>
							<input type="hidden" name="tp_ex" id="todb_tpex" value="<?php echo esc_attr(get_option('torrent_peers_list')); ?>">
						</div>
					</fieldset>
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_torrent_peers_list_admin_limit" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttpal'); ?></div>
					<label for="torrent_peers_list_admin_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_torrent_peers_list_admin_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Peers List Admin Limit</b></div></label>
						<input type="text" name="torrent_peers_list_admin_limit" id="torrent_peers_list_admin_limit" value="<?php echo esc_attr( get_option('torrent_peers_list_admin_limit') ); ?>" />
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_table_peers_admin" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttpa'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_peers_admin" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Peers List Admin</b></div></legend>
						<?php
						$tpa_args = array('user', 'torrent', 'ip', 'port', 'uploaded', 'downloaded', 'peer-id', 'connected', 'seeding', 'started', 'last-action');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_peerslistadmin" class="connectedSortable_peerslistadmin">
												<?php
													foreach ( $tpa_args as $tpa_ex ){
														$torrent_peers_list_admin = array_map('trim', explode(',', get_option('torrent_peers_list_admin')));
														if (!in_array($tpa_ex, $torrent_peers_list_admin)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tpa_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tpa_ex); ?>&nbsp;&nbsp;</h3>
															</div>
														<?php
														}
							
													}
												?>
												</div>
											</div>
											<br class="clear">
									</div>
									<br class="clear">
							</div>
						</div>
						<div data-role="controlgroup">
							<div class='ui-block-b'>
								<div class="wptrader_sortable_head"><h3>Enabled</h3></div>
									<div id="wptrader_sortable_column_holder">
										<div class="description">
											These are the default columns. Drag them up and down to sort them to show how you want.
										</div>
										<div id="wptrader_sortable_column_list">
											<div id="sortable2_peerslistadmin" name="todb_tpaex" class="connectedSortable_peerslistadmin">
												<?php
												$torrent_peers_list_admin = array_map('trim', explode(',', get_option('torrent_peers_list_admin')));
												foreach ( $torrent_peers_list_admin as $tpa_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tpa_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tpa_exss); ?>&nbsp;&nbsp;</h3>
													</div>
						
												<?php
												}
												?>
											</div>
										</div>
										<br class="clear">
									</div>
									<br class="clear">
							</div>
							<input type="hidden" name="tpa_ex" id="todb_tpaex" value="<?php echo esc_attr(get_option('torrent_peers_list_admin')); ?>">
						</div>
					</fieldset>
				</div>
				<?php if($free_leech_yes){ ?>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_torrent_free_leech_admin_limit" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttfal'); ?></div>
					<label for="torrent_free_leech_admin_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_torrent_free_leech_admin_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Freeleech Admin Limit</b></div></label>
						<input type="text" name="torrent_free_leech_admin_limit" id="torrent_free_leech_admin_limit" value="<?php echo esc_attr( get_option('torrent_free_leech_admin_limit') ); ?>" />
				</div>
				<hr>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_torrent_table_freeleech_admin" class="wp_trader_settings"><?php echo wptrader_help_file('stt', 'sttfa'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_torrent_table_freeleech_admin" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Torrent Freeleech Admin</b></div></legend>
						<?php
						$tfla_args = array('id', 'post_id', 'attachment_id', 'info_hash', 'name', 'filename', 'save_as', 'category', 'size', 'numfiles', 'banned', 'owner', 'nfo', 'announce', 'torrentlang');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_freeleechadmin" class="connectedSortable_freeleechadmin">
												<?php
													foreach ( $tfla_args as $tfla_ex ){
														$torrent_free_leech_admin = array_map('trim', explode(',', get_option('torrent_free_leech_admin')));
														if (!in_array($tfla_ex, $torrent_free_leech_admin)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tfla_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tfla_ex); ?>&nbsp;&nbsp;</h3>
															</div>
														<?php
														}
							
													}
												?>
												</div>
											</div>
											<br class="clear">
									</div>
									<br class="clear">
							</div>
						</div>
						<div data-role="controlgroup">
							<div class='ui-block-b'>
								<div class="wptrader_sortable_head"><h3>Enabled</h3></div>
									<div id="wptrader_sortable_column_holder">
										<div class="description">
											These are the default columns. Drag them up and down to sort them to show how you want.
										</div>
										<div id="wptrader_sortable_column_list">
											<div id="sortable2_freeleechadmin" name="todb_tflaex" class="connectedSortable_freeleechadmin">
												<?php
												$torrent_free_leech_admin = array_map('trim', explode(',', get_option('torrent_free_leech_admin')));
												foreach ( $torrent_free_leech_admin as $tfla_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tfla_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tfla_exss); ?>&nbsp;&nbsp;</h3>
													</div>
						
												<?php
												}
												?>
											</div>
										</div>
										<br class="clear">
									</div>
									<br class="clear">
							</div>
							<input type="hidden" name="tfla_ex" id="todb_tflaex" value="<?php echo esc_attr(get_option('torrent_free_leech_admin')); ?>">
						</div>
					</fieldset>
				</div>
				<?php } ?>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>File Uploads</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_file_uploads_image_size" class="wp_trader_settings"><?php echo wptrader_help_file('sfu', 'sfuis'); ?></div>
					<label for="image_size"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_file_uploads_image_size" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Max Image Size</b></div></label>
						<input type="text" name="image_size" value="<?php echo esc_attr( get_option('image_size') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_file_uploads_allowed_types" class="wp_trader_settings"><?php echo wptrader_help_file('sfu', 'sfuat'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<label for="image_types"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_file_uploads_allowed_types" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Allowed Image Types</b></div></label>
						<?php
							$ait_args = array('image/gif', 'image/bmp', 'image/x-windows-bmp', 'image/jpeg', 'image/pjpeg');
							$ait_argss = array('image/png', 'image/x-quicktime', 'image/tiff', 'image/x-tiff');
						?>
							<div data-role="controlgroup">
								<div class='ui-block-a'>
						<?php
								foreach ( $ait_args as $ait_ex ){
									$image_types = array_map('trim', explode(',', get_option('image_types')));
									$aits_exs = str_replace("image/", "", "". $ait_ex ."");
									if (in_array($ait_ex, $image_types)){
										$image_types = "checked='checked'";
									}
									?>
									<input type='checkbox' name='ait_ex[]' class='custom' <?php echo $image_types; ?> value='<?php echo $ait_ex; ?>' id='<?php echo $ait_ex; ?>' />
										<label for='<?php echo $ait_ex; ?>'><?php echo esc_attr($aits_exs); ?></label>
									<?php
								}
									?>
								</div>
							</div>
							<div data-role="controlgroup">
								<div class='ui-block-b'>
						<?php
								foreach ( $ait_argss as $ait_exs ){
									$image_typess = array_map('trim', explode(',', get_option('image_types')));
									$aits_exs = str_replace("image/", "", "". $ait_exs ."");
									if (in_array($ait_exs, $image_typess)){
										$image_typess = "checked='checked'";
									}
									?>
									<input type='checkbox' name='ait_ex[]' class='custom' <?php echo $image_typess; ?> value='<?php echo $ait_exs; ?>' id='<?php echo $ait_exs; ?>' />
										<label for='<?php echo $ait_exs; ?>'><?php echo esc_attr($aits_exs); ?></label>
									<?php
								}
									?>
								</div>
							</div>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_file_uploads_nfo" class="wp_trader_settings"><?php echo wptrader_help_file('sfu', 'sfunf'); ?></div>
					<label for="nfo_size"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_file_uploads_nfo" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>NFO Size</b></div></label>
						<input type="text" name="nfo_size" value="<?php echo esc_attr( get_option('nfo_size') ); ?>" />
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Free Leech</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_free_leech_onoff" class="wp_trader_settings"><?php echo wptrader_help_file('sfl', 'sflo'); ?></div>
					<label for="free_leech"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_free_leech_onoff" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>On / Off</b></div></label>
						<select name="free_leech" id="free_leech" data-role="slider" data-theme="a">
							<option value="0" <?php echo $free_leech_no; ?> >No</option>
							<option value="1" <?php echo $free_leech_yes; ?> >Yes</option>
						</select>
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Wait Times</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_classes" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtcs'); ?></div>
					<fieldset data-role="controlgroup">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_classes" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Wait Classes</b></div></legend>
					<?php
						global $wp_roles;
						$p = '';
						$all_roles = $wp_roles->roles;
				
						foreach ( $all_roles as $role => $details ) {
							$torrent_role = translate_user_role( $details['name'] );
							$torrent_roles = array_map('trim', explode('|', get_option('torrent_roles')));
							if (in_array($torrent_role, $torrent_roles)){
								$torrent_roles = "checked='checked'";
							}
							$p = "\n\t<input type='checkbox' id='$torrent_role' class='custom' name='torrent_role[]' ".$torrent_roles." value='" . $torrent_role . "' /><label for='".$torrent_role."'>$torrent_role</label>";
						echo $p;
						}
					?>
					</fieldset>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_waita" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtw'); ?></div>
					<label for="minimum_gigsa"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_waita" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Gigs Needed For <?php echo esc_attr( get_option('minimum_waita') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_gigsa" value="<?php echo esc_attr( get_option('minimum_gigsa') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_ratioa" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtr'); ?></div>
					<label for="minimum_ratioa"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_ratioa" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Ratio Needed For <?php echo esc_attr( get_option('minimum_waita') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_ratioa" value="<?php echo esc_attr( get_option('minimum_ratioa') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_a" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swta'); ?></div>
					<label for="minimum_waita"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_a" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Minimum Wait Time</b></div></label>
						<input type="text" name="minimum_waita" value="<?php echo esc_attr( get_option('minimum_waita') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_waitb" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtwb'); ?></div>
					<label for="minimum_gigsb"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_waitb" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Gigs Needed For <?php echo esc_attr( get_option('minimum_waitb') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_gigsb" value="<?php echo esc_attr( get_option('minimum_gigsb') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_ratiob" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtrb'); ?></div>
					<label for="minimum_ratiob"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_ratiob" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Ratio Needed For <?php echo esc_attr( get_option('minimum_waitb') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_ratiob" value="<?php echo esc_attr( get_option('minimum_ratiob') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_b" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtb'); ?></div>
					<label for="minimum_waitb"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_b" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Minimum Wait Time</b></div></label>
						<input type="text" name="minimum_waitb" value="<?php echo esc_attr( get_option('minimum_waitb') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_waitc" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtwc'); ?></div>
					<label for="minimum_gigsc"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_waitc" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Gigs Needed For <?php echo esc_attr( get_option('minimum_waitc') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_gigsc" value="<?php echo esc_attr( get_option('minimum_gigsc') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_ratioc" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtrc'); ?></div>
					<label for="minimum_ratioc"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_ratioc" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Ratio Needed For <?php echo esc_attr( get_option('minimum_waitc') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_ratioc" value="<?php echo esc_attr( get_option('minimum_ratioc') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_c" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtc'); ?></div>
					<label for="minimum_waitc"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_c" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Minimum Wait Time</b></div></label>
						<input type="text" name="minimum_waitc" value="<?php echo esc_attr( get_option('minimum_waitc') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_waitd" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtwd'); ?></div>
					<label for="minimum_gigsd"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_waitd" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Gigs Needed For <?php echo esc_attr( get_option('minimum_waitd') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_gigsd" value="<?php echo esc_attr( get_option('minimum_gigsd') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_ratiod" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtrd'); ?></div>
					<label for="minimum_ratiod"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_ratiod" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Min Ratio Needed For <?php echo esc_attr( get_option('minimum_waitd') ); ?>H Wait</b></div></label>
						<input type="text" name="minimum_ratiod" value="<?php echo esc_attr( get_option('minimum_ratiod') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_wait_times_d" class="wp_trader_settings"><?php echo wptrader_help_file('swt', 'swtd'); ?></div>
					<label for="minimum_waitd"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_wait_times_d" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Minimum Wait Time</b></div></label>
						<input type="text" name="minimum_waitd" value="<?php echo esc_attr( get_option('minimum_waitd') ); ?>" />
				</div>
			</div>
			<?php wptrader_submit(); ?>
    </form>
</div>
<?php wptrader_footer(); ?>
</div>