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
		$post_meta = get_post_meta( $post->ID );
		if ( 'horse' == $post_type ) {	
			$markup = '<div class="horse-information">';
			if ( isset( $post_meta['_horse_registered_name'][0] ) ) {
				$registered_name = $post_meta['_horse_registered_name'][0];
				$markup .= '<div class="horse-registered-name"><span class="label">Registered Name:</span> ' . esc_html( $registered_name ) . '</div>';
			}
			if ( isset( $post_meta['_horse_year_born'][0] ) ) {
				$year_born = $post_meta['_horse_year_born'][0];
				$markup .= '<div class="horse-year-born"><span class="label">Year Born:</span> ' . esc_html( $year_born ) . '</div>';
			}
			if ( isset( $post_meta['_horse_gender'][0] ) ) {
				$gender = $post_meta['_horse_gender'][0];
				$markup .= '<div class="horse-gender"><span class="label">Horse Gender:</span> ' . esc_html( $gender ) . '</div>';
			}
			$markup .= '<div class="horse-description">' . $content . '</div></div>';
			return $markup;
		}
		if ( 'arena' == $post_type ) {
			$markup = '<div class="arena-information">';
			if ( isset( $post_meta['_arena_address'][0] ) ) {
				$address = $post_meta['_arena_address'][0];
				$markup .= '<div class="arena-address"><span class="label">Address:</span> ' . esc_html( $address ) . '</div>';
			}
			$markup .= '<div class="arena-description">' . $content . '</div></div>';
			return $markup;
		}
		if ( 'run' == $post_type ) {
			$markup = '<div class="horse-information">';
			if ( isset( $post_meta['_run_arena'][0] ) ) {
				$arena = get_the_title( $post_meta['_run_arena'][0] );
				$arena_url = get_permalink( $post_meta['_run_arena'][0] );
				$markup .= '<div class="run-arena"><span class="label">Arena:</span> <a href="' . esc_url( $arena_url ) . '">' . esc_html( $arena ) . '</a></div>';
			}
			if ( isset( $post_meta['_run_horse'][0] ) ) {
				$horse = get_the_title( $post_meta['_run_horse'][0] );
				$horse_url = get_permalink( $post_meta['_run_horse'][0] );
				$markup .= '<div class="run-horse"><span class="label">Horse:</span> <a href="' . esc_url( $horse_url ) . '">' . esc_html( $horse ) . '</a></div>';
			}
			if ( isset( $post_meta['_run_time'][0] ) ) {
				$time = $post_meta['_run_time'][0];
				$markup .= '<div class="run-time"><span class="label">Time:</span> ' . esc_html( $time ) . ' seconds</div>';
			}
			if ( isset( $post_meta['_run_placing'][0] ) ) {
				$placing = $post_meta['_run_placing'][0];
				$markup .= '<div class="run-placing"><span class="label">Placing:</span> ' . esc_html( $placing ) . '</div>';
			}
			if ( isset( $post_meta['_run_class'][0] ) ) {
				$class = $post_meta['_run_class'][0];
				$markup .= '<div class="run-class"><span class="label">Class:</span> ' . esc_html( $class ) . '</div>';
			}
			if ( isset( $post_meta['_run_winnings'][0] ) ) {
				$winnings = $post_meta['_run_winnings'][0];
				$markup .= '<div class="run-winnings"><span class="label">Winnings:</span> $' . esc_html( $winnings ) . '</div>';
			}
			$markup .= '<div class="run-description">' . $content . '</div>';
			if ( isset( $post_meta[ '_run_video' ][0] ) && null != $post_meta[ '_run_video' ][0] ) {
				$video_number = preg_match('/\d{9}/', $post_meta[ '_run_video' ][0], $matches);
				if ( isset( $matches[0] ) ) {
					$markup .= '<div class="run-video"><iframe src="https://player.vimeo.com/video/' . $matches[0] . '" width="254" height="auto" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>';
				}
			}
			$markup .= '</div>';
			return $markup;
		}
		return $content;
	}

	public function filter_run_titles( $title, $id = null ) {
		$post_type = get_post_type( $id );
		if ( 'run' == $post_type ) {
			$post_meta = get_post_meta( $id );
			if ( isset( $post_meta['_run_horse'][0] ) && '' != $post_meta['_run_horse'][0] && null != $post_meta['_run_horse'][0] ) {
				$horse = get_the_title( $post_meta['_run_horse'][0] );
			}
			if ( isset( $post_meta['_run_time'][0] ) && '' != $post_meta['_run_time'][0] && null != $post_meta['_run_time'][0] ) {
				$time = $post_meta['_run_time'][0];
			}
			if ( isset( $horse ) && isset( $time ) ) {
				return $horse . ' - ' . $time;
			}
		}
		return $title;
	}

	public function filter_the_content_show_runs( $content ) {
		global $post;
		$post_type = get_post_type( $post );
		$post_meta = get_post_meta( $post->ID );
		if ( 'horse' == $post_type ) {
			$attributes = array(
				'radioControl' => 'run',
				'rangeControl' => 100,
				'metaKey' => '_run_horse',
				'metaValue' => $post->ID
			);
			$content.= '<div class="runs-with-horse"><h3>Runs with ' . $post->post_title . ':</h3>';
			$content .= Strided_App_Admin::strided_member_content_block_render( $attributes );
			$content .= '</div>';
		}
		if ( 'arena' == $post_type ) {
			$attributes = array(
				'radioControl' => 'run',
				'rangeControl' => 100,
				'metaKey' => '_run_arena',
				'metaValue' => $post->ID
			);
			$content.= '<div class="runs-at-arena"><h3>Runs at ' . $post->post_title . ':</h3>';
			$content .= Strided_App_Admin::strided_member_content_block_render( $attributes );
			$content .= '</div>';
		}
		return $content;
	}

}
