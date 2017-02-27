$(document).ready(function () {
	$('.img-popup-trigger').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		callbacks: {
			open: function() {
				$('html').css({
					marginRight: 0,
					paddingRight: 0,
					overflow: "auto"
				});
			}
		}
	});
});