/*! Ninja Forms Roots - v0.1.0
 * http://wordpress.org/plugins
 * Copyright (c) 2015; * Licensed GPLv2+ */
/* global jQuery:false */
( function( window, undefined, $ ) {
	'use strict';
	
	var 
		document = window.document,
		ninja_roots_object = window.ninja_roots_object
	;

	jQuery(document).ready(function() {

		var 
			data = {
				'action': 'submission_details',
				'whatever': 10      // We pass php values differently!
			},
			inline_colorbox = jQuery(".inline"),
			gallery = jQuery(".nf_gallery")
		;
			inline_colorbox.colorbox({inline:true, width:"50%"});
			gallery.colorbox({rel:'nf_gallery'});

		/*submission_el.on('click', function() {
			jQuery.post(ninja_roots_object.ajax_url, data, function(response) {
				window.alert('Got this from the server: ' + response);
			});
		});*/

	});

} )( this, jQuery );