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
	
	// Cans
	$('.home-green-can').css('top', (100-(scrolled*.35))+'px');
	$('.home-red-can').css('bottom', (-30-(scrolled*.35))+'px');
	
	// Bubbles
	$('.bubbles.one').css('top', (0-(scrolled*.85))+'px');
	$('.bubbles.one').css('left', (0-(scrolled*.05))+'px');
	
	$('.bubbles.two').css('top', (0-(scrolled*.150))+'px');
	$('.bubbles.two').css('right', (0-(scrolled*.05))+'px');

	$('.bubbles.three').css('top', (0-(scrolled*.50))+'px');
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