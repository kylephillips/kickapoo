/**
* Remove an Image Thumbnail
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
* Apply Redactor to Textareas with appropriate class
*/
function apply_redactor(item)
{
	$(item).redactor({
		imageUpload : urls.editor_upload,
		buttonSource: true,
		toolbarFixed: true,
		toolbarFixedTopOffset: 42,
		plugins: ['medialibrary'],
		buttons: ['html', 'formatting', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist', 'outdent', 'indent', 'link', 'alignment', 'horizontalrule'],
		imageUploadCallback: function(image, json){
			console.log(json);
		},
		imageUploadErrorCallback: function(json){
			console.log(json.error);
		}
	});
}

/**
* Redactor Media Library Plugin
*/
if (!RedactorPlugins) var RedactorPlugins = {};
RedactorPlugins.medialibrary = function()
{
	return {
		image_html: 'TEST',
		init: function ()
		{
			var button = this.button.add('media-library', 'Media Library');
			this.button.addCallback(button, this.medialibrary.testButton);
		},
		testButton: function(buttonName)
		{
			ActiveEditor = this.medialibrary;
			open_media_library('page_images', true);
			//this.medialibrary.image_html = 'TESTING IMAGE';
			//this.medialibrary.insert();
		},
		insert: function()
		{
			this.insert.html(this.medialibrary.image_html);
			this.code.sync();
		}
	};
};

var ActiveEditor = {};


/**
* ========================================================================
* Edit/Create Page Specific Functionality
* ========================================================================
*/

/**
* Update the slug based on input
*/
function update_slug()
{
	var slug = $('#slug').val();
	$('.slug em').text(slug);
	$('.slug-seo').text(slug);
}
/**
* Page Slug Switch Edit
*/
$('#slug').on('keyup', function(){
	update_slug();
});
$('.slug p').on('click', function(){
	$('.slug').find('em').hide();
	$('.slug').find('.hidden').show();
});
$('.slug-ok').on('click', function(e){
	$('.slug').find('.hidden').hide();
	$('.slug em').show();
	e.preventDefault();
});

/**
* Toggle custom field rows on edit page view
*/
$('.customfield-existing h4').on('click', function(){
	var item = $(this).parent('li').children('section');
	var caret = $(this).find('i');
	if ( $(item).is(':visible') ){
		$(item).slideUp();
		$(caret).removeClass('icon-caret-up').addClass('icon-caret-down');
	} else {
		$(item).slideDown();
		$(caret).removeClass('icon-caret-down').addClass('icon-caret-up');
	}
});

function custom_field_type(type, item, count)
{
	switch (type){
		case 'text' :
		html = '<input type="text" name="newcustomfield[' + count + '][fieldvalue]" />';
		break;

		case 'textarea' :
		html = '<textarea name="newcustomfield[' + count + '][fieldvalue]"></textarea>';
		break;

		case 'editor' :
		html = '<textarea class="redactor" name="newcustomfield[' + count + '][fieldvalue]"></textarea>';
		break;

		case 'image' :
		html = '<div>';
		html += '<a href="#" class="btn btn-success open-media-library" data-folder="page_images" data-field="customfield_image_' + count + '"><i class="icon-image"></i> Add from Media Library</a>';
		html += '<input type="hidden" id="customfield_image_' + count + '" name="newcustomfield[' + count + '][fieldvalue]">';
		html += '</div>';
		break;
	}
	$(item).find('.newfieldcont').html(html);
	if ( type === 'editor' ){
		apply_redactor($(item).find('textarea'));
	}
}

/**
* Cancel Adding a Custom Field & Remove the row
*/
$(document).on('click', '.cancel-new-field', function(e){
	e.preventDefault();
	var item = $(this).parents('.newfield');
	$(item).fadeOut('slow', function(){
		$(item).remove();
	});
});

/**
* Change the new custom field type
*/
$(document).on('change', '.fieldtype', function(){
	var type = $(this).val();
	var item = $(this).parents('.newfield');
	var count = $(item).find('.field_count').text();
	$(item).find('.fieldvalue').val('');
	$('#newfieldcont').empty();
	custom_field_type(type, item, count);
});

/**
* Calculate the # of characters left for the seo description
*/
function seo_characters_remaining(count)
{
	var remaining = 160 - count;
	var info = $('#description_count');

	$('#description_count span').text(remaining);
	if ( remaining < 0 ){
		var over = 'true';
		truncate_seo_description(over);
		$(info).addClass('alert-danger');
	} else {
		truncate_seo_description();
		$(info).removeClass('alert-danger');
	}
}

function truncate_seo_description(over)
{
	var text = $('#seo_description').val();
	truncated = text.substring(0, 160);
	if (over === 'true'){ truncated = truncated + '...'; }
	$('.seo-description').text(truncated);
}
$('#seo_description').on('keyup', function(){
	var count = $(this).val().length;
	seo_characters_remaining(count);
});

$('#seo_title').on('keyup', function(){
	var title = $(this).val();
	$('.seo-title').text(title);
});
