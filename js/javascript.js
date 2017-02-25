$(function(){
	$(".navbar-toggle").on('click', function () {
		$("body").toggleClass('noscroll');
	});

	$(window).resize(function(){
		resizeAsideNav();
	});

	resizeAsideNav();
});

$(document).ready(function () {
	resizeAsideNav();
});

function resizeAsideNav() {
	$(".nav-pills").width($("#floater").width());
}
