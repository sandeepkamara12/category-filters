<?php
/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'kamra_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'kamra_post_meta_boxes_setup' );

/* Meta box setup function. */
function kamra_post_meta_boxes_setup() {
  add_action( 'add_meta_boxes', 'kamra_add_post_meta_boxes' );
  add_action( 'save_post', 'kamra_save_post_class_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function kamra_add_post_meta_boxes() {
  add_meta_box(
    'suburb-fields',      
    esc_html__('Suburb Fields', 'example' ),    
    'kamra_suburb_fields_meta_box',
    'suburbs',
    'normal',   
    'high' 
  );
}

/* Display the post meta box. */
function kamra_suburb_fields_meta_box( $post ) { ?>
  <?php wp_nonce_field( basename( __FILE__ ), 'kamra_suburb_fields_nonce' ); ?>
  <p>
    <label for="suburb-fields-distance"><?php _e( "Distance (K.M)", 'example' ); ?></label>
    <input class="widefat" type="number" step="0.10" name="suburb-fields-distance" id="suburb-fields-distance" value="<?php echo esc_attr( get_post_meta( $post->ID, 'suburb_field_distance', true ) ); ?>" placeholder="10.20" size="30" />
  </p>
<?php }

/* Save the meta box’s post metadata. */
function kamra_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['kamra_suburb_fields_nonce'] ) || !wp_verify_nonce( $_POST['kamra_suburb_fields_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_distance_meta_value = ( isset( $_POST['suburb-fields-distance'] ) ? $_POST['suburb-fields-distance'] : '' );
  
  /* Get the meta key. */
  $meta_key_distance = 'suburb_field_distance';
  
  /* Get the meta value of the custom field key. */
  $meta_value_distance = get_post_meta( $post_id, $meta_key_distance, true );
  
  /* If a new meta value was added and there was no previous value, add it. */
  if ($new_distance_meta_value == $meta_value_distance)
    add_post_meta( $post_id, $meta_key_distance, $new_distance_meta_value, true);

  elseif ($new_distance_meta_value && $new_distance_meta_value != $meta_value_distance)
    update_post_meta( $post_id, $meta_key_distance, $new_distance_meta_value);

  elseif ($new_distance_meta_value && $meta_value_distance)
    delete_post_meta($post_id, $meta_key_distance, $meta_value_distance);
}