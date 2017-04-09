function validateInput() {
	if (!$("#inp_username").val() || !$("#inp_password").val())
		return false;
	return true;
}

$(document).ready(function() {
	var options = {
		detectScreenOrientation: false,
		excludeJsFonts: true,
		excludeScreenResolution: true,
		excludeAvailableScreenResolution: true
	};
	var id = $('input#auto_login'),
		af = $('form#auto-login');
	new Fingerprint2(options).get(function(result) {
		$('input#string_fp').attr('value', result);
		if (id.length) { af.submit(); }
	});
});