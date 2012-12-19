<?php
/*
  * Holds the Torrent Upload shortcode function
  * @package WP-Trader
  * @subpackage Template
  */
include_once( WP_TRADER_ABSPATH . '/templates/torrent-upload.php' );
add_shortcode('torrentupload', 'torrent_upload');
function torrent_upload($torrent_up, $content = NULL) {
extract( shortcode_atts( array(
      'torrent_up' => 'torrent_up',
      ), $torrent_up ) );

			switch ($torrent_up) {
				case 'upload' :
					return torrent_upload_template();
				break;
				case 'test' :
					return 'test';
				break;
			}
}

add_shortcode('torrentdescription', 'torrent_description');
function torrent_description($torrent_descr, $content = NULL) {
extract( shortcode_atts( array(
      'torrent_descr' => 'torrent_descr',
	  'torrent_post_id' => 'torrent_post_id',
      ), $torrent_descr ) );

			switch ($torrent_descr) {
				case 'container' :
					return torrent_container($torrent_post_id);
				break;
				case 'description' :
					return torrent_upload_description($torrent_post_id);
				break;
				case 'files' :
					return torrent_files_list($torrent_post_id);
				break;
				case 'download-box' :
					return torrent_download_box($torrent_post_id);
				break;
				case 'test' :
					return 'test';
				break;
			}
}
?>