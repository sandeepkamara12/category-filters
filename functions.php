<?php
/**
 * Twenty Twenty-Two functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Two
 * @since Twenty Twenty-Two 1.0
 */


if ( ! function_exists( 'twentytwentytwo_support' ) ) :
	function twentytwentytwo_support() {
		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );
		// Enqueue editor styles.
		add_editor_style( 'style.css' );
	}
endif;

add_action( 'after_setup_theme', 'twentytwentytwo_support' );

if ( ! function_exists( 'twentytwentytwo_styles' ) ) :
	function twentytwentytwo_styles() {
		// Register theme stylesheet.
		$theme_version = wp_get_theme()->get( 'Version' );

		$version_string = is_string( $theme_version ) ? $theme_version : false;
		wp_register_style(
			'twentytwentytwo-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$version_string
		);
		wp_enqueue_style( 'twentytwentytwo-style' );
	}

endif;

add_action( 'wp_enqueue_scripts', 'twentytwentytwo_styles' );

locate_template('includes/post-type.php', true);
locate_template('includes/taxonomy-for-post-type.php', true);
locate_template('includes/column-heading-listing-in-admin.php', true);
locate_template('includes/column-value-listing-in-admin.php', true);
locate_template('includes/create-and-save-meta-fields.php', true);
locate_template('includes/show-data-on-load.php', true);
locate_template('includes/show-data-on-click-ajax.php', true);


add_action( 'wp_footer', 'my_header_scripts' );
function my_header_scripts(){
	?>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="<?php echo get_template_directory_uri(). '/assets/js/masonry.pkgd.min.js'; ?>"></script>
	<script src="<?php echo get_template_directory_uri(). '/assets/js/imagesloaded.pkgd.min.js'; ?>"></script>
	<script>
		jQuery(window).on("load",function(){
			$grid = jQuery('#grid').masonry({
				itemSelector: '.grid-item',				
			});
			$grid.imagesLoaded().progress( function() {
  				$grid.masonry('layout');
			});	
		});
	</script>
  <?php
}