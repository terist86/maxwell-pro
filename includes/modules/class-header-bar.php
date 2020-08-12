<?php
/**
 * Footer Widgets
 *
 * Registers footer widget areas and hooks into the Maxwell theme to display widgets
 *
 * @package Maxwell Pro
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Header Bar Class
 */
class Maxwell_Pro_Header_Bar {

	/**
	 * Footer Widgets Setup
	 *
	 * @return void
	 */
	static function setup() {

		// Return early if Maxwell Theme is not active.
		if ( ! current_theme_supports( 'maxwell-pro' ) ) {
			return;
		}

		// Display Header Bar.
		add_action( 'maxwell_header_bar', array( __CLASS__, 'display_header_bar' ) );

	}

	/**
	 * Displays top navigation and social menu on header bar
	 *
	 * @return void
	 */
	static function display_header_bar() {

		// Check if there are menus.
		if ( has_nav_menu( 'social' ) or has_nav_menu( 'secondary' ) ) {

			echo '<div id="header-bar" class="header-bar clearfix">';

			// Check if there is a social menu.
			if ( has_nav_menu( 'social' ) ) {

				echo '<div id="header-social-icons" class="social-icons-navigation clearfix">';

				// Display Social Icons Menu.
				wp_nav_menu( array(
					'theme_location' => 'social',
					'container' => false,
					'menu_class' => 'social-icons-menu',
					'echo' => true,
					'fallback_cb' => '',
					'link_before' => '<span class="screen-reader-text">',
					'link_after' => '</span>',
					'depth' => 1,
					)
				);

				echo '</div>';

			}

			// Check if there is a top navigation menu.
			if ( has_nav_menu( 'secondary' ) ) : ?>

				<button class="secondary-menu-toggle menu-toggle" aria-controls="secondary-menu" aria-expanded="false">
					<?php
					echo self::get_svg( 'menu' );
					echo self::get_svg( 'close' );
					?>
					<span class="menu-toggle-text screen-reader-text"><?php esc_html_e( 'Navigation', 'maxwell-pro' ); ?></span>
				</button>

				<div class="secondary-navigation">

					<nav class="top-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Secondary Menu', 'maxwell-pro' ); ?>">

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'secondary',
								'menu_id'        => 'secondary-menu',
								'container'      => false,
							)
						);
						?>

					</nav>

				</div><!-- .secondary-navigation -->

				<?php
			endif;

			echo '</div>';
		}
	}

	/**
	 * Get SVG icon.
	 *
	 * @return void
	 */
	static function get_svg( $icon ) {
		if ( function_exists( 'maxwell_get_svg' ) ) {
			return maxwell_get_svg( $icon );
		}
	}

	/**
	 * Register navigation menus
	 *
	 * @return void
	 */
	static function register_nav_menus() {

		// Return early if Maxwell Theme is not active.
		if ( ! current_theme_supports( 'maxwell-pro' ) ) {
			return;
		}

		register_nav_menus( array(
			'secondary' => esc_html__( 'Top Navigation', 'maxwell-pro' ),
			'social' => esc_html__( 'Social Icons', 'maxwell-pro' ),
		) );

	}
}

// Run Class.
add_action( 'init', array( 'Maxwell_Pro_Header_Bar', 'setup' ) );

// Register navigation menus in backend.
add_action( 'after_setup_theme', array( 'Maxwell_Pro_Header_Bar', 'register_nav_menus' ), 20 );
