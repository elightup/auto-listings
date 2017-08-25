<?php
/**
 * Single listing tabs
 *
 * This template can be overridden by copying it to yourtheme/listings/single-listing/tabs/tabs.php.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 * @see auto_listings_default_tabs()
 */
$tabs = apply_filters( 'auto_listings_single_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="auto-listings-tabs al-tabs-wrapper">
		
		<ul class="tabs al-tabs" role="tablist">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>">
					<a href="#tab-<?php echo esc_attr( $key ); ?>">
						<?php echo apply_filters( 'auto_listings_single_listing_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>

		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="auto-listings-Tabs-panel auto-listings-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content al-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ); ?>
			</div>
		<?php endforeach; ?>
		
	</div>

<?php endif; ?>
