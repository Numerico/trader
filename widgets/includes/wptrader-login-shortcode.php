<?php





/*





  * Holds the WP-Trader login shortcode function





  * @package WP-Trader







  */





include_once( WP_TRADER_ABSPATH . '/widgets/includes/shortcode-functions.php' );





add_shortcode('wptrader_login', 'wptrader_login_template');





function wptrader_login_template($wptraderlogin, $content = NULL) {





extract( shortcode_atts( array(





      'wptraderlogin' => 'wptraderlogin',





      ), $wptraderlogin ) );











			switch ($wptraderlogin) {





				case 'wptrader_login_template' :





					return wptrader_login_templates();





				break;





				case 'test' :





					return 'test';





				break;





			}





	}





?>