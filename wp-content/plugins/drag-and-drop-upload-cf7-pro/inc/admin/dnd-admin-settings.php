<?php
	/**
	* @Description : Admin Settings - PRO
	* @Package : Drag & Drop Multiple File Upload - Contact Form 7
	* @Author : CodeDropz
	*/

	/**  This protect the plugin file from direct access */
	if ( ! defined( 'ABSPATH' ) || ! defined('dnd_upload_cf7') || ! defined('dnd_upload_cf7_PRO') ) {
		exit;
	}

	// show upload dir/folder table options
	$upload_dir = wp_upload_dir();
	$show_upload = ( ( ! get_option('drag_n_drop_save_to_media') && get_option('drag_n_drop_mail_attachment') == 'yes' ) ? 'show' : '' );
	$zip_error = ( ! class_exists('ZipArchive') ? __("Your server Doens't support Zip (ZipArchive need to be enable, contact your hosting provider)",'dnd-upload-cf7') : false );
	$tab_active = ( isset( $_GET['tab'] ) ? $_GET['tab'] : 'uploader-info' );
    $lang = dndmfu_cf7_lang();
?>
	<div class="wrap">
		<h1><?php _e('Drag & Drop Uploader - Settings','dnd-upload-cf7'); ?></h1>

		<?php settings_errors(); ?>

		<form method="post" action="options.php">

            <?php
				settings_fields( 'drag-n-drop-upload-file-cf7' );
				do_settings_sections( 'drag-n-drop-upload-file-cf7' );
			?>

			<?php
				$tabs = array(
					'uploader-info'			=>	'Uploader Info',
					'pro-features'			=>	'Pro Features',
					'color-options'			=>	'Color Options',
					'chunks-settings'		=>	'Chunks Settings',
					'image-optimization'	=>	'Image Optimization',
					'other-features'		=>	'Other Features',
					'error-message'			=>	'Error Message',
					'debug'					=>	'Debug',
				);
			?>

			<nav class="nav-tab-wrapper">
				<?php foreach( $tabs as $slug => $tab ) : ?>
					<a href="?page=drag-n-drop-upload&tab=<?php echo $slug; ?>" class="nav-tab <?php echo( $tab_active == $slug ? 'nav-tab-active' : '' ); ?>"><?php echo esc_html( $tab ); ?></a>
				<?php endforeach; ?>
			</nav>

			<?php if( $tab_active == 'uploader-info' ) : ?>

				<h2><?php _e('Uploader Text','dnd-upload-cf7'); ?></h2>

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Heading Tag','dnd-upload-cf7'); ?></th>
						<td>
							<select name="drag_n_drop_heading_tag">
								<option value="h1" <?php selected( get_option('drag_n_drop_heading_tag'), 'h1'); ?>>H1</option>
								<option value="h2" <?php selected( get_option('drag_n_drop_heading_tag'), 'h2'); ?>>H2</option>
								<option value="h3" <?php selected( get_option('drag_n_drop_heading_tag','h3'), 'h3'); ?>>H3</option>
								<option value="h4" <?php selected( get_option('drag_n_drop_heading_tag'), 'h4'); ?>>H4</option>
								<option value="h5" <?php selected( get_option('drag_n_drop_heading_tag'), 'h5'); ?>>H5</option>
								<option value="h6" <?php selected( get_option('drag_n_drop_heading_tag'), 'h6'); ?>>H6</option>
								<option value="div" <?php selected( get_option('drag_n_drop_heading_tag'), 'div'); ?>>Div</option>
								<option value="span" <?php selected( get_option('drag_n_drop_heading_tag'), 'span'); ?>>Span</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Drag & Drop Text','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_text<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_text') ); ?>" placeholder="Drag & Drop Files Here" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"></th>
						<td><input type="text" name="drag_n_drop_separator<?php echo $lang; ?>" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_separator') ); ?>" placeholder="or" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Browse Text','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_browse_text<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_browse_text') ); ?>" placeholder="Browse Files" /></td>
					</tr>
				</table>

				<h2><?php _e('Change Border','dnd-upload-cf7'); ?></h2>

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Color','dnd-upload-cf7'); ?> </th>
						<td>
							<input class="dnd-color-picker" name="drag_n_drop_border_color" type="text" value="<?php echo get_option('drag_n_drop_border_color'); ?>" />
						</td>
					</tr>
				</table>

				<h2><?php _e('Other Text','dnd-upload-cf7'); ?></h2>

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('Of Text','dnd-upload-cf7'); ?> </th>
						<td>
							<input name="drag_n_drop_of_counter_text<?php echo $lang; ?>" type="text" placeholder="0 of 10" value="<?php echo dnmfu_cf7_option('drag_n_drop_of_counter_text'); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Deleting File','dnd-upload-cf7'); ?> </th>
						<td>
							<input name="drag_n_drop_delete_text<?php echo $lang; ?>" type="text" placeholder="Deleting..." value="<?php echo dnmfu_cf7_option('drag_n_drop_delete_text'); ?>" />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Remove Title','dnd-upload-cf7'); ?> </th>
						<td>
							<input name="drag_n_drop_remove_text<?php echo $lang; ?>" type="text" placeholder="Remove" value="<?php echo dnmfu_cf7_option('drag_n_drop_remove_text'); ?>" />
						</td>
					</tr>
				</table>

			<?php endif; ?>

			<?php if( $tab_active == 'error-message' ) : ?>

				<h2><?php _e('Error Message','dnd-upload-cf7'); ?></h2>

				<table class="form-table">
					<tr valign="top">
						<th scope="row"><?php _e('File exceeds server limit','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_error_server_limit<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_server_limit') ); ?>" placeholder="<?php echo $this->get_error_msg('server_limit'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Failed to Upload','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_error_failed_to_upload<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_failed_to_upload') ); ?>" placeholder="<?php echo $this->get_error_msg('failed_upload'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Files too large','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_error_files_too_large<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_files_too_large') ); ?>" placeholder="<?php echo $this->get_error_msg('large_file'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Invalid file Type','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_error_invalid_file<?php echo $lang; ?>" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_invalid_file') ); ?>" placeholder="<?php echo $this->get_error_msg('invalid_type'); ?>" /></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Mininimum File','dnd-upload-cf7'); ?></th>
						<td><input type="text" name="drag_n_drop_error_min_file<?php echo $lang; ?>" placeholder="Please enter error message" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_min_file') ); ?>" placeholder="" /></td>
					</tr>
					<tr valign="top">
						<th colspan="2" style="padding:0 0;">
							<p class="description"><strong>Note:  </strong>%s will be replace by number according to the value specified in Options.</p>
						</th>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Max Number of Files','dnd-upload-cf7'); ?></th>
						<td>
							<input type="text" name="drag_n_drop_error_max_files<?php echo $lang; ?>" placeholder="Please enter error message" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_max_files') ); ?>"/>
							<p class="description">default: "You have reached the maximum number of files ( Only %s files allowed )"</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Max Upload Limit','dnd-upload-cf7'); ?></th>
						<td>
							<input type="text" name="drag_n_drop_error_max_upload_limit<?php echo $lang; ?>" placeholder="Please enter error message" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_max_upload_limit') ); ?>"/>
							<p class="description">default : "Note : Some of the files could not be uploaded ( Only %s files allowed )"</p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Total Size Limit','dnd-upload-cf7'); ?></th>
						<td>
							<input type="text" name="drag_n_drop_error_size_limit<?php echo $lang; ?>" placeholder="Please enter error message" class="regular-text" value="<?php echo esc_attr( dnmfu_cf7_option('drag_n_drop_error_size_limit') ); ?>" />
							<p class="description">default: "The total file(s) size exceeding the max size limit of %s."</p>
						</td>
					</tr>
				</table>

				<?php endif; ?>

				<?php if( $tab_active == 'chunks-settings' ) : ?>

					<h2><?php _e('New Features','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Parallel / Sequential Upload','dnd-upload-cf7'); ?> </th>
							<td><input name="drag_n_drop_parallel_uploads" class="regular-text" type="text" placeholder="2" value="<?php echo get_option('drag_n_drop_parallel_uploads'); ?>">
							<p class="description"><?php _e('Number of Files Simultaneously Upload. (default: <strong>2</strong>)','dnd-upload-cf7'); ?></p></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Chunks Upload','dnd-upload-cf7'); ?> </th>
							<td>
								<select name="drag_n_drop_chunks_upload">
									<option <?php selected( get_option('drag_n_drop_chunks_upload'),0 ); ?> value="0">No</option>
									<option value="1" <?php selected( get_option('drag_n_drop_chunks_upload'),1 ); ?>>Yes</option>
								</select><p class="description"><?php _e('Break large files into smaller Chunks (default: <strong>No</strong>)','dnd-upload-cf7'); ?></p>

							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Chunks Size (KB)','dnd-upload-cf7'); ?> </th>
							<td>
								<input <?php echo ( ! get_option('drag_n_drop_chunks_upload') ? 'disabled="true"' : '' ); ?> name="drag_n_drop_chunk_size" class="regular-text" type="text" placeholder="10000" value="<?php echo get_option('drag_n_drop_chunk_size'); ?>">
								<p class="description"><?php _e('Define chunk size in KB. (default: <strong>10000</strong>) equal to 10MB','dnd-upload-cf7'); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Max Total Size (MB)','dnd-upload-cf7'); ?> </th>
							<td><input name="drag_n_drop_max_total_size" class="regular-text" type="text" placeholder="100MB" value="<?php echo get_option('drag_n_drop_max_total_size'); ?>">
							<p class="description"><?php _e('Set <strong>Total Max Size</strong> of all uploaded files. (default: <strong>100MB</strong>)','dnd-upload-cf7'); ?></p></td>
						</tr>
					</table>

				<?php endif; ?>

				<?php if( $tab_active == 'pro-features' ): ?>

					<h2><?php _e('Pro Features','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top" class="filename-amend">
							<th scope="row"><?php _e('Change Filename','dnd-upload-cf7'); ?> </th>
							<td><input name="drag_n_drop_file_amend" class="regular-text" type="text" placeholder="{filename} - {ip-address}" value="<?php echo get_option('drag_n_drop_file_amend'); ?>"> <em>Use ( - ) or ( _ ) separator</em>
							<p class="description">Tags: <span>{filename}</span>,<span>{username}</span>,<span>{user_id}</span>,<span>{ip_address}</span>,<span>{random}</span>,<span>{date}</span>,<span>{time}</span>,<span>{post_id}</span>,<span>{post_slug}</span>,<span>{cf7-field-name}</span></p>
							<?php $forms = get_posts(array('post_type' => 'wpcf7_contact_form', 'numberposts' => - 1 )); ?>
							<fieldset style="padding-top:15px; display:flex;">
								<label style="padding-right:10px;"><strong>Apply to</strong></label>
									<?php $cf_fields = get_option('drag_n_drop_file_ammend_forms', array()); ?>
									<select style="width:284px;" name="drag_n_drop_file_ammend_forms[]" class="regular-text" multiple>
										<?php foreach( $forms as $form ) : ?>
											<option <?php echo ( $cf_fields && in_array( $form->ID, $cf_fields ) ) ? 'selected' : ''; ?> value="<?php echo $form->ID; ?>"><?php echo $form->post_title; ?></option>
										<?php endforeach; ?> 
									</select>
							</fieldset>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Upload Directory','dnd-upload-cf7'); ?> </th>
							<td><input name="drag_n_drop_upload_dir" class="regular-text" type="text" placeholder="<?php echo wp_normalize_path( $upload_dir['basedir'] ); ?>" value="<?php echo get_option('drag_n_drop_upload_dir'); ?>">
							<p class="description"><?php _e('Change the default WordPress media uploads folder','dnd-upload-cf7'); ?></p></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Send file(s) as links?','dnd-upload-cf7'); ?> </th>
							<td><input name="drag_n_drop_mail_attachment" class="conditional-field" type="checkbox" value="yes" <?php checked('yes', get_option('drag_n_drop_mail_attachment')); ?>> Yes <span class="description"><?php _e('( Files will be saved on your server )','dnd-upload-cf7'); ?><span><br>
							<p class="description"><?php _e('Display links on email and redirect to the attachment.','dnd-upload-cf7'); ?></p></td>
						</tr>
						<tr valign="top" style="display:none">
							<th scope="row"><?php _e('Upload (1) file at a Time','dnd-upload-cf7'); ?></th>
							<td><input name="drag_n_drop_one_file_at_time" type="checkbox" <?php checked( get_option('drag_n_drop_one_file_at_time'),1 ); ?> value="1"> Yes - <span class="description"><?php _e('This will save time and prevent multiple server request','dnd-upload-cf7'); ?></span></td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Save Files to Media Library?','dnd-upload-cf7'); ?></th>
							<td><input name="drag_n_drop_save_to_media" class="conditional-field-media" <?php checked( get_option('drag_n_drop_save_to_media'),1 ); ?> type="checkbox" value="1"> Yes</td>
						</tr>
						<tr valign="top" class="conditional-show <?php echo $show_upload; ?>">
							<th scope="row"><span style="padding-left:15px;"><?php _e('Links & File Attachments','dnd-upload-cf7'); ?></span></th>
							<td>
								<input name="drag_n_drop_links_attachments" <?php checked( get_option('drag_n_drop_links_attachments'),1 ); ?> type="checkbox" value="1"> Yes <span class="description">( <?php _e('make sure file "attachment size" not excceds <strong>25MB</strong>','dnd-upload-cf7'); ?>)</span>
								<p class="description"><?php _e('Uncheck this, if you are accepting or uploading large files.','dnd-upload-cf7'); ?></p>
							</td>
						</tr>
						<tr valign="top" class="conditional-show <?php echo $show_upload; ?>">
							<th scope="row"><span style="padding-left:15px;"><?php _e('Upload Folder (*required)','dnd-upload-cf7'); ?></span></th>
							<td>
								<fieldset>
									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'),'cf7_fields' ); ?> value="cf7_fields"><span><?php _e('Contact Form 7 - Fields','dnd-upload-cf7'); ?></span> <span>:</span>
									<input type="text" name="drag_n_drop_cf7_folder" value="<?php echo get_option('drag_n_drop_cf7_folder'); ?>" placeholder="[your-name]"></label><br>

									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'),'date_n_time' ); ?> value="date_n_time"><span><?php _e('Generated Date & Time','dnd-upload-cf7'); ?></span> <code><?php echo get_date_from_gmt( date('Y-m-d H:i:s') ); ?></code></label><br>

									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'), 'generated' ); ?> value="generated"><span><?php _e('Random Folder','dnd-upload-cf7'); ?></span> <code>11ol987xJyd12</code></label><br>

									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'), 'user_login' ); ?> value="user_login"><span><?php _e('By User','dnd-upload-cf7'); ?></span> <code>user-john-smith</code></label><span class="description"> <?php _e('( User must login )','dnd-upload-cf7'); ?></span><br>

									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'), 'custom_folder' ); ?> value="custom_folder"><span><?php _e('Custom Folder','dnd-upload-cf7'); ?> :</span>
									<input type="text" name="drag_n_drop_custom_folder" value="<?php echo get_option('drag_n_drop_custom_folder'); ?>" placeholder="wpcf7_uploads"></label><br>

									<label><input type="radio" name="drag_n_drop_folder_option" <?php checked( get_option('drag_n_drop_folder_option'), 'dynamic_folder' ); ?> value="dynamic_folder"><span><?php _e('Dynamic Folder','dnd-upload-cf7'); ?> :</span>
									<input type="text" name="drag_n_drop_dynamic_folder" style="width:210px;" value="<?php echo get_option('drag_n_drop_dynamic_folder'); ?>" placeholder="{username} / {cf7_field_name}"></label><em>(use "/" separator)</em>
									<p class="description">Tags: {username}, {name}, {user_id}, {upload_field}, {post_id}, {post_slug}, {cf7_field_name} </p><br>
									<p class="description">
										<strong>{cf7_field_name}</strong> - Replace <strong>"cf7_field_name"</strong> with the actual name of CF7 Field. (example: "your-name", "your-subject")<br>
										<strong>{upload_field}</strong> - This tag will get the name of your upload field like ("upload-file-123","uploads").
									</p>
								</fieldset>
							</td>
						</tr>
                        </table>

                        <h3>Compress Files</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php _e('Enable Zip','dnd-upload-cf7'); ?></th>
                                <td><input name="drag_n_drop_zip_files" type="checkbox" <?php checked( get_option('drag_n_drop_zip_files'), 1 ); ?> value="1" <?php echo ( $zip_error ? 'disabled' : '' ); ?>> Yes <br>
                                <?php echo ( $zip_error ? '<p class="description" style="color:red;">'. $zip_error . '</p>'  : '' ); ?></td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Zip All Files','dnd-upload-cf7'); ?></th>
                                <td><input name="drag_n_drop_zip_combine" type="checkbox" <?php checked( get_option('drag_n_drop_zip_combine'), 1 ); ?> value="1"> Yes <em>(Combine & zip all files from individual upload field)</em> <br>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Zip Name','dnd-upload-cf7'); ?></th>
                                <td>
                                    <input type="text" name="drag_n_drop_zip_name" style="width:350px;" value="<?php echo get_option('drag_n_drop_zip_name'); ?>" placeholder="{random}-{upload_field}"></label><em>(use "-" separator)</em>
								    <p class="description">Tags: {username}, {name}, {user_id}, {random}, {date}, {time}, {upload_field}, {post_id}, {post_slug}, {cf7_field_name} </p><br>
                                    <p><strong>{cf7_field_name}</strong> - Replace "cf7_field_name" with the actual name of CF7 Field. (example: "your-name", "your-subject")<br>
                                    <strong>{upload_field}</strong> - This tag will get the name of your upload field like ("upload-file-123","uploads").</p>
                                </td>
                            </tr>
                        </table>

                        <h3>File Deletion</h3>
                        <table class="form-table">
                            <tr valign="top">
                                <th scope="row"><?php _e('Delete Temporary Files','dnd-upload-cf7'); ?></th>
                                <td>
                                    <input name="drag_n_drop_on_failed_delete_files" type="checkbox" <?php checked( get_option('drag_n_drop_on_failed_delete_files',1), 1 ); ?> value="1"> Yes <em>(If form submission is failed/spam)</em>
                                </td>
                            </tr>
                            <tr valign="top">
                                <th scope="row"><?php _e('Auto Delete Files','dnd-upload-cf7'); ?></th>
                                <td>
                                    <?php
                                        $time_options = apply_filters('dndcf7_time_before_deletion_options', array(
                                            '0'		=>  'Immediately',
                                            '1'		=>	'1 Hour',
                                            '4'		=>	'4 Hours',
                                            '8'		=>	'8 Hours',
                                            '12'	=>	'12 Hours',
                                            '16'	=>	'16 Hours',
                                            '20'	=>	'20 Hours',
                                            '24'	=>	'24 Hours',
                                            '48'	=>	'48 Hours (2Days)',
                                            '96'	=>	'96 Hours (4Days)',
                                            '120'	=>	'120 Hours (5Days)',
                                            '168'	=>	'168 Hours (7Days)',
                                            '216'	=>	'216 Hours (9Days)',
                                            '360'	=>	'360 Hours (15Days)',
                                            '7440'	=>	'1 Month',
                                            '14880'	=>	'2 Months',
                                            '22320'	=>	'3 Months',
                                            '29760'	=>	'4 Months',
                                            '37200'	=>	'5 Months',
                                        ));
                                    ?>
                                    <select name="drag_n_drop_delete_options">
                                        <option value="">-</option>
                                        <?php foreach( $time_options as $hours => $time_label ) : ?>
                                            <option value="<?php echo esc_attr( $hours ); ?>" <?php selected( get_option('drag_n_drop_delete_options'), $hours ); ?> ><?php echo esc_html( $time_label ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="description"><?php _e('after submission','dnd-upload-cf7'); ?></span>
                                </td>
                            </tr>
					    </table>

				<?php endif; ?>

				<?php if( $tab_active == 'image-optimization' ) : ?>

					<h2><?php _e('Image Optimization','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Resize Image','dnd-upload-cf7'); ?> </th>
							<td>
								<input name="drag_n_drop_image_resize" class="regular-text" type="text" placeholder="600x600" value="<?php echo get_option('drag_n_drop_image_resize'); ?>">
								<p class="description"><?php _e('Separate width & height with (x)','dnd-upload-cf7'); ?></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Image Quality','dnd-upload-cf7'); ?> </th>
							<td>
								<input name="drag_n_drop_image_quality" class="regular-text" type="text" placeholder="80" value="<?php echo get_option('drag_n_drop_image_quality'); ?>">
								<p class="description"><?php _e('Quality level between 1 (low) and 100 (high) - (Wordpress Default: <strong>82</strong>)','dnd-upload-cf7'); ?></p>
							</td>
						</tr>
					</table>

					<h2><?php _e('Image Preview','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<tr valign="top">
								<th scope="row"><?php _e('Show image preview','dnd-upload-cf7'); ?></th>
								<td><input name="drag_n_drop_show_img_preview" <?php checked( get_option('drag_n_drop_show_img_preview'), 1 ); ?> type="checkbox" value="1"> Yes</td>
							</tr>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Display','dnd-upload-cf7'); ?> </th>
							<td>
								<table>
									<tr valign="top">
										<td style="padding:0;">
											<label><input name="drag_n_drop_thumbnail_display" type="radio" <?php checked( get_option('drag_n_drop_thumbnail_display','default'), 'default' ); ?> value="default"> Default</label>
											<p class="description"><img src="<?php echo plugins_url('drag-and-drop-upload-cf7-pro/assets/images/default-preview.jpg' ); ?>"></p>
										</td>
									</tr>
									<tr valign="top">
										<td style="padding:0;">
											<label><input name="drag_n_drop_thumbnail_display" type="radio" value="column" <?php checked( get_option('drag_n_drop_thumbnail_display'), 'column' ); ?>> Column</label>
											<p class="description"><img src="<?php echo plugins_url('drag-and-drop-upload-cf7-pro/assets/images/preview-grid.jpg' ); ?>"></p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Number of Column','dnd-upload-cf7'); ?> </th>
							<td>
								<input name="drag_n_drop_thumbnail_column" class="regular-text enable-if-column" type="text" placeholder="8" value="<?php echo get_option('drag_n_drop_thumbnail_column'); ?>" <?php echo ( get_option('drag_n_drop_thumbnail_display') != 'column' ? 'disabled' : '' ); ?> >
							</td>
						</tr>
					</table>

				<?php endif; ?>

				<?php if( $tab_active == 'other-features' ) : ?>

					<h2><?php _e('Other Features','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Disable Button on Submission?','dnd-upload-cf7'); ?> </th>
							<td>
								<input id="drag_n_drop_disable_btn" name="drag_n_drop_disable_btn" type="checkbox" <?php checked( get_option('drag_n_drop_disable_btn'), 1 ); ?> value="1"> <?php _e('Yes <em>(This will prevent multiple submission.)</em>','dnd-upload-cf7'); ?>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Hide File Counter','dnd-upload-cf7'); ?> </th>
							<td>
								<input id="drag_n_drop_hide_counter" name="drag_n_drop_hide_counter" type="checkbox" <?php checked( get_option('drag_n_drop_hide_counter'), 1 ); ?> value="1"> <?php _e('Yes <em>(Hide "0/10" counter. )</em>','dnd-upload-cf7'); ?>
							</td>
						</tr>
					</table>

				<?php endif; ?>

				<?php if( $tab_active == 'color-options' ) : ?>

					<h2><?php _e('Color Options','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('ProgressBar','dnd-upload-cf7'); ?> </th>
							<td>
								<input class="dnd-color-picker" name="drag_n_drop_color_progressbar" type="text" value="<?php echo get_option('drag_n_drop_color_progressbar','#4CAF50'); ?>" />
								<p class="description">Change the color of loading progress...</strong></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Filename','dnd-upload-cf7'); ?> </th>
							<td>
								<input class="dnd-color-picker" name="drag_n_drop_color_filename" type="text" value="<?php echo get_option('drag_n_drop_color_filename'); ?>" />
								<p class="description">ie: <strong>sample-file.jpg</strong></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Delete/Remove','dnd-upload-cf7'); ?> </th>
							<td>
								<input class="dnd-color-picker" name="drag_n_drop_color_delete" type="text" value="<?php echo get_option('drag_n_drop_color_delete'); ?>" />
								<p class="description">Change the color of <strong>(x)</strong> icon on top right.</strong></p>
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('File Size','dnd-upload-cf7'); ?> </th>
							<td>
								<input class="dnd-color-picker" name="drag_n_drop_color_filesize" type="text" value="<?php echo get_option('drag_n_drop_color_filesize'); ?>" />
								<p class="description">ie: <strong>(169.71KB)</strong></p>
							</td>
						</tr>
					</table>

				<?php endif; ?>

				<?php if( $tab_active == 'debug' ): ?>

					<h2><?php _e('Debug','dnd-upload-cf7'); ?></h2>

					<table class="form-table">
						<tr valign="top">
							<th scope="row"><?php _e('Enable Debug?','dnd-upload-cf7'); ?> </th>
							<td>
								<input id="drag_n_drop_debug" name="drag_n_drop_debug" type="checkbox" <?php checked( get_option('drag_n_drop_debug'), 1 ); ?> value="1">
								<input type="text" id="debug-email" <?php echo ( !get_option('drag_n_drop_debug') ? 'style="display:none;"' : ''  ); ?> name="drag_n_drop_debug_email" class="regular-text" value="<?php echo get_option('drag_n_drop_debug_email'); ?>" placeholder="Email">
							</td>
						</tr>
						<tr valign="top">
							<th scope="row"><?php _e('Settings','dnd-upload-cf7'); ?> </th>
							<td>
								<?php
									$settings = array();
									$options['uploader-info'] = array('drag_n_drop_heading_tag','drag_n_drop_text','drag_n_drop_separator','drag_n_drop_browse_text','drag_n_drop_border_color','drag_n_drop_of_counter_text','drag_n_drop_delete_text','drag_n_drop_remove_text');
									$options['error-message'] = array('drag_n_drop_error_server_limit','drag_n_drop_error_failed_to_upload','drag_n_drop_error_files_too_large','drag_n_drop_error_invalid_file','drag_n_drop_error_min_file','drag_n_drop_error_max_files','drag_n_drop_error_max_upload_limit','drag_n_drop_error_size_limit');
									$options['chunks-settings'] = array('drag_n_drop_parallel_uploads','drag_n_drop_chunks_upload','drag_n_drop_chunk_size','drag_n_drop_max_total_size');
									$options['pro-features'] = array('drag_n_drop_file_amend','drag_n_drop_file_ammend_forms','drag_n_drop_upload_dir','drag_n_drop_mail_attachment','drag_n_drop_save_to_media','drag_n_drop_links_attachments','drag_n_drop_folder_option','drag_n_drop_cf7_folder','drag_n_drop_custom_folder','drag_n_drop_dynamic_folder','drag_n_drop_zip_files','drag_n_drop_delete_options');
									$options['image-optimization'] = array('drag_n_drop_image_resize','drag_n_drop_image_quality','drag_n_drop_show_img_preview','drag_n_drop_thumbnail_display','drag_n_drop_thumbnail_column');
									$options['other-features'] = array('drag_n_drop_disable_btn','drag_n_drop_hide_counter');
									$options['color-options'] = array('drag_n_drop_color_progressbar','drag_n_drop_color_filename','drag_n_drop_color_delete','drag_n_drop_color_filesize');
									$options['debug'] = array('drag_n_drop_debug','drag_n_drop_debug_email');

									foreach( $options as $tab => $option ) {
										foreach( $option as $single_option ) {
											$settings[ $tab ][ $single_option ] = get_option( $single_option );
										}
									}

									$settings['active-plugins'] = get_option('active_plugins');
									$settings['contact-form-version'] = WPCF7_VERSION;
									$settings['drag-n-drop-version'] = dnd_upload_cf7_version;
								?>
								<code style="word-break:break-word;"><?php echo json_encode( $settings ); ?></code>
							</td>
						</tr>
					</table>

				<?php endif; ?>
			<?php echo '<input type="hidden" name="drag_n_drop_tab_active" value="'. $tab_active .'">'; ?>
			<?php submit_button(); ?>
		</form>
	</div>

	<style>
		.filename-amend span { margin: 0 4px 2px; }
		.conditional-show { display:none; }
		.conditional-show.show { display:table-row; }
	</style>

	<script type="text/javascript">
		jQuery(document).ready(function($){
			var $_conditional_field = $('.conditional-show');

			// Submit - required upload folder
			$('#submit').on('click', function(){
				var $custom_foler = 'input[name="drag_n_drop_folder_option"]';
				var $cf7_custom_foler = $('input[name="drag_n_drop_cf7_folder"]');
				var $custom_dir = $('input[name="drag_n_drop_custom_folder"]');
				if( $($custom_foler).is(':visible') & ! $($custom_foler).is(":checked") ) {
					alert('Error : Please select "Upload Folder."');
					return false;
				}
				if( $($custom_foler).is(':visible') && $($custom_foler +':checked').val() == 'custom_folder' && $custom_dir.val() == '' ) {
					alert("Error: Please enter custom folder.");
					return false;
				}
				if( $($custom_foler).is(':visible') && $($custom_foler +':checked').val() == 'cf7_fields' && $cf7_custom_foler.val() == '' ) {
					alert("Error: Please enter CF7 Fields.");
					return false;
				}
			});

			// Send attachment as links option is checked.
			$('[name="drag_n_drop_mail_attachment"]').change(function(){
				if( $(this).val() == 'yes' ) {
					$('input[value="custom_folder"]').prop("checked", false);
					if( $('[name="drag_n_drop_custom_folder"]').val() != '' ) {
						$('input[value="custom_folder"]').prop("checked", true);
					}
				}
			});

			$('.conditional-field').click(function(){
				$_conditional_field.removeClass('show');
				$_conditional_field.find('[name="drag_n_drop_folder_option"]').attr('disabled', true);
				$_conditional_field.find('[name="drag_n_drop_links_attachments"]').attr('disabled', true);
				if( $(this).is(':checked') && ! $('.conditional-field-media').is(':checked') ) {
					$_conditional_field.addClass('show');
					$_conditional_field.find('[name="drag_n_drop_folder_option"]').removeAttr('disabled');
					$_conditional_field.find('[name="drag_n_drop_links_attachments"]').removeAttr('disabled');
				}
			});

			// Hide folder options - when save to media library option is check.
			$('.conditional-field-media').click(function(){
				if( $(this).is(':checked') && $('.conditional-field').is(':checked') ) {
					$_conditional_field.removeClass('show');
					$_conditional_field.find('[name="drag_n_drop_folder_option"]').attr('disabled', true);
					$_conditional_field.find('[name="drag_n_drop_links_attachments"]').attr('disabled', true);
				}else {
					if( $('.conditional-field').is(':checked') ) {
						$_conditional_field.addClass('show');
						$_conditional_field.find('[name="drag_n_drop_links_attachments"]').removeAttr('disabled');
						$_conditional_field.find('[name="drag_n_drop_folder_option"]').removeAttr('disabled');
					}
				}
			});

			// Enable chunks
			$('[name="drag_n_drop_chunks_upload"]').change(function(){
				if( $(this).val() == 1 ) {
					$('[name="drag_n_drop_chunk_size"]').removeAttr("disabled").focus();
				}else{
					$('[name="drag_n_drop_chunk_size"]').attr("disabled",'true');
				}
			});

			// Preview Thumbnail
			$('[name="drag_n_drop_thumbnail_display"]').change(function(){
				if( $(this).val() == 'column' ) {
					$('.enable-if-column').removeAttr('disabled').focus();
				}else {
					$('.enable-if-column').attr('disabled', true);
				}
			});

			// Enable debug
			$('#drag_n_drop_debug').click(function(){
				if( $(this).is(':checked') ) {
					$('#debug-email').show();
				}else {
					$('#debug-email').hide();
				}
			});

			// Color Picker
			$( '.dnd-color-picker' ).wpColorPicker();
		});
	</script>