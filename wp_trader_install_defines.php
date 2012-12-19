<?php

/*

  * Holds the Defines

  * @package WP-Trader

  * @subpackage Template

*/

//Define things for the plugin
if ( !defined( "WP_PLUGIN_FOLDER_NAME" ) )
	define("WP_PLUGIN_FOLDER_NAME", "wp-trader");

if ( !defined( "WP_TRADER_PLUGIN_URL" ) )
	define("WP_TRADER_PLUGIN_URL", plugin_dir_url( __FILE__ ));
	
if ( !defined( "WP_TRADER_ABSPATH" ) )
	define( "WP_TRADER_ABSPATH", dirname( __FILE__ ) );

//Some code to define some db tables thanks to the WP-eCommerce plugin
// Use the DB method if it's around
global $wpdb;
if ( !empty( $wpdb->prefix ) )
	$wp_table_prefix = $wpdb->prefix;

// Fallback on the wp_config.php global
else if ( !empty( $table_prefix ) )
	$wp_table_prefix = $table_prefix;

if ( !defined( "TRADER_ANNOUNCE" ) )
	define( "TRADER_ANNOUNCE",          "{$wp_table_prefix}trader_announce" );

if ( !defined( "TRADER_COMPLETED" ) )
	define( "TRADER_COMPLETED",          "{$wp_table_prefix}trader_completed" );

if ( !defined( "TRADER_PEERS" ) )
	define( "TRADER_PEERS",     "{$wp_table_prefix}trader_peers" );

if ( !defined( "TRADER_TORRENTS" ) )
	define( "TRADER_TORRENTS",          "{$wp_table_prefix}trader_torrents" );

if ( !defined( "TRADER_TORRENT_LANGUAGES" ) )
	define( "TRADER_TORRENT_LANGUAGES",          "{$wp_table_prefix}trader_torrent_languages" );

if ( !defined( "TRADER_USER_META" ) )
	define( "TRADER_USER_META",          "{$wp_table_prefix}usermeta" );
//End define things for the plugin