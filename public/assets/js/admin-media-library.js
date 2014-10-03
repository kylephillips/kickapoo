/**
* ========================================================================
* Media Library
* ========================================================================
*/

/**
* Remove an Image Thumbnail and replace with media library button
*/
$('.remove-thumb').on('click', function(e){
	e.preventDefault();
	var thumb = $(this).parents('.image-thumb');
	$(thumb).siblings('.image-name').hide();
	var input = $(thumb).parent('.image-preview').siblings('.open-media-library');
	$(thumb).hide();
	$(input).show();
});

/**
* Open the library window
*/
$(document).on('click', '.open-media-library', function(e){
	e.preventDefault();
	var folder = $(this).data('folder');
	var field = $(this).data('field');
	save_selected_image_field(field);
	open_media_library(folder, false);
});


/**
* Hidden field holds the correct field to populate once an image has been selected
* @param field string - class of field
*/
function save_selected_image_field(field)
{
	$('#field-selected').val(field);
}


/**
* Open the modal window & display the correct directory
* @param directory string
* @param editor boolean
*/
function open_media_library(directory, editor)
{
	$('#media-library').modal('show');
	get_media_library_data(directory);
	if ( editor ) $('#media-library').addClass('is-editor');
}


/**
* Get data for populating media library
* @param directory string
*/
function get_media_library_data(directory)
{
	$('#media-library .modal-body').empty().addClass('loading');
	$.ajax({
		url: urls.media_library_route,
		type: 'GET',
		data: {
			directory : directory
		},
		success: function(data){
			console.log(data);
			populate_library(data.media);
			populate_library_menu(data.folders, directory);
		}
	});
}


/**
* Populate the media library
* @param items object (returned from AJAX response)
*/
function populate_library(items)
{
	var out = '<ul class="media-library-list">';
	$.each(items, function(key, item){
		if ( key % 4 === 0 ){
			out += '<li class="first">';
		} else {
			out += '<li>';
		}
		out += '<div><a href="#" class="media-library-item" data-name="' + item.file + '" data-id="' + item.id + '" data-folder="' + item.folder + '" data-title="' + item.title + '" data-alt="' + item.alt + '" data-caption="' + item.caption + '">';
		out += '<img src="' + urls.site_index + item.folder + '_thumbs-large/' + item.file + '">';
		out += '</a></div></li>';
	});
	out += '</ul>';
	$('#media-library .modal-body').removeClass('loading').html(out);
}


/**
* Populate the Media Library Select Menu
* @param folder object
* @param current_dir string
*/
function populate_library_menu(folders, current_dir)
{
	if ( folders ){
		var out = '';
		$.each(folders, function(key, value){
			out += '<option value="' + value.name + '"';
			if ( value.name === current_dir ) out += ' selected ';
			out += '>' + value.name + '</option>';
		});
		$('#ml-folders').html(out);
	} else {
		no_media_uploads();
	}
}


/**
* Display No uploads yet message
*/
function no_media_uploads()
{
	$('#ml-folders').html('<option value="">--No Uploads Yet--</option>');
	var out = '<div class="alert alert-info">There are no uploads yet.</div>';
	$('#media-library .modal-body').html(out);
}


/**
* Select image on click
*/
$(document).on('click', '.media-library-item', function(e){
	e.preventDefault();
	var image = {
		id : $(this).attr('data-id'),
		file : $(this).attr('data-name'),
		folder : $(this).attr('data-folder'),
		title : $(this).attr('data-title'),
		alt : $(this).attr('data-alt'),
		caption : $(this).attr('data-caption')
	};
	var item = $(this);
	if ( $(item).hasClass('selected') ){
		$('.choose-media').prop('disabled', 'disabled');
		remove_selected_image();
	} else {
		select_media_image(image, item);
		set_image_fields(image);
	}
});


/**
* Populate various required fields when selecting an image
* @param image object
* @param item DOM object
*/
function select_media_image(image, item)
{
	$('.ml-image-info-selected').hide();
	$('#ml-image-details-saved').text('').hide();

	if ( !$('#media-library').hasClass('is-editor') ){
		var selected_field = '#' + $('#field-selected').val();
		$(selected_field).val(image.id);

		$(selected_field).removeAttr('data-name');
		$(selected_field).attr('data-name', image.file);
		$(selected_field).removeAttr('data-folder');
		$(selected_field).attr('data-folder', image.folder)
	}
	
	$('.ml-chosen-image').text(image.file);

	$('.media-library-item').removeClass('selected');
	if ( item  ){
		$(item).addClass('selected');
	}

	update_editor_data_attributes(image);
	$('.choose-media').prop('disabled', '');
}

/**
* Update the data attributes for inserting editor images
* @param image object
*/
function update_editor_data_attributes(image)
{
	$('#media-library').removeAttr('data-editor');
	var selected_alt = $('.selected').attr('data-alt');
	var image_src = '<img src="' + image.folder + image.file + '" alt="' + selected_alt + '" >';
	$('#media-library').attr('data-editor', image_src);
}


/**
* Set the image details fields
*/
function set_image_fields(image)
{
	if ( image.alt !== 'null' ){
		$('#ml-image-alt').val(image.alt);
	} else {
		$('#ml-image-alt').val('');
	}
	$('#ml-image-id').val(image.id);
	if ( image.caption !== 'null' ){
		$('#ml-image-caption').val(image.caption);
	} else {
		$('#ml-image-caption').val('');
	}
	$('#ml-image-title').text(image.title);
	$('.ml-image-info-default').hide();
	$('.ml-image-info-selected').show();
}

/**
* Update Image Details
*/
$(document).on('click', '#update-image-details', function(e){
	e.preventDefault();
	update_image_details();
});
function update_image_details()
{
	$('.update-image-loading').show();
	$('#ml-image-details-saved').text('').hide();

	var id = $('#ml-image-id').val();
	var alt = $('#ml-image-alt').val();
	var caption = $('#ml-image-caption').val();
	var item = $('.media-library-item[data-id="' + id + '"]');

	$.ajax({
		url : urls.update_image_details,
		type : 'POST',
		data : {
			id : id,
			alt : alt,
			caption : caption
		},
		success : function(data){
			if ( data.status === 'success' ){
				console.log(data);
				$('.update-image-loading').hide();
				$('#ml-image-details-saved').text('Image Successfully Updated').show();
				$(item).attr('data-alt', alt);
				$(item).attr('data-caption', caption);
				update_editor_data_attributes(data.image);
			} else {
				$('.update-image-loading').hide();
				$('#ml-image-details-saved').text('There was an error saving the image information.').show();
			}
		}
	});
}


/**
* Insert the selected image into the editor
*/
function insert_editor_image()
{
	var selected = $('#media-library').attr('data-editor');
	ActiveEditor.image_html = selected;
	ActiveEditor.insert();
	console.log(ActiveEditor);
}

/**
* Update the image preview
*/
$(document).on('click', '.choose-media', function(e){
	update_image_preview();
	e.preventDefault();
});
function update_image_preview()
{
	if ( !$('#media-library').hasClass('is-editor') ){
		var selected_field = '#' + $('#field-selected').val();
		var selected_field_cont = $(selected_field).parent('div');

		var folder = $(selected_field).attr('data-folder');
		var file = $(selected_field).attr('data-name');

		var html = '<div class="image-preview">';
		html += '<div class="image-thumb"><button class="remove-ml-thumb">&times;</button>';
		html += '<img src="' + folder + '/_thumbs/' + file + '" /></div>';
		html += '<p class="image-name">' + file + '</p></div>';

		$(selected_field_cont).find('.open-media-library').hide();
		$(selected_field_cont).append(html);

		$('#media-library').modal('hide');
	} else {
		insert_editor_image();
		$('#media-library').modal('hide');
		$('#media-library').removeAttr('data-editor');
	}
}


/**
* Remove a selected image from a field
*/
$(document).on('click', '.remove-ml-thumb, .cancel-media, .open-media-library', function(e){
	e.preventDefault();
	remove_selected_image();
});
function remove_selected_image()
{
	$('#media-library').removeClass('is-editor');
	var selected_field = '#' + $('#field-selected').val();
	var selected_field_cont = $(selected_field).parent('div');
	$(selected_field_cont).find('.image-preview').remove();
	$(selected_field_cont).find('.open-media-library').show();
	$(selected_field_cont).find('input').val('');
	$('.media-library-item').removeClass('selected');
	$('.ml-chosen-image').text('Choose Your Image');

	$('.ml-image-info-default').show();
	$('.ml-image-info-selected').hide();
	$('#ml-image-details-saved').text('').hide();
}


/**
* Update the list based on directory selected
*/
$(document).on('change', '#ml-folders', function(){
	var directory = $(this).val();
	$('.choose-media').prop('disabled', 'disabled');
	$('#media-selected').val('');
	$('#media-selected-folder').val('');
	get_media_library_data(directory);
});


/**
* Toggle the tabs
*/
$(document).on('click', '.media-library-tabs a', function(e){
	e.preventDefault();
	// Disable the Use selected button
	$('.choose-media').prop('disabled', 'disabled');

	// Show the correct panel
	var target = $(this).attr('href');
	$('.modal-body-panel').hide();
	$(target).show();
	
	// Toggle Tabs
	$('.media-library-tabs a').removeClass('active');
	$(this).addClass('active');	

	// Remove any currently selected images
	remove_selected_image();
	$('.media-library-item').removeClass('selected');

	// Select the correct upload directory & reload images
	if ( target === '#media-existing' ){
		var directory = $('#dz-folder').val();
		$('#ml-folders').val(directory);
		get_media_library_data(directory);
	} else {
		var directory = $('#ml-folders').val();
		$('#dz-folder').val(directory);
		$('.dz-message').show();
	}


});
/**
* Dropzone config
*/
Dropzone.options.dropzoneForm = {
	addRemoveLinks: false,
	maxFiles: 20,
	previewTemplate: '<div class="dz-preview"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-image-preview"><img src="/assets/images/dz-loading-placeholder.png"></div></div>',
	uploadMultiple: false,
    thumbnailWidth: 100,
    thumbnailHeight: 100,
    autoProcessQueue: true,
    dictDefaultMessage: '<div class="dz-interior"><p><strong>Drop files to upload</strong><em>or</em><span>Select File</span></p></div>',
    init: function(){
    	addform = this;
    	this.on('success', function(file, response){
			if ( response.status === "error" ){
				// Error
			} else {
				$('.dz-message').hide();
				var element = file.previewElement;
				var html = '<a href="#" class="media-library-item" data-name="' + response.file + '" data-id="' + response.upload_id + '" data-folder="' + response.folder + '"><img src="' + urls.site_index + response.folder + '/_thumbs-large/' + response.file + '"></a>';
				$(element).find('.dz-image-preview').empty().html(html);
				console.log(response);
			}	
		});
		// Reset the dropzone form when switching tabs
		$('.media-library-tabs a').on('click', function(){
			addform.removeAllFiles();
		});
    }
};




