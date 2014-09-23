/**
* ========================================================================
* Media Library
* ========================================================================
*/

/**
* Open the library window
*/
$(document).on('click', '.open-media-library', function(e){
	e.preventDefault();
	var folder = $(this).data('folder');
	var field = $(this).data('field');
	save_selected_image_field(field);
	open_media_library(folder);
});

/*
* Hidden field holds the correct field to populate once an image has been selected
*/
function save_selected_image_field(field)
{
	$('#field-selected').val(field);
}

function open_media_library(directory)
{
	$('#media-library').modal('show');
	get_media_library_data(directory);
}


/**
* Get data for populating media library
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
		out += '<div><a href="#" class="media-library-item" data-name="' + item.file + '" data-id="' + item.id + '" data-folder="' + item.folder + '">';
		out += '<img src="' + urls.site_index + item.folder + '_thumbs-large/' + item.file + '">';
		out += '<span>' + item.title + '</span>';
		out += '</a></div></li>';
	});
	out += '</ul>';
	$('#media-library .modal-body').removeClass('loading').html(out);
}


/**
* Populate the Media Library Select Menu
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
* No uploads yet
*/
function no_media_uploads()
{
	$('#ml-folders').html('<option value="">--No Uploads Yet--</option>');
	var out = '<div class="alert alert-info">There are no uploads yet.</div>';
	$('#media-library .modal-body').html(out);
}

/**
* Select an image and populate the custom field
*/
$(document).on('click', '.media-library-item', function(e){
	e.preventDefault();
	var id = $(this).data('id');
	var name = $(this).data('name');
	var folder = $(this).data('folder');
	var item = $(this);
	select_media_image(id, name, folder, item);
});
function select_media_image(id, name, folder, item)
{
	// Set the hidden fields
	var selected_field = '#' + $('#field-selected').val();
	$(selected_field).val(id);

	$(selected_field).removeAttr('data-name');
	$(selected_field).attr('data-name', name);
	$(selected_field).removeAttr('data-folder');
	$(selected_field).attr('data-folder', folder)

	$('.media-library-item').removeClass('selected');
	if ( item  ){
		$(item).addClass('selected');
	}
	$('.choose-media').prop('disabled', '');
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
}


/**
* Remove a selected image from a field
*/
$(document).on('click', '.remove-ml-thumb, .cancel-media', function(e){
	e.preventDefault();
	remove_selected_image();
});
function remove_selected_image()
{
	var selected_field = '#' + $('#field-selected').val();
	var selected_field_cont = $(selected_field).parent('div');
	$(selected_field_cont).find('.image-preview').remove();
	$(selected_field_cont).find('.open-media-library').show();
	$(selected_field_cont).find('input').val('');
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
	$('.choose-media').prop('disabled', 'disabled');
	var target = $(this).attr('href');
	$('.modal-body-panel').hide();
	$(target).show();
	$('.media-library-tabs a').removeClass('active');

	// Remove any currently selected images
	remove_selected_image();
	$('.media-library-item').removeClass('selected');

	$(this).addClass('active');
});

/**
* Dropzone config
*/
Dropzone.options.dropzoneForm = {
	addRemoveLinks: true,
	maxFiles: 1,
	uploadMultiple: false,
    thumbnailWidth: 360,
    thumbnailHeight: 240,
    dictDefaultMessage: '<div class="dz-interior"><p><i class="icon-box-add"></i> <strong>Drag Image Here</strong><span>Select File</span></p></div>',
    init: function(){
    	addform = this;
    	this.on('success', function(file, response){
			if ( response.status === "error" ){
			} else {
				$('.dz-message').hide();
				select_media_image(response.file.id, response.file.title, response.file.folder);
				console.log(response);
			}	
		});
    }
}




