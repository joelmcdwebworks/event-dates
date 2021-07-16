<?php

function aff_event_dates() {

	// Get start and end dates for the event. If date spans more than one day, display the start
	// and end dates. If only a one day event, display only the start date only.

	// Enqueue registers style

	wp_enqueue_style( basename(__DIR__) );

	global $post;

	if( isset( $_GET["eventid"] ) ) {

		$param_id = $_GET["eventid"];

		if( get_field( 'test_event_id', $param_id ) ) {

			$the_id = get_field( 'test_event_id', $param_id );

		} else {

			$the_id = $param_id;

		}

	} else {

		$the_id = $post->ID;

	}

	$start_date = tribe_get_start_date( $the_id, false, 'Ymd');
	$start_date_month = tribe_get_start_date( $the_id, false, 'M');
	$start_date_day = tribe_get_start_date( $the_id, false, 'j');

	$end_date = tribe_get_end_date( $the_id, false, 'Ymd');
	$end_date_month = tribe_get_end_date( $the_id, false, 'M');
	$end_date_day = tribe_get_end_date( $the_id, false, 'j');

	ob_start();

	echo '<div class="dates-times">';

		if( $start_date != $end_date ) {

			echo '

				<div class="dates-container">

					<div class="start-date-container">

						<span class="start-date-month">' . $start_date_month . '</span>
						<span class="start-date-day">' . $start_date_day . '</span>

					</div><!-- .start-date-container -->

					<div class="dates-separator"></div>

					<div class="end-date-container">

						<span class="end-date-month">' . $end_date_month . '</span>
						<span class="end-date-day">' . $end_date_day . '</span>

					</div><!-- .end-date-container -->

				</div><!-- .dates-container -->

			';			

		} else {

			echo '

				<div class="dates-container">

					<div class="start-date-container">

						<span class="start-date-month">' . $start_date_month . '</span>
						<span class="start-date-day">' . $start_date_day . '</span>

					</div><!-- .start-date-container -->

				</div><!-- .dates-container -->

			';

			$start_time = tribe_get_start_time( $the_id );
			$end_time = tribe_get_end_time( $the_id );
			$event_timezone = get_post_meta( $the_id, '_EventTimezone', true );

			echo '			

				<div class="times-container">

					<div class="event-times">' . $start_time . ' to ' . $end_time . '</div>
					<div class="event-timezone">' . get_simple_timezone( $event_timezone ) . ' </div>				

				</div><!-- times-container -->

			';

		}

	echo '</div><!-- .dates-times -->';

	return ob_get_clean();	

}
add_shortcode( 'event-dates', 'aff_event_dates' );
