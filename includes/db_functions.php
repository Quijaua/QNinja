<?php if ( ! defined( 'ABSPATH' ) ) exit;

function getSubmissions() {
	
	global $wpdb;

	$query = "
		SELECT $wpdb->posts.ID, $wpdb->postmeta.meta_value AS submissionTitle
		FROM $wpdb->posts, $wpdb->postmeta, wp_ninja_forms_fields
		WHERE $wpdb->posts.post_type = 'nf_sub'
		AND $wpdb->posts.ID = $wpdb->postmeta.post_id
		AND $wpdb->postmeta.meta_key LIKE '%_field_%'		
		#AND $wpdb->postmeta.meta_key = '_form_id'
		#AND wp_ninja_forms_fields.form_id = $wpdb->postmeta.meta_value
		#AND wp_ninja_forms_fields.order = 0
		#GROUP BY wp_ninja_forms_fields.form_id
		AND $wpdb->postmeta.meta_value <> ''
		GROUP BY $wpdb->posts.ID
	";
	
	return $wpdb->get_results($query, OBJECT);
}

function getSubmissionDetail($postID) {

	global $wpdb;

	$query = "
		SELECT wp_ninja_forms_fields.data, $wpdb->postmeta.meta_value
		FROM wp_ninja_forms_fields, $wpdb->postmeta
		WHERE $wpdb->postmeta.post_id = $postID
		AND $wpdb->postmeta.meta_key LIKE '%_field_%'
		GROUP BY $wpdb->postmeta.meta_id
	";
	
	return $wpdb->get_results($query, OBJECT);

}

function getFormsUploads() {
	global $wpdb;

	$query = "
		SELECT wp_ninja_forms_uploads.*, wp_nf_objectmeta.meta_value
		FROM wp_ninja_forms_uploads, wp_nf_objectmeta
		WHERE wp_ninja_forms_uploads.form_id = wp_nf_objectmeta.object_id
		AND wp_nf_objectmeta.meta_key = 'form_title'
	";

	return return $wpdb->get_results($query, OBJECT);
}

