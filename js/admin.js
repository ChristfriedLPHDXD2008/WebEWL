function toogleAsideNav() {
	$("aside").toggleClass("opened");
}

$(function () { $('[data-toggle="tooltip"]').tooltip() });

/*
$(document).ready(function () {
	var pathname =  window.location.pathname;
	$("nav").find('a[href="' + decodeURIComponent(pathname) + '"]').parent().addClass("active");
});
*/