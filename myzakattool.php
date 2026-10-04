<?php
/**
 * Plugin Name: My Zakat Tool
 * Plugin URI: https://myzakattool.com/
 * Description: Zakat calculator for every madhab (Hanafi, Shafi'i, Maliki, Hanbali, Ahl-e-Hadith, Shia) with live gold and silver rates, PDF reports, site pages and built-in SEO.
 * Version: 1.6.1
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Ali Ahmad
 * Author URI: https://www.linkedin.com/in/ali-ahmad-chaudhry-12777486/
 * License: GPL-2.0-or-later
 * Text Domain: myzakattool
 *
 * @package MyZakatTool
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MYZAKATTOOL_VERSION', '1.6.1' );
define( 'MYZAKATTOOL_FILE', __FILE__ );
define( 'MYZAKATTOOL_DIR', plugin_dir_path( __FILE__ ) );
define( 'MYZAKATTOOL_URL', plugin_dir_url( __FILE__ ) );

require_once MYZAKATTOOL_DIR . 'includes/class-settings.php';
require_once MYZAKATTOOL_DIR . 'includes/class-rates.php';
require_once MYZAKATTOOL_DIR . 'includes/class-ads.php';
require_once MYZAKATTOOL_DIR . 'includes/class-frontend.php';
require_once MYZAKATTOOL_DIR . 'includes/class-seo.php';
require_once MYZAKATTOOL_DIR . 'includes/class-installer.php';
require_once MYZAKATTOOL_DIR . 'includes/class-security.php';

MYZT_Settings::init();
MYZT_Rates::init();
MYZT_Ads::init();
MYZT_Frontend::init();
MYZT_SEO::init();
MYZT_Installer::init();
MYZT_Security::init();

register_activation_hook( __FILE__, array( 'MYZT_Installer', 'install' ) );
register_deactivation_hook( __FILE__, array( 'MYZT_Rates', 'unschedule' ) );
