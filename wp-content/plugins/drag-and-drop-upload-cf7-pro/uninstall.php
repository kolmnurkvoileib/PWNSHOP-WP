<?php

	// if uninstall.php is not called by WordPress, die
	if (!defined('WP_UNINSTALL_PLUGIN')) {
		die;
	}

	// Lists of all options
	$options = array('drag_n_drop_zip_combine','drag_n_drop_zip_name','drag_n_drop_heading_tag','drag_n_drop_mail_attachment','drag_n_drop_text','drag_n_drop_separator','drag_n_drop_browse_text','drag_n_drop_error_server_limit','drag_n_drop_error_failed_to_upload','drag_n_drop_error_files_too_large','drag_n_drop_error_invalid_file','drag_n_drop_error_max_files','drag_n_drop_error_max_upload_limit','drag_n_drop_error_size_limit','drag_n_drop_one_file_at_time','drag_n_drop_upload_dir','drag_n_drop_save_to_media','drag_n_drop_folder_option','drag_n_drop_custom_folder','drag_n_drop_delete_options','drag_n_drop_on_failed_delete_files','drag_n_drop_show_img_preview','drag_n_drop_zip_files','drag_n_drop_parallel_uploads','drag_n_drop_max_total_size','drag_n_drop_chunks_upload','drag_n_drop_chunk_size','drag_n_drop_file_amend','drag_n_drop_image_resize','drag_n_drop_image_quality','drag_n_drop_cf7_folder','drag_n_drop_debug','drag_n_drop_debug_email','drag_n_drop_error_min_file','drag_n_drop_links_attachments','drag_n_drop_disable_btn','drag_n_drop_hide_counter','drag_n_drop_border_color','drag_n_drop_color_progressbar','drag_n_drop_color_filename','drag_n_drop_color_delete','drag_n_drop_color_filesize','drag_n_drop_thumbnail_display','drag_n_drop_thumbnail_column','drag_n_drop_file_ammend_forms','drag_n_drop_of_counter_text','drag_n_drop_delete_text','drag_n_drop_remove_text');

	// Loop and delete options
	foreach( $options as $option ) {
		delete_option( $option );
	}

    // Delete Table
    global $wpdb;

    $wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}cf7_dndmfu_file_uploads" );
    $wpdb->query( "DELETE FROM `{$wpdb->prefix}options` WHERE `option_name` LIKE '%drag_n_drop_%'" );