/**
* Page Preloader
*/
$(window).load(function(){
	$('.page').removeClass('loading');
	$('.preloader').remove();

	/**
	* Joy Meter
	*/
	$('.load-more').waypoint(function(direction){
		if ( direction === 'down' ){
			$('.joy-meter').addClass('active');
		}
	});
});

/**
* Mobile Navigation
*/
$('.nav-toggle').on('click', function(e){
	e.preventDefault();
	$('body').toggleClass('nav-open');
	$(this).toggleClass('active');
	$(this).find('i').toggleClass('icon-close').toggleClass('icon-menu');
});


/**
* Sticky Social Nav Style Change
*/
$('.header-bottom').waypoint(function(direction){
	if ( direction === 'down' ){
		$('.social-links').addClass('top');
	} else {
		$('.social-links').removeClass('top');
	}
});