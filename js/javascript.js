$(function(){
	$(".navbar-toggle").on('click', function () {
		$("body").toggleClass('noscroll');
	});

	$(".nav.nav-pills a").on('click', function () {
		$("#floater").removeClass("visible");
	});

	$(window).resize(function(){
		resizeAsideNav();
	});

	resizeAsideNav();
});

function resizeAsideNav() {
	var floater = $("#floater");
	$(".nav-pills").width(floater.width());
	floater.addClass("visible");
}
