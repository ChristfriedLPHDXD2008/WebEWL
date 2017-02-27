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
	});	$('.img-popup-anim-trigger').magnificPopup({
		type: 'image',
		closeOnContentClick: true,
		mainClass: 'mfp-with-zoom', // this class is for CSS animation below
		zoom: {
			enabled: true, // By default it's false, so don't forget to enable it
			duration: 300, // duration of the effect, in milliseconds
			easing: 'ease-out', // CSS transition easing function
			opener: function(openerElement) {
				return openerElement.is('img') ? openerElement : openerElement.find('img');
			}
		},
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