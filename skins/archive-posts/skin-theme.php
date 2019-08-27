<?php
/*
* This skin use OceanWP loop posts output
*/
namespace ElementorOWPPostsSkin\Skin_Theme_Archive;

use Elementor\Widget_Base;
use Elementor\Skin_Base as Elementor_Skin_Base;
use ElementorOWPPostsSkin\Skin_Theme\EOWPPS_Skin_Theme;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EOWPPS_Posts_Archive_Skin_Theme extends EOWPPS_Skin_Theme {

	public function get_id() {
		return 'theme_archive'; 
	}

	public function get_title() {
		return __( 'Theme', 'elementor-owp-posts-skin' );
	}

	protected function render_post() {
		get_template_part( 'partials/entry/layout' );
	}

	public function render() {
		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			$this->render_loop_header();

			$should_escape = apply_filters( 'elementor_pro/theme_builder/archive/escape_nothing_found_message', true );

			$message = $this->parent->get_settings_for_display( 'nothing_found_message' );
			if ( $should_escape ) {
				$message = esc_html( $message );
			}

			echo '<div class="elementor-posts-nothing-found">' . $message . '</div>';

			$this->render_loop_footer();

			return;
		}

		parent::render();
	}

}