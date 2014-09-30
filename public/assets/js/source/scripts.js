/**
* Page Preloader
*/
$(window).on('load', function(){
	
	$('.page').removeClass('loading');
	$('.preloader').remove();

	/**
	* Joy Meter
	*/
	$('.home-callouts').waypoint(function(direction){
		if ( direction === 'down' ){
			$('.joy-meter').addClass('active');
		}
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
	
});

$(document).ready(function(){
	$('.container').fitVids();
	$(window).stellar({ horizontalScrolling: false });
});


/**
* Parallax
*/
$(window).bind('scroll',function(e){
	if ( !$('html').hasClass('touch') ){
		parallaxScroll();
	}
});
function parallaxScroll(){
	var scrolled = $(window).scrollTop();

	// Headline
	$('.home-headline').css('top', (0-(scrolled*.35))+'px');
	
	// Cans
	$('.home-green-can').css('top', (100-(scrolled*.35))+'px');
	$('.home-green-can').css('WebkitTransform', 'rotate(' + (0+(scrolled*.03))+'deg') + ')';
	$('.home-green-can').css('-moz-transform', 'rotate(' + (0+(scrolled*.03))+'deg') + ')';

	$('.home-red-can').css('bottom', (-30-(scrolled*.35))+'px');

	// Big Bubbles
	$('.right-bubbles').css('right', (0-(scrolled*.55))+'px');
	$('.left-bubbles').css('left', (0-(scrolled*.55))+'px');
	
	// Bubbles
	$('.bubbles.one').css('top', (0-(scrolled*.85))+'px');
	$('.bubbles.one').css('left', (0-(scrolled*.05))+'px');
	$('.bubbles.one .bubble').css('WebkitTransform', 'rotate(' + (0-(scrolled*.55))+'deg') + ')';
	$('.bubbles.one .bubble').css('-moz-transform', 'rotate(' + (0-(scrolled*.55))+'deg') + ')';
	
	$('.bubbles.two').css('top', (0-(scrolled*.150))+'px');
	$('.bubbles.two').css('right', (0-(scrolled*.05))+'px');
	$('.bubbles.two .bubble').css('WebkitTransform', 'rotate(' + (0+(scrolled*.35))+'deg') + ')';
	$('.bubbles.two .bubble').css('-moz-transform', 'rotate(' + (0+(scrolled*.35))+'deg') + ')';

	$('.bubbles.three').css('top', (0-(scrolled*.50))+'px');
	$('.bubbles.three .bubble').css('WebkitTransform', 'rotate(' + (0-(scrolled*.35))+'deg') + ')';
	$('.bubbles.three .bubble').css('-moz-transform', 'rotate(' + (0-(scrolled*.35))+'deg') + ')';
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