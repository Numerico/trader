<?php


/*


  * Holds the Scrape shortcode function


  * @package WP-Trader


  * @subpackage Template


  */


//include_once( WP_TRADER_ABSPATH . '/templates/announce.php' );


add_shortcode('torrent_scrape', 'scrape_template');


function scrape_template($scrape, $content = NULL) {


extract( shortcode_atts( array(


      'scrape' => 'scrape',


      ), $scrape ) );





			switch ($scrape) {


				case 'scrape_template' :


					return scrape();


				break;


				case 'test' :


					return 'test';


				break;


			}


	}


?>