<?php
/**
 * Plugin Name: Ninja Forms Roots
 * Plugin URI:  http://wordpress.org/plugins
 * Description: Adiciona funcionalidades ao Ninja Forms e Ninja Forms File Upload Extension
 * Version:     0.1.0
 * Author:      Eduardo Alencar
 * Author URI:  
 * License:     GPLv2+
 * Text Domain: nfr
 * Domain Path: /languages
 */

/**
 * Copyright (c) 2015 Eduardo Alencar (email : ealencar10@gmail.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2 or, at
 * your discretion, any later version, as published by the Free
 * Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

/**
 * Built using grunt-wp-plugin
 * Copyright (c) 2013 10up, LLC
 * https://github.com/10up/grunt-wp-plugin
 */

// Useful global constants
define( 'NFR_VERSION', '0.1.0' );
define( 'NFR_URL',     plugin_dir_url( __FILE__ ) );
define( 'NFR_PATH',    dirname( __FILE__ ) . '/' );

// Include 
include NFR_PATH . 'includes/all_includes.php';

/**
 * Default initialization for the plugin:
 * - Registers the default textdomain.
 */
function nfr_init() {
	$locale = apply_filters( 'plugin_locale', get_locale(), 'nfr' );
	load_textdomain( 'nfr', WP_LANG_DIR . '/nfr/nfr-' . $locale . '.mo' );
	load_plugin_textdomain( 'nfr', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

/**
 * Activate the plugin
 */
function nfr_activate() {
	// First load the init scripts in case any rewrite functionality is being loaded
	nfr_init();

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'nfr_activate' );

/**
 * Deactivate the plugin
 * Uninstall routines should be in uninstall.php
 */
function nfr_deactivate() {

}
register_deactivation_hook( __FILE__, 'nfr_deactivate' );

// Wireup actions
add_action( 'init', 'nfr_init' );

// Enqueue scripts and styles
function nfr_scripts_styles() {
    wp_enqueue_script( 'colorbox', NFR_URL . 'assets/js/vendor/jquery.colorbox-min.js', array('jquery'), '1.0.0', true );
    wp_enqueue_script( 'ninja-roots', NFR_URL . 'assets/js/ninja_forms_roots.min.js', array(), '1.0.0', true );
    wp_enqueue_style( 'ninjaroots-core-style', NFR_URL . 'assets/css/ninja_forms_roots.min.css');
    
    wp_localize_script( 'ninja-roots', 'ninja_roots_object',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action( 'wp_enqueue_scripts', 'nfr_scripts_styles' );


// Wireup filters

// Wireup shortcodes
function nfr_submissions( $atts ) {
     
     $attributes = shortcode_atts( array(
        'id'             => '',
        'exclude_fields' => ''
    ), $atts );
     
     $form_id = $attributes['id'];
     $exclude_fields = explode(",", $attributes['exclude_fields']);
     
     $submissions = getSubmissions();
     ob_start();
     include NFR_PATH . 'includes/views/submissions.php';
     $output = ob_get_clean();
     return $output;

      

}
add_shortcode( 'nfsubmissions', 'nfr_submissions' );

function nfr_gallery($atts) {

    $uploads = getFormsUploads();
    ob_start();
    include NFR_PATH . 'includes/views/gallery.php';
    $output = ob_get_clean();
    return $output;

}
add_shortcode( 'nfgallery', 'nfr_gallery' );

add_action( 'wp_ajax_submission_details', 'nfr_submission_details' );
add_action( 'wp_ajax_nopriv_submission_details', 'nfr_submission_details' );
