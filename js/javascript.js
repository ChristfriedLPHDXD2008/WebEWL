$(function(){
	$(".navbar-toggle").on('click', function () {
		$("body").toggleClass('noscroll');
	});

	$(window).resize(function(){
		resizeAsideNav();
	});

	resizeAsideNav();
});

function resizeAsideNav() {
	$(".nav-pills").width($("#floater").width());
}
