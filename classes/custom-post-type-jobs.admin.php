<?php
/**
 *
 *  Custom Post Type Job
 *
 */
final class Custom_Post_Type_Job_Admin
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
		add_filter( 'post_updated_messages', array( $this, 'post_updated_messages' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );

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

		do_action( 'custom-post-type-jobs-meta-box-table-before', $post, $meta );

		?>

		<table class="form-table">

			<?php do_action( 'custom-post-type-jobs-meta-box-table-first-row-before', $post, $meta ); ?>

			<tr>
				<th><label for="job-begin"><?php _e( 'Begin:', 'cpt-job' ); ?></label></th>
				<td>
					<input size="50" type="text" value="<?php if ( isset( $meta['begin'] ) && '' != $meta['begin'] ) echo esc_attr( $meta['begin'] ) ?>" name="job-begin" id="job-begin"><br>
					<small><?php _e( 'dd.mm.yyyy', 'cpt-job' ); ?></small>
				</td>
			</tr>

			<?php do_action( 'custom-post-type-jobs-meta-box-table-last-row-after', $post, $meta ); ?>

		</table>

		<?php

		do_action( 'custom-post-type-jobs-meta-box-table-after', $post, $meta );

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

		$post             = get_post();
		$post_type        = get_post_type( $post );
		$post_type_object = get_post_type_object( $post_type );

		$messages['job'] = array(
			0  => '', // Unused. Messages start at index 1.
			1  => __( 'Job updated.', 'custom-post-type-jobs' ),
			2  => __( 'Custom field updated.', 'custom-post-type-jobs' ),
			3  => __( 'Custom field deleted.', 'custom-post-type-jobs' ),
			4  => __( 'Job updated.', 'custom-post-type-jobs' ),
			/* translators: %s: date and time of the revision */
			5  => isset( $_GET['revision'] ) ? sprintf( __( 'Job restored to revision from %s', 'custom-post-type-jobs' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6  => __( 'Job published.', 'custom-post-type-jobs' ),
			7  => __( 'Job saved.', 'custom-post-type-jobs' ),
			8  => __( 'Job submitted.', 'custom-post-type-jobs' ),
			9  => sprintf( __( 'Job scheduled for: <strong>%1$s</strong>.', 'custom-post-type-jobs' ),
				// translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i', 'custom-post-type-jobs' ), strtotime( $post->post_date ) )
			),
			10 => __( 'Job draft updated.', 'custom-post-type-jobs' )
		);

		if ( $post_type_object->publicly_queryable ) {
			$permalink = get_permalink( $post->ID );

			$view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View job', 'custom-post-type-jobs' ) );
			$messages[ $post_type ][1] .= $view_link;
			$messages[ $post_type ][6] .= $view_link;
			$messages[ $post_type ][9] .= $view_link;

			$preview_permalink = add_query_arg( 'preview', 'true', $permalink );
			$preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview job', 'custom-post-type-jobs' ) );
			$messages[ $post_type ][8]  .= $preview_link;
			$messages[ $post_type ][10] .= $preview_link;
		}

		return $messages;

	} // end post_updated_messages



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

		update_post_meta( $post_id, '_job-meta', apply_filters( 'custom-post-type-jobs-save-meta', $meta, $post_id ) );

	} // end save_post



}

new Custom_Post_Type_Job_Admin;
