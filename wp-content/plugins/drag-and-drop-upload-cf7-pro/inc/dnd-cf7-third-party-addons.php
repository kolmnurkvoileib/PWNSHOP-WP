<?php
	/**
	* @Description : 3rd Party Plugin - Compatibility.
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

	if ( ! defined( 'ABSPATH' ) || ! defined('dnd_upload_cf7') || ! defined('dnd_upload_cf7_PRO') ) {
		exit;
	}

	// Get all active plugins
	$active_plugins = get_option('active_plugins');

	// cf7 - multi step form
	if( in_array('cf7-multi-step/contact-form-7-multi-step.php', $active_plugins ) ) {

		add_filter('dndmfu_cf7_tag_attributes', function( $atts, $tag ){
			$atts['name'] = $tag->name;
			return $atts;
		}, 10, 2);

		add_action('wp_footer', function(){
		?>
			<script type="text/javascript">
				jQuery(document).ready(function($){
					$(document).on('click', '.cf7mls_next', function(event) {
						if( $('.codedropz-upload-wrapper').parents('fieldset').hasClass('cf7mls_current_fs') ) {
							var dndmfu_cf7_files = jQuery('input.wpcf7-drag-n-drop-file');
							$(document).ajaxComplete(function(event, xhr, options) {
								var data = jQuery.parseJSON( xhr.responseText );
								jQuery.each( dndmfu_cf7_files, function( index, files ) {
									var $files = jQuery(files);
									var $invalid_fields = data.invalid_fields;
									if( $invalid_fields ) {
										if( ! $invalid_fields[ $files.data('name') ] ) {
											$('span.' + $files.data('name') ).find('span.wpcf7-not-valid-tip').remove();
										}
									}
								});
							});
						}
					});
				});
			</script>
		<?php
		});
	}

	// Contact form 7 - Submissions
	if( in_array('contact-form-submissions/contact-form-submissions.php', $active_plugins ) ) {
		add_action('wpcf7_mail_components', function( $components, $contact_form ){
			global $wpcf7s_post_id;
			$codedropz = codeDropz_dnd_upload_cf7();
            $files = ( $codedropz->_options['save_to_media'] ? $codedropz->get_media_files() : $codedropz->get_files() );
			if( ! empty( $wpcf7s_post_id )) {
				if( $files ) {
					foreach( $files as $name => $files ) {
						if( get_post_meta( $wpcf7s_post_id, 'wpcf7s_posted-' . $name, true ) ) {
							$name_only = apply_filters( 'dndcf7_addon_cfs_name', true );
							if( $codedropz->_options['zip_files'] ) {
								update_post_meta( $wpcf7s_post_id, 'wpcf7s_posted-' . $name, ( $name_only ? basename( reset( $files ) ) : reset( $files ) ) );
							}else {
								update_post_meta( $wpcf7s_post_id, 'wpcf7s_posted-' . $name, implode(', ', $files ) );
							}
						}
					}
				}
			}
			return $components;
		},1000,2);
	}

	// CF7 Zapier - Web Hook
	if( in_array('cf7-to-zapier/cf7-to-zapier.php', $active_plugins ) ) {
		add_filter('ctz_get_data_from_contact_form', function( $data, $contact_form ){
			$codedropz = codeDropz_dnd_upload_cf7();
            $files = ( $codedropz->_options['save_to_media'] ? $codedropz->get_media_files() : $codedropz->get_files() );
			$tags = $contact_form->scan_form_tags( array( 'type' => array('mfile', 'mfile*') ) );
			if( $tags ) {
				foreach( $tags as $tag ) {
					if( isset( $files[ $tag->name ] ) ) {
						$data[ $tag->name ] = ( $codedropz->_options['zip_files'] == true ? $files[ $tag->name ][0] : $files[ $tag->name ] );
					}
				}
			}
			return $data;
		}, 20, 2);
	}

	// Flamingo
	if( in_array('flamingo/flamingo.php', $active_plugins ) ) {
		add_action('wpcf7_after_flamingo', function( $result ){
			global $dndmfu_files;
			$post_id = $result['flamingo_inbound_id'];
			$codedropz = codeDropz_dnd_upload_cf7();
			if( $dndmfu_files ) {
				foreach( $dndmfu_files as $name => $file ) {
					update_post_meta( $post_id, '_field_' . $name, ( $codedropz->_options['zip_files'] ? esc_url( reset( $file ) ) : $file ) );
				}
			}
			$dndmfu_files = null;
		});
		add_action('wpcf7_mail_sent', function( $form ){
			global $dndmfu_files;
			if( empty( $dndmfu_files ) ) {
				$codedropz = codeDropz_dnd_upload_cf7();
				if( $codedropz->get_files() ) {
					$dndmfu_files = $codedropz->get_files();
				}
			}
		});
	}

    // Contact Form 7 Database Addon – CFDB7 - Arshid
    if( in_array('contact-form-cfdb7/contact-form-cfdb-7.php', $active_plugins ) ) {
        
        add_filter('dndmfu_cf7_tag_attributes', function( $atts, $tag ){
            $atts['name'] = '';
            return $atts;
        }, 20, 2);

        add_action('cfdb7_before_save_data', function( $form_data ){
            $codedropz = codeDropz_dnd_upload_cf7();
            $files = ( $codedropz->_options['save_to_media'] ? $codedropz->get_media_files() : $codedropz->get_files() );
            if( $files ) {
                foreach( $form_data as $field => $data ) {
                    if( isset( $files[ $field ] ) ) {
                       $form_data[ $field ] = $files[ $field ];
                    }
                }
            }
            return $form_data;
        });
    }

    // Database - Addon for Contact Form 7 - NinjaTeam
    if( in_array('cf7-database/cf7-database.php', $active_plugins ) ) {
        add_filter('cf7d_modify_form_before_insert_data', function( $form_data ){
            $codedropz = codeDropz_dnd_upload_cf7();
            $files = ( $codedropz->_options['save_to_media'] ? $codedropz->get_media_files() : $codedropz->get_files() );
            if( $files ) {
                foreach( $form_data->posted_data as $field => $data ) {
                    if( isset( $files[ $field ] ) ) {
                        $form_data->posted_data[ $field ] = $files[ $field ];
                    }
                }
            }
            return $form_data;
        });
    }

    // Advanced Contact form 7 DB - Vsourz Digital
    if( in_array('advanced-cf7-db/advanced-cf7-db.php', $active_plugins ) ) {
        add_filter('vsz_cf7_modify_form_before_insert_data', function( $form_data ){
            $codedropz = codeDropz_dnd_upload_cf7();
            $files = ( $codedropz->_options['save_to_media'] ? $codedropz->get_media_files() : $codedropz->get_files() );
            if( $files ) {
                foreach( $form_data->posted_data as $field => $data ) {
                    if( isset( $files[ $field ] ) ) {
                        $form_data->posted_data[ $field ] = json_encode( $files[ $field ] );
                    }
                }
            }
            return $form_data;
        });
    }