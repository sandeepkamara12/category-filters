<?php
add_action('wp_footer', 'scripts');
function scripts() {
	?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			var ajaxUrl = "<?php echo admin_url('admin-ajax.php')?>";
			var id = 'all';
			jQuery(document).on("click",".cat-listing-wrap .cat-listing-item", function() {
				var obj = jQuery(this);
        var id = obj.data('id');
        jQuery(".cat-listing-wrap .cat-listing-item").removeClass("activeCat");
        jQuery(this).addClass("activeCat");
				// jQuery(".load_more").attr("disabled",true);
				jQuery.post(ajaxUrl, {
					action: "load_posts",
          id: id
				})
				.done(function(posts) {
					jQuery(".add-data").html(posts);
					// obj.remove();
				});
			});
		});
	</script>
	<?php
}

// Calling Data via Ajax
function load_posts() {
	$id = (isset($_POST['id'])) ? $_POST['id'] : 1;
  if($id != 'all') {
    $args = array(
      'post_type' 		  =>  'suburbs',
      'post_status'		  =>  'publish',
      'orderby'			    =>  'post_date',
      'order'         	=>  'DESC',
      'posts_per_page' 	=>  -1,
      'tax_query'       =>  array(
        array(
          'taxonomy' => 'taxonomy',
          'field'    => 'slug',
          'terms'    => $id,
        ),
      ),
    );
  }
  else {
    $args = array(
      'post_type' 		  =>  'suburbs',
      'post_status'		  =>  'publish',
      'orderby'			    =>  'post_date',
      'order'         	=>  'DESC',
      'posts_per_page' 	=>  -1,
    );
  }
	$loop = new WP_Query($args);
	$out = '';
	if($loop->have_posts()) {
		while($loop->have_posts()): $loop->the_post();
      $image[0] = get_post_thumbnail_id(get_the_ID());
      $out .= "<li class='grid-item'><a href='".get_post_permalink(get_the_id())."'>" . '<img src="'.wp_get_attachment_image_src($image[0])[0].'" alt="" style="max-width: 100%" />' . "" .  get_the_title() . "</li>";
		endwhile;
  }
  else {
    $out .= '<li class="grid-item no-record-found">No Record Found</li>';
	}
  $out .= '<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="' . get_template_directory_uri() . '/assets/js/masonry.pkgd.min.js"></script>
	<script src="' . get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js"></script>
  <script>
      $grid = jQuery("#grid").masonry({
				itemSelector: ".grid-item",
			});
			$grid.imagesLoaded().progress( function() {
        $grid.masonry();
			});
	</script>
  ';
  
	wp_reset_postdata();
	die($out);
}
add_action('wp_ajax_nopriv_load_posts','load_posts');
add_action('wp_ajax_load_posts','load_posts');
?>