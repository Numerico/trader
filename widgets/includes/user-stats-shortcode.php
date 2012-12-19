<?php





/*





  * Holds the User Stats shortcode function





  * @package WP-Trader







  */





include_once( WP_TRADER_ABSPATH . '/widgets/includes/shortcode-functions.php' );





add_shortcode('user_stats_torrents', 'user_stats_template');





function user_stats_template($userstats, $content = NULL) {





extract( shortcode_atts( array(





      'userstats' => 'userstats',





      ), $userstats ) );











			switch ($userstats) {





				case 'user_stats_template' :





					return user_stats();





				break;





				case 'test' :





					return 'test';





				break;





			}





	}





?>