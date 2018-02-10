<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://raquelmsmith.com
 * @since      1.0.0
 *
 * @package    Strided_App
 * @subpackage Strided_App/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Strided_App
 * @subpackage Strided_App/admin
 * @author     raquelmsmith <hello@raquelmsmith.com>
 */
class Strided_App_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/strided-app-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/strided-app-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the Horses custom post type.
	 *
	 * @since    1.0.0
	 */
	public function action_init_register_horse_post_type() {

		$labels = array(
			'name'                  => _x( 'Horses', 'Post type general name', 'strided-app' ),
			'singular_name'         => _x( 'Horse', 'Post type singular name', 'strided-app' ),
			'menu_name'             => _x( 'Horses', 'Admin Menu text', 'strided-app' ),
			'name_admin_bar'        => _x( 'Horse', 'Add New on Toolbar', 'strided-app' ),
			'add_new'               => __( 'Add New', 'strided-app' ),
			'add_new_item'          => __( 'Add New Horse', 'strided-app' ),
			'new_item'              => __( 'New Horse', 'strided-app' ),
			'edit_item'             => __( 'Edit Horse', 'strided-app' ),
			'view_item'             => __( 'View Horse', 'strided-app' ),
			'all_items'             => __( 'All Horses', 'strided-app' ),
			'search_items'          => __( 'Search Horses', 'strided-app' ),
			'parent_item_colon'     => __( 'Parent Horses:', 'strided-app' ),
			'not_found'             => __( 'No horses found.', 'strided-app' ),
			'not_found_in_trash'    => __( 'No horses found in Trash.', 'strided-app' ),
			'featured_image'        => _x( 'Horse Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'set_featured_image'    => _x( 'Set horse image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'remove_featured_image' => _x( 'Remove horse image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'use_featured_image'    => _x( 'Use as horse image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'archives'              => _x( 'Horse archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'strided-app' ),
			'insert_into_item'      => _x( 'Add to horse', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'strided-app' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this horse', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'strided-app' ),
			'filter_items_list'     => _x( 'Filter horses list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'strided-app' ),
			'items_list_navigation' => _x( 'Horses list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'strided-app' ),
			'items_list'            => _x( 'Horses list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'strided-app' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'horse' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-star-filled',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		);

		register_post_type( 'horse', $args );
	}

	function filter_enter_title_here_change_title_text( $title ){

		$screen = get_current_screen();

		if ( 'horse' == $screen->post_type ) {
			$title = 'Enter horse name';
		} else if ( 'arena' == $screen->post_type ) {
			$title = 'Enter arena name';
		} else if ( 'run' == $screen->post_type ) {
			$title = 'Enter run identifier';
		}

		return $title;
	}

	/**
	 * Register the Arenas custom post type.
	 *
	 * @since    1.0.0
	 */
	public function action_init_register_arena_post_type() {

		$labels = array(
			'name'                  => _x( 'Arenas', 'Post type general name', 'strided-app' ),
			'singular_name'         => _x( 'Arena', 'Post type singular name', 'strided-app' ),
			'menu_name'             => _x( 'Arenas', 'Admin Menu text', 'strided-app' ),
			'name_admin_bar'        => _x( 'Arena', 'Add New on Toolbar', 'strided-app' ),
			'add_new'               => __( 'Add New', 'strided-app' ),
			'add_new_item'          => __( 'Add New Arena', 'strided-app' ),
			'new_item'              => __( 'New Arena', 'strided-app' ),
			'edit_item'             => __( 'Edit Arena', 'strided-app' ),
			'view_item'             => __( 'View Arena', 'strided-app' ),
			'all_items'             => __( 'All Arenas', 'strided-app' ),
			'search_items'          => __( 'Search Arenas', 'strided-app' ),
			'parent_item_colon'     => __( 'Parent Arenas:', 'strided-app' ),
			'not_found'             => __( 'No arenas found.', 'strided-app' ),
			'not_found_in_trash'    => __( 'No arenas found in Trash.', 'strided-app' ),
			'featured_image'        => _x( 'Arena Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'set_featured_image'    => _x( 'Set arena image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'remove_featured_image' => _x( 'Remove arena image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'use_featured_image'    => _x( 'Use as arena image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'archives'              => _x( 'Arena archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'strided-app' ),
			'insert_into_item'      => _x( 'Add to arena', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'strided-app' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this arena', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'strided-app' ),
			'filter_items_list'     => _x( 'Filter arenas list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'strided-app' ),
			'items_list_navigation' => _x( 'Arenas list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'strided-app' ),
			'items_list'            => _x( 'Arenas list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'strided-app' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'arena' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-megaphone',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		);

		register_post_type( 'arena', $args );
	}

	/**
	 * Register the Runs custom post type.
	 *
	 * @since    1.0.0
	 */
	public function action_init_register_run_post_type() {

		$labels = array(
			'name'                  => _x( 'Runs', 'Post type general name', 'strided-app' ),
			'singular_name'         => _x( 'Run', 'Post type singular name', 'strided-app' ),
			'menu_name'             => _x( 'Runs', 'Admin Menu text', 'strided-app' ),
			'name_admin_bar'        => _x( 'Run', 'Add New on Toolbar', 'strided-app' ),
			'add_new'               => __( 'Add New', 'strided-app' ),
			'add_new_item'          => __( 'Add New Run', 'strided-app' ),
			'new_item'              => __( 'New Run', 'strided-app' ),
			'edit_item'             => __( 'Edit Run', 'strided-app' ),
			'view_item'             => __( 'View Run', 'strided-app' ),
			'all_items'             => __( 'All Runs', 'strided-app' ),
			'search_items'          => __( 'Search Runs', 'strided-app' ),
			'parent_item_colon'     => __( 'Parent Runs:', 'strided-app' ),
			'not_found'             => __( 'No runs found.', 'strided-app' ),
			'not_found_in_trash'    => __( 'No runs found in Trash.', 'strided-app' ),
			'featured_image'        => _x( 'Run Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'set_featured_image'    => _x( 'Set run image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'remove_featured_image' => _x( 'Remove run image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'use_featured_image'    => _x( 'Use as run image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'strided-app' ),
			'archives'              => _x( 'Run archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'strided-app' ),
			'insert_into_item'      => _x( 'Add to run', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'strided-app' ),
			'uploaded_to_this_item' => _x( 'Uploaded to this run', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'strided-app' ),
			'filter_items_list'     => _x( 'Filter runs list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'strided-app' ),
			'items_list_navigation' => _x( 'Runs list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'strided-app' ),
			'items_list'            => _x( 'Runs list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'strided-app' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'run' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => null,
			'show_in_rest'       => true,
			'menu_icon'          => 'dashicons-awards',
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'revisions' ),
		);

		register_post_type( 'run', $args );
	}
}
