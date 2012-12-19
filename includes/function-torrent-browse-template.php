<?php
/*
  * Holds the Torrent Browse Shortcode Function
  * @package WP-Trader
  * @subpackage Template
  */
include_once( WP_TRADER_ABSPATH . '/templates/torrents.php' );
add_shortcode('torrentbrowse', 'torrent_browse');
function torrent_browse($torrent, $content = NULL) {
extract( shortcode_atts( array(
      'torrent' => 'torrent',
      ), $torrent ) );

			switch ($torrent) {
				case 'torrent_browse' :
					return torrent_browse_template();
				break;
				case 'test' :
					return 'test';
				break;
			}
	}
?>