$(document).ready(function () {
	$('.img-popup-trigger').magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		zoom: {
			enabled: true,
			duration: 300,
			easing: 'ease-out',
			opener: function(openerElement) {
				return openerElement.is('img') ? openerElement : openerElement.find('img');
			}
		},
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