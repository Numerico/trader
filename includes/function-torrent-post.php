<?php
/*
  * Holds the Torrent Post functions
  * @package WP-Trader
  * @subpackage Template
  */function sqlesc($x) {   if (!is_numeric($x)) {       $x = "".mysql_real_escape_string($x)."";   }   return $x;}
function torrent_download_box($torrent_post_id){
	global $current_user, $wpdb;
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' ); //If moved out of function will throw an error in admin panel
	$query = "SELECT id, size, info_hash, torrentlang FROM " . TRADER_TORRENTS . " WHERE post_id = ".$torrent_post_id."";
	$res = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($res)) {
		$torrent_id .= $row['id'];
		$size .= $row['size'];
		$torrent_infohash .= $row['info_hash'];
		$querystr = "SELECT name FROM " . TRADER_TORRENT_LANGUAGES . " WHERE id = ".$row['torrentlang']."";
		$lang_name = $wpdb->get_row($querystr);
		if (!$lang_name):
				$lang_name = "Unknown/NA";
		endif;
	}		if(isset($_POST["scrape"]) == "yes") {		$seeders1 = $leechers1 = $downloaded1 = null;		$tress = "SELECT url FROM " . TRADER_ANNOUNCE . " WHERE torrent = ".$torrent_id."";		$tres = mysql_query($tress) or die(mysql_error());		while ($trow = mysql_fetch_array($tres)) {			$ann = $trow["url"];			$tracker = explode("/", $ann);			$path = array_pop($tracker);			$oldpath = $path;			$path = preg_replace("/^announce/", "scrape", $path);			$tracker = implode("/", $tracker)."/".$path;			if ($oldpath == $path) {				continue;			}			if (preg_match("/thepiratebay.org/i", $tracker) || preg_match("/prq.to/", $tracker)) {				$tracker = "http://tracker.openbittorrent.com/scrape";			}			$stats = torrent_scrape_url($tracker, $torrent_infohash);			if ($stats['seeds'] != -1) {				$seeders1 += $stats['seeds'];				$leechers1 += $stats['peers'];				$downloaded1 += $stats['downloaded'];				$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'yes', seeders = $stats[seeds], leechers = $stats[peers], times_completed = $stats[downloaded] WHERE url = '".sqlesc($ann)."' AND torrent = ".$torrent_id."";				mysql_query($ares) or die(mysql_error());			} else {				$ares = "UPDATE " . TRADER_ANNOUNCE . " SET online = 'no' WHERE url = '".sqlesc($ann)."' AND torrent = ".$torrent_id."";				mysql_query($ares) or die(mysql_error());			}		}		if ($seeders1 !== null){			update_post_meta($torrent_post_id, "seeders", $seeders1);			update_post_meta($torrent_post_id, "leechers", $leechers1);			update_post_meta($torrent_post_id, "times_completed", $downloaded1);			update_post_meta($torrent_post_id, "last_action", current_time('mysql'));			update_post_meta($torrent_post_id, "torrent_visible", "1");		}	}	
	$torrent_times_completed = get_post_meta($torrent_post_id, "times_completed", true);
	$torrent_views = get_post_meta($torrent_post_id, "views", true);
	$torrent_views_add = $torrent_views + 1;
	$torrent_hits = get_post_meta($torrent_post_id, "hits", true);
	$torrent_leechers = get_post_meta($torrent_post_id, "leechers", true);
	$torrent_seeders = get_post_meta($torrent_post_id, "seeders", true);
	$torrent_last_action .= get_post_meta($torrent_post_id, "last_action", true);
	$torrent_download_box = '<table border="0" cellpadding="0" width="100%"><tbody>';
	$torrent_download_box = '<tr>';
	$torrent_download_box .= '<td style="text-align: center;"><a href="' . WP_TRADER_PLUGIN_URL . 'download.php?id='.$torrent_id.'">';
	$torrent_download_box .= '<img title="Download" src="' . WP_TRADER_PLUGIN_URL . 'templates/images/download_torrent.png" alt="Download" style="width: 54px; height: 54px; float: left; margin-top: 100px; margin-bottom: 100px;" />';
	$torrent_download_box .= '</a></td><td>&nbsp;</td>';
	$torrent_download_box .= '<td><p style="margin:0px 0px 0px 75px;">';
	$torrent_download_box .= '<b>Health:</b> <img src="' . WP_TRADER_PLUGIN_URL . 'templates/images/health/health_'.health($torrent_leechers, $torrent_seeders).'.gif" /><br />';
	$torrent_download_box .= '<b>Seeds:</b> '.number_format($torrent_seeders).' <br />';
	$torrent_download_box .= '<b>Leechers:</b> '.number_format($torrent_leechers).' <br />';
	$torrent_download_box .= '<b>Lang:</b> '.$lang_name->name.' <br />';
	$torrent_download_box .= '<b>Total Size:</b> '.mksize($size).' <br />';
	$torrent_download_box .= '<b>Info Hash:</b> '.$torrent_infohash.' <br />';
	$torrent_download_box .= '<b>Completed:</b> '.number_format($torrent_times_completed).' <br />';
	$torrent_download_box .= '<b>Views:</b> '.number_format($torrent_views).' <br />';
	$torrent_download_box .= '<b>Hits:</b> '.number_format($torrent_hits).' <br />';
	$torrent_download_box .= '<b>Last Checked:</b> '.$torrent_last_action.' <br />';	if (get_post_meta($torrent_post_id, "external", true) == '1'){		$torrent_download_box .= '<b>Tracked:</b> Externally <br />';			$torrent_download_box .= '<form style="margin:0px 0px 0px 75px;" action="" method="post"><input type="hidden" name="scrape" value="yes" /><input type="submit" name="submit" value="Update Stats" /></form>';
	}	$torrent_download_box .= '</p></td></tr></tbody></table>';
	$torrent_views_update = update_post_meta($torrent_post_id, "views", $torrent_views_add);
	return $torrent_download_box;
}

function torrent_peers_list($torrent_post_id){
	global $current_user, $wpdb;
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' );
	$query = "SELECT id, size, info_hash, torrentlang FROM " . TRADER_TORRENTS . " WHERE post_id = ".$torrent_post_id."";
	$res = mysql_query($query) or die(mysql_error());
	while ($row = mysql_fetch_assoc($res)) {
		$torrent_id .= $row['id'];
		$size .= $row['size'];
		$torrent_infohash .= $row['info_hash'];
		$querystr = "SELECT name FROM " . TRADER_TORRENT_LANGUAGES . " WHERE id = ".$row['torrentlang']."";
		$lang_name = $wpdb->get_row($querystr);
		if (!$lang_name):
			$lang_name = "Unknown/NA";
		endif;
	}
	$torrent_leechers = get_post_meta($torrent_post_id, "leechers", true);
	$torrent_seeders = get_post_meta($torrent_post_id, "seeders", true);
	$torrent_external_yes = get_post_meta($torrent_post_id, "external", true) == 1;
	$torrent_external_no = get_post_meta($torrent_post_id, "external", true) == 0;
	if ($torrent_external_no){
		$query = mysql_query("SELECT * FROM " . TRADER_PEERS . " WHERE torrent = ".$torrent_id." ORDER BY seeder DESC");
		$result = mysql_num_rows($query);
		
		if($result == 0) {
			$torrent_peers_list .= "Sorry No Active Peers.";
		}else{
			// Columns
			$cols = explode(",", get_option('torrent_peers_list'));
			$cols = array_map("strtolower", $cols);
			$cols = array_map("trim", $cols);
			$colspan = count($cols);
			// End
			$torrent_peers_list .= '<div id="table-container">';
			$torrent_peers_list .= '<div id="row">';
			foreach ($cols as $col) {
				switch ($col) {
					case 'port':
						$torrent_peers_list .= '<div id="left">Port</div>';
					break;
					case 'uploaded':
						$torrent_peers_list .= '<div id="left">Uploaded</div>';
					break;
					case 'downloaded':
						$torrent_peers_list .= '<div id="left">Downloaded</div>';
					break;
					case 'ratio':
						$torrent_peers_list .= '<div id="middle">Ratio</div>';
					break;
					case 'left':
						$torrent_peers_list .= '<div id="middle">Left</div>';
					break;
					case 'ready':
						$torrent_peers_list .= '<div id="middle">Ready</div>';
					break;
					case 'seed':
						$torrent_peers_list .= '<div id="right">Seed</div>';
					break;
					case 'connected':
						$torrent_peers_list .= '<div id="right">Connected</div>';
					break;
					case 'client':
						$torrent_peers_list .= '<div id="right">Client</div>';
					break;
					case 'nick':
						$torrent_peers_list .= '<div id="right">Nick</div>';
					break;
				}
			}
			$torrent_peers_list .= '</div>';
			
			while($row1 = MYSQL_FETCH_ARRAY($query)){
				if ($row1["downloaded"] > 0){
					$ratio = $row1["uploaded"] / $row1["downloaded"];
					$ratio = number_format($ratio, 3);
				}else{
					$ratio = "---";
				}
				$percentcomp = sprintf("%.2f", 100 * (1 - ($row1["to_go"] / $size)));
				$torrent_peers_list .= '<div id="row">';
				foreach ($cols as $col) {
					switch ($col) {
						case 'port':
							$torrent_peers_list .= '<div id="left">'.$row1["port"].'</div>';
						break;
						case 'uploaded':
							$torrent_peers_list .= '<div id="left">'.mksize($row1["uploaded"]).'</div>';
						break;
						case 'downloaded':
							$torrent_peers_list .= '<div id="left">'.mksize($row1["downloaded"]).'</div>';
						break;
						case 'ratio':
							$torrent_peers_list .= '<div id="middle">'.$ratio.'</div>';
						break;
						case 'left':
							$torrent_peers_list .= '<div id="middle">'.mksize($row1["to_go"]).'</div>';
						break;
						case 'ready':
							$torrent_peers_list .= '<div id="middle">'.$percentcomp.'%</div>';
						break;
						case 'seed':
							$torrent_peers_list .= '<div id="right">'.$row1["seeder"].'</div>';
						break;
						case 'connected':
							$torrent_peers_list .= '<div id="right">'.$row1["connectable"].'</div>';
						break;
						case 'client':
							$torrent_peers_list .= '<div id="right">'.$row1["client"].'</div>';
						break;
						case 'nick':
							$torrent_peers_list .= '<div id="right">Private</div>';
						break;
					}
				}
				$torrent_peers_list .= '</div>';
			}
			$torrent_peers_list .= '</div>';
			
		}
	}
	return $torrent_peers_list;
}
function torrent_files_list($torrent_post_id){
	
	include_once( WP_TRADER_ABSPATH . '/includes/function-main.php' ); //If moved out of function will throw an error in admin panel
	//Get File list
	$file_list =  get_post_meta($torrent_post_id, 'torrent_files');
	
	$file_list_template .= '<div id="table-container">';
	foreach ($file_list[0] as $file_list){
		$file_list_template .= '<div id="row"><div id="left">'.$file_list["path"].'</div><div id="right">'.mksize($file_list["size"]).'</div></div>';
	}
	$file_list_template .= '</div>';
	//End get file list
	return $file_list_template;
}
function torrent_nfo($torrent_post_id){
	//DISPLAY NFO BLOCK
function my_nfo_translate($nfo){
        $trans = array(
        "\x80" => "&#199;", "\x81" => "&#252;", "\x82" => "&#233;", "\x83" => "&#226;", "\x84" => "&#228;", "\x85" => "&#224;", "\x86" => "&#229;", "\x87" => "&#231;", "\x88" => "&#234;", "\x89" => "&#235;", "\x8a" => "&#232;", "\x8b" => "&#239;", "\x8c" => "&#238;", "\x8d" => "&#236;", "\x8e" => "&#196;", "\x8f" => "&#197;", "\x90" => "&#201;",
        "\x91" => "&#230;", "\x92" => "&#198;", "\x93" => "&#244;", "\x94" => "&#246;", "\x95" => "&#242;", "\x96" => "&#251;", "\x97" => "&#249;", "\x98" => "&#255;", "\x99" => "&#214;", "\x9a" => "&#220;", "\x9b" => "&#162;", "\x9c" => "&#163;", "\x9d" => "&#165;", "\x9e" => "&#8359;", "\x9f" => "&#402;", "\xa0" => "&#225;", "\xa1" => "&#237;",
        "\xa2" => "&#243;", "\xa3" => "&#250;", "\xa4" => "&#241;", "\xa5" => "&#209;", "\xa6" => "&#170;", "\xa7" => "&#186;", "\xa8" => "&#191;", "\xa9" => "&#8976;", "\xaa" => "&#172;", "\xab" => "&#189;", "\xac" => "&#188;", "\xad" => "&#161;", "\xae" => "&#171;", "\xaf" => "&#187;", "\xb0" => "&#9617;", "\xb1" => "&#9618;", "\xb2" => "&#9619;",
        "\xb3" => "&#9474;", "\xb4" => "&#9508;", "\xb5" => "&#9569;", "\xb6" => "&#9570;", "\xb7" => "&#9558;", "\xb8" => "&#9557;", "\xb9" => "&#9571;", "\xba" => "&#9553;", "\xbb" => "&#9559;", "\xbc" => "&#9565;", "\xbd" => "&#9564;", "\xbe" => "&#9563;", "\xbf" => "&#9488;", "\xc0" => "&#9492;", "\xc1" => "&#9524;", "\xc2" => "&#9516;", "\xc3" => "&#9500;",
        "\xc4" => "&#9472;", "\xc5" => "&#9532;", "\xc6" => "&#9566;", "\xc7" => "&#9567;", "\xc8" => "&#9562;", "\xc9" => "&#9556;", "\xca" => "&#9577;", "\xcb" => "&#9574;", "\xcc" => "&#9568;", "\xcd" => "&#9552;", "\xce" => "&#9580;", "\xcf" => "&#9575;", "\xd0" => "&#9576;", "\xd1" => "&#9572;", "\xd2" => "&#9573;", "\xd3" => "&#9561;", "\xd4" => "&#9560;",
        "\xd5" => "&#9554;", "\xd6" => "&#9555;", "\xd7" => "&#9579;", "\xd8" => "&#9578;", "\xd9" => "&#9496;", "\xda" => "&#9484;", "\xdb" => "&#9608;", "\xdc" => "&#9604;", "\xdd" => "&#9612;", "\xde" => "&#9616;", "\xdf" => "&#9600;", "\xe0" => "&#945;", "\xe1" => "&#223;", "\xe2" => "&#915;", "\xe3" => "&#960;", "\xe4" => "&#931;", "\xe5" => "&#963;",
        "\xe6" => "&#181;", "\xe7" => "&#964;", "\xe8" => "&#934;", "\xe9" => "&#920;", "\xea" => "&#937;", "\xeb" => "&#948;", "\xec" => "&#8734;", "\xed" => "&#966;", "\xee" => "&#949;", "\xef" => "&#8745;", "\xf0" => "&#8801;", "\xf1" => "&#177;", "\xf2" => "&#8805;", "\xf3" => "&#8804;", "\xf4" => "&#8992;", "\xf5" => "&#8993;", "\xf6" => "&#247;",
        "\xf7" => "&#8776;", "\xf8" => "&#176;", "\xf9" => "&#8729;", "\xfa" => "&#183;", "\xfb" => "&#8730;", "\xfc" => "&#8319;", "\xfd" => "&#178;", "\xfe" => "&#9632;", "\xff" => "&#160;",
        );
        $trans2 = array(
		"\xe4" => "&auml;", "\xF6" => "&ouml;", "\xFC" => "&uuml;", "\xC4" => "&Auml;",
		"\xD6" => "&Ouml;", "\xDC" => "&Uuml;", "\xDF" => "&szlig;");
        $all_chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $last_was_ascii = False;
        $tmp = "";
        $nfo = $nfo . "\00";
        for ($i = 0; $i < (strlen($nfo) - 1); $i++)
        {
                $char = $nfo[$i];
                if (isset($trans2[$char]) and ($last_was_ascii or strpos($all_chars, ($nfo[$i + 1]))))
                {
                        $tmp = $tmp . $trans2[$char];
                        $last_was_ascii = True;
                }
                else
                {
                        if (isset($trans[$char]))
                        {
                                $tmp = $tmp . $trans[$char];
                        }
                        else
                        {
                            $tmp = $tmp . $char;
                        }
                        $last_was_ascii = strpos($all_chars, $char);
                }
        }
        return $tmp;
}
//-----------------------------------------------
	//DISPLAY NFO BLOCK
	$nfo_location .= get_post_meta($torrent_post_id, "nfo_location", true);
	$nfo_png_location .= get_post_meta($torrent_post_id, "nfo_png_location", true);
	if(!$nfo_location == ""){
		$file_get_contents = file_get_contents($nfo_location);
		$nfo = htmlspecialchars($file_get_contents);
		if ($nfo && wp_trader_options('nfo_display_type_no')) {	
			$nfo = my_nfo_translate($nfo);
			$nfo_view .= "<pre>".stripslashes($nfo)."</pre>";
        }elseif(!$nfo_png_location == "" && extension_loaded('gd') && wp_trader_options('nfo_display_type_yes')){
           $nfo_view .= "<center><img src='".$nfo_png_location."' alt='NFO'/></center>";
        }
	}else{
		$nfo_view .= "Sorry no nfo available for the torrent.";
	}
	return $nfo_view;
}
function torrent_container($torrent_post_id) {
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo WP_TRADER_PLUGIN_URL . 'css/torrent_description.css'; ?>">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
	<script src="http://cdn.jquerytools.org/1.2.6/full/jquery.tools.min.js"></script>
	<script src="<?php echo WP_TRADER_PLUGIN_URL . '/includes/js/torrent_description.js'; ?>" type="text/javascript"></script>
	<?php
	$torrent_descr = get_post_meta($torrent_post_id, "descr", true);
	$upload_container .= '<ul class="css-tabs">';
	$upload_container .= '<li><a href="#">Description</a></li>';
	if (wp_trader_options('show_file_list_yes')){
		$upload_container .= '<li><a href="#">File List</a></li>';
	}
	if (wp_trader_options('show_peer_list_yes')){
		$upload_container .= '<li><a href="#">Peers</a></li>';
	}
	if (wp_trader_options('allow_nfo_upload_yes')){
		$upload_container .= '<li><a href="#">NFO</a></li>';
	}
	$upload_container .= '</ul>';
	$upload_container .= '<div class="css-panes">';
	$upload_container .= '<div>';
	$upload_container .= ''.$torrent_descr.'';
	$upload_container .= '</div>';
	if (wp_trader_options('show_file_list_yes')){
		$upload_container .= '<div>';
		$upload_container .= ''.torrent_files_list($torrent_post_id).'';
		$upload_container .= '</div>';
	}
	if (wp_trader_options('show_peer_list_yes')){
		$upload_container .= '<div>';
		$upload_container .= ''.torrent_peers_list($torrent_post_id).'';
		$upload_container .= '</div>';
	}
	if (wp_trader_options('allow_nfo_upload_yes')){
		$upload_container .= '<div>';
		$upload_container .= ''.torrent_nfo($torrent_post_id).'';
		$upload_container .= '</div>';
	}
	$upload_container .= '</div>';
	
	return $upload_container;
}