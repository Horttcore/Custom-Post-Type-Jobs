<?php
/*
Plugin Name: Custom Post Type Jobs
Plugin URI: http://horttcore.de
Description: A custom post type for managing job offers
Version: 0.4
Author: Ralf Hortt
Author URI: http://horttcore.de
License: GPL2
*/




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
	 * @author Ralf Hortt
	 **/
	public function __construct()
	{

		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'init', array( $this, 'register_taxonomy' ) );
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

		load_plugin_textdomain( 'jobs', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/'  );

	} // end __construct



	/**
	 * Register Metaboxes
	 *
	 * @access public
	 * @author Ralf Hortt
	 **/
	public function add_meta_boxes()
	{

		add_meta_box( 'job-meta', __( 'Information', 'cpt-job' ), array( $this, 'job_meta' ), 'job', 'normal' );

	} // end add_meta_boxes



	/**
	 * Metabox
	 *
	 * @access public
	 * @param obj $post Post object
	 * @author Ralf Hortt
	 **/
	public function job_meta( $post )
	{

		$meta = get_post_meta( $post->ID, 'job-meta', TRUE );

		do_action( 'job-meta-table-before', $post, $meta );

		?>

		<table class="form-table">

			<?php do_action( 'job-meta-before', $post, $meta ); ?>

			<tr>
				<th><label for="job-begin"><?php _e( 'Begin:', 'cpt-job' ); ?></label></th>
				<td>
					<input size="50" type="text" value="<?php if ( isset($meta['begin']) && '' != $meta['begin'] ) echo esc_attr( $meta['begin'] ) ?>" name="job-begin" id="job-begin"><br>
					<small><?php _e( 'dd.mm.yyyy', 'cpt-job' ); ?></small>
				</td>
			</tr>

			<?php do_action( 'job-meta-after', $post, $meta ); ?>

		</table>

		<?php

		do_action( 'job-meta-table-after', $post, $meta );

		wp_nonce_field( 'save-job-meta', 'job-meta-nonce' );

	} // end job_meta



	/**
	 * Update messages
	 *
	 * @access public
	 * @param array $messages Messages
	 * @return array Messages
	 * @author Ralf Hortt
	 **/
	public function post_updated_messages( $messages ) {

		global $post, $post_ID;

		$messages['job'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('job updated. <a href="%s">View job</a>', 'jobs'), esc_url( get_permalink($post_ID) ) ),
			2 => __('Custom field updated.', 'jobs'),
			3 => __('Custom field deleted.', 'jobs'),
			4 => __('job updated.', 'jobs'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('job restored to revision from %s', 'jobs'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('job published. <a href="%s">View job</a>', 'jobs'), esc_url( get_permalink($post_ID) ) ),
			7 => __('job saved.', 'jobs'),
			8 => sprintf( __('job submitted. <a target="_blank" href="%s">Preview job</a>', 'jobs'), esc_url( add_query_arg( 'preview', 'TRUE', get_permalink($post_ID) ) ) ),
			9 => sprintf( __('job scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview job</a>', 'jobs'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
			10 => sprintf( __('job draft updated. <a target="_blank" href="%s">Preview job</a>', 'jobs'), esc_url( add_query_arg( 'preview', 'TRUE', get_permalink($post_ID) ) ) ),
		);

		return $messages;

	} // end post_updated_messages



	/**
	 *
	 * Register post type
	 *
	 * @access public
	 * @author Ralf Hortt
	 */
	public function register_post_type()
	{

		$labels = array(
			'name' => _x('Jobs', 'post type general name', 'jobs'),
			'singular_name' => _x('Job', 'post type singular name', 'jobs'),
			'add_new' => _x('Add New', 'job', 'jobs'),
			'add_new_item' => __('Add New job', 'jobs'),
			'edit_item' => __('Edit job', 'jobs'),
			'new_item' => __('New job', 'jobs'),
			'view_item' => __('View job', 'jobs'),
			'search_items' => __('Search jobs', 'jobs'),
			'not_found' =>  __('No jobs found', 'jobs'),
			'not_found_in_trash' => __('No jobs found in Trash', 'jobs'),
			'parent_item_colon' => '',
			'menu_name' => __('jobs', 'jobs')
		);

		$args = array(
			'labels' => $labels,
			'public' => TRUE,
			'publicly_queryable' => TRUE,
			'show_ui' => TRUE,
			'show_in_menu' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'job', 'post type slug', 'jobs' ) ),
			'capability_type' => 'post',
			'has_archive' => TRUE,
			'hierarchical' => TRUE,
			'menu_position' => null,
			'show_in_nav_menus' => FALSE,
			'supports' => array( 'title', 'editor' )
		);

		register_post_type('job',$args);

	} // end register_post_type



	/**
	 *
	 * Register taxonomy
	 *
	 * @access public
	 * @author Ralf Hortt
	 */
	public function register_taxonomy()
	{

		$labels = array(
			'name' => _x( 'Categories', 'taxonomy general name', 'jobs' ),
			'singular_name' => _x( 'Category', 'taxonomy singular name', 'jobs' ),
			'search_items' =>  __( 'Search Categories', 'jobs' ),
			'popular_items' => __( 'Popular Categories', 'jobs' ),
			'all_items' => __( 'All Categories', 'jobs' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => __( 'Edit Category', 'jobs' ),
			'update_item' => __( 'Update Category', 'jobs' ),
			'add_new_item' => __( 'Add New Category', 'jobs' ),
			'new_item_name' => __( 'New Category Name', 'jobs' ),
			'menu_name' => __( 'Category', 'jobs' ),
		);

		register_taxonomy( 'job-category', 'job', array(
			'hierarchical' => TRUE,
			'labels' => $labels,
			'show_ui' => TRUE,
			'query_var' => TRUE,
			'rewrite' => array( 'slug' => _x( 'job-category', 'taxonomy slug', 'jobs' ) ),
			'show_admin_column' => TRUE,
		));

	} // end register_taxonomy



	/**
	 * Save post meta
	 *
	 * @access public
	 * @param int $post_id Post ID
	 * @author Ralf Hortt
	 **/
	public function save_post( $post_id )
	{

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return;

		if ( !isset( $_POST['job-meta-nonce'] ) || !wp_verify_nonce( $_POST['job-meta-nonce'], 'save-job-meta' ) )
			return;

		$meta = array(
			'begin' => sanitize_text_field( $_POST['job-begin'] )
		);

		update_post_meta( $post_id, 'job-meta', apply_filters( 'save-job-meta', $meta, $post_id ) );

	} // end save_post



}

new Custom_Post_Type_Job;
