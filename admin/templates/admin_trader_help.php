<?php
/** 
* WP-Trader Admin Help. 
* @package WP-Trader 
* @subpackage Administration 
**/
include_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));
?>
<div data-role="page" data-theme="d" class="form-table">
<?php wptrader_header(); ?>
	<div data-role="content">
		<?php
		donate_header();
		wptrader_missing_announce();
		wptrader_missing_scrape();
		?>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Main Page</h3>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Main Settings</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('mains', 'mainsa'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>FAQ</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('mfaq', 'mfaqa'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Shortcodes</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('msc', 'msca'); ?>
					</div>
			</div>
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Main Options</h3>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Keep/Delete</h3>
					<div data-role="fieldcontain" id="settings_keep_delete">
						<?php echo wptrader_help_file('skd', 'skde'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Users</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('susers', 'susersma'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Cleanup And Announce</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('sca', 'scaa'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Auto Warning</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('saw', 'sawall'); ?>
					</div>
			</div>
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Torrent Options</h3>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Torrent Directory</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('std', 'stda'); ?>
					</div>
			</div>
			<?php 
			global $wp_version;
			if ($wp_version >= '3.3'){
			?>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Torrent Editor</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('ste', 'stea'); ?>
					</div>
			</div>
			<?php } ?>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Torrent</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('st', 'sta'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Announce</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('sa', 'saa'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Torrent Table</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('stt', 'stta'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings File Uploads</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('sfu', 'sfua'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Free Leech</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('sfl', 'sfla'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Wait Times</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('swt', 'swtal'); ?>
					</div>
			</div>
		</div>
		<div data-role="collapsible" data-collapsed="true" data-theme="a">
			<h3>Widgets Options</h3>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Most Active Widget</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('sma', 'smaa'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Latest Uploads Widget</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('slu', 'sluall'); ?>
					</div>
			</div>
			<div data-role="collapsible" data-collapsed="true" data-theme="a">
				<h3>Settings Seed Wanted Widget</h3>
					<div data-role="fieldcontain">
						<?php echo wptrader_help_file('ssw', 'sswa'); ?>
					</div>
			</div>
		</div>
	</div>
<?php wptrader_footer(); ?>
</div>