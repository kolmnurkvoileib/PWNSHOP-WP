<?php
	/**
	* @Description : Custom Functions
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('dnd_upload_cf7') || ! defined('dnd_upload_cf7_PRO') ) {
		exit;
	}

    add_filter('dndmfu_cf7_tag_attributes', function( $atts, $tag ){
        $atts['name'] = $tag->name;
        return $atts;
    },10, 2 );

    /**
    * Cron Schedules
    */

    function dndmfu_cf7_cron_schedules( $schedules ) {
        $schedules['10mins'] = array(
            'interval' => 10 * MINUTE_IN_SECONDS, //600 seconds
            'display' => __( 'Every 10 Minutes' )
        );
        return $schedules;
    }

    add_filter( 'cron_schedules', 'dndmfu_cf7_cron_schedules' );

	/**
	* Get users IP Address
	*/

	function dndmfu_cf7_get_user_ip(){
		if( !empty($_SERVER['HTTP_CLIENT_IP']) ) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return apply_filters('wpb_get_ip', $ip);
	}

	/**
	* Filter - Add more validation for file extension
	*/

	function dndmfu_cf7_validate_type( $extension, $supported_types = '' ) {

		$valid = true;
		$extension = preg_replace( '/[^A-Za-z0-9,|]/', '', $extension );

		// not allowed file types
		$not_allowed = array( 'php', 'php3','php4','phtml','exe','script', 'app', 'asp', 'bas', 'bat', 'cer', 'cgi', 'chm', 'cmd', 'com', 'cpl', 'crt', 'csh', 'csr', 'dll', 'drv', 'fxp', 'flv', 'hlp', 'hta', 'htaccess', 'htm', 'htpasswd', 'inf', 'ins', 'isp', 'jar', 'js', 'jse', 'jsp', 'ksh', 'lnk', 'mdb', 'mde', 'mdt', 'mdw', 'msc', 'msi', 'msp', 'mst', 'ops', 'pcd', 'php', 'pif', 'pl', 'prg', 'ps1', 'ps2', 'py', 'rb', 'reg', 'scr', 'sct', 'sh', 'shb', 'shs', 'sys', 'swf', 'tmp', 'torrent', 'url', 'vb', 'vbe', 'vbs', 'vbscript', 'wsc', 'wsf', 'wsf', 'wsh' );

		// allowed ext.
		$allowed_ext = apply_filters('dndmfu_cf7_allowed_extensions', array('ipt') );

		// Search in $not_allowed extension and match
		foreach( $not_allowed as $single_ext ) {
			if ( strpos( $single_ext, $extension, 0 ) !== false && ! in_array( $extension, $allowed_ext )) {
				$valid = false;
				break;
			}
		}

		// If pass on first validation - check extension if exists in allowed types
		if( $valid === true && $supported_types) {
			$extensions = explode('|', strtolower( $supported_types ) );
			if( ! in_array( $extension, $extensions ) ) {
				$valid = false;
			}
		}

		return $valid;
	}

	/**
	* Setup file type pattern for validation
	*/

	function dndmfu_cf7_filetypes( $types ) {
		$file_type_pattern = '';

		// If contact form 7 5.0 and up
		if( function_exists('wpcf7_acceptable_filetypes') ) {
			$file_type_pattern = wpcf7_acceptable_filetypes( $types, 'regex' );
			$file_type_pattern = '/\.(' . $file_type_pattern . ')$/i';
		}else{
			$allowed_file_types = array();
			$file_types = explode( '|', $types );

			foreach ( $file_types as $file_type ) {
				$file_type = trim( $file_type, '.' );
				$file_type = str_replace( array( '.', '+', '*', '?' ), array( '\.', '\+', '\*', '\?' ), $file_type );
				$allowed_file_types[] = $file_type;
			}

			$allowed_file_types = array_unique( $allowed_file_types );
			$file_type_pattern = implode( '|', $allowed_file_types );

			$file_type_pattern = trim( $file_type_pattern, '|' );
			$file_type_pattern = '(' . $file_type_pattern . ')';
			$file_type_pattern = '/\.' . $file_type_pattern . '$/i';
		}

		return $file_type_pattern;
	}

	/**
	* 3rd party - conditional fields cf7
	*/

	function dndmfu_cf7_conditional( $form_id ) {

		if( ! $form_id ) {
			return false;
		}

		// Get visible groups
		$groups = array();

		// Get current form object
		$cf7_post = get_post( $form_id );

		// Extract group shortcode
		$regex = get_shortcode_regex( array('group') );

		// Match pattern
		preg_match_all( '/'. $regex .'/s', $cf7_post->post_content, $matches );

		if( array_key_exists( 3, $matches )) {
			foreach( $matches[3] as $index => $group_name ) {
				$name = array_filter( explode(" ", $group_name ) );
				preg_match('/\[mfile[*|\s].*?\]/', $matches[0][$index], $file_matches );
				if( $file_matches ) {
					$field_name = shortcode_parse_atts( $file_matches[0] );
					$field_name = preg_replace( '/[^a-zA-Z0-9-_]/','', $field_name[1] );
					$groups[ $field_name ] = $name[1];
				}
			}
		}

		return $groups;
	}

	/**
	* Add custom mime-types
	*/

	function dndmfu_cf7_mime_types( $mime_types ){
		$mime_types['xls'] = 'application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel';
		$mime_types['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
		return $mime_types;
	}

	/**
	* Admin Custom Scripts
	*/

	function dndmfu_cf7_admin_scripts() {
		if( isset( $_GET['page'] ) && $_GET['page'] == 'drag-n-drop-upload' ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
	}

	/**
	* Add custom inline css for file uploader styling
	*/

	function dndmfu_cf7_footer() {
		$css = '';
		$css = '<style type="text/css">'."\n";
			if( $progress_color = get_option('drag_n_drop_color_progressbar') ) {
				$css .= '.dnd-progress-bar span { background-color:'. esc_attr( $progress_color ) .'!important; }'."\n";
			}
			if( $filename_color = get_option('drag_n_drop_color_filename') ) {
				$css .= '.dnd-upload-details .name span { color:'. esc_attr( $filename_color ) .'!important; }'."\n";
			}
			if( $icon_color = get_option('drag_n_drop_color_delete') ) {
				$css .= '.dnd-upload-details .remove-file { color:'. esc_attr( $icon_color ) .'!important; }'."\n";
			}
			if( $filesize_color = get_option('drag_n_drop_color_filesize') ) {
				$css .= '.dnd-upload-details .name em { color:'. esc_attr( $filesize_color ) .'!important; }'."\n";
			}
			if( $border_color = get_option('drag_n_drop_border_color') ) {
				$css .= '.codedropz-upload-handler { border-color:'. esc_attr( $border_color ) .'!important; }'."\n";
			}
			if( get_option('drag_n_drop_hide_counter') ) {
				$css .= '.dnd-upload-counter { display:none!important; }'."\n";
			}
			if( $thumbnail_column = get_option('drag_n_drop_thumbnail_column' ) ) {
				$css .= '.codedropz--preview .dnd-upload-status { width: calc( '. ( 100 - ( $thumbnail_column * 2 ) ) .'% / '.$thumbnail_column.' ); }'."\n";
			}
		$css .= '</style>'."\n";

		echo $css;
	}

    /**
	* Fixed Image Orientation
    * From : https://gist.github.com/n7studios/6a764d46bc1d515ba406
    * Credits to : Tim Carr
	*/

    function dndmfu_fix_orientation( $file, $image ) {

        // Attempt to read EXIF data from the image
        $exif_data = wp_read_image_metadata( $file );

        // Make sure there's an orientation
        if( isset( $exif_data['orientation'] ) && in_array( $exif_data['orientation'], array(8,3,6) ) ) {
            switch ( $exif_data['orientation'] ){
                /**
                * Rotate 90 degrees counter-clockwise
                */
                case 8:
                    $image->rotate( 90 );
                    break;

                /**
                * Rotate 180 degrees
                */
                case 3:
                    $image->rotate( 180 );
                    break;

                /**
                * Rotate 270 degrees counter-clockwise ($image->rotate always works counter-clockwise)
                */
                case 6:
                    $image->rotate( 270 );
                    break;
            }
            return $image;
        }

        return $image;
    }

    /**
    * Parse img tags in email
    */

    function dndmfu_cf7_parse_email( $tag, $body ) {
        if( ! $tag ) {
            return false;
        }

        // Setup img shortcode regex
        $img_regex = get_shortcode_regex( array("$tag") );

        // Match regex pattern
        preg_match_all( '/'. $img_regex .'/s', $body, $matches );

        // For img tags matches the regex
        $img_tags = array();

        // Keys 2 = upload field name (ie: upload-file-1)
        if( array_key_exists( 2, $matches )) {
            foreach( $matches[2] as $index => $uploader_name ) {
              
                // Extract shortcode attributes
                $img_atts = shortcode_parse_atts( str_replace(']',' /]', $matches[0][$index] ) );
               
                // Get the tag & size attributes
                if( isset( $img_atts['img-preview'] ) && $img_atts['img-preview'] == 1 ) {
                    $img_tags['is_image'] = (int) $img_atts['img-preview'];
                    $img_tags['replaced_tag'] = $matches[0][$index];
                    if( isset( $img_atts['size'] ) ) {
                        $img_tags['size'] = explode('x', $img_atts['size'] );    
                    }
                }
            }
        }

        return $img_tags;
    }

    /**
    * Check if table exist
    */

    function dndmfu_cf7_check_table() {
        global $wpdb;
        $table = $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix . dndmfu_cf7_table_name ) );
        return $table;
    }

    /**
    * Check multilingual plugin
    */

    function dndmfu_cf7_lang() {

        $lang = '';

        if( function_exists( 'pll_count_posts' ) ){
            $lang = pll_current_language();
        }elseif( function_exists('icl_object_id') ){
            $lang = ICL_LANGUAGE_CODE;
        }

        $wplang = get_option('WPLANG') ? get_option('WPLANG') : 'en_US';
        $lang = ( ( $lang && strpos( $wplang, $lang ) !== false ) || ( ! $lang ) ? '' : '_' . $lang );
        return apply_filters('dndmfu_cf7_lang', $lang );
    }

    /**
    * Fetch multi lingual text
    */

    function dnmfu_cf7_option( $option_name ){
        
        $lang = dndmfu_cf7_lang();
        
        $translated_text = get_option( $option_name );
        
        if( $lang ) {
            $translated_text = get_option( $option_name . $lang );
        }

        return $translated_text;
    }