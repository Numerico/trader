<?php
/*
  * Holds the WP-Trader Meta Box
  * @package WP-Trader
*/

/* Define the custom box */
add_action( 'add_meta_boxes', 'wptrader_add_custom_box' );
// backwards compatible (before WP 3.0)
// add_action( 'admin_init', 'wptrader_add_custom_box', 1 );

/* Do something with the data entered */
add_action( 'save_post', 'wptrader_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function wptrader_add_custom_box() {
    add_meta_box( 
        'wptrader_sectionid',
        __( 'WP-Trader Torrent Edit And Options', 'wptrader_textdomain' ),
        'wptrader_inner_custom_box',
        'post' 
    );
}

/* Prints the box content */
function wptrader_inner_custom_box( $post ) {
	$free_leech_yes = (get_post_meta($post->ID, 'freeleech', true) == 1) ? 'checked="checked"' : '';
	$free_leech_no = (get_post_meta($post->ID, 'freeleech', true) == 0) ? 'checked="checked"' : '';
	$external_yes = (get_post_meta($post->ID, 'external', true) == 1) ? 'checked="checked"' : '';
	$external_no = (get_post_meta($post->ID, 'external', true) == 0) ? 'checked="checked"' : '';
	$anonymous_yes = (get_post_meta($post->ID, 'anon', true) == 1) ? 'checked="checked"' : '';
	$anonymous_no = (get_post_meta($post->ID, 'anon', true) == 0) ? 'checked="checked"' : '';
  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'wptrader_noncename' );

  // The actual fields for data entry
  echo '<label for="wptrader_freeleech">';
       _e("Free Leech:", 'wptrader_textdomain' );
  echo '</label> ';
  echo '<input type="radio" name="wptrader_freeleech" id="wptrader_freeleech" value="1" ' . $free_leech_yes . ' /> Yes<input type="radio" name="wptrader_freeleech" id="wptrader_freeleech" value="0" ' . $free_leech_no . ' /> No<br /><br />';

  echo '<label for="wptrader_external">';
       _e("External:", 'wptrader_textdomain' );
  echo '</label> ';
  echo '<input type="radio" name="wptrader_external" id="wptrader_external" value="1" ' . $external_yes . ' /> Yes<input type="radio" name="wptrader_external" id="wptrader_external" value="0" ' . $external_no . ' /> No<br /><br />';

  echo '<label for="wptrader_anonymous">';
       _e("Anonymous Upload:", 'wptrader_textdomain' );
  echo '</label> ';
  echo '<input type="radio" name="wptrader_anonymous" id="wptrader_anonymous" value="1" ' . $anonymous_yes . ' /> Yes<input type="radio" name="wptrader_anonymous" id="wptrader_anonymous" value="0" ' . $anonymous_no . ' /> No<br /><br />';

   echo '<label for="wptrader_description">';
       _e("Description<br />", 'wptrader_textdomain' );
  echo '</label> ';
  echo '<textarea name="wptrader_description" id="wptrader_description" rows="5" cols="75">' . get_post_meta($post->ID, "descr", true) . '</textarea>';
}

/* When the post is saved, saves our custom data */
function wptrader_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['wptrader_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }
  else
  {
    if ( !current_user_can( 'edit_post', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data

	$freeleech = $_POST['wptrader_freeleech'];
	$external = $_POST['wptrader_external'];
	$anon = $_POST['wptrader_anonymous'];
	$descr = $_POST['wptrader_description'];
	update_post_meta($post_id, "freeleech", $freeleech);
	update_post_meta($post_id, "anon", $anon);
	update_post_meta($post_id, "external", $external);
	update_post_meta($post_id, "descr", $descr);
}
?>