<?php
/*
* This skin use OceanWP loop posts output
*/
namespace ElementorOWPPostsSkin\Skin_Theme;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class EOWPPS_Skin_Theme extends Elementor_Skin_Base {

	protected function _register_controls_actions() {
		add_action( 'elementor/element/posts/section_layout/before_section_end', [ $this, 'register_controls' ] );
	}

	public function get_id() {
		return 'theme'; 
	}

	public function get_title() {
		return __( 'Theme', 'elementor-owp-posts-skin' );
	}

	public function register_controls( Widget_Base $widget ) {
		$this->parent = $widget;

		$this->skin_theme_register_post_count_control();
	}

	public function skin_theme_register_post_count_control() {

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'elementor-owp-posts-skin' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 6,
			]
		);

	}

	protected function render_post() {
		get_template_part( 'partials/entry/layout' );
	}

	public function render() {
		$this->parent->query_posts();

		/** @var \WP_Query $query */
		$query = $this->parent->get_query();

		if ( ! $query->found_posts ) {
			return;
		}
		?>
		<div class="<?php oceanwp_blog_wrap_classes(); ?>">
			<?php

			// It's the global `wp_query` it self. and the loop was started from the theme.
			if ( $query->in_the_loop ) {
				$this->current_permalink = get_permalink();
				$this->render_post();
			} else {
				while ( $query->have_posts() ) {
					$query->the_post();

					$this->current_permalink = get_permalink();
					$this->render_post();
				}
			}

			wp_reset_postdata();

			oceanwp_blog_pagination();
			?>
		</div>
		<?php
	}
}