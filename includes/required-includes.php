<?php
/*
  * Holds the Required Includes
  * @package WP-Trader
  * @subpackage Template
*/
	
	//Get some required files for the plugin to function correctly
	require_once( WP_TRADER_ABSPATH . '/includes/function-torrent-upload-template.php' );
	require_once( WP_TRADER_ABSPATH . '/includes/function-torrent-post.php' );
	require_once( WP_TRADER_ABSPATH . '/classes/class-admin-bar.php' );
	require_once( WP_TRADER_ABSPATH . '/includes/function-torrent-browse-template.php' );
	require_once( WP_TRADER_ABSPATH . '/includes/function-announce-template.php' );
	require_once( WP_TRADER_ABSPATH . '/includes/function-scrape-template.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/most-active-torrents-widget.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/includes/most-active-torrents-shortcode.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/latest-uploads-widget.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/includes/latest-uploads-shortcode.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/seed-wanted-widget.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/includes/seed-wanted-shortcode.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/wptrader-login-widget.php' );
	require_once( WP_TRADER_ABSPATH . '/widgets/includes/wptrader-login-shortcode.php' );
	require_once( WP_TRADER_ABSPATH . '/templates/wptrader_meta_box.php' );
	
	//End add users ip to user meta for ip tracking on announce
	
	//Functions for WP-Trader menu in the admin menu
	if(!function_exists('wptrader_main')){
		function wptrader_main(){
			include( WP_TRADER_ABSPATH . '/admin/admin_trader_index.php' );
		}
	}
	if(!function_exists('wptrader_help')){
		function wptrader_help(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_help.php' );
		}
	}
	if(!function_exists('wptrader_main_options')){
		function wptrader_main_options(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_options_main.php' );
		}
	}
	if(!function_exists('wptrader_torrent_options')){
		function wptrader_torrent_options(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_options_torrent.php' );
		}
	}
	if(!function_exists('wptrader_widgets_options')){
		function wptrader_widgets_options(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_options_widgets.php' );
		}
	}
	if(!function_exists('wptrader_peers_list')){
		function wptrader_peers_list(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_peers_list.php' );
		}
	}
	if(!function_exists('wptrader_free_leech_list')){
		function wptrader_free_leech_list(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_free_leech.php' );
		}
	}
	/*if(!function_exists('wptrader_plugins')){
		function wptrader_plugins(){
			include( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_plugins.php' );
		}
	}*/
	if (is_admin()){
		global $wptrader_main_menu, $wptrader_main, $wptrader_help, $wptrader_main_options, $wptrader_torrent_options, $wptrader_widgets_options, $wptrader_peers_list, $wptrader_free_leech_list;
		//Add scripts to the admin area
		add_action( "admin_print_scripts-$wptrader_main_menu", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_main", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_help", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_main_options", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_torrent_options", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_widgets_options", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_peers_list", 'wptrader_admin_styles_scripts' );
		add_action( "admin_print_scripts-$wptrader_free_leech_list", 'wptrader_admin_styles_scripts' );
		//End add scripts to the admin area
		add_action('admin_menu' , 'wptrader_menu_create_admin_menu');
	}
	//End functions for WP-Trader menu in the admin menu
	
	//Add admin menu styles and scripts
	function wptrader_admin_styles_scripts(){
		wp_register_style( 'wptrader_plugin_mobile_stylesheet', 'http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css' );
		wp_register_style( 'wptrader_plugin_mobile_dialog', 'http://dev.jtsage.com/cdn/simpledialog/latest/jquery.mobile.simpledialog.min.css' );
		wp_register_style( 'wptrader_plugin_stylesheet', WP_TRADER_PLUGIN_URL . 'admin/css/wp-trader_admin.css' );
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
		wp_register_script( 'wptrader-admin', WP_TRADER_PLUGIN_URL . 'admin/includes/js/wp-trader-admin.js');
		wp_register_script( 'jquery-mobile', 'http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js');
		wp_register_script( 'jquery-mobile-dialog', 'http://dev.jtsage.com/cdn/simpledialog/latest/jquery.mobile.simpledialog.min.js');
		wp_register_script( 'jquery-ui-core-custom', WP_TRADER_PLUGIN_URL . 'admin/includes/js/wptrader_jquery_ui.js');
		wp_enqueue_style( 'wptrader_plugin_mobile_stylesheet' );
		wp_enqueue_style( 'wptrader_plugin_mobile_dialog' );
		wp_enqueue_style( 'wptrader_plugin_stylesheet' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'wptrader-admin' );
		wp_enqueue_script( 'jquery-mobile' );
		wp_enqueue_script( 'jquery-mobile-dialog' );
		wp_enqueue_script( 'jquery-ui-core-custom' );
	}
	//End admin menu styles and scripts
	
	//Add WP-Trader menu to admin menu bar
	if(!function_exists('wptrader_menu_create_admin_menu')){
		function wptrader_menu_create_admin_menu() {
			//global $wptrader_main_menu, $wptrader_main, $wptrader_help, $wptrader_main_options, $wptrader_torrent_options, $wptrader_widgets_options, $wptrader_peers_list, $wptrader_free_leech_list, $wptrader_plugins;
			global $wptrader_main_menu, $wptrader_main, $wptrader_help, $wptrader_main_options, $wptrader_torrent_options, $wptrader_widgets_options, $wptrader_peers_list, $wptrader_free_leech_list;
			if (function_exists('add_menu_page')) {
				$wptrader_main_menu = add_menu_page('WP-Trader Plugin', 'WP-Trader', 8, WP_PLUGIN_FOLDER_NAME, 'wptrader_main', WP_TRADER_PLUGIN_URL . 'admin/css/images/admin_icons/admin_main.png');
			}
			if (function_exists('add_submenu_page')) {
				$wptrader_main = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Index','wptrader')), htmlspecialchars(__('Index','wptrader')), 8, WP_PLUGIN_FOLDER_NAME, 'wptrader_main');
				$wptrader_help = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Help','wptrader')), htmlspecialchars(__('Help','wptrader')), 8, 'wptrader-help', 'wptrader_help');
				$wptrader_main_options = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Options Main','wptrader')), htmlspecialchars(__('Options Main','wptrader')), 8, 'wptrader-options-main', 'wptrader_main_options');
				$wptrader_torrent_options = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Options Torrent','wptrader')), htmlspecialchars(__('Options Torrent','wptrader')), 8, 'wptrader-options-torrent', 'wptrader_torrent_options');
				$wptrader_widgets_options = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Options Widgets','wptrader')), htmlspecialchars(__('Options Widgets','wptrader')), 8, 'wptrader-options-widgets', 'wptrader_widgets_options');
				$wptrader_peers_list = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Peers List','wptrader')), htmlspecialchars(__('Peers List','wptrader')), 8, 'wptrader-peers-list', 'wptrader_peers_list');
				$wptrader_free_leech_list = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Free Leech List','wptrader')), htmlspecialchars(__('Free Leech List','wptrader')), 8, 'wptrader-free-leech-list', 'wptrader_free_leech_list');
				//$wptrader_plugins = add_submenu_page(WP_PLUGIN_FOLDER_NAME, htmlspecialchars(__('WP-Trader: Plugins','wptrader')), htmlspecialchars(__('Plugins','wptrader')), 8, 'wptrader-plugins', 'wptrader_plugins');
			}
			if (function_exists ('wptrader_admin_styles_scripts')){
				add_action( "admin_print_styles-$wptrader_main_menu", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_main", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_help", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_main_options", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_torrent_options", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_widgets_options", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_peers_list", "wptrader_admin_styles_scripts" );
				add_action( "admin_print_styles-$wptrader_free_leech_list", "wptrader_admin_styles_scripts" );
			}
		}
	}
	//End add WP-Trader menu to admin menu bar
	
	//Code for the wp_editor() to function correctly
	if (function_exists ('shortcode_unautop')){
		add_filter ('widget_text', 'shortcode_unautop');
	}
	add_filter('widget_text', 'do_shortcode', 11);
	wp_enqueue_script('media-upload');
	//End code for the wp_editor() to function correctly
?>