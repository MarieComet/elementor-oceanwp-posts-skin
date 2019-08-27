<?php
namespace ElementorOWPPostsSkin;

/**
 * Class ElementorOWPPostsSkinPlugin
 *
 * Main ElementorOWPPostsSkinPlugin class
 * @since 1.2.0
 */
class ElementorOWPPostsSkinPlugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var ElementorOWPPostsSkinPlugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return ElementorOWPPostsSkinPlugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets skins
	 *
	 * Load widgets skins
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_skins_files() {
		require_once( __DIR__ . '/skins/posts/skin-theme.php' );
		require_once( __DIR__ . '/skins/archive-posts/skin-theme.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_skins() {

		$this->include_skins_files();
		// Register skin
		add_action( 'elementor/widget/posts/skins_init', function( $widget ) {

			$widget->add_skin( new Skin_Theme\EOWPPS_Skin_Theme($widget) );
		} );

		add_action( 'elementor/widget/archive-posts/skins_init', function( $widget ) {

			$widget->add_skin( new Skin_Theme_Archive\EOWPPS_Posts_Archive_Skin_Theme($widget) );

		} );
	}

	/**
	 *  ElementorOWPPostsSkinPlugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {
		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_skins' ] );
	}
}

// Instantiate ElementorOWPPostsSkinPlugin Class
ElementorOWPPostsSkinPlugin::instance();
