var changed, saving;

$(function () {
	console.log("openingTime JS loading");
	changed = [];
	saving = false;
});

function editManual(d) {
	if (d === 0) return;
	var manuModal	= $("#modalManual"),
		selector	= $('#' + d);
	manuModal.find("#modalTitle").html("Eingabe für " + selector.data("day"));
	manuModal.find("#btnDiscardManual").attr("onclick", "discardManual('" + d + "'); return false;");
	manuModal.find("#btnSaveManual").attr("onclick", "saveManual('" + d + "'); return false;");
	manuModal.find("#inpManual").val(selector.data("value"));
	manuModal.modal("show");
}
function saveManual(d) {
	if (d === 0) return;

	var manuModal	= $("#modalManual"),
		selector	= $('#' + d),
		data		= manuModal.find("#inpManual").val();

	data = data.replace(/[<>"']*/g, '');

	manuModal.modal('hide');

	if (selector.data("value") == data) {
		revokeChange(d);
		return;
	}
	if ($.trim(selector.data("value")).length > 0 && selector.data("value") == data) return;
	if (selector.data("value") !== data) selector.addClass("changed");

	selector.data("value", data);

	pushChange(d);

	if ($.trim(selector.data("value")).length > 0)
		selector.addClass("occupied");
	else selector.removeClass("occupied");
}
function discardManual(d) {
	if (d === 0) return;
	var manuModal	= $("#modalManual"),
		selector = $('#' + d);
	if ($.trim(selector.data("value")).length > 0) pushChange(d);
	selector.data("value", "");

	selector.addClass("changed");
	selector.removeClass("occupied");

	manuModal.modal('hide');
}
function hiddenDay(d) {
	if (d === 0) return;

	var selector = $('#' + d),
		hidden = selector.data("value") == "1" ? "0" : "1";
	selector.data("value", hidden);

	if (selector.data("value") == selector.data("init")) {
		revokeChange(d);
		selector.removeClass("changed");
	} else {
		pushChange(d);
		selector.addClass("changed");
	}

	if (selector.data("value") == "0") {
		selector.find("span.glyphicon").removeClass("glyphicon-eye-open").addClass("glyphicon-eye-close");
		selector.removeClass("occupied");
	}
	else {
		selector.find("span.glyphicon").removeClass("glyphicon-eye-close").addClass("glyphicon-eye-open");
		selector.addClass("occupied");
	}
}
function editTime(d) {
	if (d === 0) return;
	var timeModal	= $("#modalTime"),
		selector	= $('#' + d);
	timeModal.find("#modalTitle").html("Geöffnet am " + selector.data("day"));
	timeModal.find("#inpHour").val(selector.html().split(":")[0].replace(/\s/g,''));
	timeModal.find("#inpMin").val(selector.html().split(":")[1].replace(/\s/g,''));
	timeModal.find("#inpHour").parent().removeClass("has-error");
	timeModal.find("#inpMin").parent().removeClass("has-error");
	timeModal.find("#btnSaveTime").attr("onclick", "saveTime('" + d + "'); return false;");
	timeModal.modal("show");
}
function saveTime(d) {
	if (d === 0) return;

	var timeModal	= $("#modalTime"),
		selector	= $('#' + d),
		hour		= timeModal.find("#inpHour").val(),
		min			= timeModal.find("#inpMin").val(),
		combi		= (hour + ":" + min).replace(/[<>"'\\?]*/g, '');

	if (!validateInput()) return;

	timeModal.modal('hide');
	selector.html(combi);

	if (combi !== selector.data("before")) {
		pushChange(d);
		selector.addClass("changed");
	} else {
		revokeChange(d);
		selector.removeClass("changed");
	}

	var slice = d.slice(0, -1),
		both = $('#' + slice + '1, #' + slice + '2');

	if ($('#' + slice + '1').html() === $('#' + slice + '2').html())
		both.addClass("closed");
	else
		both.removeClass("closed");
}
function setZero(dn1, dn2) {
	var selectors = $('#' + dn1 + ', #' + dn2);
	selectors.html("0:00");
	selectors.addClass("changed");
	selectors.addClass("closed");
	pushChange(dn1);
	pushChange(dn2);
}
function submitChanges() {
	if (saving) return;
	saving = true;

	console.log("Submitting...");

	var times = {};
	$.each(changed, function (i, v) {
		var sel = $('#' + v);
		if (sel.has("span").length)
			times[v] = sel.data("value");
		else times[v] = sel.html();
	});

	if ($.isEmptyObject(times)) {
		resetEverything();
		setMessage("Keine Änderungen vorgenommen.");
		return;
	}

	var json = JSON.stringify(times, null);
	json = json.replace(/[<>'\\?]*/g, '');
	console.log("starting ajax post");
	console.log(json);
	$.ajax({
		url: "/handler/openingTimes.handler.php",
		contentType: "application/json; charset=utf-8",
		type: "POST",
		data: json,
		dataType: "json",
		success: function (data) {
			console.log(data);
			submitSuccessHandler(data);
			saving = false;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			if (xhr.status === 200)
				console.log(ajaxOptions);
			else {
				console.log(xhr.status);
				console.log(thrownError);
			}
			saving = false;
		}
	});
	console.log("ajax passed");
}
function submitSuccessHandler(data) {
	if ("error" in data) {
		setMessage(data["error"]);
		return;
	}
	if ("success" in data) {
		resetEverything();
		setMessage(data["success"]);
		return;
	}
	setMessage("Ein undokumentierter Fehler ist aufgetreten.");
}
function resetEverything() {
	$("td a.changed").each(function () {
		$(this).removeClass("changed");
		var before = $(this).html();
		$(this).data("before", before);
	});
	$(".hide-data").each(function () {
		$(this).data("init", $(this).data("value"));
	});
	changed = [];
	saving = false;
}
function setMessage(msg) {
	var status = $("#status");
	status.html("<span>" + msg + "</span>");
}
function pushChange(d) {
	if ($.inArray(d, changed) >= 0) return;
	changed.push(d);
}
function revokeChange(d) {
	var found = $.inArray(d, changed);
	if (found >= 0) changed.splice(found, 1);
}
function validateInput() {
	var timeModal	= $("#modalTime"),
		hour		= timeModal.find("#inpHour").val(),
		min			= timeModal.find("#inpMin").val(),
		valid		= true;

	if (!$.isNumeric(hour) || !hour.length > 0 || hour < 0 || hour > 24) {
		timeModal.find("#inpHour").parent().addClass("has-error");
		valid = false;
	} else timeModal.find("#inpHour").parent().removeClass("has-error");

	if (!$.isNumeric(min) || min.length !== 2 || min < 0 || min > 60) {
		timeModal.find("#inpMin").parent().addClass("has-error");
		valid = false;
	} else timeModal.find("#inpMin").parent().removeClass("has-error");

	return valid;
}

$('input#inpManual').on('keypress', function (e) {
	var reg = new RegExp(/^[<>"'\\?]*$/g),
		key = String.fromCharCode(!e.charCode ? e.which : e.charCode);
	if (reg.test(key)) {
		e.preventDefault();
		return false;
	}
});

$(function () {
	console.log("openingTimes JS executed");
});
