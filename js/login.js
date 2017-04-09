function validateInput() {
	if (!$("#inp_username").val() || !$("#inp_password").val())
		return false;
	return true;
}