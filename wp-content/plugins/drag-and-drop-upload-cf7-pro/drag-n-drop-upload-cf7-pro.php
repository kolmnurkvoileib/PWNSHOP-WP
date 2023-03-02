<?php

	/**
	* Plugin Name: Drag and Drop Multiple File Upload PRO - Contact Form 7
	* Plugin URI: https://profiles.wordpress.org/glenwpcoder
	* Description: This simple plugin create Drag & Drop or choose Multiple File upload in your Confact Form 7 Forms.
	* Text Domain: dnd-upload-cf7
	* Domain Path: /languages
	* Version: 2.10.9
	* Author: CodeDropz
	* Author URI: http://codedropz.com
	* License: GPL2
	**/

	/**  This protect the plugin file from direct access */
	if ( ! defined( 'WPINC' ) ) {
		die;
	}

	/** Set plugin constant to true **/
	define( 'dnd_upload_cf7', true );
	define( 'dnd_upload_cf7_PRO', true );

	/**  Define plugin Version */
	define( 'dnd_upload_cf7_version', '2.10.9' );

	/**  Define constant Plugin Directories  */
	define( 'dnd_upload_cf7_directory', untrailingslashit( dirname( __FILE__ ) ) );

	/**  Define constant Plugin Path  */
	if( ! defined('wp_dndcf7_upload_folder') ) {
		define( 'wp_dndcf7_upload_folder', 'wpcf7_drag-n-drop_uploads' );
	}

	/**  Define constant Temporary Folder  */
	if( ! defined('wp_dndcf7_tmp_folder') ) {
		define( 'wp_dndcf7_tmp_folder', 'tmp_uploads' );
	}

	// require plugin core file
	require_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/dnd-upload-cf7.php' ) );

	// include plugin update checker
	require_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/admin/updates.php' ) );

	// Activation & Deactivation
	register_deactivation_hook( __FILE__, 'dndmfu_cf7_deactivate' );