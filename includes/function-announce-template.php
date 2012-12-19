<?php
/*
  * Holds the Announce shortcode function
  * @package WP-Trader
  * @subpackage Template
  */
//include_once( WP_TRADER_ABSPATH . '/templates/announce.php' );
add_shortcode('torrent_announce', 'announce_template');
function announce_template($announce, $content = NULL) {
extract( shortcode_atts( array(
      'announce' => 'announce',
      ), $announce ) );

			switch ($announce) {
				case 'announce_template' :
					return announce();
				break;
				case 'test' :
					return 'test';
				break;
			}
	}
?>