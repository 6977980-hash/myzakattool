<?php
/**
 * Plugin Name: My Zakat Tool
 * Description: Zakat calculator for WordPress. Use the [zakat_calculator] shortcode on any page.
 * Version: 0.1.0
 * Author: Ali Ahmad
 * License: GPL-2.0-or-later
 * Text Domain: myzakattool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MYZAKATTOOL_VERSION', '0.1.0' );

/**
 * Renders the [zakat_calculator] shortcode.
 * Placeholder until the calculator form is built.
 */
function myzakattool_render_calculator() {
	return '<div class="myzakattool-calculator"><p>' . esc_html__( 'Zakat calculator coming soon.', 'myzakattool' ) . '</p></div>';
}
add_shortcode( 'zakat_calculator', 'myzakattool_render_calculator' );
