<?php


/*


  * Holds the Seed Wanted Torrents shortcode function


  * @package WP-Trader



  */


include_once( WP_TRADER_ABSPATH . '/widgets/includes/shortcode-functions.php' );


add_shortcode('seed_wanted_torrents', 'seed_wanted_template');


function seed_wanted_template($seedwanted, $content = NULL) {


extract( shortcode_atts( array(


      'seedwanted' => 'seedwanted',


      ), $seedwanted ) );





			switch ($seedwanted) {


				case 'seed_wanted_template' :


					return seed_wanted_torrents();


				break;


				case 'test' :


					return 'test';


				break;


			}


	}


?>