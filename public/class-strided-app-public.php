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
		if( 'horse' == $settings['key'] || 'arena' == $settings['key'] || 'edit_run_arena' == $settings['key'] || 'edit_run_horse' == $settings['key'] ){
			$post_type = 'arena';
			if ( $settings['key'] == 'horse' || 'edit_run_horse' == $settings['key'] ) {
				$post_type = 'horse';
			}
			$args = array(
				'author'         => get_current_user_id(),
				'post_type'      => $post_type,
				'orderby'        => 'menu_order',
				'order'          => 'ASC',
				'posts_per_page' => -1,
				'post_status'    => 'publish'
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
	public function create_markup_horse_display( $content, $post, $post_meta ) {
		$markup = '';
		$horse_name = $post->post_title;
		$registered_name = $post_meta['_horse_registered_name'][0];
		$year_born = $post_meta['_horse_year_born'][0];
		$gender = $post_meta['_horse_gender'][0];
		$image_url = get_the_post_thumbnail_url( $post->ID );
		$edit_url = add_query_arg( array( 
				'post'            => $post->ID,
				'horse-name'      => $horse_name,
				'registered-name' => $registered_name,
				'year-born'       => $year_born,	
				'gender'          => $gender,
				'description'     => wp_strip_all_tags( $content ),
				'image-url'       => $image_url,
				'post-type'       => 'horse'
			), 
			home_url( 'view-all-horses/edit-horse/' ) );
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$markup .= '<div class="post-actions"><a href="' 
				. esc_url( $edit_url ) 
				. '"><button>Edit</button></a><a onclick="return confirm(\'Are you sure you wish to delete this?\')" href="' 
				. get_delete_post_link( $post->ID ) 
				. '"><button>Delete</button></a></div>';
				//TODO: redirect after deleting post
		}
		$markup .= '<div class="horse-information">';
		if ( null != $registered_name ) {
			$markup .= '<div class="horse-registered-name"><span class="label">Registered Name:</span> ' . esc_html( $registered_name ) . '</div>';
		}
		if ( null != $year_born ) {
			$markup .= '<div class="horse-year-born"><span class="label">Year Born:</span> ' . esc_html( $year_born ) . '</div>';
		}
		if ( null != $gender ) {
			$markup .= '<div class="horse-gender"><span class="label">Horse Gender:</span> ' . esc_html( $gender ) . '</div>';
		}
		$markup .= '<div class="horse-description">' . $content . '</div></div>';
		return $markup;
	}

	public function create_markup_arena_display( $content, $post, $post_meta ) {
		$markup = '';
		$arena_name = $post->post_title;
		$address = $post_meta['_arena_address'][0];
		$edit_url = add_query_arg( array( 
				'post'          => $post->ID,
				'arena-name'    => $arena_name,
				'arena-address' => $address,
				'description'   => wp_strip_all_tags( $content ),
				'post-type'     => 'arena'
			), 
			home_url( 'view-all-horses/edit-arena/' ) );
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$markup .= '<div class="post-actions"><a href="' 
				. esc_url( $edit_url ) 
				. '"><button>Edit</button></a><a onclick="return confirm(\'Are you sure you wish to delete this?\')" href="' 
				. get_delete_post_link( $post->ID ) 
				. '"><button>Delete</button></a></div>';
				//TODO: redirect after deleting post
		}
		$markup .= '<div class="arena-information">';
		if ( null != $address ) {
			$markup .= '<div class="arena-address"><span class="label">Address:</span> ' . esc_html( $address ) . '</div>';
		}
		$markup .= '<div class="arena-description">' . $content . '</div></div>';
		return $markup;
	}

	public function create_markup_run_display( $content, $post, $post_meta ) {
		$markup = '';
		$run_name = $post->post_title;
		$keys = array(
			'date',
			'arena',
			'horse',
			'time',
			'placing',
			'class',
			'winnings',
			'video'
		);
		$edit_args = array( 
			'post'        => $post->ID,
			'description' => wp_strip_all_tags( $content ),
			'post-type'   => 'run'
		);
		foreach ( $keys as $key ) {
			if ( isset( $post_meta[ '_run_' . $key ][0] ) && $post_meta[ '_run_' . $key ][0] ) {
				$$key = $post_meta[ '_run_' . $key ][0];
				$edit_args[ $key ] = $$key;
			}
		}
		$edit_url = add_query_arg(  $edit_args, home_url( 'view-all-runs/edit-run' ) );
		if ( current_user_can( 'edit_post', $post->ID ) ) {
			$markup .= '<div class="post-actions"><a href="' 
				. esc_url( $edit_url ) 
				. '"><button>Edit</button></a><a onclick="return confirm(\'Are you sure you wish to delete this?\')" href="' 
				. get_delete_post_link( $post->ID ) 
				. '"><button>Delete</button></a></div>';
				//TODO: redirect after deleting post
		}
		$markup .= '<div class="run-information">';
		if ( isset( $date ) ) {
			$markup .= '<div class="run-date"><span class="label">Date: </span> ' . esc_html( $date ) . '</div>';
		}
		if ( isset( $arena ) ) {
			$arena_url = get_permalink( $arena );
			$markup .= '<div class="run-arena"><span class="label">Arena:</span> <a href="' . esc_url( $arena_url ) . '">' . esc_html( get_the_title( $arena ) ) . '</a></div>';
		}
		if ( isset( $horse ) ) {
			$horse_url = get_permalink( $horse );
			$markup .= '<div class="run-horse"><span class="label">Horse:</span> <a href="' . esc_url( $horse_url ) . '">' . esc_html( get_the_title( $horse ) ) . '</a></div>';
		}
		if ( isset( $time ) ) {
			$markup .= '<div class="run-time"><span class="label">Time:</span> ' . esc_html( $time ) . ' seconds</div>';
		}
		if ( isset( $placing ) ) {
			$markup .= '<div class="run-placing"><span class="label">Placing:</span> ' . esc_html( $placing ) . '</div>';
		}
		if ( isset( $class ) ) {
			$markup .= '<div class="run-class"><span class="label">Class:</span> ' . esc_html( $class ) . '</div>';
		}
		if ( isset( $winnings ) ) {
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

	public function filter_the_content_strided_post_type( $content ) {
		global $post;
		$post_type = get_post_type( $post );
		$post_meta = get_post_meta( $post->ID );
		if ( 'horse' == $post_type ) {
			return $this->create_markup_horse_display( $content, $post, $post_meta );
		}
		if ( 'arena' == $post_type ) {
			return $this->create_markup_arena_display( $content, $post, $post_meta );
		}
		if ( 'run' == $post_type ) {
			return $this->create_markup_run_display( $content, $post, $post_meta );
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
				'metaKey'      => '_run_horse',
				'metaValue'    => $post->ID
			);
			$content.= '<div class="runs-with-horse"><h3>Runs with ' . $post->post_title . ':</h3>';
			$content .= Strided_App_Admin::strided_member_content_block_render( $attributes );
			$content .= '</div>';
		}
		if ( 'arena' == $post_type ) {
			$attributes = array(
				'radioControl' => 'run',
				'rangeControl' => 100,
				'metaKey'      => '_run_arena',
				'metaValue'    => $post->ID
			);
			$content.= '<div class="runs-at-arena"><h3>Runs at ' . $post->post_title . ':</h3>';
			$content .= Strided_App_Admin::strided_member_content_block_render( $attributes );
			$content .= '</div>';
		}
		return $content;
	}

	public function action_edit_horse_post_on_save( $form_data ) {
		$post_info = array();
		$post_meta = array();
		$form_id       = $form_data[ 'form_id' ];
		$form_fields   =  $form_data[ 'fields' ];
		foreach( $form_fields as $field ){
			$field_id    = $field[ 'id' ];
			$field_key   = $field[ 'key' ];
			$field_value = $field[ 'value' ];
			if ( 'edit_post_id' == $field_key ) {
				$post_info['ID'] = $field_value;
				$post_id_to_update = $field_value;
			}
			if ( 'edit_horse_name' == $field_key ) {
				$post_info['post_title'] = $field_value;
			}
			if ( 'edit_horse_information' == $field_key ) {
				$post_info['post_content'] = $field_value;
			}
			if ( 'edit_horse_registered_name' == $field_key ) {
				$post_meta['_horse_registered_name'] = $field_value;
			}
			if ( 'edit_year_born' == $field_key ) {
				$post_meta['_horse_year_born'] = $field_value;
			}
			if ( 'edit_horse_gender' == $field_key ) {
				$post_meta['_horse_gender'] = $field_value;
			}
			if ( 'edit_horse_image' == $field_key && '' != $field_value ) {
				$attachment_id = $this->strided_insert_attachment_from_url( reset( $field_value ), $post_id_to_update );
				$post_thumbnail = set_post_thumbnail( $post_id_to_update, $attachment_id );
			}
		}
		if ( current_user_can( 'edit_post', $post_id_to_update ) ) {
			wp_update_post( $post_info );
			foreach ( $post_meta as $key => $value ) {
				update_post_meta( $post_id_to_update, $key, $value );
			}
		}
	}

	public function action_edit_arena_post_on_save( $form_data ) {
		$post_info = array();
		$post_meta = array();
		$form_id       = $form_data[ 'form_id' ];
		$form_fields   =  $form_data[ 'fields' ];
		foreach( $form_fields as $field ){
			$field_id    = $field[ 'id' ];
			$field_key   = $field[ 'key' ];
			$field_value = $field[ 'value' ];
			if ( 'edit_post_id' == $field_key ) {
				$post_info['ID'] = $field_value;
				$post_id_to_update = $field_value;
			}
			if ( 'edit_arena_name' == $field_key ) {
				$post_info['post_title'] = $field_value;
			}
			if ( 'edit_arena_information' == $field_key ) {
				$post_info['post_content'] = $field_value;
			}
			if ( 'edit_arena_address' == $field_key ) {
				$post_meta['_arena_address'] = $field_value;
			}
			if ( 'edit_arena_image' == $field_key && '' != $field_value ) {
				$attachment_id = $this->strided_insert_attachment_from_url( reset( $field_value ), $post_id_to_update );
				$post_thumbnail = set_post_thumbnail( $post_id_to_update, $attachment_id );
			}
		}
		if ( current_user_can( 'edit_post', $post_id_to_update ) ) {
			wp_update_post( $post_info );
			foreach ( $post_meta as $key => $value ) {
				update_post_meta( $post_id_to_update, $key, $value );
			}
		}
	}

	public function action_edit_run_post_on_save( $form_data ) {
		$post_info = array();
		$post_meta = array();
		$form_id       = $form_data[ 'form_id' ];
		$form_fields   =  $form_data[ 'fields' ];
		foreach( $form_fields as $field ){
			$field_id    = $field[ 'id' ];
			$field_key   = $field[ 'key' ];
			$field_value = $field[ 'value' ];
			if ( 'edit_post_id' == $field_key ) {
				$post_info['ID'] = $field_value;
				$post_id_to_update = $field_value;
			}
			if ( 'edit_run_description' == $field_key ) {
				$post_info['post_content'] = $field_value;
			}
			if ( 'edit_run_date' == $field_key ) {
				$post_meta['_run_date'] = $field_value;
			}
			if ( 'edit_run_horse' == $field_key ) {
				$post_meta['_run_horse'] = $field_value;
			}
			if ( 'edit_run_arena' == $field_key ) {
				$post_meta['_run_arena'] = $field_value;
			}
			if ( 'edit_run_placing' == $field_key ) {
				$post_meta['_run_placing'] = $field_value;
			}
			if ( 'edit_run_class' == $field_key ) {
				$post_meta['_run_class'] = $field_value;
			}
			if ( 'edit_run_time' == $field_key ) {
				$post_meta['_run_time'] = $field_value;
			}
			if ( 'edit_run_winnings' == $field_key ) {
				$post_meta['_run_winnings'] = $field_value;
			}
			if ( 'edit_run_video' == $field_key ) {
				$post_meta['_run_video'] = $field_value;
			}
		}
		if ( current_user_can( 'edit_post', $post_id_to_update ) ) {
			wp_update_post( $post_info );
			foreach ( $post_meta as $key => $value ) {
				update_post_meta( $post_id_to_update, $key, $value );
			}
		}
	}

	/**
	 * Insert an attachment from a URL address.
	 *
	 * @param  String $url 
	 * @param  Int    $post_id 
	 * @param  Array  $meta_data 
	 * @return Int    Attachment ID
	 */
	function strided_insert_attachment_from_url( $url, $post_id = null ) {

		if( !class_exists( 'WP_Http' ) )
			include_once( ABSPATH . WPINC . '/class-http.php' );

		$http = new WP_Http();
		$response = $http->request( $url );
		if( $response['response']['code'] != 200 ) {
			return false;
		}

		$upload = wp_upload_bits( basename($url), null, $response['body'] );
		if( !empty( $upload['error'] ) ) {
			return false;
		}

		$file_path = $upload['file'];
		$file_name = basename( $file_path );
		$file_type = wp_check_filetype( $file_name, null );
		$attachment_title = sanitize_file_name( pathinfo( $file_name, PATHINFO_FILENAME ) );
		$wp_upload_dir = wp_upload_dir();

		$post_info = array(
			'guid'              => $wp_upload_dir['url'] . '/' . $file_name, 
			'post_mime_type'    => $file_type['type'],
			'post_title'        => $attachment_title,
			'post_content'      => '',
			'post_status'       => 'inherit',
		);

		// Create the attachment
		$attach_id = wp_insert_attachment( $post_info, $file_path, $post_id );

		// Include image.php
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Define attachment metadata
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );

		// Assign metadata to attachment
		wp_update_attachment_metadata( $attach_id,  $attach_data );

		return $attach_id;
	}
}
