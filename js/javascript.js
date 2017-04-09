var lastId,
	menuItems,
	scrollItems,
	update = true;

$(function () {
	console.log("javascript loading");
	menuItems = $("#right-nav").find("li a");
	scrollItems = menuItems.map(function(){
		var item = $($(this).attr("href"));
		if (item.length) { return item; }
	});
});

$(window).scroll(function() {
	if (update === false) return;
	//noinspection JSValidateTypes
	var fromTop = $(window).scrollTop() + 250,
		cur = scrollItems.map(function () {
			if ($(this).offset().top < fromTop)
				return this;
		});

	if (cur.length === 0) cur = scrollItems[0];
	else cur = cur[cur.length - 1];
	var id = cur && cur.length ? cur[0].id : "";

	if (lastId === id) return;
	lastId = id;
	// Set/remove active class
	menuItems
		.parent().removeClass("active")
		.end().filter("[href='#" + id + "']").parent().addClass("active");
});

function ScrollToElement(element) {
	update = false;
	//noinspection JSValidateTypes
	var time = 0,
		topOffset = element.offset().top - 80,
		scrollTop = $(window).scrollTop();

	if (topOffset > scrollTop) time = topOffset - scrollTop;
	else time = scrollTop - topOffset;

	$('html').animate({ scrollTop: topOffset }, time, function () {
		update = true;
		$(window).scroll();
	});
}

$(function (){
	$(".navbar-toggle").on("click", function () {
		var html = $("html"),
			n = html.css("overflow-y");
		if (n === 'hidden') html.css("overflow-y", "scroll");
		else html.css("overflow-y", "hidden");
	});

	$(".nav.nav-pills a").on("click", function () {
		$("#floater").removeClass("visible");
	});

	$("#right-nav").find("li a").click(function (e) {
		if ($("#navbar-collapse.collapse").hasClass("in"))
			$(".navbar-toggle").click();
		ScrollToElement($($(this).attr("href")));
		e.preventDefault();
	});

	$(window).scroll();

	console.log("javascript loaded");
});