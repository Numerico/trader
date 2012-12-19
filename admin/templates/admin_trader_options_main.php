<?php
/** 
* Main Options Administration Screen. 
* @package WP-Trader 
* @subpackage Administration 
**/
include_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

if (isset($_POST['change_options_main']) == "yes"){
		check_admin_referer('wptrader-options-main');
		if(isset($_POST['wp_trader_keep_settings'])){
			update_option('wp_trader_keep_settings', $_POST['wp_trader_keep_settings']);
		}
		if(isset($_POST['wp_trader_keep_databank_tables'])){
			update_option('wp_trader_keep_databank_tables', $_POST['wp_trader_keep_databank_tables']);
		}
		if(isset($_POST['wp_trader_keep_all_pages'])){
			update_option('wp_trader_keep_all_pages', $_POST['wp_trader_keep_all_pages']);
		}
		if(isset($_POST['wp_trader_keep_all_user_info'])){
			update_option('wp_trader_keep_all_user_info', $_POST['wp_trader_keep_all_user_info']);
		}
		if(isset($_POST['wp_trader_keep_system_user'])){
			update_option('wp_trader_keep_system_user', $_POST['wp_trader_keep_system_user']);
		}
		if(isset($_POST['wp_trader_keep_posts'])){
			update_option('wp_trader_keep_posts', $_POST['wp_trader_keep_posts']);
		}
		if(isset($_POST['members_only'])){
			update_option('members_only', $_POST['members_only']);
		}
		if(isset($_POST['pagg_guid']) != ''){
			$members_only_exclusions = '|wp-login.php|wp-register.php|wp-cron.php|wp-trackback.php|wp-app.php|xmlrpc.php';
			update_option('members_only_page_exclude', implode('|', $_POST['pagg_guid']).$members_only_exclusions);
		}else{
			$members_only_exclusions = 'wp-login.php|wp-register.php|wp-cron.php|wp-trackback.php|wp-app.php|xmlrpc.php';
			update_option('members_only_page_exclude', $members_only_exclusions);
		}
		if(isset($_POST['members_only_wait'])){
			update_option('members_only_wait', $_POST['members_only_wait']);
		}
		if(isset($_POST['announce_peerlimit'])){
			update_option('announce_peerlimit', $_POST['announce_peerlimit']);
		}
		if(isset($_POST['cleanup_autoclean_interval'])){
			update_option('cleanup_autoclean_interval', $_POST['cleanup_autoclean_interval']);
		}
		if(isset($_POST['cleanup_log_clean'])){
			update_option('cleanup_log_clean', $_POST['cleanup_log_clean']);
		}
		if(isset($_POST['announce_interval'])){
			update_option('announce_interval', $_POST['announce_interval']);
		}
		if(isset($_POST['max_dead_torrent_time'])){
			update_option('max_dead_torrent_time', $_POST['max_dead_torrent_time']);
		}
		if(isset($_POST['ratiowarn_enable'])){
			update_option('ratiowarn_enable', $_POST['ratiowarn_enable']);
		}
		if(isset($_POST['ratiowarn_minratio'])){
			update_option('ratiowarn_minratio', $_POST['ratiowarn_minratio']);
		}
		if(isset($_POST['ratiowarn_mingigs'])){
			update_option('ratiowarn_mingigs', $_POST['ratiowarn_mingigs']);
		}
		if(isset($_POST['ratiowarn_daystowarn'])){
			update_option('ratiowarn_daystowarn', $_POST['ratiowarn_daystowarn']);
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
	$members_only_yes = (get_option('members_only') == 1) ? 'selected="selected"' : '';
	$members_only_no = (get_option('members_only') == 0) ? 'selected="selected"' : '';
	$members_only_wait_yes = (get_option('members_only_wait') == 1) ? 'selected="selected"' : '';
	$members_only_wait_no = (get_option('members_only_wait') == 0) ? 'selected="selected"' : '';
	$ratiowarn_enable_yes = (get_option('ratiowarn_enable') == 1) ? 'selected="selected"' : '';
	$ratiowarn_enable_no = (get_option('ratiowarn_enable') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_settings_yes = (get_option('wp_trader_keep_settings') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_settings_no = (get_option('wp_trader_keep_settings') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_databank_tables_yes = (get_option('wp_trader_keep_databank_tables') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_databank_tables_no = (get_option('wp_trader_keep_databank_tables') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_all_pages_yes = (get_option('wp_trader_keep_all_pages') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_all_pages_no = (get_option('wp_trader_keep_all_pages') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_all_user_info_yes = (get_option('wp_trader_keep_all_user_info') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_all_user_info_no = (get_option('wp_trader_keep_all_user_info') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_system_user_yes = (get_option('wp_trader_keep_system_user') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_system_user_no = (get_option('wp_trader_keep_system_user') == 0) ? 'selected="selected"' : '';
	$wp_trader_keep_posts_yes = (get_option('wp_trader_keep_posts') == 1) ? 'selected="selected"' : '';
	$wp_trader_keep_posts_no = (get_option('wp_trader_keep_posts') == 0) ? 'selected="selected"' : '';
	
	$cleanup_interval_hourly = (get_option('cleanup_autoclean_interval') == 'hourly') ? 'checked="checked"' : '';
	$cleanup_interval_twicedaily = (get_option('cleanup_autoclean_interval') == 'twicedaily') ? 'checked="checked"' : '';
	$cleanup_interval_daily = (get_option('cleanup_autoclean_interval') == 'daily') ? 'checked="checked"' : '';
?>
<div data-role="page" data-theme="d" class="form-table">
<?php wptrader_header(); ?>
	<div data-role="content">
		<?php
		donate_header();
		wptrader_missing_announce();
		wptrader_missing_scrape();
		?>
		<form action="admin.php?page=wptrader-options-main" method="post" data-ajax="false">
			<input type="hidden" name="change_options_main" value="yes" />
			<?php wp_nonce_field('wptrader-options-main') ?>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings To Keep/Delete</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skda'); ?></div>
					<label for="wp_trader_keep_settings"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep All Settings</b></div></label>
						<select name="wp_trader_keep_settings" id="wp_trader_keep_settings" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_settings_yes; ?> >No</option>
							<option value="1" <?php echo $wp_trader_keep_settings_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete_tables" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skdt'); ?></div>
					<label for="wp_trader_keep_databank_tables"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete_tables" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep All DB Tables</b></div></label>
						<select name="wp_trader_keep_databank_tables" id="wp_trader_keep_databank_tables" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_databank_tables_no; ?> >No</option>
						<option value="1" <?php echo $wp_trader_keep_databank_tables_yes; ?> >Yes</option>
						</select> 
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete_pages" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skdap'); ?></div>
					<label for="wp_trader_keep_all_pages"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete_pages" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep All Pages</b></div></label>
						<select name="wp_trader_keep_all_pages" id="wp_trader_keep_all_pages" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_all_pages_no; ?> >No</option>
							<option value="1" <?php echo $wp_trader_keep_all_pages_yes; ?> >Yes</option>
						</select> 
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete_user_info" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skdui'); ?></div>
					<label for="wp_trader_keep_all_user_info"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete_user_info" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep All User Info</b></div></label>
						<select name="wp_trader_keep_all_user_info" id="wp_trader_keep_all_user_info" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_all_user_info_no; ?> >No</option>
							<option value="1" <?php echo $wp_trader_keep_all_user_info_yes; ?> >Yes</option>
						</select> 
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete_user_system" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skdus'); ?></div>
					<label for="wp_trader_keep_system_user"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete_user_system" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep System User</b></div></label>
						<select name="wp_trader_keep_system_user" id="wp_trader_keep_system_user" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_system_user_no; ?> >No</option>
							<option value="1" <?php echo $wp_trader_keep_system_user_yes; ?> >Yes</option>
						</select> 
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_keep_delete_posts" class="wp_trader_settings"><?php echo wptrader_help_file('skd', 'skdp'); ?></div>
					<label for="wp_trader_keep_posts"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_keep_delete_posts" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Keep Posts</b></div></label>
						<select name="wp_trader_keep_posts" id="wp_trader_keep_posts" data-role="slider" data-theme="a">
							<option value="0" <?php echo $wp_trader_keep_posts_no; ?> >No</option>
							<option value="1" <?php echo $wp_trader_keep_posts_yes; ?> >Yes</option>
						</select> 
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Members Only Settings</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_users_members_only" class="wp_trader_settings"><?php echo wptrader_help_file('susers', 'susersmo'); ?></div>
					<label for="members_only"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_users_members_only" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Members Only</b></div></label>
						<select name="members_only" id="members_only" data-role="slider" data-theme="a">
							<option value="0" <?php echo $members_only_no; ?> >No</option>
							<option value="1" <?php echo $members_only_yes ; ?> >Yes</option>
						</select>
				</div>
				<?php 
				if($members_only_yes){ 
				?>
				<div data-role="fieldcontain">
					<fieldset data-role="controlgroup">
						<div id="simpleraw_settings_users_members_only_exclude" class="wp_trader_settings"><?php echo wptrader_help_file('susers', 'susersmoe'); ?></div>
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_users_members_only_exclude" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Members Only Page Exclude</b></div></legend>
							<?php 
							$mopae = '';
							$args = array(
								'child_of' => 0,
								'sort_order' => 'ASC',
								'sort_column' => 'post_title',
								'hierarchical' => 1,
								'parent' => -1,
								'offset' => 0,
								'post_type' => 'page',
								'post_status' => 'publish'
							);
							$pages = get_pages( $args );
							foreach ( $pages as $pagg ){
								$pagg_guid = basename( $pagg->guid );
								$page_exclude = array_map('trim', explode('|', get_option('members_only_page_exclude')));
								if (in_array($pagg_guid, $page_exclude)){
									$page_exclude = "checked='checked'";
								}
								?>
									<input type='checkbox' name='pagg_guid[]' class='custom' <?php echo $page_exclude; ?> value='<?php echo $pagg_guid; ?>' id='<?php echo $pagg_guid; ?>' />
										<label for='<?php echo $pagg_guid; ?>'><?php echo esc_attr($pagg->post_title); ?></label>
								<?php
							}
							?>
					</fieldset>
				</div>
				<?php
				}
				?>
				<div data-role="fieldcontain">
					<div id="simpleraw_settings_users_members_only_wait" class="wp_trader_settings"><?php echo wptrader_help_file('susers', 'susersmow'); ?></div>
					<label for="members_only_wait"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_users_members_only_wait" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Members Only Wait</b></div></label>
						<select name="members_only_wait" id="members_only_wait" data-role="slider" data-theme="a">
							<option value="0" <?php echo $members_only_wait_no; ?> >No</option>
							<option value="1" <?php echo $members_only_wait_yes; ?> >Yes</option>
						</select>
				</div>
			</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Cleanup And Announce Settings</h3>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_cleanup_announce_peer_limit" class="wp_trader_settings"><?php echo wptrader_help_file('sca', 'scapl'); ?></div>
				<label for="announce_peerlimit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_cleanup_announce_peer_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Peer Limit</b></div></label>
					<input type="text" name="announce_peerlimit" value="<?php echo esc_attr( get_option('announce_peerlimit') ); ?>" /><br />
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_cleanup_announce_autoclean_interval" class="wp_trader_settings"><?php echo wptrader_help_file('sca', 'scaai'); ?></div>
				<fieldset data-role="controlgroup" data-type="horizontal">
					<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_cleanup_announce_autoclean_interval" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Auto Cleanup Interval</b></div></legend>
						<label for="cleanup_autoclean_interval_hourly">Hourly</label>
							<input type="radio" name="cleanup_autoclean_interval" id="cleanup_autoclean_interval_hourly" value="hourly" <?php echo $cleanup_interval_hourly; ?> />
						<label for="cleanup_autoclean_interval_twicedaily">Twice Daily</label>
							<input type="radio" name="cleanup_autoclean_interval" id="cleanup_autoclean_interval_twicedaily" value="twicedaily" <?php echo $cleanup_interval_twicedaily; ?> />
						<label for="cleanup_autoclean_interval_daily">Daily</label>
							<input type="radio" name="cleanup_autoclean_interval" id="cleanup_autoclean_interval_daily" value="daily" <?php echo $cleanup_interval_daily; ?> />
				</fieldset>
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_cleanup_announce_log_clean" class="wp_trader_settings"><?php echo wptrader_help_file('sca', 'scalc'); ?></div>
				<label for="cleanup_log_clean"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_cleanup_announce_log_clean" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Log Clean</b></div></label>
					<input type="text" name="cleanup_log_clean" value="<?php echo esc_attr( get_option('cleanup_log_clean') ); ?>" /><br />
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_cleanup_announce_interval" class="wp_trader_settings"><?php echo wptrader_help_file('sca', 'scai'); ?></div>
				<label for="announce_interval"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_cleanup_announce_interval" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Announce Interval</b></div></label>
					<input type="text" name="announce_interval" value="<?php echo esc_attr( get_option('announce_interval') ); ?>" /><br />
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_cleanup_announce_dead" class="wp_trader_settings"><?php echo wptrader_help_file('sca', 'scad'); ?></div>
				<label for="max_dead_torrent_time"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_cleanup_announce_dead" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Max Dead Torrent Time</b></div></label>
					<input type="text" name="max_dead_torrent_time" value="<?php echo esc_attr( get_option('max_dead_torrent_time') ); ?>" /><br />
			</div>
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Auto Warning</h3>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_auto_warning_ratio_enable" class="wp_trader_settings"><?php echo wptrader_help_file('saw', 'sawre'); ?></div>
				<label for="ratiowarn_enable"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_auto_warning_ratio_enable" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Ratio Warning Enable</b></div></label>
					<select name="ratiowarn_enable" id="ratiowarn_enable" data-role="slider" data-theme="a">
						<option value="0" <?php echo $ratiowarn_enable_no; ?> >No</option>
						<option value="1" <?php echo $ratiowarn_enable_yes; ?> >Yes</option>
					</select>
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_auto_warning_ratio_min_ratio" class="wp_trader_settings"><?php echo wptrader_help_file('saw', 'sawrmr'); ?></div>
				<label for="ratiowarn_minratio"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_auto_warning_ratio_min_ratio" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Ratio Warning Min Ratio</b></div></label>
					<input type="text" name="ratiowarn_minratio" value="<?php echo esc_attr( get_option('ratiowarn_minratio') ); ?>" /><br />
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_auto_warning_ratio_min_gigs" class="wp_trader_settings"><?php echo wptrader_help_file('saw', 'sawrmg'); ?></div>
				<label for="ratiowarn_daystowarn"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_auto_warning_ratio_min_gigs" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Ratio Warning Min Gigs</b></div></label>
					<input type="text" name="ratiowarn_daystowarn" value="<?php echo esc_attr( get_option('ratiowarn_mingigs') ); ?>" /><br />
			</div>
			<div data-role="fieldcontain">
				<div id="simpleraw_settings_auto_warning_ratio_days" class="wp_trader_settings"><?php echo wptrader_help_file('saw', 'sawrd'); ?></div>
				<label for="ratiowarn_daystowarn"><div class="wptrader_info_icon"><a href="#" name="simpleraw_settings_auto_warning_ratio_days" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Ratio Warning # Of Days</b></div></label>
					<input type="text" name="ratiowarn_daystowarn" value="<?php echo esc_attr( get_option('ratiowarn_daystowarn') ); ?>" /><br />
			</div>
		</div>
		<?php wptrader_submit(); ?>		
    </form>
	</div>
<?php wptrader_footer(); ?>
</div>