<?php if ( ! defined( 'ABSPATH' ) ) exit;

function getSubmissions($id = '') {
	
	global $wpdb;
		$query = "
			SELECT $wpdb->posts.ID, $wpdb->postmeta.meta_value AS submissionTitle
			FROM $wpdb->posts, $wpdb->postmeta
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
		FROM  $wpdb->postmeta
		WHERE $wpdb->postmeta.post_id = $postID
		AND $wpdb->postmeta.meta_key LIKE '%_field_%'
		AND $wpdb->postmeta.meta_key <> '_action'
		AND $wpdb->postmeta.meta_value <> ''
		GROUP BY $wpdb->postmeta.meta_id
	";
	return $wpdb->get_results($query, OBJECT);

}

function getFormsUploads() {
	
	global $wpdb;
	$ninja_forms_uploads = $wpdb->prefix . 'ninja_forms_uploads';
	$ninja_nf_objectmeta = $wpdb->prefix . 'nf_objectmeta';

	$query = "
		SELECT {$ninja_forms_uploads}.*, {$ninja_nf_objectmeta}.meta_value
		FROM {$ninja_forms_uploads}, {$ninja_nf_objectmeta}
		WHERE {$ninja_forms_uploads}.form_id = {$ninja_nf_objectmeta}.object_id
		AND {$ninja_nf_objectmeta}.meta_key = 'form_title'
	";
	
	return $wpdb->get_results($query, OBJECT);
}

function getLabelByMetaKey($metaKey) {
	
	$id = (int) str_replace("_field_", "", $metaKey);
	global $wpdb;

	$ninja_ninja_forms_fields = $wpdb->prefix . 'ninja_forms_fields'; 
	$query = "
		SELECT {$ninja_ninja_forms_fields}.data
		FROM {$ninja_ninja_forms_fields}
		WHERE {$ninja_ninja_forms_fields}.id = $id
	";

	$data = $wpdb->get_results($query, OBJECT);
	$field_metadata = unserialize($data[0]->data);
	return false === $field_metadata ? $metaKey : $field_metadata['label'];
	
}

