<?php
/** 
* WP-Trader Widget Options Administration Screen. 
* @package WP-Trader 
* @subpackage Administration 
**/
include_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
			wp_die(__('Cheatin&#8217; uh?'));

if (isset($_POST["change_options_widgets"]) == "yes"){
		check_admin_referer('wptrader-options-widgets');
		if (isset($_POST['most_active_limit'])){
			update_option('most_active_limit', $_POST['most_active_limit']);
		}
		if (isset($_POST['most_active_external'])){
			update_option('most_active_external', $_POST['most_active_external']);
		}
		if (isset($_POST['most_active_name_shortner'])){
			update_option('most_active_name_shortner', $_POST['most_active_name_shortner']);
		}
		if(isset($_POST['tma_ex'])){
			update_option('most_active_torrenttable', $_POST['tma_ex']);
		}
		if (isset($_POST['latest_uploaded_limit'])){
			update_option('latest_uploaded_limit', $_POST['latest_uploaded_limit']);
		}
		if (isset($_POST['latest_uploaded_external'])){
			update_option('latest_uploaded_external', $_POST['latest_uploaded_external']);
		}
		if (isset($_POST['latest_uploaded_name_shortner'])){
			update_option('latest_uploaded_name_shortner', $_POST['latest_uploaded_name_shortner']);
		}
		if (isset($_POST['tla_ex'])){
			update_option('latest_uploaded_torrenttable', $_POST['tla_ex']);
		}
		if (isset($_POST['seed_wanted_limit'])){
			update_option('seed_wanted_limit', $_POST['seed_wanted_limit']);
		}
		if (isset($_POST['seed_wanted_external'])){
			update_option('seed_wanted_external', $_POST['seed_wanted_external']);
		}
		if (isset($_POST['seed_wanted_name_shortner'])){
			update_option('seed_wanted_name_shortner', $_POST['seed_wanted_name_shortner']);
		}
		if (isset($_POST['tsa_ex'])){
			update_option('seed_wanted_torrenttable', $_POST['tsa_ex']);
		}
		
		$errorheader = "Updated";
		$errormessage = "WP-Trader options has been updated.";
		wptrader_update($errorheader, $errormessage);

}elseif(isset($_POST['move_announce'])){
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
	$most_active_external_yes = (get_option('most_active_external') == 1) ? 'selected="selected"' : '';

	$most_active_external_no = (get_option('most_active_external') == 0) ? 'selected="selected"' : '';
	
	$latest_uploaded_external_yes = (get_option('latest_uploaded_external') == 1) ? 'selected="selected"' : '';

	$latest_uploaded_external_no = (get_option('latest_uploaded_external') == 0) ? 'selected="selected"' : '';
	
	$seed_wanted_external_yes = (get_option('seed_wanted_external') == 1) ? 'selected="selected"' : '';

	$seed_wanted_external_no = (get_option('seed_wanted_external') == 0) ? 'selected="selected"' : '';
?>

<style type='text/css'>
.error_wp_trader {
	background: #FFFF00;
	border-top-left-radius: 5px;
    border-top-right-radius: 5px;
    -moz-border-radius-topleft: 5px;
    -moz-border-radius-topright: 5px;
    -webkit-border-top-left-radius: 5px;
    -webkit-border-top-right-radius: 5px;
    -khtml-border-top-left-radius: 5px;
    -khtml-border-top-right-radius: 5px;
}
.mydropdown1{
	height:65px; /* for size 4, means 4 items of list visible at a time */
}
</style>
<div data-role="page" data-theme="d" class="form-table">
	<?php wptrader_header(); ?>
	<div data-role="content">
	<?php
	donate_header();
	wptrader_missing_announce();
	wptrader_missing_scrape();
	?>
	<form action="admin.php?page=wptrader-options-widgets" method="post">
		<input type="hidden" name="change_options_widgets" value="yes" />
		<?php wp_nonce_field('wptrader-options-widgets') ?>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Most Active Torrents</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_most_active_limit" class="wp_trader_settings"><?php echo wptrader_help_file('sma', 'smal'); ?></div>
					<label for="most_active_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_most_active_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Most Active Limit</b></div></label>
						<input type="text" name="most_active_limit" id="most_active_limit" value="<?php echo esc_attr( get_option('most_active_limit') ); ?>" />	
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_most_active_external" class="wp_trader_settings"><?php echo wptrader_help_file('sma', 'smae'); ?></div>
					<label for="most_active_external"><div class="wptrader_info_icon"><a href="#" name="simpleraw_most_active_external" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Most Active External</b></div></label>
						<select name="most_active_external" id="most_active_external" data-role="slider" data-theme="a">
							<option value="0" <?php echo $most_active_external_no; ?> >No</option>
							<option value="1" <?php echo $most_active_external_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_most_active_name_shortner" class="wp_trader_settings"><?php echo wptrader_help_file('sma', 'smas'); ?></div>
					<label for="most_active_name_shortner"><div class="wptrader_info_icon"><a href="#" name="simpleraw_most_active_name_shortner" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Most Active Name Shortner</b></div></label>
						<input type="text" name="most_active_name_shortner" id="most_active_name_shortner" value="<?php echo esc_attr( get_option('most_active_name_shortner') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_most_active_table" class="wp_trader_settings"><?php echo wptrader_help_file('sma', 'smatt'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_most_active_table" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Most Active Torrent Table</b></div></legend>
						<?php
						$tma_args = array('category', 'name', 'dl', 'uploader', 'comments', 'completed', 'size', 'seeders', 'leechers', 'health', 'external', 'wait', 'rating', 'added', 'nfo');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_mostactive" class="connectedSortable_mostactive">
												<?php
													foreach ( $tma_args as $tma_ex ){
														$most_active_torrenttable = array_map('trim', explode(',', get_option('most_active_torrenttable')));
														if (!in_array($tma_ex, $most_active_torrenttable)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tma_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tma_ex); ?>&nbsp;&nbsp;</h3>
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
											<div id="sortable2_mostactive" name="todb_tmaex" class="connectedSortable_mostactive">
												<?php
												$most_active_torrenttable = array_map('trim', explode(',', get_option('most_active_torrenttable')));
												foreach ( $most_active_torrenttable as $tma_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tma_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tma_exss); ?>&nbsp;&nbsp;</h3>
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
							<input type="hidden" name="tma_ex" id="todb_tmaex" value="<?php echo esc_attr(get_option('most_active_torrenttable')); ?>">
						</div>
					</fieldset>
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Latest Uploaded Torrents</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_latest_uploaded_limit" class="wp_trader_settings"><?php echo wptrader_help_file('slu', 'slul'); ?></div>
					<label for="latest_uploaded_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_latest_uploaded_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Latest Uploaded Limit</b></div></label>
						<input type="text" name="latest_uploaded_limit" id="latest_uploaded_limit" value="<?php echo esc_attr( get_option('latest_uploaded_limit') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_latest_uploaded_external" class="wp_trader_settings"><?php echo wptrader_help_file('slu', 'slue'); ?></div>
					<label for="latest_uploaded_external"><div class="wptrader_info_icon"><a href="#" name="simpleraw_latest_uploaded_external" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Latest Uploaded External</b></div></label>
						<select name="latest_uploaded_external" id="latest_uploaded_external" data-role="slider" data-theme="a">
							<option value="0" <?php echo $latest_uploaded_external_no; ?> >No</option>
							<option value="1" <?php echo $latest_uploaded_external_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_latest_uploaded_name_shortner" class="wp_trader_settings"><?php echo wptrader_help_file('slu', 'slus'); ?></div>
					<label for="latest_uploaded_name_shortner"><div class="wptrader_info_icon"><a href="#" name="simpleraw_latest_uploaded_name_shortner" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Latest Uploaded Name Shortner</b></div></label>
						<input type="text" name="latest_uploaded_name_shortner" id="latest_uploaded_name_shortner" value="<?php echo esc_attr( get_option('latest_uploaded_name_shortner') ); ?>" size="3" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_latest_uploaded_table" class="wp_trader_settings"><?php echo wptrader_help_file('slu', 'slut'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_latest_uploaded_table" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Latest Uploaded Torrent Table</b></div></legend>
							<?php
						$tla_args = array('category', 'name', 'dl', 'uploader', 'comments', 'completed', 'size', 'seeders', 'leechers', 'health', 'external', 'wait', 'rating', 'added', 'nfo');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_latestuploaded" class="connectedSortable_latestuploaded">
												<?php
													foreach ( $tla_args as $tla_ex ){
														$latest_uploaded_torrenttable = array_map('trim', explode(',', get_option('latest_uploaded_torrenttable')));
														if (!in_array($tla_ex, $latest_uploaded_torrenttable)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tla_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tla_ex); ?>&nbsp;&nbsp;</h3>
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
											<div id="sortable2_latestuploaded" name="todb_tmaex" class="connectedSortable_latestuploaded">
												<?php
												$latest_uploaded_torrenttable = array_map('trim', explode(',', get_option('latest_uploaded_torrenttable')));
												foreach ( $latest_uploaded_torrenttable as $tla_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tla_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tla_exss); ?>&nbsp;&nbsp;</h3>
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
							<input type="hidden" name="tla_ex" id="todb_tlaex" value="<?php echo esc_attr(get_option('latest_uploaded_torrenttable')); ?>">
						</div>
					</fieldset>
				</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Seed Wanted Torrents</h3>
				<div data-role="fieldcontain">
					<div id="simpleraw_seed_wanted_limit" class="wp_trader_settings"><?php echo wptrader_help_file('ssw', 'sswl'); ?></div>
					<label for="seed_wanted_limit"><div class="wptrader_info_icon"><a href="#" name="simpleraw_seed_wanted_limit" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Seed Wanted Limit</b></div></label>
						<input type="text" name="seed_wanted_limit" id="seed_wanted_limit" value="<?php echo esc_attr( get_option('seed_wanted_limit') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_seed_wanted_external" class="wp_trader_settings"><?php echo wptrader_help_file('ssw', 'sswe'); ?></div>
					<label for="seed_wanted_external"><div class="wptrader_info_icon"><a href="#" name="simpleraw_seed_wanted_external" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Seed Wanted External</b></div></label>
						<select name="seed_wanted_external" id="seed_wanted_external" data-role="slider" data-theme="a">
							<option value="0" <?php echo $seed_wanted_external_no; ?> >No</option>
							<option value="1" <?php echo $seed_wanted_external_yes; ?> >Yes</option>
						</select>
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_seed_wanted_name_shortner" class="wp_trader_settings"><?php echo wptrader_help_file('ssw', 'ssws'); ?></div>
					<label for="seed_wanted_name_shortner"><div class="wptrader_info_icon"><a href="#" name="simpleraw_seed_wanted_name_shortner" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Seed Wanted Name Shortner</b></div></label>
						<input type="text" name="seed_wanted_name_shortner" id="seed_wanted_name_shortner" value="<?php echo esc_attr( get_option('seed_wanted_name_shortner') ); ?>" />
				</div>
				<div data-role="fieldcontain">
					<div id="simpleraw_seed_wanted_table" class="wp_trader_settings"><?php echo wptrader_help_file('ssw', 'sswt'); ?></div>
					<fieldset data-role="controlgroup" class="ui-grid-a">
						<legend><div class="wptrader_info_icon"><a href="#" name="simpleraw_seed_wanted_table" id="simpleraw" data-role="button" data-icon="info" data-iconpos="notext">Info</a></div><div class="wptrader_label_title"><b>Seed Wanted Torrent Table</b></div></legend>
							<?php
						$tsa_args = array('category', 'name', 'dl', 'uploader', 'comments', 'completed', 'size', 'seeders', 'leechers', 'health', 'external', 'wait', 'rating', 'added', 'nfo');
						?>
						<div data-role="controlgroup">
							<div class='ui-block-a'>
								<div class="wptrader_sortable_head"><h3>Disabled</h3></div>
									<div class="wptrader_sortable_column_holder">
										<div class="description">
											Drag the column name from disabled to enabeled on the right to activate them. Drag the column name back here to deactivate them.
										</div>
											<div id="wptrader_sortable_column_list">
												<div id="sortable1_seedwanted" class="connectedSortable_seedwanted">
												<?php
													foreach ( $tsa_args as $tsa_ex ){
														$seed_wanted_torrenttable = array_map('trim', explode(',', get_option('seed_wanted_torrenttable')));
														if (!in_array($tsa_ex, $seed_wanted_torrenttable)){
														?>
															<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tsa_ex); ?>">
																<h3>&nbsp;&nbsp;<?php echo esc_attr($tsa_ex); ?>&nbsp;&nbsp;</h3>
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
											<div id="sortable2_seedwanted" name="todb_tmaex" class="connectedSortable_seedwanted">
												<?php
												$seed_wanted_torrenttable = array_map('trim', explode(',', get_option('seed_wanted_torrenttable')));
												foreach ( $seed_wanted_torrenttable as $tsa_exss ){
												?>
													<div class="wptrader_column_title_head ui-draggable" id="<?php echo esc_attr($tsa_exss); ?>">
														<h3>&nbsp;&nbsp;<?php echo esc_attr($tsa_exss); ?>&nbsp;&nbsp;</h3>
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
							<input type="hidden" name="tsa_ex" id="todb_tsaex" value="<?php echo esc_attr(get_option('seed_wanted_torrenttable')); ?>">
						</div>
					</fieldset>
				</div>
			</div>
			<?php wptrader_submit(); ?>
    </form>
</div>
<?php wptrader_footer(); ?>
</div>