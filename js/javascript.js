$(function(){
	$(".navbar-toggle").on('click', function () {
		$("body").toggleClass('noscroll');
	});

	$(".nav.nav-pills a").on('click', function () {
		$("#floater").removeClass("visible");
	});
});
