<?php
/**
 * Holds the Seed Wanted widget class
 *
 * @package WP-Trader
 * @subpackage Widget
 */

if ( !class_exists( 'Seed_Wanted' ) ) :

/**
 * Example Widget class.
 * This class handles everything that needs to be handled with the widget:
 * the settings, form, display, and update.  Nice!
 *
 * @since 0.1
 */
class Seed_Wanted extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function Seed_Wanted() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'Seed Wanted', 'description' => __('A widget which shows the seeds wanted.', 'Seed Wanted') );

		/* Create the widget. */
		$this->WP_Widget( 'seed-wanted', __('Seed Wanted', 'seed-wanted'), $widget_ops, $control_ops );
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

		/* Set up some default widget settings. */
		$defaults = array( 'title' => __('Seed Wanted', 'seed-wanted'), 'text' => __('[seed_wanted_torrents seedwanted="seed_wanted_template"] [/seed_wanted_torrents]') );
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'seed-wanted'); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			<textarea rows="10" cols="30" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" style="width:100%;"><?php echo $instance['text']; ?></textarea>
		</p>

	<?php
	}
}
function seed_wanted() {
	register_widget( 'Seed_Wanted' );
}
add_action( 'widgets_init', 'seed_wanted' );

endif; // Class exists
?>