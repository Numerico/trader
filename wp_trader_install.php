<?php
/**
* @package WP-Trader
*/
/*
* Plugin Name: WP-Trader
* Plugin URI: http://wp-tracker.com/
* Description: Roughly based on Torrent Trader 2.07, WP-Trader is an easy solution for people to run a torrent site. Now it is easier for bands, software makers, authors and etc. to be able to get their work out to their users without the high cost of having servers for product download. We hope this plugin will be useful for people who do not want to distribute their works through the normal channel which like to act like a mafiaa and not pay the artists what they deserve (we will not mention the companies names but you should know who you are and should not fear us but embrace us). Users of this plugin should only use it to distribute work which they own the rights to. The author(s) of this plugin can not be held responsible for the use of this plugin.
* Version: .4.8 Beta
* Author: Andrew Walker & Lee Howarth
* Author URI: http://wp-tracker.com/
* Lisence: GPLv2
*/ 
require_once( dirname( __FILE__ ) . "/wp_trader_install_defines.php" );
require_once( WP_TRADER_ABSPATH . "/includes/required-includes.php" );
	
global $wp_trader_plugin_description, $wp_trader_plugin_version, $wp_trader_plugin_author;
if ( ! function_exists( "get_plugin_data" ) )
	require_once( ABSPATH . "wp-admin/includes/plugin.php" );
$wp_trader_plugin_data = get_plugin_data( __FILE__, true, true );
$wp_trader_plugin_description = $wp_trader_plugin_data["Description"];
$wp_trader_plugin_version = $wp_trader_plugin_data["Version"];
$wp_trader_plugin_author = $wp_trader_plugin_data["Author"];
	
global $wp_trader_db_version;
$wp_trader_db_version = "1.1";
function wptrader_install(){
	global $wpdb;
	require_once( WP_TRADER_ABSPATH . "/includes/function-main.php" );
	require_once( WP_TRADER_ABSPATH . "/wp_trader_install_functions.php" );
	if ( function_exists( "wp_trader_install_db" ) )
		wp_trader_install_db();
	if ( function_exists( "wp_trader_install_db_values" ) )
		wp_trader_install_db_values();
	if ( function_exists( "wp_trader_install_options" ) )
		wp_trader_install_options();
	if ( function_exists( "wp_trader_install_categories" ) )
		wp_trader_install_categories();
	if ( function_exists( "wp_trader_install_pages" ) )
		wp_trader_install_pages();
	if ( function_exists( "wp_trader_install_system_user" ) )
		wp_trader_install_system_user();
	
	//need to remove in later version
	update_option( 'cleanup_autoclean_interval', 'hourly' );
}
  
function wptrader_uninstall(){
	require_once( WP_TRADER_ABSPATH . "/includes/function-main.php" );
	if(get_option("wp_trader_keep_settings") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		global $wpdb;
		if ( function_exists( "wp_trader_uninstall_options" ) )
			wp_trader_uninstall_options(); //need to add an option to keep
		delete_option("wp_trader_keep_settings");
	}
	if(get_option("wp_trader_keep_settings") == 0 || get_option("wp_trader_keep_posts") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		$query = "SELECT post_id, attachment_id FROM " . TRADER_TORRENTS . "";
		$res = mysql_query($query) or die(mysql_error());
		while ($row = mysql_fetch_assoc($res)) {
			wp_delete_post( $row["post_id"], true );
			wp_delete_post( $row["attachment_id"], true );
			delete_post_meta($row["post_id"], "_thumbnail_id");
			delete_post_meta($row["post_id"], "anon");
			delete_post_meta($row["post_id"], "freeleech");
			delete_post_meta($row["post_id"], "external");
			delete_post_meta($row["post_id"], "views");
			delete_post_meta($row["post_id"], "hits");
			delete_post_meta($row["post_id"], "times_completed");
			delete_post_meta($row["post_id"], "leechers");
			delete_post_meta($row["post_id"], "seeders");
			delete_post_meta($row["post_id"], "torrent_location");
			delete_post_meta($row["post_id"], "last_action");
			delete_post_meta($row["post_id"], "descr");
		}
		delete_option("wp_trader_keep_posts");
	}
	if(get_option("wp_trader_keep_settings") == 0 || get_option("wp_trader_keep_all_pages") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		if ( function_exists( "wp_trader_uninstall_pages" ) )
			wp_trader_uninstall_pages();
		delete_option("wp_trader_keep_all_pages");
	}
	if(get_option("wp_trader_keep_settings") == 0 || get_option("wp_trader_keep_all_user_info") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		if ( function_exists( "wp_trader_uninstall_user_meta" ) )
			wp_trader_uninstall_user_meta();
		delete_option("wp_trader_keep_all_user_info");
	}
	if(get_option("wp_trader_keep_settings") == 0 || get_option("wp_trader_keep_system_user") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		if ( function_exists( "wp_trader_uninstall_system_user" ) )
			wp_trader_uninstall_system_user();
		delete_option("wp_trader_keep_system_user");
	}
	if(get_option("wp_trader_keep_settings") == 0 || get_option("wp_trader_keep_databank_tables") == 0){
		require_once( WP_TRADER_ABSPATH . "/wp_trader_uninstall_functions.php" );
		if ( function_exists( "wp_trader_uninstall_db" ) )
			wp_trader_uninstall_db();
		delete_option("wp_trader_keep_databank_tables");
	}
}

register_activation_hook(__FILE__, "wptrader_install");
register_deactivation_hook(__FILE__, "wptrader_uninstall");

add_action("wp_head", "wp_trader_head");
function wp_trader_head(){
	if (!is_admin()){
		?>  
		<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/themes/base/jquery-ui.css">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.1/jquery-ui.min.js"></script>
		<?php
	}
}

if (get_option("members_only") == 1){
	//credits and some part of the memebrs only redirect go to http://wordpress.org/extend/plugins/registered-users-only/
	add_action( "wp", "members_only_redirect" );
	function members_only_redirect() {
		global $post;
		// If the user is logged in, then abort
		if ( current_user_can('read') ) return;

		$members_only = get_option( "members_only" );

		// Feeds
		if ( 1 == $members_only["feeds"] && is_feed() ) return;

		// This is a base array of pages that will be EXCLUDED from being blocked
		$page_exclude = array_map("trim", @explode("|", get_option("members_only_page_exclude")));

		// If the current script name is in the exclusion list, abort
		if ( in_array( basename(get_permalink()), apply_filters( "wp_trader_memebers_only", $page_exclude ) ) ) return;

		// Still here? Okay, then redirect to the login form
		auth_redirect();
	}

	add_action( "init", "wp_trader_login_form_message" );
	function wp_trader_login_form_message() {
		// Don't show the error message if anything else is going on (registration, etc.)
		if ( "wp-login.php" != basename($_SERVER["PHP_SELF"]) || !empty($_POST) || ( !empty($_GET) && empty($_GET["redirect_to"]) ) ) return;

		global $error;
		$error = __( "Only registered and logged in users are allowed to view this site. Please log in now.", "registered-users-only" );
	}
		
	// Tell bots to go away (they shouldn't index the login form)
	add_action( "login_head", "wp_trader_no_index", 1 );
	function wp_trader_no_index(){
		return "	<meta name='robots' content='noindex,nofollow' />\n";
	}
}
function wptrader_custom_user_profile_fields( $user ) {
	global $wpdb;
	require_once( WP_TRADER_ABSPATH . "/includes/function-main.php" );
?>
    <h3><?php _e('Torrent Site Info', 'your_textdomain'); ?></h3>
    <table class="form-table">
		<tr>
			<th>
				<label for="trader_upload"><?php _e('Upload', 'your_textdomain'); ?></label>
			</th>
			<td>
				<?php 
					if ( !get_the_author_meta( 'trader_upload', $user->ID ) ){
						$user_upload = '0';
					}else{
						$user_upload = ''.get_the_author_meta( 'trader_upload', $user->ID ).'';
					}
				?>
				<?php if( !current_user_can('level_10') ){ ?>
					<?php echo esc_attr( mksize( $user_upload ) ); ?><br />
				<?php }else{ ?>
					<input type="text" size="30" name="trader_upload" id="trader_upload" value="<?php echo esc_attr( $user_upload ); ?>" />&nbsp;&nbsp;<?php echo esc_attr( mksize( $user_upload ) ); ?><br />
					<span class="description">Value should be entered in bytes.</span><br />
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="trader_download"><?php _e('Download', 'your_textdomain'); ?></label>
			</th>
			<td>
				<?php 
					if ( !get_the_author_meta( 'trader_download', $user->ID ) ){
						$user_download = '0';
					}else{
						$user_download = ''.get_the_author_meta( 'trader_download', $user->ID ).'';
					}
				?>
				<?php if( !current_user_can('level_10') ){ ?>
					<?php echo esc_attr( mksize( $user_download ) ); ?><br />
				<?php }else{ ?>
					<input type="text" size="30" name="trader_download" id="trader_download" value="<?php echo esc_attr( $user_download ); ?>" />&nbsp;&nbsp;<?php echo esc_attr( mksize( $user_download ) ); ?><br />
					<span class="description">Value should be entered in bytes.</span><br />
				<?php } ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="trader_ratio"><?php _e('Ratio', 'your_textdomain'); ?></label>
			</th>
			<td>
				<?php
					if (get_the_author_meta("trader_upload", $user->ID) > 0 && get_the_author_meta("trader_download", $user->ID) == 0){
						$user_ratio .= "Inf.";
					}elseif (get_the_author_meta("trader_download", $user->ID) > 0){
						$user_ratio .= number_format(get_the_author_meta("trader_upload", $user->ID) / get_the_author_meta("trader_download", $user->ID), 2);
					}else{
						$user_ratio .= "---";
					}
				?>
				<?php echo esc_attr( $user_ratio ); ?><br />
			</td>
		</tr>
		
		<?php if( get_option('members_only') == 1 && get_option('wptrader_seed_bonus') == 1 ){ ?>
		<tr>
			<th>
				<label for="trader_ratio"><?php _e('Seed Bonus', 'your_textdomain'); ?></label>
			</th>
			<td>
				<?php 
					if ( !get_the_author_meta( 'seed_bonus', $user->ID ) ){
						$user_seed_bonus = '0';
					}else{
						$user_seed_bonus = ''.number_format(get_the_author_meta( 'seed_bonus', $user->ID ), 2).'';
					}
				?>
				<?php if( !current_user_can('level_10') ){ ?>
					<?php echo esc_attr( $user_seed_bonus ); ?><br />
				<?php }else{ ?>
					<input type="text" size="10" name="seed_bonus" id="seed_bonus" value="<?php echo esc_attr( $user_seed_bonus ); ?>" /><br />
					<span class="description">Edit user's seed bonus amount.</span><br />
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<?php if( get_option('members_only') == 1 && get_option('ip_passkey_tracking') == 1 ){ ?>
		<tr>
			<th>
				<label for="trader_ratio"><?php _e('Passkey', 'your_textdomain'); ?></label>
			</th>
			<td>
				<?php
					if(!get_the_author_meta("trader_passkey", $user->ID)){
						echo 'No passkey has been assigned for this account. Please download a torrent to assign one.';
					}else{
						echo esc_attr( get_the_author_meta("trader_passkey", $user->ID) ).'<br />';
					}
				?>
			</td>
		</tr>
		<?php if((current_user_can( 'edit_user', $user_id ) && get_option('user_generate_passkey') == 1) || current_user_can('level_10')){ ?>
		<tr>
			<th>
				<label for="reset_passkey"><?php _e('Passkey Reset', 'your_textdomain'); ?></label>
			</th>
			<td>
				<input name="reset_passkey" value="1" type="checkbox">&nbsp;&nbsp;Yes<br />
				<span class="description">Generate a new passkey for this account. (Any active torrents must be downloaded again to continue leeching or seeding.)</span><br />
			</td>
		</tr>
		<?php } ?>
		<?php } ?>
		<?php if( get_option('members_only') == 1 && current_user_can('level_10')){ 
				$download_banned_yes = (get_option('download_banned') == 1) ? 'checked="checked"' : '';
				$download_banned_no = (get_option('download_banned') == 0) ? 'checked="checked"' : '';
		?>
		<tr>
			<th>
				<label for="download_banned"><?php _e('Download Banned', 'your_textdomain'); ?></label>
			</th>
			<td>
				<input type="radio" name="download_banned" value="0" <?php echo $download_banned_no ?> />&nbsp;No&nbsp;&nbsp;<input type="radio" name="download_banned" value="1" <?php echo $download_banned_yes ?> />&nbsp;Yes<br />
				<span class="description">Ban the user from downloading.</span><br />
			</td>
		</tr>
		<?php } ?>
    </table>
<?php 
}
function wptrader_save_custom_user_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return FALSE;
	update_usermeta( $user_id, 'trader_upload', $_POST['trader_upload'] );
	update_usermeta( $user_id, 'trader_download', $_POST['trader_download'] );
	update_usermeta( $user_id, 'download_banned', $_POST['download_banned'] );
	if($_POST['reset_passkey'] == "1"){
		$trader_secret = get_user_meta($user_id, 'trader_secret', true);
		$rand = array_sum(explode(" ", microtime()));
		$trader_passkey = md5($current_user->user_login.$rand.$trader_secret.($rand*mt_rand()));
		update_usermeta( $user_id, 'trader_passkey', $trader_passkey );
	}
}
add_action( 'show_user_profile', 'wptrader_custom_user_profile_fields' );
add_action( 'edit_user_profile', 'wptrader_custom_user_profile_fields' );
add_action( 'personal_options_update', 'wptrader_save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', 'wptrader_save_custom_user_profile_fields' );

// Add cron job to run cleanup
/*function wptrader_cron_schedule( $schedules ) {
    $schedules['weekly'] = array(
        'interval' => 604800, // 1 week in seconds
        'display'  => __( 'Once Weekly' ),
    );
 
    return $schedules;
}*/
 
// Schedule an action if it's not already scheduled
if ( ! wp_next_scheduled( 'wptrader_cron_action' ) ) {
    wp_schedule_event( time(), 'hourly', 'wptrader_cron_action', wptrader_cron_schedule() );
}
 
// Hook into that action that'll fire weekly
add_action( 'wptrader_cron_action', 'wptrader_cron_do_cleanup' );
function wptrader_cron_do_cleanup() {
    require_once( WP_TRADER_ABSPATH . "/admin/function-cleanup.php" );
	do_cleanup();
}
add_filter( 'cron_schedules', 'wptrader_cron_schedule' );
function wptrader_cron_schedule() {
	return array( 'wptrader_cleanup_time' => array(
		'interval' => get_option('cleanup_autoclean_interval'), // seconds
		'display' => __( 'WP-Trader Cleanup' )
	) );
}
?>