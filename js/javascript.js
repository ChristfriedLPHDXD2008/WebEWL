$(function(){
	$(".navbar-toggle").on('click', function () {
		$("body").toggleClass('noscroll');
	});

	$(window).resize(function(){
		resizeAsideNav();
	});

	resizeAsideNav();
});

$(window).load(function () {
	resizeAsideNav();
});

function resizeAsideNav() {
	$(".nav-pills").width($("#floater").width());
}
