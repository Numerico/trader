<?php

/**

 * Holds the Seed Wanted widget class

 *

 * @package WP-Trader

 * @subpackage Widget

 */



if ( !class_exists( 'WPTrader_Login' ) ) :



/**

 * Example Widget class.

 * This class handles everything that needs to be handled with the widget:

 * the settings, form, display, and update.  Nice!

 *

 * @since 0.1

 */

class WPTrader_Login extends WP_Widget {



	/**

	 * Widget setup.

	 */

	function WPTrader_Login() {

		/* Widget settings. */

		$widget_ops = array( 'classname' => 'WP-Trader Login', 'description' => __('A widget which allows you to log into your site.', 'Login') );



		/* Create the widget. */

		$this->WP_Widget( 'wptrader-login', __('WP-Trader Login', 'wptrader-login'), $widget_ops, $control_ops );

	}



	/**

	 * How to display the widget on the screen.

	 */

	function widget( $args, $instance ) {

		extract( $args );



		/* Our variables from the widget settings. */

		$title = apply_filters('widget_title', $instance['title'] );

		$text = apply_filters( 'widget_text', $instance['text'] );

		/* Before widget (defined by themes). */

		echo $before_widget;



		/* Display the widget title if one was input (before and after defined by themes). */

		if ( $title )

			echo $before_title . $title . $after_title;

				global $current_user;

				get_currentuserinfo();

				?>

				<div class="textwidget"><?php echo $text; ?></div>

				<?php

		/* After widget (defined by themes). */

		echo $after_widget;

	}



	/**

	 * Update the widget settings.

	 */

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;



		/* Strip tags for title and name to remove HTML (important for text inputs). */

		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['text'] = strip_tags( $new_instance['text'] );

		return $instance;

	}



	/**

	 * Displays the widget settings controls on the widget panel.

	 * Make use of the get_field_id() and get_field_name() function

	 * when creating your form elements. This handles the confusing stuff.

	 */

	function form( $instance ) {

		global $user_identity;

		/* Set up some default widget settings. */

		$defaults = array( 'title' => __('Login', 'wptrader-login'), 'text' => __('[wptrader_login wptraderlogin="wptrader_login_template"] [/wptrader_login]') );

		$instance = wp_parse_args( (array) $instance, $defaults ); 

		?>



		<!-- Widget Title: Text Input -->

		<p>

			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'wptrader-login'); ?></label>

			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />

			<textarea rows="10" cols="30" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="width:100%;"><?php echo $instance['text']; ?></textarea>

		</p>



	<?php

	}

}

function wptrader_login() {

	register_widget( 'WPTrader_Login' );

}

add_action( 'widgets_init', 'wptrader_login' );



endif; // Class exists

?>