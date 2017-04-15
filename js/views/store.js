function toggleKonvention(src) {
	if (src.parent().parent().hasClass("shown")) {
		src.parent().parent().removeClass("shown");
		return;
	}
	if ($(".wl-konvention.shown").length > 0) {
		$(".wl-konvention.shown").removeClass("shown");
		setTimeout(function () {
			src.parent().parent().addClass("shown");
		}, 300);
	} else src.parent().parent().addClass("shown");
}

$(document).ready(function () {
	$(".wl-konvention a").on("click", function (e) {
		toggleKonvention($(this));
		e.preventDefault();
		e.stopPropagation();
	});
});