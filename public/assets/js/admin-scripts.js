/**
* Remove an Image Thumbnail
*/
$('.remove-thumb').on('click', function(e){
	e.preventDefault();
	var thumb = $(this).parents('.image-thumb');
	var input = $(thumb).siblings('.image-file');
	$(thumb).hide();
	$(input).show();
});