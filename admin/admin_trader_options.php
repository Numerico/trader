<?php
$action = isset($_GET['action']);
if (!$action){
include_once( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_options_main.php' );
}
if ($action=="torrent_settings"){
include_once( WP_TRADER_ABSPATH . '/admin/templates/admin_trader_options_torrent.php' );
}
 ?>