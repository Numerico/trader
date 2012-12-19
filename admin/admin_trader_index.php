<?php
/** 
* Index Administration Screen. 
* @package WP-Trader 
* @subpackage Administration 
**/
require_once( WP_TRADER_ABSPATH . '/admin/includes/functions_admin_trader_options.php' );

if ( !current_user_can('manage_options') )
	wp_die(__('Cheatin&#8217; uh?'));

if (isset($_POST['move_announce'])){
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
}elseif (isset($_POST['move_scrape'])){
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
}else if (isset($_POST['do_cleanup'])){
	check_admin_referer('wptrader-do-cleanup');
	require_once( WP_TRADER_ABSPATH . '/admin/includes/function-cleanup.php' );
	do_cleanup();	
	$errorheader = "Updated";
	$errormessage = "Cleanup has been done.";
	wptrader_update($errorheader, $errormessage);
}
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
	.submit_wp_trader {
		float:left; 
		padding:0px 200px;
	}
	</style>
<div data-role="page" data-theme="d" class="form-table">
<?php wptrader_header(); ?>
	<div data-role="content">
		<?php
		donate_header();
		wptrader_missing_announce();
		wptrader_missing_scrape();
		wptrader_do_cleanup();
		?>
		<br />
		<p>
			<?php
				global $wp_trader_plugin_description;
				echo $wp_trader_plugin_description;
			?>
		</p>
	</div>
<?php wptrader_footer(); ?>
</div>