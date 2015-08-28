<?php if ( ! defined( 'ABSPATH' ) ) exit;

function get_all_submissions() {
	
	global $wpdb;

	$query = "
		SELECT $wpdb->posts.ID, wp_ninja_forms_fields.data
		FROM $wpdb->posts, $wpdb->postmeta, wp_ninja_forms_fields
		WHERE $wpdb->posts.post_type = 'nf_sub'
		AND $wpdb->posts.ID = $wpdb->postmeta.post_id
		AND $wpdb->postmeta.meta_key = '_form_id'
		AND wp_ninja_forms_fields.form_id = $wpdb->postmeta.meta_value
		AND wp_ninja_forms_fields.order = 0
		GROUP BY wp_ninja_forms_fields.form_id
	";
	
	$submissions = $wpdb->get_results($query, OBJECT);
	return $submissions;
	//return $wpdb->get_results($querystr, OBJECT);

		

}