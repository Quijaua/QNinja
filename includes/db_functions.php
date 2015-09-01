<?php if ( ! defined( 'ABSPATH' ) ) exit;

function getSubmissions($id = '') {
	
	global $wpdb;
		$query = "
			SELECT $wpdb->posts.ID, $wpdb->postmeta.meta_value AS submissionTitle
			FROM $wpdb->posts, $wpdb->postmeta, wp_ninja_forms_fields
			WHERE $wpdb->posts.post_type = 'nf_sub'
			AND $wpdb->posts.ID = $wpdb->postmeta.post_id
			AND $wpdb->postmeta.meta_key LIKE '%_field_%'		
			
			AND $wpdb->postmeta.meta_value <> ''
			GROUP BY $wpdb->posts.ID
		";	
		
	
	return $wpdb->get_results($query, OBJECT);
}

function getSubmissionDetails($postID) {

	global $wpdb;

	$query = "
		SELECT $wpdb->postmeta.meta_key, $wpdb->postmeta.meta_value
		FROM wp_ninja_forms_fields, $wpdb->postmeta
		WHERE $wpdb->postmeta.post_id = $postID
		AND $wpdb->postmeta.meta_key LIKE '%_field_%'
		#AND $wpdb->postmeta.meta_value <> ''
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

	return $wpdb->get_results($query, OBJECT);
}

function getLabelByMetaKey($metaKey) {
	
	$id = (int) str_replace("_field_", "", $metaKey);
	global $wpdb;

	$query = "
	SELECT wp_ninja_forms_fields.data
	FROM wp_ninja_forms_fields
	WHERE wp_ninja_forms_fields.id = $id
	";

	$data = $wpdb->get_results($query, OBJECT);
	$field_metadata = unserialize($data[0]->data);
	return false === $field_metadata ? $metaKey : $field_metadata['label'];
	
}

