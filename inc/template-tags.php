<?php
/**
 * Print starting date
 *
 * @param str $date_format Date format
 * @param int $post_id Post ID
 * @return void
 * @author Ralf Hortt <me@horttcore.de>
 **/
function the_job_starting_date( $date_format = FALSE, $post_id = FALSE )
{

	$date_format = ( FALSE !== $date_format ) ? $date_format : get_option( 'date_format' );
	$post_id = ( FALSE !== $post_id ) ? $post_id : get_the_ID();

	$date = get_job_starting_date( $post_id, $date_format );

	echo $date;

} // end the_job_starting_date



/**
 * Get job starting date
 *
 * @param int $post_id Post ID
 * @return str Timestamp
 * @author Ralf Hortt <me@horttcore.de>
 **/
function get_job_starting_date( $post_id, $date_format = FALSE )
{

	$meta = get_post_meta( get_the_ID(), '_job-meta', TRUE );
	$date = $meta['begin'];

	if ( FALSE === $date_format )
		return $date;

	return date_i18n( $date_format, $date );

} // end get_job_starting_date
