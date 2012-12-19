<?php
/*
Template Name: Scrape
*/
error_reporting(0); //disable error reporting
$root = dirname(dirname(dirname(dirname(__FILE__))));


	if (file_exists($root.'/wp-load.php')) {


		// WP 2.6


		require_once($root.'/wp-load.php');


	} else {


		// Before 2.6


		require_once($root.'/wp-config.php');


	}
	global $wpdb, $current_user;
	//Some code to define some db tables thanks to the WP-eCommerce plugin

	// Use the DB method if it's around

	if ( !empty( $wpdb->prefix ) )

		$wp_table_prefix = $wpdb->prefix;



	// Fallback on the wp_config.php global

	else if ( !empty( $table_prefix ) )

		$wp_table_prefix = $table_prefix;

		

	define( 'TRADER_ANNOUNCE',          "{$wp_table_prefix}trader_announce" );

	define( 'TRADER_COMPLETED',          "{$wp_table_prefix}trader_completed" );

	define( 'TRADER_PEERS',     "{$wp_table_prefix}trader_peers" );

	define( 'TRADER_TORRENTS',          "{$wp_table_prefix}trader_torrents" );

	define( 'TRADER_TORRENT_LANGUAGES',          "{$wp_table_prefix}trader_torrent_languages" );

	define( 'TRADER_USER_META',          "{$wp_table_prefix}usermeta" );

// check if client can handle gzip
if (stristr($_SERVER["HTTP_ACCEPT_ENCODING"],"gzip") && extension_loaded('zlib') && ini_get("zlib.output_compression") == 0) {
    if (ini_get('output_handler')!='ob_gzhandler') {
        ob_start("ob_gzhandler");
    } else {
        ob_start();
    }
}else{
     ob_start();
}
// end gzip controll


function hex2bin($hexdata) {
  $bindata = "";
  for ($i=0;$i<strlen($hexdata);$i+=2) {
    $bindata.=chr(hexdec(substr($hexdata,$i,2)));
  }

  return $bindata;
}


function sqlesc($x) {
    return "'".mysql_real_escape_string($x)."'";
}

$infohash = array();

foreach (explode("&", $_SERVER["QUERY_STRING"]) as $item) {
    if (substr($item, 0, 10) == "info_hash=") {
        $hash = substr($item, 10);
        $hash = urldecode($hash);

        if (get_magic_quotes_gpc())
            $info_hash = stripslashes($hash);
        else
            $info_hash = $hash;
        if (strlen($info_hash) == 20)
            $info_hash = bin2hex($info_hash);
        else if (strlen($info_hash) != 40)
            continue;
        $infohash[] = sqlesc(strtolower($info_hash));
    }
}

if (!count($infohash)) die("Invalid infohash.");
    $query = mysql_query("SELECT post_id, info_hash, filename FROM " . TRADER_TORRENTS . " WHERE info_hash IN (".join(",", $infohash).")");

$result="d5:filesd";

while ($row = mysql_fetch_row($query)){
	$torrent_post_id = $row[0];
	$seeders = get_post_meta($torrent_post_id, "seeders", true);
	$leechers = get_post_meta($torrent_post_id, "leechers", true);
	$times_completed = get_post_meta($torrent_post_id, "times_completed", true);
    $hash = hex2bin($row[1]);
    $result.="20:".$hash."d";
    $result.="8:completei".$seeders."e";
    $result.="10:downloadedi".$times_completed."e";
    $result.="10:incompletei".$leechers."e";
    $result.="4:name".strlen($row[2]).":".$row[2]."e";
    $result.="e";
}

$result.="ee";

echo $result;
ob_end_flush();
mysql_close();
?>