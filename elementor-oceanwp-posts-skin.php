<?php
/**
 * Plugin Name: Elementor Ocean WP Posts Skin
 * Description: Add a new skin to Elementor Pro Posts and Archives widgets which display OceanWP post template part
 * Plugin URI:  
 * Version:     1.0.0
 * Author:      Marie Comet
 * Author URI:  elementor-oceanwp-posts-skin
 * Text Domain: elementor-owp-posts-skin
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Main Elementor Ocean WP Posts Skin Class
 *
 * The init class that runs the Hello World plugin.
 * Intended To make sure that the plugin's minimum requirements are met.
 *
 * You should only modify the constants to match your plugin's needs.
 *
 * Any custom code should go inside ElementorOcean WP Posts SkinPlugin Class in the plugin.php file.
 * @since 1.2.0
 */
final class Elementor_OWPPostsSkin {

	/**
	 * ElementorOcean WP Posts SkinPlugin Version
	 *
	 * @since 1.2.0
	 * @var string The plugin version.
	 */
	const VERSION = '1.2.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.2.0
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

	/**
	 * Minimum PHP Version
	 *
	 * @since 1.2.0
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '7.0';

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Init ElementorOcean WP Posts SkinPlugin
		add_action( 'plugins_loaded', array( $this, 'init' ) );

		define( 'EOWPPS_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Initialize the plugin
	 *
	 * Validates that Elementor is already loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed include the plugin class.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) && ! is_plugin_active( 'elementor-pro/elementor-pro.php') ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
			return;
		}

		// Check if OceanWP installed and activated
		$theme = wp_get_theme();
		if ( 'oceanwp' != $theme->template ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_missing_theme' ) );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
			return;
		}

		load_muplugin_textdomain( 'elementor-owp-posts-skin', basename( dirname( __FILE__ ) ) . '/languages' );

		// Once we get here, We have passed all validation checks so we can safely include our plugin
		require_once( 'plugin.php' );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: ElementorOcean WP Posts SkinPlugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-owp-posts-skin' ),
			'<strong>' . esc_html__( 'Elementor Ocean WP Posts Skin', 'elementor-owp-posts-skin' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor Pro', 'elementor-owp-posts-skin' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	public function admin_notice_missing_theme() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: ElementorOcean WP Posts SkinPlugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementor-owp-posts-skin' ),
			'<strong>' . esc_html__( 'Elementor Ocean WP Posts Skin', 'elementor-owp-posts-skin' ) . '</strong>',
			'<strong>' . esc_html__( 'OceanWP theme', 'elementor-owp-posts-skin' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: ElementorOcean WP Posts SkinPlugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-owp-posts-skin' ),
			'<strong>' . esc_html__( 'Elementor Ocean WP Posts Skin', 'elementor-owp-posts-skin' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementor-owp-posts-skin' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {
		if ( isset( $_GET['activate'] ) ) {
			unset( $_GET['activate'] );
		}

		$message = sprintf(
			/* translators: 1: ElementorOcean WP Posts SkinPlugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-owp-posts-skin' ),
			'<strong>' . esc_html__( 'Elementor Ocean WP Posts Skin', 'elementor-owp-posts-skin' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementor-owp-posts-skin' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
	}
}

// Instantiate Elementor_OWPPostsSkin.
new Elementor_OWPPostsSkin();
