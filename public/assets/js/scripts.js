/**
* Mobile Navigation
*/
$('.nav-toggle').on('click', function(e){
	e.preventDefault();
	$('body').toggleClass('nav-open');
	$(this).toggleClass('active');
	$(this).find('i').toggleClass('icon-close').toggleClass('icon-menu');
});

$('.header-bottom').waypoint(function(direction){
	if ( direction === 'down' ){
		$('.social-links').addClass('top');
	} else {
		$('.social-links').removeClass('top');
	}
});