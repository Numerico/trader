<?php
/*
  * Holds the Cleanup functions
  * @package WP-Trader
  * @subpackage Template
  */
function get_date_time($timestamp = 0){
	if ($timestamp)
		return date("Y-m-d H:i:s", $timestamp);
	else
		return gmdate("Y-m-d H:i:s");
}
function sql_timestamp_to_unix_timestamp($s){
	return mktime(substr($s, 11, 2), substr($s, 14, 2), substr($s, 17, 2), substr($s, 5, 2), substr($s, 8, 2), substr($s, 0, 4));
}
function gmtime() {
	return sql_timestamp_to_unix_timestamp(get_date_time());
}
function do_cleanup() {
	global $wpdb;
	//LOCAL TORRENTS - GET PEERS DATA AND UPDATE BROWSE STATS
	//DELETE OLD NON-ACTIVE PEERS
    $deadtime = get_date_time(gmtime() - get_option('announce_interval'));
    $wpdb->query("DELETE FROM ".$wpdb->trader_peers." WHERE last_action < '$deadtime'");
	
	$torrents = array();
	$res = mysql_query("SELECT torrent, seeder, COUNT(*) AS c FROM ".$wpdb->trader_peers." GROUP BY torrent, seeder");
	while ($row = mysql_fetch_assoc($res)) {
		if ($row["seeder"] == "yes")
			$key = "seeders";
		else
			$key = "leechers";
		$torrents[$row["torrent"]][$key] = $row["c"];
	}

	$fields = explode(":", "leechers:seeders");
	$res = mysql_query("SELECT id, post_id FROM ".$wpdb->trader_torrents." WHERE banned = 'no'");
	while ($row = mysql_fetch_assoc($res)) {
		$id = $row["id"];
		$torrent_post_id = $row["post_id"];
		$torr = $torrents[$id];
		foreach ($fields as $field) {
			update_post_meta($torrent_post_id, $field, $torr[$field]);
		}
	}


//LOCAL TORRENTS - MAKE NON-ACTIVE/OLD TORRENTS INVISIBLE
$deadtime = gmtime() - get_option('max_dead_torrent_time');
//mysql_query("UPDATE ".$wpdb->trader_torrents." SET visible='no' WHERE visible='yes' AND last_action < FROM_UNIXTIME($deadtime) AND seeders = '0' AND leechers = '0' AND external !='yes'");
query_posts('visible=1&last_action<FROM_UNIXTIME($deadtime)&seeders=0&leechers=0&external=0');
if (have_posts()) :
	while (have_posts()) :
		update_post_meta(the_ID(), 'visible', '0');
		$wptrader_post = array();
		$wptrader_post['ID'] = the_ID();
		$wptrader_post['post_status'] = 'pending';
		wp_update_post( $my_post );
		update_post_meta(the_ID(), 'visible', '0');
	endwhile;
endif;

    $res = mysql_query("SHOW TABLES");
   
    while ( $table = mysql_fetch_row($res) )
    {
        mysql_query("OPTIMIZE TABLE `$table[0]`;");
    }

}
do_cleanup();
?>