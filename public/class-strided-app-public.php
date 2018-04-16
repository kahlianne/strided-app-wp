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

	public function filter_add_horse_field_options( $options, $settings ){
		if( 'horse' == $settings['key'] || 'arena' == $settings['key'] ){
			$args = array(
				'author' => get_current_user_id(),
				'post_type' => $settings['key'],
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'posts_per_page' => -1,
				'post_status' => 'publish'
			);
			$the_query = new WP_Query( $args ); 
			if ( $the_query->have_posts() ){
				global $post;
				while ( $the_query->have_posts() ){
					$the_query->the_post();
					$options[] = array('label' => get_the_title(), 'value' => get_the_ID() );
				}
				wp_reset_postdata(); 
			}
		}
		return $options;
	}

	public function filter_the_content_strided_post_type( $content ) {
		global $post;
		$post_type = get_post_type( $post );
		if ( 'horse' == $post_type ) {
			return $content . 'this is a horse';
		}
	}

}
