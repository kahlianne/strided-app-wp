<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Strided_App
 * @subpackage Strided_App/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Strided_App
 * @subpackage Strided_App/public
 * @author     raquelmsmith <hello@raquelmsmith.com>
 */
class Strided_App_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/strided-app-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/strided-app-public.js', array( 'jquery' ), $this->version, false );

	}

	public function action_init_register_shortcodes() {
		add_shortcode( 'strided', array( $this, 'strided_shortcode' ) );
	}

	public function strided_shortcode( $atts ) {
		$a = shortcode_atts( array(
			'type' => 'horse',
			'number' => 6
			), $atts 
		);
		$query_args = array(
			'author' => get_current_user_id(),
			'post_type' => $a[ 'type' ],
			'posts_per_page' => $a[ 'number' ],
			'orderby' => 'name',
			'order' => 'ASC',
		);
		$query = new WP_Query( $query_args );

		echo '<ul class="horse-grid">';
		while( $query->have_posts() ) {
			$query->the_post();
			echo '<li><a href="' . get_permalink( $post ) . '"><div class="item-image">';
			the_post_thumbnail( 'post-thumbnail' );
			echo '</div><div class="item-name">';
			the_title();
			echo '</div></a></li>';
		}
		echo '</ul>';
		// End the query
		wp_reset_postdata();
			
	}

}
