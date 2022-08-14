<?php
add_action( 'manage_suburbs_posts_custom_column', 'kamra_suburbs_column', 10, 2);
function kamra_suburbs_column( $column, $post_id ) {
  if ( 'distance' === $column ) {
    $distance = get_post_meta( $post_id, 'suburb_field_distance', true );

    if ( ! $distance ) {
      _e( '00 K.M' );
    } else {
      echo $distance . 'K.M';
    }
  }
}
?>