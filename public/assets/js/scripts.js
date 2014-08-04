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
* Parallax
*/
$(window).bind('scroll',function(e){
	parallaxScroll();
});
function parallaxScroll(){
	var scrolled = $(window).scrollTop();
	$('.home-green-can').css('top', (120-(scrolled*.35))+'px');
	$('.home-red-can').css('bottom', (-60-(scrolled*.35))+'px');
}
function scrollGreenCan()
{

}

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