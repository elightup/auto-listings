<?php
/**
 * Custom Single Listing Template
 * 
 * This template renders the custom Elementor page for single listings
 * 
 * @package AutoListings
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $auto_listings_custom_template_id;

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		
		if ( class_exists( '\Elementor\Plugin' ) && $auto_listings_custom_template_id ) {
			echo \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $auto_listings_custom_template_id, true );
		} else {
			?>
			<div class="auto-listing-single-content">
				<div class="container">
					<h1><?php the_title(); ?></h1>
					<?php the_content(); ?>
				</div>
			</div>
			<?php
		}
	}
} else {
	?>
	<div class="auto-listing-single-content">
		<div class="container">
			<h1><?php esc_html_e( 'Listing not found', 'auto-listings' ); ?></h1>
		</div>
	</div>
	<?php
}

get_footer();

