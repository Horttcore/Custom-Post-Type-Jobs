<?php
/**
 *
 *  Custom Post Type Job
 *
 */
class Custom_Post_Type_Job
{



	/**
	 * Plugin constructor
	 *
	 * @access public
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.0.0
	 **/
	public function __construct()
	{

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'widgets_init', array( $this, 'widgets_init' ) );

	} // end __construct



	/**
	 * Load plugin translation
	 *
	 * @access public
	 * @return void
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.0.0
	 **/
	public function load_plugin_textdomain()
	{

		load_plugin_textdomain( 'custom-post-type-jobs', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );

	} // end load_plugin_textdomain



	/**
	 *
	 * Register post type
	 *
	 * @access public
	 * @author Ralf Hortt <me@horttcore.de>
 	 * @since v1.0.0
	 */
	public function register_post_type()
	{

		$args = array(
			'labels' => array(
				'name' => _x( 'Jobs', 'post type general name', 'custom-post-type-jobs' ),
				'singular_name' => _x( 'Job', 'post type singular name', 'custom-post-type-jobs' ),
				'add_new' => _x( 'Add New', 'job', 'custom-post-type-jobs' ),
				'add_new_item' => __( 'Add New job', 'custom-post-type-jobs' ),
				'edit_item' => __( 'Edit job', 'custom-post-type-jobs' ),
				'new_item' => __( 'New job', 'custom-post-type-jobs' ),
				'view_item' => __( 'View job', 'custom-post-type-jobs' ),
				'search_items' => __( 'Search jobs', 'custom-post-type-jobs' ),
				'not_found' =>  __( 'No jobs found', 'custom-post-type-jobs' ),
				'not_found_in_trash' => __( 'No jobs found in Trash', 'custom-post-type-jobs' ),
				'parent_item_colon' => '',
				'menu_name' => __( 'Jobs', 'custom-post-type-jobs' )
			),
			'public' => TRUE,
			'publicly_queryable' => TRUE,
			'show_ui' => TRUE,
			'show_in_menu' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'jobs', 'post type slug', 'custom-post-type-jobs' ) ),
			'capability_type' => 'post',
			'has_archive' => TRUE,
			'hierarchical' => FALSE,
			'menu_position' => null,
			'show_in_nav_menus' => FALSE,
			'menu_icon' => 'dashicons-businessman',
			'supports' => array( 'title', 'editor' )
		);

		register_post_type( 'job', $args);

	} // end register_post_type



	/**
	 *
	 * Register taxonomy
	 *
	 * @access public
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.0.0
	 */
	public function register_taxonomy()
	{

		register_taxonomy( 'job-category', 'job', array(
			'hierarchical' => TRUE,
			'labels' => array(
				'name' => _x( 'Categories', 'taxonomy general name', 'custom-post-type-jobs' ),
				'singular_name' => _x( 'Category', 'taxonomy singular name', 'custom-post-type-jobs' ),
				'search_items' =>  __( 'Search Categories', 'custom-post-type-jobs' ),
				'popular_items' => __( 'Popular Categories', 'custom-post-type-jobs' ),
				'all_items' => __( 'All Categories', 'custom-post-type-jobs' ),
				'parent_item' => null,
				'parent_item_colon' => null,
				'edit_item' => __( 'Edit Category', 'custom-post-type-jobs' ),
				'update_item' => __( 'Update Category', 'custom-post-type-jobs' ),
				'add_new_item' => __( 'Add New Category', 'custom-post-type-jobs' ),
				'new_item_name' => __( 'New Category Name', 'custom-post-type-jobs' ),
				'menu_name' => __( 'Category', 'custom-post-type-jobs' ),
			),
			'show_ui' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'job-category', 'taxonomy slug', 'custom-post-type-jobs' ) ),
			'show_admin_column' => TRUE,
		));

	} // end register_taxonomy



	/**
	 *
	 * Register taxonomy
	 *
	 * @access public
	 * @author Ralf Hortt <me@horttcore.de>
	 * @since v1.0.0
	 */
	public function widgets_init()
	{

		register_widget( 'Custom_Post_Type_Jobs_Widget' );

	} // end widgets_init


}

new Custom_Post_Type_Job;
