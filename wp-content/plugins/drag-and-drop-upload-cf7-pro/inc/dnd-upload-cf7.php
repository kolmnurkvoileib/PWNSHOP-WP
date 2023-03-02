<?php
	/**
	* @Description : Plugin main core
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('dnd_upload_cf7') || ! defined('dnd_upload_cf7_PRO') ) {
		exit;
	}

	/**
	* Begin : begin plugin initialization
	*/

	if( ! class_exists('CodeDropz_Drag_Drop_Upload_CF7') ) {

		class CodeDropz_Drag_Drop_Upload_CF7 {

			private static $instance = null;

			// default error message
			public $error_message = array();

			// Default upload options
			public $_options = array(
				'save_to_media'				=>	false,
				'automatic_file_deletion'	=>	false,
				'folder_option'				=>	null,
				'tmp_folder'				=>	null,
				'upload_dir'				=>	null,
				'preview_image'				=>	'',
				'zip_files'					=>	false
			);

			// Posted data - get from CF7
			private $posted_data = array();

			// default 0 - file counter
			public $counter = 0;

			// bolean - enable debug
			public $debug = 0;

			// array - store save files (media,zip)
			public $files = array();

            // Zipp all files
            public $zip_files = array();

			// array - user information
			public $user = array();

			// Upload dir - default from wp
			public $wp_upload_dir = array();

            // Media Files
            public $media_files = array();

			/**
			* Creates or returns an instance of this class.
			*
			* @return  Init A single instance of this class.
			*/

			public static function get_instance() {
				if( null === self::$instance ) {
					self::$instance = new self();
				}
				return self::$instance;
			}

			// Disable the cloning of this class.
			public function __clone() {}

			// Disable the wakeup of this class.
			public function __wakeup() {}

			/**
			* Load and initialize plugin
			*/

			private function __construct() {
				$this->includes();
				$this->init();
				$this->hooks();
				$this->filters();
			}

			/**
			* Load files
			*/

			public function includes() {
				include_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/dnd-cf7-functions.php' ) ); 			// Include custom functions
				include_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/dnd-cf7-third-party-addons.php' ) ); 	// 3rd party plugins
			}

			/**
			* Plugin init
			*/

			public function init() {

				// Load plugin text domain
				$this->dnd_load_plugin_textdomain();

				// Wordpress upload directory
				$this->wp_upload_dir = apply_filters( 'dnd_cf7_upload_dir', wp_upload_dir() );

				// Debug
				$this->debug = ( get_option('drag_n_drop_debug') ? true : false );

				// Set tmp folder
				$this->_options['tmp_folder'] = wp_dndcf7_tmp_folder;

				// Base upload URL
				$base_url = $this->wp_upload_dir['baseurl'];

				// Create upload folder where files being stored.
				if( defined('wp_dndcf7_upload_folder') ) {

					// concat path and defined folder dir
					$wp_dndcf7_folder = trailingslashit( wp_normalize_path( $this->wp_upload_dir['basedir'] ) ) . wp_dndcf7_upload_folder;

					// Upload Path override in WP admin Settings
					if( $custom_dir = get_option('drag_n_drop_upload_dir') ) {
						$wp_dndcf7_folder = trailingslashit( wp_normalize_path( $custom_dir ) ) . wp_dndcf7_upload_folder;
						$base_url = str_replace(
							wp_normalize_path( ABSPATH ),
							trailingslashit( site_url() ),
							empty( wp_dndcf7_upload_folder ) ? $wp_dndcf7_folder : trailingslashit( dirname( $wp_dndcf7_folder ) )
						);
					}

					// Format correct slashes
					$base_url = preg_replace( '/\\\\/', '/', $base_url );

					// Create dir
					if( ! is_dir( $wp_dndcf7_folder ) ) {
						wp_mkdir_p( $wp_dndcf7_folder );

						// Generate .htaccess file`
						$htaccess_file = path_join( $wp_dndcf7_folder, '.htaccess' );

						if ( ! file_exists( $htaccess_file ) ) {
							if ( $handle = fopen( $htaccess_file, 'w' ) ) {
								fwrite( $handle, "Options -Indexes \n <Files *.php> \n deny from all \n </Files>" );
								fclose( $handle );
							}
						}
					}

					// override default wordpress basedir and baseurl
					$this->wp_upload_dir['basedir'] = apply_filters( 'dnd_cf7_base_dir', untrailingslashit( $wp_dndcf7_folder ) );
					$this->wp_upload_dir['baseurl'] = apply_filters( 'dnd_cf7_base_url', untrailingslashit( path_join( $base_url , wp_dndcf7_upload_folder ) ) );

				}

				// Set default error message
				$this->error_message = array(
					'server_limit'		=>	__('The uploaded file exceeds the maximum upload size of your server.','dnd-upload-cf7'),
					'failed_upload'		=>	__('Uploading a file fails for any reason','dnd-upload-cf7'),
					'large_file'		=>	__('Uploaded file is too large','dnd-upload-cf7'),
					'invalid_type'		=>	__('Uploaded file is not allowed for file type','dnd-upload-cf7'),
					'maxNumFiles'		=>	__('You have reached the maximum number of files ( Only %s files allowed )','dnd-upload-cf7'),
					'maxTotalSize'		=>	__('The total file(s) size exceeding the max size limit of %s.','dnd-upload-cf7'),
					'maxUploadLimit'	=>	__('Note : Some of the files could not be uploaded ( Only %s files allowed )','dnd-upload-cf7'),
					'minFileUpload'		=>	__('Minimum file upload at least','dnd-upload-cf7')
				);

				// check save to media - options
				$this->_options['save_to_media'] = get_option('drag_n_drop_save_to_media') ? true : false;

				// Auto delete file - options
				$this->_options['automatic_file_deletion'] = ( get_option('drag_n_drop_delete_options') !== '' ? true : false );

				// Image Preview - options
				$this->_options['preview_image'] = get_option('drag_n_drop_show_img_preview') ? true : false;

				// Compressed / Zipped files
				$this->_options['zip_files'] = get_option('drag_n_drop_zip_files') ? true : false;

				// Get user information - for loggedin user
				$this->user = ( is_user_logged_in() ? wp_get_current_user() : null );

				// Folder Option
				if( get_option('drag_n_drop_folder_option') ) {
					$this->_options['folder_option'] = get_option('drag_n_drop_folder_option');
				}

				// Setup upload path
				$_dir = '';

				// Switch folder options
				if( $this->_options['folder_option'] ) {
					switch(  $this->_options['folder_option'] ) {
						case 'dynamic_folder':
						case 'cf7_fields':
							$_dir = null;
							break;
						case 'date_n_time':
							$_dir = $this->get_date('Y-m-d-h-i-s');
							break;
						case 'user_login':
							$_dir = ( ( is_user_logged_in() && $this->user->exists() ) ? 'user-'. sanitize_title( $this->user->display_name ) : 'user-file-'.time() );
							break;
						case 'generated':
							$rand_max = mt_getrandmax();
							$_dir = zeroise( mt_rand( 0, $rand_max ), strlen( $rand_max ) );
							break;
						default:
							$_dir = ( get_option('drag_n_drop_custom_folder') ? get_option('drag_n_drop_custom_folder') : 'custom-' . $this->get_date('m-d-y') );
							break;
					}
				}

				// Setup dir
				$this->_options['upload_dir'] = ( $_dir ? $_dir : $this->_options['tmp_folder'] );

			}

			/**
			* Begin : begin plugin hooks
			*/

			public function hooks() {

                // Add plugin settings
                add_filter( 'plugin_action_links_' . plugin_basename( dnd_upload_cf7_directory ) .'/drag-n-drop-upload-cf7-pro.php', array( $this, 'dnd_cf7_upload_links' ) );

				// Contact form 7 hooks
				add_action( 'wpcf7_init', array( $this, 'dnd_cf7_upload_add_form_tag_file') );
				add_action( 'wpcf7_admin_init', array( $this, 'dnd_upload_cf7_add_tag_generator'), 50 );
				add_action( 'wp_enqueue_scripts', array( $this, 'dnd_cf7_scripts') );

				// Enqueue admin scripts
				add_action( 'admin_enqueue_scripts', 'dndmfu_cf7_admin_scripts' );

				// Ajax Upload
				add_action( 'wp_ajax_dnd_codedropz_upload', array( $this, 'dnd_upload_cf7_upload') );
				add_action( 'wp_ajax_nopriv_dnd_codedropz_upload', array( $this, 'dnd_upload_cf7_upload' ) );

				// Ajax - Chunks
				add_action( 'wp_ajax_dnd_codedropz_upload_chunks', array( $this, 'dnd_upload_cf7_upload_chunks' ) );
				add_action( 'wp_ajax_nopriv_dnd_codedropz_upload_chunks', array( $this, 'dnd_upload_cf7_upload_chunks' ) );

				// Hook - Ajax Delete
				add_action( 'wp_ajax_nopriv_dnd_codedropz_upload_delete', array( $this,'dnd_codedropz_upload_delete') );
				add_action( 'wp_ajax_dnd_codedropz_upload_delete', array( $this, 'dnd_codedropz_upload_delete'));

				// Hook before mail send cf7
                $cf7_conditional =  'contact-form-7-conditional-fields-pro/contact-form-7-conditional-fields.php'; //CF7 Conditional Field PRO
                if( in_array( $cf7_conditional, get_option( 'active_plugins' ) ) ) {
                    add_action( 'wpcf7_before_send_mail', array( $this, 'dnd_cf7_before_send_mail'), 10, 1 );
                }else {
                    add_action( 'wpcf7_before_send_mail', array( $this, 'dnd_cf7_before_send_mail'), 9, 1 ); // adjust priority for compatibility
                }

				// Add Submenu - Settings
				add_action( 'admin_menu', array( $this, 'dnd_admin_settings') );

				// Hooks - Clean up files
				if( $this->_options['automatic_file_deletion'] === true ) {
					add_action('wp_dnd_cf7_daily_cron', array( $this, 'wpcf7_remove_dnd_uploaded_files' ), 20, 3 );
					if ( ! wp_next_scheduled ( 'wp_dnd_cf7_daily_cron') ) {
						wp_schedule_event( time(), '10mins', 'wp_dnd_cf7_daily_cron' );
					}
				}

				// Submit Form Hooks - Check Status ( Spam or Failed )
				add_action( 'wpcf7_submit', array( $this, 'dnd_cf7_wpcf7_submission'), 10, 2 );

				// Hooks dnd before send files data - change filename
				add_action( 'dnd_cf7_mail_setup_data', array( $this, 'dnd_cf7_change_filename'), 10 );

				// Hooks change folder name
				add_action( 'dnd_cf7_mail_setup_data', array( $this, 'dnd_cf7_move_to_folder'), 50 );

				// Hooks change folder pattern ( dynamic folder option ie: {your-name} / {username} )
				add_action( 'dnd_cf7_mail_setup_data', array( $this, 'dnd_cf7_dynamic_folder'), 100 );

				// Hooks - Mail Sent
				add_action( 'wpcf7_mail_sent', array( $this, 'dnd_wpcf7_mail_sent' ), 10, 1 );

				// Add custom style in footer
				add_action( 'wp_footer', 'dndmfu_cf7_footer' );
				
			}

            /**
			* Add plugin settings link
			*/

            public function dnd_cf7_upload_links( $actions ) {
                $upload_links = array('<a href="' . admin_url( 'admin.php?page=drag-n-drop-upload' ) . '">Settings</a>',);
                $actions = array_merge( $upload_links, $actions );
                return $actions;
            }

			/**
			* Hooks : After Sent ( Clear Session )
			*/

			public function dnd_wpcf7_mail_sent( $form ){
                
                // Allow other plugin to get the files
                do_action('dndmfu_cf7_form_sent', $this->get_files() );

				// Delete files immediately
				if( get_option('drag_n_drop_delete_options') === '0' ) {
					$get_files = $this->get_files();
					if( false !== $get_files ) {
						foreach( $get_files as $upload_name => $files ) {
							foreach( $files as $file ) {
								$this->delete_files( self::convert_url( $file ) );
							}
						}
					}
				}

				// For Debugging
				if( $this->debug == true ) {
					wp_mail( get_option('drag_n_drop_debug_email'), get_bloginfo( 'name' ) .' - Debug Session', print_r( $_SESSION, true ) );
					wp_mail( get_option('drag_n_drop_debug_email'), get_bloginfo( 'name' ) .' - Posted Data', print_r( $this->get_posted_data(), true ) );
					wp_mail( get_option('drag_n_drop_debug_email'), get_bloginfo( 'name' ) .' - Files Data', print_r( $this->get_files(), true ) );
				}

				// remove session
				self::delete_cookie('posted_data');

				// Reset files
				$this->files = array();

                // For zip files
                $this->zip_files = array();

                // For media Files
                $this->media_files = array();

			}

			/**
			* Hooks : Change filename pattern
			*/

			public function dnd_cf7_change_filename( $tag_name ) {

				if( ! $tag_name )
					return;

				if( is_array( $tag_name ) && count( $tag_name ) > 0 ) {

					// Get filename ammend.
					$ammend_name = trim( get_option('drag_n_drop_file_amend') );

					// If original file name no need to proceed.
					if( '{filename}' == $ammend_name || empty( $ammend_name ) ) {
						self::delete_cookie('posted_data');
						return;
					}

					// Check to match for fields
					if( $ammend_name ) {

						$dir = array(); // Setup variable for DIR
						$wp_dir = $this->wp_upload_dir; // Get basedir & baseurl

						// Loop files ang get only mfile upload fields
						foreach( $tag_name as $name ) {

							if( isset( $this->posted_data[ $name ] ) && ! empty( $this->posted_data[ $name ] ) ) {
								foreach( $this->posted_data[ $name ] as $file ) {

									// ammend name, convert basedir to baseurl, pathinfo of old file
									$new_dir = self::convert_url( $file );
									$old_file = pathinfo( $new_dir );

									// Old filename, extesion
									$old_filename = $old_file['filename'];
									$old_dir = trailingslashit( $old_file['dirname'] );
									$ext = strtolower( $old_file['extension'] );

									// skip - don't change filename
									$apply_to = get_option('drag_n_drop_file_ammend_forms');
									if( $apply_to && isset( $_POST['_wpcf7'] ) && ! in_array( $_POST['_wpcf7'], $apply_to ) ) {
										$dir[ $name ][] = $new_dir;
										continue;
									}

									// Replace special tags pattern
									$ammend_pattern = $this->replace_tags( $ammend_name, $old_filename );

									// Remove special characters
									if( function_exists('mb_check_encoding') ) {
										if ( mb_check_encoding( $ammend_pattern, 'ASCII' ) ) {
											$new_file_name = preg_replace('/[^A-Za-z0-9-_.]/','', $ammend_pattern);
										}else{
                                            $new_file_name = $ammend_pattern;
                                        }
									}else {
										$new_file_name = $ammend_pattern;
									}

                                    // Upload field option is present
                                    if( strpos( $new_file_name, 'upload_field' ) !== false ) {
                                        $new_file_name = str_replace('upload_field', $name, $new_file_name );
                                    }

									// Create new filename
									$new_name = pathinfo( wp_unique_filename( $old_dir, sanitize_title( $new_file_name ) .'.'. $ext ) );

									// Check if file exists then rename
									if( file_exists( $new_dir ) ) {
										$rename_file = rename( $new_dir, path_join( $old_dir, $new_name['filename'] .'.'. $ext ) );

										// Rename also thumbnail
										if( $rename_file ) {
											$new_thumb_file = $new_name['filename'] .'-100x100.'. $ext;
											if( file_exists( path_join( $old_dir,  $old_filename .'-100x100.'. $ext ) ) ) {
												rename( path_join( $old_dir,  $old_filename .'-100x100.'. $ext ), path_join( $old_dir, $new_thumb_file ) );
											}
											$dir[ $name ][] = trailingslashit( $this->wp_upload_dir['baseurl'] ) . wp_basename( $old_dir ) .'/'. $new_name['filename'] .'.'. $ext;
										}
									}

									//Modified posted_data with the new filename.
									if( count( $dir ) > 0 ) {
										self::set_cookie('posted_data', $dir );
									}

								} // end foreach
							}
						}
					}
				}
			}

			/**
			* Move Files to folder specified settings - Contact Form 7 Fields Only
			*/

			public function dnd_cf7_move_to_folder( $tag_name ) {

				// Check and make sure tag name is present.
				if( ! $tag_name )
					return;

				// If not cf7 fields there's no need to continue
				if( $this->_options['folder_option'] != 'cf7_fields' ) {
					return;
				}

				$new_data = array();

				// Make sure cf7 fields folder is added.
				if( get_option('drag_n_drop_cf7_folder') ) {

					// Get & Clean cf7 fields.
					$cf7_fields =  preg_replace( '/([^a-zA-Z0-9-_&])/m', '', get_option('drag_n_drop_cf7_folder') );

					// Get posted data
					$posted_data = ( self::get_cookie('posted_data') ?  self::get_cookie('posted_data') : $this->posted_data );

					if( is_array( $tag_name ) && count( $tag_name ) > 0 ) {

						// Loop files ang get only mfile upload fields
						foreach( $tag_name as $name ) {

							// Make sure it's not empty
							if( isset( $posted_data[ $name ] ) && ! empty( $posted_data[ $name ] ) ) {

								// Loop all posted data ( from : submitted or after changing the names )
								foreach( $posted_data[ $name ] as $file ) {

									// Convert base url to directory
									$from_dir = self::convert_url( $file );

									if( file_exists( $from_dir ) ) {

										// Get data from cf7 - fields
										if( $cf7_fields && isset( $this->posted_data[ $cf7_fields ] ) ) {

											// Get folder name value from cf7 data
											$folder_cf7_data = $this->posted_data[ $cf7_fields ];

											// Setup folder name
											$folder_name = ( is_array( $folder_cf7_data ) ? reset( $this->posted_data[ $cf7_fields ] ) : $folder_cf7_data );

											// Get filename, basedir, ext from old files
											$file = pathinfo( $from_dir );
											$filename = $file['filename'];
											$dir = trailingslashit( $file['dirname'] );
											$ext = strtolower( $file['extension'] );

											// Setup new dir & where to move files.
											$move_to = $this->wp_upload_dir['basedir'] .'/'. ( ! is_email( $folder_name ) ? sanitize_title( $folder_name ) : $folder_name );

											// Create new /dir
											if( ! is_dir( $move_to ) ) {
												wp_mkdir_p( $move_to );
											}

											// Finaly move to files to new dir ( main file & thumbnail )
											if( is_dir( $move_to ) ) {
												@rename( $from_dir , trailingslashit( $move_to ) . wp_basename( $from_dir ) ); //@main file
												@rename(  $dir . $filename .'-100x100.' . $ext, trailingslashit( $move_to ) . $filename .'-100x100.'. $ext ); //@thumbnail 100x100
											}

											// Assign newly move files to $new_data variable
											$dir = trailingslashit( $move_to ) . wp_basename( $from_dir );
											if( file_exists( $dir ) ) {
												$new_data[$name][] = self::convert_url( $dir, true );
											}

										}

									} //#end file_exists

								} //#end foreach

							} //#end isset & empty

						} //#end foreach

					}

				}

				// Set to session/cookie
				if( $new_data && count( $new_data ) > 0 ) {
					self::set_cookie('posted_data', $new_data );
				}

			}

			/**
			* Move Files to custom / dynamic folder
			*/

			public function dnd_cf7_dynamic_folder( $tag_name ) {
				// Check and make sure tag name is present.
				if( ! $tag_name )
					return;
				
				// If folder option not equal to dynamic folder then return.
				if( $this->_options['folder_option'] != 'dynamic_folder' ) {
					return;
				}

				$new_data = array();

				// Make sure cf7 fields folder is added.
				if( get_option('drag_n_drop_dynamic_folder') ) {

					// Get posted data
					$posted_data = ( self::get_cookie('posted_data') ?  self::get_cookie('posted_data') : $this->posted_data );
					
					// Get folder pattern
					$folder_pattern = get_option('drag_n_drop_dynamic_folder');

					if( is_array( $tag_name ) && count( $tag_name ) > 0 ) {

						// Loop files ang get only mfile upload fields
						foreach( $tag_name as $name ) {

							// Make sure it's not empty
							if( isset( $posted_data[ $name ] ) && ! empty( $posted_data[ $name ] ) ) {

								// Loop all posted data ( from : submitted or after changing the names )
								foreach( $posted_data[ $name ] as $file ) {

									// Convert base url to directory
									$old_dir_file = self::convert_url( $file );

									// Check & make sure file exists
									if( file_exists( $old_dir_file ) ) {

										// Replace special tags
										$folder_dir = $this->replace_tags( $folder_pattern );

										if( $folder_dir ) {

											// Upload field option is present
											if( strpos( $folder_dir, 'upload_field' ) !== false ) {
												$folder_dir = str_replace('upload_field', $name, $folder_dir );
											}

											// Setup new dir
											$new_dir = trailingslashit( $this->wp_upload_dir['basedir'] ) . $folder_dir . '/';

											// Create new dir
											if( ! is_dir( $new_dir ) ) {
												wp_mkdir_p( $new_dir );
											}

											// Check & make sure file exist & begin to move.
											if( file_exists( $new_dir ) ) {
												if( copy( $old_dir_file, $new_dir . wp_basename( $file ) ) ) {

													// assign new files from new directory/folder
													$new_data[$name][] = self::convert_url( $new_dir . wp_basename( $file ) , true );

													// delete files from old dir
													$this->delete_files( $old_dir_file );
												}
											}

										}

									} //#end file_exists

								} //#end foreach

							} //#end isset & empty

						} //#end foreach

					}

				}

				// Set to session/cookie
				if( $new_data && count( $new_data ) > 0 ) {
					self::set_cookie('posted_data', $new_data );
				}
			}

			/**
			* Replace special tags with corresponding values from CF7 fields.
			* @param : tags_pattern {field_name}, original_filename
			*/

			public function replace_tags( $pattern, $filename = null ) {

				if( ! $pattern ) {
					return;
				}

				// Match {field_name} or {fields:your-name} patterns : /{fields[s+:|:](.*?)}|{.*?}/ = {fields:name}
				preg_match_all( '/\{(.*?)\}/', $pattern, $matches ); // $matches[0] = {file_name}_pattern, $matches[1] = field_name

				if( $matches[1] && count( $matches[1] ) > 0 ) {
					foreach( $matches[1] as $key=> $single_match ) {

						// Get field name
						$field_name = trim( $single_match );
						$field_pattern = $matches[0][ $key ];

						// Replace dynamic fields ie: {fields:your-name}
						if( isset( $this->posted_data[ $field_name ] ) && ( null !== $this->posted_data[ $field_name ] ) ) {
							$field_cf7_data = $this->posted_data[ $field_name ];
							if( is_array( $field_cf7_data ) ) {
								$pattern = str_replace( $field_pattern, sanitize_title( reset( $field_cf7_data ) ), $pattern );
							}else {
								$pattern = str_replace( $field_pattern, sanitize_title( $field_cf7_data ), $pattern );
							}
						}else {
							// Replace {field_name} pattern with corresponding value
							$dynamic_fields = $this->get_tag( $field_name, $filename );
							if( $dynamic_fields ) {
								$pattern = str_replace( $field_pattern, $dynamic_fields, $pattern );
							}
						}
					}
				}

				return preg_replace( '/\s+/', '', $pattern );
			}

			/**
			* Begin : Get special tag name
			* @param : {fieldname}, original_filename
			*/

			public function get_tag( $field_name, $name = null ) {

				if( ! $field_name ) {
					return false;
				}

				// Get special tags
				$special_tags = $this->dnd_special_tags();
				$post_id = (int)$_POST['_wpcf7_container_post'];
				$tags = array();

				// Loop all tags
				foreach( $special_tags as $tag => $tag_value ) {
					if( $tag == 'filename' && $name ) {
						$tags['filename'] = $name; // get original filename
					}elseif( $tag == 'post_id' ) {
						$tags['post_id'] = sanitize_text_field( $post_id );
					}elseif( $tag == 'post_slug' ) {
						$tags['post_slug'] = get_post( $post_id )->post_name;
					}else {
						$tags[$tag] = $tag_value;
					}
				}

				if( array_key_exists( $field_name, $tags ) && isset( $tags[ $field_name ] ) ) {
					return $tags[ $field_name ];
				}else {
					return $field_name;
				}

				return false;
			}

			/**
			* Begin : Custom Cf7 filters
			*/

			private function filters() {

				// Add custom mime-type
				add_filter('upload_mimes', 'dndmfu_cf7_mime_types', 1, 1);

				// Encode type filter to support multipart since this is input type file
				add_filter( 'wpcf7_form_enctype',  array( $this, 'dnd_upload_cf7_form_enctype_filter') );

				// Validation + upload handling filter
				add_filter( 'wpcf7_validate_mfile',  array( $this, 'dnd_upload_cf7_validation_filter' ), 10, 2 );
				add_filter( 'wpcf7_validate_mfile*',  array( $this, 'dnd_upload_cf7_validation_filter' ), 10, 2 );

				// Add hidden fields
				add_filter('wpcf7_form_hidden_fields', function( $hidden ){
					return array_merge( $hidden, array(
						'upload_dir'		=>	$this->_options['upload_dir'],
						'generate_name'		=>	$this->get_date('m-d-y') . '-'. uniqid()
					));
				});

				// Modify Posted Data
				add_filter('wpcf7_posted_data', array( $this, 'dnd_wpcf7_posted_data'), 10, 1 );

				// Modify email body
				//add_filter('dnd_wpcf7_email_body', array( $this, 'dnd_upload_cf7_email_body'), 10, 3 );

				// filter before mail send
				add_filter('wpcf7_mail_components', array( $this, 'dnd_cf7_mail_components'), 500, 2 );

                // Change zip name
                add_filter('dnd_cf7_archive_name', array( $this, 'dnd_cf7_change_archive_name'), 10, 3 );

			}

			/**
			* Hooks - After form submission
			*/

			public function dnd_cf7_wpcf7_submission( $form, $result ) {

				// Make sure not (failed and spam)
				if( in_array( $result['status'], array( 'mail_failed','spam' ) ) ) {
                    
                    // Get option settings for file deletion if form is failed/spam
                    $delete_option = get_option('drag_n_drop_on_failed_delete_files', 1 );

                    // Dont' delete files
                    if( '' === $delete_option ) {
                        return $result;
                    }

					// Get posted_data
					$posted_data = $this->get_posted_data();

					// Get name of mfile only from fields array
					$tags = self::scan_tags( $form );

					// Clean/Remove : Files
					if( $tags && count( $tags ) > 0 ) {
						foreach( $tags as $field_name ) {
							if( isset( $posted_data[ $field_name ] ) && is_array( $posted_data[ $field_name ] ) ) {
								foreach( $posted_data[ $field_name ] as $file ) {
									$file_path = self::convert_url( $file );
									if( file_exists( $file_path ) ) {
										$this->delete_files( $file_path );
									}
								}
							}
						}
					}
				}

				return $result;
			}

			/**
			* Hooks -  Modify contact form posted_data
			*/

			public function dnd_wpcf7_posted_data( $posted_data ){

				// Subbmisson instance from CF7
				$submission = WPCF7_Submission::get_instance();

				// Make sure we have the data
				if ( ! $posted_data ) {
					$posted_data = $submission->get_posted_data();
				}

				// Scan form tags and get only `mfile` specific tag
				$tags = self::scan_tags( $submission->get_contact_form() );

				// Loop mfile upload tags and assign to posted_data
				if( $tags && count( $tags ) > 0 ) {
					foreach( $tags as $field_name ) {
						if( isset( $_POST[ $field_name ] ) && ! empty( $_POST[ $field_name ] ) ) {
							foreach( $_POST[ $field_name ] as $key => $file ) {
								$posted_data[$field_name][$key] = esc_url( $this->wp_upload_dir['baseurl'] . trim( sanitize_text_field( $file ) ) );
							}
						}
					}
				}

				// Supply data from cf7
				$this->posted_data = $posted_data;

				// Remove hidden fields
				unset($posted_data['upload_dir']);
				unset($posted_data['generate_name']);

				// Array return data
				return $posted_data;
			}

			/**
			* Delete specific files
			*/

			public function dnd_codedropz_upload_delete() {

				// Verify ajax none
				if( is_user_logged_in() ) {
					check_ajax_referer( 'dnd_cf7_ajax_upload', 'security' );
				}

				// Sanitize Path
				$path = ( isset( $_POST['path'] ) ? sanitize_text_field( $_POST['path'] ) : null );

				// Make sure path is set
				if( ! is_null( $path ) ) {

					// Check valid filename & extensions
					if( preg_match_all('/wp-|(\.php|\.exe|\.js|\.phtml|\.cgi|\.aspx|\.asp|\.bat)/', $path ) ) {
						die('File not safe');
					}

					// Concat path and upload directory	- prevent from transversal attack
					$_dir =  trailingslashit( wp_basename( dirname( $path ) ) );
					$file_path = realpath( trailingslashit( $this->wp_upload_dir['basedir'] ) . $_dir . wp_basename( $path ) );

					// Check if directory inside wp_content/uploads/
					$is_path_in_content_dir = strpos( $file_path, realpath( wp_normalize_path( $this->wp_upload_dir['basedir'] ) ) );

					// Check if is in the correct upload_dir
					if( ! preg_match("/". wp_dndcf7_upload_folder ."/i", $file_path ) || ( 0 !== $is_path_in_content_dir ) ) {
						die('It\'s not a valid upload directory');
					}

					// Check if file exists
					if( file_exists( $file_path ) ){
						$this->delete_files( $file_path );
						if( ! file_exists( $file_path ) ) {
							wp_send_json_success('File Deleted!');
						}
					}
				}

				die;
			}

			/**
			* Delete Preview Thumbnail
			* @param : $file_path - basedir
			*/

			protected function delete_files( $file_path ) {

				// There's no reason to proceed if - null
				if( ! $file_path ) {
					return;
				}

				// Get file info
				$file = pathinfo( $file_path );
				$dirname = trailingslashit( wp_normalize_path( $file['dirname'] ) );

				// Check and validate file type if it's safe to delete...
				$safe_to_delete = dndmfu_cf7_validate_type( $file['extension'] );

				// @bolean - true if validated
				if( $safe_to_delete ) {

					// Delete parent file
					wp_delete_file( $file_path );

					// Delete if there's a thum
					if( file_exists( $thumbnail = $dirname . $file['filename'].'-100x100' .'.'. strtolower( $file['extension'] ) ) ) {
						wp_delete_file( $thumbnail );
					}
				}
			}

			/**
			* Clean file / auto delete files
			*/

			public function wpcf7_remove_dnd_uploaded_files( $dir_path = null, $seconds = 600, $max = 60 ) {
				if ( is_admin() || 'POST' != $_SERVER['REQUEST_METHOD'] || is_robots() || is_feed() || is_trackback() ) {
					return;
				}

				// Setup dirctory path
				$dir = ( ! $dir_path  ? trailingslashit( $this->wp_upload_dir['basedir'] ) : trailingslashit( $dir_path ) );

				// Make sure dir is readable or writable
				if ( ! is_dir( $dir ) || ! is_readable( $dir ) || ! wp_is_writable( $dir ) ) {
					return;
				}

				// Get time options if set or else use default : 600 seconds
				$time = absint( get_option('drag_n_drop_delete_options') ? ( (int) get_option('drag_n_drop_delete_options') * 60 * 60 ) : $seconds );

				// allow theme/plugins to change time before deletion...
				$seconds = apply_filters( 'dnd_cf7_time_before_deletion', $time );

				$max = absint( $max );
				$count = 0;

				//Delete files from media library...
				if( $this->_options['save_to_media'] ) {

					// Setup attachment post type.
					$args = array(
						'post_type'			=>	'attachment',
						'posts_per_page'	=>	20,
						'meta_query'		=>	array(
							array(
								'key'     => '_dndmfu_cf7_file_upload',
								'value'   => 'yes'
							)
						)
					);

					// Get all attachment
					$attachments = get_posts( $args );

					if( $attachments ) {
						foreach( $attachments as $media ) {

							//@debug
							//echo date( 'Y-m-d H:i:s', strtotime( $media->post_date ) + $seconds ) .'/'. $this->get_date('Y-m-d H:i:s').'<br>';

							// Delete older files based on the time/option selected in the admin
							if( strtotime( $media->post_date ) + $seconds  <= strtotime( $this->get_date('Y-m-d H:i:s') ) ) {
								wp_delete_attachment( $media->ID, true );
							}

							/*
							 Example:
							 Delete files after 1 hour (set the option in Admin).
							 User 1 uploaded files at 10:00 AM + 60 Minutes (1Hour) = 11:00 AM Total
							 If uploaded file is less than current time then it will automatically deleted. (exactly 11:00 AM or onwards)
							 Don't delete the file if current time is between ( 10AM - 10:59AM )
							*/
						}
					}

					return false;
				}

				// Scan local files directory
				if ( $handle = @opendir( $dir ) ) {
					while ( false !== ( $file = readdir( $handle ) ) ) {
						if ( $file == "." || $file == ".." ) {
							continue;
						}

						// Setup dir and filename
						$file_path = $dir . $file;

						// Check if current path is directory (recursive)
						if( is_dir( $file_path ) ) {
							$this->wpcf7_remove_dnd_uploaded_files( $file_path );
							continue;
						}

						// Get file time of files OLD files.
						$mtime = @filemtime( $file_path );
						if ( $mtime && time() < $mtime + $seconds ) { // less than $seconds old (if time >= modified = then_delete_files) (past)
							continue;
						}

						// @desscription : Make sure it's inside our upload basedir (directory)
						// @example : "c:/xampp/htdocs/wp/wp-content/uploads/wpcf7_drag-n-drop_uploads/file.jpg", "c:/xampp/htdocs/wp/wp-content/uploads/wpcf7_drag-n-drop_uploads/"
						$is_path_in_content_dir = strpos( $file_path, wp_normalize_path( realpath( $this->wp_upload_dir['basedir'] ) ) );

						// Delete files from dir ( don't delete .htaccess file )
						if( 0 === $is_path_in_content_dir && $file != '.htaccess' ) {
							$this->delete_files( $file_path );
						}

						$count += 1;

						if ( $max <= $count ) {
							break;
						}
					}
					@closedir( $handle );
				}

				// Remove empty dir except - /tmp_uploads
				if( false === strpos( $dir, $this->_options['tmp_folder'] ) ) {
					@rmdir( $dir );
				}
			}

			/**
			* Encode type filter to support multipart since this is input type file
			*/

			public function dnd_upload_cf7_form_enctype_filter( $enctype ) {
				$multipart = (bool) wpcf7_scan_form_tags( array( 'type' => array( 'drag_drop_file', 'drag_drop_file*' ) ) );

				if ( $multipart ) {
					$enctype = 'multipart/form-data';
				}

				return $enctype;
			}

			/**
			* Validation + upload handling filter
			*/

			public function dnd_upload_cf7_validation_filter( $result, $tag ) {

				// Setup cf7 files tags name & option
				$name = $tag->name;
				$id = $tag->get_id_option();
				$min_file = $tag->get_option( 'min-file','', true);

				// Get upload-file POST data
				$multiple_files = ( isset( $_POST[ $name ] ) ? array_map( 'sanitize_text_field', $_POST[ $name ] ) : null );

				// Check minimum upload
				if( $multiple_files && count( $multiple_files ) < (int) $min_file ) {
					$min_file_error = ( dnmfu_cf7_option('drag_n_drop_error_min_file') ? dnmfu_cf7_option('drag_n_drop_error_min_file') : $this->get_error_msg('minFileUpload') );
					$result->invalidate( $tag, $min_file_error .' '. (int)$min_file );
					return $result;
				}

				// Cf7 Conditional Field
				if( in_array('cf7-conditional-fields/contact-form-7-conditional-fields.php', get_option('active_plugins') ) || in_array('contact-form-7-conditional-fields-pro/contact-form-7-conditional-fields.php', get_option('active_plugins') ) ){

					$hidden_groups = json_decode( stripslashes( $_POST['_wpcf7cf_hidden_groups'] ) );
					$form_id = WPCF7_ContactForm::get_current()->id();
					$group_fields = dndmfu_cf7_conditional( $form_id );

					if( is_null( $multiple_files ) && $tag->is_required() ) {
						if( isset( $group_fields[ $name ] ) && ! in_array( $group_fields[ $name ], $hidden_groups ) ) {
							$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
						}elseif( ! array_key_exists( $name, $group_fields ) ) {
							$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
						}
						return $result;
					}

					return $result;
				}

				// Check if we have files or if it's empty
				if( ( is_null( $multiple_files ) || count( $multiple_files ) == 0 ) && $tag->is_required() ) {
					$result->invalidate( $tag, wpcf7_get_message( 'invalid_required' ) );
					return $result;
				}

				return $result;
			}

			/**
			* Register form tag(mfile - file)
			*/

			public function dnd_cf7_upload_add_form_tag_file() {
				wpcf7_add_form_tag(	array( 'mfile ', 'mfile*'), array( $this, 'dnd_cf7_upload_form_tag_handler'), array( 'name-attr' => true ) );
			}

			/**
			* Begin : Generate Tags
			*/

			public function dnd_upload_cf7_add_tag_generator() {
				$tag_generator = WPCF7_TagGenerator::get_instance();
				$tag_generator->add( 'upload-file', __( 'multiple file upload', 'dnd-upload-cf7' ), array( $this, 'dnd_upload_cf7_tag_generator_file' ) );
			}

			/**
			* Begin : Display Form In wp-admin
			*/

			public function dnd_upload_cf7_tag_generator_file( $contact_form, $args = '' ) {

				// Parse data and get our options
				$args = wp_parse_args( $args, array() );

				// Our multiple upload field
				$type = 'mfile';

				$description = __( "Generate a form-tag for a file uploading field. For more details, see %s.", 'contact-form-7' );
				$desc_link = wpcf7_link( __( 'https://contactform7.com/file-uploading-and-attachment/', 'contact-form-7' ), __( 'File Uploading and Attachment', 'contact-form-7' ) );

				if( file_exists( dnd_upload_cf7_directory .'/inc/admin/admin-cf7-fields.php' ) ) {
					include_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/admin/admin-cf7-fields.php' ) );
				}
			}

			/**
			* Begin : Form tag handler from the tag - callback
			*/

			public function dnd_cf7_upload_form_tag_handler( $tag ) {

				// check and make sure tag name is not empty
				if ( empty( $tag->name ) ) {
					return '';
				}

				// Validate our fields
				$validation_error = wpcf7_get_validation_error( $tag->name );

				// Generate class
				$class = wpcf7_form_controls_class( 'drag-n-drop-file d-none' );

				// Add not-valid class if there's an error.
				if ( $validation_error ) {
					$class .= ' wpcf7-not-valid';
				}

				// Get current form Object
				$form = WPCF7_ContactForm::get_current();

				// Setup element attributes
				$atts = array();

				$atts['size'] = $tag->get_size_option( '40' );
				$atts['class'] = $tag->get_class_option( $class );
				$atts['id'] = $tag->get_id_option();
				$atts['tabindex'] = $tag->get_option( 'tabindex', 'signed_int', true );

				// If file is required
				if ( $tag->is_required() ) {
					$atts['aria-required'] = 'true';
				}

				// Set invalid attributes if there's validation error
				$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

				// Set input type and name
				$atts['type'] = 'file';
				$atts['multiple'] = 'multiple';
				$atts['data-name'] = $tag->name;
				$atts['data-type'] = $tag->get_option( 'filetypes','', true);
				$atts['data-limit'] = $tag->get_option( 'limit','', true);
				$atts['data-max'] = $tag->get_option( 'max-file','', true);
				$atts['data-id'] = ( $form->id() ? $form->id() : 0 );

                if( '' != $atts['data-type'] && ! wp_is_mobile() ) {
                    $types = explode('|', $atts['data-type'] );
                    $atts['accept'] = '.' . implode(', .', array_map( 'trim', $types ) );
                }

				// allow other plugins to add custom attributes
				$atts = apply_filters('dndmfu_cf7_tag_attributes', $atts, $tag );

				// Combine and format attrbiutes
				$atts = wpcf7_format_atts( $atts );

				// Return our element and attributes
				return sprintf('<span class="wpcf7-form-control-wrap" data-name="%1$s"><input %2$s />%3$s</span>',	sanitize_html_class( $tag->name ), $atts, $validation_error );
			}

			/**
			* Resize Image | @param : path & file_name
			*/

			protected function resize_image( $path, $file_name ) {

				if( ! $path || ! $file_name ) {
					return;
				}

				// Concat
				$new_file_path = untrailingslashit( $this->wp_upload_dir['basedir'] ) . $path . $file_name;
				$new_file = pathinfo( $file_name );
				$image_format = array('jpg','png','jpeg','gif','tif');
                
				// Call default image editor
				$image = wp_get_image_editor( $new_file_path );

				if ( ! is_wp_error( $image ) && in_array( strtolower( $new_file['extension'] ), $image_format ) ) {

					// Get image sizes.
					$orig_image = $image->get_size();

					// Make sure resize image option is not empty.
					if( $size = get_option('drag_n_drop_image_resize') ) {
						$size = explode('x', $size);
						if( $orig_image['width'] > $size[0] || $orig_image['height'] > $size[1] ) {
							$image->resize( $size[0], $size[1] );
						}
					}

					// Minor optimization
					$quality = ( get_option('drag_n_drop_image_quality') ? get_option('drag_n_drop_image_quality') : 82 );
					$image->set_quality( $quality );

                    // Fix image orientation
                    if( $image && file_exists( $new_file_path ) ) {
                        $image = dndmfu_fix_orientation( $new_file_path, $image );
                    }

					// Save image
					$final_image = $image->save( $new_file_path );

					// Return image path
					if( ! is_wp_error( $final_image ) ) {
						return untrailingslashit( $this->wp_upload_dir['baseurl'] ) . $path . $final_image['file'];
					}
				}

				return untrailingslashit( $this->wp_upload_dir['baseurl'] ) . $path . $file_name;
			}

			/**
			* Begin process ajax upload.
			*/

			public function dnd_upload_cf7_upload() {

				// Verify ajax none
				if( is_user_logged_in() ) {
					check_ajax_referer( 'dnd_cf7_ajax_upload', 'security' );
				}

				// Make sure upload directory is set
				if( ! empty( $_POST['upload_dir'] ) ) {
					// Set Directory/Path - where the files being stored.
					$this->_options['upload_dir'] = path_join( $this->wp_upload_dir['basedir'], trim( sanitize_text_field( $_POST['upload_dir'] ) ) );
				}

				// cf7 form id & upload name
				$cf7_id = sanitize_text_field( (int)$_POST['form_id']);

				// Get the name of upload field.
				$cf7_upload_name = sanitize_text_field( $_POST['upload_name'] );
				
				// input type file 'name'
				$name = 'upload-file';

				// Setup $_FILE name (from Ajax)
				$file = isset( $_FILES[$name] ) ? array_map( 'sanitize_text_field', $_FILES[ $name ] ) : null;
				
				// Custom name
				if( isset( $_POST['orig-name'] ) ) {
					$file['name'] = sanitize_text_field( $_POST['orig-name'] );
				}

				// Tells whether the file was uploaded via HTTP POST
				if ( ! is_uploaded_file( $file['tmp_name'] ) ) {
					$error_code = ( $file['error'] == 1 ? __('The uploaded file exceeds the upload_max_filesize limit.','dnd-upload-cf7') : $this->get_error_msg('failed_upload') );
					wp_send_json_error( dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ? dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') : $error_code  );
				}

				// Get allowed ext list @expected : png|jpeg|jpg
				$allowed_types = $this->allowed_types( $cf7_id );

				/* Get allowed extension */
				$supported_type = ( isset( $allowed_types["$cf7_upload_name"] ) ? $allowed_types["$cf7_upload_name"] : $this->default_ext() );

				/* File type validation */
				$file_type_pattern = dndmfu_cf7_filetypes( $supported_type );

				// Get file extension
				$extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

				// validate file type
				if ( ! preg_match( $file_type_pattern, $file['name'] ) || ! dndmfu_cf7_validate_type( $extension, $supported_type ) ) {
					wp_send_json_error( dnmfu_cf7_option('drag_n_drop_error_invalid_file') ? dnmfu_cf7_option('drag_n_drop_error_invalid_file') : $this->get_error_msg('invalid_type') );
				}

				// validate file size limit
				if( $file['size'] > (int)$_POST['size_limit'] ) {
					wp_send_json_error( dnmfu_cf7_option('drag_n_drop_error_files_too_large') ? dnmfu_cf7_option('drag_n_drop_error_files_too_large') : $this->get_error_msg('large_file') );
				}

				// Temporary TMP folder/dir
				$tmp_path = path_join( $this->wp_upload_dir['basedir'], $this->_options['tmp_folder'] );

				// Allow other plugin to change tmp_uploads path.
				$tmp_dir = apply_filters( 'dnd_cf7_tmp_folder', $tmp_path );

				// Get dir setup
				$base_dir = $this->dnd_get_dir_setup( $tmp_dir, true );

				// Create file name
				$filename = $file['name'];
				$filename = wpcf7_canonicalize( $filename, 'as-is' );
				$filename = wpcf7_antiscript_file_name( $filename );

				// Add filter on upload file name
				$filename = apply_filters( 'wpcf7_upload_file_name', $filename,	$file['name'] );

				// Generate new filename
				$filename = wp_unique_filename( $base_dir, $filename );
				$new_file = path_join( $base_dir, $filename );

				// Upload Files to Temporary Folder ( Only Files - NOT ZIP )
				if( $this->_options['zip_files'] !== true && $this->_options['save_to_media'] === true ) {
					$new_file = path_join( $tmp_dir, $filename );
				}

				// Php manual files upload
				if ( false === move_uploaded_file( $file['tmp_name'], $new_file ) ) {
					$error_upload = dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ? dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') : $this->get_error_msg('failed_upload');
					wp_send_json_error( $error_upload );
				}else{

					// Setup path and file name and add it to response.
					$path = trailingslashit( '/' . wp_basename( $base_dir ) );

					// Change file permission to 0400
					chmod( $new_file, 0644 );

					// Resize image
					if( get_option('drag_n_drop_image_resize') ) {
						$filename = $this->resize_image( $path, $filename );
					}

					// Get details of attachment from media_json_respons function
					$files = $this->_media_json_response( $path, wp_basename( $filename ) );

					// Send files to json response
					wp_send_json_success( $files );
				}

				die;
			}

			/**
			* Filter to modify body contents ( Only Attachment Links )
			*/

			public function dnd_upload_cf7_email_body( $files = array(), $use_html = false, $name, $type = 'link' ) {

				// Make sure we have files
				if( empty( $files ) || count( $files ) < 1 ) {
					return array();
				}

				$links = array();
				$plain = true;
                $zip_file = '';
                $response = '';

                // Get existing files
                $file_data = $this->get_files();

				// If attachment / both links & attachment option is checked.
				if( get_option('drag_n_drop_mail_attachment') == 'yes' || get_option('drag_n_drop_links_attachments') ) {
					$plain = false;
				}

				// ZIP files Option is enable
				if( $this->_options['zip_files'] === true ) {

					// Compressed/zip files
                    if( $file_data && isset( $file_data[ $name ] ) ) { //@existing data for mail(2)
					   $zip_file = $file_data[ $name ][0];
                    }else{
                        $zip_file = $this->dnd_zip_all_files( $files, $name );
                    }

					// If save to media option is set to yes
					if( $this->_options['save_to_media'] === true  && false !== $zip_file ) {
                        if( ! isset( $file_data[$name] ) ) {
                            $response = $this->dnd_save_to_media_library( $zip_file, $name ); // saving zipped files to media library
                            $zip_file = ( isset( $response['file'] ) ? $response['file'] : null ); 
                        }
					}

                    // Allow other plugin to override
                    $zip_file = apply_filters('dnd_cf7_zip_file_links', $zip_file );
                    
					// Setup html attributes (links)
					if( $zip_file ) {

						// assign zip file to $files variable
						$this->files[ $name ][0] = $zip_file;

						// Create anchor with filename links to attachment ( for zip & media )
						$links[] = ( $use_html ? '<a target="_blank" href="'.esc_url( $zip_file ).'">'.esc_html( wp_basename( $zip_file ) ).'</a>' : esc_html( $zip_file ) );

					}

				}else {

					// Generatee files links in email.
					foreach( $files as $index => $file_link ) {

						// If option is save to media library
						if( $this->_options['save_to_media'] === true ) {
                            if( $file_data && isset( $file_data[ $name ] ) ) { // @second loop on mail(2) - get existing data.
							    $file_link = $file_data[ $name ][ $index ];
                            }else {
                                $media = $this->dnd_save_to_media_library( $file_link, $name ); // saving all files to media library
							    $file_link = ( isset( $media['file'] ) ? $media['file'] : $file_link );    
                            }
						}

                        $file_link = apply_filters( 'dnd_cf7_file_links', $file_link );

						// assign individual file links to $files variable
						$this->files[ $name ][ $index ] = esc_url( $file_link );

						// Create anchor with filename links to attachment
                        if( is_array( $type ) && isset( $type['is_image'] ) && $type['is_image'] == 1 ) {
                            $width = ( isset( $type['size'][0] ) ? 'width="'. esc_attr( $type['size'][0] ) .'"' : '' );
                            $height = ( isset( $type['size'][1] ) ? 'height="'. esc_attr( $type['size'][1] ) .'"' : '');
                            $links[] = sprintf('<a href="%s"><img src="%s" %s %s /></a>', esc_url($file_link), esc_url($file_link), $width, $height );
                        }else {
                            $links[] = ( $use_html ? '<a target="_blank" href="'. esc_url($file_link).'">'. esc_html(wp_basename( $file_link )) .'</a>' : esc_html( $file_link ) );
                        }
					}

				}

				// Make a list
				if( is_array( $links ) && count( $links ) > 0 ) {
					return $links;
				}

				// return plain array without href attribute.
				if( isset( $this->files[ $name ] ) && $plain === true ) {
                    
                    // Add custom hook action
                    do_action( 'dndmfu_cf7_email_body_files',$this->files[ $name ] );

                    // Return files
					return $this->files[ $name ];
				}
			}

			/**
			* Hooks before sending mail / format url/links ( Append links to mail body ) (priority:1)
			*/

			public function dnd_cf7_before_send_mail( $wpcf7 ){

				// Check for submission
				if( WPCF7_Submission::get_instance() ) {

					// Get name of mfile only from fields array
					$tags = self::scan_tags( $wpcf7 );

					// Get form tags for upload
					$form = $wpcf7->scan_form_tags( array( 'type' => array('mfile', 'mfile*') ) );

					// Hooks - change filename/folder before sending...
					do_action( 'dnd_cf7_mail_setup_data', $tags );

					// Get posted data
					$submitted = $this->get_posted_data();

					// Prop email
					$mail = $wpcf7->prop('mail');
					$mail_2 = $wpcf7->prop('mail_2');

					// An array contents file full path.
					$files = array();

                    // If zip all the files
                    $zip_all = ( ( get_option('drag_n_drop_zip_combine') && $this->_options['zip_files'] ) ? true : false );

					// Loop fields and replace mfile code
					if( $tags && is_array( $tags ) ) {
						foreach( $tags as $name ){
							if( isset( $submitted[ $name ] ) && ! empty( $submitted[ $name ] ) ) {
								// Allow plugins to override and modify email body contents
								if( is_array( $submitted[ $name ] ) && count( $submitted[ $name ] ) > 0 ) {
                                    
                                    /**
                                    * @description : Combine all files into one zip if more than one upload field.
                                    */

                                    if( $zip_all === true ) {
                                        foreach( $submitted[ $name ] as $single_file ) {
                                            $this->files[$name][] = esc_url( $single_file ); // get the file full path url
                                        }
                                        continue; // skip early
                                    }

                                    /**
                                     * @description : Check If not send attachment as links OR both links & attachment
                                     * @return : html array
                                     */
                                   
                                    /* Start - Mail Body 1 */
                                        // Parse email get img tags
                                        $mail_img_tags = dndmfu_cf7_parse_email( $name, $mail['body'] );
                                        $replaced_tag = ( isset( $mail_img_tags['replaced_tag'] ) ? $mail_img_tags['replaced_tag'] : "[$name]" );
                                        $files = $this->dnd_upload_cf7_email_body( $submitted[ $name ], $mail['use_html'], $name, $mail_img_tags );

                                        // Setup mail body with links
                                        if( $files && count( $files ) > 0 ) {
                                            $mail['body'] = str_replace( "$replaced_tag", "\n" . implode( "\n", $files ), $mail['body'] );
                                        }

                                    /* End - Mail Body 1 */

                                    /* Start - Mail Body 2 */
                                        if( $mail_2['active'] ) {
                                            $mail2_img_tags = dndmfu_cf7_parse_email( $name, $mail_2['body'] );
                                            $replaced_tag = ( isset( $mail2_img_tags['replaced_tag'] ) ? $mail2_img_tags['replaced_tag'] : "[$name]" );
                                            $files2 = $this->dnd_upload_cf7_email_body( $submitted[ $name ], $mail['use_html'], $name, $mail2_img_tags );

                                            // Setup mail body with links
                                            if( $files2 && count( $files2 ) > 0 ) {
                                                $mail_2['body'] = str_replace( "$replaced_tag", "\n" . implode( "\n", $files2 ), $mail_2['body'] );
                                            }
                                        }
                                    /* End - Mail Body 2 */

								}
							}
						}
					}
                    
                    // Zip all files (combine files)
                    if( $zip_all === true && get_option('drag_n_drop_mail_attachment') == 'yes' ) {
                        if( $this->files && count($this->files) > 0 ) {
                            
                            $random_name = $this->dnd_special_tags('random'); // generate random numbers
                            $for_zip = array();

                            // Extract and prepare files
                            foreach( $this->files as $name => $files ) {
                                foreach( $files as $file ) {
                                    $for_zip[] = $file;
                                }
                            }

                            // Make sure we files to zip
                            if( $for_zip ) {
                                // Begin to zip all files (return single url: http://example.com/wp-content/uploads/file.zip)
                                $zipped_file = $this->dnd_zip_all_files( $for_zip, $random_name . time() );
                                
                                // Check if saving zip to media library
                                if( $this->_options['save_to_media'] === true  && false !== $zipped_file ) {
                                    $response = $this->dnd_save_to_media_library( $zipped_file ); // saving zipped files to media library
                                    $zipped_file = ( isset( $response['file'] ) ? $response['file'] : null ); 
                                }
                                
                                if( $zipped_file ) {

                                    // Format links wheather html or plain text ( <a href="">file.zip</a> | file.zip )
                                    $file_link = ( $mail['use_html'] ? '<a target="_blank" href="'.esc_url( $zipped_file ).'">'.esc_html( wp_basename( $zipped_file ) ).'</a>' : esc_html( $zipped_file ) );

                                    // Loop all upload files
                                    if( $tags && is_array( $tags ) ) {
                                        foreach( $tags as $upload_name ) {

                                            // Replaced upload tag with zip file link
                                            $mail['body'] = str_replace( "[$upload_name]", "\n" . $file_link, $mail['body'] );

                                            // If mail2 is active replace also the tag
                                            if( $mail_2['active'] ) {
                                                $mail_2['body'] = str_replace( "[$upload_name]", "\n" .$file_link, $mail_2['body'] );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

					// Save the email body
					$wpcf7->set_properties( array("mail" => $mail) );

					// if mail 2
					if( $mail_2['active'] ) {
						$wpcf7->set_properties( array("mail_2" => $mail_2) );
					}
				}
                
                // For debugging
                if( $this->debug ) {
                   $this->log($mail['body']);
                   $this->log($mail_2['body']);
                }
                
				// For Debugging
				if( $this->debug == true ) {
					wp_mail( get_option('drag_n_drop_debug_email'), get_bloginfo( 'name' ) .' - Debug Before Send', print_r( $mail, true ) );
				}

				return $wpcf7;
			}

			/**
			* filter - Custom cf7 Mail components ( For attachment - only ) (priority:2)
			*/

			public function dnd_cf7_mail_components( $components, $form ) {

				if( ! $form ) {
					return;
				}

				// Send email link as an attachment.
				if( get_option('drag_n_drop_mail_attachment') == 'yes' && get_option('drag_n_drop_links_attachments') == '' ) {
					return $components;
				}

				// Get all files ( zip, media files etc... )
				$posted_files = $this->get_files();

                // Cotainer for all the files that about to zip
                $zip_components = array();

                // If combine all files in one zip is check
                $zip_all = ( ( get_option('drag_n_drop_zip_combine') && $this->_options['zip_files'] ) ? true : false );

				// Check & return if there are no files...
				if( false === $posted_files ) {
					return $components;
				}

                // Get name of mfile only from fields array
				$tags = self::scan_tags( $form );

				// Delay for 10 seconds (allow saving to media & zip files) @todo - need to find another way.
				if( get_option('drag_n_drop_links_attachments') && $this->counter == 0 && $this->_options['zip_files'] === true ) {
					sleep(10);
				}

				// cf7 - Submission Object
				if( WPCF7_Submission::get_instance() ) {

					// Get mail,mail_2 attachment [tags]
					$additional_mail = apply_filters( 'dnd_cf7_additional_mail', array('mail','mail_2'), $form );

					// Props data object
					$props_mail = array();

					// Loop additional mail
					foreach( $additional_mail as $single_mail ) {
						$props_mail[] = $form->prop( $single_mail );
					}

					// Get email attachments (mail, mail_2)
					$mail = $props_mail[ $this->counter++ ];

					// If mail is active & have attachment
					if( $mail && $mail['active'] && $mail['attachments'] && $posted_files ) {
						if( $tags && is_array( $tags ) ) {

							// Loop fields get mfile only.
							foreach( $tags as $name ) {

								// Get posted data
								$posted_data = $this->get_posted_data();
                                
								// Make sure we have files to attach
								if( isset( $posted_data[ $name ] ) && count( $posted_data[ $name ] ) > 0 ) {

									// Check and make sure [upload-file-xxx] exists in attachments - fields
									if ( false !== strpos( $mail['attachments'], "[{$name}]" ) ) {

										// Attach files to components...
										if( $posted_files && isset( $posted_files[ $name ] ) && count( $posted_files[ $name ] ) > 0  ) {
											foreach( $posted_files[ $name ] as $file ) {
												if( file_exists( self::convert_url( $file ) ) ) {

                                                    /**
                                                    * @description : Combine all files into one zip if more than one upload field. (bail early)
                                                    */

                                                    if( $zip_all === true ) {
                                                        $zip_components[] = $file; // merge all files from individual file upload
                                                        continue;
                                                    }

                                                    // Asign single file path into components
													$components['attachments'][] = self::convert_url( $file );

												}
											}
										}

									} // end - strpos check

								} // end if - posted_data

							} // end - foreach

                            /**
                            * @description : Attach zip in components only if ZIP all is checked.
                            */

                            if( $zip_all === true ) {

                                // Zip all file - url
                                if( $zip_components ) {
                                    // Generate random name for zip
                                    $random_name = $this->dnd_special_tags('random');

                                    // Zip all the files
                                    $zipped_file = $this->dnd_zip_all_files( $zip_components, $random_name . time() );

                                    // Check if saving zip to media library
                                    if( $this->_options['save_to_media'] === true  && false !== $zipped_file ) {
                                        $response = $this->dnd_save_to_media_library( $zipped_file ); // saving zipped files to media library
                                        $zipped_file = ( isset( $response['file'] ) ? $response['file'] : null ); 
                                    }
                                }

                                // If has existing zip 
                                if( $this->zip_files ) {
                                    $zipped_file = $this->zip_files;
                                }

                                // Add zip to attachments - about to send
                                if( $zipped_file ) {

                                    // Store zip files
                                    $this->zip_files = $zipped_file;

                                    // Attach to components
                                    $components['attachments'][] = self::convert_url( $zipped_file );
                                }

                            }

						}
					}

				}
                
				// For Debugging purposes
				if( $this->debug == true ) {
                    
                    // For debugging
                    $this->log( $components );

                    // Mail debug details
					wp_mail( get_option('drag_n_drop_debug_email'), get_bloginfo( 'name' ) .' - Debug Components', print_r( $components, true ) );
				}

				// Return setup components
				return $components;
			}

			/**
			* Begin process ajax chunks upload.
			*/

			public function dnd_upload_cf7_upload_chunks() {

				// Verify ajax none
				if( is_user_logged_in() ) {
					check_ajax_referer( 'dnd_cf7_ajax_upload', 'security' );
				}

				$total_chunks = ( isset( $_POST['total_chunks'] ) ? (int)$_POST['total_chunks'] : '' );
				$num = ( isset( $_POST['chunk'] ) ? (int)$_POST['chunk'] + 1 : '' );
				$chunk_size = ( isset( $_POST['chunk_size'] ) ? sanitize_text_field( $_POST['chunk_size'] ) : '' );

				// Setup basedir `tmp_upload/chunks` folder for chunks files
				$tmp_folder = apply_filters('dndcf7_chunks_path', path_join( $this->wp_upload_dir['basedir'], $this->_options['tmp_folder'] .'/chunks/' ) );

				// create tmp directory - if not exist
				if( ! is_dir( $tmp_folder ) ) {
					wp_mkdir_p( $tmp_folder );
				}

				// input type file 'name'
				$name = 'chunks-file';

				// Setup $_FILE name (from Ajax)
				$file = isset( $_FILES[$name] ) ? array_map( 'sanitize_text_field', $_FILES[ $name ] ) : null;

				// File Info
				$tmp_name = $file['tmp_name'];

				/**
				* File Types - Validation
				*/

				$cf7_id 			= sanitize_text_field( (int)$_POST['form_id']); 	//cf7 form id & upload name
				$cf7_upload_name 	= sanitize_text_field( $_POST['upload_name'] ); 	//Get the name of upload field.
				$allowed_types 		= $this->allowed_types( $cf7_id ); 					//Get allowed ext list @expected : png|jpeg|jpg
				$supported_type 	= ( isset( $allowed_types["$cf7_upload_name"] ) ? $allowed_types["$cf7_upload_name"] : $this->default_ext() );
				$file_type_pattern 	= dndmfu_cf7_filetypes( $supported_type );

				// Get file extension
				$extension = strtolower( pathinfo( $file['name'], PATHINFO_EXTENSION ) );

				// validate file type
				if ( ! preg_match( $file_type_pattern, $file['name'] ) || ! dndmfu_cf7_validate_type( $extension, $supported_type ) ) {
					wp_send_json_error( dnmfu_cf7_option('drag_n_drop_error_invalid_file') ? dnmfu_cf7_option('drag_n_drop_error_invalid_file') : $this->get_error_msg('invalid_type') );
				}

				// File unique index
				$file_index = sanitize_text_field( wp_unslash( $_POST['unique'] ) );

				// Check if file exists then add increment number on filename.
				$filename = wp_unique_filename( $tmp_folder, $file['name'] );

				// New Filename for chunks
				$new_file_name = $file_index . '-chunk-' . $num .'-'. $filename;

				// Tells whether the file was uploaded via HTTP POST
				if ( ! is_uploaded_file( $tmp_name ) ) {
					$error_code = ( $file['error'] == 1 ? __('The uploaded file exceeds the upload_max_filesize limit.','dnd-upload-cf7') : $this->get_error_msg('failed_upload') );
					wp_send_json_error( dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ? dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') : $error_code  );
				}

				//@todo - validate file size if chunks > server_max_upload limit

				if ( false === move_uploaded_file( $tmp_name, $tmp_folder . $new_file_name ) ) {
					$error_upload = dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ? dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') : $this->get_error_msg('failed_upload');
					wp_send_json_error( $error_upload );
				}

				// Process merging files
				if( $num == $total_chunks ) {

					// Make sure upload directory is set
					if( ! empty( $_POST['upload_dir'] ) ) {
						$upload_dir = trim( sanitize_text_field( $_POST['upload_dir'] ) );
					}

					// Final dir for merging files
					$final_chunks_path = apply_filters( 'dndcf7_final_chunks_path', path_join( $this->wp_upload_dir['basedir'], $upload_dir .'/' ) );

					// Create unique filename
					$chunks_name = apply_filters( 'wpcf7_upload_file_name', $filename,	$file['name'] );

					// Final - name of chunk
					$chunk_unique_name = wp_unique_filename( $final_chunks_path, $chunks_name );

					// Create base dir if it's not yet created
					if( ! is_dir( $final_chunks_path ) ) {
						wp_mkdir_p( $final_chunks_path );
					}

					// Begin merging files and loop chunks
					for( $i = 1; $i <= $total_chunks; $i++ ) {
						$chunk_name = $tmp_folder . $file_index . '-chunk-' . $i .'-'. $filename;
						if( file_exists( $chunk_name ) ) {

							// Open chunks file ( rb - read binary )
							$chunk_file = fopen( $chunk_name, 'rb');
							if( $chunk_file ) {
								$read_file_chunks = fread( $chunk_file, $chunk_size );
								fclose( $chunk_file );
							}

							// Make sure path is writable - write final files
							if( is_writable( $final_chunks_path ) && $read_file_chunks == true ) {
								$final_file = fopen( $final_chunks_path . $chunk_unique_name, 'ab' );
								if( $final_file ) {
									$write = fwrite( $final_file, $read_file_chunks );
                                    unset( $read_file_chunks );
									fclose( $final_file );
									@chmod( $final_chunks_path . $chunk_unique_name, 0644 );
								}
							}

							// Remove chunks file
							unlink( $chunk_name );
						}
					}

					// Done merging - return files details
					if( file_exists( $final_chunks_path . $chunk_unique_name ) ) {

						//Trim path
						$path = trailingslashit( '/' . wp_basename( $final_chunks_path ) );

						// Resize image
						if( get_option('drag_n_drop_image_resize') ) {
							$image = $this->resize_image( $path, $chunk_unique_name );
						}

						// Get details of attachment from media_json_respons function
						wp_send_json_success( $this->_media_json_response( $path, $chunk_unique_name ) );
					}
				}

				// Return part chunks
				if( file_exists( $tmp_folder . $new_file_name ) ) {
					wp_send_json_success( array('partial_chunks' => $new_file_name ) );
				}

				die;
			}

			/**
			* Log - for debugging only
			*/

			public function log( $message, $email = false ) {
				$file = fopen( $this->wp_upload_dir['basedir']."/logs.txt", "a") or die("Unable to open file!");
				fwrite( $file, "\n". ( is_array( $message ) ? print_r( $message, true ) : $message ) );
				fclose( $file );
			}

			/**
			* Convert URL to DIR or DIR to URL
			*/

			public static function convert_url( $string, $dir = false ) {
				$blog_id = get_current_blog_id();
                $is_ssl = ( is_ssl() ? 'https' : 'http' );
                $abs_path = ( defined('WP_CONTENT_DIR') ? dirname( WP_CONTENT_DIR ) . '/' : ABSPATH );
				if( false === $dir && $string ) {
					return str_replace( trailingslashit( get_site_url( $blog_id, '', $is_ssl ) ), wp_normalize_path( $abs_path ), $string );
				}else {
					return str_replace( wp_normalize_path( $abs_path ), trailingslashit( get_site_url( $blog_id, '', $is_ssl ) ), $string );
				}
			}

			/**
			* Get dir setup
			*/

			public function dnd_get_dir_setup( $directory = null, $create = false ) {

				// check send as links attachment settings & zip file option
				if( get_option('drag_n_drop_mail_attachment') == 'yes' || ( get_option('drag_n_drop_mail_attachment') == 'yes' && $this->_options['zip_files'] === true ) ) {
					$directory = $this->_options['upload_dir'];
				}

				// Create dir
				if( $create ) {
					if( ! is_dir( $directory ) ) {
						wp_mkdir_p( $directory );
					}
					if( file_exists( $directory ) ) {
						return $directory;
					}
				}

				// Get current IDR
				return $directory;
			}

			/**
			* Begin : Load js and css
			*/

			public function dnd_cf7_scripts() {
				// Get plugin version
				$version = dnd_upload_cf7_version;

				// enque script
				wp_enqueue_script( 'codedropz-uploader', plugins_url ('/assets/js/codedropz-uploader-min.js',dirname(__FILE__)), array('jquery','contact-form-7'), $version, true );
				wp_enqueue_script( 'dnd-upload-cf7', plugins_url ('/assets/js/dnd-upload-cf7.js', dirname(__FILE__)), array('jquery','codedropz-uploader','contact-form-7'), $version, true );

                // Localize Options
                $localize_options = apply_filters('dnd_cf7_localize_options', 
                    array(
						'ajax_url' 				=> admin_url( 'admin-ajax.php' ),
						'nonce'					=>	wp_create_nonce('dnd_cf7_ajax_upload'),
						'drag_n_drop_upload' 	=> array(
							'text'				=>	( dnmfu_cf7_option('drag_n_drop_text') ? dnmfu_cf7_option('drag_n_drop_text') : __('Drag & Drop Files Here','dnd-upload-cf7') ),
							'or_separator'		=>	( dnmfu_cf7_option('drag_n_drop_separator') ? dnmfu_cf7_option('drag_n_drop_separator') : __('or','dnd-upload-cf7') ),
							'browse'			=>	( dnmfu_cf7_option('drag_n_drop_browse_text') ? dnmfu_cf7_option('drag_n_drop_browse_text') : __('Browse Files','dnd-upload-cf7') ),
							'server_max_error'	=>	( dnmfu_cf7_option('drag_n_drop_error_server_limit') ? dnmfu_cf7_option('drag_n_drop_error_server_limit') : $this->get_error_msg('server_limit') ),
							'large_file'		=>	( dnmfu_cf7_option('drag_n_drop_error_files_too_large') ? dnmfu_cf7_option('drag_n_drop_error_files_too_large') : $this->get_error_msg('large_file') ),
							'invalid_type'		=>	( dnmfu_cf7_option('drag_n_drop_error_invalid_file') ? dnmfu_cf7_option('drag_n_drop_error_invalid_file') : $this->get_error_msg('invalid_type') ),
						),
						'parallel_uploads'		=>	( get_option('drag_n_drop_parallel_uploads') ? get_option('drag_n_drop_parallel_uploads') : 2 ),
						'max_total_size'		=>	( get_option('drag_n_drop_max_total_size') ? get_option('drag_n_drop_max_total_size') : '100MB' ),
						'chunks'				=>	( get_option('drag_n_drop_chunks_upload') ? true : false ),
						'chunk_size'			=>	( get_option('drag_n_drop_chunk_size') ? get_option('drag_n_drop_chunk_size') : 10000 ),
						'err_message'			=>	array(
							'maxNumFiles'			=>	dnmfu_cf7_option('drag_n_drop_error_max_files') ? dnmfu_cf7_option('drag_n_drop_error_max_files') : $this->get_error_msg('maxNumFiles'),
							'maxTotalSize'			=>	dnmfu_cf7_option('drag_n_drop_error_size_limit') ? dnmfu_cf7_option('drag_n_drop_error_size_limit') : $this->get_error_msg('maxTotalSize'),
							'maxUploadLimit'		=>	dnmfu_cf7_option('drag_n_drop_error_max_upload_limit') ? dnmfu_cf7_option('drag_n_drop_error_max_upload_limit') : $this->get_error_msg('maxUploadLimit')
						),
						'heading_tag'				=>	get_option('drag_n_drop_heading_tag') ? get_option('drag_n_drop_heading_tag') : 'h3',
						'disable_btn_submission'	=>	get_option('drag_n_drop_disable_btn'),
						'preview_layout'			=>	get_option('drag_n_drop_thumbnail_display'),
                        'image_preview'             =>  $this->_options['preview_image'],
						'dnd_text_counter'			=>	dnmfu_cf7_option('drag_n_drop_of_counter_text') ? dnmfu_cf7_option('drag_n_drop_of_counter_text') : __('of','dnd-upload-cf7'),
						'delete_text'				=>	dnmfu_cf7_option('drag_n_drop_delete_text') ? dnmfu_cf7_option('drag_n_drop_delete_text') : __('Deleting...','dnd-upload-cf7'),
						'remove_text'				=>	dnmfu_cf7_option('drag_n_drop_remove_text') ? dnmfu_cf7_option('drag_n_drop_remove_text') : __('Remove','dnd-upload-cf7'),
                        'delete_files_on_failed'    =>  get_option('drag_n_drop_on_failed_delete_files', 1 ),
					)
                );

				//  registered script with data for a JavaScript variable.
				wp_localize_script( 'dnd-upload-cf7', 'dnd_cf7_uploader', $localize_options );

				// enque style
				wp_enqueue_style( 'dnd-upload-cf7', plugins_url ('/assets/css/dnd-upload-cf7.css', dirname(__FILE__) ), '', $version );
			}

            /**
			* Get media library files
			*/

            public function get_media_files() {
                return $this->media_files;
            }

			/**
			* Upload File and Save to Media Libray
			*/

			public function dnd_save_to_media_library( $files = array(), $name = null ) {

				// Response status
				$response = array();

				// Required wordpress file and image library
				if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) {
					require_once( ABSPATH . 'wp-admin/includes/image.php' );
					require_once( ABSPATH . 'wp-admin/includes/media.php' );
				}

				// Check if $_Files is not empty
				if( empty( $files ) ) {
					$response['error'] = ( dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ? dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') : $this->get_error_msg('failed_upload') );
				}

				// Wordpress upload directory - path & url
				$_dir = $this->wp_upload_dir;

				// Get file name / convert from url to basedir
				$filename = str_replace( $_dir['baseurl'], wp_normalize_path( $_dir['basedir'] ), $files );
				$filetype = wp_check_filetype( basename( $filename ), null );
				$thumbnail = pathinfo( $filename );
				$upload_dir = wp_upload_dir();

				// Manually move to wp_upload directory
				if( file_exists( $filename ) ) {
					if( rename( $filename , $upload_dir['path'] .'/'. basename( $filename ) ) ) {
						$filename = $upload_dir['path'] .'/'. basename( $filename );
					}
				}

				// Prepare an array of post data for the attachment.
				$attachment = array(
					'guid'           => $upload_dir['url'] . '/' . basename( $filename ),
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);

				// Insert the attachment.
				$attachment_id = wp_insert_attachment( $attachment, $filename, 0, true );

				// // Check status of upload if it's success or not
				if ( ! is_wp_error( $attachment_id ) ) {

					// Generate metadata for attachment
					$attach_data = wp_generate_attachment_metadata( $attachment_id, $filename );

					// Update database record for meta data information
					wp_update_attachment_metadata( $attachment_id, $attach_data );

					// get attachment meta data
					$attachment = wp_get_attachment_url( $attachment_id );

					// Assign response
					$response['file'] = $attachment;

                    // Store media files
                    if( $name ){
                        $this->media_files[ $name ][] = $attachment;
                    }else{
                        $this->media_files[] = $attachment;
                    }

					// Covert base_url to base_dir
					$file_path =  $thumbnail['dirname'] .'/'. $thumbnail['filename'] .'-100x100.' . strtolower( $thumbnail['extension'] );

					// Update post_meta
					update_post_meta( $attachment_id, '_dndmfu_cf7_file_upload', 'yes' );

					// Remove files & thumbnail
					if( file_exists( $file_path ) ) {
						$this->delete_files( $file_path );
					}

                    // Allow theme/plugins to hook
                    do_action('dndmfu_cf7_after_media_saved', $attachment_id );

				}else {
					$response['error']= ( $attachment_id->get_error_message() ? $attachment_id->get_error_message() : get_option('drag_n_drop_error_failed_to_upload') );
				}

				return $response;
			}

			/**
			* Setup and Zip Attachment
			* @param : files - baseurl
			*/

			public function dnd_zip_all_files( $files, $name = null ) {

				// Make sure we have files
				if( empty( $files ) ) {
					return false;
				}

				// Concat base and default dir
				$get_dir = current( $files );
				if( $get_dir ) {
					$dir_path = dirname( self::convert_url( $get_dir ) );
				}

				// Setup dir and begin to create .zip file
				$zip = new ZipArchive;

				// Setup zip name combine ( date + unique_id + file-name )
				$_generated_name = sanitize_text_field( trim( $_POST['generate_name'] ) );

				// Special custom tags ( user information, random, ip-address, time )
				$tags = $this->dnd_special_tags();

				// Allow user to modify name ( original filename, tags )
				$archive_name =  apply_filters( 'dnd_cf7_archive_name', substr( $_generated_name .'-'. md5( $name ), 0, 40 ), $tags, $name );

				// Create unique name
				$generated_name = wp_unique_filename( trailingslashit( $dir_path ), $archive_name .'.zip' );

				// new zip name
				$zip_name = trailingslashit( $dir_path ) . $generated_name;

				// check if zip files already created.
				$exists = ( file_exists( $zip_name ) ? ZipArchive::OVERWRITE : ZipArchive::CREATE );

				// Open zip file
				if ( $zip_open = $zip->open( $zip_name , $exists ) === TRUE ) {
					foreach( $files as $file ) {
						// zip only the files that are exists.
						$for_zip_file = self::convert_url( $file );

						if( file_exists( $for_zip_file ) ) {
							$zip->addFile( $for_zip_file , wp_basename( $for_zip_file ) );
						}
					}
				}

				// Closing zip
				$zip->close();

				// Return whole path of zip
				if( $zip_open && file_exists( $zip_name ) ) {

					// Delete temporary files
					$this->dnd_delete_wp_files( $files );

					// Convert basedir to baseurl
					$zip_file[ $name ] = self::convert_url( $zip_name, true );

                    // Add Custom Hook
                    do_action('dndmfu_cf7_after_zipped', $zip_file );

					// Return zip url
					return $zip_file[ $name ];

				}else {
					return false;
				}
			}

			/**
			* Unlink or delete files
			*/

			public function dnd_delete_wp_files( $files ) {
				if( count( $files ) > 0 ) {

					// Loop array files
					foreach( $files as $_file ) {

						// Check valid filename & extensions
						if( preg_match_all('/wp-|(\.php|\.exe|\.js|\.phtml|\.cgi|\.aspx|\.asp|\.bat)/', wp_basename( $_file ) ) ) {
							return;
						}

						// Convert DIR to URL
						$file = str_replace( $this->wp_upload_dir['baseurl'], wp_normalize_path( $this->wp_upload_dir['basedir'] ), $_file );

						// Finally delte files from server.
						$this->delete_files( $file );
					}

				}
			}

			/**
			* Setup media file on json response after the successfull upload.
			*/

			public function _media_json_response( $path, $file_name ) {

				// Default placeholder
				$preview = false;

				// Match to images ext
				$is_image = preg_match( '/\.(jpg|jpeg|png|gif|tiff|svg )$/i', $file_name );

                // Get file type
                $file_type = wp_check_filetype( $file_name );

                // Apply preview on images only
				if( $this->_options['preview_image'] ) {
                    $preview = ( $is_image ? true :  wp_mime_type_icon( $file_type['type'] ) );
				}

				$media_files = array(
					'path'		=>	$path,
					'file'		=>	$file_name,
					'preview'	=>	$preview
				);

				// Display column for preview image
				if( get_option('drag_n_drop_thumbnail_display') == 'column' ) {
					$media_files['is_image'] = ( $is_image ? true : false );
					$media_files['ext'] = pathinfo( $file_name, PATHINFO_EXTENSION  );
					if( ! $is_image ) {
						$media_files['preview'] = wp_mime_type_icon( $file_type['type'] );
					}
				}

				return $media_files;
			}

			/**
			* create admin settings
			*/

			public function dnd_admin_settings() {
				add_submenu_page( 'wpcf7', 'Drag & Drop Uploader - Settings', 'Drag & Drop Upload', 'manage_options', 'drag-n-drop-upload',array( $this, 'dnd_upload_admin_settings') );
				add_action('admin_init', array( $this, 'dnd_upload_register_settings') );
			}

			/**
			* Callable functions display HTML admin settings
			*/

			public function dnd_upload_admin_settings( ) {
				if( file_exists( dnd_upload_cf7_directory .'/inc/admin/dnd-admin-settings.php' ) ) {
					include_once( wp_normalize_path( dnd_upload_cf7_directory .'/inc/admin/dnd-admin-settings.php' ) );
				}
			}

			/**
			* Default error message
			*/

			public function get_error_msg( $error_key ) {
				// return error message based on $error_key request
				if( isset( $this->error_message[$error_key] ) ) {
					return $this->error_message[$error_key];
				}
				return false;
			}

			/**
			* Load plugin text-domain
			*/

			public function dnd_load_plugin_textdomain() {
				load_plugin_textdomain( 'dnd-upload-cf7', false, dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages' );
			}

			/**
			* Get Posted Data
			*/

			public function get_posted_data() {
				if( self::get_cookie('posted_data') ) {
					return self::get_cookie('posted_data');
				}else {
					return $this->posted_data;
				}
			}

			/**
			* Get files ( media, zip, etc )
			*/

			public function get_files() {
				if( count( $this->files ) > 0 ) {
					return $this->files;
				}
				return false;
			}

			/**
			* Set Custom Cookie/Session - setcookie may delay
			* @ param : name(string), value(array), expire(2hours)
			*/

			private static function set_cookie( $name, $value, $expire = 7200 ) {
				$_SESSION[ $name ] = ( is_array( $value ) ? maybe_serialize( $value ) : $value );
			}

			/**
			* Get Cookie/Session
			* @ param : name (string)
			* @ return : array or string
			*/

			private static function get_cookie( $name ) {
				if( isset( $_SESSION[ $name ] ) ) {
					return ( is_serialized( $_SESSION[ $name ] ) ? maybe_unserialize( stripslashes( $_SESSION[ $name ] ) ) : $_SESSION[ $name ] );
				}
				return false;
			}

			/**
			* Delete Cookie/Session
			* @ param : name(string)
			*/

			private static function delete_cookie( $name ) {
				if( isset( $_SESSION[ $name ] ) ) {
					unset( $_SESSION[ $name ] );
					$_SESSION[ $name ] = '';
				}
			}

			/**
			* Save admin settings
			*/

			public function dnd_upload_register_settings() {
				$tab_active = ( isset( $_POST['drag_n_drop_tab_active'] ) ? $_POST['drag_n_drop_tab_active'] : false );
                $lang = dndmfu_cf7_lang();

				$settings['uploader-info'] = array('drag_n_drop_heading_tag','drag_n_drop_text'.$lang,'drag_n_drop_separator'.$lang,'drag_n_drop_browse_text'.$lang,'drag_n_drop_border_color','drag_n_drop_of_counter_text'.$lang,'drag_n_drop_delete_text'.$lang,'drag_n_drop_remove_text'.$lang);
				$settings['error-message'] = array('drag_n_drop_error_server_limit'.$lang,'drag_n_drop_error_failed_to_upload'.$lang,'drag_n_drop_error_files_too_large'.$lang,'drag_n_drop_error_invalid_file'.$lang,'drag_n_drop_error_min_file'.$lang,'drag_n_drop_error_max_files'.$lang,'drag_n_drop_error_max_upload_limit'.$lang,'drag_n_drop_error_size_limit'.$lang);
				$settings['chunks-settings'] = array('drag_n_drop_parallel_uploads','drag_n_drop_chunks_upload','drag_n_drop_chunk_size','drag_n_drop_max_total_size');
				$settings['pro-features'] = array('drag_n_drop_file_amend','drag_n_drop_file_ammend_forms','drag_n_drop_upload_dir','drag_n_drop_mail_attachment','drag_n_drop_save_to_media','drag_n_drop_links_attachments','drag_n_drop_folder_option','drag_n_drop_cf7_folder','drag_n_drop_custom_folder','drag_n_drop_dynamic_folder','drag_n_drop_zip_files','drag_n_drop_zip_combine','drag_n_drop_zip_name','drag_n_drop_delete_options','drag_n_drop_on_failed_delete_files');
				$settings['image-optimization'] = array('drag_n_drop_image_resize','drag_n_drop_image_quality','drag_n_drop_show_img_preview','drag_n_drop_thumbnail_display','drag_n_drop_thumbnail_column');
				$settings['other-features'] = array('drag_n_drop_disable_btn','drag_n_drop_hide_counter');
				$settings['color-options'] = array('drag_n_drop_color_progressbar','drag_n_drop_color_filename','drag_n_drop_color_delete','drag_n_drop_color_filesize');
				$settings['debug'] = array('drag_n_drop_debug','drag_n_drop_debug_email');

				if( $tab_active && isset( $settings[ $tab_active ] ) ) {
					foreach( $settings[ $tab_active ] as $option ) {
                        if( $option == 'drag_n_drop_file_ammend_forms' ) {
							register_setting( 'drag-n-drop-upload-file-cf7', 'drag_n_drop_file_ammend_forms',  array('type' => 'array'));	
						}else {
                            register_setting( 'drag-n-drop-upload-file-cf7', $option, 'sanitize_text_field');
						}
					}
				}
			}

			/**
			* Setup Sepcial Tags
			*/

			public function dnd_special_tags( $name = null ) {

				// List of all special tags
				$tags = array(
					'username'		=>	$this->user ? sanitize_title( $this->user->user_login ) : null,
					'name'			=>	$this->user ? sanitize_title( $this->user->display_name ) : null,
					'user_id'		=>	$this->user ? $this->user->ID : null,
					'ip_address'	=>	dndmfu_cf7_get_user_ip(),
					'random'		=>	mt_rand(1000,9999),
					'date'			=>	$this->get_date('m-d-y'),
					'time'			=>	time(),
					'filename'		=>	null,
					'post_id'		=>	null,
					'post_slug'		=>	null
				);

				// Allow other plugin,user to add or modify tags
				$tags = apply_filters('dnd_cf7_special_tags', $tags );

				// Get and return specific tag
				if( $name && isset( $tags[ $name ] ) ) {
					return $tags[ $name ];
				}

				return $tags;
			}

			/**
			* Get mfile,mfile* (name attributes) from Contact Form 7 Fields
			*/

			protected static function scan_tags( $form ) {

				// Check if not valid object and null
				if( ! $form && ! is_object( $form ) ) {
					return false;
				}

				// Get mfile,mfile* array from cf7 fields
				$fields = $form->scan_form_tags( array( 'type' => array('mfile', 'mfile*') ) );

				// Get name only from array
				$tags = ( is_array( $fields ) && count( $fields ) > 0 ) ? wp_list_pluck( $fields, 'name' ) : false;

				return $tags;
			}

			/**
			* Get current time based on GMT selected
			*/

			public function get_date( $format ) {
				$string = date( 'Y-m-d H:i:s' );
				return get_date_from_gmt( $string, $format );
			}

			/**
			* Get allowed file types @param : form_id
			*/

			public function allowed_types( $form_id ) {

				// Initialize contact form instance
				$form = WPCF7_ContactForm::get_instance( $form_id );

				// Check if not valid object and null
				if( ! $form && ! is_object( $form ) ) {
					return false;
				}

				// Get specific tag (mfile is for dnd file upload)
				$tags = $form->scan_form_tags( array( 'type' => array('mfile', 'mfile*') ) );
				$supported_types = array();

				// Loop all upload tags
				if( $tags && is_array( $tags ) ) {
					foreach( $tags as $tag ) {

						// Get file types option & remove not allowed character..
						$types = preg_replace( '/[^a-zA-Z0-9|\']/', '', $tag->get_option('filetypes','', true ) );

						// Assign if filetypes is present otherwise use the default ext list.
						$supported_types[ $tag->name ] = ( $types ? $types : $this->default_ext() );
					}
				}

				return $supported_types;
			}

			/**
			* Define custom (safe) file extension.
			*/

			public function default_ext() {
				return apply_filters('dnd_cf7_default_ext', 'jpg|jpeg|JPG|png|gif|pdf|doc|docx|ppt|pptx|odt|avi|ogg|m4a|mov|mp3|mp4|mpg|wav|wmv|xls' );
			}
            
            /**
			* Change zip name
			*/

            public function dnd_cf7_change_archive_name( $name, $tags, $field_name ) {

                // bail early.
                if( ! get_option('drag_n_drop_zip_name') || ! get_option('drag_n_drop_zip_files') ) {
                    return $name;
                }

                // Get zip name pattern
                $zip_option_name = get_option('drag_n_drop_zip_name');
                
                // Extract {filename} pattern
                $name = $this->replace_tags( $zip_option_name );

                // Upload field option is present
                if( strpos( $name, 'upload_field' ) !== false && ! get_option('drag_n_drop_zip_combine') ) {
                    $name = str_replace('upload_field', $field_name, $name );
                }

                return $name;
            }
		}
	}

	/**
	* Initialize using singleton pattern
	*/

	function codeDropz_dnd_upload_cf7() {
		$CodeDropz = CodeDropz_Drag_Drop_Upload_CF7::get_instance();
		return $CodeDropz;
	}

	/**
	* Plugin Deactivation
	*/

	function dndmfu_cf7_deactivate() {
		wp_clear_scheduled_hook( 'wp_dnd_cf7_daily_cron' );
	}

	/**
	* Add hooks on ajax response ( Contact Form 7 - API )
	*/

	if( version_compare( WPCF7_VERSION, '5.2', '<' ) ) {
		add_filter( 'wpcf7_ajax_json_echo', 'dndmfu_cf7_ajax_json_response',20,2 );
	}else {
		add_filter( 'wpcf7_feedback_response', 'dndmfu_cf7_ajax_json_response',20,2 );
	}

	// Rest API response callback
	function dndmfu_cf7_ajax_json_response( $response, $result ){
		if( $result['status'] != 'validation_failed' ) {
			$codDropz = codeDropz_dnd_upload_cf7();
			$response['drag_n_drop'] = array(
				'upload_dir'		=>	$codDropz->_options['upload_dir'],
				'generate_name'		=>	$codDropz->get_date('m-d-y') . '-'. uniqid()
			);
		}
		return $response;
	}

	// Launch the whole plugin.
	add_action( 'plugins_loaded', 'codeDropz_dnd_upload_cf7' );