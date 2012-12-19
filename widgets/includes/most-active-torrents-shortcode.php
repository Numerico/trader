<?php


/*


  * Holds the Most Active Torrents shortcode function


  * @package WP-Trader



  */


include_once( WP_TRADER_ABSPATH . '/widgets/includes/shortcode-functions.php' );


add_shortcode('most_active', 'most_active_template');


function most_active_template($mostactive, $content = NULL) {


extract( shortcode_atts( array(


      'mostactive' => 'mostactive',


      ), $mostactive ) );





			switch ($mostactive) {


				case 'most_active_template' :


					return most_active();


				break;


				case 'test' :


					return 'test';


				break;


			}


	}


?>