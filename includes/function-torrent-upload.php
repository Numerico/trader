<?php
/*
  * Holds the Torrent Upload functions
  * @package WP-Trader
  * @subpackage Template
  */
function validfilename($name) {
    return preg_match('/^[^\0-\x1f:\\\\\/?*\xff#<>|]+$/si', $name);
}

function is_valid_id($id){
	return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

function langlist() {
	global $wpdb;
    $ret = array();
    $res = mysql_query("SELECT id, name, image FROM " . $wpdb->prefix . "trader_torrent_languages ORDER BY sort_index, id");
    while ($row = mysql_fetch_array($res))
        $ret[] = $row;
    return $ret;
}

function wp_trader_insert_torrent($upload_torrent, $wp_error = false) {
	global $wpdb;
	$wpdb->insert( $wpdb->prefix.'trader_torrents', $upload_torrent, array( '%s' ) );
}

function wp_trader_insert_announce($upload_torrent_announce, $wp_error = false) {	
	global $wpdb;	
	$wpdb->insert( $wpdb->prefix.'trader_announce', $upload_torrent_announce, array( '%s' ) );
}

function wp_trader_insert_torrent_post($upload_torrent_post, $wp_error = false) {
	global $wpdb;
	wp_insert_post( $upload_torrent_post );
}

function wp_trader_insert_torrent_image_post($upload_torrent_image_post, $wp_error = false) {
	global $wpdb;
	wp_insert_post( $upload_torrent_image_post );
}

function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}

function crop_image($extension, $uploaded_file_name, $new_width, $new_height, $uploaded_save_name) {
	if($extension=="jpg" || $extension=="jpeg" ){
		$uploadedfile = $uploaded_file_name;
		$src = imagecreatefromjpeg($uploadedfile);
	}else if($extension=="png"){
		$uploadedfile = $uploaded_file_name;
		$src = imagecreatefrompng($uploadedfile);
	}else {
		$src = imagecreatefromgif($uploadedfile);
	}
	
	list($width,$height)=getimagesize($uploadedfile);
	
	$newwidth = $new_width;
	$newheight=($height/$width)*$newwidth;
	$tmp=imagecreatetruecolor($newwidth,$newheight);

	$newwidth1= $new_height;
	$newheight1=($height/$width)*$newwidth1;
	$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

	imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
	imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

	$filename = $uploaded_file_name;
	$filename1 = $uploaded_save_name;

	imagejpeg($tmp,$filename,100);
	imagejpeg($tmp1,$filename1,100);
	imagedestroy($src);
	imagedestroy($tmp);
	imagedestroy($tmp1);
}

function mksecret($len = 20) {
	$chars = array_merge(range(0, 9), range("A", "Z"), range("a", "z"));
	shuffle($chars);
	$x = count($chars) - 1;
	for ($i = 1; $i <= $len; $i++)
		$str .= $chars[mt_rand(0, $x)];
		return $str;
}

function unlink_files() {
	@unlink("$torrent_dir/$fname");
	@unlink($tmpname);
	@unlink("$nfo_dir/$nfofilename");
}

function scrape_upload($torrent_id, $infohash) {
	$seeders1 = $leechers1 = $downloaded1 = null;
				//echo "<div id='info' class='info'><center><b>Loading:</b> ".count($TorrentInfo[6])." urls to scrape.</center></div>";
				$tres = mysql_query("SELECT url FROM " . TRADER_ANNOUNCE . " WHERE torrent=$torrent_id");
				while ($trow = mysql_fetch_array($tres)) {
					$ann = $trow["url"];
					$tracker = explode("/", $ann);
					$path = array_pop($tracker);
					$oldpath = $path;
					$path = preg_replace("/^announce/", "scrape", $path);
					$tracker = implode("/", $tracker)."/".$path;

					if ($oldpath == $path) {
						continue;
					}

					if (preg_match("/thepiratebay.org/i", $tracker) || preg_match("/prq.to/", $tracker)) {
						$tracker = "http://tracker.openbittorrent.com/scrape";
					}
					//echo "<div id='validation' class='validation'><center><b>Currently Scraping:</b> <a href='".$ann."' target='_blank'>" . htmlspecialchars($ann) . "</a></center></div>"; 
					$stats = torrent_scrape_url($tracker, $infohash);
					if ($stats['seeds'] != -1) {
						$seeders1 += $stats['seeds'];
						$leechers1 += $stats['peers'];
						$downloaded1 += $stats['downloaded'];
						$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'yes', seeders = $stats[seeds], leechers = $stats[peers], times_completed = $stats[downloaded] WHERE url = '".sqlesc($ann)."' AND torrent = ".$torrent_id."";
						mysql_query($ares) or die(mysql_error());
						//echo "<div id='success' class='success'><center><b>Stats Detected:</b> <font color='red'>Seeders:</font><font color='green'>".$stats[seeds]."</font>, <font color='red'>Leechers:</font><font color='green'>".$stats[peers]."</font>, <font color='red'>Completed:</font><font color='green'>".$stats[downloaded]."</font></center></div>"; 
					} else {
						$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'no' WHERE url = '".sqlesc($ann)."' AND torrent = ".$torrent_id."";
						mysql_query($ares) or die(mysql_error());
					}
				}

				if ($seeders1 !== null){
					update_post_meta($upload_torrent_post_id, "seeders", $seeders1);
					update_post_meta($upload_torrent_post_id, "leechers", $leechers1);
					update_post_meta($upload_torrent_post_id, "times_completed", $downloaded1);
					update_post_meta($upload_torrent_post_id, "last_action", current_time('mysql'));
					update_post_meta($upload_torrent_post_id, "torrent_visible", "1");
				}
}
?>