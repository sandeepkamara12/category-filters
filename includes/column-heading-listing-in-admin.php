<?php
add_filter( 'manage_suburbs_posts_columns', 'kamra_suburbs_columns' );
function kamra_suburbs_columns( $columns ) { 
  $columns = array(
    'cb' => $columns['cb'],
    'title' => __( 'Suburbs' ),
    'distance' => __( 'Distance (K.M)', 'kamra' ),
  ); 
  return $columns;
}
?>