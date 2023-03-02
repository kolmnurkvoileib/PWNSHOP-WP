jQuery(document).ready(function($){

	// Setup drag n drop function
	window.initDragDrop = function ( file_name ) {

		// Get text object options/settings from localize script
		var TextOJB = dnd_cf7_uploader.drag_n_drop_upload;

		var dnd_options = {
			'color'				:	'#fff',
			'ajax_url'			: 	dnd_cf7_uploader.ajax_url,
			'text'				: 	TextOJB.text,
			'separator'			: 	TextOJB.or_separator,
			'button_text'		:	TextOJB.browse,
			'server_max_error'	: 	TextOJB.server_max_error,

			// New Options
			'parallel_uploads'	:	dnd_cf7_uploader.parallel_uploads,
			'chunks'			:	dnd_cf7_uploader.chunks,
			'chunk_size'		:	dnd_cf7_uploader.chunk_size,
			'max_total_size'	: 	dnd_cf7_uploader.max_total_size,
			'err_message'		: 	{
				'maxNumFiles'		: dnd_cf7_uploader.err_message.maxNumFiles,
				'maxTotalSize'		: dnd_cf7_uploader.err_message.maxTotalSize,
				'maxUploadLimit'	: dnd_cf7_uploader.err_message.maxUploadLimit
			},

			//@description: upload is in progress
			'in_progress' : function( form_handler, queue, data ) {

				// Get submit btn
				var submitBtn = $('input[type="submit"]', form_handler);

				// Disable submit button
				if( submitBtn.length > 0 ) {
					submitBtn.addClass('disable').prop( "disabled", true );
				}

                // Create event - upload in progress
                dndmfu_cf7_event( form_handler, 'in_progress', data );
			},

			// @description: single queue file upload is complete
			'on_success' : function( progressBar, response, fieldName, Record ){

				// Progressbar Object ID
				var progressDetails = $('#' + progressBar ),
                    parentWrap = progressDetails.parents('.codedropz-upload-wrapper');

                if( dnd_cf7_uploader.preview_layout == 'column' ) {
                    
                    // If file is not an image show only the extension.
                    if( ! response.data.is_image || response.data.preview === false ) {
                       $('.dnd-upload-image', progressDetails ).addClass('has-icon has-bg');
                    }

                    // append to preview container.
                    $( '.codedropz--preview', parentWrap ).append( progressDetails );

                    // Show image
                    progressDetails.find('.dnd-upload-image').fadeIn();

                }

                // Preview image according their type
                if( typeof response.data.preview !== "boolean" ) {
                    $('.dnd-icon-blank-file', progressDetails ).css('background-image', 'url(' + response.data.preview + ')' );
                }

				// Append hidden input field
				$('.dnd-upload-details', progressDetails )
					.append('<span><input type="hidden" name="'+ fieldName +'[]" value="'+ response.data.path + response.data.file +'"></span>');

				// Update Counter
				$('.dnd-upload-counter span', parentWrap ).text( Record.uploaded );

                // Create event - individual file upload successfully
                dndmfu_cf7_event( progressDetails, 'success', response );

			},

			// @description: all queued files has been completed
			'completed' : function( form_handler, fileData, data ) {

				var $span  = $('.wpcf7-acceptance', form_handler );
				var $input = $('input:checkbox', $span);

				var $max_total_size = ( dnd_options.max_total_size ? dnd_options.max_total_size : '100MB' );
				var $totalSizeLimit = parseInt( $max_total_size.replace('[^0-9]/g','') );

				// If it's complete remove disabled attribute in button
				if( $('.in-progress', form_handler ).length === 0 ) {
					if( $span.hasClass( 'optional' ) || $input.is( ':checked' ) || $span.length == 0 || form_handler.hasClass('wpcf7-acceptance-as-validation') )  {
						if( fileData.maxTotalSize < ( $totalSizeLimit * 1048576 ) ) {
							$('input[type="submit"]', form_handler ).removeAttr('disabled');
						}
					}
                    // Create event - all files uploaded
                    dndmfu_cf7_event( form_handler, 'completed', data );
				}
			}

		};

		// Initialize Plugin
        if( file_name ) {
            $('input[data-name="'+ file_name +'"]').CodeDropz_Uploader( dnd_options );
        }else {
            $('.wpcf7-drag-n-drop-file').CodeDropz_Uploader( dnd_options );
        }

	}

	// Initialize drag n drop plugin.
	window.initDragDrop();
    
    // Coditional Field - Repeater
    if( $('.wpcf7cf_repeater').length > 0 ) {
        $('form').on('click.wpcf7cf', function(e){
            
            // Bail early
            if( $(e.target).attr('class') != 'wpcf7cf_add' ) {
                return;
            }

            // Get cf7 conditional name, count & file upload
            var $repeater_count = $('input[name="'+ $('.wpcf7cf_repeater').data('id') +'_count"]').val();
            var $sub =  $('.wpcf7cf_repeater_sub:last');
            var $file_upload =  $('.wpcf7-drag-n-drop-file', $sub);
            var $uploader_name = $( $file_upload, $sub ).attr('data-name') +'__'+ parseInt( $repeater_count );

            // Update uploader name & attribute
            $file_upload.attr('data-name', $uploader_name );
            
            // Initialize uploader
            window.initDragDrop( $uploader_name );
        });
    }

    // RedNumber Repeater
    if( $('.cf7-repeater').length > 0 ) {
        $('.cf7-button-repeater a').on('click', function(){
            
            var firstUploader = $('.wpcf7-drag-n-drop-file').first();
            var lastField = $('.cf7-repeater-filed:last');
            var fileUploader = $('.wpcf7-drag-n-drop-file', lastField );
            var dataNames = $('.cf7-remove-repeater', lastField ).attr('data-name').split(',');
            const currentIndex = dataNames[0].split('-').splice(-1);
            var uploaderName = fileUploader.attr('data-name-'+currentIndex[0]);

            // Unwrap input type
            fileUploader.unwrap();

            // Clean and set new data name attr
            fileUploader.attr('data-name', uploaderName);
            fileUploader.removeAttr('data-name-'+currentIndex[0]);

            $('.codedropz-upload-handler', lastField ).remove();
            $('.codedropz--results', lastField ).remove();

            window.initDragDrop( uploaderName );

            firstUploader.val('');

        });
    }

    // Custom event handler
    var dndmfu_cf7_event = function( target, name, data ) {
        var event = new CustomEvent( 'dndmfu_cf7_' + name, {
			bubbles     : true,
			detail     : data
		});
		$(target).get(0).dispatchEvent( event );
    }

    // Mail Sent
    document.addEventListener('wpcf7mailsent', function( event ){
        // Get input file type - object
        var inputFile = $('.wpcf7-drag-n-drop-file');

        // Get api response
        if( event.detail.apiResponse ) {
            var api_Response = event.detail.apiResponse;

            // Change upload dir - in hidden fields ( under contact form 7 )
            if( typeof api_Response.drag_n_drop.upload_dir !== 'undefined' ) {
                $(api_Response.into).find("input[name='upload_dir']").val( api_Response.drag_n_drop.upload_dir );
            }

            // Change generated name - in hidden fields ( under contact form 7 )
            if( typeof api_Response.drag_n_drop.generate_name !== 'undefined' ) {
                $(api_Response.into).find("input[name='generate_name']").val( api_Response.drag_n_drop.generate_name );
            }
        }

        // Remove status / progress bar
        $('.dnd-upload-status', inputFile.parents('form')).remove();
        $('span.has-error-msg').remove();

        // Reset file count
        dndmfu_cf7_reset_progress();
    });

    // Mail Spam
    document.addEventListener('wpcf7spam', function( event ){
        // Reset file lists.
        if( dnd_cf7_uploader.delete_files_on_failed == 1 ) {
            $('.dnd-upload-status').remove();
            dndmfu_cf7_reset_progress();
        }
    });

    // Failed
    document.addEventListener('wpcf7mailfailed', function( event ){
        // Reset file lists.
        if( dnd_cf7_uploader.delete_files_on_failed == 1 ) {
            $('.dnd-upload-status').remove();
            dndmfu_cf7_reset_progress();
        }
    });

	// Disable button on submission
	if( dnd_cf7_uploader.disable_btn_submission ) {

		// Disable button is submission in progress
		$('form.wpcf7-form input.wpcf7-submit').click(function() {
			if( $('span.ajax-loader').hasClass('is-active') ) {
				$(this).prop( "disabled",true );
			}
		});

		// When cf7 submit enable button again.
		document.addEventListener('wpcf7submit',function(event){
			$('form.wpcf7-form input.wpcf7-submit').prop('disabled', false );
		}, false);
	}

     // Enable button & reset file counter
    function dndmfu_cf7_reset_progress() {
        // reset counter to 0
        $('.dnd-upload-counter span').text('0');

        // Make sure to enable submit button.
        $('form.wpcf7-form input.wpcf7-submit').prop('disabled', false );
    }

    //@description : sample event
    document.addEventListener('dndmfu_cf7_success', function(event){
        //var eventDetails = event.detail[0];
    });

});