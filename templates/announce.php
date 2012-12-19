<?php
/*
Template Name: Announce
*/
	global $wpdb, $current_user;
	
	$members_only = ( get_option('members_only') == 1 ) ? true : false;
	$members_only_wait = ( get_option('members_only_wait') == 1 ) ? true : false;
	$ip_passkey_tracking = ( get_option('ip_passkey_tracking') == 1 ) ? true : false;

//START FUNCTIONS

function hex2bin($hexdata) {
  $bindata = "";
  for ($i=0;$i<strlen($hexdata);$i+=2) {
    $bindata.=chr(hexdec(substr($hexdata,$i,2)));
  }
  return $bindata;
}

function is_valid_id($id) {
  return is_numeric($id) && ($id > 0) && (floor($id) == $id);
}

function hash_pad($hash) {
    return str_pad($hash, 20);
}


function sqlesc($x) {
    return "'".mysql_real_escape_string($x)."'";
}

function err($msg) {
    benc_resp(array("failure reason" => array(type => "string", value => $msg)));
    exit();
}

function benc($obj) {
    if (!is_array($obj) || !isset($obj["type"]) || !isset($obj["value"]))
        return;
    $c = $obj["value"];
    switch ($obj["type"]) {
        case "string":
            return benc_str($c);
        case "integer":
            return benc_int($c);
        case "list":
            return benc_list($c);
        case "dictionary":
            return benc_dict($c);
        default:
            return;
    }
}

function benc_str($s) {
    return strlen($s) . ":$s";
}

function benc_int($i) {
    return "i" . $i . "e";
}

function benc_list($a) {
    $s = "l";
    foreach ($a as $e) {
        $s .= benc($e);
    }
    $s .= "e";
    return $s;
}

function benc_dict($d) {
    $s = "d";
    $keys = array_keys($d);
    sort($keys);
    foreach ($keys as $k) {
        $v = $d[$k];
        $s .= benc_str($k);
        $s .= benc($v);
    }
    $s .= "e";
    return $s;
}

function benc_resp($d) {
    benc_resp_raw(benc(array(type => "dictionary", value => $d)));
}

function benc_resp_raw($x) {
	header("Content-Type: text/plain");
	header("Pragma: no-cache");

	if (extension_loaded('zlib') && !ini_get('zlib.output_compression') && $_SERVER["HTTP_ACCEPT_ENCODING"] == "gzip") {
		header("Content-Encoding: gzip");
		echo gzencode($x, 9, FORCE_GZIP);
	} else
		print($x);
}

function portblacklisted($port) {
    // direct connect
    if ($port >= 411 && $port <= 413) return true;

    // kazaa
    if ($port == 1214) return true;

    // gnutella
    if ($port >= 6346 && $port <= 6347) return true;

    // emule
    if ($port == 4662) return true;

    // winmx
    if ($port == 6699) return true;

    return false;
}

//////////////////////// NOW WE DO THE ANNOUNCE CODE ////////////////////////

// BLOCK ACCESS WITH WEB BROWSERS
$agent = $_SERVER["HTTP_USER_AGENT"];
if (preg_match("/^Mozilla\\//", $agent) || preg_match("/^Opera\\//", $agent) || preg_match("/^Links /", $agent) || preg_match("/^Lynx\\//", $agent))
	die("No");

//GET DETAILS OF PEERS ANNOUNCE
if (!$members_only || ($members_only && $ip_passkey_tracking_no)) {
	foreach (array("info_hash","peer_id","ip","event") as $x)
        $GLOBALS[$x] = stripslashes($_GET[$x]);
}elseif($members_only && $ip_passkey_tracking) {
	foreach (array("passkey","info_hash","peer_id","ip","event") as $x)
        $GLOBALS[$x] = stripslashes($_GET[$x]);
}

foreach (array("port","downloaded","uploaded","left") as $x)
    $GLOBALS[$x] = (int) $_GET[$x];
	
if (!isset($GLOBALS[$x]))
		err("Missing key: $x");
		
if (strpos($passkey, "?")) {
    $tmp = substr($passkey, strpos($passkey, "?"));
    $passkey = substr($passkey, 0, strpos($passkey, "?"));
    $tmpname = substr($tmp, 1, strpos($tmp, "=")-1);
    $tmpvalue = substr($tmp, strpos($tmp, "=")+1);
    $GLOBALS[$tmpname] = $tmpvalue;
}

if (strlen($peer_id) != 20)
	err("Invalid peer_id");

$no_peer_id = (int) $_GET["no_peer_id"];

    if (strlen($GLOBALS['info_hash']) == 20)
        $GLOBALS['info_hash'] = bin2hex($GLOBALS['info_hash']);
    else if (strlen($GLOBALS['info_hash']) != 40)
        err("Invalid info hash value.");
    $GLOBALS['info_hash'] = strtolower($GLOBALS['info_hash']);

	if ($MEMBERSONLY){
		if (strlen($passkey) != 32)
			err("Invalid passkey (" . strlen($passkey) . " - $passkey)");
	}

$ip = $_SERVER["REMOTE_ADDR"];

//PORT CHECK
if (!$port || $port > 0xffff)
    err("invalid port");

//TRACKER EVENT CHECK
if (!isset($event))
    $event = "";

$seeder = ($left == 0) ? "yes" : "no";

//Agent Ban
$agentarray = array_map("trim", explode(",", get_option('agent_bans')));
$useragent = substr($peer_id, 0, 8);
foreach($agentarray as $bannedclient)
if (@strpos($useragent, $bannedclient) !== false)
	err("Client is banned");
//End Agent Bans

if (portblacklisted($port))
	err("Port $port is blacklisted.");

$peerfields = "seeder, UNIX_TIMESTAMP(last_action) AS ez, peer_id, ip, port, uploaded, downloaded, userid, passkey"; //peers details to get

$torrentfields = "id, info_hash"; //torrent details to get

$useridm = 0;
if ($members_only && $ip_passkey_tracking){
	global $wpdb;
	//check passkey is valid, and get users details
	$user = $wpdb->get_row("SELECT * FROM " . TRADER_USER_META . " WHERE meta_value=".sqlesc($passkey)."") or err("Cannot Get User Details");
	if (!$user)
		err("Cannot locate a user with that passkey!");
	$useridm = $user->user_id; //etc
}elseif ($members_only && !$ip_passkey_tracking) {
	global $wpdb;
	//check passkey is valid, and get users details
	$user = $wpdb->get_row("SELECT * FROM " . TRADER_USER_META . " WHERE meta_value=".sqlesc($ip)."") or err("Unrecognized host $ip - Go to " . site_url() . " to sign up or login.");
	if (!$user)
		err("Unrecognized host $ip - Go to " . site_url() . " to sign up or login.");
	$useridm = $user->user_id; //etc
}


//check torrent is valid and get torrent fields
#$torrent = $wpdb->get_row("SELECT * FROM " . TRADER_TORRENTS . " WHERE info_hash = " .sqlesc($info_hash), ARRAY_A . "") or err("Cannot Get Torrent Details");

$res = mysql_query("SELECT $torrentfields FROM " . TRADER_TORRENTS . " WHERE info_hash = " . sqlesc($info_hash) . "");
$torrent = mysql_fetch_assoc($res);

if (!$torrent)
    err("Torrent not found on this tracker - hash = " . $info_hash);
if ($torrent["banned"]=='yes')
    err("Torrent has been banned - hash = " . $info_hash);
global $wpdb;
$torrentid .= $torrent["id"];
$torrent_post_id .= $torrent["post_id"];
$torrent_seeders .= get_post_meta($torrent_post_id, "seeders", true);
$torrent_leechers .= get_post_meta($torrent_post_id, "leechers", true);
$torrent_times_completed .= get_post_meta($torrent_post_id, "times_completed", true);
$torrent_num_peers .= $torrent_seed + $torrent_leechers;

//Now get data from peers table
$peerlimit = get_option('announce_peerlimit');
if ($torrent_num_peers > $peerlimit){
    $limit = "ORDER BY RAND() LIMIT $peerlimit";
}else{
    $limit = "";
}
$res = mysql_query("SELECT $peerfields FROM " . TRADER_PEERS . " WHERE torrent = $torrentid $limit") or err("Error Selecting Peers");

//DO SOME BENC STUFF TO THE PEERS CONNECTION
$resp = "d8:completei".$torrent_seeders."e10:downloadedi".$torrent_times_completed."e10:incompletei".$torrent_leechers."e";
$resp .= benc_str("interval") . "i" . get_option('announce_interval') . "e" . benc_str("min interval") . "i300e" . benc_str("peers");
unset($self);
while ($row = mysql_fetch_assoc($res)){
    $row["peer_id"] = hash_pad($row["peer_id"]);

    if ($row["peer_id"] === $peer_id){
        $self = $row;
        continue;
    }

	$peers .= "d" . benc_str("ip") . benc_str($row["ip"]);
        if (!$no_peer_id)
		$peers .= benc_str("peer id") . benc_str($row["peer_id"]);
        $peers .= benc_str("port") . "i" . $row["port"] . "ee";
}
$resp .= "l{$peers}e";
$resp .= "ee";

$selfwhere = "torrent = $torrentid AND peer_id = ".sqlesc($peer_id);



// FILL $SELF WITH DETAILS FROM PEERS TABLE (CONNECTING PEERS DETAILS)
if (!isset($self)){

	//check passkey isnt leaked
	if ($members_only && get_user_meta($useridm, 'download_banned', true) != 1) {
		$valid = @mysql_fetch_row(@mysql_query("SELECT COUNT(*) FROM " . TRADER_PEERS . " WHERE torrent=$torrentid AND passkey=" . sqlesc($passkey))) or err("Error Checking Psskey Is Leaked");

		if ($valid[0] >= 6 && $seeder == 'no')
			err("Connection limit exceeded! You may only leech from one location at a time.");

		if ($valid[0] >= 9 && $seeder == 'yes')
			err("Connection limit exceeded!");
	}

	$res = mysql_query("SELECT $peerfields FROM " . TRADER_PEERS . " WHERE $selfwhere") or err("Error Selecting Peers Table $peer_id");
	$row = mysql_fetch_assoc($res);
	if ($row){
	        $self = $row;
	}
}
// END $SELF FILL


if (!isset($self)){ //IF PEER IS NOT IN PEERS TABLE DO THE WAIT TIME CHECK
	if ($members_only_wait && $members_only && get_user_meta($useridm, 'download_banned', true) != 1){
		global $wpdb;
		$user_info = get_userdata($useridm);
		// below line get the all capabilities from capability table.
		$capabilities = $user_info->{$wpdb->prefix . 'capabilities'};
        if (count($capabilities) > 0) :
	    if ( !isset( $wp_roles ) )
	   	    $wp_roles = new WP_Roles();
 
	    foreach ( $wp_roles->role_names as $role => $name ) :
		    if ( array_key_exists( $role, $capabilities ) )
			    $roles .= $role;
	    endforeach;
        endif;
		//wait time check
		$post_id = get_post($row["post_id"]);
		$post_added = $post_id->post_date;
		if($left > 0 && in_array($roles, explode(",",get_option('torrent_roles')))){ //check only leechers and lowest user class
			global $wpdb;
			$gigs = get_user_meta($useridm, 'trader_upload', true) / (1024*1024*1024);
			$elapsed = floor((current_time('timestamp') - strtotime($post_added)) / 3600); 
			$ratio = ((get_user_meta($useridm, 'trader_download', true) > 0) ? (get_user_meta($useridm, 'trader_upload', true) / get_user_meta($useridm, 'trader_download', true)) : 1); 
			if ($ratio == 0 && $gigs == 0) $wait = get_option('minimum_waita');
			elseif ($ratio < get_option('minimum_ratioa') || $gigs < get_option('minimum_gigsa')) $wait = get_option('minimum_waita');
			elseif ($ratio < get_option('minimum_ratiob') || $gigs < get_option('minimum_gigsb')) $wait = get_option('minimum_waitb');
			elseif ($ratio < get_option('minimum_ratioc') || $gigs < get_option('minimum_gigsc')) $wait = get_option('minimum_waitc');
			elseif ($ratio < get_option('minimum_ratiod') || $gigs < get_option('minimum_gigsd')) $wait = get_option('minimum_waitd');
			else $wait = 0;
		if ($elapsed < $wait)
			err("Wait Time (" . ($wait - $elapsed) . " hours) - Visit ".bloginfo('url')." for more info");
		}
	}
	$sockres = @fsockopen($ip, $port, $errno, $errstr, 5);
	if (!$sockres)
		$connectable = "no";
	else
		$connectable = "yes";
	@fclose($sockres);

}else{
    $upthis = max(0, $uploaded - $self["uploaded"]);
    $downthis = max(0, $downloaded - $self["downloaded"]);

    if (($upthis > 0 || $downthis > 0) && is_valid_id($useridm)){ // LIVE STATS!)
		$freeleech_yes = get_post_meta($torrent["post_id"], "freeleech", true) == 1;
		$freeleech_no = get_post_meta($torrent["post_id"], "freeleech", true) == 0;
		if ($freeleech_yes == 1){
			global $wpdb;
			$uploadedm = get_user_meta( $useridm, 'trader_upload', true );
			$update_uploadedm = $uploadedm + $upthis;
			update_user_meta( $useridm, 'trader_upload', $update_uploadedm, $uploadedm );
		}else{
			global $wpdb;
			$uploadedm = get_user_meta( $useridm, 'trader_upload', true );
			$update_uploadedm = $uploadedm + $upthis;
			update_user_meta( $useridm, 'trader_upload', $update_uploadedm, $uploadedm );
			
			$downloadedm = get_user_meta( $useridm, 'trader_download', true );
			$update_downloadedm = $downloadedm + $downthis;
			update_user_meta( $useridm, 'trader_upload', $update_downloadedm, $downloadedm );
		}
    }
}//END WAIT AND STATS UPDATE

////////////////// NOW WE DO THE TRACKER EVENT UPDATES ///////////////////

if ($event == "stopped") { // UPDATE "STOPPED" EVENT
        mysql_query("DELETE FROM " . TRADER_PEERS . " WHERE $selfwhere");
        if (mysql_affected_rows()){
            if ($self["seeder"] == "yes"){
				global $wpdb;
				if ($torrent_seeders > 0){ //need this so their is no negatives
					$torrent_seeders_subtract = $torrent_seeders - 1;
					update_post_meta($torrent_post_id, "seeders", $torrent_seeders_subtract);
				}
            }else{
				global $wpdb;
				if ($torrent_leechers > 0){ //need this so their is no negatives
					$torrent_leechers_subtract = $torrent_leechers - 1;
					update_post_meta($torrent_post_id, "leechers", $torrent_leechers_subtract);
				}
			}
        }
}

if ($event == "completed") { // UPDATE "COMPLETED" EVENT
	global $wpdb;
	$torrent_times_completed_add = $torrent_times_completed + 1;
	update_post_meta($torrent_post_id, "times_completed", $torrent_times_completed_add);

	if ($MEMBERSONLY)
		mysql_query("INSERT INTO " . TRADER_COMPLETED . " (userid, torrentid, date) VALUES ($useridm, $torrentid, '".current_time('mysql')."')") or err("Tracker error: Cannot insert into completed");
}//END COMPLETED

if (isset($self)){// NO EVENT? THEN WE MUST BE A NEW PEER OR ARE NOW SEEDING A COMPLETED TORRENT
    
    mysql_query("UPDATE " . TRADER_PEERS . " SET ip = " . sqlesc($ip) . ", passkey = " . sqlesc($passkey) . ", port = $port, uploaded = $uploaded, downloaded = $downloaded, to_go = $left, last_action = '".current_time('mysql')."', client = " . sqlesc($agent) . ", seeder = '$seeder' WHERE $selfwhere") or err("Tracker error: Cannot update peers");

    if (mysql_affected_rows() && $self["seeder"] != $seeder){
        if ($seeder == "yes"){
			global $wpdb;
			$torrent_seeders_add = $torrent_seeders + 1;
			update_post_meta($torrent_post_id, "seeders", $torrent_seeders_add);
			if ($torrent_leechers > 0){ //need this so their is no negatives
				$torrent_leechers_subtract = $torrent_leechers - 1;
				update_post_meta($torrent_post_id, "leechers", $torrent_leechers_subtract);
			}
        } else {
			global $wpdb;
			if ($torrent_seeders > 0){ //need this so their is no negatives
				$torrent_seeders_subtract = $torrent_seeders - 1;
				update_post_meta($torrent_post_id, "seeders", $torrent_seeders_subtract);
			}
			$torrent_leechers_add = $torrent_leechers + 1;
			update_post_meta($torrent_post_id, "leechers", $torrent_leechers_add);
        }
    }

} else {
	
    $ret = mysql_query("INSERT INTO " . TRADER_PEERS . " (connectable, torrent, peer_id, ip, passkey, port, uploaded, downloaded, to_go, started, last_action, seeder, userid, client) VALUES ('$connectable', $torrentid, " . sqlesc($peer_id) . ", " . sqlesc($ip) . ", " . sqlesc($passkey) . ", $port, $uploaded, $downloaded, $left, '".current_time('mysql')."', '".current_time('mysql')."', '$seeder', '$useridm', " . sqlesc($agent) . ")") or err("Tracker error: Cannot insert into peers");
    
    if ($ret){
        if ($seeder == "yes"){
			global $wpdb;
			$torrent_seeders_add = $torrent_seeders + 1;
			update_post_meta($torrent_post_id, "seeders", $torrent_seeders_add);
        }else{
			global $wpdb;
			$torrent_leechers_add = $torrent_leechers + 1;
			update_post_meta($torrent_post_id, "leechers", $torrent_leechers_add);
		}
    }
}

//////////////////    END TRACKER EVENT UPDATES ///////////////////

// SEEDED, LETS MAKE IT VISIBLE THEN
if ($seeder == "yes") {
    if ($torrent["banned"] != "yes") // DONT MAKE BANNED ONES VISIBLE
		global $wpdb;
		update_post_meta($torrent_post_id, 'visible', '1');
		update_post_meta($torrent_post_id, 'last_action', ''.current_time('mysql').'');
}

// NOW BENC THE DATA AND SEND TO CLIENT???
benc_resp_raw($resp);

mysql_close();
?>