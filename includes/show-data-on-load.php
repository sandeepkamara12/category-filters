<?php
add_shortcode('suburbPosts', 'suburbPosts');
function suburbPosts() {

  // Shownig Suburb's Categories
  $terms = get_terms(
    array(
      'taxonomy' => 'taxonomy',
      'hide_empty' => false,
    )
  );
  $suburbCategories = "<ul class=\"cat-listing-wrap\">";
  $suburbCategories .= "<li class=\"cat-listing-item activeCat\" data-id=\"all\">All</li>";
  foreach ($terms as $term){
    $suburbCategories .= "<li class=\"cat-listing-item\" data-id=\"$term->slug\">" . $term->name . "</li>";
  }
  $suburbCategories .= "</ul>";
  
  // Shownig Suburb's Posts
  $category = 'all';
  if($category != 'all') {
    $args = array(
      'post_type'			  =>	'suburbs',
      'posts_per_page'	=>  -1,
      'post_status'		  =>  'publish',
      'orderby'			    =>  'post_date',
      'order'         	=>  'DESC',
      'tax_query'       =>  array(
        array(
            'taxonomy' => 'taxonomy',
            'field'    => 'slug',
            'terms'    => $category,
        ),
      ),
    );
  }
  else {
    $args = array(
      'post_type'			  =>	'suburbs',
      'posts_per_page'	=>  -1,
      'post_status'		  =>  'publish',
      'orderby'			    =>  'post_date',
      'order'         	=>  'DESC',      
    );
  }
	$query = new WP_Query($args);
	$tp = $query->max_num_pages;
	if($query->have_posts()):
		$suburbCategories .= "<ul id='grid' class='add-data'>";
      while($query->have_posts()): $query->the_post();
      $image[0] = get_post_thumbnail_id(get_the_ID());
        $suburbCategories .= "<li class='grid-item'><div><a href='".get_post_permalink(get_the_id())."'>" . '<img src="'.wp_get_attachment_image_src($image[0])[0].'" alt="" style="max-width: 100%" />' . "" .  get_the_title() . "</div></li>";
      endwhile;
    $suburbCategories .= "</ul>";
	endif;
  return $suburbCategories;
}