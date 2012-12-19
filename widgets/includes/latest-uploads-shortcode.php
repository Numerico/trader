<?php


/*


  * Holds the Latest Uploaded Torrents shortcode function


  * @package WP-Trader



  */


include_once( WP_TRADER_ABSPATH . '/widgets/includes/shortcode-functions.php' );


add_shortcode('latest_uploaded_torrents', 'latest_uploads_template');


function latest_uploads_template($latestuploads, $content = NULL) {


extract( shortcode_atts( array(


      'latestuploads' => 'latestuploads',


      ), $latestuploads ) );





			switch ($latestuploads) {


				case 'latest_uploads_template' :


					return latest_uploaded_torrents();


				break;


				case 'test' :


					return 'test';


				break;


			}


	}


?>