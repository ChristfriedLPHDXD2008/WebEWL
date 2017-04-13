function toggleKonvention(src) {
	if (src.parent().parent().hasClass("shown")) {
		src.parent().parent().removeClass("shown");
		return;
	}
	$(".wl-konvention.shown").removeClass("shown");
	src.parent().parent().toggleClass("shown");
}

$(document).ready(function () {
	$(".wl-konvention a").on("click", function (e) {
		toggleKonvention($(this));
		e.preventDefault();
		e.stopPropagation();
	});
});